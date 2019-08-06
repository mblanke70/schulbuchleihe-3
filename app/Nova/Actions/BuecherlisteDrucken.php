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

class BuecherlisteDrucken extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return ('Bücherliste drucken');
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

        foreach($models as $schueler) 
        {
            // Hole alle Buchtitel, die auf der Bücherliste des Jahrgangs des Schülers stehen       
            $buchtitel     = $schueler->klasse->jahrgang->buchtitel;
            // Hole alle Bücher, die der Schüler derzeit ausgeliehen hat
            $buecher       = $schueler->buecher;
            // Hole alle Buchbestellungen, die der Schüler abgegeben hat
            $buecherwahlen = $schueler->buecherwahlen->keyBy('buchtitel_id');
            
            // Durchlaufe die Bücherliste und ergänze zu jedem Buchtitel
            //   - die zugehörige Bestellung
            //   - den aktuellen Leihstatus (ist der Buchtitel bereits als Buch ausgeliehen worden?) 
            foreach($buchtitel as $btsj) 
            {    
                // bestellt?
                $bw = $buecherwahlen->get($btsj->id);
                if($bw!=null) {
                    $btsj['wahl']    = $bw->wahl;
                    $btsj['wahl_id'] = $bw->id;
                } else {
                    $btsj['wahl'] = 4;    // == nicht bestellt (abgewählt)
                }

                // ausgeliehen?
                $btsj['ausgeliehen'] = $buecher->contains('buchtitel_id', $btsj->buchtitel->id) ? 1 : 0;
            }

            $eintrag = collect();
            $eintrag->push($schueler);
            $eintrag->push($buchtitel);

            $liste->push($eintrag);
        }
           
        \File::delete('pdf/buecherliste.pdf');

        $pdf = \PDF::loadView('pdf.buecherliste', compact('liste'))
                ->save('pdf/buecherliste.pdf');
    
        return Action::download(url('pdf/buecherliste.pdf'), 'buecherliste.pdf');
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
