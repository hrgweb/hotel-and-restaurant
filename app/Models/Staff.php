<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'staffs';
    protected $with = ['staff_role'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function staff_role()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }
}
