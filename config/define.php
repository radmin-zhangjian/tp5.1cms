<?php
if(!defined('ROOT_AES_KEY'))
	define('ROOT_AES_KEY', substr(strtoupper(md5("a53dd09374f9a2a61ba3da6524b639ed")),8,16));

define('RDSDEFAULT', 0); // 库0 
define('USERINFO', 1); // 库1 哈希
define('USERLIST', 2); // 库2 列表
define('USERSET', 3); // 库3 集合
define('ORDER', 4); // 4 订单
define('LOGINSPLIT', '@~');
define('HASHKEYLEN', 10);
define('EXPIRETIME', 86400*7);

define('CERTIFICATE_MAX_SIZE', 10240);
define('APP_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');//网站根目录
define('PRIVATE_KEY', APP_ROOT_PATH."system/pem/rsa_private_key_2048.pem");
define('PUBLIC_KEY', APP_ROOT_PATH."system/pem/rsa_public_key_2048.pem");

define('OSS_DOMAIN', "http://img.hezongli.com");//图片服务器域名
define('DB_PREFIX', config('DB_PREFIX'));
define('PAGE_SIZE', 5);
define('ROOT', 'http://'.$_SERVER['SERVER_NAME']);//当前域名

define('ADM_NAME', 'ADM_NAME');
