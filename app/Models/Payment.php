<?php

namespace App\Models;

use App\Constants\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'request_id',
        'status',
        'process_url',
        'receipt',
        'authorization',
        'currency',
        'total_paid',
        'paid_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getStatusNameAttribute()
    {
        return Str::ucfirst(PaymentStatus::STATUSES[$this->status]);
    }

    public function isPending(): bool
    {
        return $this->status === PaymentStatus::PENDING;
    }
}
