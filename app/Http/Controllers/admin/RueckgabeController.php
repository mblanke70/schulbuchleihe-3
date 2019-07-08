<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Buch;
use App\Schueler;
use App\BuchHistorie;
use Carbon\Carbon;
use Validator;
use App\Rules\BuchAusgeliehen;
use App\Rules\BuchcodeExistiert;
use App\Rules\BuchNichtVerlaengert;
use App\Rules\BuchGehoertAusleiher;

class RueckgabeController extends Controller
{
    public function index()
    {
        return view('admin/rueckgabe/index');
    }

    public function waehleAusleiher(Request $request)
    {
        $buch = Buch::find($request->buch_id);  

        // Ausleiher kann nicht ermittelt werden, Abbruch mit Fehlermeldung...
        $validator = Validator::make(
            $request->all(), 
            [
                'buch_id' => [
                    'required',
                    new BuchcodeExistiert($buch),
                    new BuchAusgeliehen($buch),
                ],
            ], [
                'buch_id.required' => 'Bitte einen Buch-Code eingeben.',
            ]
        );

        if($validator->fails()) {
            return redirect('admin/rueckgabe/')
                ->withErrors($validator->errors())
                ->withInput();
        }

 
        $ausleiher = $buch->ausleiher;
        
        if ( $ausleiher ) 
        {
            return redirect('admin/rueckgabe/' . $ausleiher->id);
        }        

        return redirect('admin/rueckgabe/index');
    }

    public function zeigeAusleiher($ausleiher)
    {
        $ausleiher = Schueler::find($ausleiher);

        $buecher = $ausleiher->buecher;

        return view('admin/rueckgabe/zeigeSchueler', compact('buecher', 'ausleiher'));
    }    

    /*
     * Rückgabe eines Buches
     */
    public function zuruecknehmen(Request $request, $ausleiher_id)
    {
        $buch = Buch::find($request->buch_id);

        // Rückgabe nicht möglich, Abbruch mit Fehlermeldung...
        $validator = Validator::make(
            $request->all(), 
            [
                'buch_id' => [
                    'required',
                    new BuchcodeExistiert($buch),
                    new BuchAusgeliehen($buch),
                    new BuchNichtVerlaengert($buch),
                    new BuchGehoertAusleiher($buch, $ausleiher_id),
                ],
            ], [
                'buch_id.required' => 'Bitte einen Buch-Code eingeben.',
            ]
        );

        if($validator->fails()) {
            return redirect('admin/rueckgabe/' . $ausleiher_id)
                ->withErrors($validator->errors())
                ->withInput();
        }
        
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

        // Aktualisierte Bücherliste holen
        $buecher = $ausleiher->buecher()->get();
    
        return view('admin/rueckgabe/zeigeSchueler', compact('buecher', 'ausleiher', 'buch'));
    }

    /*
     * Soeben zurückgenommenes Buch löschen
     */
    public function loeschen(Request $request, $ausleiher_id, $buch_id)
    {
        $buch = Buch::find($buch_id);
        $buch->delete();

        return redirect('admin/rueckgabe/' . $ausleiher_id);
    }
}
