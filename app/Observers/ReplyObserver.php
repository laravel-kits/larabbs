<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        // \DB::enableQueryLog();
        // $reply->topic->increment('reply_count', 1);
        // dd(\DB::getQueryLog());
        $reply->topic()->increment('reply_count', 1);
    }
}