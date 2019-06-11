<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('signup', 'UsersController@create')->name('signup');
Route::resource('users', 'UsersController');

//等同于
//显示所有用户列表的页面
//Route::get('/users', 'UsersController@index')->name('users.index');
//创建用户的页面
//Route::get('/users/create', 'UsersController@create')->name('users.create');
//显示用户个人信息的页面
//Route::get('/users/{user}', 'UsersController@show')->name('users.show');
//创建用户
//Route::post('/users', 'UsersController@store')->name('users.store');
//编辑用户个人资料的页面
//Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
//更新用户
//Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
//删除用户
//Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');

//显示登陆页面
Route::get('login', 'SessionsController@create')->name('login');
//创建新会话（登录）
Route::post('login', 'SessionsController@store')->name('login');
//销毁会话（退出登录）
Route::delete('logout', 'SessionsController@destroy')->name('logout');
//用户注册激活令牌
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

//显示重置密码的邮箱发送页面
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//邮箱发送重设链接
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//密码更新页面
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//执行密码更新操作
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');