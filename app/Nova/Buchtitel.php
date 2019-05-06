<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Number;

class Buchtitel extends Resource
{
    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Buchtitel';
    }

    /**
    * The logical group associated with the resource.
    *
    * @var string
    */
    public static $group = 'Bestand';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Buchtitel';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'titel';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'titel'
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
            
            Text::make('Kennung', 'kennung')
                ->sortable(),
            
            Text::make('Titel', 'titel')
                ->rules('required')
                ->sortable(),
            
            Text::make('Verlag', 'verlag')
                ->rules('required'),

            Text::make('ISBN', 'isbn')
                ->rules('required')
                ->sortable(),

            //Number::make('Preis', 'preis')
            //    ->hideFromIndex()->min(1)->max(1000)->step(0.01),
            
            //Number::make('Leihpreis', 'leihgebuehr')
                //->min(1)->max(1000)->step(0.01),

            BelongsTo::make('Fach', 'fach')
                ->hideFromIndex()->rules('required'),
            
            HasMany::make('Buch', 'buecher'),

            /*
            BelongsToMany::make('Buecherliste')
                ->fields(function () {
                    return [
                        Boolean::make('ausleihbar'),
                    ];
                })
            */
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
            new Actions\BuecherErstellen
        ];
    }

    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'buchtitel';
    }
}
