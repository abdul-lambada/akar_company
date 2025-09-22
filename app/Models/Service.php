<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $primaryKey = 'service_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'service_name',
        'slug',
    ];

    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class, 'project_services', 'service_id', 'project_id');
    }

    public function getRouteKeyName(): string
    {
        return 'service_id';
    }
}