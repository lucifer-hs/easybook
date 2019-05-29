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
Route::get('/', "\App\Http\Controllers\LoginController@welcome");
//用户模块
//注册页面


//注册行为
Route::post('/register', "\App\Http\Controllers\RegisterController@register");
//登录页面
Route::get('login', "\App\Http\Controllers\LoginController@index");
//登陆行为
Route::post('/login', "\App\Http\Controllers\LoginController@login");
//登出行为
Route::get('/logout', "\App\Http\Controllers\LoginController@logout");
//个人设置页面
Route::get('/user/me/setting', "\App\Http\Controllers\UserController@setting");
//个人设置操作
Route::post('/user/me/setting', "\App\Http\Controllers\UserController@settingStore");


Route::group(['middleware' => 'auth:web'], function(){
	//文章列表页
	Route::get('/posts','\App\Http\Controllers\PostController@index');
	//创建文章
	Route::get('/posts/create','\App\Http\Controllers\PostController@create');
	Route::post('/posts','\App\Http\Controllers\PostController@store');
	//搜索结果页
	Route::get('/posts/search', '\App\Http\Controllers\PostController@search');
	//文章详情页
	Route::get('/posts/{post}','\App\Http\Controllers\PostController@show');
	//编辑文章
	Route::get('/posts/{post}/edit','\App\Http\Controllers\PostController@edit');
	Route::put('/posts/{post}','\App\Http\Controllers\PostController@update');
	//删除文章
	Route::get('/posts/{post}/delete','\App\Http\Controllers\PostController@delete');
	//图片上传
	Route::post('/posts/image/upload', '\App\Http\Controllers\PostController@imageUpload');
	//评论
	Route::post('/posts/{post}/comment', '\App\Http\Controllers\PostController@comment');
	//赞
	Route::get('/posts/{post}/zan', '\App\Http\Controllers\PostController@zan');
	//取消赞
	Route::get('/posts/{post}/unzan', '\App\Http\Controllers\PostController@unzan');


	// 个人中心
	Route::get('/user/{user}', '\App\Http\Controllers\UserController@show');

	// 个人设置
	Route::get('/user/{user}/setting', '\App\Http\Controllers\UserController@setting');
	Route::post('/user/{user}/setting', '\App\Http\Controllers\UserController@settingStore');

	//关注
	Route::post('/user/{user}/fan', '\App\Http\Controllers\UserController@fan');
	//取消关注
	Route::post('/user/{user}/unfan', '\App\Http\Controllers\UserController@unfan');

	// 专题
	Route::get('/topic/{topic}', '\App\Http\Controllers\TopicController@show');
	Route::get('/topic/{topic}/submit', '\App\Http\Controllers\TopicController@submit');

	// 通知
	Route::get('/notices', '\App\Http\Controllers\NoticeController@index');
});
//管理后台
Route::group(['prefix' => 'admin'], function() {

    Route::get('/login', '\App\Admin\Controllers\LoginController@index');
    Route::post('/login', '\App\Admin\Controllers\LoginController@login');
    Route::get('/logout', '\App\Admin\Controllers\LoginController@logout');

    // 需要登陆的
    Route::group(['middleware' => 'auth:admin'], function(){
        Route::get('/home', '\App\Admin\Controllers\HomeController@index');

        // 系统管理
        Route::group(['middleware' => 'can:system'], function(){
            // 用户管理
            Route::get('/users', '\App\Admin\Controllers\UserController@index');
            Route::get('/users/create', '\App\Admin\Controllers\UserController@create');
            Route::post('/users/store', '\App\Admin\Controllers\UserController@store');
            Route::get('/users/{user}/role', '\App\Admin\Controllers\UserController@role');
            Route::post('/users/{user}/role', '\App\Admin\Controllers\UserController@storeRole');

            // 角色管理
            Route::get('/roles', '\App\Admin\Controllers\RoleController@index');
            Route::get('/roles/create', '\App\Admin\Controllers\RoleController@create');
            Route::post('/roles/store', '\App\Admin\Controllers\RoleController@store');
            Route::get('/roles/{role}/permission', '\App\Admin\Controllers\RoleController@permission');
            Route::post('/roles/{role}/permission', '\App\Admin\Controllers\RoleController@storePermission');

            // 权限管理
            Route::get('/permissions', '\App\Admin\Controllers\PermissionController@index');
            Route::get('/permissions/create', '\App\Admin\Controllers\PermissionController@create');
            Route::post('/permissions/store', '\App\Admin\Controllers\PermissionController@store');
        });

        // 文章管理
        Route::group(['middleware' => 'can:post'], function() {
            // 文章管理
            Route::get('/posts', '\App\Admin\Controllers\PostController@index');
            Route::post('/posts/{post}/status', '\App\Admin\Controllers\PostController@status');
        });

        // 专题模块
        Route::group(['middleware' => 'can:topic'], function(){
            Route::resource('topics', '\App\Admin\Controllers\TopicController', ['only' => [
                'index', 'create', 'store', 'destroy'
            ]]);
        });

        // 通知模块
        Route::group(['middleware' => 'can:notice'], function(){
           Route::resource('notices', '\App\Admin\Controllers\NoticeController', [
               'only' => ['index', 'create', 'store'],
           ]);
        });
    });
});