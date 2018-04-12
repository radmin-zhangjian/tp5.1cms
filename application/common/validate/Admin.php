<?php
namespace app\common\validate;

use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'adm_name'      	 => 'require|min:3|max:16',
        'adm_password'    	 => 'require',
    ];
    
    protected $message = [
        'adm_name.require' 		=> '用户名必须填写',
        'adm_name.min' 			=> '用户名不小于3个字符',
        'adm_name.max' 			=> '用户名不大于16个字符',
        'adm_password.require'  => '密码必须填写', 
    ];
    
    protected $scene = [
        'edit'  =>  ['adm_password'],
    ];
}