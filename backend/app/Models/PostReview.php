<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostReview extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'post_id',
        'user_id',
        'name',
        'email',
        'website',
        'comment',
    ];

    /**
     * Lấy bài viết mà bình luận này thuộc về.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Lấy người dùng đã viết bình luận này (nếu có).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
