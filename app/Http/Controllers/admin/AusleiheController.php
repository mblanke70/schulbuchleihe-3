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

        return view('admin/ausleihe/index', compact('klassen', 'jahrgaenge'));
    }

    public function zeigeKlasse($id)
    {        
        $klasse   = Klasse::find($id);
        $schueler = User::where('klasse', $klasse->bezeichnung)->get();#

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
       
        $jg = $user->jahrgang; if( $jg!=20 ) $jg++;
        $buchtitel = Buecherliste::where('jahrgang', $jg)->first()->buchtitel;  

        foreach($buchtitel as $bt) {
            $bw = $user->buchwahlen()->where('buchtitel_id', $bt->id)->first();
            $bt['wahl'] = ($bw!=null) ? $bw->wahl : 4;
            $bt['ausgeliehen'] = $buecher->contains('buchtitel_id', $bt->id) ? 1 : 0;
        }

        //dd($buchtitel);

        return view('admin/ausleihe/schueler', compact('klasse', 'user', 'buecher', 'buchtitel'));
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

        return redirect('admin/ausleihe/'.$klasse_id.'/'.$user_id);
    }
   
    public function loeschen(Request $request, $klasse_id, $user_id)
    {
        $user = User::find($user_id);
        $buch = Buch::find($request->buch_id);

        //dd($user, $buch);

        $user->buecher()->detach($buch);
        
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
