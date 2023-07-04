<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_PENDING = 0;
    const STATUS_PAID = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_order_id',
        'total',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'total' => 'float',
        'status' => 'integer',
    ];
}
