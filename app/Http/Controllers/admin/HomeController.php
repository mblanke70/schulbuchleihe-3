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
        $users = User::all();

        $anz_buecher = Buch::all()->count();

        $gewaehlt = $users->where('fertig', 1)
                        ->sortByDesc('updated_at');
		
        $nichtGewaehlt = $users->where('fertig', 0)
                            ->where('is_admin', 0)
                            ->sortBy('klasse');

        return view('admin/home/index', 
            compact('anz_buecher', 'gewaehlt', 'nichtGewaehlt'));
    }
}