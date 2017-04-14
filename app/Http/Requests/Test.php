<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class Test extends FormRequest
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
            'title' => 'required|unique:news|max:255',
            'publish_time' => 'required|',
            'audio_file' => 'file|mimetypes:video/avi,video/mpeg,video/mp4,audio/mpeg,audio/mp4'
        ];
    }

    // protected function formatErrors(Validator $validator)
    // {
    //     return $validator->errors()->all();
    // }
}
