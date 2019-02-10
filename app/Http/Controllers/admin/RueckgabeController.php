<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Buch;
use App\BuchHistorie;

class RueckgabeController extends Controller
{
    public function index()
    {
        return view('admin/rueckgabe/index');
    }

    /*
     * Rückgabe eines Buches
     */
    public function zuruecknehmen(Request $request)
    {
        request()->validate([
            'buch_id' => 'required | exists:buecher,id'
        ], [
            'buch_id.required' => 'Es wurde keine Buch-ID angegeben.',
            'buch_id.exists'   => 'Die angegebene Buch-ID existiert nicht.', 
        ]);

        $buch      = Buch::find($request->buch_id);
        $ausleiher = $buch->ausleiher;

        if($ausleiher) {
            $eintrag = new BuchHistorie();
            $eintrag->buch_id   = $buch->id;
            $eintrag->vorname   = $ausleiher->user->vorname;
            $eintrag->nachname  = $ausleiher->user->nachname;
            $eintrag->klasse    = $ausleiher->klasse->bezeichnung;
            $eintrag->ausgabe   = $buch->ausgabe;
            $eintrag->rueckgabe = now();
            $eintrag->save();

            /*
            $buch->ausleiher_id = null;
            $buch->ausgabe      = null;
            $buch->save();
            */
        }
            
        return redirect('admin/rueckgabe');
    }
}
