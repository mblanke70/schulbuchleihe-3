<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WahlRequest extends FormRequest
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
        foreach($this->request->get('wahlen') as $key => $val)
        {
            $rules['wahlen.'.$key] = 'required';
        }

        return $rules;
        
        /*
        $rules['wahlen.*'] = 'required';
        //dd($rules);     
        return $rules;
        */
    }

    public function messages()
    {
        $wahlen = $this->request->get('wahlen'); 

        return [
            'wahlen.*.required' => 'Für jeden Buchtitel muss eine Wahl getroffen werden.',
        ];
    }
}
