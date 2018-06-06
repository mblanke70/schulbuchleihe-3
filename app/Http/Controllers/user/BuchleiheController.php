<?php
namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Abfrage;
use App\AbfrageAntwort;
use App\Buecherliste;
use App\Http\Requests\AbfrageRequest;
use App\Http\Requests\VorabfrageRequest;
use App\Http\Requests\WahlRequest;
use App\Http\Requests\ZustimmungRequest;

use App\Buchwahl;
use Auth;   
use URL;

class BuchleiheController extends Controller
{
    public function neuwahl()
    {
        $user = Auth::user();
        $user->fertig = false;
        $user->save();

        return redirect('user/buchleihe');
    }

    public function index()
    {
        $user = Auth::user();
        if($user->fertig) 
        {
            $user_id   = Auth::user()->id;
            $wahlliste = Buchwahl::with('buchtitel')->where('user_id', $user_id)->get();

            $kaufen = $wahlliste->filter(function ($buchwahl, $key) {
                return  $buchwahl['wahl'] == 0;
            });
            $summeKaufen = $kaufen->sum('buchtitel.preis');

            $leihen = $wahlliste->filter(function ($buchwahl, $key) {
                return  $buchwahl['wahl'] > 0;
            });
            $summeLeihen  = $leihen->sum('buchtitel.leihgebuehr');
            $ermaessigung = Auth::user()->ermaessigung;
            $pauschale    = Auth::user()->pauschale;
            $summeLeihenReduziert = $summeLeihen * ($ermaessigung / 10.0);

            $zeit = $kaufen->first()->created_at;
            date_add($zeit, date_interval_create_from_date_string('2 hours'));
            
            return view('user/buchleihe/index', compact('leihen', 'kaufen', 'summeKaufen', 'summeLeihen', 'summeLeihenReduziert', 'ermaessigung', 'pauschale', 'zeit'));

            
        }
        
        return redirect('user/buchleihe/vorabfragen');
    }

    public function zeigeVorabfragen()
    {
        $jahrgang = Auth::user()->jahrgang;
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
        $jg = Auth::user()->jahrgang;

        $abfragen = Abfrage::where('jahrgang', $jg)
                        ->whereNull('parent_id')
                        ->get();

        return view('user/buchleihe/abfragen', compact('abfragen'));
    }

    public function zeigeBuecherliste(AbfrageRequest $request)
    {
        $abfragen = $request->abfrage;
        $jahrgang = Auth::user()->jahrgang;

        $buecherliste = Buecherliste::where('jahrgang', $jahrgang)->first()->buchtitel;      

        $ids = array_keys($abfragen);               // Abfrage IDs holen
        foreach($ids as $id)                        // alle Abfragen durchlaufen
        {
            $abfr      = Abfrage::find($id);        // Abfrage holen
            $antworten = $abfr->antworten;          // zugehörigen Antworten holen
        
            foreach($antworten as $antw)            // und durchlaufen
            {
                if ( $antw->wert != $abfragen[$id] && !empty($antw->wert) )                      
                {                       // entspricht akt. Antwort NICHT der gegebenen Antwort
                    if( empty($abfr->parent_id) )   // Ober-Abfrage nach FACH
                    {                               // Fach komplett rausfiltern
                        $fach         = $antw->wert;
                        $buecherliste = $buecherliste->filter(function ($bt) use ($fach) {
                            return $bt->fach != $fach;
                        });
                    }
                    else                             // Unter-Abfrage nach BUCHGRUPPE
                    {
                        if( !empty($abfragen[$abfr->parent_id]) )
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

    public function verarbeiteBuecherwahlen(WahlRequest $request)
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

        return redirect('user/buchleihe/buecherwahlen');
    }

    public function zeigeBuecherwahlen()
    {
        $user_id   = Auth::user()->id;
        $wahlliste = Buchwahl::with('buchtitel')->where('user_id', $user_id)->get();

        $kaufen = $wahlliste->filter(function ($buchwahl, $key) {
            return  $buchwahl['wahl'] == 0;
        });
        $summeKaufen = $kaufen->sum('buchtitel.preis');

        $leihen = $wahlliste->filter(function ($buchwahl, $key) {
            return  $buchwahl['wahl'] > 0;
        });
        $summeLeihen  = $leihen->sum('buchtitel.leihgebuehr');
        $ermaessigung = Auth::user()->ermaessigung;
        $pauschale    = Auth::user()->pauschale;
        $summeLeihenReduziert = $summeLeihen * ($ermaessigung / 10.0);

        return view('user/buchleihe/buecherwahlen', compact('leihen', 'kaufen', 'summeKaufen', 'summeLeihen', 'summeLeihenReduziert', 'ermaessigung', 'pauschale'));
    }

    public function verarbeiteZustimmung(ZustimmungRequest $request)
    {
        $user = Auth::user(); 
        $user->fertig = 1;
        $user->save();

        return redirect('user/buchleihe');
    }
}
