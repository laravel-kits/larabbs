<?php

namespace App\Observers;

use App\Handles\SlugTranslateHandler;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    // saving 数据库入库前
    public function saving(Topic $topic, SlugTranslateHandler $handler)
    {
        // XSS 过滤
        $topic->body = clean($topic->body, 'user_topic_body');
        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if (!$topic->slug) {
            $topic->slug = $handler->translate($topic->title);;
        }
    }
}