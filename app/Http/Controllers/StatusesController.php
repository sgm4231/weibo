<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Status;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*因为创建微博的用户始终为当前用户，借助 Laravel 提供的 Auth::user() 方法我们可以获取到当前用户实例。在创建微博的时候，我们需要对微博的内容进行赋值，因此最终的创建方法如下：
    由于我们接下来会在主页上同时显示微博发布表单和微博动态，因此在用户完成微博的创建之后，需要将其导向至上一次发出请求的页面，即网站主页，因此我们可以使用 back 方法来完成：*/
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);

        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);
        session()->flash('success', '发布成功！');
        return redirect()->back();
    }

    public function destroy(Status $status)
    {
        //做删除授权的检测，不通过会抛出 403 异常
        //app\Policies\StatusPolicy.php
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '微博已被成功删除！');
        return redirect()->back();
    }
}