<?php

namespace App\Listeners;

use App\Notifications\EmailVerificationNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

// implements ShouldQueue 让这个监听器异步执行
class RegisteredListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * 当事件被触发时，对应该事件的监听器的 handle() 方法就会被调用
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        // 获取刚刚注册的用户
        $user = $event->user;
        // 调用notify 发送通知
        $user->notify(new EmailVerificationNotification());
    }
}
