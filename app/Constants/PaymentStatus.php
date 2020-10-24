<?php

namespace App\Constants;

interface PaymentStatus
{
    public const FAILED = 0;
    public const APPROVED = 1;
    public const DECLINED = 2;
    public const PENDING = 3;

    public const STATUSES = [
        self::FAILED => 'failed',
        self::APPROVED => 'approved',
        self::DECLINED => 'declined',
        self::PENDING => 'pending',
    ];
}
