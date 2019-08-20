<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Boolean;

class Rechnung extends Resource
{
    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Rechnungen';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Rechnung';
    }

    /**
    * The logical group associated with the resource.
    *
    * @var string
    */
    public static $group = 'Leihverfahren';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Rechnung';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 's_vorname', 's_nachname'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [

            Heading::make('Ausleiher'), 

            ID::make()->sortable(),

            Text::make('Geschlecht', 's_geschlecht')->sortable(),

            Text::make('Vorname', 's_vorname')->sortable(),

            Text::make('Nachname', 's_nachname')->sortable(),
            
            Text::make('# Posten', function () {
                return $this->positionen()->count();
            })->onlyOnIndex(),

            Text::make('Summe', 're_summe')->sortable(),

            Boolean::make('bezahlt', 'bezahlt')->rules('required')->sortable(),

            HasMany::make('RechnungPosition', 'positionen'),

            Heading::make('Rechnungsempfänger'), 

            Text::make('RE_Geschlecht', 're_geschlecht')->sortable()->hideFromIndex(),

            Text::make('RE_Vorname', 're_vorname')->sortable()->hideFromIndex(),

            Text::make('RE_Nachname', 're_nachname')->sortable()->hideFromIndex(),

            Text::make('RE_Straße', 're_strasse')->sortable()->hideFromIndex(),

            Text::make('RE_PLZ', 're_plz')->sortable()->hideFromIndex(),

            Text::make('RE_Ort', 're_ort')->sortable()->hideFromIndex(),

            Text::make('RE_Summe', 're_summe')->sortable()->hideFromIndex(),

            Date::make('RE_Datum', 're_datum')
                ->format('DD.MM.YYYY')->sortable()->hideFromIndex(),

            Date::make('RE_Fälligkeit', 're_faelligkeit')
                ->format('DD.MM.YYYY')->sortable()->hideFromIndex(),

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
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
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
            new Actions\RechnungDrucken2,
            new Actions\RechnungBezahlt,
        ];
    }

    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'rechnungen';
    }
}
