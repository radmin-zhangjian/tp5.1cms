<?php
namespace services\menu;

use think\Exception;
use think\Db;
use services\admin\Admin as AdminService;
use models\manage\Menu as MenuModel;

class Menu
{
    /**
     * 拼接链接
     * @param array $info
     * @return mixed
     */
    private static function urlSplitJoint($info)
	{
		$url = '';
		if ($info['module']) {
			$url .= $info['module'] . "/";
		}
		if ($info['controller']) {
			$url .= $info['controller'] . "/";
		}
		if ($info['action']) {
			$url .= $info['action'];
		}
		return $url;
	}
	
    /**
     * 加载菜单
     * @param array $admin
     * @return mixed
     */
    public static function loadMenu($admin)
	{
        // 超级管理员有所有权限
        if ($admin['ADM_NAME'] !== config('default_admin')) {
            $map[] = ['id', '>', 0];
        } else {
			// 获取管理权限
			$info = AdminService::getInfoRow(array(['id', '=', $admin['ADMIN_ID']]), ['given']);
			$map[] = ['id', 'in', $info['given']];
        }
		$field = ['id', 'parent_id', 'name', 'module', 'controller', 'action', 'icon'];

        // 获取对应的菜单
        $aMenu = self::getInfoList($map, $field);
        $menuData = array();
        foreach ($aMenu as $m1) {
            if ($m1['parent_id'] == 0) {
				$url = self::urlSplitJoint(['module' => $m1['module'], 'controller' => $m1['controller'], 'action' => $m1['action']]);
                $givenData = array(
                    "id"   => $m1['id'],
                    "name" => $m1['name'],
                    "url"  => $url,
                    "icon" => $m1['icon']
                );
                $item = array();
                foreach ($aMenu as $m2) {
                    if ($m2['parent_id'] == $m1['id']) {
						$url = self::urlSplitJoint(['module' => $m2['module'], 'controller' => $m2['controller'], 'action' => $m2['action']]);
                        $tmpData = array(
                            "id"   => $m2['id'],
                            "name" => $m2['name'],
                            "url"  => $url,
                            "icon" => $m2['icon']
                        );
                        $item[] = $tmpData;
                    }
                }
                $givenData['item'] = $item;
                $menuData[] = $givenData;
            }
        }
		
        return $menuData;
    }
	
    /**
     * 菜单列表
     * @param array $map, array $field, string $limit, string $order
     * @return mixed
     */
    public static function getInfoList($map = [], $field = '*', $limit = '', $order = '')
	{
        $result = MenuModel::getAll($map, $field, $limit, $order);
        return $result;
    }
	
    /**
     * 新增菜单
     * @param array $data
     * @return mixed
     */
    public static function setAddMenu($data)
	{
        $res = MenuModel::setCreate($data);
        return $res;
    }
	
    /**
     * 修改菜单
     * @param array $data
     * @return mixed
     */
    public static function setUpdateMenu($data, $map = [])
	{
        $res = MenuModel::setUpdate($data, $map);
        return $res;
    }
	
    /**
     * 删除菜单
     * @param int $id
     * @return mixed
     */
    public static function setDelete($map)
    {
        $result = MenuModel::setDelete($map);
		return $result;
    }
	
	/**
     * 获取单条数据
     * @param array $map, array $field
     * @return mixed
     */
    public static function getInfoRow($map = [], $field = '*')
    {
        $result = MenuModel::getRow($map, $field);
		return $result;
    }
	
	/**
     * maps
     * @param array $args
     * @return mixed
     */
    public static function maps($args = [])
    {
		$map = [];
		if (isset($args['parent_id'])) {
			$map[] = ['parent_id', '=', intval($args['parent_id'])];
		}
        if (isset($args['id'])) {
			$map[] = ['id', '=', intval($args['id'])];
		}
        if (isset($args['id_parent_id'])) {
			$map[] = ['id', '=', intval($args['id_parent_id'])];
		}
		return $map;
    }
	
}
