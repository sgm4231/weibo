<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class StaticPagesController extends Controller
{
    public function home()
    {
        /*我们定义了一个空数组 feed_items 来保存微博动态数据。
        由于用户在访问首页时，可能存在登录或未登录两种状态，
        因此我们需要确保当前用户已进行登录时才从数据库读取数据。
        前面章节我们已讲过，可以使用 Auth::check() 来检查用户是否已登录。
        另外我们还对微博做了分页处理的操作，每页只显示 30 条微博。*/
        $feed_items = [];
        if (Auth::check()) {
            $feed_items = Auth::user()->feed()->paginate(10);
        }

        return view('static_pages/home', compact('feed_items'));
    }

    public function help()
    {
        return view('static_pages/help');
    }

    public function about()
    {
        return view('static_pages/about');
    }
}
