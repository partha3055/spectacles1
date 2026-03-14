<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'pincode',
        'billing_address',
        'billing_city',
        'billing_pincode',
        'subtotal',
        'shipping',
        'total',
        'payment_method',
        'payment_status',
        'order_status',
        'notes',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber()
    {
        $lastOrder = self::orderBy('id', 'desc')->first();
        $nextId = $lastOrder ? $lastOrder->id + 1 : 1;
        return 'ORD' . date('Y') . str_pad($nextId, 5, '0', STR_PAD_LEFT);
    }
}
