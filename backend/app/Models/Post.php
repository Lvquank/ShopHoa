<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Thêm dòng này

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    /**
     * Các thuộc tính có thể được gán hàng loạt.
     * Sửa lại cho đúng với các trường bạn muốn lưu.
     */
    protected $fillable = [
        'title',
        'post_category_id',
        'description',
        'content', // <-- THIẾU
        'author',
        'image', // <-- THIẾU
        'title_seo',
        'is_featured', // <-- THIẾU
        'histotal',
    ];

    /**
     * Lấy danh mục của bài viết.
     */
    public function category(): BelongsTo // Sửa lại để code tường minh hơn
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    /**
     * Lấy tất cả các ảnh trong thư viện của bài viết.
     */
    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class)->orderBy('order');
    }
}
