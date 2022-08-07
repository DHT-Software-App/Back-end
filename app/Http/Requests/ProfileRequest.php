<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nickname' => 'required|max:50|regex:/^[a-z ,.\'-]+$/i|unique:profiles,nickname,' . ($this->profile ? $this->profile->id : ''),
            'url' => 'nullable|file|max:1024|mimes:jpeg,png,jpg'
        ];
    }
}
