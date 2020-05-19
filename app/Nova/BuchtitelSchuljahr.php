<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Number;

use App\Buchwahl;

use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;


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
        'id', 
    ];

    /**
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [
        'buchtitel' => ['titel'],
    ];

     /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = [
        'buchtitel', 
        'schuljahr'
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
                        
            BelongsTo::make('Buchtitel', 'buchtitel'),

            Text::make('Titel', 'buchtitel.titel')
                ->onlyOnIndex(),

            Text::make('ISBN', 'buchtitel.isbn')
                ->onlyOnIndex(),

            Text::make('Verlag', 'buchtitel.verlag')
                ->onlyOnIndex(),

            Text::make('ISBN', 'buchtitel.isbn')
                ->onlyOnIndex(),
            
            BelongsTo::make('Schuljahr', 'schuljahr'),

            Text::make('Fach', 'buchtitel.fach.name')
                ->hideWhenCreating()
                ->hideWhenUpdating(), 

            Number::make('Leihpreis', 'leihpreis')->min(1)->max(100)->step(0.01),
            
            Number::make('Kaufpreis', 'kaufpreis')->min(1)->max(200)->step(0.01),
            
            BelongsToMany::make('AbfrageAntwort', 'antworten')
                ->onlyOnDetail(),

            /*
            Text::make('# verfügbar', function () {
                return $this->buchtitel()
                    ->first()
                    ->buecher()
                    ->whereNull('ausleiher_id')
                    ->count();
            
            })->onlyOnIndex(),
            */

            /*
            Text::make('# bestellt', function () {
                return $this->buchwahlen()
                    ->where('wahl', 1)
                    ->count();
            })->onlyOnIndex(),
            */

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
         return [
            new Actions\BestelllisteDrucken,
            new DownloadExcel,

        ];
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
