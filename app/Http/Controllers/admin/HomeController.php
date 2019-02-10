<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Yajra\Datatables\Datatables;

use App\User;
use App\Buch;
use App\Ausleiher;
use App\Buchwahl;
//use App\BuchUser;
//use App\AusleiherBuch;


class HomeController extends Controller
{
    
    public function index()
    {
        /*
        $ausleiher = Ausleiher::all();
        foreach($ausleiher as $a)
        {
            if($a->erm==null)
            {
                $u = User::where('id', $a->user_id)->first();
                if($u!=null) {
                    $a->erm = $u->ermaessigung;
                    $a->save();
                }
            }
        }

        dd("done");
        */
  
    /*
        $leihen = AusleiherBuch::all();
        foreach($leihen as $l)
        {
            $b = Buch::where('id', $l->buch_id)->first();
            if($b!=null && $b->ausleiher_id==null) {
                $b->ausleiher_id = $l->ausleiher_id;
                $b->ausgabe      = $l->ausgabe;

                //dd($b);

                $b->save();
            }
        }

        dd("done");
     */   
        $users = User::all();
        $anz_buecher = Buch::all()->count();

        $gewaehlt = $users->where('fertig', 1)->sortByDesc('updated_at');
		$nichtGewaehlt = $users->where('fertig', 0)->where('is_admin', 0)->sortBy('klasse');

        return view('admin/home/index', compact('anz_buecher', 'gewaehlt', 'nichtGewaehlt'));
    }

    public function getIndexData()
    {
    	$users = User::all();
    	$nichtGewaehlt = $users->where('fertig', 0)
    						->where('is_admin', 0)
    						->sortBy('klasse');

        return Datatables::of($nichtGewaehlt)
 			->setRowClass(function ($user) {
                return $user->id % 2 == 0 ? 'alert-success' : 'alert-warning';
            })
        	->make();
    }
}