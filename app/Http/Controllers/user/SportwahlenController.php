<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use Auth;

use App\Sportkurs;
use App\Sportwahl;
use App\Sportkursthema;

class SportwahlenController extends Controller
{
    /*
	public function __construct()
    {
        $this->middleware('user');
    }
    */

    public function index()
    {
    	$user = Auth::user();

		$sportwahl = Sportwahl::where( 'email', $user->email )->first();

	    if( $sportwahl == null )
	    {
	    	return redirect('user/sportwahlen/wahlbogen');
	    }
	    else
	    {
	    	return view('user/sportwahlen/index', compact('sportwahl', 'user'));
	    }
    }

    public function zeigeWahlbogen()
    {
       	$user = Auth::user();

    	$sportkurse = Sportkurs::all();

    	$semester = array();
    	
    	for($i=1; $i<=4; $i++)
    	{
    		$semester[$i] = array();
    		$semester[$i][0] = array();
			$semester[$i][1] = array();
    	}

    	$semester[1]["name"] = "12/1";
    	$semester[2]["name"] = "12/2";
    	$semester[3]["name"] = "13/1";
    	$semester[4]["name"] = "13/2";

		foreach($sportkurse as $kurs)
		{
			$semester[$kurs->semester][$kurs->bewegungsfeld][$kurs->pos] = $kurs;
		}

		$ersatz = array();

		$ersatz[0] = [
			"a0" => "Turnen und Trampolin",
			"a1" => "Rudern / Fitness",
			"a2" => "Gymnastik: Grundlegende Bewegungsformen",
			"a3" => "Leichtathletik / Fitness",
			"a4" => "Schwimmen",
			"a5" => "Alpiner Skilauf",
			"a6" => "Orientierungslauf",
			"a7" => "Tanz: Gestaltung von Bewegung",
            "a8" => "Fitness / Ausdauer"
		];

		$ersatz[1] = [
			"b0" => "Tennis",
			"b1" => "Badminton",
			"b2" => "Volleyball",
			//"b3" => "Badminton / Tennis",
			"b4" => "Badminton / Tischtennis",
			//"b5" => "Tischtennis",
			"b6" => "Hockey / Handball",
			"b7" => "Endzonenspiele: z.B. Ultimate Frisbee",
			"b8" => "Fußball",
			"b9" => "Basketball",
		];

    	return view('user/sportwahlen/wahlbogen', compact('semester', 'ersatz', 'user'));
    }

    public function speichereWahlbogen(Request $request)
    {
       	$user = Auth::user();

		$rules = [
            'wahl' => 'required|array|size:4|sum',
            'ersatzwahl' => 'size:2',
  	    	'ersatzwahl.*' => 'required',
		];

		$messages = [
			'wahl.required' 
				=> 'In jedem Semester muss ein Sportkurs belegt werden.',
		    'wahl.sum'   
		    	=> 'Es müssen 2 Sportkurse aus Bewegungsfeld A und 2 Sportkurse aus Bewegungsfeld B belegt werden.',
		    'wahl.size'     
		    	=> 'In jedem Semester muss ein Sportkurs belegt werden',
		    'ersatzwahl.*.required' 
                => 'In jedem Bewegungsfeld muss eine Ersatzwahl angegeben werden.',
            'ersatzwahl.size' 
		    	=> 'Es müssen 2 Ersatzwahlen, eine aus jedem Bewegungsfeld, angegeben werden.',
		];

        //dd($request->ersatzwahl[0]);

    	$validator = Validator::make($request->all(), $rules, $messages)->validate();

    	$wahlen = array();
    	for($i=0; $i<4; $i++)
    	{
  	    	$wahlen[$i] = Sportkurs::find($request->wahl[$i]);
		}

		$sportwahl = Sportwahl::where( 'email', $user->email )->first();
        
        /*
         *  Checks to see if a user exists. If not we need to create the
         *  user in the database before logging them in.
         */
        
        if( $sportwahl == null )
        {
	        $sportwahl = new Sportwahl;
            $sportwahl->email    = $user->email;
        	$sportwahl->nachname = $user->nachname;
        	$sportwahl->vorname  = $user->vorname;
        	$sportwahl->klasse   = $user->klasse;
        }
        
        $sportwahl->sem1 = $wahlen[0]->titel;
        $sportwahl->sem2 = $wahlen[1]->titel;
        $sportwahl->sem3 = $wahlen[2]->titel;
        $sportwahl->sem4 = $wahlen[3]->titel;

        $a = Sportkursthema::where('code', $request->ersatzwahl[0])->first();
        $sportwahl->subA = $a->titel;
        $b = Sportkursthema::where('code', $request->ersatzwahl[1])->first();
        $sportwahl->subB = $b->titel;

        $sportwahl->save();

		return redirect('user/sportwahlen');
    }
}