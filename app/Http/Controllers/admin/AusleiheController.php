<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Klasse;
use App\Buch;
use App\Jahrgang;

class AusleiheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $klassen = Klasse::all();
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
        $user    = User::findOrFail($user_id);
        $buecher = $user->buecher;

        $auswahl = session('auswahl');
        //dd($auswahl);
        if(isset($auswahl))
        {
            $auswahlbuecher = Buch::whereIn('id', $auswahl)->get();
        }

        return view('admin/ausleihe/schueler', compact('klasse', 'user', 'buecher', 'auswahlbuecher'));
    }

    public function ausleihen(Request $request, $klasse_id, $user_id)
    {
        $user = User::find($user_id);

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
