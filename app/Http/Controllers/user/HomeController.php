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
use App\Schueler;

class HomeController extends Controller
{
    public function zeigeBuecherlisten(Request $request, $schuljahr_id) 
    {
        if(!empty($request->jahrgang)) {
            $jg = $request->jahrgang;
            $jahrgang = Jahrgang::find($jg);
        } else {
            $user = Auth::user();
            $jg = $user->jahrgang;
            if($schuljahr_id>3) $jg++;
            $jahrgang = Jahrgang::where(
                ['jahrgangsstufe' => $jg, 'schuljahr_id' => $schuljahr_id]
            )->first();
        }
        
        $buecherliste = $jahrgang->buchtitel;
        $jahrgaenge   = Jahrgang::where('schuljahr_id', $schuljahr_id)->get();

        return view('user/buecherlisten', compact('jahrgang', 'buecherliste', 'jahrgaenge', 'schuljahr_id'));
    }

    public function zeigeBuecher($sj)
    {
        $user      = Auth::user();
        $schueler  = $user->schuelerInSchuljahr($sj)->first();
        $schuljahr = Schuljahr::find($sj);

        if(!empty($schueler)) $buecher = $schueler->buecher;
        
        return view('user/buecher', compact('schueler', 'buecher', 'schuljahr'));
    }

    public function zeigeRechnung($sj, $id = null)
    {
        if($id == null) {
            $user       = Auth::user();
            $ausleiher  = $user->schuelerInSchuljahr($sj)->first();
        } else {
            $ausleiher  = Schueler::find($id);    
        }
        
        if($ausleiher != null)
        {
            $buecher  = $ausleiher->buecher;
            $familie  = $ausleiher->familie;

            $summe = 0;
            foreach($buecher as $buch) {
                // BuchtitelSchuljahr muss passen zum Schuljahr des Ausleihers
                $btsj = $buch->buchtitel->buchtitelSchuljahr->first();

                $leihpreis = $btsj->leihpreis;
                $buch['leihpreis'] = $leihpreis;
                if($leihpreis != null) { $summe += $leihpreis; }
            }

            $erm = 1;
            if($familie != null)
            {
                if($familie->kinder()->count() 
                    + $familie->externe()->count() > 2)
                {
                    $erm = 0.8;
                }

                if($familie->befreit)
                {
                    $erm = 0;
                } 
            }

            return view('user/rechnungen', 
                compact('ausleiher', 'buecher', 'familie', 'summe', 'erm'));
        }

         return view('user/index2');
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