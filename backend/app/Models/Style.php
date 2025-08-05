<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Thêm để code rõ ràng

class Style extends Model
{
    use HasFactory;

    protected $table = 'styles';

    /**
     * SỬA LỖI: Thêm các trường vào mảng fillable.
     */
    protected $fillable = [
        'name',
        'alias',
        'order',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_style')
            ->using(CategoryStyle::class)
            ->withPivot('description')
            ->withTimestamps();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'style_id', 'id');
    }
}
