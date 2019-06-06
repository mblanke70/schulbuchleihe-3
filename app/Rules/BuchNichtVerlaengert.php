<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\BuchUser;

class BuchNichtVerlaengert implements Rule
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
        if( $this->buch && $this->buch->ausleiher_type == 'App\Schueler' ) 
        {
            $ausleiher = $this->buch->ausleiher;
            if( $ausleiher )
            {
                return $ausleiher->klasse->jahrgang->schuljahr->id < 3;
            }

            return true;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $ausleiher = $this->buch->ausleiher;

        return 'Das Buch ist bereits von ' . $ausleiher->vorname . " " . $ausleiher->nachname . ' für das Schuljahr 2019/20 ausgeliehen (verlängert) worden.';
    }
}
