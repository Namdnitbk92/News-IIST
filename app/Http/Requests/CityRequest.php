<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class CityRequest extends BaseRequest
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
            'name' => 'required|unique:city|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Field name is required',
        ];
    }
}
