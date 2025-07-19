<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the cart that owns the item
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the product for this cart item
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate the subtotal for this item
     *
     * @return float
     */
    public function getSubtotal(): float
    {
        return $this->quantity * ($this->price ?? $this->product->price);
    }

    /**
     * Set the price based on the current product price
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cartItem) {
            if (!$cartItem->price) {
                $cartItem->price = $cartItem->product->price;
            }
        });
    }
}
