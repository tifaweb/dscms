<?php
defined('THINK_PATH') or exit();
class LogoAction extends AdminCommAction {
     public function index(){
		
        if(isset($_POST['name'])){
           if($this->_session('verify') != md5($this->_post('proving'))) {
			   
				$this->assign('msgerror','验证码错误');
            }else{
				$User = D("Admin"); // 实例化User对象
				$condition['name'] = $this->_post('name');
				$condition['password'] = $User->adminMd5($this->_post('passw'));
				$list = $User->where($condition)->find();
			   if($list){
				   
					session('admin_name',$list['username']);  //设置session
					session('admin_uid',$list['id']);
					session('admin_verify',MD5($list['username'].DS_ENTERPRISE.$list['password'].DS_EN_ENTERPRISE));
					if($list['portrait']){
						$portrait=explode("/",$list['portrait']);
						if($portrait[0] =='img'){
							session('admin_portraittype',1);
						}
						session('admin_portrait',$list['portrait']);
					}
					
					if($this->_post('remember')=='on'){
						cookie('admin_uid',session('admin_uid'),2592000);
					}
					session('verify',null); //删除验证码
					$this->Record('管理员登陆成功');//后台操作
					$this->jumps(__APP__.'/'.TIFAWEB_DSWJCMS);
				}else{
					$this->assign('msgerror','用户名密码错误');
				}
			}
			
        }
		 $this->display();
        
    }
	
	public 	function loginout(){
		if(isset($_SESSION['admin_uid'])) {
			$this->Record('管理员登出成功');//后台操作
			$this->adminClearCache();
            $this->jumps(__APP__.'/'.TIFAWEB_DSWJCMS.'/Logo.html');
        }else {
            $this->error('已经成功！');
        }
	}
	
	//踢下线显示页面
	public function lockscreen(){
		if(session('admin_uid')>0){
			session('lockscreen_uid',session('admin_uid'));
			session('lockscreen_portrait',session('admin_portrait'));
			session('lockscreen_portraittype',session('admin_portraittype'));
			session('lockscreen_goto',$_SERVER['HTTP_REFERER']);
			$this->adminClearCache();
		}
		if($this->_post('sub')==1){
			$list=D("Admin")->where(array('id'=>session('lockscreen_uid'),'password'=>D("Admin")->adminMd5($this->_post('password'))))->find();
			if($list){
				session('admin_name',$list['username']);
				session('admin_uid',$list['id']);
				session('admin_verify',MD5($list['username'].DS_ENTERPRISE.$list['password'].DS_EN_ENTERPRISE));
				if($list['portrait']){
					$portrait=explode("/",$list['portrait']);
					if($portrait[0] =='img'){
						session('admin_portraittype',1);
					}
					session('admin_portrait',$list['portrait']);
				}
				
				if($this->_post('remember')=='on'){
					cookie('admin_uid',session('admin_uid'),2592000);
				}
				session('lockscreen_uid',null);
				session('lockscreen_portrait',null);
				session('lockscreen_portraittype',null);
				$this->Record('管理员登陆成功');//后台操作
				$this->jumps(session('lockscreen_goto'));
			}else{
				$this->assign('msgerror','用户名密码错误');
			}
		}
		$this->display();
	}
	
	 
}