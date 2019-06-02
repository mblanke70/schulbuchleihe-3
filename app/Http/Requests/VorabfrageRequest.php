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
            'ermaessigung' => 'required',
            'jahrgang'     => 'required',
        ];
    }

    public function messages()
    {
        return [
            'ermaessigung.required' => 'Ermäßigung nicht ausgewählt.',
            'jahrgang.required'    => 'Jahrgang nicht ausgewählt.',
        ];
    }
}
