<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Events\ExportBlogArticles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class Blog extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'keywords',
        'content',
        'image',
        'tags',
        'category_id',
        'updated_at',
        'blog_date',
        'is_featured',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function getFormattedDateAttribute()
    {
        $defaultDate = Carbon::parse($this->updated_at)->format('Y-m-d');
        if ($this->blog_date) {
            $defaultDate = Carbon::parse($this->blog_date)->format('Y-m-d');
        }
        return $defaultDate;
    }

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
