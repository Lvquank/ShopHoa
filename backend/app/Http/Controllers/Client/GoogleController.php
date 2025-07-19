<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Xử lý callback từ Google sau khi người dùng xác thực ở frontend.
     * Phương thức này nhận access_token từ React.
     */
    public function handleGoogleCallbackApi(Request $request)
    {
        // 1. Validate xem client có gửi access_token không
        $request->validate([
            'access_token' => 'required|string',
        ]);

        try {
            // 2. Dùng access_token để lấy thông tin người dùng từ Google
            // Socialite sẽ tự động sử dụng client_id và client_secret từ config/services.php
            $googleUser = Socialite::driver('google')->userFromToken($request->access_token);

            // 3. Tìm người dùng trong DB bằng google_id, nếu không có thì tìm bằng email
            $user = User::where('google_id', $googleUser->getId())->orWhere('email', $googleUser->getEmail())->first();

            if ($user) {
                // Nếu người dùng đã tồn tại, cập nhật lại google_id và avatar nếu cần
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $user->avatar ?? $googleUser->getAvatar(),
                ]);
            } else {
                // Nếu người dùng chưa tồn tại, tạo mới
                $user = User::create([
                    'username' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'role_id' => 2, // Gán role mặc định
                    'password' => Hash::make(uniqid()), // Tạo mật khẩu ngẫu nhiên vì không cần dùng
                ]);
            }

            // 4. Tạo một API token của Laravel (Sanctum) cho người dùng này
            $laravelToken = $user->createToken('auth_token_google')->plainTextToken;

            // 5. Trả về response thành công cùng với token của bạn
            return response()->json([
                'status' => true,
                'message' => 'Đăng nhập bằng Google thành công!',
                'access_token' => $laravelToken,
                'token_type' => 'Bearer',
                'data' => $user,
            ]);
        } catch (Exception $e) {
            // Nếu token không hợp lệ hoặc có lỗi khác
            return response()->json([
                'status' => false,
                'message' => 'Xác thực thất bại hoặc token không hợp lệ.',
                'error' => $e->getMessage(),
            ], 401); // 401 Unauthorized
        }
    }
}
