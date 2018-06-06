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
    return redirect('login/iserv');
    //return view('home');
});

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
    Route::get('/', function () { return view('admin/home/index'); } );

    Route::resource('schueler',  'UserController');
    Route::resource('buchtitel', 'BuchtitelController');
    Route::resource('buecher',   'BuchController');
    Route::resource('klassen',   'KlasseController');
    Route::resource('abfragen',  'AbfrageController');
    Route::resource('buecherlisten', 'BuecherlisteController');
    
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
    Route::get('/', function () { return redirect('user/buchleihe'); } );

    Route::get('buchleihe', 'BuchleiheController@index');
    Route::get('buchleihe/vorabfragen', 'BuchleiheController@zeigeVorabfragen');
    Route::post('buchleihe/abfragen', 'BuchleiheController@verarbeiteVorabfragen');
    Route::get('buchleihe/abfragen', 'BuchleiheController@zeigeAbfragen');
    Route::get('buchleihe/buecherliste',  'BuchleiheController@zeigeBuecherliste');
    Route::get('buchleihe/buecherwahlen',  'BuchleiheController@zeigeBuecherwahlen');
    Route::post('buchleihe/buecherwahlen', 'BuchleiheController@verarbeiteBuecherwahlen');
    Route::post('buchleihe/zustimmung', 'BuchleiheController@verarbeiteZustimmung');
    Route::post('buchleihe/neuwahl', 'BuchleiheController@neuwahl');
});


//Auth::routes();

Route::get('login/iserv', 'Auth\LoginController@redirectToProvider');
Route::get('login/iserv/callback', 'Auth\LoginController@handleProviderCallback');

//Route::post('logout', 'Auth\LoginController@logout')->name('logout');

/*
	// Authentication Routes...
    $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
    $this->post('login', 'Auth\LoginController@login');
    $this->post('logout', 'Auth\LoginController@logout')->name('logout');
*/