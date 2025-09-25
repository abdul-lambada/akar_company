<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use App\Models\Service;

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
        // keep optional if present in schema
        'service_id',
    ];

    public function getRouteKeyName()
    {
        return 'order_id';
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'order_id', 'order_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }
}