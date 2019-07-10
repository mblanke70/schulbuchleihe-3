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

        $ausleiher = $klasse->schueler()->get();
        $gruppen   = $ausleiher->split(3);    
        
        return view('admin/ausleihe/klasse', compact('klasse', 'ausleiher', 'gruppen'));
    }


    /**
     *  Zeige eine Liste der ausgeliehenen und eine Liste der bestellten Bücher. 
     */
    public function zeigeSchueler($klasse_id, $schueler_id)
    {   
        $schueler = Schueler::findOrFail($schueler_id);

        $next   = $schueler->next();
        $prev   = $schueler->prev();

        // Hole alle Buchtitel, die auf der Bücherliste des Jahrgangs des Schülers stehen       
        $buchtitel     = $schueler->klasse->jahrgang->buchtitel;
        // Hole alle Bücher, die der Schüler derzeit ausgeliehen hat
        $buecher       = $schueler->buecher;
        // Hole alle Buchbestellungen, die der Schüler abgegeben hat
        $buecherwahlen = $schueler->buecherwahlen->keyBy('buchtitel_id');
        
        //dd($buchtitel);

        // Durchlaufe die Bücherliste und ergänze zu jedem Buchtitel
        //   - die zugehörige Bestellung
        //   - den aktuellen Leihstatus (ist der Buchtitel bereits als Buch ausgeliehen worden?) 
        foreach($buchtitel as $btsj) {
            
            // bestellt?
            //$bw = $buecherwahlen->get($bt->buchtitel_id);
            $bw = $buecherwahlen->get($btsj->id);
            if($bw!=null) {
                $btsj['wahl']    = $bw->wahl;
                $btsj['wahl_id'] = $bw->id;
            } else {
                $btsj['wahl'] = 4;    // == nicht bestellt (abgewählt)
            }

            // ausgeliehen?
            $btsj['ausgeliehen'] = $buecher->contains('buchtitel_id', $btsj->buchtitel->id) ? 1 : 0;
        }

        //dd($buchtitel);

        // Berechne Summe der Leihgebühren
        $summe = 0;
        foreach($buecher as $buch) {
            $bt = $buchtitel->where('buchtitel_id', $buch->buchtitel_id)->first();

            $leihpreis = $bt->leihpreis;
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
            compact('schueler', 'buecher', 'buchtitel', 'next', 'prev', 'summe', 'summeErm'));
    }

    /**
     * Leihe ein Buch an einen Ausleiher aus.
     */
    public function ausleihen(Request $request, $klasse_id, $schueler_id)
    {
        $schueler = Schueler::find($schueler_id);
        $buch     = Buch::find($request->buch_id);
      
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
                ],
            ] 
        );

        if($request->confirmed==null && $validator2->fails()) {
            return redirect('admin/ausleihe/'.$klasse_id.'/'.$schueler_id)
                ->withErrors($validator2->errors()->add('type', 'confirm'))
                ->withInput();
        } 

        // Buch wird ausgeliehen
        $buch->ausleiher()->save($schueler, ['ausgabe' => now()]);

        /*
        $buch->ausleiher_id   = $schueler->id;
        $buch->ausleiher_type = "App\Schueler"
        $buch->ausgabe        = now();
        $buch->save();  
        */
        
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

        $buch->schueler_id = null;
        $buch->ausgabe     = null;
        $buch->save();

        //$user->buecher()->detach($buch);
        
        return redirect('admin/ausleihe/'.$klasse_id.'/'.$schueler_id);
    }

    public function aktualisieren(Request $request, $klasse_id, $schueler_id)
    {
        $buchwahlen = $request->wahlen;
        
        foreach($buchwahlen as $buchtitel_id => $wahl) 
        {    
            $bw = Buchwahl::where('ausleiher_id', $schueler_id)
                          ->where('buchtitel_id', $buchtitel_id)
                          ->first();
            if($wahl!=4)
            {
                if($bw) {
                    $bw['wahl'] = $wahl;
                    $bw->save();
                } else {
                    $buchwahl = new Buchwahl;
                    $buchwahl->ausleiher_id = $ausleiher_id;
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

    public function zeigeBuecherliste($klasse_id, $schueler_id)
    {
        $schueler = Schueler::findOrFail($schueler_id);

        // Hole alle Buchtitel, die auf der Bücherliste des Jahrgangs des Ausleihers stehen       
        $buchtitel     = $schueler->klasse->jahrgang->buecherliste->buchtitel;
        // Hole alle Bücher, die der Ausleiher derzeit ausgeliehen hat
        $buecher       = $schueler->buecher;

        $buecherwahlen = $schueler->buecherwahlen->keyBy('buchtitel_id');

        foreach($buchtitel as $bt) {
           // bestellt?
            $bw = $buecherwahlen->get($bt->buchtitel_id);
            if($bw!=null) {
                $bt['wahl']    = $bw->wahl;
                $bt['wahl_id'] = $bw->id;
            } else {
                $bt['wahl'] = 4;    // == nicht bestellt (abgewählt)
            }

            // ausgeliehen?
            $bt['ausgeliehen'] = $buecher->contains('buchtitel_id', $bt->buchtitel_id) ? 1 : 0;
        }

        return view('admin/ausleihe/buecherliste', compact('schueler', 'buchtitel'));
    }

    public function zeigeErmaessigungen()
    {
        $schueler = DB::table('schueler')
            ->join('users',   'schueler.user_id',   '=', 'users.id')
            ->join('klassen', 'schueler.klasse_id', '=', 'klassen.id')
            //->where('erm', '>', 0)
            ->orderBy('nachname')
            ->orderBy('vorname')
            ->get();

        return view('admin/ausleihe/ermaessigungen', compact('ausleiher'));
    }

    public function bestaetigeErmaessigungen(Request $request, $schueler_id)
    {
        $schueler = Schueler::find($schueler_id);

        $schueler->erm_bestaetigt = $request->ermaessigung;
        $schueler->save();

        return redirect('admin/ausleihe/ermaessigungen');
    }

    public function bestaetigeErmaessigungen2(Request $request, $klasse_id, $schueler_id)
    {
        $schueler = Schueler::find($schueler);

        $schueler->bestaetigt = $request->ermaessigung;
        $schueler->save();

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
