<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['order_data', 'company_id', 'completed_at', 'total'];

    protected $casts = [
        'completed_at' => 'datetime',
        'order_data' => 'array'
    ];
}
