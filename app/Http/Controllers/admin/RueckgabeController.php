<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Buch;
use App\Schueler;
use App\BuchHistorie;
use App\Rechnung;
use App\RechnungPosition;

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
        
        return redirect('admin/rueckgabe/' . $ausleiher->id);
    }

    public function zeigeAusleiher($ausleiher)
    {
        $ausleiher = Schueler::find($ausleiher);

        $buecher = $ausleiher->buecher;
        $user    = $ausleiher->user;

        $ausleiher_neu = null;
        if(!empty($user) && $ausleiher->klasse->jahrgang->id < 22){
            $ausleiher_neu = $user->schueler->where('jahrgang_id','>', 21)->first();
        }

        return view('admin/rueckgabe/zeigeSchueler', 
            compact('buecher', 'ausleiher', 'ausleiher_neu'));
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
                    //new BuchNichtVerlaengert($buch),
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

        $ausleiher = $buch->ausleiher;
        
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
        $buecher = $ausleiher->buecher;

        // Schüler aus dem nächsten Schuljahr holen
        $user = $ausleiher->user;
        
        $ausleiher_neu = null;
        if(!empty($user)) {
            $ausleiher_neu = $user->schueler->where('jahrgang_id','>', 21)->first();
        }
    
        return view('admin/rueckgabe/zeigeSchueler', 
            compact('buecher', 'ausleiher', 'ausleiher_neu', 'buch'));
    }

    /*
     * Soeben zurückgenommenes Buch löschen
     */
    public function verlaengern(Request $request, $schueler_id, $buch_id)
    {
        $buch     = Buch::find($buch_id);
        $schueler = Schueler::find($schueler_id);

        // Schüler aus dem nächsten Schuljahr holen
        $user = $schueler->user;
        if(!empty($user)) {
            $schueler_neu = $user->schueler->where('jahrgang_id','>', 21)->first();
        
            if(!empty($schueler_neu)) {
             
                // BuchHistorien-Eintrag machen (Buch zurückgeben)
                $eintrag = new BuchHistorie;
                $eintrag->buch_id   = $buch->id;
                $eintrag->titel     = $buch->buchtitel->titel;
                $eintrag->nachname  = $schueler->nachname;
                $eintrag->vorname   = $schueler->vorname;
                $eintrag->email     = $schueler->user->email;
                $eintrag->klasse    = $schueler->klasse->bezeichnung;
                $eintrag->schuljahr = $schueler->klasse->jahrgang->schuljahr->schuljahr;
                $eintrag->ausgabe   = $buch->ausleiher_ausgabe;
                $eintrag->rueckgabe = Carbon::now();
                $eintrag->save();

                // Buch neu ausleihen
                $schueler_neu->buecher()->save($buch);  
                $buch->ausleiher_ausgabe = Carbon::now();
                $buch->save();

                // wenn Buch zum Leihen bestellt, muss Bestellung geändert werden!
            }
        }

        return redirect('admin/rueckgabe/' . $schueler_id);
    }    

    /*
     * Soeben zurückgenommenes Buch löschen
     */
    public function loeschen(Request $request, $schueler_id, $buch_id)
    {
        $buch = Buch::find($buch_id);

        if($request->exists('rechnung'))
        {
            $buch     = Buch::find($buch_id);
            $schueler = Schueler::find($schueler_id);
            $familie  = $schueler->user->familie;

            $rechnung = new Rechnung;

            $rechnung->s_id            = $schueler->id;
            $rechnung->s_vorname       = $schueler->vorname;
            $rechnung->s_nachname      = $schueler->nachname;
            $rechnung->s_geschlecht    = $schueler->geschlecht;
            $rechnung->s_schuljahr     = $schueler->klasse->jahrgang->schuljahr->schuljahr;

            $rechnung->re_anrede       = $familie->re_anrede;
            $rechnung->re_vorname      = $familie->re_vorname;
            $rechnung->re_nachname     = $familie->re_nachname;
            $rechnung->re_strasse      = $familie->re_strasse_nr;
            $rechnung->re_plz          = $familie->re_plz;
            $rechnung->re_strasse      = $familie->re_strasse_nr;
            $rechnung->re_ort          = $familie->re_ort;
            $rechnung->re_datum        = Carbon::now();
            $rechnung->re_faelligkeit  = Carbon::now()->addDays(30);

            $rechnung->save();

            $summe = 0;

            $btsj = $buch->buchtitel->buchtitelSchuljahr2($schueler->klasse->jahrgang->schuljahr_id)->first();

            $jahr      = date_format($buch->aufnahme, 'Y');
            $kaufpreis = ceil($btsj->kaufpreis);
            $leihpreis = $btsj->leihpreis;
            $restwert  = $kaufpreis - (2020 - $jahr) * $leihpreis;
                    
            if($restwert<0) $restwert = 0;
            $summe += $restwert;

            $posten = new RechnungPosition;

            $posten->buch_id     = $buch->id;
            $posten->titel       = $buch->buchtitel->titel;
            $posten->kaufpreis   = $kaufpreis;
            $posten->leihpreis   = $leihpreis;
            $posten->aufnahme    = $buch->aufnahme;
            $posten->restwert    = $restwert;
            $posten->rechnung_id = $rechnung->id; 

            $posten->save();

            $rechnung->re_summe = $summe;
            $rechnung->save();
        }

        // Buch permanent löschen (KEIN soft delete)    
        $buch->forceDelete();

        return redirect('admin/rueckgabe/' . $schueler_id);
    }
}
