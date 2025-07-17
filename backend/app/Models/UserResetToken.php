<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserResetToken extends Model
{
    protected $table = 'user_reset_tokens';

    protected $fillable = [
        'email',
        'token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
