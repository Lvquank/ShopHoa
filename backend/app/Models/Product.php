<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['title', 'image', 'category', 'description'];

    public function details()
    {
        return $this->hasMany(ProductDetail::class);
    }
}
