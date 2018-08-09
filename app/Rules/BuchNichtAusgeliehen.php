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
        //$buecher = $this->user->buecher()->get(); 
        $ausgelieheneBuecher = BuchUser::whereNull('rueckgabe')->get();
        //return !$buecher->contains('id', $value);
        return !$ausgelieheneBuecher->contains('buch_id', $value);
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
