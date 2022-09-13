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
            'end_date' => 'required|date_format:Y-m-d H:i:s|after:start_date',
            'address' => 'required|max:255',
            'notes' => 'required|max:255',
            'contacts.*' => 'required|distinct|string',
            'employee_id' => ['required', 'exists:employees,id'],
            'job_id' => ['required', 'exists:jobs,id'],
        ];
    }
}
