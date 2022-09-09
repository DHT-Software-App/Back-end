<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'policy_number' => 'required|string|max:75',
            'claim_number' => 'required|string|max:75',
            'notes' => 'required|max:255|regex:/^[a-z ,.\'-]+$/i',
            'date_of_loss' => 'required|date_format:Y-m-d H:i:s',
            'type_of_loss' => 'required|max:75|regex:/^[a-z ,.\'-]+$/i',
            'status' => [
                Rule::in(['new', 'on going', 'completed']),
            ],
            'state' => 'required|max:45',
            'street' => 'required|max:45',
            'city' => 'required|max:45',
            'zip' => 'required|string',
            'company' => 'required|max:75',
            'customer_id' => ['required', 'exists:customers,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'work_type_id' => ['required', 'exists:work_types,id'],
            'insurance_id' => ['required', 'exists:insurances,id']
        ];
    }
}
