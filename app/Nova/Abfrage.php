<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo; 
use Laravel\Nova\Fields\HasOne; 
use Laravel\Nova\Fields\Boolean; 

class Abfrage extends Resource
{
    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Abfragen';
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
    public static $model = 'App\Abfrage';


    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->id . " (" . $this->titel . ")";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['jahrgang'];

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
            Text::make('Name', 'titel')
                ->rules('required')
                ->sortable(),
            BelongsTo::make('Jahrgang', 'jahrgang', 'App\Nova\Jahrgang')
                ->rules('required')
                ->sortable(),
            BelongsTo::make('Oberabfrage', 'parent', 'App\Nova\Abfrage')
                ->nullable(),
            BelongsTo::make('Unterabfrage', 'child', 'App\Nova\Abfrage')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->nullable(),
            HasMany::make('Antworten', 'antworten', 'App\Nova\AbfrageAntwort')
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
            new Filters\AbfrageSchuljahr,
            new Filters\AbfrageJahrgang,
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
        return [];
    }

    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'abfragen';
    }
}
