<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CategoryStyle
 *
 * Đây là một model cho bảng trung gian (pivot model) để kết nối Category và Style.
 * Nó cho phép chúng ta tương tác với các thuộc tính riêng của bảng trung gian,
 * ví dụ như cột 'description'.
 *
 * @package App\Models
 */
class CategoryStyle extends Pivot
{
    /**
     * Tên bảng được liên kết với model.
     *
     * @var string
     */
    protected $table = 'category_style';

    /**
     * Cho biết model có nên được đóng dấu thời gian hay không.
     * Bảng của bạn có created_at và updated_at, vì vậy để là true.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Cho biết ID có phải là tự động tăng hay không.
     * Bảng trung gian thường có khóa chính kết hợp nên không tự động tăng.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Các thuộc tính có thể được gán hàng loạt.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'style_id',
        'description',
    ];
}
