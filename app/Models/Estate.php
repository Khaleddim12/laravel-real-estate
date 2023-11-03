<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    use HasFactory;
    protected $fillable=['address', 'price', 'available', 'user_id' ];

    protected $hidden = ['user_id'];

    // In the Estate model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deals()
    {
        return $this->belongsToMany(User::class, 'deals')->withTimestamps();
    }
}
