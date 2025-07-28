<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'phone_number',
        'avatar',
        'password',
        'role_id',
        'google_id',
        'facebook_id'
    ];

    public function order()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }
}
