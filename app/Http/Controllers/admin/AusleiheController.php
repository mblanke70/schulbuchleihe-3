<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AusleiheRequest;
use Validator;

use App\User;
use App\Klasse;
use App\Buch;
use App\Jahrgang;
use App\Buecherliste;
use App\Buchwahl;

use App\Rules\BuchtitelNichtAusgeliehen;
use App\Rules\BuchNichtAusgeliehen;
use App\Rules\BuchcodeExistiert;
use App\Rules\BuchtitelIstAufBuecherliste;


class AusleiheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $klassen    = Klasse::all();
        $jahrgaenge = Jahrgang::all();

        return view('admin/ausleihe/index', compact('klassen', 'jahrgaenge'));
    }

    public function zeigeKlasse($id)
    {        
        $klasse   = Klasse::find($id);
        $schueler = User::where('klasse', $klasse->bezeichnung)->orderBy('nachname')->get();#

        $gruppen = $schueler->split(3);

        return view('admin/ausleihe/klasse', compact('klasse', 'schueler', 'gruppen'));
    }

    public function zeigeSchueler($klasse_id, $user_id)
    {
        $klasse  = Klasse::find($klasse_id);
        $user    = User::find($user_id);
        
        $buecher    = $user->buecher;
        //$buchwahlen = $user->buchwahlen()->where('wahl', '<', 3)->sortByDesc('wahl');
        //$buchwahlen = $user->buchwahlen()->sortBy('wahl');

        $next = $klasse->next($user);
        $prev = $klasse->prev($user);
       
        $jg = $user->jahrgang; if( $jg!=20 ) $jg++;
        $buchtitel = Buecherliste::where('jahrgang', $jg)->first()->buchtitel;  

        foreach($buchtitel as $bt) {
            $bw = $user->buchwahlen()->where('buchtitel_id', $bt->id)->first();
            if($bw!=null) {
                $bt['wahl']    = $bw->wahl;
                $bt['wahl_id'] = $bw->id;
            } else {
                $bt['wahl'] = 4;
            }

            $bt['ausgeliehen'] = $buecher->contains('buchtitel_id', $bt->id) ? 1 : 0;
        }

        return view('admin/ausleihe/schueler', compact('klasse', 'user', 'buecher', 'buchtitel', 'next', 'prev'));
    }

    public function ausleihen(Request $request, $klasse_id, $user_id)
    {
        $user = User::find($user_id);
        $buch = Buch::find($request->buch_id);

        $validator1 = Validator::make(
            $request->all(), 
            [
                'buch_id' => [
                    'required',
                    new BuchcodeExistiert($buch),
                    new BuchNichtAusgeliehen($user),
                ],
            ], 
            ['required' => 'Bitte einen Buch-Code eingeben.']
        );

        if($validator1->fails()) {
            return redirect('admin/ausleihe/'.$klasse_id.'/'.$user_id)
                ->withErrors($validator1->errors()->add('type', 'warning'))
                ->withInput();
        }

        $validator2 = Validator::make(
            $request->all(), 
            [
                'buch_id' => [
                    new BuchtitelNichtAusgeliehen($user),
                    new BuchtitelIstAufBuecherliste($user, $buch),
                ],
            ] 
        );

        if($request->confirmed==null && $validator2->fails()) {
            return redirect('admin/ausleihe/'.$klasse_id.'/'.$user_id)
                ->withErrors($validator2->errors()->add('type', 'confirm'))
                ->withInput();
        } 

        $user->buecher()->attach($buch, ['ausgabe' => now() ]);

        return redirect('admin/ausleihe/'.$klasse_id.'/'.$user_id);
    }
   
    public function loeschen(Request $request, $klasse_id, $user_id)
    {
        $user = User::find($user_id);
        $buch = Buch::find($request->buch_id);

        $user->buecher()->detach($buch);
        
        return redirect('admin/ausleihe/'.$klasse_id.'/'.$user_id);
    }

    public function aktualisieren(Request $request, $klasse_id, $user_id)
    {
        $buchwahlen = $request->wahlen;
        
        foreach($buchwahlen as $buchtitel_id => $wahl) 
        {    
            $bw = Buchwahl::where('user_id', $user_id)
                          ->where('buchtitel_id', $buchtitel_id)
                          ->first();
            if($wahl!=4)
            {
                if($bw) {
                    $bw['wahl'] = $wahl;
                    $bw->save();
                } else {
                    $buchwahl = new Buchwahl;
                    $buchwahl->user_id      = $user_id;
                    $buchwahl->buchtitel_id = $buchtitel_id;
                    $buchwahl->wahl         = $wahl;
                    $buchwahl->save();
                }
            } else {
                 if($bw) $bw->delete();
            }
        }

        return redirect('admin/ausleihe/'.$klasse_id.'/'.$user_id);
    }

/*
    public function add(Request $request, $klasse_id, $user_id)
    {
        $buch_id = $request->buch_id;
        if(isset($buch_id))
        {
            if( session('auswahl')==null || !in_array($buch_id, session('auswahl')))
            {
                if(Buch::find($buch_id))
                {
                    session()->push('auswahl', $buch_id);
                }
            }
        }

        return redirect('admin/ausleihe/'.$klasse_id.'/'.$user_id);
    }

    public function remove(Request $request, $klasse_id, $user_id)
    {
        $key = array_search($request->buch_id, session('auswahl'));
        session()->forget('auswahl.'.$key);

        return redirect('admin/ausleihe/'.$klasse_id.'/'.$user_id);
    }    

*/
}
