<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkdownCardCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function markdownCards()
    {
        return $this->hasMany(MarkdownCard::class);
    }
}
