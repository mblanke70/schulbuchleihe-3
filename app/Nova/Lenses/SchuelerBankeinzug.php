<?php

namespace App\Nova\Lenses;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Fields\Number;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Http\Requests\LensRequest;

class SchuelerBankeinzug extends Lens
{
    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        return $request->withOrdering($request->withFilters(
            $query->select(self::columns())
                ->join('buecher', 'schueler.id', '=', 'buecher.ausleiher_id')
                ->join('familien', 'schueler.familie_id', '=', 'familien.id')
                ->orderBy('schueler.nachname', 'asc')
                ->groupBy('schueler.id', 'schueler.nachname', 'schueler.vorname', 'familien.strasse', 'familien.iban')
        ));
    }

    /**
     * Get the columns that should be selected.
     *
     * @return array
     */
    protected static function columns()
    {
        return [
            'schueler.id',
            'schueler.nachname',
            'schueler.vorname',
            'familien.strasse',
            'familien.iban',
            //DB::raw('count(buecher.id) as anzahl'),
        ];
    }

    /**
     * Get the fields available to the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make('ID', 'id'),
            Text::make('Nachname', 'nachname'),
            Text::make('Vorname', 'vorname'),
            Text::make('Straße', 'strasse'),
            Text::make('IBAN', 'iban'),
           
            //Number::make('Anzahl', 'anzahl'),
        ];
    }

    /**
     * Get the filters available for the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available on the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return parent::actions($request);
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'bankeinzug';
    }
}
