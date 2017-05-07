<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class UsersRequest extends BaseRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
	    return [
	        'name' => 'required||max:255',
	        'email' => 'required|email|unique:users',
	        'password' => 'required|max:20',
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
	    // return [
	    //     'name.required' => 'User name is required',
	    //     'email.required'  => 'User email is required.',
	    //     'role_id.required'  => 'User role is required.',
	    //     'password.required' => 'Password is required.'
	    // ];
	    return [];
	}
}
