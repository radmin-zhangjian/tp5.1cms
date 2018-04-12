<?php
namespace app\menu\controller;

use app\common\controller\BaseController;
use think\Request;
use think\Exception;
use think\facade\Validate;
use app\common\validate\Menu as MenuValidate;
use services\menu\Menu as MenuService;

class Menu extends BaseController
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
		$this->validate = new MenuValidate();
	}
	
	/**
     * 显示子资源列表
     *
     * @return \think\Response
     */
    public function children($id)
    {
		$map = MenuService::maps(['parent_id' => $id]);
		$this->assign("aMenu", MenuService::getInfoList($map));
		return $this->fetch();
    }

	/**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
		$map = MenuService::maps(['parent_id' => 0]);
		$aMenu = MenuService::getInfoList($map);
		$this->assign("aMenu", $aMenu);
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
        if(true !== $this->validate->check($data)){
            return json(ret_failure($this->validate->getError()));
        }
		
		$res = MenuService::setAddMenu($data);
		if ($res) {
			return json(ret_success());
		} else {
			return json(ret_failure('添加菜单失败'));
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
		// 修改信息
		$map = MenuService::maps(['id' => $id]);
		$eMenu = MenuService::getInfoRow($map, $field = ['parent_id', 'name', 'module', 'controller', 'action']);
		$this->assign("eMenu", $eMenu);
		
		// 上级菜单名称
		if ($eMenu['parent_id'] == 0) {
			$sMenu['id'] = 0;
			$sMenu['name'] = '顶级菜单';
		} else {
			$map = MenuService::maps(['id' => $eMenu['parent_id']]);
			$sMenu = MenuService::getInfoRow($map, $field = ['id', 'name']);
		}
		$this->assign('sMenu', $sMenu);
		
		return $this->fetch();
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
        if(true !== $this->validate->scene('edit')->check($data)){
            return json(ret_failure($this->validate->getError()));
        }
		
		$map = MenuService::maps(['id' => $id]);
		$res = MenuService::setUpdateMenu($data, $map);
		if ($res) {
			return json(ret_success());
		} else {
			return json(ret_failure('修改菜单失败'));
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
		// 获取菜单
		$map = MenuService::maps(['parent_id' => $id]);
		$aMenu = MenuService::getInfoRow($map);
		
		if (empty($aMenu)) {
			$map = MenuService::maps(['id' => $id]);
			$res = MenuService::setDelete($map);
			if ($res) {
				$info = ret_success();
			} else {
				$info = ret_failure('删除失败');
			}
		} else {
			$info = ret_failure('请先删除该菜单下的子菜单');
		}
		
        return json($info);
    }
	
}
