<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioImage extends Model
{
    use HasFactory;

    protected $table = 'portfolio_images';

    protected $fillable = [
        'project_id',
        'image_path',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class, 'project_id', 'project_id');
    }

    /**
     * Get publicly accessible URL for the image.
     */
    public function getUrlAttribute(): string
    {
        $path = (string) ($this->image_path ?? '');

        if ($path === '') {
            return '';
        }

        // If already absolute or already starting from public root
        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }

        // Default: use storage URL (requires `php artisan storage:link`)
        return Storage::url($path);
    }
}