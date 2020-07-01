<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;

class Buchwahl extends Resource
{
    public static $displayInNavigation = false;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Buchwahl';

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
        'id',
    ];

/*
    public static function relatableBuchtitelSchuljahrs(NovaRequest $request, $query)
    {
        $btsj = $request->findResourceOrFail();
        //return $query->where($btsj->schuljahr_id, '3');
    }   
*/
    
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
            
            BelongsTo::make('BuchtitelSchuljahr', 'buchtitel'),
            
            Select::make('Wahl', 'wahl')->options([
                '1' => 'Leihen',
                '2' => 'Verlängern',
                '3' => 'Kaufen',
            ])->displayUsingLabels(),

            //Text::make('Wahl', 'wahl')->onlyOnForms(),
            
            Boolean::make('E-Book', 'ebook'),
            
            /*Text::make('Wahl', function () {
                $w = "Leihen";
                if($this->wahl == 2) { $w = "Verlängern"; }
                if($this->wahl == 3) { $w = "Kaufen";     }
                return $w;
            })->sortable(),*/

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
}
