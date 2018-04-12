<?php
namespace app\admin\controller;

use app\common\controller\BaseController;
use think\Request;
use think\Exception;
use think\facade\Validate;
use services\admin\Roles as RolesService;

class Roles extends BaseController
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
	}
	
	/**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
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
		$map = RolesService::maps(['id' => $id]);
        $sGiven = RolesService::getInfoField($map, 'given');
		$sGiven = explode(',', $sGiven);
        $aMenu = RolesService::getInfoList('', '', '', 'id asc');
		
		// 创建节点
		$aTree = RolesService::getRoles($aMenu, $sGiven);
		return json(ret_success($aTree));
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
		$data = $request->post();
		unset($data['_method']);
		
		// 验证信息
		$rule = [
            'given'  => 'require',
            'id'  	 => 'require|number',
        ];
        $msg = [
            'given.require' => '请勾选对应的菜单！',
            'id.require'     => '数据传输错误，请稍后重试！',
            'id.number'   => '数据传输错误，请稍后重试。',
        ];
        $validate = Validate::make($rule, $msg);
        $result = $validate->check($data);
        if(!$result) {
			return json(ret_failure($validate->getError()));
        }
		
		if ($data) {
			$map = RolesService::maps(['id' => $id]);
			$res = RolesService::setUpdateRoles($data, $map);
			if ($res['code'] == 1) {
				return json(ret_success());
			} else {
				return json(ret_failure($res['message']));
			}
		}
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
