<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Models\User;
use App\Models\UserResetToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Exception;

class AuthController extends Controller
{
    /**
     * Xử lý yêu cầu đăng ký của người dùng.
     */
    public function register(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone_number' => 'required|numeric|digits:10',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'username.required' => 'Tên không được bỏ trống.',
            'username.max' => 'Tên quá dài. Chọn tên ngắn hơn.',
            'email.required' => 'Email không được bỏ trống.',
            'email.unique' => 'Email đã được sử dụng.',
            'phone_number.digits' => 'Số điện thoại không đúng định dạng.',
            'password.required' => 'Mật khẩu không được bỏ trống.',
            'password.min' => 'Mật khẩu phải từ 6 kí tự trở lên.',
            'password.confirmed' => 'Mật khẩu xác nhận không trùng khớp.',
        ]);

        try {
            // Tạo người dùng mới
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($validated['username']),
                'password' => Hash::make($validated['password']),
                'role_id' => 2,
            ]);

            // Tạo một API token cho người dùng vừa tạo
            $token = $user->createToken('auth_token_register')->plainTextToken;

            // Trả về response JSON chứa token
            return response()->json([
                'status' => true,
                'message' => 'Đăng ký tài khoản thành công!',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'data' => $user
            ], 201); // HTTP 201 Created

        } catch (Exception $e) {
            // Trả về lỗi nếu có sự cố
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại!',
                'error' => $e->getMessage()
            ], 500); // HTTP 500 Internal Server Error
        }
    }

    /**
     * Xử lý yêu cầu đăng nhập.
     */
    public function login(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Tìm người dùng bằng email
        $user = User::where('email', $request->email)->where('role_id', 2)->first();

        // Kiểm tra người dùng có tồn tại và mật khẩu có đúng không
        if (!$user || !Hash::check($request->password, $user->password)) {
            // Nếu sai, trả về lỗi 401 Unauthorized
            return response()->json([
                'status' => false,
                'message' => 'Email hoặc mật khẩu không chính xác.',
            ], 401);
        }

        // Nếu đúng, tạo một API token cho người dùng
        $token = $user->createToken('auth_token_login')->plainTextToken;

        // Trả về thông tin người dùng và token
        return response()->json([
            'status' => true,
            'message' => 'Đăng nhập thành công!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => $user,
        ]);
    }

    /**
     * Xử lý yêu cầu đăng xuất.
     */
    public function logout(Request $request)
    {
        // Thu hồi token đã được sử dụng để xác thực yêu cầu hiện tại
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Đã đăng xuất thành công!',
        ]);
    }

    /**
     * Gửi email quên mật khẩu.
     */
    public function forgotPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email không được bỏ trống.',
            'email.exists' => 'Không có tài khoản nào được đăng ký với email này.',
        ]);

        $user = User::where('email', $validated['email'])->first();
        $token = Str::random(60);

        // Xóa token cũ và tạo token mới
        UserResetToken::where('email', $validated['email'])->delete();
        $tokenData = UserResetToken::create([
            'email' => $validated['email'],
            'token' => $token,
        ]);

        if ($tokenData) {
            // Gửi email
            Mail::to($validated['email'])->send(new ForgotPassword($user, $token));

            return response()->json([
                'status' => true,
                'message' => 'Link đặt lại mật khẩu đã được gửi vào email của bạn!',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Hành động thất bại. Vui lòng thử lại!',
        ], 500);
    }

    /**
     * Kiểm tra tính hợp lệ của token reset mật khẩu.
     */
    public function validateResetToken($token)
    {
        $tokenData = UserResetToken::where('token', $token)->first();

        if (!$tokenData) {
            return response()->json([
                'status' => false,
                'message' => 'Token không hợp lệ hoặc đã hết hạn.',
            ], 404);
        }

        // Có thể thêm kiểm tra thời gian hết hạn của token ở đây

        return response()->json([
            'status' => true,
            'message' => 'Token hợp lệ.',
            'data' => [
                'token' => $token
            ]
        ]);
    }

    /**
     * Đặt lại mật khẩu mới.
     */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string|exists:user_reset_tokens,token',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'token.exists' => 'Token không hợp lệ hoặc đã hết hạn.',
            'password.required' => 'Mật khẩu không được bỏ trống.',
            'password.min' => 'Mật khẩu phải từ 6 kí tự trở lên.',
            'password.confirmed' => 'Mật khẩu xác nhận không trùng khớp.',
        ]);

        $tokenData = UserResetToken::where('token', $validated['token'])->first();
        $user = User::where('email', $tokenData->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy người dùng với email tương ứng.',
            ], 404);
        }

        // Cập nhật mật khẩu mới
        $user->password = Hash::make($validated['password']);
        $user->save();

        // Xóa token sau khi đã sử dụng
        UserResetToken::where('email', $user->email)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Mật khẩu đã được đặt lại thành công!',
        ]);
    }
    public function check(Request $request)
    {
        // Chỉ cần trả về thông tin người dùng đang được xác thực.
        return response()->json([
            'status' => true,
            'user' => $request->user(),
        ]);
    }
}
