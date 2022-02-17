<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieSearchRequest extends FormRequest
{

    public function prepareForValidation() {
        $all = $this->all();
        if(array_key_exists('query', $all)) {
            $this->merge([
                'query' => urlencode($all['query'])
            ]);
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'query' => ['string', 'required' ]
        ];
    }
}
