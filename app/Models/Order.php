<?php

namespace App\Models;

use App\Enum\OrderStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Enum\OrderApprovalStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];
    protected $casts = [
        'status' => OrderStatusEnum::class,
        'approval_status' => OrderApprovalStatusEnum::class,

    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }


    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function tracking()
    {
        return $this->hasMany(OrderTracking::class);
    }

    public static function generateOrderNumber()
    {
        return DB::transaction(function () {
            $lastOrder = self::orderBy('id', 'desc')->lockForUpdate()->first();
            $nextNumber = $lastOrder ? ((int) preg_replace('/[^0-9]/', '', $lastOrder->order_number)) + 1 : 1000;
            return 'ORD' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }
}
