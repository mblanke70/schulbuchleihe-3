<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Buch;
use App\Buchtitel;

class BuchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buecher = Buch::with('buchtitel')->get();  // eager loading

        //dd($buecher->first()->buchtitel->kennung);

        return view('admin/buecher/index', compact('buecher'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $buchtitel = Buchtitel::all();
        return view('admin/buecher/create', compact('buchtitel'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $anz = $request->anzahl;

        for($i=0; $i<$anz; $i++)
        {
            $buch = new Buch;
            $buch->buchtitel_id    = $request->buchtitel_id;
            $buch->neupreis        = $request->neupreis;
            $buch->aufnahme        = date('Y-m-d');

            $buchtitel = Buchtitel::find($request->buchtitel_id);
            $buchtitel->buecher()->save($buch);
        }
        
        return redirect()->route('buecher.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $buch = Buch::findOrFail($id);
        // aus Buchtitel-Beziehung löschen???
        // sonst noch was damit machen? Ins Archiv verschieben?
        // prüfen, ob ausgeliehen?
        // $buch->delete();
        
        return redirect()->route('buecher.index');
    }

    public function printLabel($id)
    {
        $buch = Buch::findOrFail($id);

        $pdf = \PDF::loadView('admin.buecher.pdf.label', compact('buch'))
            ->setOption('page-width'   , '105.0')
            ->setOption('page-height'  , '48.0')
            ->setOption('margin-bottom', '4mm')
            ->setOption('margin-top'   , '4mm')
            ->setOption('margin-right' , '4mm')
            ->setOption('margin-left'  , '4mm');
    
        return $pdf->inline();
    }

    public function inventarisieren(Request $request)
    {
        request()->validate([
            'buch_id' => 'required | exists:buecher,id'
        ], [
            'buch_id.required' => 'Es wurde keine Buch-ID angegeben.',
            'buch_id.exists'   => 'Die angegebene Buch-ID existiert nicht.', 
        ]);

        $buch = Buch::find($request->buch_id);

        $buch->inventur = now();
        $buch->save();

        return view('admin/buecher/inventur', compact('buch'));
    }
}