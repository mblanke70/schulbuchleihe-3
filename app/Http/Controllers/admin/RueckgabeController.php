<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Buch;
use App\BuchHistorie;
use Carbon\Carbon;

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

        if ( $ausleiher ) {

            // Eintrag in Buchhistorie
            $eintrag = new BuchHistorie;
            $eintrag->buch_id   = $buch->id;
            $eintrag->titel     = $buch->buchtitel->titel;
            $eintrag->nachname  = $ausleiher->nachname;
            $eintrag->vorname   = $ausleiher->vorname;
            $eintrag->email     = $ausleiher->user->email;
            
            if($buch->ausleiher_type == 'App\Schueler')
            {
                $eintrag->klasse    = $ausleiher->klasse->bezeichnung;
                $eintrag->schuljahr = $ausleiher->klasse->jahrgang->schuljahr->schuljahr;
            }
            
            $eintrag->ausgabe   = $buch->ausleiher_ausgabe;
            $eintrag->rueckgabe = Carbon::now();
            $eintrag->save();

            // Leihe beenden
            $buch->ausleiher_id      = null;
            $buch->ausleiher_type    = null;
            $buch->ausleiher_ausgabe = null;
            $buch->save();

            $buecher = $ausleiher->buecher()->get();
        }

        return view('admin/rueckgabe/index', compact('buecher', 'ausleiher', 'buch'));
    }
}
