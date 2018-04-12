<?php
namespace services\admin;

use think\Exception;
use think\Db;
use models\manage\Admin as AdminModel;

class Admin
{
	/**
     * @param object $res
     * @return mixed
     */
    private static function updateAdminData($res)
    {
        // 存session
		$adminInfo['ADMIN_ID'] = $res->id;
		$adminInfo['ADM_NAME'] = $res->adm_name;
		session(md5(config('session_key')), $adminInfo);
		
		// 模型 save 方法
		$res->last_ip     = $res->login_ip;
		$res->login_ip     = request()->ip();
		$res->last_time   = $res->login_time;
		$res->login_time   = time();
		$res->save();
		
		// 模型自定义 update 方法
		// $data['last_ip'] = $res['login_ip'];
		// $data['login_ip'] = request()->ip();
		// $data['last_time'] = $res['login_time'];
		// $data['login_time'] = time();
		// $map = ['id' => $res['id']];
		// AdminModel::setUpdate($data, $map);
    }
	
    /**
     * @param array $request
     * @return mixed
     */
    public static function login($request)
    {
        $result = ret_failure('操作失败');
		
		// $model = Db::name('admin');
		$model = new AdminModel;
        $where['adm_name'] = $request['user_name'];
		
        $res = $model->where($where)->find();
        if (!empty($res) && $res->is_delete == 0) {
            if ($res->adm_password == sp_password(md5($request['user_pass']))) {
                self::updateAdminData($res);
				$result = ret_success();
            } else {
				$result = ret_failure('用户名或密码错误！');
            }
        } else {
			$result = ret_failure('用户不存在！');
        }
		
		return $result;
    }
	
	/**
     * @param null
     * @return mixed
     */
    public static function logout()
    {
        session(md5(config('session_key')), null);
        session(null);
        return true;
    }
	
    /**
     * @param null
     * @return mixed
     */
    public static function getLoginStatus()
    {
        return session(md5(config('session_key')));
    }
	
    /**
     * @param array $request
     * @return mixed
     */
    public static function updatePass($request)
    {
        $result = ret_failure('操作失败');
		
		$model = new AdminModel;
        $where['adm_name'] = self::getLoginStatus()['ADM_NAME'];
		
        $res = $model->where($where)->find();
        if (!empty($res) && $res->is_delete == 0) {
            if ($res->adm_password == sp_password(md5($request['user_pass']))) {
                $res->adm_password = sp_password(md5($request['c_mew_pas']));
				if ($res->save()) {
					$result = ret_success();
				} else {
					$result = ret_failure('更新失败！');
				}
            } else {
				$result = ret_failure('旧密码验证失败！');
            }
        } else {
			$result = ret_failure('用户不存在！');
        }
		
		return $result;
    }
	
	/**
     * @param array $data
     * @return mixed
     */
    public static function setAddAdmin($data)
    {
		$info = ['code' => 0, 'message' => '操作失败'];
		// 检查用户名是否存在
		$map = self::maps(['adm_name' => $data['adm_name']]);
		$result = self::getInfoRow($map, $field = ['id', 'adm_name']);
		if ($result && !empty($result) && $result!=null) {
			return $info = ['code' => 0, 'message' => '管理员已存在'];
		}
		// 增加管理员
		$data['adm_password'] = sp_password(md5($data['adm_password']));
        $res = AdminModel::setCreate($data);
		if ($res) {
			$info = ['code' => 1, 'message' => '操作成功'];
		}
		return $info;
    }
	
	/**
     * @param array $data, array $map
     * @return mixed
     */
    public static function setUpdateAdmin($data, $map)
    {
		$info = ['code' => 0, 'message' => '重置失败'];
		$data['adm_password'] = sp_password(md5(config('admin_default_pwd')));
        $res = AdminModel::setUpdate($data, $map);
		if ($res) {
			$info = ['code' => 1, 'message' => '操作成功'];
		}
		return $info;
    }
	
	/**
     * @param array $map
     * @return mixed
     */
    public static function setDelete($map)
    {
        $result = AdminModel::setDelete($map);
		return $result;
    }
	
	/**
     * @param array $map, array $field, string $limit, string $order
     * @return mixed
     */
    public static function getInfoList($map = [], $field = '*', $limit = '', $order = '')
    {
        $result = AdminModel::getAll($map, $field, $limit, $order);
		return $result;
    }
	
	/**
     * @param array $map, array $field
     * @return mixed
     */
    public static function getInfoRow($map = [], $field = '*')
    {
        $result = AdminModel::getRow($map, $field);
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
        if (isset($args['id'])) {
			$map[] = ['id', '=', intval($args['id'])];
		}
        if (isset($args['adm_name'])) {
			$map[] = ['adm_name', '=', strim($args['adm_name'])];
		}
		return $map;
    }
	
}
