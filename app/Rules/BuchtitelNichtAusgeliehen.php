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
    public function __construct($user)
    {
         $this->user = $user;
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
        $buch = Buch::find($value);
        
        if($buch!=null) {
            $bt_id = $buch->buchtitel->id;
            $buecher = $this->user->buecher()->get();
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
         return 'Dieser Schüler hat diesen Buchtitel bereits ausgeliehen.';
    }
}
