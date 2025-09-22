<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}