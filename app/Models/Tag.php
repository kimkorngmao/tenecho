<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = mb_strtolower(trim(preg_replace('/[^\p{L}\p{Nd}]+/u', '-', $model->name), '-'));
            }
        });
    }

    public function articles(){
        return $this->belongsToMany(Article::class);
    }
}
