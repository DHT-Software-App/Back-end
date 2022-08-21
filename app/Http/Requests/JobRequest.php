<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends APIRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'claim_number' => 'required|numeric',
            'note' => 'required|max:3500|regex:/^[a-z ,.\'-]+$/i',
            'date_of_lost' => 'required|date_format:Y-m-d H:i:s',
            'type_of_loss' => 'required|max:3500|regex:/^[a-z ,.\'-]+$/i',
            'status' => 'required|regex:/^[a-z ,.\'-]+$/i',
            'state' => 'required|max:45',
            'street' => 'required|max:45',
            'city' => 'required|max:45',
            'zip' => 'required|numeric',
            'company' => 'required|max:80',
            'employee_id' => 'required', 'int',
            'customer_id' => 'required', 'int',
            'client_id' => 'required', 'int',
            'work_type_id' => 'required', 'int',
            'insurance_id' => 'required', 'int'
        ];
    }
}
