<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    // Chuyển hướng đến Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Xử lý callback từ Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Tìm hoặc tạo user mới
            $user = User::updateOrCreate([
                'google_id' => $googleUser->id,
            ], [
                'username' => $googleUser->name,
                'email' => $googleUser->email,
                'avatar' => $googleUser->avatar,
                'password' => Hash::make(Str::random(24)), // Tạo mật khẩu ngẫu nhiên
                'role_id' => 2, // Role người dùng thường
            ]);

            // Đăng nhập cho user
            Auth::login($user);

            // Tạo token cho API
            $token = $user->createToken('auth-token')->plainTextToken;

            // Chuyển hướng về trang chủ React với token và thông tin user
            $frontendUrl = config('app.frontend_url', 'http://localhost:5173');

            return redirect($frontendUrl . '/auth/callback?token=' . $token . '&userInfo=' . urlencode(json_encode($user)));
        } catch (\Exception $e) {
            // Chuyển hướng về trang đăng nhập của React nếu có lỗi
            $frontendUrl = config('app.frontend_url', 'http://localhost:5173');
            return redirect($frontendUrl . '/login?error=' . urlencode($e->getMessage()));
        }
    }

    // Tương tự cho Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        // Logic tương tự như Google
    }
}
