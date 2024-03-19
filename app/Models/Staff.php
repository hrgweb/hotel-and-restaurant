<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'staffs';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function user_role()
    {
        return $this->belongsTo(UserRole::class);
    }
}
