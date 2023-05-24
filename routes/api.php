<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




/*Laravel jwt 多表（多用户端）验证隔离的实现
发布于 2020-10-20 10:54:10
8760
举报
Tips: tymon/jwt-auth 作者已通过增加 prv 字段修复这一问题#1167，但是如果你是用 dingo api + jwt 的话，该问题依然存在。#

JWT 多表验证隔离


为什么要做隔离

当同一个 laravel 项目有多端（移动端、管理端……）都需要使用 jwt 做用户验证时，如果用户表有多个（一般都会有），
就需要做 token 隔离，
不然会发生移动端的 token 也能请求管理端的问题，造成用户越权。

会引发这个问题的原因是 laravel 的 jwt token 默认只会存储数据表的主键的值，并没有区分是那个表的。所以只要 token 里携带的
ID 在你的用户表中都存在，就会导致越权验证。*/



// 普通用户
Route::middleware('jwt.role:user')->prefix('user')->group( function () {
    Route::post('test', '\App\Http\Controllers\wt\UsersController@test')->middleware(['refresh.token:api']);

    //搜索
    Route::post('type/select/all', '\App\Http\Controllers\wt\Competiton_InfController@find_all_user')->middleware(['refresh.token:super']);
    //提交报名
    Route::post('add/information', '\App\Http\Controllers\wt\Competiton_users@inf_add')->middleware(['refresh.token:super']);
    //批量报名
    Route::post('add/array/information', '\App\Http\Controllers\wt\Competiton_users@inf_add_array')->middleware(['refresh.token:super']);
    //excel
    Route::post('excel/school','\App\Http\Controllers\wt\ExcelController@export')->middleware(['refresh.token:super']);


    /*
     * 用户端yyh
     */
    Route::get('yongcha','teacher@yongcha');//默认报名信息报名
    Route::post('sancyong','teacher@sancyong');//删除
    Route::post('piliangshancyong','teacher@piliangshancyong');//批量删除



});

// 管理员
Route::middleware('jwt.role:admin')->prefix('admin')->group( function () {
    Route::post('registered', '\App\Http\Controllers\wt\AdminController@registered');
    Route::post('test', '\App\Http\Controllers\wt\AdminController@test')->middleware(['refresh.token:super']);


    // 添加项目
    Route::post('type/add', '\App\Http\Controllers\wt\Competiton_InfController@add')->middleware(['refresh.token:super']);
    //搜索
    Route::post('type/select/all', '\App\Http\Controllers\wt\Competiton_InfController@find_all')->middleware(['refresh.token:super']);
    //添加用户
    Route::post('add/users','\App\Http\Controllers\wt\AdminController@registered')->middleware(['refresh.token:super']);
    // 批量删除学校信息
    Route::post('delete/array/users','\App\Http\Controllers\wt\AdminController@delete_user_arr')->middleware(['refresh.token:super']);
    // 删除学校信息
    Route::post('delete/users','\App\Http\Controllers\wt\AdminController@delete_user')->middleware(['refresh.token:super']);
    //默认查询学校的信息
    Route::get('select/user/school','\App\Http\Controllers\wt\AdminController@select_school')->middleware(['refresh.token:super']);
    //模糊查询
    Route::post('select/like/user/school','\App\Http\Controllers\wt\AdminController@dim_select_school')->middleware(['refresh.token:super']);
    //excel
    Route::post('excel/school','\App\Http\Controllers\wt\ExcelController@export')->middleware(['refresh.token:super']);


    /*
     * 管理员端yyh
     */
    Route::get('xuecha','teacher@xuecha');//返回学校信息
    Route::post('sancguan','teacher@sancguan');//删除学校
    Route::post('piliangshancguan','teacher@piliangshancguan');//批量删除学校
    Route::get('baocha','teacher@baocha');//返回报名信息
    Route::post('sancguanbao','teacher@sancguanbao');//报名信息删除
    Route::post('piliangshancguanbao','piliangshancguanbao');//报名信息批量删除
    Route::get('bisaicha','teacher@bisaicha');//返回全部项目
    Route::post('sancguanbi','teacher@sancguanbi');//比赛删除
    Route::post('piliangshancguannbi','teacher@piliangshancguannbi');//比赛批量删除
});

// 通用
//查询比赛项目
Route::any('type/select2', '\App\Http\Controllers\wt\Competiton_InfController@find2');
Route::post('type/select3', '\App\Http\Controllers\wt\Competiton_InfController@find3');
//管理员登录
Route::post('admin/login', '\App\Http\Controllers\wt\AdminController@login');
//用户登录
Route::post('users/login', '\App\Http\Controllers\wt\UsersController@login');





////测试
//Route::post('delete/users','\App\Http\Controllers\wt\AdminController@delete_user');
//Route::post('delete/array/users','\App\Http\Controllers\wt\AdminController@delete_user_arr');
//Route::post('add/users','\App\Http\Controllers\wt\AdminController@registered');
//Route::get('select/user/school','\App\Http\Controllers\wt\AdminController@select_school');
//Route::post('select/like/user/school','\App\Http\Controllers\wt\AdminController@dim_select_school');
//Route::post('type/select/all', '\App\Http\Controllers\wt\Competiton_InfController@find_all');
//Route::any('excel/school','\App\Http\Controllers\wt\ExcelController@export');
//Route::post('add/information', '\App\Http\Controllers\wt\Competiton_users@inf_add');
//Route::post('type/select/all', '\App\Http\Controllers\wt\Competiton_InfController@find_all_user');
//Route::post('add/array/information', '\App\Http\Controllers\wt\Competiton_users@inf_add_array');
//




