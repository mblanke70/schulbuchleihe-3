<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\BuchUser;

class BuchAusgeliehen implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($buch)
    {
        $this->buch = $buch;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {        
        // hole alle Bücher, die (wenigstens) einen Ausleiher haben 
        // und die noch nicht zurückgegeben worden sind 

        //$ausgelieheneBuecher = App\Buch::whereHas('ausleiher', function($query) { $query->whereNull('rueckgabe'); })->get();
        if($this->buch!=null)
            return $this->buch->ausleiher_id != null;
        else 
            return true;

        //$ausgelieheneBuecher = BuchUser::whereNull('rueckgabe')->get();
        
        //return !$ausgelieheneBuecher->contains('buch_id', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
         //return 'Dieser Schüler hat dieses Buch bereits ausgeliehen.';
        return 'Das Buch ist nicht ausgeliehen.';
    }
}
