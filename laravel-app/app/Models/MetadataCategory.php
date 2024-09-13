<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetadataCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function metadata()
    {
        return $this->hasMany(Metadata::class);
    }
}
