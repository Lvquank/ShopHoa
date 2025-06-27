<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('user'); 
        $emailRule = "required|email|max:255|unique:users,email";
        if ($id) 
        {
            $emailRule .= ",{$id}";
            $name = $this->name;
            echo $name;
            $email = $this->email;
            $password = $this->password;
            $rules = [];
            if ($name) {
                $rules['name'] = 'required|string|max:255';
            }
            if ($email) {
                $rules['email'] = $emailRule;
            }
            if ($password) {
                $rules['password'] = 'required|string|min:8|confirmed';
            }
            return $rules;

        }
        return [
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:users,email",
            "password" => "required|string|min:8|confirmed",
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'The username is required.',
            'email.required' => 'The email is required.',
            'password.required' => 'The password is required.',
            'email.unique' => 'The email has already been taken.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
    public function attributes(): array
    {
        return [
            'username' => 'Tên tài khoản',
            'email' => 'Email',
            'password' => 'Mật khẩu',
        ];  
    }
}
