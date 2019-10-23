<?php

namespace Mb70\Ausleihe\Rules;

use Illuminate\Contracts\Validation\Rule;

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
        if($this->buch != null)
        {
            return $this->buch->ausleiher_id == null;
        }
        
        return false;
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
