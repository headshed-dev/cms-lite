<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Contracts\Auditable;

class Image extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'image',
        'alt',
        'description',
        'category_id',
        'attachment_file_name',
    ];

    public function category()
    {
        return $this->belongsTo(ImageCategory::class, 'category_id');
    }

    public function getImageUrlAttribute()
    {
        return '![](/storage/' . $this->image . ')';
    }

}
