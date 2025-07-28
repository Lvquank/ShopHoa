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
        'status'
    ];
    public function styles(): HasMany
    {
        // Một Category có nhiều Styles.
        // Laravel sẽ tự động tìm kiếm khóa ngoại 'category_id' trong bảng 'styles'.
        return $this->hasMany(Style::class, 'category_id', 'id');
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
