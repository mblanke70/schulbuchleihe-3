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
        $gesamtsumme = 0;
        $gesamtanzahl = 0;

        foreach($models as $model) 
        {
            $buchtitel = collect();
            $buchtitel->put('titel' , $model->buchtitel->titel);
            $buchtitel->put('isbn', $model->buchtitel->isbn);
            $buchtitel->put('kaufpreis', number_format($model->kaufpreis, 2, ',', ' '));

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

            if( !in_array($model->id, [222,178,136,123]))
            {
                if($anzahl > 0) {
                    $buchtitel->put('anzahl', $anzahl);
                    $buchtitel->put('summe', 
                        number_format($model->kaufpreis * $anzahl, 2, ',', ' '));
                    $gesamtsumme += $model->kaufpreis * $anzahl;
                    $gesamtanzahl += $anzahl; 
                    $liste->push($buchtitel);  
                }
            } 
        }
           
        \File::delete('pdf/bestellliste.pdf');

        $pdf = \PDF::loadView('pdf.bestellliste', compact('liste', 'gesamtsumme', 'gesamtanzahl'))
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
