<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class TextWidget extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    
    protected $fillable = [
        'description',
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
