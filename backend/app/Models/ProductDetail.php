<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    /**
     * Tắt tính năng tự động quản lý timestamps (created_at, updated_at)
     * vì bảng này không có chúng.
     */
    public $timestamps = false;

    /**
     * Các trường được phép gán hàng loạt.
     */
    protected $fillable = [
        'product_id',
        'description'
    ];

    /**
     * Lấy sản phẩm cha của chi tiết này.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Lấy các hình ảnh của chi tiết này.
     */
    public function images()
    {
        return $this->hasMany(ProductDetailImage::class);
    }
}
