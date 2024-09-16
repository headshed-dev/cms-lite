<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkdownCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'markdown_card_category_id',
    ];

    public function markdownCardCategory()
    {
        return $this->belongsTo(MarkdownCardCategory::class);
    }

    protected static function booted()
    {
        static::created(function (MarkdownCard $markdownCard) {
            event(new \App\Events\UpsertMarkdownCard($markdownCard));
        });

        static::updated(function (MarkdownCard $markdownCard) {
            event(new \App\Events\UpsertMarkdownCard($markdownCard));
        });

    }


}
