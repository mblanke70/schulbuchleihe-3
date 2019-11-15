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

class LabelDrucken extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return ('Label drucken');
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $buecher)
    {
        \File::delete('pdf/labels.pdf');

        $pdf = \PDF::loadView('pdf.label', compact('buecher'))
            ->setOption('page-width'   , '105.0')
            ->setOption('page-height'  , '48.0')
            ->setOption('margin-bottom', '4mm')
            ->setOption('margin-top'   , '4mm')
            ->setOption('margin-right' , '4mm')
            ->setOption('margin-left'  , '4mm')
            ->save('pdf/labels.pdf');
    
        return Action::download(url('pdf/labels.pdf'), 'labels.pdf');

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
