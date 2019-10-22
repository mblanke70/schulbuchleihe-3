<?php

namespace Mb70\Buchinfo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Jahrgang;
use App\Klasse;
use App\Schueler;
use App\Buch;

class AusleiheController extends Controller
{

	public function getJahrgaenge() 
	{
		$jahrgaenge = Jahrgang::whereHas('schuljahr', function($query) {
	        $query->where('aktiv', '1'); 
	    })->get();
	 	
	 	return [
	 		'jahrgaenge' => $jahrgaenge,
	 	];
	}

	public function getKlassen($jahrgang) 
	{	
 		$jahrgang = Jahrgang::find($jahrgang);
 	
	 	return [
 			'klassen' => $jahrgang->klassen,
 		];	
	}

	public function getSchueler($jahrgang, $klasse) 
	{
		$klasse = Klasse::find($klasse);
 	
	 	return [
	 		'schueler' => $klasse->schueler,
	 	];
	}

	public function getAusleiher($jahrgang, $klasse, $schueler) 
	{
		$schueler = Schueler::find($schueler);
 	
        $buecherliste = $schueler->buecherliste();
        $buecher = $schueler->buecher;

        // Berechne Summe der Leihgebühren
        $summe = 0;
        foreach($buecher as $buch) {

        	// FEHLER wenn Buchtitel ausgeliehen, der nicht auf der Bücherliste des Schuljahres steht!!!
            $btsj = $buch->buchtitel->buchtitelSchuljahr->first();

            $leihpreis = $btsj->leihpreis;
            if($leihpreis != null)
            {
                $buch['leihpreis'] = $leihpreis;
                $summe += $leihpreis;
            }
        }

        $summeErm = $summe;
        switch($schueler->erm_bestaetigt) {
            case 1: $summeErm *= 0.8; break;
            case 2: $summeErm  = 0  ; break;
        }

	 	return [
	 		'buecher'      => $buecher,
	 		'buecherliste' => $buecherliste,
	 		'summe'        => $summe,
	 		'summeErm'     => $summeErm,
	 	];
	}

	 /**
     * Leihe ein Buch an einen Ausleiher aus.
     */
    public function ausleihen(Request $request, $jahrgang, $klasse, $schueler)
    {
        $schueler = Schueler::find($schueler);
        $buch = Buch::withTrashed()->with('buchtitel')->find($request->buchId);

        // Ausleihen nicht möglich, Abbruch mit Fehlermeldung...
        
        /*
        $validator1 = Validator::make(
            $request->all(), 
            [
                'buch_id' => [
                    'required',
                    //'exists: buecher, id',
                    //new BuchcodeExistiert($buch),
                    //new BuchNichtAusgeliehen($buch),
                ],
            ], [
                'buch_id.required' => 'Bitte einen Buch-Code eingeben.',
                //'buch_id.exists'   => 'Die angegebene Buch-ID existiert nicht.'
            ]
        );

        if($validator1->fails()) {
            
            return redirect('admin/ausleihe/'.$klasse_id.'/'.$schueler_id)
                ->withErrors($validator1->errors()->add('type', 'warning'))
                ->withInput();
        }
		*/

        // Ausleihen zwar möglich, es wird aber eine Bestätigung verlangt...
        /*
        $validator2 = Validator::make(
            $request->all(), 
            [
                'buch_id' => [
                    new BuchtitelNichtAusgeliehen($schueler, $buch),
                    new BuchtitelIstAufBuecherliste($schueler, $buch),
                    new BuchtitelIstBestellt($schueler, $buch),
                    new BuchNichtGeloescht($buch)                                 
                ],
            ] 
        );

        if($request->confirmed==null && $validator2->fails()) {
            return redirect('admin/ausleihe/'.$klasse_id.'/'.$schueler_id)
                ->withErrors($validator2->errors()->add('type', 'confirm'))
                ->withInput();
        } 
		*/

        //if($buch->trashed()) $buch->restore();

        // Buch wird ausgeliehen
        //$buch->ausleiher()->save($schueler, ['ausleiher_ausgabe' => now()]);

        
        $buch->ausleiher_id       = $schueler->id;
        $buch->ausleiher_type     = "App\Schueler";
        $buch->ausleiher_ausgabe  = now();
        $buch->save();  

        //$ausleiher->buecher()->attach($buch, ['ausgabe' => now()]);

        //return redirect('admin/ausleihe/'.$klasse_id.'/'.$schueler_id);

        return [
	 		'buch'  => $buch,
	 	];
    }  
}