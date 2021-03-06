<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;


class BuchtitelIstBestellt implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($ausleiher, $buch)
    {
         $this->ausleiher = $ausleiher;
         $this->jg        = $ausleiher->jahrgang;
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
        if($this->buch!=null) 
        {
            $btsj = $this->buch->buchtitel->buchtitelSchuljahr->first();

            return $this->ausleiher->buecherwahlen
                ->where('wahl', 1)
                ->contains('buchtitel_id', $btsj->id);
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Der zugehörige Buchtitel ist nicht für die Ausleihe bestellt worden.';
    }
}
