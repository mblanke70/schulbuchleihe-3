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
            //if($schuljahr_id>3) $jg++;
            $jahrgang = Jahrgang::where(
                ['jahrgangsstufe' => $jg, 'schuljahr_id' => $schuljahr_id]
            )->first();
        }
        
        $buecherliste = $jahrgang->buchtitel;
        $jahrgaenge   = Jahrgang::where('schuljahr_id', $schuljahr_id)->get();

        return view('user/buecherlisten', compact('jahrgang', 'buecherliste', 'jahrgaenge', 'schuljahr_id'));
    }

    public function zeigeBuecher($sj, $id = null)
    {
        if($id == null) {
            $user      = Auth::user();
            $schueler  = $user->schuelerInSchuljahr($sj)->first();
        } else {
            $schueler  = Schueler::find($id);    
        }
       
        $schuljahr = Schuljahr::find($sj);
                
        return view('user/buecher', compact('schueler', 'schuljahr'));
    }

    public function zeigeFamilie($id = null)
    {
        if($id == null) {
            $user = Auth::user();
        } else {
            $user = User::findOrFail($id);
        }

        $familie = $user->familie;

        return view('user/familie', compact('user', 'familie'));
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
            $ebooks   = $ausleiher->ebooks;
            $familie  = $ausleiher->user->familie;

            /* Bücher */
            $summe = 0;

            if($buecher != null) {
                foreach($buecher as $buch) {
                    $btsj = $buch->buchtitel->buchtitelSchuljahr
                        ->where('schuljahr_id', 4)->first();

                    $leihpreis = $btsj->leihpreis;
                    $buch['leihpreis'] = $leihpreis;
                    if($leihpreis != null) { $summe += $leihpreis; }
                }
            }

            /* Ebooks */
            $summe_ebooks = 0;

            if($ebooks != null) {
                foreach($ebooks as $ebook) {
                    $btsj      = $ebook->buchtitel;
                    $leihpreis = $btsj->ebook;
                    $ebook['leihpreis'] = $leihpreis;
                    if($leihpreis != null) { $summe_ebooks += $leihpreis; }
                }
            }

            $erm = 1;
            if($familie != null)
            {
                if($familie->users()->count() 
                    + $familie->externe()->where('bestaetigt', 1)->count() > 2)
                {
                    $erm = 0.8;
                }

                if($familie->befreit)
                {
                    $erm = 0;
                } 
            }

            //dd($ebooks);

            return view('user/rechnungen', 
                compact('ausleiher', 'erm', 'buecher', 'ebooks', 'familie', 'summe', 'summe_ebooks'));
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