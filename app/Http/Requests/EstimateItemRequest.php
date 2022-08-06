<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EstimateItemRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50|regex:/^[a-z ,.\'-]+$/i|unique:estimate_items,name,' . ($this->estimateItem ? $this->estimateItem->id : ''),
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'unit' => 'required|max:5',
            'item_type' => [
                Rule::in(['service', 'machine'])
            ],
            'work_type_id' => 'required|exists:work_types,id'
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'price.regex' => 'Price should be a currency amount.',
            'work_type_id.exists' => 'Not existing work type'
        ];
    }
}
