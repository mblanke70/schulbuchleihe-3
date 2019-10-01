<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Buch;
use App\Buchtitel;

class BuchController extends Controller
{    
    public function inventarisieren(Request $request)
    {
        request()->validate([
            'buch_id' => 'required | exists:buecher,id'
        ], [
            'buch_id.required' => 'Es wurde keine Buch-ID angegeben.',
            'buch_id.exists'   => 'Die angegebene Buch-ID existiert nicht.', 
        ]);

        $buch = Buch::withTrashed()->find($request->buch_id);

        $buch->inventur = now();
        $buch->save();

        return view('admin/buecher/inventur', compact('buch'));
    }
}