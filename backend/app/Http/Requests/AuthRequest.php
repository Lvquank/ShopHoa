<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];
        $route = $this->route()->getName();

        // Nếu không có route name, sử dụng path để xác định action
        if (!$route) {
            $path = $this->path();
            if (str_contains($path, 'register')) {
                $route = 'register';
            } elseif (str_contains($path, 'login')) {
                $route = 'login';
            } elseif (str_contains($path, 'forgot-password')) {
                $route = 'forgot-password';
            } elseif (str_contains($path, 'reset-password')) {
                $route = 'reset-password';
            }
        }

        switch ($route) {
            case 'register':
                $rules = [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'phone_number' => 'required|numeric|digits:10',
                    'password' => 'required|string|min:6',
                    'confirm_password' => 'required|same:password'
                ];
                break;

            case 'login':
                $rules = [
                    'email' => 'required|email',
                    'password' => 'required'
                ];
                break;

            case 'forgot-password':
                $rules = [
                    'email' => 'required|email|exists:users,email'
                ];
                break;

            case 'reset-password':
                $rules = [
                    'password' => 'required|string|min:6',
                    'confirm_password' => 'required|same:password'
                ];
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được bỏ trống.',
            'name.max' => 'Tên quá dài. Chọn tên ngắn hơn',
            'email.required' => 'Email không được bỏ trống.',
            'email.unique' => 'Email đã được sử dụng.',
            'email.exists' => 'Không có tài khoản sử dụng email này.',
            'phone_number' => 'Số điên thoại không đúng định dạng.',
            'password.required' => 'Password không được bỏ trống.',
            'password.min' => 'Password phải từ 6 kí tự trở lên.',
            'confirm_password.same' => 'Mật khẩu không trùng khớp.',
        ];
    }
}
