<?php

namespace App\Models;

use App\Constants\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $appends = ['status_name'];

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getStatusNameAttribute(): string
    {
        return Str::ucfirst(OrderStatus::STATUSES[$this->status]);
    }
}
