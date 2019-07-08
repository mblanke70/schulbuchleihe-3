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

class BestelllisteDrucken extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return ('Bestellliste drucken');
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
        $liste = collect();
        foreach($models as $model) 
        {
            $buchtitel = collect();
            $buchtitel->put('vorname' , $model->buchtitel->first()->titel);
            $buchtitel->put('nachname', $model->buchtitel->first()->isbn);
            
            $verfuegbar = $model->buchtitel()
                ->first()
                ->buecher()
                ->whereNull('ausleiher_id')
                ->count();
            $buchtitel->put('verfuegbar', $verfuegbar);

            $verfuegbarMitInventurstempel = $model->buchtitel()
                ->first()
                ->buecher()
                ->whereNull('ausleiher_id')
                ->whereNotNull('inventur')
                ->count();
            $buchtitel->put('verfuegbarMitInventurstempel', $verfuegbarMitInventurstempel);
        
            $bestellt = $model->buchwahlen()
                ->where('wahl', 1)
                ->count();
            $buchtitel->put('bestellt', $bestellt);

            $anzahl = $bestellt - $verfuegbarMitInventurstempel;
            if($anzahl > 0) {
                $buchtitel->put('anzahl', $anzahl);
                $liste->push($buchtitel);  
            } 
        }
           
        \File::delete('pdf/bestellliste.pdf');

        $pdf = \PDF::loadView('pdf.bestellliste', compact('liste'))
                ->save('pdf/bestellliste.pdf');
    
        return Action::download(url('pdf/bestellliste.pdf'), 'bestellliste.pdf');
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
