<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;

// 定义根目录
// define('SYSTEM_PATH', __DIR__ . '/../');

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

// 定义命名空间
define('APP_NAMESPACE', 'app');

// 加载基础文件
require __DIR__ . '/../thinkphp/base.php';

// 支持事先使用静态方法设置Request对象和Config对象

// 执行应用并响应
Container::get('app')->run()->send();


// 或则已 start.php 方式引入入口文件

// 定义应用目录
// define('APP_PATH', __DIR__ . '/../application/');
// 加载框架引导文件
// require __DIR__ . '/../thinkphp/start.php';
