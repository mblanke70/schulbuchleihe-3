<?php
namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use Validator;
use Auth;   
use URL;

use Illuminate\Support\Facades\Mail;

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
use App\Familie;
use App\Mail\OrderConfirm;

class AnmeldungController extends Controller
{
    public function zeigeVorabfragen()
    {
        $user     = Auth::user();
        $schueler = $user->schuelerInSchuljahr(4)->first();
        
        if( !empty($schueler) ) 
        {
            $wahlen = Buchwahl::where('schueler_id', $schueler->id)->get();
            
            $kaufen = $wahlen->filter(function ($bw) { return $bw->wahl == 3; });
            $kaufliste = BuchtitelSchuljahr::findMany($kaufen->pluck('buchtitel_id'));

            $verlaengern = $wahlen->filter(function ($bw) { return $bw->wahl == 2; });
            $verlaengernliste = BuchtitelSchuljahr::findMany($verlaengern->pluck('buchtitel_id'));
            
            $leihen = $wahlen->filter(function ($bw) { return $bw->wahl == 1; });
            $leihliste = BuchtitelSchuljahr::findMany($leihen->pluck('buchtitel_id'));
        
            //dd($leihen->where('buchtitel_id', '=', 335)->first());
            $leihenEbooks = $wahlen->filter(function ($bw) { return $bw->wahl == 1 && $bw->ebook == 1; });
            $leihlisteEbooks = BuchtitelSchuljahr::findMany($leihenEbooks->pluck('buchtitel_id'));

            $verlaengernEbooks = $wahlen->filter(function ($bw) { return $bw->wahl == 2 && $bw->ebook == 1; });
            $verlaengernlisteEbooks = BuchtitelSchuljahr::findMany($verlaengernEbooks->pluck('buchtitel_id'));


            $summeKaufen = $kaufliste->sum('kaufpreis');
            $summeLeihen = $leihliste->sum('leihpreis') 
                + $leihlisteEbooks->sum('ebook')
                + $verlaengernliste->sum('leihpreis') 
                + $verlaengernlisteEbooks->sum('ebook');

            $gewaehltAm = $wahlen->first()->created_at;

            //dd($leihlisteEbooks->sum('ebook'));

            return view('user/anmeldung/uebersicht', compact('leihliste', 'leihlisteEbooks', 'kaufliste', 'verlaengernliste', 'verlaengernlisteEbooks', 'gewaehltAm', 'leihen', 'verlaengern', 'summeLeihen', 'summeKaufen', 'schueler'));
        } 
        else 
        {
            $jahrgang   = $user->jahrgang+1;
            $familie    = $user->familie;
            $jahrgaenge = Jahrgang::where('schuljahr_id', 4)->get();

            return view('user/anmeldung/schritt1', 
                compact('familie', 'user', 'jahrgang', 'jahrgaenge'));
            
            //return view('user/anmeldung/geschlossen'); 
        }
    }

    public function verarbeiteVorabfragen(VorabfrageRequest $request)
    {
        //$request->session()->put('ermaessigung', $request->ermaessigung);
        $request->session()->put('jahrgang', $request->jahrgang);
        //$request->session()->put('kontoinhaber', $request->kontoinhaber);
        //$request->session()->put('iban', $request->iban);
        $request->session()->put('anrede', $request->anrede);
        $request->session()->put('vorname', $request->vorname);
        $request->session()->put('nachname', $request->nachname);
        $request->session()->put('strasse', $request->strasse);
        $request->session()->put('plz', $request->plz);
        $request->session()->put('ort', $request->ort);
        $request->session()->put('email', $request->email);

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
                    else
                    {
                        $buecherliste = $buecherliste->diff($antw->buchtitel);
                    }
                }
            }
        }

        /* Achtung quick & dirty */
        if($jahrgang->jahrgangsstufe == 11) 
        {
            if(Auth::user()->klasse == '10F') {
                // Weltatlas 2008 raus
                $buchtitel = BuchtitelSchuljahr::findMany([325]);
            }
            else {
                // Weltatlas 2015 und Elektronisches Wörterbuch raus
                $buchtitel = BuchtitelSchuljahr::findMany([324, 283]);
            }
            $buecherliste = $buecherliste->diff($buchtitel);
        }

        $schueler = $user->schuelerInSchuljahr($jahrgang->schuljahr->vorjahr->id)->first();
        if(!empty($schueler)) {
            $leihbuecher = $schueler->buecher->pluck('buchtitel_id');
        } else {
            $leihbuecher = [];
        }

        return view('user/anmeldung/schritt3', compact('buecherliste', 'jahrgang', 'leihbuecher'));
    }

    public function verarbeiteBuecherliste(WahlRequest $request)
    {
        $request->session()->put('wahlen', $request->wahlen);

        return redirect('user/anmeldung/schritt4');
    }

    public function zeigeEbooks()
    {
        $wahlen = session('wahlen');

        $leihen = array_filter($wahlen, function ($val) { return $val <= 2; });
        $leihliste = BuchtitelSchuljahr::findMany(array_keys($leihen));

        $leihliste = $leihliste->filter(function ($val) {
            return $val->ebook != null;
        }); 

        //dd($leihliste);

        return view('user/anmeldung/schritt4', compact('leihliste'));
    }

    public function verarbeiteEbooks(Request $request)
    {
        $request->session()->put('ebooks', $request->ebooks);

        //dd(session('ebooks'));

        return redirect('user/anmeldung/schritt5');
    }

    public function zeigeZustimmung(Request $request)   // Schritt 5
    {
        $wahlen = session('wahlen');
        $ebooks = session('ebooks');

        $kaufen = array_filter($wahlen, function ($val) { return $val == 3; });
        $kaufliste = BuchtitelSchuljahr::findMany(array_keys($kaufen));
        
        $leihen = array_filter($wahlen, function ($val) { return $val <= 2; });
        $leihliste = BuchtitelSchuljahr::findMany(array_keys($leihen));
        
        //$verlaengern = array_filter($wahlen, function ($val) { return $val == 2; });
        //$verlaengernliste = BuchtitelSchuljahr::findMany(array_keys($verlaengern));

        $summeKaufen = $kaufliste->sum('kaufpreis');
        $summeLeihen = $leihliste->sum('leihpreis');

        if(!empty($ebooks)) {
            $summeEbooks = BuchtitelSchuljahr::findMany($ebooks)->sum('ebook');
            $summeLeihen += $summeEbooks; // 3,99€ noch nicht eingearbeitet
        }

        $request->session()->put('betrag', $summeLeihen);

        // + $verlaengernliste->sum('leihpreis');
        /*
        $ermaessigung = session('ermaessigung');
        
        $summeLeihenReduziert = $summeLeihen;
        switch($ermaessigung) {
            case 1 :  $summeLeihenReduziert = $summeLeihenReduziert * 0.8; break;
            case 2 :  $summeLeihenReduziert = 0; break;
        }
        */

        return view('user/anmeldung/schritt5', 
            compact('leihliste', 'kaufliste', 'summeKaufen', 'summeLeihen', 'ebooks'));
    }

    public function verarbeiteZustimmung(ZustimmungRequest $request)
    {
        $user     = Auth::user();
        $jg       = session('jahrgang');
        $jahrgang = Jahrgang::find($jg);

        #################### User updaten #####################

        /*
        $user->re_geschlecht = session('geschlecht');
        $user->re_nachname   = session('nachname');
        $user->re_vorname    = session('geschlecht');
        $user->re_ort        = session('ort');
        $user->re_plz        = session('plz');
        $user->re_email      = session('email');
        */

        $user->strasse = session('strasse');
        $user->save();

        #################### Neuen Schüler erzeugen #####################

        $schueler = new Schueler;
        $schueler->user_id      = $user->id;
        $schueler->vorname      = $user->vorname;
        $schueler->nachname     = $user->nachname;
        $schueler->betrag       = session('betrag');
        $schueler->jahrgang_id  = session('jahrgang');

        //$jahrgang->schueler()->save($schueler);
        
        #################### Klasse ermitteln und dem Schüler zuordnen #####################

        $klassen  = $jahrgang->klassen;

        // Jahrgänge 5-11: Klasse des Schülers zuweisen
        if($klassen->count() > 1) {
            $kuerzel = substr($user->klasse, 2, 2); // aktuelles Klassenkürzel (A-F) ermitteln
            if($kuerzel!=null) { // wenn nicht Jg. 05
                $klassen = $klassen->filter(function($value, $key) use ($kuerzel) {
                    if(strpos($value->bezeichnung, $kuerzel)) {
                        return $value;
                    }
                }); // richtige Klasse unter den Klassen im Jahrgang ermitteln
            }
        }

        if($klassen->count() > 0) {
            $klasse = $klassen->first();
            $schueler->klasse_id = $klasse->id; 

            // alle Schüler im Jahrgang 05 landen in der Klasse 05A
            //$klasse->schueler()->save($schueler); // Klasse beim Schüler setzen
        }
        
        $schueler->save();

        #################### Familie zuordnen oder neu erzeugen #####################
        if(empty($user->familie_id)) {
            $familie = Familie::where('name', '=', $user->nachname)
                ->where('strasse', 'like', substr($user->strasse,0,5))
                ->first();

            if(empty($familie)) {
                $familie = new Familie;
            }
        } 
        else {  
            $familie = $user->familie;
        }

        $familie->name    = $user->nachname;
        $familie->strasse = session('strasse');

        $familie->re_anrede     = session('anrede');;
        $familie->re_nachname   = session('nachname');
        $familie->re_vorname    = session('vorname');
        $familie->re_strasse_nr = session('strasse');
        $familie->re_ort        = session('ort');
        $familie->re_plz        = session('plz');
        $familie->email         = session('email');

        $familie->save();

        if(empty($user->familie_id)) {
            $user->familie_id = $familie->id;
            //$familie->users()->save($user);
            $user->save();
        }

        #################### Wahlentscheidungen verarbeiten #####################

        // Vorjahres-Schüler holen
        $schuelerVorjahr = $user->schuelerInSchuljahr($jahrgang->schuljahr->vorjahr->id)->first();
        if(!empty($schuelerVorjahr)) {
            $leihbuecher = $schuelerVorjahr->buecher; // Leihbücher des Vorjahres holen
        }

        //Buchwahl::where('schueler_id', $schueler->id)->delete(); // überflüssig?!
        
        $wahlen = session('wahlen');     
        $ebooks = session('ebooks');     

        // alle Wahlentscheidungen durchgehen
        foreach($wahlen as $btsj_id => $wahl)
        {
            // neue Wahl erzeugen
            $buchwahl = new Buchwahl;
            $buchwahl->schueler_id  = $schueler->id;
            $buchwahl->buchtitel_id = $btsj_id;
            $buchwahl->wahl         = $wahl;

            if(!empty($ebooks)) {
                if(in_array($btsj_id, $ebooks)) {
                    $buchwahl->ebook = 1;
                }
            }

            $buchwahl->save();

            // bei Verlängerung das bereits ausgeliehene Buch ins neue Schuljahr übertragen
            if($wahl == 2) 
            {
                // ausgeliehendes Buch des aktuellen Buchtitel ermitteln
                $btsj  = BuchtitelSchuljahr::find($btsj_id);
                $bt_id = $btsj->buchtitel_id;
                $buch  = $leihbuecher->filter(function($value, $key) use ($bt_id) {
                    if( $value->buchtitel_id == $bt_id ) {
                        return $value;
                    }
                })->first();

                // BuchHistorien-Eintrag machen (Buch zurückgeben)
                $eintrag = new BuchHistorie;
                $eintrag->buch_id   = $buch->id;
                $eintrag->titel     = $buch->buchtitel->titel;
                $eintrag->nachname  = $schuelerVorjahr->nachname;
                $eintrag->vorname   = $schuelerVorjahr->vorname;
                $eintrag->email     = $schuelerVorjahr->user->email;
                $eintrag->klasse    = $schuelerVorjahr->klasse->bezeichnung;
                $eintrag->schuljahr = $schuelerVorjahr->klasse->jahrgang->schuljahr->schuljahr;
                $eintrag->ausgabe   = $buch->ausleiher_ausgabe;
                $eintrag->rueckgabe = Carbon::now();
                $eintrag->save();

                // Buch neu ausleihen
                $schueler->buecher()->save($buch);  // Bucn wird dabei beim Vorjahres-Schüler gelöscht
                $buch->ausleiher_ausgabe = Carbon::now();
                $buch->save();
            }
        }

        $mail = new OrderConfirm($schueler);
        Mail::to($familie->email)->send($mail);
  
        return redirect('user/anmeldung/schritt6');
    }

    public function zeigeAbschluss()
    {
        return view('user/anmeldung/schritt6');
    }
}