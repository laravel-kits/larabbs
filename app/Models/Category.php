<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Category extends Model
{
    protected $fillable = [
        'name', 'description',
    ];

    public function categories()
    {
        $categories = Cache::get('category_key');
        if (is_null($categories)) {
            $categories = static::all();
            Cache::set('category_key', $categories, 30);
        }
        return $categories;
    }
}
