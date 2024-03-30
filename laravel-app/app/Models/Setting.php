<?php

namespace App\Models;

use App\Events\ExportBlogArticles;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $fillable = [
        'key',
        'label',
        'value',
        'type',
        'attributes',
    ];

    protected $casts = [
        'attributes' => 'array',
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
