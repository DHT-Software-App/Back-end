<?php

namespace App\Http\Requests;

class ClientRequest extends APIRequest
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
            'email_address_1' => 'required|max:100|email',
            'email_address_2' => 'required|max:100|email',
            'state' => 'required|max:45',
            'street' => 'required|max:45',
            'city' => 'required|max:45',
            'zip' => 'required|numeric',
            'company' => 'required|max:75',
            'contacts.*' => 'required|distinct|string'
        ];
    }
}
