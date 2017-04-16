<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class NewsRequest extends BaseRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
	    return [
	        'title' => 'required|unique:news|max:255',
	        'publish_time' => 'required',
	        'audio-file' => 'required|file|mimetypes:video/avi,video/mpeg,video/mp4,audio/mpeg,audio/mp4'
	    ];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
	    // $comment = Comment::find($this->route('comment'));

	    // return $comment && $this->user()->can('update', $comment);
	    return true;
	}

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
	    return [
	        'title.required' => 'A title is required',
	        'publish_time.required'  => 'the publish time is required for new',
	    ];
	}
}
