<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasOne;


class SepaMandat extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\SepaMandat';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'debtorMandate';

    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'SEPA-Mandate';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'SEPA-Mandat';
    }


    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = true;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'debtorMandate', 'debtorName'
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

            Text::make('Mandatsreferenz', 'debtorMandate')->sortable(),

            Date::make('Signaturdatum', 'debtorMandateSignDate')->sortable(),

            Text::make(' Name', 'debtorName'),

            Text::make('BIC', 'debtorBic'),

            Text::make('IBAN', 'debtorIban'),

            //Text::make('Gläubiger Name', 'creditorName')->rules('required')->sortable(),

            //Text::make('Gläubiger ID', 'creditorId')->rules('required')->sortable(),

            HasOne::make('Familie', 'familie')->hideFromIndex(),
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
