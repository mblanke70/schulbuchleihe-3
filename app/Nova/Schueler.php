<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsToMany;

class Schueler extends Resource
{
    /**
    * The logical group associated with the resource.
    *
    * @var string
    */
    public static $group = 'Leihverfahren';


    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Schüler';
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Schueler';

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->vorname . ' ' . $this->nachname;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'vorname', 'nachname'
    ];

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['user', 'klasse'];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [

            ID::make()->sortable(),

            DateTime::make('Created At', 'created_at')->sortable()->onlyOnIndex(),

            Text::make('Vorname', 'vorname')->rules('required')->sortable(),
            
            Text::make('Nachname', 'nachname')->rules('required')->sortable(),            

            BelongsTo::make('Klasse', 'klasse')->rules('required')->nullable(),
            
            BelongsTo::make('User', 'user')->hideFromIndex()->nullable()->searchable(),
            
            Text::make('# geliehen', function () { return $this->buecher()->count(); })
                ->onlyOnIndex(),

            Text::make('# bestellt', function () { return $this->bestellungen()->count(); })
                ->onlyOnIndex(),
            
            HasMany::make('Buch', 'buecher'),

            HasMany::make('Buchwahl', 'buecherwahlen'),

            BelongsTo::make('Familie', 'familie')->nullable()->hideFromIndex(),

            Text::make('RE_Vorname', 're_vorname')->hideFromIndex(),
            
            Text::make('RE_Nachname', 're_nachname')->hideFromIndex(),
            
            Text::make('RE_Straße', 're_strasse_nr')->hideFromIndex(),
            
            Text::make('RE_PLZ', 're_plz')->hideFromIndex(),
            
            Text::make('RE_Ort', 're_ort')->hideFromIndex(),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new Filters\SchuelerKlasse,
            new Filters\SchuelerJahrgang,
            new Filters\SchuelerSchuljahr
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [
            new Lenses\SchuelerMitBuechern,
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new Actions\BuchAusleihen,
            new Actions\BuchZurueck,
            new Actions\RechnungStellen,
            new Actions\BuecherlisteDrucken,
        ];
    }

    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'schueler';
    }
}
