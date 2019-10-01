<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\File;

class BuchtitelVonISBN extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return ('Buchtitel von ISBN');
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
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

        /*
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
        */ 
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
