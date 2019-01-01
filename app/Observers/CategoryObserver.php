<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    // @url https://laravel-china.org/topics/17853
    public function deleted(Category $category)
    {
        \Cache::forget($category->cache_key);
        // 删除后所有帖子转移到普通分类5
        $topics = \DB::table('topics')->where('category_id', $category->id)->get();
        foreach ($topics as $topic) {
            \DB::table('topics')->where('category_id', $topic->category_id)->update(
                ['category_id' => 5]
            );
        }
    }
}