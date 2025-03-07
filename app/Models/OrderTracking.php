<?php

namespace App\Models;

use App\Enum\OrderTrackingEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderTracking extends Model
{
    use HasFactory;
    protected $guarded = ['created_at', 'updated_at'];

    protected $casts = [
        'type' => OrderTrackingEnum::class,
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
