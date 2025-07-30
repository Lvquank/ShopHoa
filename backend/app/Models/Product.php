<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Thêm use statement này
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Product extends Model
{
    use HasFactory;

    /**
     * Tên bảng được liên kết với model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * Cho biết model có nên được đóng dấu thời gian hay không.
     * Bảng 'products' của bạn có các cột created_at và updated_at.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Các thuộc tính có thể được gán hàng loạt.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_code',
        'title',
        'description',
        'tag',
        'image',
        'is_on_top',
        'is_new',
        'price',
        'purchases',
        'category_id',
        'style_id',
        'order',
        'stock_status',
    ];
    protected $casts = [
        'is_on_top' => 'boolean',
        'is_new' => 'boolean',
    ];

    /**
     * Lấy category (danh mục) mà Product này thuộc về.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Lấy style (kiểu dáng) của Product này.
     */
    public function style(): BelongsTo
    {
        return $this->belongsTo(Style::class, 'style_id', 'id');
    }

    /**
     * Lấy các chi tiết của sản phẩm.
     */
    public function details(): HasMany
    {
        return $this->hasMany(ProductDetail::class);
    }
    public function detailImages(): HasManyThrough
    {
        return $this->hasManyThrough(
            ProductDetailImage::class,
            ProductDetail::class,
            'product_id',
            'product_detail_id',
            'id',
            'id'
        );
    }
}
