<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Buchtitel;
use App\Buch;
use App\BuchUser;

class AuswertungController extends Controller
{   

    public function index()
    {
        $buchtitel = Buchtitel::all();
        
        return view('admin/auswertung/index', compact('buchtitel'));
    }
}
