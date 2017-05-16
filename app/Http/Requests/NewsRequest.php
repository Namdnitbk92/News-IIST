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
	// public function rules()
	// {
	//     return [
	//     ];
	// }

	public function rules()
	{
		$rules = [
	        'title' => 'required|max:255',
	        'publish_time' => 'required',
	        'attach-file' => 'file|mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
	    ];
	    $filesType = \Request::get('file_type');
	    if ($filesType === 'text')
	    {
	    	// $rules = array_merge($rules, ['audio_text' => 'required']);
	    }
	    else if($filesType === 'audio')
	    {
	    	$rules = array_merge($rules, ['audio-file' => 'file|mimetypes:audio/mpeg,audio/mp4']);
	    }
	    else if($filesType === 'video')
	    {
	    	$rules = array_merge($rules, ['audio-file' => 'file|mimetypes:video/avi,video/mpeg,video/mp4']);
	    }

	    return $rules;
	}

	public function getQuickRules()
	{
		return [
	        'title' => 'required|unique:news|max:255',
	        'audio_text' => 'required',
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
