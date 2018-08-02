<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

use App\User;
use App\Klasse;

class UserController extends Controller
{
    public function versetzen()
    {
        $klassen = Klasse::all();

        return view('admin/schueler/versetzen', compact('klassen'));
    }

    public function versetzenSpeichern(Request $request)
    {
        $klasse       = $request->klasse;
        $zielklasse   = $request->zielklasse;
        $zieljahrgang = substr($zielklasse, 0, 2);

        $schueler = User::where('klasse', $klasse)->get();

        foreach($schueler as $user)
        {
            $user->klasse   = $zielklasse;
            $user->jahrgang = $zieljahrgang;
            $user->save();
        }

        return redirect()->route('schueler.index');
    }

    /**
     * Display index page and process dataTable ajax request.
     *
     * @param \App\DataTables\UsersDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.schueler.index');
    }

    
    public function getUserData()
    {        
        $users = User::select(['id', 'nachname', 'vorname', 'klasse', 'iserv_id']);

        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return '
                    <a href="'.url('admin/schueler/'.$user->id.'/edit').'" class="btn btn-xs btn-primary">
                        <i class="glyphicon glyphicon-edit"></i> Edit
                    </a> 

                    <a href="#delete-'.$user->id.'" class="btn btn-xs btn-danger">
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
        $klassen = Klasse::all();

        return view('admin/schueler/create', compact('klassen'));
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
        
        $schueler = new User;
        $schueler->vorname   = $request->vorname;
        $schueler->nachname  = $request->nachname;
        $schueler->klasse    = $request->klasse;
        $schueler->jahrgang  = substr($request->klasse, 0, 2);
        $schueler->iserv_id  = $request->iserv_id;

        $schueler->save();

        return redirect()->route('schueler.index');
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
        $klassen = Klasse::all();
        $user = User::findOrFail($id);

        return view('admin/schueler/edit', compact('user', 'klassen'));
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
        $user = User::findOrFail($id);

        $user->nachname  = $request->nachname;
        $user->vorname   = $request->vorname;
        $user->klasse    = $request->klasse;
        $user->iserv_id  = $request->iserv_id;

        $user->save();

        return redirect()->route('schueler.index');
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
