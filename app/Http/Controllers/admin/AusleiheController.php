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
    public function zeigeKlasse($id)
    {  
        $klasse = Klasse::findOrFail($id);

        $ausleiher = $klasse->ausleiher()->get();
        $gruppen   = $ausleiher->split(3);    
        
        return view('admin/ausleihe/klasse', compact('ausleiher', 'gruppen'));
    }


    /**
     *  Zeige eine Liste der ausgeliehenen und eine Liste der bestellten Bücher. 
     */
    public function zeigeSchueler($klasse_id, $ausleiher_id)
    {   
        $ausleiher = Ausleiher::where('id', $ausleiher_id)
            ->with('user', 'klasse.jahrgang')       // eager loading
            ->first();

        $next   = $ausleiher->next();
        $prev   = $ausleiher->prev();
       
        // Hole alle Buchtitel, die auf der Bücherliste des Jahrgangs des Ausleihers stehen       
        $buchtitel     = $ausleiher->klasse->jahrgang->buecherliste->buchtitel;
        // Hole alle Bücher, die der Ausleiher derzeit ausgeliehen hat
        $buecher       = $ausleiher->buecher;
        // Hole alle Buchbestellungen, die der Ausleiher abgegeben hat
        $buecherwahlen = $ausleiher->buecherwahlen->keyBy('buchtitel_id');

        // Durchlaufe die Bücherliste und ergänze zu jedem Buchtitel
        //   - die zugehörige Bestellung
        //   - den aktuellen Leihstatus (ist der Buchtitel bereits als Buch ausgeliehen worden?) 
        foreach($buchtitel as $bt) {
            
            // bestellt?
            $bw = $buecherwahlen->get($bt->id);
            if($bw!=null) {
                $bt['wahl']    = $bw->wahl;
                $bt['wahl_id'] = $bw->id;
            } else {
                $bt['wahl'] = 4;    // == nicht bestellt (abgewählt)
            }

            // ausgeliehen?
            $bt['ausgeliehen'] = $buecher->contains('buchtitel_id', $bt->id) ? 1 : 0;
        }

        // Berechne Summe der Leihgebühren
        $summe = 0;
        foreach($buecher as $b) {
            $summe += $b->buchtitel->leihgebuehr;
        }

        return view('admin/ausleihe/schueler', 
            compact('ausleiher', 'buecher', 'buchtitel', 'next', 'prev', 'summe'));
    }

    /**
     * Leihe ein Buch an einen Ausleiher aus.
     */
    public function ausleihen(Request $request, $klasse_id, $ausleiher_id)
    {
        $ausleiher = Ausleiher::find($ausleiher_id);
        $buch      = Buch::find($request->buch_id);
      
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
            return redirect('admin/ausleihe/'.$klasse_id.'/'.$ausleiher_id)
                ->withErrors($validator1->errors()->add('type', 'warning'))
                ->withInput();
        }

        // Ausleihen zwar möglich, es wird aber eine Bestätigung verlangt...
        $validator2 = Validator::make(
            $request->all(), 
            [
                'buch_id' => [
                    new BuchtitelNichtAusgeliehen($ausleiher, $buch),
                    new BuchtitelIstAufBuecherliste($ausleiher, $buch),
                    new BuchtitelIstBestellt($ausleiher, $buch),                    
                ],
            ] 
        );

        if($request->confirmed==null && $validator2->fails()) {
            return redirect('admin/ausleihe/'.$klasse_id.'/'.$ausleiher_id)
                ->withErrors($validator2->errors()->add('type', 'confirm'))
                ->withInput();
        } 

        // Buch wird ausgeliehen
        $buch->ausleiher_id = $ausleiher->id;
        $buch->ausgabe      = now();
        $buch->save();  

        //$ausleiher->buecher()->attach($buch, ['ausgabe' => now()]);

        return redirect('admin/ausleihe/'.$klasse_id.'/'.$ausleiher_id);
    }
   
    

    /**
     * Nimm die Ausleihe eines Buches zurück  
     * (ohne einen Eintrag in die Buchhistorie zu machen)
     */
    public function loeschen(Request $request, $klasse_id, $ausleiher_id)
    {
        //$ausleiher = Ausleiher::find($ausleiher_id);
        $buch = Buch::find($request->buch_id);

        $buch->ausleiher_id = null;
        $buch->ausgabe      = null;
        $buch->save();

        //$user->buecher()->detach($buch);
        
        return redirect('admin/ausleihe/'.$klasse_id.'/'.$ausleiher_id);
    }

    public function aktualisieren(Request $request, $klasse_id, $ausleiher_id)
    {
        $buchwahlen = $request->wahlen;
        
        foreach($buchwahlen as $buchtitel_id => $wahl) 
        {    
            $bw = Buchwahl::where('ausleiher_id', $ausleiher_id)
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

        return redirect('admin/ausleihe/'.$klasse_id.'/'.$ausleiher_id);
    }

    public function zeigeBuecherliste($klasse_id, $ausleiher_id)
    {
        $ausleiher = Ausleiher::where('id', $ausleiher_id)
            ->with('user', 'klasse.jahrgang')       // eager loading
            ->first();

        // Hole alle Buchtitel, die auf der Bücherliste des Jahrgangs des Ausleihers stehen       
        $buchtitel     = $ausleiher->klasse->jahrgang->buecherliste->buchtitel;
        // Hole alle Bücher, die der Ausleiher derzeit ausgeliehen hat
        $buecher       = $ausleiher->buecher;

        $buecherwahlen = $ausleiher->buecherwahlen->keyBy('buchtitel_id');

        foreach($buchtitel as $bt) {
           // bestellt?
            $bw = $buecherwahlen->get($bt->id);
            if($bw!=null) {
                $bt['wahl']    = $bw->wahl;
                $bt['wahl_id'] = $bw->id;
            } else {
                $bt['wahl'] = 4;    // == nicht bestellt (abgewählt)
            }

            // ausgeliehen?
            $bt['ausgeliehen'] = $buecher->contains('buchtitel_id', $bt->id) ? 1 : 0;
        }

        return view('admin/ausleihe/buecherliste', compact('ausleiher', 'buchtitel'));
    }

    public function zeigeErmaessigungen()
    {
        $ausleiher = DB::table('ausleiher')
            ->join('users',   'ausleiher.user_id',   '=', 'users.id')
            ->join('klassen', 'ausleiher.klasse_id', '=', 'klassen.id')
            //->where('erm', '>', 0)
            ->orderBy('nachname')
            ->orderBy('vorname')
            ->get();

        return view('admin/ausleihe/ermaessigungen', compact('ausleiher'));
    }

    public function bestaetigeErmaessigungen(Request $request, $ausleiher_id)
    {
        $ausleiher = Ausleiher::find($ausleiher_id);

        $ausleiher->erm_bestaetigt = $request->ermaessigung;
        $ausleiher->save();

        return redirect('admin/ausleihe/ermaessigungen');
    }

    public function bestaetigeErmaessigungen2(Request $request, $klasse_id, $ausleiher_id)
    {
        $ausleiher = Ausleiher::find($ausleiher_id);

        $ausleiher->bestaetigt = $request->ermaessigung;
        $ausleiher->save();

        return redirect('admin/ausleihe/'.$klasse_id.'/'.$ausleiher_id);
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

        $buch = Buch::find($request->buch_id);

        $ausleiher = $buch->ausleiher()->first();
            //->whereNull('rueckgabe')
        
        return view('admin/ausleihe/buchinfo', compact('buch', 'ausleiher'));
    }
}
