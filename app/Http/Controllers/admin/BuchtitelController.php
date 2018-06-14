<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Scriptotek\Marc\Record;

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

    public function createFromISBN($isbn)
    {
        $response = file_get_contents('https://services.dnb.de/sru/dnb?' . http_build_query([
            'version'        => '1.1',
            'operation'      => 'searchRetrieve',
            'query'          => $isbn,
            'recordSchema'   => 'MARC21-xml',
            'accessToken'    => '4259d9c9dd2bd31aa24f69c22a923591',
        ]));

        //dd($response);

        $record  = Record::fromString($response);

        $title_a = $record->getField('245')->getSubfield('a')->getData();
        $title_c = $record->getField('245')->getSubfield('c')->getData();    
        $title_n = $record->getField('245')->getSubfield('n');  

        //dd($record->getField('245')->getSubfields());

        $title   = $record->getTitle()->__toString();
        $isbns   = $record->getIsbns();

        $isbn    = $record->isbns[0]->getSubfield('9')->getData();  
    
        dd($title_n, $record->getTitle(), $title_a . " " . $title_n . " " . $title_c . " " . $isbn);

        $xmldoc = new \DOMDocument();
        $xmldoc->load("https://services.dnb.de/sru/dnb?".
            "version=1.1&".
            "operation=searchRetrieve&".
            "query=%22".$isbn."%22&".
            "recordSchema=MARC21-xml&".
            "accessToken=4259d9c9dd2bd31aa24f69c22a923591");
        
        dd($xmldoc);

        $data = array();

        $data["title"] = $xmldoc->getElementsByTagName("title")->item(0)->nodeValue;

        $nodelist = $xmldoc->getElementsByTagName("creator");
        $data["creator"] = array();
        foreach($nodelist as $creator) {
            $data["creator"][] = $creator->nodeValue;
        }

        $nodelist = $xmldoc->getElementsByTagName("publisher");
        $data["publisher"] = array();
        foreach($nodelist as $publisher) {
            $data["publisher"][] = $publisher->nodeValue;
        }

        $data["date"]      = $xmldoc->getElementsByTagName("date")->item(0)->nodeValue;

        $nodelist = $xmldoc->getElementsByTagName("identifier");
        $data["identifier"] = array();
        foreach($nodelist as $identifier) {
            $data["identifier"][] = $identifier->nodeValue;
        }

        $nodelist = $xmldoc->getElementsByTagName("subject");
        $data["subject"] = array();
        foreach($nodelist as $subject) {
            $data["subject"][] = $subject->nodeValue;
        }

        $data["format"]    = $xmldoc->getElementsByTagName("format")->item(0)->nodeValue;

        dd($xmldoc);
    }
}
