<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextWidgetCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function textWidgets()
    {
        return $this->hasMany(TextWidget::class);
    }
}
