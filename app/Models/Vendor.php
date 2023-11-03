<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'phone_number',
        'address',
        'password',
        'email',
        'profile_picture'
    ];

    protected $hidden = [
        'user_id',
        "user",
        'password',
        'remember_token',
        'role_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
