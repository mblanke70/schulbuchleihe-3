<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Buecherliste;
use App\Buchtitel;
use App\Buchgruppe;

class BuecherlisteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buecherlisten = Buecherliste::all();

        $bl = $buecherlisten->first();
        
        return view('admin/buecherlisten/index', compact('buecherlisten'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin/buecherlisten/create');
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

        $buecherliste = new Buecherliste;

        $buecherliste->jahrgang  = $request->jahrgang;
        $buecherliste->name      = $request->name;
        $buecherliste->Schuljahr = $request->schuljahr;

        $buecherliste->save();

        return redirect()->route('buecherlisten.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $buecherliste = Buecherliste::findOrFail($id);
        $booktitlesAttached = $buecherliste->buchtitel;
        $booktitlesNotAttached = Buchtitel::all()->diff($booktitlesAttached);

        $buchgruppen = Buchgruppe::with('fach')->where('buecherliste_id', $id)->get();

        return view('admin/buecherlisten/show', compact('buecherliste', 'booktitlesAttached', 'booktitlesNotAttached', 'buchgruppen'));
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
        $buecherliste = Buecherliste::findOrFail($id);
        $buecherliste->buchtitel()->detach();
        $buecherliste->delete();
   
        return redirect()->route('buecherlisten.index');
    }

    /**
     * Attach the specified resource.

     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function attach(Request $request, $id)
    {
        $data = array(
            'ausleihbar'    => $request->ausleihbar,
            'verlaengerbar' => $request->verlaengerbar,
            'buchgruppe'    => $request->buchgruppe,
        );

        Buecherliste::find($id)->buchtitel()->attach($request->bid, $data);

        return redirect()->route('buecherlisten.show', ['id' => $id]);
    }

    /**
     * Detach the specified resource.

     * @param  int  $booklist_id
     * @param  int  $booktitle_id
     * @return \Illuminate\Http\Response
     */
    public function detach($buecherliste_id, $buchtitel_id)
    {
        Buecherliste::find($buecherliste_id)->buchtitel()->detach($buchtitel_id);

        return redirect()->route('buecherlisten.show', ['id' => $buecherliste_id]);
    }
}
