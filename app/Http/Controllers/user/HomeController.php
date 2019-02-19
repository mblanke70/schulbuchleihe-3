<?php
namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;   

use App\Klasse;
use App\User;
use App\Ausleiher;
use App\Buecherliste;

class HomeController extends Controller
{
    public function zeigeBuecherliste()
    {
        $user     = Auth::user();
        $schueler = $user->schueler()
            ->with('user', 'klasse.jahrgang')
            ->first(); // nur ein Ausleiher wird geholt!!!

        $buchtitel     = $schueler->klasse->jahrgang->buecherliste->buchtitel;
        $buecher       = $schueler->buecher;
        $buecherwahlen = $schueler->buecherwahlen->keyBy('buchtitel_id');

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

        return view('user/buecherliste/index', compact('schueler', 'buchtitel'));
    }

    public function zeigeBuecher()
    {
        $user     = Auth::user();
        $schueler = $user->schueler()->first(); // nur ein Ausleiher wird geholt!!!

        if($schueler!=null) {
            $buecher = $schueler->buecher;

            $summe = 0;
            foreach($buecher as $b) {
                $summe += $b->buchtitel->leihgebuehr;
            }
            
            $summeErm = $summe;
            if($schueler->erm_bestaetigt==2) $summeErm = 0;
            if($schueler->erm_bestaetigt==1) $summeErm = $summe * 0.8;

            $zusatzkosten = 6.5;
            if($schueler->pauschale>0) $zusatzkosten += 10.5;

            return view('user/buecher/index', 
                compact('schueler', 'buecher', 'summe', 'summeErm', 'zusatzkosten'));
        }
        else {
            return dd("kein Ausleiher");
        }
    }
}