<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';
    protected $primaryKey = 'client_id';
    public $incrementing = true;

    protected $fillable = [
        'client_name',
        'email',
        'whatsapp',
        'address',
    ];

    public function getRouteKeyName()
    {
        return 'client_id';
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'client_id', 'client_id');
    }
}