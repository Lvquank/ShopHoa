<?php

namespace App\Http\Controllers\Client; // Cập nhật namespace để nhất quán

use App\Http\Controllers\Controller;
use App\Models\Cart; // Sử dụng Cart Model
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Province;

class CheckoutController extends Controller
{
    /**
     * Bắt buộc người dùng phải đăng nhập để truy cập các phương thức trong controller này.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Cung cấp dữ liệu cần thiết cho trang thanh toán.
     */
    public function getCheckoutData()
    {
        $user = Auth::user();
        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

        $cartItems = [];
        $cartTotalPrice = 0;

        if ($cart && !$cart->items->isEmpty()) {
            // Định dạng lại cart items để nhất quán và chỉ lấy thông tin cần thiết
            $cartItems = $cart->items->map(function ($item) {
                if (!$item->product) return null; // Bỏ qua nếu sản phẩm đã bị xóa
                return [
                    'productId'   => $item->product->id,
                    'productName' => $item->product->title, // Giả sử model Product có thuộc tính 'title'
                    'quantity'    => $item->quantity,
                    'price'       => $item->product->price,
                ];
            })->filter()->values()->all();

            // Lấy tổng tiền từ accessor của Cart model
            $cartTotalPrice = $cart->total_amount;
        }

        $provinces = Province::select('id', 'name', 'gso_id', 'shipping')->get();

        return response()->json([
            'cart' => [
                'items'       => $cartItems,
                'total_price' => (float) $cartTotalPrice,
            ],
            'provinces' => $provinces,
        ]);
    }

    /**
     * Xử lý yêu cầu đặt hàng từ frontend.
     */
    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'nullable|email|max:255',
            'phone_number' => 'required|string|regex:/^(0[35789])\d{8}$/',
            'province_id'  => 'required|exists:provinces,id',
            'district_id'  => 'required|exists:districts,id',
            'ward_id'      => 'required|exists:wards,id',
            'address_detail' => 'nullable|string|max:255',
            'note'         => 'nullable|string',
        ], [
            // ... các message validation không đổi
            'name.required' => 'Họ và tên không được bỏ trống.',
            'phone_number.required' => 'Số điện thoại không được bỏ trống.',
            'phone_number.regex' => 'Số điện thoại không đúng định dạng.',
            'province_id.required' => 'Tỉnh/thành không được bỏ trống.',
            'district_id.required' => 'Quận/huyện không được bỏ trống.',
            'ward_id.required' => 'Phường/xã không được bỏ trống.',
        ]);

        $user = Auth::user();
        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

        // Kiểm tra nếu giỏ hàng không tồn tại hoặc trống
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Giỏ hàng của bạn đang trống.'], 400);
        }

        try {
            DB::beginTransaction();

            $province = Province::findOrFail($validated['province_id']);
            $cartTotalPrice = $cart->total_amount; // Lấy tổng tiền từ cart model
            $totalAmount = (float) $cartTotalPrice + (float) $province->shipping;

            // 1. Tạo đơn hàng
            $order = Order::create([
                'user_id'        => $user->id, // Luôn có user_id vì đã bắt buộc đăng nhập
                'name'           => $validated['name'],
                'email'          => $validated['email'],
                'phone_number'   => $validated['phone_number'],
                'province_id'    => $validated['province_id'],
                'district_id'    => $validated['district_id'],
                'ward_id'        => $validated['ward_id'],
                'address_detail' => $validated['address_detail'],
                'note'           => $validated['note'],
                'total_price'    => $cartTotalPrice,
                'shipping'       => $province->shipping,
                'total_amount'   => $totalAmount,
                'status_id'      => 1,
                'code'           => 'TEMP_' . now()->format('YmdHis')
            ]);

            $order->code = 'DH' . now()->format('ymd') . $order->id;
            $order->save();

            // 2. Thêm các sản phẩm vào chi tiết đơn hàng
            foreach ($cart->items as $item) {
                // Đảm bảo sản phẩm của item vẫn tồn tại
                if ($item->product) {
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $item->product_id,
                        'quantity'   => $item->quantity,
                        'price'      => $item->product->price
                    ]);
                }
            }

            // Hoàn tất giao dịch
            DB::commit();

            // Xóa giỏ hàng sau khi đã đặt hàng thành công
            $cart->delete();

            return response()->json([
                'message'    => 'Đặt hàng thành công! Cảm ơn bạn đã mua hàng.',
                'order_code' => $order->code,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Creation Failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Đã có lỗi xảy ra khi tạo đơn hàng. Vui lòng thử lại sau.'
            ], 500);
        }
    }
}
