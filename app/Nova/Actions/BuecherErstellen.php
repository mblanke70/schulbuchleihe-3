<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Fields\Number;

use App\Buch;
use Carbon\Carbon;

class BuecherErstellen extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return ('Bücher erstellen');
    }

    /**
     * Indicates if this action is only available on the resource detail view.
     *
     * @var bool
     */
    public $onlyOnDetail = true;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $buchtitel = $models->first();

        $buecher = new Collection();
        for ($i=0; $i<$fields->anzahl; $i++) 
        {
           $buch = new Buch;
           $buch->buchtitel_id = $buchtitel->id;
           $buch->neupreis = $fields->preis;
           $buch->aufnahme = Carbon::now();
           $buch->save();

           $buecher->push($buch);
        }

        \File::delete('pdf/labels.pdf');

        $pdf = \PDF::loadView('pdf.label', compact('buecher'))
            ->setOption('page-width'   , '105.0')
            ->setOption('page-height'  , '48.0')
            ->setOption('margin-bottom', '4mm')
            ->setOption('margin-top'   , '4mm')
            ->setOption('margin-right' , '4mm')
            ->setOption('margin-left'  , '4mm')
            ->setOption('encoding', 'utf-8')
            ->save('pdf/labels.pdf');
    
        return Action::download(url('pdf/labels.pdf'), 'labels.pdf');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
       return [
            Number::make('Anzahl', 'anzahl')
                ->min(1)->max(100)->step(1)->rules('required'),

            Number::make('Preis', 'preis')
                ->min(1)->max(100)->step(0.01)->rules('required'),
        ];
    }
}
