<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Buecherliste;

class BuchtitelIstAufBuecherliste implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($ausleiher, $buch)
    {
         $this->ausleiher = $ausleiher;
         $this->jg   = $ausleiher->jahrgang;
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
        if($this->buch!=null)
        {
            $bt_id = $this->buch->buchtitel->id;
            $buecherliste = Buecherliste::where('jahrgang', $this->jg)->first();
            return $buecherliste->buchtitel->contains('id', $bt_id);
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Der diesem Buch zugeordnete Buchtitel steht nicht auf der Bücherliste des Jahrgangs '. $this->jg.'.';
    }
}
