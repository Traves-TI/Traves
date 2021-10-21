<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2'
        ];
    }

    public function messages()
    {
        return [
            'min'=> __('The field :attribute must have at least :min characters'),
            'required' => __('The field <b>:attribute</b> is mandatory'),
        ];
    }

}
