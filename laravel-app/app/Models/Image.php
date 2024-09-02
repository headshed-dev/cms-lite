<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Image extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'image',
        'alt',
        'description',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(ImageCategory::class, 'category_id');
    }
}
