<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;

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
            Text::make('Vorname', 'vorname')->sortable(),
            Text::make('Nachname', 'nachname')->sortable(),
            BelongsTo::make('Klasse', 'klasse')->nullable(),
            Text::make('# geliehen', function () {
                return $this->buecher()->count();
            }),
            HasMany::make('Buch', 'buecher')
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
            new Actions\BuchAusleihen,
            new Actions\BuchZurueck
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
