<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'required|max:50|regex:/^[a-z ,.\'-]+$/i',
            'lastname' => 'required|max:50|regex:/^[a-z ,.\'-]+$/i',
            'has_insured' => "required|boolean",
            'insured_firstname' => 'required_if:has_insured,true|max:50|regex:/^[a-z ,.\'-]+$/i',
            'insured_lastname' => 'required_if:has_insured,true|max:50|regex:/^[a-z ,.\'-]+$/i',
            'email_address' => 'required|max:100|email',
            'state' => 'required|max:45',
            'street' => 'required|max:45',
            'city' => 'required|max:45',
            'zip' => 'required|numeric',
            'contacts.*' => 'required|distinct|string',
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated()
    {

        if (request()->has_insured) {
            return parent::validated();
        }

        return request()->except(['insured_firstname', 'insured_lastname']);
    }


    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'insured_firstname.required_if' => 'The insured firstname field is required.',
            'insured_lastname.required_if' => 'The insured lastname field is required'
        ];
    }
}
