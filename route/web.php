<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::rule('static', response()->code(404));

// 登录
Route::rest([
    'index'   => ['GET', '', 'login'],
    'create'  => ['GET', '/logout', 'logout'],
    'save'    => ['POST', '', 'doLogin'],
    'update'  => ['POST', '/pass', 'updatePass'],
]);
Route::resource('login', 'manager/index');

// 首页
Route::rest([
    'index'   => ['GET', '', 'index'],
    'create'  => ['GET', '/home', 'home'],
    'save'    => ['POST', '', 'save'],
]);
Route::resource('home', 'main/index');

// 菜单
Route::rest([
    'index'   => ['GET', '', 'index'],
    'create'  => ['GET', '/create', 'create'],
    'save'    => ['POST', '', 'save'],
	'read'    => ['GET', '/:id', 'read'],
    'edit'    => ['GET', '/:id/editMenu', 'edit'],
    'put'     => ['PUT', '/:id', 'update'],
    'delete'  => ['DELETE', '', 'delete'],
]);
Route::resource('menu', 'menu/menu');
Route::rest(['index'   => ['GET', '/:id', 'children']]); // 子菜单
Route::resource('menu/mChildren', 'menu/menu');

// 管理员
Route::rest([
    'index'   => ['GET', '', 'index'],
    'create'  => ['GET', '/create', 'create'],
    'save'    => ['POST', '', 'save'],
	'read'    => ['GET', '/:id', 'read'],
    'edit'    => ['GET', '/:id/edit', 'edit'],
    'put'     => ['PUT', '/:id', 'update'],
    'delete'  => ['DELETE', '', 'delete'],
]);
Route::resource('admin', 'admin/admin');
Route::resource('roles', 'admin/roles');

// Route::rule('login', 'manager/index/login')->method('get');
// Route::get('logout', 'manager/index/logout')->method('get');

return [

];
