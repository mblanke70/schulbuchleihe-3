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


Route::get('/', function () {
    return view('home');
});

Route::get('/keinAccount', function () {
    return view('noaccount');
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
    Route::get('/', 'HomeController@index' );

/* USER-CONTROLLER
    Route::resource('schueler', 'UserController');
    Route::get('getUserData', 'UserController@getUserData');    
    Route::get('versetzen', 'UserController@versetzen');
    Route::post('versetzenSpeichern', 'UserController@versetzenSpeichern');
*/

/* BUCHTITEL-CONTROLLER
    Route::resource('buchtitel', 'BuchtitelController');
    Route::get('buchtitel/createISBN/{isbn}', 'BuchtitelController@createFromISBN');
*/

/* BUCH-CONTROLLER
    Route::resource('buecher', 'BuchController');
    Route::get('buecher/label/{id}', 'BuchController@printLabel');
*/

/* KLASSEN-CONTROLLER
    Route::resource('klassen', 'KlasseController');
*/

/* SCHULJAHRE-CONTROLLER
    Route::resource('schuljahre', 'SchuljahrController');
*/

/* SCHUELER-CONTROLLER
    Route::resource('schueler', 'SchuelerController');
    Route::get('getSchuelerData', 'SchuelerController@getSchuelerData');
*/

/* ABFRAGEN-CONTROLLER
    Route::resource('abfragen', 'AbfrageController');
    Route::post('abfragen/attach/{id}', 'AbfrageController@attach');
*/

/* BUECHERLISTEN-CONTROLLER
    Route::resource('buecherlisten', 'BuecherlisteController');
    Route::delete('buecherlisten/detach/{buecherliste}/{buchtitel}', 'BuecherlisteController@detach');
    Route::post('buecherlisten/attach/{id}', 'BuecherlisteController@attach');
*/

    /* AUSWERTUNG */
    Route::get('auswertung', 'AuswertungController@index');
    Route::get('auswertung/bankeinzug', 'AuswertungController@zeigeBankeinzug');

    /* RÜCKGABE */
    Route::get ('rueckgabe', 'RueckgabeController@index');
    Route::post('rueckgabe', 'RueckgabeController@zuruecknehmen');   

    /* BUCHINFO */
    Route::get('buchinfo', function () { return view('admin/ausleihe/buchinfo'); });
    Route::post('buchinfo', 'AusleiheController@zeigeBuchinfo');       

    /* INVENTUR */
    Route::get('inventur', function () { return view('admin/buecher/inventur'); });
    Route::post('inventur', 'BuchController@inventarisieren'); 

    /* AUSLEIHE */
    Route::get('ausleihe', 'AusleiheController@index');
    Route::get('ausleihe/ermaessigungen', 'AusleiheController@zeigeErmaessigungen');
    
    Route::post('ausleihe/ermaessigungen/{schueler}', 'AusleiheController@bestaetigeErmaessigungen');
    
    Route::get('ausleihe/buecherliste/{klasse}/{schueler}', 'AusleiheController@zeigeBuecherliste');
    
    Route::get('ausleihe/{klasse}', 'AusleiheController@zeigeKlasse');
    Route::get('ausleihe/{klasse}/{schueler}', 'AusleiheController@zeigeSchueler');
    Route::delete('ausleihe/{klasse}/{schueler}', 'AusleiheController@remove');    

    //Route::post('ausleihe/{klasse}/{schueler}/auswahl', 'AusleiheController@add');
    //Route::delete('ausleihe/{klasse}/{schueler}/auswahl', 'AusleiheController@remove');    
    
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
        return view('user/index');
    });

    Route::get('buecherlisten', 'HomeController@zeigeBuecherlisten');
    Route::post('buecherlisten', 'HomeController@zeigeBuecherlisten');

    Route::get('buecher/{id}', 'HomeController@zeigeBuecher');

    Route::get('/{id}', 'HomeController@zeigeSchuljahr');


    Route::get('anmeldung/schritt1', 'AnmeldungController@zeigeVorabfragen');
    Route::post('anmeldung/schritt1', 'AnmeldungController@verarbeiteVorabfragen');

    Route::get('anmeldung/schritt2', 'AnmeldungController@zeigeAbfragen');
    Route::post('anmeldung/schritt2', 'AnmeldungController@verarbeiteAbfragen');

    Route::get('anmeldung/schritt3', 'AnmeldungController@zeigeBuecherliste');
    Route::post('anmeldung/schritt3', 'AnmeldungController@verarbeiteBuecherliste');

    Route::get('anmeldung/schritt4', 'AnmeldungController@zeigeZustimmung');
    Route::post('anmeldung/schritt4', 'AnmeldungController@verarbeiteZustimmung');

    Route::get('anmeldung/schritt5', 'AnmeldungController@zeigeAbschluss');

    /* ANMELDEVERFAHREN */
    Route::get('buchleihe', 'BuchleiheController@index');

    Route::get ('buchleihe/vorabfragen', 'BuchleiheController@zeigeVorabfragen');
    Route::post('buchleihe/vorabfragen', 'BuchleiheController@verarbeiteVorabfragen');
    
    Route::get  ('buchleihe/abfragen', 'BuchleiheController@zeigeAbfragen');
    Route::post ('buchleihe/abfragen', 'BuchleiheController@verarbeiteAbfragen');
    
    Route::get ('buchleihe/buecherliste', 'BuchleiheController@zeigeBuecherliste');
    Route::post('buchleihe/buecherliste', 'BuchleiheController@verarbeiteBuecherliste');
    
    Route::get ('buchleihe/zustimmung', 'BuchleiheController@zeigeZustimmung');
    Route::post('buchleihe/zustimmung', 'BuchleiheController@verarbeiteZustimmung');

    Route::get('buchleihe/abschluss', 'BuchleiheController@zeigeAbschluss');

    Route::post('buchleihe/neuwahl', 'BuchleiheController@neuwahl');

    /* HOME */
    Route::get('buecher', 'HomeController@zeigeBuecher');
    Route::get('buecherliste', 'HomeController@zeigeBuecherliste');

    Route::get ('sportwahlen', 'SportwahlenController@index');
    Route::get ('sportwahlen/wahlbogen', 'SportwahlenController@zeigeWahlbogen');
    Route::post('sportwahlen/wahlbogen', 'SportwahlenController@speichereWahlbogen');
});

