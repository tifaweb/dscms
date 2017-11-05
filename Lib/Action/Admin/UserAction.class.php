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
class UserAction extends AdminCommAction {
	//显示所有用户
	public function index($q=0){
		if($this->_get('title')){
			$where="`username`='".$this->_get('title')."' or `id`='".$this->_get('title')."'";
		}
		
	    import('ORG.Util.Page');// 导入分页类
        $count      = D("User")->where($where)->count();// 查询满足要求的总记录数
        $Page       = new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = D("User")->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id')->select();
	    $this->assign('list',$list);
        $this->assign('page',$show);
		 $endjs='
function edits(id){
	var loading=\'<div class="invest_loading"><div><img src="__PUBLIC__/bootstrap/img/ajax-loaders/ajax-loader-1.gif"/></div><div>加载中...</div> </div>\';
	$(".integral_subject").html(loading);
		$("#editss").load("__APP__/TIFAWEB_DSWJCMS/User/passajax", {id:id});
}
		';
		$this->assign('endjs',$endjs);
        $this->display();
	}
	
	
	//用户修改密码AJAX
    public function passajax(){
		$id=$this->_post("id");
		$mod = D("User");
		$borrow=$mod->where('id='.$id)->find();
		echo '
			<table class="table">
        <tbody>
          <tr>
            <td>用户名：</td>
            <td>'.$borrow['username'].'</td>
          </tr>
          <tr>
            <td>密码：</td>
            <td><input name="password" type="password" class="span2"></td>
          </tr>
		  <input name="sid" type="hidden" value="'.$id.'" />
        </tbody>      
    </table>
		';
    }
	
	//删除用户
   public function exituse(){
	   $mod =  D("User");
		if($this->_get('id')){
			 $result = $mod->where("id=".$this->_get('id'))->delete();
			 if($result){
				 $this->Record('删除用户成功');//后台操作
				$this->success('删除成功');
			}else{
				$this->Record('删除用户失败');//后台操作
				$this->error("删除失败");
			}		
		}  
   }
	
	//显示用户组
	public function userGroups(){
		$mod = D("Auth_group");
		$list = $mod->select();
		$this->assign('list',$list);
		
        $this->display();
	
	}
	
	//查看用户组下所有用户
	public function viewUser($id=0){
		if($id){
			$where= "group_id =".$id;
		}else{
			$this->error("请选择用户组");
		}
		$mod = D("Auth_group_access");
		$list = $mod->where($where)->relation("admin")->select();
		$this->assign('list',$list);
		$this->assign('id',$id);
        $this->display();
	}
	
	//获取未分配的管理员
	public function viewUserAjax(){
		$admin=M('admin')->field('username,id')->select();
		
		$auth_group_access=M('auth_group_access')->select();
		
		if($auth_group_access){
			foreach($auth_group_access as $a=>$access){
				$arr[$access['uid']]=$access['uid'];
			}
		}
		
		foreach($admin as $id=>$a){
			
			if(!array_key_exists($a['id'],$arr)){
				$adminarr[$a['id']]=$a['username'];
			}
		}
		$this->ajaxReturn(1,$adminarr,1);
	}
	
	//管理员
	public function manage(){
		$mod = D("Admin");
		$list = $mod->select();
		$this->assign('list',$list);
		$endjs='
//编辑
function edit(id){
	var loading=\'<div class="invest_loading"><div><img src="__PUBLIC__/bootstrap/img/ajax-loaders/ajax-loader-1.gif"/></div><div>加载中...</div> </div>\';
	$(".integral_subject").html(loading);
		$("#edits").load("__APP__/TIFAWEB_DSWJCMS/User/adminajax", {id:id});
}
		';
		$this->assign('endjs',$endjs);
        $this->display();
	}	
	
	//管理员修改AJAX
    public function adminajax(){
		$id=$this->_post("id");
		$mod = D("Admin");
		$borrow=$mod->where('id='.$id)->find();
		echo '
			<table class="table">
        <tbody>
          <tr>
            <td>用户名：</td>
            <td>'.$borrow['username'].'</td>
          </tr>
          <tr>
            <td>密码：</td>
            <td><input name="password" type="password" class="span2"></td>
          </tr>
		  <tr>
            <td>邮箱：</td>
            <td><input name="email" type="text" class="span2" value="'.$borrow['email'].'"></td>
          </tr>
		  <input name="sid" type="hidden" value="'.$id.'" />
        </tbody>      
    </table>
		';
    }
	
	
	//删除管理员
   public function exitman(){
	   $mod =D("Admin");
		if($this->_get('id')){
			 $result = $mod->where("id=".$this->_get('id'))->delete();
			 if($result){
				 $this->Record('删除管理员成功');//后台操作
				$this->success('删除成功');
			}else{
				$this->Record('删除管理员失败');//后台操作
				$this->error("删除失败");
			}		
		}  
   }
	
	//添加用户组
    public function addGroup(){
		
		$mod = D("Auth_group");	
		 if($mod->create()){
		 	$result = $mod->add();
			if($result){
				$this->Record('添加用户组成功');//后台操作
				$this->success("添加用户组成功");
			}else{
				$this->Record('添加用户组失败');//后台操作
				$this->error("添加用户组失败");
			}
		 }else{
		 	$this->error($mod->getError());
		 }
	}	
	
	//为分组添加成员 
	public function saveUser(){
		$data = array();
		foreach($_POST['guser'] as $k=>$v ){
			$data[$k]['group_id']=intval($_POST['group_id']);
			$data[$k]['uid']=intval($v);
		}
		$mod = D("auth_group_access");
		$ret = $mod->addAll($data);
		if($ret){
			 $this->Record('添加分组成员成功');//后台操作
			 $this->success("添加分组成员成功");
		}else{
			 $this->Record('添加分组成员失败');//后台操作
			 $this->error("添加分组成员失败");
		}		
	}
	
	//分组添加用户
	public function addGroupUser(){
		$data = array();
		foreach($_POST['params'] as $k=>$v ){
			$data[$k]['group_id']=intval($_POST['group_id']);
			$data[$k]['uid']=intval($v);
		}
		$mod = D("Auth_group_access");
		$ret = $mod->add($data);
		if($ret){
			
		}else{
			
		}
	}
	
	//为小组分配权限
	public function editUserGroups($id){
		if(!$id){ 
		   $this->error("请选择分组");
		}
		$group = D("Auth_group")->where("id=".$id)->find();
		$rule =  D("Auth_rule")->field('id,name')->order('fid  ASC ,id ASC')->select();
		$inarr = explode(",",$group['rules']);
		foreach($rule as $k=>$v){
			if(in_array($v['id'],$inarr)){
				$rule[$k]['cla']="y";
			}else{
				$rule[$k]['cla']="n";
			}
		}
		
		$this->assign('group',$group);
		$this->assign('rule',$rule);
		$this->display();		
	}

   //权限规则管理
   public function competence(){
	  $mod = D("Auth_rule");
	  $list = $mod->order('id DESC')->select();
	  $this->assign('list',$list);
	  $unite=M('unite');
	  $unt=$unite->where('`state`=0 and `pid`=1')->order('`order` asc,`id` asc')->select();
	  foreach($unt as $id=>$u){
	  	$unts[$u['value']]=$u['name'];
	  }
	  $this->assign('unts',$unts);
	  $this->assign('unt',$unt);
	  $endjs='
//编辑
function edit(id){
	var loading=\'<div class="invest_loading"><div><img src="__PUBLIC__/bootstrap/img/ajax-loaders/ajax-loader-1.gif"/></div><div>加载中...</div> </div>\';
	$(".integral_subject").html(loading);
		$("#edits").load("__APP__/TIFAWEB_DSWJCMS/User/editajax", {id:id});
}
		';
		$this->assign('endjs',$endjs);
	  $this->display();	
   }
   
   //权限编辑显示AJAX
    public function editajax(){
		$unite=D('Auth_rule');
		$id=$this->_post("id");
		$list=$unite->where('`id`='.$id)->find();
		$unite=M('unite');
		$unt=$unite->where('`state`=0 and `pid`=1')->order('`order` asc,`id` asc')->select();
		echo '
			<table class="table">
        <tbody>
          <tr>
            <td>授权名称：</td>
            <td><input name="name" type="text" class="span6" placeholder="请输入权限名称..." value="'.$list['name'].'"></td>
          </tr>
		  <tr>
			<td>
				   分组：
			</td>
			<td>
				<select name="fid">';
			foreach($unt as $lt){
				if($list['fid']==$lt['value']){
					echo '<option value="'.$lt['value'].'" selected>'.$lt['name'].'</option>';
				}else{
					echo '<option value="'.$lt['value'].'">'.$lt['name'].'</option>';
				}
			}
		echo '
				</select>
			</td>
		  </tr>
          <tr>
            <td>控制器：</td>
            <td><input name="condition" type="text" class="span6" placeholder="Group-Controller-action" value="'.$list['condition'].'"></td>
          </tr>
		  <input name="sid" type="hidden" value="'.$id.'" />
        </tbody>      
    </table>
		';
    }
   
   //删除权限
   public function exitcom(){
	   $mod =  D("Auth_rule");
		if($this->_get('id')){
			 $result = $mod->where("id=".$this->_get('id'))->delete();
			 if($result){
				 $this->Record('删除权限成功');//后台操作
				$this->success('删除成功');
					
			}else{
				$this->Record('删除权限失败');//后台操作
				$this->error("删除失败");
			}		
		}  
   }
   
   //删除用户下的某个用户
   public function delGroupUser($uid=0){
	   if(!$uid){
		   $this->error("选择删除用户");
	   }
	   $uid = intval($_REQUEST['uid']);
	   $mod =  D("Auth_group_access");
	   $result = $mod->where("uid=".$uid)->delete();
		if($result){
			$this->Record('删除某个用户成功');//后台操作
			$this->success('删除成功');
				
		}else{
			$this->Record('删除某个用户失败');//后台操作
			$this->error("删除失败");
		}		   
   }

}
?>