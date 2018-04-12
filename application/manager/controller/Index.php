<?php
namespace app\manager\controller;

use think\Controller;
// use think\facade\Env;
// use think\Db;
// use think\Exception;
// use think\Request;
// use think\facade\Cache;
// use think\facade\Session;
// use think\facade\Cookie;
// use think\facade\Validate;
use services\admin\Admin as AdminService;

class Index extends Controller
{
	/**
     * 检测是否登录并跳转
     */
    public function login() 
	{
        if (!empty(AdminService::getLoginStatus()) && AdminService::getLoginStatus() != null) {
            $this->success('登录成功，正在跳转', '/home');
        } else {
			$this->assign('s_year', date('Y', time()));
			return $this->fetch();
        }
    }

    /**
     * 退出登录
     */
    public function logout()
	{
		AdminService::logout();
        $this->redirect("/login");
    }
	
	/**
     * 管理员登录
     */
    public function doLogin()
	{
        $request['user_name'] = $this->request->post('user_login');
        $request['user_pass'] = $this->request->post('user_pwd');
		
        if (empty($request['user_name'])) {
			return json(ret_failure('用户名不能为空'));
        }
        if (empty($request['user_pass'])) {
			return json(ret_failure('密码不能为空'));
        }
		
		$result = AdminService::login($request);
		
		return json($result);
		
    }
	
	/**
     * 修改管理员密码
     */
    public function updatePass()
	{
        $request['user_pass'] = $this->request->post('pwd');
        $request['c_mew_pas'] = $this->request->post('c_mew_pas');
        $request['nes_pas'] = $this->request->post('nes_pas');
		
        if (empty($request['user_pass'])) {
			return json(ret_failure('旧密码不能为空'));
        }
        if (empty($request['c_mew_pas'])) {
			return json(ret_failure('新密码不能为空'));
        }
        if ($request['c_mew_pas'] != $request['nes_pas']) {
			return json(ret_failure('新密码与确认密码不匹配'));
        }
		
		$result = AdminService::updatePass($request);
		
		// var_dump($result);die;
		return json($result);
		
    }
	
}
