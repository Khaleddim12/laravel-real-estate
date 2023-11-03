<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public $table = "permissions";

    protected $fillable = ["action", "resource"];

    protected $hidden = ['pivot'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class, 'role_permission');
    }
}
