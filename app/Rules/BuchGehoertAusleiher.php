<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Buch;

class BuchGehoertAusleiher implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($buch, $ausleiher)
    {
        $this->buch = $buch;
        $this->ausleiher = $ausleiher;
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
        if($this->buch && $this->buch->ausleiher)
        {
            return $this->buch->ausleiher->id == $this->ausleiher;
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
        return 'Dieses Buch ist von ' . $this->buch->ausleiher->vorname . ' ' . $this->buch->ausleiher->nachname . ' (' . $this->buch->ausleiher->klasse->bezeichnung . ') ausgeliehen worden!';
    }
}
