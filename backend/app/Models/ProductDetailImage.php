<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetailImage extends Model
{
    use HasFactory;

    /**
     * Tắt tính năng tự động quản lý timestamps (created_at, updated_at)
     * vì bảng 'product_detail_images' không có các cột này.
     */
    public $timestamps = false;

    /**
     * Các trường được phép gán hàng loạt (mass-assignable).
     */
    protected $fillable = [
        'product_detail_id',
        'order',
        'image',
        'caption',
    ];

    /**
     * Định nghĩa mối quan hệ ngược lại:
     * Mỗi hình ảnh chi tiết thuộc về một chi tiết sản phẩm (ProductDetail).
     */
    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class);
    }
}
