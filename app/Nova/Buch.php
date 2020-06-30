<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Number;

class Buch extends Resource
{
    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Bücher';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Buch';
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
    public static $model = 'App\Buch';

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->buchtitel->titel;
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
    public static $with = ['buchtitel'];

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

            BelongsTo::make('Titel', 'buchtitel', 'App\Nova\Buchtitel'),

            MorphTo::make('Ausleiher')->types([
                Schueler::class,
                Lehrer::class,
            ])->hideWhenCreating(),
            
            Number::make('Kaufpreis', 'neupreis')
                ->min(1)->max(1000)->step(0.01)->rules('required'),
          
            Date::make('Aufnahme', 'aufnahme')
                ->hideWhenCreating()->hideFromIndex(),
            
            HasMany::make('BuchHistorie', 'historie'),

            Date::make('Inventur', 'inventur')
                ->onlyOnIndex(),
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
            (new Actions\LabelDrucken)->showOnTableRow(),
            (new Actions\BuchRueckgabe)->showOnTableRow(),
        ];
    }

    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'buecher';
    }
}
