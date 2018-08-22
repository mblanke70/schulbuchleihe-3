<?php
namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;   

use App\Klasse;
use App\User;
use App\Buecherliste;

class HomeController extends Controller
{
    public function zeigeBuecherliste($klasse_id, $user_id)
    {
        $klasse  = Klasse::find($klasse_id);
        $user    = User::find($user_id);
        $buecher = $user->buecher;

        $jg = $user->jahrgang; 
        $buchtitel = Buecherliste::where('jahrgang', $jg)->first()->buchtitel;  

        foreach($buchtitel as $bt) {
            $bw = $user->buchwahlen()->where('buchtitel_id', $bt->id)->first();
            if($bw!=null) {
                $bt['wahl']    = $bw->wahl;
                $bt['wahl_id'] = $bw->id;
            } else {
                $bt['wahl'] = 4;
            }

            $bt['ausgeliehen'] = $buecher->contains('buchtitel_id', $bt->id) ? 1 : 0;
        }

        return view('user/buecherliste/index', compact('klasse', 'user', 'buchtitel'));
    }

    public function zeigeBuecher()
    {
        $user     = Auth::user();
        $klasse   = $user->klassengruppe;
        $buecher  = $user->buecher;

        $summe    = $buecher->sum('leihgebuehr');
        
        $summeErm = $summe;
        if($user->bestaetigt===0) $summeErm = 0;
        if($user->bestaetigt==8)  $summeErm = $summe * 0.8;

        $zusatzkosten = 6.5;
        if($user->pauschale>0) $zusatzkosten += 10.5;

        /*
        $buchtitel = Buecherliste::where('jahrgang', $jg)->first()->buchtitel;  

        foreach($buchtitel as $bt) {
            $bw = $user->buchwahlen()->where('buchtitel_id', $bt->id)->first();
            if($bw!=null) {
                $bt['wahl']    = $bw->wahl;
                $bt['wahl_id'] = $bw->id;
            } else {
                $bt['wahl'] = 4;
            }

            $bt['ausgeliehen'] = $buecher->contains('buchtitel_id', $bt->id) ? 1 : 0;
        }
        */

        return view('user/buecher/index', compact('klasse', 'user', 'buecher', 'summe', 'summeErm', 'zusatzkosten'));
    }
}