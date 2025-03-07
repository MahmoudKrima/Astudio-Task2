<?php

namespace App\Enum;

enum OrderApprovalStatusEnum: string
{
    case PENDING  = 'pending';
    case REJECTED  = 'rejected';
    case APPROVED  = 'approved';

    public function lang(): string
    {
        return match ($this) {
            self::PENDING => __("api.pending"),
            self::REJECTED => __("api.rejected"),
            self::APPROVED => __("api.approved"),
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::PENDING => 'btn btn-warning text-center',
            self::REJECTED => 'btn btn-danger text-center',
            self::APPROVED => 'btn btn-success text-center',
        };
    }

    public static function vals(): array
    {
        return [
            self::PENDING->value,
            self::REJECTED->value,
            self::APPROVED->value,
        ];
    }
}
