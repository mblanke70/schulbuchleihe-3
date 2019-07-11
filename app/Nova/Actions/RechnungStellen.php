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
use Carbon\Carbon;

class RechnungStellen extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return ('Rechnung stellen');
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
        foreach($models as $model) 
        {
            $rechnung = new Rechnung;

            $rechnung->s_id            = $model->id;
            $rechnung->s_vorname       = $model->vorname;
            $rechnung->s_nachname      = $model->nachname;
            $rechnung->s_geschlecht    = $model->geschlecht;
            $rechnung->s_schuljahr     = $model->klasse->jahrgang->schuljahr->schuljahr;
            $rechnung->re_vorname      = $model->re_vorname;
            $rechnung->re_nachname     = $model->re_nachname;
            $rechnung->re_geschlecht   = $model->re_geschlecht;
            $rechnung->re_strasse      = $model->re_strasse_nr;
            $rechnung->re_plz          = $model->re_plz;
            $rechnung->re_strasse      = $model->re_strasse_nr;
            $rechnung->re_ort          = $model->re_ort;
            $rechnung->re_datum        = Carbon::now();
            $rechnung->re_faelligkeit  = Carbon::now()->addDays(30);

            $rechnung->save();

            $summe = 0;
            foreach($model->buecher as $b)
            {
                $btsj = $b->buchtitel->buchtitelSchuljahr->first();

                $jahr      = date_format($b->aufnahme, 'Y');
                $kaufpreis = ceil($btsj->kaufpreis);
                $leihpreis = $btsj->leihpreis;
                $restwert  = $kaufpreis - (2019 - $jahr) * $leihpreis;
                
                if($restwert<0) $restwert = 0;
                $summe += $restwert;

                $posten = new Rechnungsposten;

                $posten->buch_id     = $b->id;
                $posten->titel       = $b->buchtitel->titel;
                $posten->kaufpreis   = $kaufpreis;
                $posten->leihpreis   = $leihpreis;
                $posten->aufnahme    = $b->aufnahme;
                $posten->restwert    = $restwert;
                $posten->rechnung_id = $rechnung->id; 

                $posten->save();
            }

            $rechnung->re_summe = $summe;
            $rechnung->save();
        }
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
