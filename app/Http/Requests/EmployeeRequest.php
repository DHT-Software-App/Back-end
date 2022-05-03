<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class EmployeeRequest extends APIRequest
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
            'email_address' => 'required|max:100|email|unique:employees,email_address, '.$this->employee,
            'contact_1' => 'required|max:50',
            'contact_2' => 'required|max:50',
            'state' => 'required|max:45',
            'street' => 'required|max:45',
            'city' => 'required|max:45',
            'zip' => 'required|numeric',
        ];
    }



}
