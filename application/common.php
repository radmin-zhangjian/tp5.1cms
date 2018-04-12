<?php

/**
 * @desc 密码加密
 * @param $pw 需要加密的字符
 * @return string 加密后字符
 */
function sp_password($pw)
{
	$decor = md5(config('admin_key'));
	$mi = md5($pw);
	return substr($decor, 0, 12) . $mi . substr($decor, -4, 4);
}

/**
 * @desc 生成唯一编号(最少18位)
 * @param string $prefix 编号前缀,建议使用两个大写字母区分不同业务
 * @return string 唯一编号
 */
function create_unique_id($prefix='')
{
	return $prefix.time().(substr(microtime(),2,5)).rand(100,999);
}

/**
 * @desc 返回成功
 * @param string $message 提示信息
 * @param array $data 数据集合
 * @return array 正确结果集合
 */
function ret_success($data=array(), $message='操作成功')
{
	return array('code' => true, 'message' => $message, 'data' => $data);
}

/**
 * @desc 返回失败
 * @param string $message 提示信息
 * @return array 正确结果集合
 */
function ret_failure($message='操作失败')
{
	return array('code' => false, 'message' => $message);
}

/**
 * @desc curl post请求
 * @param $url
 * @param $post
 * @return mixed
 */
function curl_post($url, $post)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$data = curl_exec($ch);
	curl_close($ch);

	return $data;
}

/**
 * @desc 转义特殊字符
 * @param string $content 
 * @return string 
 */
function quotes($content)
{
	//if $content is an array
	if (is_array($content))	{
		foreach ($content as $key=>$value) {
			//$content[$key] = mysql_real_escape_string($value);
			if (get_magic_quotes_gpc()) {
				$content[$key] = stripslashes($value);
			}
			$content[$key] = addslashes($value);
		}
	} else {
		if (get_magic_quotes_gpc()) {
			$content = stripslashes($content);
		}
		$content = addslashes($content);
		//if $content is not an array
		//mysql_real_escape_string($content);
	}
	return $content;
}

/**
 * @desc 参数过滤
 * @param string $str 
 * @return string 
 */
function strim($str, $type = 'post')
{
	$postfilter="/^\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)$/i";
	$getfilter="/^'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)$/i";
	$cookiefilter="/^\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)$/i";
	switch (strtolower($type)) {
		case 'post':
			if (preg_match($postfilter, $str)) {
				DialogHelper::popup('提示信息', 'Post非法注入！', '/Index/Index/main');
				exit;
			}
			break;
		case 'get':
			if (preg_match($getfilter, $str)) {
				DialogHelper::popup('提示信息', 'Get非法注入！', '/Index/Index/main');
				exit;
			}
			break;
		case 'cookie':
			if (preg_match($cookiefilter, $str)) {
				DialogHelper::popup('提示信息', 'Cookie非法注入！', '/Index/Index/main');
				exit;
			}
			break;
	}
	return quotes(htmlspecialchars(trim($str)));
}
function btrim($str)
{
	return quotes(trim($str));
}
