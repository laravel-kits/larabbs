<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function root()
    {
        return view('pages.root');
    }

    public function emailVerifyNotice(Request $request)
    {
        return view('pages.email_verify_notice');
    }

    public function notificationCount()
    {
        $notification_count = \Auth::user()->notification_count;
        if ($notification_count > 0) {
            return [
                'success' => '存在数据',
                'notification_count' => $notification_count,
            ];
        } else {
            return [
                'failed' => '不存在数据',
            ];
        }
    }
}
