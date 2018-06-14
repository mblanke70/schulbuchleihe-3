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

        session()->forget('auswahl');
        
        return view('admin/ausleihe/index', compact('klassen', 'jahrgaenge'));
    }

    public function zeigeKlasse($id)
    {        
        $klasse   = Klasse::find($id);
        $schueler = User::where('klasse', $klasse->bezeichnung)->get();#

        session()->forget('auswahl');
        
        return view('admin/ausleihe/klasse', compact('klasse', 'schueler'));
    }

    public function zeigeSchueler($klasse_id, $user_id)
    {
        $klasse  = Klasse::find($klasse_id);
        $user    = User::find($user_id);
        
        $buecher    = $user->buecher;
        $buchwahlen = $user->buchwahlen()->where('wahl', '<', 3)->sortByDesc('wahl');

        foreach($buecher as $b)
        {
            $ausgeliehen[$b->buchtitel->id] = $b->id;
        }

        foreach($buchwahlen as $bw)
        {      
            $bw['leihstatus'] = 0;
            $bw['buch_id']    = 0;
            
            if(isset($ausgeliehen) && array_key_exists($bw->buchtitel_id, $ausgeliehen))
            {     
                $bw['leihstatus'] =  1;
                $bw['buch_id']    =  $ausgeliehen[$bw->buchtitel_id];
            }
        }

        /*
        $auswahl = session('auswahl');
        if(isset($auswahl))
        {
            $auswahlbuecher = Buch::whereIn('id', $auswahl)->get();
        }
        */

        return view('admin/ausleihe/schueler', compact('klasse', 'user', 'buecher', 'buchwahlen'));
    }

    public function ausleihen(Request $request, $klasse_id, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'buch_id' => [
                'required',
                function($attribute, $value, $fail) use ($user_id) {
                    $b = Buch::find($value);
                    if($b==null) {
                         return $fail('Es existiert kein Buch mit diesem Code.');
                    }
                    else {
                        $bt   = $b->buchtitel->id;
                        $user = User::find($user_id);
                        $jg   = $user->jahrgang; if($jg!=20) $jg++;

                        $leihbuecher = $user->buecher()->get();
                        if($leihbuecher->contains('buchtitel.id', $bt)) {
                            return $fail('Dieser Schüler hat das Buch bereits ausgeliehen.');
                        }

                        $buecherliste = Buecherliste::where('jahrgang', $jg)->first();
                        if(!$buecherliste->buchtitel->contains('id', $bt)) {
                            return $fail('Der diesem Buch zugeordnete Buchtitel steht nicht auf der Bücherliste des Jahrgangs '. $jg.'.');
                        }

                        $buchwahlen = $user->buchwahlen()->where('wahl', '=', 3);
                        if($buchwahlen->contains('buchtitel_id', $bt)) {
                            return $fail('Dieses Buch ist als Kaufbuch ausgewählt worden.');
                        }                        
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return redirect('admin/ausleihe/'.$klasse_id.'/'.$user_id)
                ->withErrors($validator)
                ->withInput();
        }
    
        $user = User::find($user_id);
        $buch = Buch::find($request->buch_id);
        
        $user->buecher()->attach($buch, ['ausgabe' => now() ]);

        
        /*
        $auswahl = session('auswahl');
        if($auswahl != null)
        {
            foreach($auswahl as $buch_id)
            {
                $buch = Buch::find($buch_id);
                $user->buecher()->attach($buch, ['ausgabe' => now() ]);
            }

            session()->forget('auswahl');
        }
        */

        return redirect('admin/ausleihe/'.$klasse_id.'/'.$user_id);
    }
   
    public function loeschen(Request $request, $klasse_id, $user_id)
    {
        $user = User::find($user_id);
        $buch = Buch::find($request->buch_id);

        $user->buecher()->detach($buch);
        
        return redirect('admin/ausleihe/'.$klasse_id.'/'.$user_id);
    }

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


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
