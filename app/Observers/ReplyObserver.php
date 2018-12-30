<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        // \DB::enableQueryLog();
        // $reply->topic->increment('reply_count', 1);
        // dd(\DB::getQueryLog());
        // =@ https://laravel-china.org/topics/18759
        $topic = $reply->topic;
        $topic->increment('reply_count', 1);
        // 通知作者话题被回复了
        $topic->user->topicNotify(new TopicReplied($reply));
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->decrement('reply_count', 1);
    }
}