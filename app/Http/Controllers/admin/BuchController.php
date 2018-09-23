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
            $buch->leihgebuehr     = 0;
            $buch->neupreis        = $request->neupreis;
            $buch->ausgeliehen     = 0;
            $buch->vorbesitzerzahl = 0;
            $buch->aufnahmedatum   = date('Y-m-d');

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
        //
    }

    public function printLabel($id)
    {
        $buch = Buch::findOrFail($id);

        //dd($buch);

        $pdf = \PDF::loadView('admin.buecher.pdf.label', compact('buch'))
            ->setOption('page-width'   , '105.0')
            ->setOption('page-height'  , '48.0')
            ->setOption('margin-bottom', '4mm')
            ->setOption('margin-top'   , '4mm')
            ->setOption('margin-right' , '4mm')
            ->setOption('margin-left'  , '4mm');
    
        return $pdf->inline();
    }
}