<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;

class Schuljahr extends Resource
{
    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Schuljahre';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Schuljahr';
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
    public static $model = 'App\Schuljahr';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'schuljahr';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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

            ID::make()->sortable(),
 
            Text::make('Schuljahr', 'schuljahr')->rules('required'),
 
            Boolean::make('aktiv', 'aktiv')->rules('required'),
 
            Date::make('Beginn', 'von')->rules('required'),
 
            Date::make('Ende', 'bis')->rules('required'),
 
            HasMany::make('Jahrgang', 'jahrgaenge'),
           
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
        return [];
    }

    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'schuljahre';
    }
}
