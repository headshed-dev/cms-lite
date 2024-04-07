<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
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
