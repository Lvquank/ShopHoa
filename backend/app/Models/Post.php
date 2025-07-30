<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    /**
     * Các thuộc tính có thể được gán hàng loạt (Mass Assignable).
     * Mảng này phải chứa TẤT CẢ các cột mà bạn muốn lưu từ form.
     */
    protected $fillable = [
        'post_category_id',
        'title',
        'image',         // <-- Đã có
        'content',       // <-- Đã có
        'description',
        'author',
        'title_seo',
        'order',         // <-- THÊM: Thiếu trường này
        'is_featured',   // <-- Đã có
        'status',        // <-- THÊM: Thiếu trường này
    ];

    /**
     * Lấy danh mục của bài viết.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    /**
     * Lấy tất cả các ảnh trong thư viện của bài viết.
     */
    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class)->orderBy('order', 'asc');
    }
}
