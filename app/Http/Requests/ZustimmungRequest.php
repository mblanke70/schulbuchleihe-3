<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZustimmungRequest extends FormRequest
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
        $rules['zustimmung'] = 'required';
        
        return $rules;
    }

    public function messages()
    {
        return [
            'zustimmung.required' => 'Sie müssen Ihre Zustimmung erteilen.',
        ];
    }
}
