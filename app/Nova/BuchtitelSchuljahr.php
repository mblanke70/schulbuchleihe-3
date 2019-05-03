<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsToMany;

class BuchtitelSchuljahr extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\BuchtitelSchuljahr';


    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    //public static $displayInNavigation = false;

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->buchtitel->titel . ' (' . $this->schuljahr->schuljahr . ')';
    }

    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'BuchtitelImSchuljahr';
    }

        /**
    * The logical group associated with the resource.
    *
    * @var string
    */
    public static $group = 'Leihverfahren';

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
    public static $with = ['buchtitel', 'schuljahr'];

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
            Text::make('Titel', 'buchtitel.titel')->sortable(),
            Text::make('Schuljahr', 'schuljahr.schuljahr')->sortable(),
            Text::make('Leihpreis', 'leihpreis')->sortable(),
            Text::make('Kaufpreis', 'kaufpreis')->sortable(),
            BelongsToMany::make('Buecherliste', 'buecherlisten'),
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
        return 'buchtitelSchuljahr';
    }
}
