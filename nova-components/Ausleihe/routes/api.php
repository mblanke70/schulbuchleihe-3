<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Buch;
use App\Jahrgang;
use App\Klasse;
use App\Schueler;

use Mb70\Ausleihe\Http\Controllers\AusleiheController;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::post('/', AusleiheController::class.'@getJahrgaenge');
Route::get('/{jahrgang}', AusleiheController::class.'@getKlassen');
Route::get('/{jahrgang}/{klasse}', AusleiheController::class.'@getSchueler');
Route::get('/{jahrgang}/{klasse}/{schueler}', AusleiheController::class.'@getAusleiher');

Route::post('/{jahrgang}/{klasse}/{schueler}', AusleiheController::class.'@ausleihen');

