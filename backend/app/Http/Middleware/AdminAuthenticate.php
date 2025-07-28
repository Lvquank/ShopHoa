<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // BƯỚC 1: KIỂM TRA XEM ĐÃ ĐĂNG NHẬP CHƯA
        if (!Auth::check()) {
            // Nếu chưa đăng nhập, chắc chắn chuyển về trang logon.
            return redirect()->route('formLogon');
        }

        // BƯỚC 2: GỠ LỖI (DEBUG)
        // Bỏ comment dòng dd() dưới đây để xem chính xác giá trị role của bạn là gì.
        // Sau khi đăng nhập, màn hình sẽ dừng lại và hiển thị giá trị.
        // Hãy kiểm tra xem nó có phải là số 1 không.
        // dd(Auth::user()->role);


        // BƯỚC 3: SỬA LẠI ĐIỀU KIỆN
        // Sau khi đã biết chính xác giá trị, bạn có thể sửa lại điều kiện cho đúng.
        // Phép so sánh == sẽ linh hoạt hơn (chấp nhận cả số 1 và chuỗi '1').
        if (Auth::user()->role_id == 1) {
            // Nếu đúng là admin, cho phép đi tiếp.
            return $next($request);
        }

        // Nếu không phải admin, chuyển về trang đăng nhập với thông báo lỗi.
        return redirect()->route('formLogon')->with('error', 'Bạn không có quyền truy cập vào khu vực này.');
    }
}
