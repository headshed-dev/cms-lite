<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'keywords',
        'metadata_category_id',
        'image',
    ];

    public function metadataCategory()
    {
        return $this->belongsTo(MetadataCategory::class);
    }
}
