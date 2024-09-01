<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PublishLog extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'user_id'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->user_id = Auth::id();
            }
        });
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
