<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/mail', function(){
    Mail::raw('Sending emails with Mailgun and Laravel is easy!', function($message)
    {
        $message->to('malte.blanke@urs-os.de');
    });
});
*/

Route::get('/', function () {
    return view('index');
});

/* AUTH */
Route::get('login/iserv', 'Auth\LoginController@redirectToProvider');
Route::get('login/iserv/callback', 'Auth\LoginController@handleProviderCallback');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::group(
    [  
        'prefix'     => 'admin', 
        'namespace'  => 'admin',
        'middleware' => ['admin', 'menu.admin']
    ], function()
{
    /* HOME */
    Route::get('/', 'HomeController@index' );

    /* RÜCKGABE */
    Route::get ('rueckgabe', 'RueckgabeController@index');
    Route::post('rueckgabe', 'RueckgabeController@waehleAusleiher'); 
    Route::get('rueckgabe/{ausleiher}', 'RueckgabeController@zeigeAusleiher');   
    Route::post('rueckgabe/{ausleiher}', 'RueckgabeController@zuruecknehmen'); 
    Route::post('rueckgabe/{ausleiher}/{buch}', 'RueckgabeController@loeschen');   

    /* BUCHINFO */
    Route::get('buchinfo', function () { return view('admin/ausleihe/buchinfo'); });
    Route::post('buchinfo', 'AusleiheController@zeigeBuchinfo');       

    /* INVENTUR */
    Route::get('inventur', function () { return view('admin/buecher/inventur'); });
    Route::post('inventur', 'BuchController@inventarisieren'); 

    /* AUSLEIHE */
    Route::get('ausleihe', 'AusleiheController@index');

    Route::get('ausleihe/{klasse}', 'AusleiheController@zeigeKlasse');
    Route::get('ausleihe/{klasse}/{schueler}', 'AusleiheController@zeigeSchueler');
    Route::delete('ausleihe/{klasse}/{schueler}', 'AusleiheController@remove');    
    
    Route::post('ausleihe/{klasse}/{schueler}', 'AusleiheController@ausleihen');
    Route::delete('ausleihe/{klasse}/{schueler}', 'AusleiheController@loeschen');    
    Route::put('ausleihe/{klasse}/{schueler}', 'AusleiheController@aktualisieren');
});

Route::group([
        'prefix'     => 'user', 
        'namespace'  => 'user',
        'middleware' => ['user', 'menu.user']
    ], function () 
{
    Route::get('/', function () {
        return view('user/index2');
    });

    Route::get('buecherlisten', 'HomeController@zeigeBuecherlisten');
    Route::post('buecherlisten', 'HomeController@zeigeBuecherlisten');

    Route::get('buecher/{id}', 'HomeController@zeigeBuecher');

    Route::get('anmeldung/schritt1', 'AnmeldungController@zeigeVorabfragen');
    Route::post('anmeldung/schritt1', 'AnmeldungController@verarbeiteVorabfragen');

    Route::get('anmeldung/schritt2', 'AnmeldungController@zeigeAbfragen');
    Route::post('anmeldung/schritt2', 'AnmeldungController@verarbeiteAbfragen');

    Route::get('anmeldung/schritt3', 'AnmeldungController@zeigeBuecherliste');
    Route::post('anmeldung/schritt3', 'AnmeldungController@verarbeiteBuecherliste');

    Route::get('anmeldung/schritt4', 'AnmeldungController@zeigeZustimmung');
    Route::post('anmeldung/schritt4', 'AnmeldungController@verarbeiteZustimmung');

    Route::get('anmeldung/schritt5', 'AnmeldungController@zeigeAbschluss');

    /* HOME */
    /*
    Route::get ('sportwahlen', 'SportwahlenController@index');
    Route::get ('sportwahlen/wahlbogen', 'SportwahlenController@zeigeWahlbogen');
    Route::post('sportwahlen/wahlbogen', 'SportwahlenController@speichereWahlbogen');
    */
});

