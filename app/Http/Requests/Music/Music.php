<?php

namespace App\Http\Requests\Music;

use Illuminate\Foundation\Http\FormRequest;

class Music extends FormRequest
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
		switch ($this->method()) {
			case 'POST':
				return [
					'music_type_id' => 'required|exists:music_music_types,id',
					'name' => 'required|string|min:3|max:20',
					'composer' => 'required|string|min:3|max:20',
					'file' => 'required|file|mimetypes:audio/mpeg|max:5120',
					'sort' => 'nullable|integer|min:0|max:255',
					'status' => 'nullable|boolean'
				];
			case 'PUT':
				// return [
				// 	'name' => 'required|string|min:3|max:15',
				// 	'sort' => 'required|integer|min:0|max:255',
				// 	'status' => 'required|boolean'
				// ];
		}
	}

	public function attributes()
	{
		return [
			'music_type_id' => '類別',
			'name' => '名稱',
			'composer' => '作曲家',
			'file' => '檔案',
			'sort' => '排序',
			'status' => '狀態'
		];
	}
}
