<?php
namespace services\user;

use think\Exception;
use think\Db;
use models\manage\User as UserModel;

class User
{
    /**
     * @param array $map, array $field
     * @return mixed
     */
    public static function getInfoRow($map, $field)
    {
        $result = UserModel::getRow($map, $field);
		return $result;
    }
	
    /**
     * @param array $map
     * @return mixed
     */
    public static function getInfoCount($map = '1=1')
    {
        $result = UserModel::getCount($map);
		return $result;
    }
	
}
