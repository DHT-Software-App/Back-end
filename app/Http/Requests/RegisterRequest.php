<?php

namespace App\Http\Requests;

use Symfony\Component\HttpFoundation\Response;

class RegisterRequest extends APIRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|max:100|email|unique:users,email, ',
        ];
    }

    public function prepareForValidation() {
        parent::prepareForValidation();
    }
}
