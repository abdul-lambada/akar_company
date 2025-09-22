<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';
    protected $primaryKey = 'order_item_id';
    public $incrementing = true;

    protected $fillable = [
        'order_id',
        'service_id',
        'price_at_order',
    ];

    public function getRouteKeyName()
    {
        return 'order_item_id';
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }
}