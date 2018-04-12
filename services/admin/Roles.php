<?php
namespace services\admin;

use think\Exception;
use think\Db;
use models\manage\Admin as AdminModel;
use models\manage\Menu as MenuModel;

class Roles
{
	/**
     * @param array $aMenu, array $sGiven
     * @return mixed
     */
    public static function getRoles($aMenu, $sGiven)
    {
		$aTree = [];
		foreach ($aMenu as $m) {
			if ($m['parent_id'] == 0) {
				$pNode = [
					'id' => $m['id'],
					'pId' => 0,
					'name' => $m['name'],
				];
				if (in_array($m['id'], $sGiven)) {
					$pNode['checked'] = true;
				}
				$aTree[] = $pNode;
				foreach ($aMenu as $n) {
					if ($m['id'] == $n['parent_id']) {
						$nNode = [
							'id' => $n['id'],
							'pId' => $n['parent_id'],
							'name' => $n['name'],
						];
						if (in_array($n['id'], $sGiven)) {
							$nNode['checked'] = true;
						}
						$aTree[] = $nNode;
					}
				}
			}
		}
		return $aTree;
    }
	
	/**
     * @param array $data, array $map
     * @return mixed
     */
    public static function setUpdateRoles($data, $map)
    {
		$info = ['code' => 0, 'message' => '操作失败'];
		// 增加权限
        $res = AdminModel::setUpdate($data, $map);
		if ($res) {
			$info = ['code' => 1, 'message' => '操作成功'];
		}
		return $info;
    }
	
	/**
     * @param array $map, array $field, string $limit, string $order
     * @return mixed
     */
    public static function getInfoList($map = [], $field = '*', $limit = '', $order = '')
    {
        $result = MenuModel::getAll($map, $field, $limit, $order);
		return $result;
    }
	
	/**
     * @param array $map, array $field
     * @return mixed
     */
    public static function getInfoField($map = [], $field = 'id')
    {
        $res = AdminModel::getRow($map, $field);
		return $res[$field];
    }
    
	/**
     * maps
     * @param array $args
     * @return mixed
     */
    public static function maps($args = [])
    {
		$map = [];
        if (isset($args['id'])) {
			$map[] = ['id', '=', intval($args['id'])];
		}
		return $map;
    }
	
}
