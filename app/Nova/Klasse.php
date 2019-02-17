<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;

class Klasse extends Resource
{
    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Klassen';
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
    public static $model = 'App\Klasse';

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->bezeichnung . ' - ' . $this->jahrgang->schuljahr->schuljahr;
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
    public static $with = ['jahrgang', 'jahrgang.schuljahr'];

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
            Text::make('bezeichnung')->sortable(),
            BelongsTo::make('Jahrgang', 'jahrgang')->nullable(),
            Text::make('Schuljahr', 'jahrgang.schuljahr.schuljahr')->hideWhenCreating()
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
            new Filters\KlassenSchuljahr,
        ];
        
        //return [];
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
}
