<?php
namespace app\common\validate;

use think\Validate;

class Menu extends Validate
{
    protected $rule = [
        'parent_id'      => 'require|number',
        'name'      	 => 'require|min:2|max:10',
        'module'      	 => 'alpha',
        'controller'     => 'alpha',
        'action'    	 => 'require|alpha',
    ];
    
    protected $message = [
        'parent_id.require' => '上级必须填写',
        'parent_id.number' => '上级菜单为数字',
        'name.require' => '名称必须填写',
        'name.min' => '名称不小于2个字符',
        'name.max' => '名称不大于10个字符',
        'module.alpha'     => '应用需为字母',
        'controller.alpha'   => '模块需为字母',
        'action.require'  => '方法必须填写', 
        'action.alpha'  => '方法需为字母', 
    ];
    
    protected $scene = [
        'edit'  =>  ['name', 'module', 'controller', 'action'],
    ];
}