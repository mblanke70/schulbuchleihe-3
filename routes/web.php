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

Route::group(
    [  
        'prefix'     => 'admin', 
        'namespace'  => 'admin',
        'middleware' => ['admin', 'menu.admin']
    ], function()
{
    Route::get('/', 'HomeController@index' );

    Route::resource('schueler', 'UserController');
    Route::get('getUserData', 'UserController@getUserData');
    
    Route::get('versetzen', 'UserController@versetzen');
    Route::post('versetzenSpeichern', 'UserController@versetzenSpeichern');
    
    Route::resource('buchtitel', 'BuchtitelController');
    Route::get('buchtitel/createISBN/{isbn}', 'BuchtitelController@createFromISBN');

    Route::resource('buecher', 'BuchController');
    Route::resource('klassen', 'KlasseController');
    Route::resource('schuljahre', 'SchuljahrController');

    Route::resource('schueler', 'SchuelerController');
    Route::get('getSchuelerData', 'SchuelerController@getSchuelerData');
    //Route::get('ausleiher/getUserData', 'AusleiherController@getUserData');

    Route::resource('abfragen', 'AbfrageController');
    Route::resource('buecherlisten', 'BuecherlisteController');
    
    //Route::resource('ausleihe',      'AusleiheController');

    Route::get('buecher/label/{id}', 'BuchController@printLabel');

    Route::get('auswertung', 'AuswertungController@index');
    Route::get('auswertung/bankeinzug', 'AuswertungController@zeigeBankeinzug');

    Route::get ('rueckgabe', 'RueckgabeController@index');
    Route::post('rueckgabe', 'RueckgabeController@zuruecknehmen');   

    Route::get('buchinfo', function () { 
        return view('admin/ausleihe/buchinfo');
    });
   
    Route::post('buchinfo', 'AusleiheController@zeigeBuchinfo');       

    Route::get('ausleihe', 'AusleiheController@index');
    Route::get('ausleihe/ermaessigungen', 'AusleiheController@zeigeErmaessigungen');
    
    Route::post('ausleihe/ermaessigungen/{schueler}', 'AusleiheController@bestaetigeErmaessigungen');
    //Route::post('ausleihe/ermaessigungen/{klasse}/{schueler}', 'AusleiheController@bestaetigeErmaessigungen2');

    Route::get('ausleihe/buecherliste/{klasse}/{schueler}', 'AusleiheController@zeigeBuecherliste');
    
    Route::get('ausleihe/{klasse}', 'AusleiheController@zeigeKlasse');
    Route::get('ausleihe/{klasse}/{schueler}', 'AusleiheController@zeigeSchueler');
    Route::delete('ausleihe/{klasse}/{schueler}', 'AusleiheController@remove');    

    //Route::post('ausleihe/{klasse}/{schueler}/auswahl', 'AusleiheController@add');
    //Route::delete('ausleihe/{klasse}/{schueler}/auswahl', 'AusleiheController@remove');    
    Route::post('ausleihe/{klasse}/{schueler}', 'AusleiheController@ausleihen');
    Route::delete('ausleihe/{klasse}/{schueler}', 'AusleiheController@loeschen');    
    Route::put('ausleihe/{klasse}/{schueler}', 'AusleiheController@aktualisieren');
        
    Route::post('abfragen/attach/{id}', 'AbfrageController@attach');

    Route::delete('buecherlisten/detach/{buecherliste}/{buchtitel}', 'BuecherlisteController@detach');
    Route::post('buecherlisten/attach/{id}', 'BuecherlisteController@attach');
});

Route::group([
        'prefix'     => 'user', 
        'namespace'  => 'user',
        'middleware' => ['user', 'menu.user']
    ], function () 
{
    Route::get('/', function () { return redirect('user/buecher'); } );

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

    Route::get('buecher', 'HomeController@zeigeBuecher');
    Route::get('buecherliste', 'HomeController@zeigeBuecherliste');
});


Route::get('login/iserv', 'Auth\LoginController@redirectToProvider');
Route::get('login/iserv/callback', 'Auth\LoginController@handleProviderCallback');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

//Route::post('logout', 'Auth\LoginController@logout')->name('logout');