<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $table = 'testimonials';
    protected $primaryKey = 'testimonial_id';
    public $incrementing = true;

    protected $fillable = [
        'client_name',
        'testimonial_text',
        'project_id',
    ];

    public function getRouteKeyName()
    {
        return 'testimonial_id';
    }

    public function project()
    {
        return $this->belongsTo(Portfolio::class, 'project_id', 'project_id');
    }

    // Alias relation agar konsisten dengan penggunaan di controller & view
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class, 'project_id', 'project_id');
    }
}