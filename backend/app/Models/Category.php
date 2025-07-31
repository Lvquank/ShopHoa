<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'alias',
        'status',
        'order',
        'description',
    ];
    public function styles()
    {
        return $this->belongsToMany(Style::class, 'category_style')->withPivot('description');
    }

    /**
     * Lấy tất cả các product (sản phẩm) thuộc về Category này.
     */
    public function products(): HasMany
    {
        // Một Category cũng có nhiều Products.
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
