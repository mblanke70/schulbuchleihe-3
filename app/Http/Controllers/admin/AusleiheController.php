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
use App\BuchUser;

use App\Rules\BuchtitelNichtAusgeliehen;
use App\Rules\BuchNichtAusgeliehen;
use App\Rules\BuchcodeExistiert;
use App\Rules\BuchtitelIstAufBuecherliste;
use App\Rules\BuchtitelIstBestellt;


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
        //$jahrgaenge = Jahrgang::all();
        $jahrgaenge = Jahrgang::where('jahrgangsstufe', '>', 4)
            ->orderBy('jahrgangsstufe')
            ->get();

        //$jahrgaenge = $jahrgaenge->sortBy('jahrgangsstufe'); 

        return view('admin/ausleihe/index', compact('klassen', 'jahrgaenge'));
    }

    public function zeigeKlasse($id)
    {        
        $klasse   = Klasse::find($id);
        $schueler = User::where('klasse', $klasse->bezeichnung)->orderBy('nachname')->get();

        $gruppen = $schueler->split(3);

        return view('admin/ausleihe/klasse', compact('klasse', 'schueler', 'gruppen'));
    }

    public function zeigeSchueler($klasse_id, $user_id)
    {
        $klasse  = Klasse::find($klasse_id);
        $user    = User::find($user_id);
        
        $buecher = $user->buecher;
        $summe = 0;
        foreach($buecher as $b) {
            $summe += $b->buchtitel->leihgebuehr;
        }
        //$buchwahlen = $user->buchwahlen()->where('wahl', '<', 3)->sortByDesc('wahl');
        //$buchwahlen = $user->buchwahlen()->sortBy('wahl');

        $next = $klasse->next($user);
        $prev = $klasse->prev($user);
       
        $jg = $user->jahrgang; //if( $jg!=20 ) $jg++;
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

        return view('admin/ausleihe/schueler', compact('klasse', 'user', 'buecher', 'buchtitel', 'next', 'prev', 'summe'));
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
                    new BuchtitelIstBestellt($user, $buch),                    
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

    public function zeigeBuecherliste($klasse_id, $user_id)
    {
        $klasse  = Klasse::find($klasse_id);
        $user    = User::find($user_id);
        $buecher = $user->buecher;

        $jg = $user->jahrgang; 
        $buchtitel = Buecherliste::where('jahrgang', $jg)->first()->buchtitel;  

        foreach($buchtitel as $bt) {
            $bw = $user->buchwahlen()->where('buchtitel_id', $bt->id)->first();
            if($bw!=null) {
                $bt['wahl'] = $bw->wahl;
            } else {
                $bt['wahl'] = 4;
            }

            $bt['ausgeliehen'] = $buecher->contains('buchtitel_id', $bt->id) ? 1 : 0;
        }

        return view('admin/ausleihe/buecherliste', compact('klasse', 'user', 'buchtitel'));
    }

    public function zeigeErmaessigungen()
    {
        $schueler = User::where('ermaessigung', '<', 10)->orderBy('nachname')->get();

        return view('admin/ausleihe/ermaessigungen', compact('schueler'));
    }

    public function bestaetigeErmaessigungen(Request $request, $user_id)
    {
        $user = User::find($user_id);

        $user->bestaetigt = $request->ermaessigung;
        $user->save();

        return redirect('admin/ausleihe/ermaessigungen');
    }

    public function bestaetigeErmaessigungen2(Request $request, $klasse_id, $user_id)
    {
        $user = User::find($user_id);

        $user->bestaetigt = $request->ermaessigung;
        $user->save();

        return redirect('admin/ausleihe/'.$klasse_id.'/'.$user_id);
    }


    public function suchen()
    {
        $buch = null;
        return view('admin/ausleihe/buchinfo', compact('buch'));
    }

    public function zeigeBuchinfo(Request $request)
    {
        request()->validate([
            'buch_id' => 'required | exists:buecher,id'
        ], [
            'buch_id.required' => 'Es wurde keine Buch-ID angegeben.',
            'buch_id.exists'   => 'Die angegebene Buch-ID existiert nicht.', 
        ]);

        $buch = Buch::find($request->buch_id);

        $user = $buch->users()
            ->whereNull('rueckgabe')
            ->first();
        
        return view('admin/ausleihe/buchinfo', compact('buch', 'user'));
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
