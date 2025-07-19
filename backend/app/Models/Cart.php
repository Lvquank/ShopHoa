<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * SỬA ĐỔI: Đã loại bỏ 'session_id' và 'expires_at'.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'total_amount',
        'items_count',
        'status',
    ];

    /**
     * The attributes that should be cast.
     * SỬA ĐỔI: Đã loại bỏ 'expires_at'.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get all items in the cart
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the user that owns the cart
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate total amount for the cart
     *
     * @return float
     */
    public function calculateTotal(): float
    {
        // Eager load products to prevent N+1 query issues
        $this->loadMissing('items.product');
        return $this->items->sum(function ($item) {
            // Check if product exists to avoid errors
            if ($item->product) {
                return $item->quantity * $item->product->price;
            }
            return 0;
        });
    }

    /**
     * Update cart totals
     *
     * @return void
     */
    public function updateTotals(): void
    {
        $this->total_amount = $this->calculateTotal();
        // Use query builder sum for better performance
        $this->items_count = $this->items()->sum('quantity');
        $this->save();
    }

    /**
     * Add item to cart
     *
     * @param int $productId
     * @param int $quantity
     * @return CartItem
     */
    public function addItem(int $productId, int $quantity = 1): CartItem
    {
        $existingItem = $this->items()->where('product_id', $productId)->first();

        if ($existingItem) {
            $existingItem->increment('quantity', $quantity);
            $cartItem = $existingItem;
        } else {
            $cartItem = $this->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        $this->updateTotals();
        return $cartItem;
    }

    /**
     * Remove item from cart
     *
     * @param int $productId
     * @return bool
     */
    public function removeItem(int $productId): bool
    {
        $result = $this->items()->where('product_id', $productId)->delete();
        // Only update totals if an item was actually removed
        if ($result > 0) {
            $this->updateTotals();
        }
        return $result > 0;
    }

    /**
     * Update item quantity
     *
     * @param int $productId
     * @param int $quantity
     * @return CartItem|null
     */
    public function updateItemQuantity(int $productId, int $quantity): ?CartItem
    {
        $item = $this->items()->where('product_id', $productId)->first();

        if ($item) {
            // If quantity is 0, it's consistent to remove the item
            if ($quantity <= 0) {
                $this->removeItem($productId);
                return null;
            }

            $item->update(['quantity' => $quantity]);
            $this->updateTotals();
            return $item;
        }

        return null;
    }

    /**
     * Clear all items from cart
     *
     * @return bool
     */
    public function clearItems(): bool
    {
        $result = $this->items()->delete();
        if ($result > 0) {
            $this->updateTotals();
        }
        return $result > 0;
    }

    /**
     * Get item count in cart
     *
     * @return int
     */
    public function getItemCount(): int
    {
        return $this->items()->sum('quantity');
    }

    /**
     * Check if cart has specific product
     *
     * @param int $productId
     * @return bool
     */
    public function hasProduct(int $productId): bool
    {
        return $this->items()->where('product_id', $productId)->exists();
    }

    // ĐÃ XÓA: Các phương thức findBySession() và getOrCreateBySession()
    // đã được loại bỏ vì chúng không còn cần thiết.
}
