<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VorabfrageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'ermaessigung' => 'required',
            'jahrgang'      => 'required',
            'geschlecht'    => 'required',
            'vorname'       => 'required',
            'nachname'      => 'required',
            'strasse'       => 'required',
            'ort'           => 'required',
            'email'         => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            //'ermaessigung.required' => 'Ermäßigung nicht ausgewählt.',
            'jahrgang.required'     => 'Jahrgang nicht ausgewählt.',
            'geschlecht.required'   => 'Anrede nicht angegeben.',
            'vorname.required'      => 'Vorname nicht angegeben.',
            'nachname.required'     => 'Nachname nicht angegeben.',
            'strasse.required'      => 'Straße nicht angegeben.',
            'ort.required'          => 'Ort nicht angegeben.',
            'email.required'        => 'Email nicht angegeben.',
        ];
    }
}
