<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;

use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class Schueler extends Resource
{
    /**
    * The logical group associated with the resource.
    *
    * @var string
    */
    public static $group = 'Leihverfahren';


    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Schüler';
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Schueler';

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->vorname . ' ' . $this->nachname;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'vorname', 'nachname'
    ];

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['user', 'klasse'];

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

            //DateTime::make('Created At', 'created_at')->sortable()->onlyOnIndex(),

            Text::make('Vorname', 'vorname')->rules('required')->sortable(),
            
            Text::make('Nachname', 'nachname')->rules('required')->sortable(),            

            BelongsTo::make('Klasse', 'klasse')->rules('required')->nullable(),

            Boolean::make('Koop-Schüler', 'koop')->hideFromIndex(),
            
            BelongsTo::make('User', 'user')->hideFromIndex()->nullable()->searchable(),

            Text::make('Ermäßigung', function () { 
                $familie = $this->familie;
                if($familie != null)
                {
                    if($familie->kinder()->count() 
                        + $familie->externe()->count() > 2)
                    {
                        return "20%";
                    }

                    if($familie->befreit)
                    {
                        return "100%";
                    }
                    return "---"; 
                }
                return "k.F.";
            }),

            Text::make('Summe', function () { 
                $buecher = $this->buecher;
                $summe = 0;
                foreach($buecher as $buch) {
                    $btsj = $buch->buchtitel->buchtitelSchuljahr->first();

                    $leihpreis = $btsj->leihpreis;
                    if($leihpreis != null)
                    {
                        $summe += $leihpreis;
                    }
                }

                $familie = $this->familie;
                if($familie != null)
                {
                    if($familie->kinder()->count() 
                        + $familie->externe()->count() > 2)
                    {
                        $summe = $summe * 0.8;
                    }

                    if($familie->befreit)
                    {
                        $summe = 0;
                    } 
                }

                return number_format($summe, 2, ',', '');
            }),

            Text::make('# geliehen', function () { return $this->buecher()->count(); })
                ->onlyOnIndex()->sortable(),

            /*
            Text::make('Mandatsref', function () { 
                $familie = $this->familie;
                if($familie != null)
                    return $familie->mandatsref; 
                else
                    return "---";
            })->sortable(),
            */
           
/*
            Text::make('# bestellt', function () { return $this->bestellungen()->count(); })
                ->onlyOnIndex(),
*/            
            HasMany::make('Buch', 'buecher'),

            HasMany::make('Buchwahl', 'buecherwahlen'),

            BelongsTo::make('Familie', 'familie')->nullable()->hideFromIndex(),

            Text::make('RE_Vorname', 're_vorname')->hideFromIndex(),
            
            Text::make('RE_Nachname', 're_nachname')->hideFromIndex(),
            
            Text::make('RE_Straße', 're_strasse_nr')->hideFromIndex(),
            
            Text::make('RE_PLZ', 're_plz')->hideFromIndex(),
            
            Text::make('RE_Ort', 're_ort')->hideFromIndex(),

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
            new Filters\SchuelerKlasse,
            new Filters\SchuelerJahrgang,
            new Filters\SchuelerSchuljahr
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
        return [
            new Lenses\SchuelerBankeinzug,
        ];
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
            new Actions\BuchAusleihen,
            new Actions\BuchZurueck,
            new Actions\RechnungStellen,
            new Actions\BuecherlisteDrucken,
            new Actions\SepaXML,
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
        return 'schueler';
    }
}
