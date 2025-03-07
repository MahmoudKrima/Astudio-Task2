<?php

namespace App\Enum;

enum OrderStatusEnum: string
{
    case PENDING  = 'pending';
    case APPROVED  = 'aprroved';

    public function lang(): string
    {
        return match ($this) {
            self::PENDING => __("api.pending"),
            self::APPROVED => __("api.aprroved"),
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::PENDING => 'btn btn-warning text-center',
            self::APPROVED => 'btn btn-success text-center',
        };
    }

    public static function vals(): array
    {
        return [
            self::PENDING->value,
            self::APPROVED->value,
        ];
    }
}
