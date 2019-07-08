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
        $rechnungen = collect();
        foreach($models as $model) 
        {
            $schueler = collect();
            $schueler->put('vorname' , $model->vorname );
            $schueler->put('nachname', $model->nachname);
            $schueler->put('strasse',  $model->re_strasse_nr);
            $schueler->put('plz',      $model->re_plz);
            $schueler->put('ort',      $model->re_ort);
            $schueler->put('id',       $model->id);
            
            $buecher = collect();
            $summe = 0;
            foreach($model->buecher as $b)
            {
                $buch = collect();
                $btsj = $b->buchtitel->buchtitelSchuljahr->first();

                $jahr      = date_format($b->aufnahme, 'Y');
                $kaufpreis = ceil($btsj->kaufpreis);
                $leihpreis = $btsj->leihpreis;
                $restwert  = $kaufpreis - (2019 - $jahr) * $leihpreis;
                
                if($restwert<0) $restwert = 0;
                $summe += $restwert;

                $buch->put('id'       , $b->id);
                $buch->put('titel'    , $b->buchtitel->titel);
                $buch->put('kaufpreis', number_format($kaufpreis, 2, ',', ' '));
                $buch->put('leihpreis', number_format($leihpreis, 2, ',', ' '));
                $buch->put('jahr'     , $jahr);
                $buch->put('restwert' , number_format($restwert, 2, ',', ' '));
                $buch->put('schuljahr', $btsj->schuljahr_id);

                $buecher->push($buch);
            }

            $schueler->put('buecher', $buecher);
            $schueler->put('summe', number_format($summe, 2, ',', ' '));

            $rechnungen->push($schueler);
        }

        \File::delete('pdf/rechnung.pdf');

        $pdf = \PDF::loadView('pdf.rechnung', compact('models', 'rechnungen'))
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
