<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkTypeRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50|regex:/^[a-z ,.\'-]+$/i|unique:work_types,name,' . ($this->workType ? $this->workType->id : ''),
            'description' => 'required|max:255'
        ];
    }
}
