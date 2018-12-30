<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(ReplyRequest $request, Reply $reply)
    {
        //@url https://laravel-china.org/topics/8731/when-the-content-is-empty-when-the-content-is-filtered-use-a-more-friendly-way-to-handle-the-xss
        $content = clean($request->input('content'), 'user_topic_body'); // 避免与 Request 对象本身的 public 属性冲突，比如 attributes / query 可以很方便地使用 input() 的第二个参数来返回默认值
        if (empty($content)) {
            return redirect()->back()->with('danger', '回复内容错误！');
        }
        $reply->content = $content;
        $reply->user_id = \Auth::id();
        $reply->topic_id = $request->topic_id;
        $reply->save();
        // 访问控制器中的方法除了在路由文件定义路由之外，还可以使用to()这种方式
        return redirect()->to($reply->topic->link())->with('success', '创建成功！');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('destroy', $reply);
        $reply->delete();

        return redirect()->to($reply->topic->link())->with('success', '删除成功！');
    }
}