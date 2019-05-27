<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use App\Jahrgang;
use App\Schuljahr;

class SchuelerJahrgang extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * The displayable name of the filter.
     *
     * @var string
     */
    public $name = 'Jahrgang';

    /**
     * Set the default options for the filter.
     *
     * @return array
     */
    public function default()
    {
        //$schuljahr  = Schuljahr::where('aktiv', '1')->first();
        //return ['id' => $schuljahr->id];
    }

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->whereHas('klasse', function($query) use ($value) {
            $query->where('jahrgang_id', $value);
        });
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        $jgs = Jahrgang::all();
        $opt = array();
        foreach($jgs as $jg) {
            $opt[$jg->jahrgangsstufe . " (" . $jg->schuljahr->schuljahr. ")"] = $jg->id;
        }

        return $opt;
    }
}
