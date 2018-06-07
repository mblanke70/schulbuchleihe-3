<?php
namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use Auth;   
use URL;

use App\Abfrage;
use App\AbfrageAntwort;
use App\Buecherliste;
use App\AbfrageWahl;
use App\Buchwahl;
use App\Http\Requests\AbfrageRequest;
use App\Http\Requests\VorabfrageRequest;
use App\Http\Requests\WahlRequest;
use App\Http\Requests\ZustimmungRequest;

class BuchleiheController extends Controller
{
    public function neuwahl()
    {
        $user = Auth::user();
        $user->fertig = false;
        $user->betrag = null;
        $user->ermaessigung = null;
        $user->pauschale    = null;
        AbfrageWahl::where('user_id', $user->id)->delete();
        Buchwahl::where('user_id', $user->id)->delete();
        $user->save();

        return redirect('user/buchleihe');
    }

    public function index()
    {
        $user = Auth::user();

        if($user->fertig) 
        {
            $user = Auth::user();
            $wahlliste = $user->buchwahlen();

            $kaufen = $wahlliste->filter(function ($buchwahl, $key) {
                return  $buchwahl['wahl'] == 3;
            });
            $summeKaufen = $kaufen->sum('buchtitel.preis');

            $leihen = $wahlliste->filter(function ($buchwahl, $key) {
                return  $buchwahl['wahl'] < 3;
            });
            $summeLeihen  = $leihen->sum('buchtitel.leihgebuehr');
            
            $ermaessigung = $user->ermaessigung;
            $pauschale    = $user->pauschale;
            $summeLeihenReduziert = $summeLeihen * ($ermaessigung / 10.0);

            $summeExtra   = $pauschale ? 17 : 6.5;
            $summeGesamt  = $summeLeihenReduziert + $summeExtra;

            $zeit = $kaufen->first()->created_at;
            date_add($zeit, date_interval_create_from_date_string('2 hours'));

            return view('user/buchleihe/index', compact('leihen', 'kaufen', 'summeKaufen', 'summeLeihen', 'summeLeihenReduziert', 'zeit', 'summeGesamt', 'user', 'pauschale'));
        }
        
        return redirect('user/buchleihe/vorabfragen');
    }

    public function zeigeVorabfragen()
    {
        $jahrgang = Auth::user()->jahrgang; if( $jahrgang!=20 ) $jahrgang++;
        return view('user/buchleihe/vorabfragen', compact('jahrgang'));
    }    

    public function verarbeiteVorabfragen(VorabfrageRequest $request)
    {
        $user = Auth::user(); 
        $user->ermaessigung = $request->ermaessigung;
        $user->pauschale    = $request->pauschale;
        
        if($user->istAdmin())
        {
            $user->jahrgang = $request->jahrgang; 
        }

        $user->save();
        
        return redirect('user/buchleihe/abfragen');
    }    

    public function zeigeAbfragen()
    {
        $jg = Auth::user()->jahrgang; if( $jg!=20 ) $jg++;

        $abfragen = Abfrage::where('jahrgang', $jg)->whereNull('parent_id')->get();

        return view('user/buchleihe/abfragen', compact('abfragen', 'jg'));
    }

    public function verarbeiteAbfragen(AbfrageRequest $request)
    {
        $abfragen = $request->abfrage;
        $user_id  = Auth::user()->id;

        AbfrageWahl::where('user_id', $user_id)->delete();

        foreach($abfragen as $abfrage_id => $wert)
        {
            $abfrageWahl = new AbfrageWahl;
            $abfrageWahl->user_id    = $user_id;
            $abfrageWahl->abfrage_id = $abfrage_id;
            $abfrageWahl->abfrage_antwort_id = $wert;
            $abfrageWahl->save();
        }

        return redirect('user/buchleihe/buecherliste');
    }

    public function zeigeBuecherliste()
    {
        $user = Auth::user();

        $abfragen = AbfrageWahl::where('user_id', $user->id)->get();

        foreach($abfragen as $id => $abfr)
        {
            $abfragenRequest[$abfr->abfrage_id] = $abfr->abfrage_antwort_id;
        }

        $jg = $user->jahrgang; if( $jg!=20 ) $jg++;
        $buecherliste = Buecherliste::where('jahrgang', $jg)->first()->buchtitel;      

        foreach($abfragenRequest as $idRequest => $antwRequest)   
        // alle beantworteten Abfragen durchlaufen
        {
            $abfr      = Abfrage::find($idRequest); // Abfrage holen
            $antworten = $abfr->antworten;          // zugehörigen Antworten holen
        
            foreach($antworten as $antw)            // und durchlaufen
            {
                if ( $antw->wert != $antwRequest && !empty($antw->wert) ) 
                {           // entspricht akt. Antwort NICHT der gegebenen Antwort
                    if( empty($abfr->parent_id) )   // Ober-Abfrage nach FACH
                    {                               // Fach komplett rausfiltern
                        $fach         = $antw->wert;
                        $buecherliste = $buecherliste->filter(function ($bt) use ($fach) {
                            return $bt->fach != $fach;
                        });
                    }
                    else                            // Unter-Abfrage nach BUCHGRUPPE
                    {
                        if( !empty($abfragenRequest[$abfr->parent_id]) )
                        {
                            // wenn gegebene Antwort der zugehörigen Ober-Abfrage NICHT leer
                            $buchgruppe    = $antw->wert;
                            $buecherliste  = $buecherliste->filter(function($bt) use ($buchgruppe) {
                                return $bt->pivot->buchgruppe != $buchgruppe;
                            });
                        }
                    }
                }
            }
        }
            
        return view('user/buchleihe/buecherliste', compact('buecherliste'));
    }

    public function verarbeiteBuecherliste(WahlRequest $request)
    {
        $wahlen  = $request->wahlen;
        $user_id = Auth::user()->id;

        Buchwahl::where('user_id', $user_id)->delete();

        foreach($wahlen as $buchtitel_id => $wahl)
        {
            $buchwahl = new Buchwahl;
            $buchwahl->user_id      = $user_id;
            $buchwahl->buchtitel_id = $buchtitel_id;
            $buchwahl->wahl         = $wahl;
            $buchwahl->save();
        }

        return redirect('user/buchleihe/zustimmung');
    }

    public function zeigeZustimmung()
    {
        $user = Auth::user();
        $wahlliste = $user->buchwahlen();

        $kaufen = $wahlliste->filter(function ($buchwahl, $key) {
            return  $buchwahl['wahl'] == 3;
        });
        $summeKaufen = $kaufen->sum('buchtitel.preis');

        $leihen = $wahlliste->filter(function ($buchwahl, $key) {
            return  $buchwahl['wahl'] < 3;
        });

        $summeLeihen  = $leihen->sum('buchtitel.leihgebuehr');
        $ermaessigung = $user->ermaessigung;
        $pauschale    = $user->pauschale;
        $summeLeihenReduziert = $summeLeihen * ($ermaessigung / 10.0);

        $summeExtra   = $pauschale ? 17 : 6.5;
        $summeGesamt  = $summeLeihenReduziert + $summeExtra;

        return view('user/buchleihe/zustimmung', compact('leihen', 'kaufen', 'summeKaufen', 'summeLeihen', 'summeLeihenReduziert', 'summeGesamt', 'ermaessigung', 'pauschale'));
    }

    public function verarbeiteZustimmung(ZustimmungRequest $request)
    {
        $user = Auth::user(); 
        $user->fertig = 1;
        $user->betrag = $request->betrag;
        $user->save();

        return redirect('user/buchleihe');
    }
}
