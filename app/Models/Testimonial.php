<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        'image_path',
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

    /**
     * Public URL for the client image associated with this testimonial.
     */
    public function getImageUrlAttribute(): string
    {
        $path = (string) ($this->image_path ?? '');
        if ($path === '') {
            return '';
        }
        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }
        return Storage::url($path);
    }
}