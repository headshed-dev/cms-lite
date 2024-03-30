<?php

namespace App\Models;

use App\Events\ExportBlogArticles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'keywords',
        'content',
        'image',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    protected static function booted()
    {
        static::created(function ($blog) {
            event(new ExportBlogArticles($blog));
        });

        static::updated(function ($blog) {
            event(new ExportBlogArticles($blog));
        });

        static::deleted(function ($blog) {
            event(new ExportBlogArticles($blog));
        });
    }
}
