<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendarRequest extends APIRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_date' => 'required|date_format:Y-m-d H:i:s',
            'end_date' => 'required|date_format:Y-m-d H:i:s',
            'notes' => 'required|max:3500|regex:/^[a-z ,.\'-]+$/i',
            'job_id' => 'required', 'int',
            'employee_id' => 'required', 'int'
        ];
    }
}
