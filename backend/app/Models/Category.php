<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Thêm để code rõ ràng

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

    public function styles(): BelongsToMany
    {
        return $this->belongsToMany(Style::class, 'category_style')
            ->using(CategoryStyle::class)
            ->withPivot('description')
            ->withTimestamps();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
