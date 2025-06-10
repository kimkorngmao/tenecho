<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'page_visited'
    ];

    public static function track($page)
    {
        // check if page and ip are already tracked today
        $existingVisit = static::where('ip_address', request()->ip())
            ->where('page_visited', $page)
            ->whereDate('created_at', today())
            ->first();

        if ($existingVisit) {
            return $existingVisit;
        }

        return static::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'page_visited' => $page
        ]);
    }
}
