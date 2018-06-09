<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Abfrage;
use App\AbfrageWahlen;

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
        $abfragenRequest = $this->request->get('abfrage'); 

        $jg = $this->user()->jahrgang; if($jg!=20) $jg++;
        $abfragen = Abfrage::where('jahrgang', $jg)->get();

        foreach($abfragen as $abfr)
        {
            if( empty($abfr->parent_id) ||
                (!empty($abfr->parent_id) && !empty($abfragenRequest[$abfr->parent_id]) ) )
            {
                $rules['abfrage.'.$abfr->id] = 'required';
            }           
        }

        //dd($abfragenRequest, $rules);

        return $rules;
    }

    public function messages()
    {
        return [
            'abfrage.*.required' => 'Jede Abfrage muss beantwortet werden.',
        ];
    }
}
