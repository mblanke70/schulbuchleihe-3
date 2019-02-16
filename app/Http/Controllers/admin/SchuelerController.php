<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

use App\Ausleiher;
use App\Schueler;
use App\Schuljahr;

class SchuelerController extends Controller
{
    /**
     * Display index page and process dataTable ajax request.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schuljahr  = Schuljahr::where('aktiv', '1')->first();

        return view('admin/ausleiher/index', compact('schuljahr'));
    }

    public function getAusleiherData()
    {        
        // nur Ausleiher aus Klassen, die in Jahrgängen sind, die zum aktuellen Schuljahr gehören
        $schueler = Schueler::with('user', 'klasse')->get() ; 

        return Datatables::of($schueler)
            ->addColumn('action', function ($ausleiher) {
                return '
                    <a href="'.url('admin/ausleiher/'.$schueler->id.'/edit').'" class="btn btn-xs btn-primary">
                        <i class="glyphicon glyphicon-edit"></i> Edit
                    </a> 

                    <a href="#delete-'.$schueler->id.'" class="btn btn-xs btn-danger">
                        <i class="glyphicon glyphicon-trash"></i> Delete
                    </a>';
            })
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
