<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::all();

        $gewaehlt = $users->where('fertig', 1)->sortByDesc('updated_at');
		$nichtGewaehlt = $users->where('fertig', 0)->sortBy('klasse');

        return view('admin/home/index', compact('gewaehlt', 'nichtGewaehlt'));
    }
}
