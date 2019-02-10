<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Buch;

class BuchtitelNichtAusgeliehen implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($ausleiher, $buch)
    {
         $this->ausleiher = $ausleiher;
         $this->buch      = $buch;
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
        if($this->buch!=null) {
            $bt_id   = $this->buch->buchtitel->id;
            $buecher = $this->ausleiher->buecher()->get();
            return !$buecher->contains('buchtitel.id', $bt_id);
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
         return 'Dieser Schüler hat den Buchtitel bereits ausgeliehen.';
    }
}
