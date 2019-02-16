<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PrintBarcodeLabel extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $buch) {
            $pdf = \PDF::loadView('admin.buecher.pdf.label', compact('buch'))
                ->setOption('page-width'   , '105.0')
                ->setOption('page-height'  , '48.0')
                ->setOption('margin-bottom', '4mm')
                ->setOption('margin-top'   , '4mm')
                ->setOption('margin-right' , '4mm')
                ->setOption('margin-left'  , '4mm');
        }

        return Action::redirect($pdf->inline());
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
