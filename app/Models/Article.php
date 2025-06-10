<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $fillable = [
        'type',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image_url',
        'status',
        'published_at',
        'author_id', // foreign key
        'category_id', // foreign key
        'meta_description',
        'is_featured',
        'view_count'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = mb_strtolower(trim(preg_replace('/[^\p{L}\p{Nd}]+/u', '-', $model->title), '-'));
            }
        });
    }

    public function author(){
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
