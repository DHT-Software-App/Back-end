<?php

namespace App\Http\Requests;

use App\Http\Resources\InvalidAttributeCollection;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

abstract class APIRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }
   
    protected function failedValidation(Validator $validator) {
        $formatError = invalid_attribute_format($validator->errors());
        
        throw (new HttpResponseException(response()->json(new InvalidAttributeCollection($formatError), Response::HTTP_BAD_REQUEST)));
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if($this->_method) {
            $this->request->remove('_method');
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();
}
