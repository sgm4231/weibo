<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }


    //creating 用于监听模型被创建之前的事件，created 用于监听模型被创建之后的事件。
    //boot 方法会在用户模型类完成初始化之后进行加载，因此我们对事件的监听需要放在该方法中。
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->activation_token = Str::random(10);
        });
    }

    //用户模型中，指明一个用户拥有多条微博。
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }


    /*我们需要在用户模型中定义一个 feed 方法，
    该方法将当前用户发布过的所有微博从数据库中取出，
    并根据创建时间来倒序排序。在后面我们为用户增加关注人的功能之后，
    将使用该方法来获取当前用户关注的人发布过的所有微博动态。
    现在的 feed 方法定义如下：*/
    public function feed()
    {
        return $this->statuses()
            ->orderBy('created_at', 'desc');
    }




}
