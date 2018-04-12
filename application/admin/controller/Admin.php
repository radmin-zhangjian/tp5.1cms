<?php
namespace app\admin\controller;

use app\common\controller\BaseController;
use think\Request;
use think\Exception;
use think\facade\Validate;
use app\common\validate\Admin as AdminValidate;
use services\admin\Admin as AdminService;

class Admin extends BaseController
{
	/**
     * @var 验证
     */
	protected $validate = null;
	
	/**
     * 构造方法
     * @param Request $request Request对象
     * @access public
     */
	public function initialize()
	{
		parent::initialize();
		$this->validate = new AdminValidate();
	}
	
	/**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $showList = AdminService::getInfoList('', '', '', 'id asc');
		$this->assign("showList", $showList);
		$this->assign("defaultAdmin", config('default_admin')); // 默认管理员
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
        $data = $request->post();
		
		// 验证信息
		if (true !== $this->validate->check($data)) {
			return json(ret_failure($this->validate->getError()));
		}
		
		$res = AdminService::setAddAdmin($data);
		if ($res['code'] == 1) {
			return json(ret_success());
		} else {
			return json(ret_failure($res['message']));
		}
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
		$map = AdminService::maps(['id' => $id]);
		$res = AdminService::setUpdateAdmin($data=[], $map);
		if ($res['code'] == 1) {
			$info = ret_success();
		} else {
			$info = ret_failure($res['message']);
		}
        return json($info);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
		$map = AdminService::maps(['id' => $id]);
		$res = AdminService::setDelete($map);
		if ($res) {
			$info = ret_success();
		} else {
			$info = ret_failure('删除失败');
		}
        return json($info);
    }
	
}
