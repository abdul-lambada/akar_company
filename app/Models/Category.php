<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'category_name',
        'slug',
    ];

    public function posts()
    {
        return $this->belongsToMany(\App\Models\Post::class, 'post_categories', 'category_id', 'post_id');
    }

    public function getRouteKeyName(): string
    {
        return 'category_id';
    }
}