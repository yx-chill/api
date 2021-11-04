<?php

namespace App\Http\Requests\Music;

use Illuminate\Foundation\Http\FormRequest;

class MusicType extends FormRequest
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
			'name' => 'required|string|min:3|max:15',
			'sort' => 'nullable|integer|min:0|max:255',
			'status' => 'nullable|boolean'
		];
	}

	public function attributes()
	{
		return [
			'name' => '曲風',
			'sort' => '排序',
			'status' => '狀態'
		];
	}
}
