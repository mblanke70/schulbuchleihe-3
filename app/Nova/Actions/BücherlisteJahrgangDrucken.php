<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

use App\BuchtitelSchuljahr;

class BücherlisteJahrgangDrucken extends Action
{
    use InteractsWithQueue, Queueable;

    public function handle(ActionFields $fields, Collection $models)
    {    
        \File::delete('pdf/buecherliste_jahrgang.pdf');

        $pdf = \PDF::loadView(

            'pdf.buecherliste_jahrgang', 
            compact('models')

        )->save('pdf/buecherliste_jahrgang.pdf');
    
        return Action::download(
        
            url('pdf/buecherliste_jahrgang.pdf'), 
            'buecherliste_jahrgang.pdf'
        
        );
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
