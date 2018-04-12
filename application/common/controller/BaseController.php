<?php
namespace app\common\controller;

use think\Controller;
use think\facade\Env;
use services\admin\Admin as AdminService;

class BaseController extends Controller
{
    // session
    protected $sessionInfo = null;
    
    // request
    protected $request = null;
    
    // 白名单
    private $whileList = [];
    
    public function initialize() 
    {
        $this->whileList = [
            'controller' => [
                'public/Index',
                // 'api/BaseV1.User',
            ],
            
            'action' => [
                // 'api/BaseV1.User/init',
            ],
        ];
        
        $url_controller = request()->module() . '/' . request()->controller();
        $url_action = request()->module() . '/' . request()->controller() . '/' . request()->action();
        
        if (!in_array($url_controller, $this->whileList['controller']) && !in_array($url_action, $this->whileList['action'])) {
            // 相关验证
            // echo '白名单';
        }
		
        // $this->token = '';
        // $this->request = request()->param();
        
		$this->sessionInfo = AdminService::getLoginStatus();
		if (isset($this->sessionInfo)) {
    		$adminId = $this->sessionInfo['ADMIN_ID'];
    		$res = AdminService::getInfoRow(array(['id', '=', $adminId]), ['is_effect', 'is_delete']);
            if ($res->getData('is_effect') == 0 || $res->getData('is_delete') == 1) {
                header("Location:" . 'login');
                exit();
            }
    	} else {
    		if ($this->request->isAjax()) {
    			$this->error("您还没有登录！", 'login');
    		} else {
    			header("Location:" . 'login');
    			exit();
    		}
    	}
		
    }
    
}