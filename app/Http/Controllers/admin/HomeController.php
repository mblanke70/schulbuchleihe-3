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
        return view('admin/home/index', compact('users'));
    }
}
