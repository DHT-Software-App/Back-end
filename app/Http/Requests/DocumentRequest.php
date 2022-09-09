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
            'url' => 'nullable|file|max:5120|mimes:jpeg,png,jpg,pdf',
            'job_id' => ['required', 'exists:jobs,id'],
            'document_type_id' => ['required', 'exists:document_types,id']
        ];
    }
}
