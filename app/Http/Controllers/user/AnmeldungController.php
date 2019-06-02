<?php
namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

class AnmeldungController extends Controller
{
    public function zeigeVorabfragen()
    {
        $user = Auth::user();

        $jahrgang = $user->jahrgang;
        if($jahrgang != 20) $jahrgang++;

        $jahrgaenge = Jahrgang::where('schuljahr_id', 3)->get();

        return view('user/anmeldung/schritt1', compact('jahrgang', 'jahrgaenge'));
    }

    public function verarbeiteVorabfragen(VorabfrageRequest $request)
    {
        $request->session()->put('ermaessigung', $request->ermaessigung);
        $request->session()->put('jahrgang', $request->jahrgang);

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
        $summeKaufen = $kaufliste->sum('kaufpreis');

        $leihen = array_filter($wahlen, function ($val) { return $val < 3; });
        $leihliste = BuchtitelSchuljahr::findMany(array_keys($leihen));
        $summeLeihen  = $leihliste->sum('leihpreis');

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

        // Schüler für aktuelles Schuljahr existiert schon? NEIN?
        $schueler = new Schueler;
        $schueler->user_id     = $user->id;
        $schueler->vorname     = $user->vorname;
        $schueler->nachname    = $user->nachname;
        $schueler->erm         = $erm;
        $schueler->jahrgang_id = $jg;
        $schueler->betrag      = $request->betrag;

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

        $schueler->klasse_id = $klassen[0]->id;
        $schueler->save();

        Buchwahl::where('schueler_id', $schueler->id)->delete();    
        $wahlen = session('wahlen');     
        foreach($wahlen as $btsj_id => $wahl)
        {
            $buchwahl = new Buchwahl;
            $buchwahl->schueler_id  = $schueler->id;
            $buchwahl->buchtitel_id = $btsj_id;
            $buchwahl->wahl         = $wahl;
            $buchwahl->save();
        }

        $schueler = $user->schuelerInSchuljahr($jahrgang->schuljahr->vorjahr->id)->first();
        if(!empty($schueler)) {
            $leihbuecher = $schueler->buecher;
        }

        // Verlängerte Bücher bearbeiten !!! Fehlt noch !!!

        return redirect('user/anmeldung/schritt5');
    }

    public function zeigeAbschluss()
    {
        return view('user/anmeldung/schritt5');
    }
}
