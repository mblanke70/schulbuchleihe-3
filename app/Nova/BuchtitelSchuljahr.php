<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\BelongsTo;

class BuchtitelSchuljahr extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\BuchtitelSchuljahr';


    public static $perPageViaRelationship = 10;

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

    public static function relatableJahrgangs(NovaRequest $request, $query)
    {
        $jg = $request->findResourceOrFail();
        return $query->where('schuljahr_id', $jg->schuljahr->id);    
    }

    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Buchtitel:Schuljahr';
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
        'id', 'buchtitel.titel'
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
            //Text::make('Titel', 'buchtitel.titel')->sortable(),
            BelongsTo::make('Buchtitel', 'buchtitel'),
            //Text::make('Schuljahr', 'schuljahr.schuljahr')->sortable(),
            BelongsTo::make('Schuljahr', 'schuljahr'),
            Text::make('Fach', 'buchtitel.fach.name')
                ->hideWhenCreating()
                ->hideWhenUpdating(),
            
            Text::make('Leihpreis', 'leihpreis')->sortable(),
            Text::make('Kaufpreis', 'kaufpreis')->sortable(),
            
            BelongsToMany::make('AbfrageAntwort', 'antworten')
                ->onlyOnDetail(),

            //BelongsToMany::make('Buecherliste', 'buecherlisten'),
            BelongsToMany::make('Jahrgang', 'jahrgaenge'),
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
            new Filters\BuchtitelSchuljahr,
            new Filters\BuchtitelSchuljahrFach,
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
        return 'buchtitelSchuljahr';
    }
}
