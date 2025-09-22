<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $table = 'portfolio';
    protected $primaryKey = 'project_id';
    public $incrementing = true;

    protected $fillable = [
        'project_title',
        'client_name',
    ];

    public function getRouteKeyName()
    {
        return 'project_id';
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'project_services', 'project_id', 'service_id');
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class, 'project_id', 'project_id');
    }
}