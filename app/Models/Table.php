<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function vacant()
    {
        return $this->hasOne(Order::class)->latestOfMany();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
