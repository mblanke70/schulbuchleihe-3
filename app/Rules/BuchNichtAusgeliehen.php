<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\BuchUser;

class BuchNichtAusgeliehen implements Rule
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
        if($this->buch)
        {
            return $this->buch->ausleiher_id == null;
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
         //return 'Dieser Schüler hat dieses Buch bereits ausgeliehen.';
        return 'Das Buch ist bereits ausgeliehen.';
    }
}
