<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Category extends Model
{
    protected $fillable = [
        'name', 'description',
    ];
    protected $cache_key = 'category_key';
    protected $cache_time = 30; // 30分钟

    public function categories()
    {
        if (is_null(Cache::get($this->cache_key))) {
            Cache::set($this->cache_key, static::all(), $this->cache_time);
        }
        return Cache::get($this->cache_key);
    }
}
