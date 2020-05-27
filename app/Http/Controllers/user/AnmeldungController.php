<?php
namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use Validator;
use Auth;   
use URL;

use App\Http\Requests\AbfrageRequest;
use App\Http\Requests\VorabfrageRequest;
use App\Http\Requests\WahlRequest;
use App\Http\Requests\ZustimmungRequest;

use App\Abfrage;
use App\AbfrageAntwort;
use App\Jahrgang;
use App\BuchtitelSchuljahr;
use App\Schueler;
use App\Buchwahl;
use App\Klasse;
use App\BuchHistorie;

class AnmeldungController extends Controller
{
    public function zeigeVorabfragen()
    {
        $user = Auth::user();
        $schueler = $user->schuelerInSchuljahr(3)->first();
        
        if(!empty($schueler)) 
        {
            $ermaessigung = $schueler->erm;

            $wahlen = Buchwahl::where('schueler_id', $schueler->id)->get();

            $kaufen = $wahlen->filter(function ($bw) { return $bw->wahl == 3; });
            $kaufliste = BuchtitelSchuljahr::findMany($kaufen->pluck('buchtitel_id'));

            $verlaengern = $wahlen->filter(function ($bw) { return $bw->wahl == 2; });
            $verlaengernliste = BuchtitelSchuljahr::findMany($verlaengern->pluck('buchtitel_id'));
            
            $leihen = $wahlen->filter(function ($bw) { return $bw->wahl == 1; });
            $leihliste = BuchtitelSchuljahr::findMany($leihen->pluck('buchtitel_id'));
        
            $summeKaufen = $kaufliste->sum('kaufpreis');
            $summeLeihen = $leihliste->sum('leihpreis') + $verlaengernliste->sum('leihpreis');
        
            $summeLeihenReduziert = $summeLeihen;
            switch($ermaessigung) {
                case 1 :  $summeLeihenReduziert = $summeLeihenReduziert * 0.8; break;
                case 2 :  $summeLeihenReduziert = 0; break;
            }

            $gewaehlt = $wahlen[0]->created_at;

            return view('user/anmeldung/uebersicht', compact('leihliste', 'kaufliste', 'verlaengernliste', 'summeKaufen', 'summeLeihen', 'summeLeihenReduziert', 'ermaessigung', 'gewaehlt'));
        } 
        else 
        {
            $jahrgang = $user->jahrgang;
            $jahrgaenge = Jahrgang::where('schuljahr_id', 4)->get();

            return view('user/anmeldung/schritt1', compact('jahrgang', 'jahrgaenge'));
            
            //return view('user/anmeldung/geschlossen'); 
        }
    }

    public function verarbeiteVorabfragen(VorabfrageRequest $request)
    {
        $request->session()->put('ermaessigung', $request->ermaessigung);
        $request->session()->put('jahrgang', $request->jahrgang);
        $request->session()->put('kontoinhaber', $request->kontoinhaber);
        $request->session()->put('iban', $request->iban);

        return redirect('user/anmeldung/schritt2');
    }    

    public function zeigeAbfragen()
    {
        $jg = Jahrgang::find(session('jahrgang'));

        $abfragen = Abfrage::where('jahrgang_id', $jg->id)
            ->whereNull('parent_id')
            ->get();

        return view('user/anmeldung/schritt2', compact('abfragen', 'jg'));
    }

    public function verarbeiteAbfragen(Request $request)
    {
        $abfragen = $request->abfrage;
        $request->session()->put('abfragen', $abfragen);


        return redirect('user/anmeldung/schritt3');
    }

    public function zeigeBuecherliste()
    {
        $user         = Auth::user();
        $jahrgang     = Jahrgang::find(session('jahrgang'));
        $buecherliste = $jahrgang->buchtitel;

        $abfragenRequest = session('abfragen'); 

        foreach($abfragenRequest as $idRequest => $antwRequest)   
        // alle beantworteten Abfragen durchlaufen
        {
            $abfr      = Abfrage::find($idRequest); // Abfrage holen
            $antworten = $abfr->antworten;          // zugehörigen Antworten holen
        
            foreach($antworten as $antw)            // und durchlaufen
            {
                if ( $antw->id != $antwRequest )// && !empty($antw->fach_id) ) 
                {           // entspricht akt. Antwort NICHT der gegebenen Antwort
                    if( empty($abfr->parent_id) )   // Ober-Abfrage nach FACH
                    {                               // Fach komplett rausfiltern
                        $fach         = $antw->fach_id;
                        $buecherliste = $buecherliste->filter(function ($bt) use ($fach) {
                            return $bt->buchtitel->fach_id != $fach;
                        });
                    }
                    else                            // Unter-Abfrage nach BUCHGRUPPE
                    {
                        $buecherliste = $buecherliste->diff($antw->buchtitel);
                    }
                }
            }
        }

        $schueler = $user->schuelerInSchuljahr($jahrgang->schuljahr->vorjahr->id)->first();
        if(!empty($schueler)) {
            $leihbuecher = $schueler->buecher->pluck('buchtitel_id');
        }

        return view('user/anmeldung/schritt3', compact('buecherliste', 'jahrgang', 'leihbuecher'));
    }

    public function verarbeiteBuecherliste(WahlRequest $request)
    {
        $request->session()->put('wahlen', $request->wahlen);

        return redirect('user/anmeldung/schritt4');
    }

    public function zeigeZustimmung()
    {
        $wahlen = session('wahlen');

        $kaufen = array_filter($wahlen, function ($val) { return $val == 3; });
        $kaufliste = BuchtitelSchuljahr::findMany(array_keys($kaufen));
        
        $leihen = array_filter($wahlen, function ($val) { return $val <= 2; });
        $leihliste = BuchtitelSchuljahr::findMany(array_keys($leihen));
        
        //$verlaengern = array_filter($wahlen, function ($val) { return $val == 2; });
        //$verlaengernliste = BuchtitelSchuljahr::findMany(array_keys($verlaengern));
        
        $summeKaufen = $kaufliste->sum('kaufpreis');
        $summeLeihen = $leihliste->sum('leihpreis'); 
        // + $verlaengernliste->sum('leihpreis');
        $ermaessigung = session('ermaessigung');
        
        $summeLeihenReduziert = $summeLeihen;
        switch($ermaessigung) {
            case 1 :  $summeLeihenReduziert = $summeLeihenReduziert * 0.8; break;
            case 2 :  $summeLeihenReduziert = 0; break;
        }

        return view('user/anmeldung/schritt4', compact('leihliste', 'kaufliste', 'summeKaufen', 'summeLeihen', 'summeLeihenReduziert', 'ermaessigung'));
    }

    public function verarbeiteZustimmung(ZustimmungRequest $request)
    {
        $user = Auth::user();
        $jg   = session('jahrgang');
        $erm  = session('ermaessigung');
        $kontoinhaber  = session('kontoinhaber');
        $iban = session('iban');

        // Schüler für aktuelles Schuljahr existiert schon? NEIN?
        $schueler = new Schueler;
        $schueler->user_id      = $user->id;
        $schueler->vorname      = $user->vorname;
        $schueler->nachname     = $user->nachname;
        $schueler->erm          = $erm;
        $schueler->kontoinhaber = $kontoinhaber;
        $schueler->iban         = $iban;
        $schueler->jahrgang_id  = $jg;
        $schueler->betrag       = $request->betrag;

        $jahrgang = Jahrgang::find($jg);
        $klassen  = $jahrgang->klassen;

        // Klasse ermitteln: Jahrgänge 5-11
        if($klassen->count() > 1) {
            $kuerzel = substr($user->klasse, 2, 2); // aktuelles Klassenkürzel setzen
            $klassen = $klassen->filter(function($value, $key) use ($kuerzel) {
                if(strpos($value->bezeichnung, $kuerzel)) {
                    return $value;
                }
            });
        }

        if($klassen->count() > 0) {
            $schueler->klasse_id = $klassen->first()->id;
        }
        
        $schueler->save();

        $alterSchueler = $user
            ->schuelerInSchuljahr($jahrgang->schuljahr->vorjahr->id)->first();
        if(!empty($alterSchueler)) {
            $leihbuecher = $alterSchueler->buecher;
        }

        Buchwahl::where('schueler_id', $schueler->id)->delete();    
        $wahlen = session('wahlen');     

        foreach($wahlen as $btsj_id => $wahl)
        {
            $buchwahl = new Buchwahl;
            $buchwahl->schueler_id  = $schueler->id;
            $buchwahl->buchtitel_id = $btsj_id;
            $buchwahl->wahl         = $wahl;
            $buchwahl->save();

            // Verlängerungs-Buch?
            if($wahl == 2) 
            {
                // Buch ermitteln
                $btsj  = BuchtitelSchuljahr::find($btsj_id);
                $bt_id = $btsj->buchtitel_id;
                $buch  = $leihbuecher->filter(function($value, $key) use ($bt_id) {
                    if( $value->buchtitel_id == $bt_id ) {
                        return $value;
                    }
                })->first();

                // BuchHistorien-Eintrag machen
                $eintrag = new BuchHistorie;
                $eintrag->buch_id   = $buch->id;
                $eintrag->titel     = $buch->buchtitel->titel;
                $eintrag->nachname  = $alterSchueler->nachname;
                $eintrag->vorname   = $alterSchueler->vorname;
                $eintrag->email     = $alterSchueler->user->email;
                $eintrag->klasse    = $alterSchueler->klasse->bezeichnung;
                $eintrag->schuljahr = $alterSchueler->klasse->jahrgang->schuljahr->schuljahr;
                $eintrag->ausgabe   = $buch->ausleiher_ausgabe;
                $eintrag->rueckgabe = Carbon::now();
                $eintrag->save();

                // Buch neu ausleihen
                $schueler->buecher()->save($buch);
                $buch->ausleiher_ausgabe = Carbon::now();
                $buch->save();
            }
        }
  
        return redirect('user/anmeldung/schritt5');
    }

    public function zeigeAbschluss()
    {
        return view('user/anmeldung/schritt5');
    }
}