<?php
// +----------------------------------------------------------------------
// | dswjcms
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.tifaweb.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
// +----------------------------------------------------------------------
// | Author: 宁波市鄞州区天发网络科技有限公司 <dianshiweijin@126.com>
// +----------------------------------------------------------------------
// | Released under the GNU General Public License
// +----------------------------------------------------------------------
defined('THINK_PATH') or exit();
class AdminCommAction extends CommAction {
	public function _initialize() {
		
	   header("Content-Type:text/html; charset=utf-8");
	   $dirname = F('admdirname')?F('admdirname'):"Default";
		C('DEFAULT_THEME','template/'.$dirname);	//自动切换模板
		C('TMPL_ACTION_ERROR','Index/jump');	//默认错误跳转对应的模板文件
		C('TMPL_ACTION_SUCCESS','Index/jump');	//默认成功跳转对应的模板文件
       //后台自定义地址
		if(strpos(__SELF__,TIFAWEB_DSWJCMS)<1){
			$this->jumps(__ROOT__.'/error.html');
		}
		header("Content-Type:text/html; charset=utf-8");
		$this->adminVerify();
	}
	
	/**
	 * @后台验证
     * @作者		shop猫
	 * @版权		宁波天发网络
	 * @官网		http://www.tifaweb.com http://www.dswjcms.com
	 */
	protected function adminVerify(){
		if(MODULE_NAME=='Logo'){
			return true;
		}
		if(cookie('admin_uid')>0 && !session('admin_uid')){
			$admin=M('admin')->where(array('id'=>cookie('admin_uid')))->find();
			$verify=MD5($admin['username'].DS_ENTERPRISE.$admin['password'].DS_EN_ENTERPRISE);
			
			session('admin_name',$admin['username']);
			session('admin_uid',$admin['id']);
			session('admin_verify',$verify);
			if($admin['portrait']){
				$admin_portraittype=explode("/",$admin['portrait']);
				if($admin_portraittype[0] =='img'){
					session('admin_portraittype',1);
				}
				session('admin_portrait',$admin['portrait']);
			}
			return true;
		}
		import('ORG.Util.Authority');
		$auth=new Authority();
		$uid=$this->_session('admin_uid');
		$user =$this->_session('admin_name');
		if($uid<0 || !$uid){
			$this->jumps(__APP__.'/'.TIFAWEB_DSWJCMS.'/Logo.html');
		}
		if($user !="admin"){
		 if(!$auth->getAuth(GROUP_NAME.'/'.MODULE_NAME.'/'.ACTION_NAME,$uid)){
			$this->adminClearCache();
			$this->error("你没有权限",'__APP__/TIFAWEB_DSWJCMS/Logo.html');
		 }
		}
		
		if($this->_session('admin_uid')){
			$users=M('admin')->field('username,password')->where(array('id'=>$this->_session('admin_uid')))->find();
			if($this->_session('admin_verify') !== MD5($users['username'].DS_ENTERPRISE.$users['password'].DS_EN_ENTERPRISE)){
				$this->adminClearCache();
				$this->jumps(__APP__.'/'.TIFAWEB_DSWJCMS.'/Logo.html');
			}
		}else{
			$this->jumps(__APP__.'/'.TIFAWEB_DSWJCMS.'/Logo.html');
		}
		
	 }
	
	/**
	 *
	 * @后台添加
	 * @作者		shop猫
	 * @版权		宁波天发网络
	 * @官网		http://www.tifaweb.com http://www.dswjcms.com
	 */	
	public function tfAdd(){
		$this->add();
	}
	
	/**
	 *
	 * @后台更新
	 * @作者		shop猫
	 * @版权		宁波天发网络
	 * @官网		http://www.tifaweb.com http://www.dswjcms.com
	 */	
	public function tfUpda(){
		$this->upda();
	}
	
	/**
	 *
	 * @后台删除
	 * @作者		shop猫
	 * @版权		宁波天发网络
	 * @官网		http://www.tifaweb.com http://www.dswjcms.com
	 */	
	public function tfDel(){
		$this->del();
	}
	
	/**
	 *
	 * @后台更新
	 * @作者		shop猫
	 * @版权		宁波天发网络
	 * @官网		http://www.tifaweb.com http://www.dswjcms.com
	 */	
	public function iUpda(){
		$this->integral_upda();
	}
	
	//后台清登录缓存
	public function adminClearCache(){
		session('admin_name',null);
		session('admin_uid',null);
		session('admin_verify',null);
		session('admin_portrait',null);
		session('admin_portraittype',null);
		cookie('admin_uid',null);
	}
}

?>