<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends APIRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|max:3000|regex:/^[a-z ,.\'-]+$/i',
            'url' => 'required|max:3000',
            'job_id' => 'required', 'int',
            'document_type_id' => 'required', 'int'
        ];
    }
}
