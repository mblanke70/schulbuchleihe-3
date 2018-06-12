<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Buch;
use App\Buchtitel;
use App\Fach;

class BuchtitelController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buchtitel = Buchtitel::all(); //sortable()->paginate(8);
        
        return view('admin/buchtitel/index', compact('buchtitel'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $faecher = Fach::all();

        return view('admin/buchtitel/create', compact('faecher'));
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
        $buchtitel = new Buchtitel;
        $buchtitel->titel    = $request->titel;
        $buchtitel->fach     = $request->fach;
        $buchtitel->verlag   = $request->verlag;
        $buchtitel->preis    = $request->preis;
        $buchtitel->kennung  = $request->kennung;
        $buchtitel->isbn     = $request->isbn;
        $buchtitel->save();

        return redirect()->route('buchtitel.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $buchtitel = Buchtitel::findOrFail($id);
        $buecher = $buchtitel->buecher;
        return view('admin/buchtitel/show', compact('buchtitel', 'buecher'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $buchtitel = Buchtitel::findOrFail($id);
        return view('admin/buchtitel/edit', compact('buchtitel'));
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
        $buchtitel = Buchtitel::findOrFail($id);
        $buchtitel->titel    = $request->titel;
        $buchtitel->verlag   = $request->verlag;
        $buchtitel->preis    = $request->preis;
        $buchtitel->kennung  = $request->kennung;
        $buchtitel->isbn     = $request->isbn;
        $buchtitel->save();

        return redirect()->route('buchtitel.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buchtitel = Buchtitel::findOrFail($id);
        $buchtitel->buecher()->delete();
        //$buchtitel->booklists()->detach();
        $buchtitel->delete();
        
        return redirect()->route('buchtitel.index');
    }
}
