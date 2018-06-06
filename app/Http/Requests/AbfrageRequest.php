<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Abfrage;

class AbfrageRequest extends FormRequest
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
        $abfrage = $this->request->get('abfrage'); 

        foreach( $abfrage as $key => $val)
        {
            //$abfr = Abfrage::find($key);
            //if( empty($abfr->parent_id) ||
            //    (!empty($abfr->parent_id) && !empty($abfrage[$abfr->parent_id]) ) )
            {
                $rules['abfrage.'.$key] = 'required';
            }           
        }

        //dd($rules);

        return $rules;
    }

    public function messages()
    {
        return [
            'abfrage.*.required' => 'Jede Abfrage muss beantwortet werden.',
        ];
    }
}
