<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Buchtitel;
use App\Buch;
use App\BuchUser;
use App\User;

class AuswertungController extends Controller
{   
    public function index()
    {
        $buchtitel = Buchtitel::all();
        
        return view('admin/auswertung/index', compact('buchtitel'));
    }

    public function zeigeBankeinzug()
    {
        $schueler = User::where('is_admin', 0)->get();

        foreach($schueler as $user)
        {
	        $klasse   = $user->klassengruppe;
	        $buecher  = $user->buecher;
	        $summe    = $buecher->sum('leihgebuehr');
	        
	        $summeErm = $summe;
	        if($user->bestaetigt===0) $summeErm = 0;
	        if($user->bestaetigt==8)  $summeErm = $summe * 0.8;

	        $zusatzkosten = 6.5;
	        if($user->pauschale>0) $zusatzkosten += 10.5;

	        $user->zusatzkosten =  $zusatzkosten;
	        $user->summe        = $summe;
	        $user->summeErm     = $summeErm;
	        $user->gesamt       = $summeErm + $zusatzkosten;
	    }

	    //dd($schueler[10]);
	    
	    return view('admin/auswertung/bankeinzug/index', compact('schueler'));
    }
}
