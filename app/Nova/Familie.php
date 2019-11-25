<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasOne;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class Familie extends Resource
{
    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Familien';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Familie';
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Familie';

    /**
    * The logical group associated with the resource.
    *
    * @var string
    */
    public static $group = 'Leihverfahren';

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
        'id', 'name', 'strasse'
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

            //BelongsTo::make('Schuljahr', 'schuljahr')->nullable(),

            Text::make('Name', 'name')->rules('required')->sortable(),
            
            Text::make('Straße', 'strasse')->rules('required')->sortable(),

            Text::make('IBAN', 'iban')->hideFromIndex(),

            Text::make('Mandatsref', 'mandatsref')->sortable(),
            
            BelongsTo::make('SEPA-Mandat', 'sepa_mandat'),
            
            Text::make('Kinder', function() {
                $kinder  = $this->kinder;
                $externe = $this->externe;

                $namen = array();
                foreach($kinder as $k)  { $namen[] = $k->vorname; }
                foreach($externe as $k) { $namen[] = $k->vorname; }

                return implode(", ", $namen);
            })->onlyOnIndex(),

            /*
            Text::make('angegebene Erm.', function () {
                
                if($this->erm == 2) {
                    return "befreit";
                } else if ($this->erm == 1) {
                    return "20%";
                } else {
                    return "keine";
                }

            })->onlyOnIndex(),
            */

            Boolean::make('befreit'),

            Boolean::make('ermäßigt', function () {
                return ($this->kinder()->count() + $this->externe()->count()) > 2;
            })->onlyOnIndex(),

            Text::make('# Kinder', function () {
                return $this->kinder()->count();
            })->onlyOnIndex(),

            Text::make('# Externe', function () {
                return $this->externe()->count();
            })->onlyOnIndex(),
            
            HasMany::make('Schueler', 'kinder'),

            HasMany::make('SchuelerExt', 'externe'),

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
            new Filters\FamilieErm,
            //new Filters\FamilieErmStatus,
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
        return 'familien';
    }
}
