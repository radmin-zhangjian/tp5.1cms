<?php
namespace app\main\controller;

use app\common\controller\BaseController;
use think\Request;
use think\Exception;
use services\admin\Admin as AdminService;
use services\menu\Menu as MenuService;
use services\user\User as UserService;

class Index extends BaseController
{
	
    /**
     * 显示首页.
     *
     * @return \think\Response
     */
    public function home()
    {
		$aId = AdminService::getLoginStatus()['ADMIN_ID'];
        $adminInfo = AdminService::getInfoRow(array(['id', '=', $aId]), ['login_time', 'login_ip', 'last_time', 'last_ip']); //登录信息
		
        //用户量
        $userNum  = UserService::getInfoCount();
        //完成订单数
        $orderNUM = 1000;
        //交易成功的交易额
        $tradeTotal = 200000;
        //代理商数
        $agentNum = 200;

        $this->assign("adminInfo", $adminInfo);
        $this->assign("userNum",$userNum);
        $this->assign("orderNum",$orderNUM);
        $this->assign("tradeTotal",$tradeTotal);
        $this->assign("agentNum",$agentNum);
		
        return $this->fetch();
    }
	
	/**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $aAdmin = AdminService::getLoginStatus();
		$this->assign('aAdmin', $aAdmin);
		$this->assign("menuData", MenuService::loadMenu($this->sessionInfo));
		return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
	
}
