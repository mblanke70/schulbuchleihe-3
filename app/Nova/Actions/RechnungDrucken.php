<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\File;

class RechnungDrucken extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return ('Rechnung drucken');
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
        \File::delete('pdf/rechnung.pdf');

        $pdf = \PDF::loadView('pdf.rechnung', compact('models'))
            ->setOption('margin-bottom', '20mm')
            ->setOption('margin-top'   , '20mm')
            ->setOption('margin-right' , '20mm')
            ->setOption('margin-left'  , '20mm')
            ->save('pdf/rechnung.pdf');
    
        return Action::download(url('pdf/rechnung.pdf'), 'rechnung.pdf');

        //return Action::redirect($pdf->inline());
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
