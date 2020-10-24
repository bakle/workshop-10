<?php

namespace App\Constants;

use Illuminate\Support\Str;

class PaymentStatus
{
    public const FAILED = 0;
    public const APPROVED = 1;
    public const DECLINED = 2;
    public const PENDING = 3;
    public const REJECTED = 4;

    public const STATUSES = [
        self::FAILED => 'failed',
        self::APPROVED => 'approved',
        self::DECLINED => 'declined',
        self::PENDING => 'pending',
        self::REJECTED => 'rejected',
    ];

    public static function isPending(string $status): bool
    {
        return Str::lower($status) === 'pending';
    }

    public static function isApproved(string $status): bool
    {
        return Str::lower($status) === 'approved';
    }
}
