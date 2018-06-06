<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Abfrage;
use App\AbfrageAntwort;
use App\Jahrgang;
use App\Buecherliste;
use App\Fach;
use App\Buchgruppe;

class AbfrageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $abfragen = Abfrage::all()->sortBy('jahrgang');
        
        return view('admin/abfragen/index', compact('abfragen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jahrgang = Jahrgang::all();
        return view('admin/abfragen/create', compact('jahrgang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request...
        $abfrage = new Abfrage;
        $abfrage->parent_id = $request->parent_id;
        $abfrage->titel     = $request->titel;
        $abfrage->jahrgang  = $request->jahrgang;
        $abfrage->save();

        if($abfrage->parent_id > 0)
        {
            $abfrage_parent = Abfrage::findOrFail($abfrage->parent_id);
            $abfrage_parent->child_id = $abfrage->id;
            $abfrage_parent->save();
        }

        return redirect()->route('abfragen.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $abfrage = Abfrage::findOrFail($id);
        $jg = $abfrage->jahrgang;
        $buecherliste = Buecherliste::where('jahrgang', $abfrage->jahrgang)->first();

        if(!empty($buecherliste)) $buchtitelAttached = $buecherliste->buchtitel;

        $antworten = $abfrage->antworten;

        $faecher = Fach::all();
        $buchgruppen = Buchgruppe::whereHas('buecherliste', function($query) use ($jg) {
            $query->where('jahrgang', '=', $jg);        
        })->get();

        return view('admin/abfragen/show', compact('abfrage', 'antworten', 'buchtitelAttached', 'faecher', 'buchgruppen'));
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
        $abfrage = Abfrage::findOrFail($id);
        $abfrage->antworten()->delete();
        $abfrage->delete();
   
        return redirect()->route('abfragen.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function attach(Request $request, $id)
    {
         // Validate the request...
        $antwort = new AbfrageAntwort;
        $antwort->abfrage_id = $id;
        $antwort->titel      = $request->titel;
        $antwort->wert       = $request->wert;
        $antwort->save();

        //show($id);
        return redirect()->route('abfragen.show', $id);
    }

    public function detach($id)
    {

    }
}
