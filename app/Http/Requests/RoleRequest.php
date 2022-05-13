<?php

namespace App\Http\Requests;

use Symfony\Component\HttpFoundation\Response;
use App\Models\Employee;

class RoleRequest extends APIRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'exists:roles,name'
            ]
        ];
    }

}
