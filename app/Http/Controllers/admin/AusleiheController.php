<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AusleiheRequest;
use Validator;

use Illuminate\Support\Facades\DB;

use App\User;
use App\Klasse;
use App\Buch;
use App\Jahrgang;
use App\Buecherliste;
use App\Buchwahl;
use App\BuchUser;
use App\Schuljahr;
use App\BuchHistorie;
use App\Ausleiher;
use App\Schueler;

use App\Rules\BuchtitelNichtAusgeliehen;
use App\Rules\BuchNichtAusgeliehen;
use App\Rules\BuchcodeExistiert;
use App\Rules\BuchtitelIstAufBuecherliste;
use App\Rules\BuchtitelIstBestellt;
use App\Rules\BuchNichtGeloescht;

class AusleiheController extends Controller
{
    /**
     * Zeigt alle Jahrgänge des aktiven Schuljahres mit den zugehörigen Klassen.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Jahrgänge des aktiven Schuljahres holen
        $jahrgaenge = Jahrgang::whereHas('schuljahr', function($query) {
                            $query->where('aktiv', '1'); 
                        })->get();

        return view('admin/ausleihe/index', compact('jahrgaenge'));
    }

    /**
     * Zeigt alle Schüler einer ausgewählten Klasse.
     *
     * @return \Illuminate\Http\Response
     */
    public function zeigeKlasse($klasse_id)
    {  
        $klasse = Klasse::findOrFail($klasse_id);

        $ausleiher = $klasse->schueler()
            ->orderBy('nachname', 'asc')
            ->orderBy('vorname',  'asc')
            ->get();

        $gruppen   = $ausleiher->split(3);    
        
        return view('admin/ausleihe/klasse', compact('klasse', 'ausleiher', 'gruppen'));
    }


    /**
     *  Zeige eine Liste der ausgeliehenen und eine Liste der bestellten Bücher. 
     */
    public function zeigeSchueler($klasse_id, $schueler_id)
    {   
        $schueler = Schueler::findOrFail($schueler_id);

        $next = $schueler->next();
        $prev = $schueler->prev();

        $buchtitel = $schueler->buecherliste();

        //dd($buchtitel);

        $buecher = $schueler->buecher;
       
        // Berechne Summe der Leihgebühren
        $summe = 0;
        foreach($buecher as $buch) {
            $btsj = $buch->buchtitel->buchtitelSchuljahr->first();

            $leihpreis = $btsj->leihpreis;
            if($leihpreis != null)
            {
                $buch['leihpreis'] = $leihpreis;
                $summe += $leihpreis;
            }
        }

        $summeErm = $summe;
        switch($schueler->erm_bestaetigt) {
            case 1: $summeErm *= 0.8; break;
            case 2: $summeErm  = 0  ; break;
        }

        return view('admin/ausleihe/schueler', 
            compact('schueler', 'buchtitel', 'buecher', 'next', 'prev', 'summe', 'summeErm'));
    }

    /**
     * Leihe ein Buch an einen Ausleiher aus.
     */
    public function ausleihen(Request $request, $klasse_id, $schueler_id)
    {
        $schueler = Schueler::find($schueler_id);
        $buch     = Buch::withTrashed()->find($request->buch_id);
      
        // Ausleihen nicht möglich, Abbruch mit Fehlermeldung...
        $validator1 = Validator::make(
            $request->all(), 
            [
                'buch_id' => [
                    'required',
                    //'exists: buecher, id',
                    new BuchcodeExistiert($buch),
                    new BuchNichtAusgeliehen($buch),
                ],
            ], [
                'buch_id.required' => 'Bitte einen Buch-Code eingeben.',
                //'buch_id.exists'   => 'Die angegebene Buch-ID existiert nicht.'
            ]
        );

        if($validator1->fails()) {
            return redirect('admin/ausleihe/'.$klasse_id.'/'.$schueler_id)
                ->withErrors($validator1->errors()->add('type', 'warning'))
                ->withInput();
        }

        // Ausleihen zwar möglich, es wird aber eine Bestätigung verlangt...
        $validator2 = Validator::make(
            $request->all(), 
            [
                'buch_id' => [
                    new BuchtitelNichtAusgeliehen($schueler, $buch),
                    new BuchtitelIstAufBuecherliste($schueler, $buch),
                    new BuchtitelIstBestellt($schueler, $buch),
                    new BuchNichtGeloescht($buch)                                 
                ],
            ] 
        );

        if($request->confirmed==null && $validator2->fails()) {
            return redirect('admin/ausleihe/'.$klasse_id.'/'.$schueler_id)
                ->withErrors($validator2->errors()->add('type', 'confirm'))
                ->withInput();
        } 

        if($buch->trashed()) $buch->restore();

        // Buch wird ausgeliehen
        //$buch->ausleiher()->save($schueler, ['ausleiher_ausgabe' => now()]);

        $buch->ausleiher_id       = $schueler->id;
        $buch->ausleiher_type     = "App\Schueler";
        $buch->ausleiher_ausgabe  = now();
        $buch->save();  
                
        //$ausleiher->buecher()->attach($buch, ['ausgabe' => now()]);

        return redirect('admin/ausleihe/'.$klasse_id.'/'.$schueler_id);
    }  

    /**
     * Nimm die Ausleihe eines Buches zurück  
     * (ohne einen Eintrag in die Buchhistorie zu machen)
     */
    public function loeschen(Request $request, $klasse_id, $schueler_id)
    {
        //$ausleiher = Ausleiher::find($ausleiher_id);
        $buch = Buch::find($request->buch_id);

        $buch->ausleiher_id      = null;
        $buch->ausleiher_type    = null;
        $buch->ausleiher_ausgabe = null;
        $buch->save();

        //$user->buecher()->detach($buch);
        
        return redirect('admin/ausleihe/'.$klasse_id.'/'.$schueler_id);
    }

    public function aktualisieren(Request $request, $klasse_id, $schueler_id)
    {
        $buchwahlen = $request->wahlen;
        
        foreach($buchwahlen as $buchtitel_id => $wahl) 
        {    
            $bw = Buchwahl::where('schueler_id', $schueler_id)
                          ->where('buchtitel_id', $buchtitel_id)
                          ->first();
            if($wahl!=4)
            {
                if($bw) {
                    $bw['wahl'] = $wahl;
                    $bw->save();
                } else {
                    $buchwahl = new Buchwahl;
                    $buchwahl->schueler_id  = $schueler_id;
                    $buchwahl->buchtitel_id = $buchtitel_id;
                    $buchwahl->wahl         = $wahl;
                    $buchwahl->save();
                }
            } else {
                 if($bw) $bw->delete();
            }
        }

        return redirect('admin/ausleihe/'.$klasse_id.'/'.$schueler_id);
    }

    /*
     * Holt Buchinformationen und zeigt sie an.
     */
    public function zeigeBuchinfo(Request $request)
    {
        request()->validate([
            'buch_id' => 'required | exists:buecher,id'
        ], [
            'buch_id.required' => 'Es wurde keine Buch-ID angegeben.',
            'buch_id.exists'   => 'Die angegebene Buch-ID existiert nicht.', 
        ]);

        $buch      = Buch::find($request->buch_id);
        $ausleiher = $buch->ausleiher;
        
        return view('admin/ausleihe/buchinfo', compact('buch', 'ausleiher'));
    }
}
