<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;

use App\BuchHistorie;
use App\Buch;
use Carbon\Carbon;

class BuchZurueck extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return ('Buch zurückgeben');
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
        $ausleiher = $models->first();
        $buch = Buch::find($fields->buch_id);

        if($buch->ausleiher_id == $ausleiher->id)
        {
            if(!$fields->ohne_historien_eintrag)
            {
                // Eintrag in Buchhistorie
                $eintrag = new BuchHistorie;
                $eintrag->buch_id   = $buch->id;
                $eintrag->titel     = $buch->buchtitel->titel;
                $eintrag->nachname  = $ausleiher->nachname;
                $eintrag->vorname   = $ausleiher->vorname;
                if($buch->ausleiher_type == 'App\Schueler')
                {
                    $eintrag->klasse    = $ausleiher->klasse->bezeichnung;
                    $eintrag->schuljahr = $ausleiher->klasse->jahrgang->schuljahr->schuljahr;
                }
                $eintrag->ausgabe   = $buch->ausleiher_ausgabe;
                $eintrag->rueckgabe = Carbon::now();
                $eintrag->save();
            }
            
            // Leihe beenden
            $buch->ausleiher_id      = null;
            $buch->ausleiher_type    = null;
            $buch->ausleiher_ausgabe = null;
            $buch->save();

            return Action::message('Das Buch wurde zur&uuml;ckgegeben.');
        }

        return Action::danger('Rückgabe fehlgeschlagen. Das Buch ist ausgeliehen an ' 
            . $buch->ausleiher()->first()->name) . ' !';
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
       return [

            Text::make('buch_id')->rules(
                
                'required', 
                
                function($attribute, $value, $fail) {
                    $buch = Buch::find($value); 
                    if ($buch == null) {
                        return $fail('Die Buch-ID ' . $value . ' existiert nicht.');
                    }
                },

                function($attribute, $value, $fail) {
                    $buch = Buch::find($value); 
                    if ($buch != null && $buch->ausleiher_id == null) {
                        return $fail('Das Buch ist gar nicht ausgeliehen.');
                    }
                }          
            ),

            Boolean::make('ohne_historien_eintrag') 

        ];
    }
}
