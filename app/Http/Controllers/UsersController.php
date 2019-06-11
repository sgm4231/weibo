<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function __construct()
    {
        //除了以下几个都必须登陆才能访问
        $this->middleware('auth',[
            'except' => ['show', 'create', 'store', 'index']
        ]);

        //只让未登录用户访问登录页面
        //Auth 中间件提供的 guest 选项，
        //用于指定一些只允许未登录用户访问的动作，
        //因此我们需要通过对 guest 属性进行设置，只让未登录用户访问登录页面和注册页面。
        $this->middleware('guest', [
            'only' => ['create']
        ]);
        
    }
    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');

        return redirect()->route('users.show', [$user]);
    }

    public function edit(User $user)
    {
        //这里 update 是指授权类里的 update 授权方法，
        //$user 对应传参 update 授权方法的第二个参数。
        //正如上面定义 update 授权方法时候提起的，调用时，
        //默认情况下，我们 不需要 传递第一个参数，
        //也就是当前登录用户至该方法内，因为框架会自动加载当前登录用户。
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user);
    }


    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        //在删除动作的授权中，我们规定只有当前用户为管理员，且被删除用户不是自己时，授权才能通过
        $this->authorize('destroy', $user);

        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }

}
