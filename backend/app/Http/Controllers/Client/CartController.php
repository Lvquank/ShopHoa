<?php

// Namespace đã được cập nhật để khớp với cấu trúc thư mục
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Thêm sản phẩm vào giỏ hàng.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        if (!$user) {
            // Mặc dù logic controller yêu cầu đăng nhập, việc kiểm tra này vẫn quan trọng
            // để phòng trường hợp route được gọi mà không có middleware 'auth'.
            return response()->json(['message' => 'Bạn cần đăng nhập để thực hiện chức năng này.'], 401);
        }

        // SỬA ĐỔI: Loại bỏ session_id. Giờ đây giỏ hàng chỉ được tạo hoặc tìm dựa trên user_id.
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Gọi phương thức addItem() của model để xử lý logic
        $cart->addItem($request->product_id, $request->quantity);

        return $this->getCartResponse('Thêm vào giỏ hàng thành công');
    }

    /**
     * Cập nhật số lượng của một sản phẩm.
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0'
        ]);

        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart) {
            return response()->json(['message' => 'Giỏ hàng không tồn tại'], 404);
        }

        if ($request->quantity == 0) {
            // Gọi phương thức removeItem()
            $cart->removeItem($request->product_id);
        } else {
            // Gọi phương thức updateItemQuantity()
            $cart->updateItemQuantity($request->product_id, $request->quantity);
        }

        return $this->getCartResponse('Cập nhật giỏ hàng thành công');
    }

    /**
     * Xóa một sản phẩm khỏi giỏ hàng.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            // Gọi phương thức removeItem()
            $cart->removeItem($request->product_id);
        }

        return $this->getCartResponse('Xóa sản phẩm thành công');
    }

    /**
     * Hiển thị thông tin giỏ hàng.
     */
    public function show()
    {
        return $this->getCartResponse('Lấy thông tin giỏ hàng thành công');
    }

    /**
     * Helper function để lấy và định dạng dữ liệu giỏ hàng trả về.
     */
    private function getCartResponse(string $message)
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'message' => $message,
                'items' => [],
                'count' => 0,
                'total' => 0
            ]);
        }

        $items = $cart->items->map(function ($item) {
            if (!$item->product) return null;
            return [
                'id' => $item->product->id,
                'name' => $item->product->title,
                'image' => $item->product->image,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'line_total' => $item->quantity * $item->product->price,
            ];
        })->filter()->values();

        // Sử dụng các phương thức accessor đã định nghĩa trong Model (nếu có)
        // để đảm bảo tính nhất quán
        return response()->json([
            'message' => $message,
            'items' => $items,
            'count' => $cart->items_count, // Lấy từ accessor hoặc cột đã tính toán
            'total' => (float) $cart->total_amount // Lấy từ accessor hoặc cột đã tính toán
        ]);
    }
}
