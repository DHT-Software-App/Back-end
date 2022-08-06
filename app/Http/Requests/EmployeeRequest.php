<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Silber\Bouncer\Database\Ability;

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
            'email_address' => 'required|max:100|email|unique:employees,email_address,' . ($this->employee ? $this->employee->id : ''),
            'state' => 'required|max:45',
            'street' => 'required|max:45',
            'city' => 'required|max:45',
            'zip' => 'required|numeric',
            'contacts.*' => 'required|distinct|string',
            'status' => [
                Rule::in(['active', 'desactive'])
            ]
        ];
    }

    public function authorize()
    {
        if ($this->isMethod('PUT')) {
            $ownedRole = $this->employee->getRoles()->first();

            return auth()->user()->can('update', [Ability::class, $ownedRole]);
        }

        return true;
    }
}
