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
            'jahrgang'  => 'required',
            'anrede'    => 'required',
            'vorname'   => 'required',
            'nachname'  => 'required',
            'strasse'   => 'required',
            'ort'       => 'required',
            'plz'       => 'required|digits:5',
            'email'     => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'jahrgang.required'     => 'Jahrgang nicht ausgewählt.',
            'anrede.required'       => 'Anrede nicht angegeben.',
            'vorname.required'      => 'Vorname nicht angegeben.',
            'nachname.required'     => 'Nachname nicht angegeben.',
            'strasse.required'      => 'Straße nicht angegeben.',
            'ort.required'          => 'Ort nicht angegeben.',
            'plz.required'          => 'Die Postleitzahl muss angegeben werden.',
            'plz.digits'            => 'Die Postleitzahl muss 5-stellig sein.',
            'email.required'        => 'Email nicht angegeben.',
        ];
    }
}
