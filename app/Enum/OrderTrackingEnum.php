<?php

namespace App\Enum;

enum OrderTrackingEnum: string
{
    case PROCESSING = 'processing';
    case READY_FOR_PICKUP = 'ready_for_pickup';
    case OUT_FOR_DELIVERY = 'out_for_delivery';
    case CANCELLED = 'cancelled';

    public function lang(): string
    {
        return match ($this) {
            self::PROCESSING => __("api.processing"),
            self::READY_FOR_PICKUP => __("api.ready_for_pickup"),
            self::OUT_FOR_DELIVERY => __("api.out_for_delivery"),
            self::CANCELLED => __("api.cancelled"),
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::PROCESSING => 'btn btn-info text-center',
            self::READY_FOR_PICKUP => 'btn btn-primary text-center',
            self::OUT_FOR_DELIVERY => 'btn btn-secondary text-center',
            self::CANCELLED => 'btn btn-danger text-center',
        };
    }

    public static function vals(): array
    {
        return [
            self::PROCESSING->value,
            self::READY_FOR_PICKUP->value,
            self::OUT_FOR_DELIVERY->value,
            self::CANCELLED->value,
        ];
    }
}
