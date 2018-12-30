<?php

namespace App\Observers;

use App\Jobs\TranslateSlug;
use App\Models\Topic;
use App\Models\TimeOuts;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    // saving 数据库入库前
    public function saving(Topic $topic)
    {
        // XSS 过滤
        $topic->body = clean($topic->body, 'user_topic_body');
        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);
    }

    // 模型监控器的 saved() 方法对应 Eloquent 的 saved 事件，此事件发生在创建和编辑时、数据入库以后。在 saved() 方法中调用，
    // 确保了我们在分发任务时，$topic->id 永远有值。
    public function saved(Topic $topic)
    {
        // 添加话题时间间隔
        $key = 'topic_create_' . \Auth::id();
        if (!app(TimeOuts::class)->get($key)) {
            TimeOuts::put($key, Topic::TTL);
        }
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译 isDirty判断是都是更新数据
        if (!$topic->slug || $topic->isDirty()) {
            // 推送任务到队列
            dispatch(new TranslateSlug($topic));
            // 修复edit或者编辑的时候会跑到路由后面的问题
            // @url https://laravel-china.org/topics/14584/slug-has-bug?#reply76507
            if (trim($topic->slug) === 'edit') {
                $topic->slug = 'edit-slug';
            }
        }
    }

    public function deleted(Topic $topic)
    {
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}