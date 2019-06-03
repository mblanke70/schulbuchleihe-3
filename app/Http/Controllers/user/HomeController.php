<?php
namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;   

use App\Klasse;
use App\User;
use App\Ausleiher;
use App\Buecherliste;
use App\Jahrgang;
use App\Schuljahr;

class HomeController extends Controller
{
    public function zeigeBuecherlisten(Request $request) 
    {
        if(!empty($request->jahrgang)) {
            $jg = $request->jahrgang;
            $jahrgang = Jahrgang::find($jg);
        } else {
            $user = Auth::user();
            $jg = $user->jahrgang; if($jg!=20) $jg++;
            $jahrgang = Jahrgang::where(
                ['jahrgangsstufe' => $jg, 'schuljahr_id' => 3]
            )->first();
        }
        
        $buecherliste = $jahrgang->buchtitel;
        $jahrgaenge   = Jahrgang::where('schuljahr_id', 3)->get();

        return view('user/buecherlisten', compact('jahrgang', 'buecherliste', 'jahrgaenge'));
    }

    public function zeigeBuecher($sj)
    {
        $user      = Auth::user();
        $schueler  = $user->schuelerInSchuljahr($sj)->first();
        $schuljahr = Schuljahr::find($sj);

        if(!empty($schueler)) $buecher = $schueler->buecher;
        
        return view('user/buecher', compact('schueler', 'buecher', 'schuljahr'));
    }

    public function zeigeSchuljahr($sj)
    {
        $user = Auth::user();

        $schueler = $user->schuelerInSchuljahr($sj)->first();
        $jahrgang = $schueler->klasse->jahrgang;

        $buecher       = $schueler->buecher;
        $buchtitel     = $jahrgang->buchtitel;
        $buecherwahlen = $schueler->buecherwahlen->keyBy('buchtitel_id');

        foreach($buchtitel as $bt) {
            // bestellt?
            $bw = $buecherwahlen->get($bt->id);
            if($bw!=null) {
                $bt['wahl']    = $bw->wahl;
                $bt['wahl_id'] = $bw->id;
            } else {
                $bt['wahl'] = 4;   // == nicht bestellt (abgewählt)
            }

            // ausgeliehen?
            $bt['ausgeliehen'] = $buecher->contains('buchtitel_id', $bt->id) ? 1 : 0;
        }

        return view('user/buecherliste/index', compact('schueler', 'buchtitel'));
    }
}