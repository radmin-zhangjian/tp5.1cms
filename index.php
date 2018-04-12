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

namespace think;

// 定义根目录
define('SYSTEM_PATH', __DIR__ . '/../');
// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');
// 加载框架基础引导文件
require __DIR__ . '/thinkphp/base.php';
// 添加额外的代码
// ...

// 执行应用并响应
Container::get('app', [APP_PATH])->run()->send();
// Container::get('app')->path(APP_PATH)->run()->send();    // 5.1.2+