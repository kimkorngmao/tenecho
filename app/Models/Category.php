<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    //
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'order', 
        'is_featured'
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

    public function children() {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function articles(){
        return $this->hasMany(Article::class);
    }

    public static function shiftOrder(int $fromOrder)
    {
        $categories = static::where('order', '>=', $fromOrder)
        ->orderBy('order', 'desc')
        ->get();

        foreach ($categories as $category) {
            $category->order += 1;
            $category->save();
        }
    }

}
