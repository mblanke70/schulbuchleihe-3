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

//use App\Rules\BuchtitelNichtAusgeliehen;
//use App\Rules\BuchNichtAusgeliehen;
//use App\Rules\BuchcodeExistiert;

use App\Buch;
use Carbon\Carbon;

class BuchAusleihen extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    
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
        $ausleiher = $models->first();
        $buch      = Buch::find($fields->buch_id);
        $now       = Carbon::now()->toDateTimeString();

        $ausleiher->buecher()->save($buch);
        
        $buch->ausleiher_ausgabe = Carbon::now();
        $buch->save();
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
                    if ($buch != null && $buch->ausleiher_id != null) {
                        return $fail('Das Buch ist schon ausgeliehen.');
                    }
                }          
            )
        ];
    }
}
