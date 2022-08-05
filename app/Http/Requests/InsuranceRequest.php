<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsuranceRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:75|regex:/^[a-z ,.\'-]+$/i',
            'email_address_1' => 'required|max:100|email',
            'email_address_2' => 'required|max:100|email',
            'contact_1' => 'required|max:50',
            'contact_2' => 'required|max:50',
            'state' => 'required|max:45',
            'street' => 'required|max:45',
            'city' => 'required|max:45',
            'zip' => 'required|numeric',
            'company' => 'required|max:75',
        ];
    }
}
