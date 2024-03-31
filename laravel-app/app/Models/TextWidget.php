<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TextWidget extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(TextWidgetCategory::class);
    }

    public function getContentExcerptAttribute()
    {
        return Str::limit($this->content, 25);
    }
}
