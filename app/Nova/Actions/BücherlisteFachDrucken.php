<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

use App\Fach;

class BücherlisteFachDrucken extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return ('Bücherlisten fächerweise drucken');
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {    
        
        $plucked = $models->pluck('buchtitel.fach');

        \File::delete('pdf/buecherliste_fach.pdf');

        $pdf = \PDF::loadView(

            'pdf.buecherliste_fach', 
            compact('models', 'plucked')

        )->save('pdf/buecherliste_fach.pdf');
    
        return Action::download(
        
            url('pdf/buecherliste_fach.pdf'), 
            'buecherliste_fach.pdf'
        
        );
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        /*
        return [

            Select::make('fach_id')->options(
                Fach::pluck('id', 'name')
            ),

        ];
        */
    }
}
