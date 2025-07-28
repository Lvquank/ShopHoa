<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $orders = Order::all();
        $users = User::where('role_id', 2)->get();
        $reviews = ProductReview::all();

        $years = Order::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view(
            'admin.pages.dashboard',
            compact(
                'products',
                'orders',
                'users',
                'reviews',
                'years'
            )
        );
    }

    public function ckeditorImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();

            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->storeAs('public/images/uploads', $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');

            $url = asset('storage/images/uploads/' . $fileName);
            $msg = 'Tải ảnh thành công';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

    public function fileBrowser()
    {
        $paths = glob(public_path('storage/images/uploads/*'));
        $fileNames = array();
        foreach ($paths as $path) {
            array_push($fileNames, basename($path));
        }

        $data = array(
            'fileNames' => $fileNames
        );
        return view('admin.images.file-browser')->with($data);
    }

    public function config()
    {
        $configs = Config::all()->pluck('value', 'key')->toArray();
        return view('admin.pages.config.config', compact('configs'));
    }

    public function updateConfig(Request $request)
    {
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            if ($key === 'logo') {
                continue;
            }
            Config::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $originalName = $file->getClientOriginalName();

            $oldLogo = Config::where('key', 'logo')->value('value');
            // Cần một phương thức helper để xóa ảnh, tạm thời comment lại
            // $this->deleteImageIfExists('images/config/' . $oldLogo);
            $file->storeAs('images/config', $originalName, 'public');
            Config::updateOrCreate(
                ['key' => 'logo'],
                ['value' => $originalName]
            );
        }

        Cache::forget('site_configs');

        return redirect()->back();
    }

    public function formLogon()
    {
        return view('admin.pages.auth.login');
    }

    /**
     * Xử lý yêu cầu đăng nhập của admin.
     */
    public function logon(Request $request): RedirectResponse
    {
        // 1. Validate dữ liệu đầu vào từ form
        $validated = $request->validate([
            'name' => ['required', 'string'], // 'name' là name của thẻ input trong form
            'password' => ['required', 'string'],
        ], [
            'name.required' => 'Tên đăng nhập không được bỏ trống.',
            'password.required' => 'Mật khẩu không được bỏ trống.',
        ]);

        // 2. Chuẩn bị mảng credentials với đúng tên cột trong database
        $credentials = [
            'username' => $validated['name'], // Sửa key thành 'username' để khớp với cột trong bảng users
            'password' => $validated['password'],
            'role_id' => 1,
        ];

        // 3. Sử dụng guard 'web' để thực hiện đăng nhập
        if (Auth::guard('web')->attempt($credentials)) {
            // 4. Tạo lại session để tăng cường bảo mật
            $request->session()->regenerate();

            // 5. Chuyển hướng đến trang dashboard nếu thành công
            return redirect()->intended(route('admin.dashboard'))->with('success', 'Đăng nhập thành công!');
        }

        // 6. Nếu thất bại, quay lại trang trước với thông báo lỗi
        return back()->with('error', 'Tài khoản hoặc mật khẩu không đúng hoặc bạn không có quyền truy cập.')->withInput();
    }

    /**
     * Xử lý đăng xuất.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function formChangePassword()
    {
        return view('admin.pages.auth.change-password');
    }

    public function changePassword(Request $request, $adminId)
    {
        $validated = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|same:new_password'
        ], [
            'old_password.required' => 'Nhập mật khẩu cũ.',
            'new_password.required' => 'Nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu phải từ 6 kí tự trở lên.',
            'confirm_password.same' => 'Mật khẩu không trùng khớp.',
        ]);

        $admin = User::findOrFail($adminId);
        if (!Hash::check($request->old_password, $admin->password)) {
            return redirect()->back()->with('error', 'Mật khẩu không đúng.');
        }

        try {
            $admin->password = Hash::make($request->new_password);
            $admin->save();
            return redirect()->route('admin.dashboard')->with('success', 'Đổi mật khẩu thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi đổi mật khẩu. Vui lòng thử lại!');
        }
    }
}
