<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'published_at',
        'status'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    protected static function booted()
    {
        static::created(function ($news) {
            Log::info('News Article Created', $news->toArray());
        });
        
        static::updated(function ($news) {
            Log::info('News Article Updated', $news->toArray());
        });
    }
} 