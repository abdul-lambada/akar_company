<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $incrementing = true;

    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_whatsapp',
        'total_amount',
        'status',
    ];

    public function getRouteKeyName()
    {
        return 'order_id';
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}