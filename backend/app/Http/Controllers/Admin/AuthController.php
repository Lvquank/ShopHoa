<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string|min:6',
            ]);

            $status = Auth::attempt([
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role_id' => 1
            ]);

            if ($status) {
                $user = Auth::user();
                return response()->json([
                    'status' => true,
                    'message' => 'Đăng nhập thành công!',
                    'user' => $user
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Email hoặc mật khẩu không đúng!'
            ], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Admin login error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi đăng nhập. Vui lòng thử lại!',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out'
        ]);
    }
}
