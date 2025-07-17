<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Mail\ForgotPassword;
use App\Models\User;
use App\Models\UserResetToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register(AuthRequest $request)
    {
        try {
            $validated = $request->validated();

            // Kiểm tra xem email đã tồn tại chưa
            if (User::where('email', $validated['email'])->exists()) {
                return response()->json([
                    'message' => 'Email đã được sử dụng',
                    'errors' => ['email' => ['Email đã được sử dụng']]
                ], 422);
            }

            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($validated['username']),
                'password' => Hash::make($validated['password']),
                'role_id' => 2
            ]);

            Auth::login($user);

            return response()->json([
                'message' => 'Đăng ký tài khoản thành công!',
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                ]
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Có lỗi xảy ra khi tạo đăng ký. Vui lòng thử lại!',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function login(AuthRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::where('email', $validated['email'])
                ->where('role_id', 2)
                ->first();

            if ($user && Hash::check($validated['password'], $user->password)) {
                // Tạo token thay vì session
                $token = $user->createToken('auth-token')->plainTextToken;

                return response()->json([
                    'message' => 'Đăng nhập thành công!',
                    'user' => [
                        'id' => $user->id,
                        'username' => $user->username,
                        'email' => $user->email,
                        'avatar' => $user->avatar,
                        'role_id' => $user->role_id,
                    ],
                    'token' => $token
                ]);
            }

            return response()->json([
                'message' => 'Email hoặc mật khẩu không đúng. Vui lòng thử lại!'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Có lỗi xảy ra khi đăng nhập. Vui lòng thử lại!',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function check(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'authenticated' => false,
                'message' => 'Not authenticated'
            ], 401);
        }

        return response()->json([
            'authenticated' => true,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'role_id' => $user->role_id,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Đã đăng xuất!'
        ]);
    }

    public function forgotPassword(AuthRequest $request)
    {
        $validated = $request->validated();

        try {
            $user = User::where('email', $validated['email'])->first();

            // Delete existing tokens
            UserResetToken::where('email', $validated['email'])->delete();

            $token = Str::random(40);
            $tokenData = [
                'email' => $validated['email'],
                'token' => $token
            ];

            if ($resetToken = UserResetToken::create($tokenData)) {
                Mail::to($validated['email'])->send(new ForgotPassword($user, $resetToken->token));

                return response()->json([
                    'message' => 'Kiểm tra email để lấy lại mật khẩu!'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Hành động không thành công. Vui lòng thử lại!'
            ], 500);
        }
    }

    public function resetPassword(AuthRequest $request, $token)
    {
        $validated = $request->validated();

        try {
            $tokenData = UserResetToken::where('token', $token)
                ->where('created_at', '>', now()->subHours(24))
                ->firstOrFail();

            $user = User::where('email', $tokenData->email)->firstOrFail();
            $user->password = Hash::make($validated['password']);
            $user->save();

            // Delete all reset tokens for this user
            UserResetToken::where('email', $user->email)->delete();

            return response()->json([
                'message' => 'Mật khẩu đã được đặt lại thành công!'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Token không hợp lệ hoặc đã hết hạn!'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Có lỗi xảy ra. Vui lòng thử lại!'
            ], 500);
        }
    }
}
