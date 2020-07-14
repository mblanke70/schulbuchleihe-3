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
use App\Rechnung;
use App\Rechnungsposten;

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

            $schueler->put('id',            $model->id);
            $schueler->put('vorname' ,      $model->vorname );
            $schueler->put('nachname',      $model->nachname);
            $schueler->put('geschlecht',    $model->geschlecht);
           
            $schueler->put('re_anrede',     $model->user->familie->re_anrede);
            $schueler->put('re_vorname',    $model->user->familie->re_vorname);
            $schueler->put('re_nachname',   $model->user->familie->re_nachname);
            $schueler->put('re_strasse',    $model->user->familie->re_strasse_nr);
            $schueler->put('re_plz',        $model->user->familie->re_plz);
            $schueler->put('re_ort',        $model->user->familie->re_ort);
            
            $buecher = collect();
            $summe = 0;
            foreach($model->buecher as $b)
            {
                $buch = collect();
                $btsj = $b->buchtitel->buchtitelSchuljahr->first();

                $jahr      = date_format($b->aufnahme, 'Y');
                $kaufpreis = ceil($btsj->kaufpreis);
                $leihpreis = $btsj->leihpreis;
                $restwert  = $kaufpreis - (2020 - $jahr) * $leihpreis;
                
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

        $pdf->setOption('margin-top',0);
        $pdf->setOption('margin-bottom',10);
        $pdf->setOption('margin-left',0);
        $pdf->setOption('margin-right',0);
    
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
