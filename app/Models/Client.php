<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        // optional logo path stored relative to storage/public or an absolute URL
        'logo_path',
    ];

    public function getRouteKeyName()
    {
        return 'client_id';
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'client_id', 'client_id');
    }

    /**
     * Public URL for the client's logo.
     */
    public function getLogoUrlAttribute(): string
    {
        $path = (string) ($this->logo_path ?? '');
        if ($path === '') {
            return '';
        }
        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }
        return Storage::url($path);
    }
}