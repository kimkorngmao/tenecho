<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
        'url',
        'image',
        'order',
        'article_id',
    ];
    protected $casts = [
        'article_id' => 'integer',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
