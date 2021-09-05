<?php

namespace App\Http\Requests\Music;

use Illuminate\Foundation\Http\FormRequest;

class Register extends FormRequest
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
            'name' => 'required|string|max:10',
            'username' => 'required|string|max:10|unique:admins',
            'password' => 'required|string|max:20'
        ];
    }

    public function attributes()
    {
        return [
            'name' => '姓名',
            'username' => '帳號',
            'password' => '密碼'
        ];
    }
}
