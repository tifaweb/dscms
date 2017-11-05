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
class BasisAction extends AdminCommAction {
//--------数据库备份-----------
	public function backup(){
		import('ORG.Custom.backupsql');
		$db = new DBManage ( C('DB_HOST'),C('DB_USER'), C('DB_PWD'), C('DB_NAME'), 'utf8' );
		if($this->_post('pid')){
			$smtp=M('smtp');
			$stmpArr=$smtp->find();
			$backup=$db->backup();
			if($backup){
				if($this->_post('email')){
					$stmpArr['receipt_email']	=$this->_post('email');
					$stmpArr['title']			="数据库备份".time();
					$stmpArr['content']			='<div>
														备份时间:'.date('Y/m/d H:i:s').'
													</div>';
					$stmpArr['addattachment']	=$backup;
					$this->email_send($stmpArr);//发送邮件
					$this->Record('数据库备份成功');//后台操作
					//删除备份的数据表
					if(file_exists($backup)){	
						unlink($backup);	//删除它
					}
					$this->success("数据库备份成功","__APP__/TIFAWEB_DSWJCMS/Basis/backup");
					exit;
				}else{
					$this->error("请输入正确的邮箱地址");
				}
			}else{
				$this->Record('数据库备份失败');//后台操作
				$this->error("数据库备份失败");
			}	
		}
		$this->display();
    }
//--------导航页-----------
    public function shuffling(){
        $shuff = M('shuffling');
        $list = $shuff->select();
        $this->assign('list',$list);
        $this->display();
    }
	
    //添加轮播图片
    public function addsh(){
		$info=$this->upload('undefined',1);
		
		$Shuff=D('Shuffling');
		if(!$create=$Shuff->create()){
				$this->error($Shuff->getError());
		}
		$create['time']=time();
		//有图片上传处理
		if($info){
			$create['img']=$info[0]['savename'];
			
		}
		$last=$Shuff->add($create);
		if($last){
				$this->Record('添加轮播图片成功');//后台操作
				$this->success('添加成功', '__APP__/TIFAWEB_DSWJCMS/Basis/shuffling');
		}else{
				$this->Record('添加轮播图片失败');//后台操作
				$this->error('商品添加失败');
		}
    }
	
    //排序修改
    public function savesh(){
            $Shuff=M('shuffling');
            $id=$this->_post('id');
			$order=$this->_post('order');
			$state=$this->_post('state');
			$data['id']			= $id;
			if(isset($order)){
			$data['order']		= $order;
			}else if(isset($state)){
			$data['state']		= $state;	
			}
			$Shuff->save($data);
    }
	
    //轮播图片编辑页
    public function editshu(){
            $Shuff = M('shuffling');
            $id=$this->_get('id');
            $edlist = $Shuff->where('id='.$id)->select();
            $this->assign('edlist',$edlist);
            $this->display();
    }

    //轮播图片编辑页保存
    public function editsh(){
		$info=$this->upload('undefined',1);
		$Shuff=D('Shuffling');
		if(!$create=$Shuff->create()){
				$this->error($Shuff->getError());
		}
		//有图片上传处理
		if($info){
			$create['img']=$info[0]['savename'];
			
		}
		$Shuff->where(array('id'=>$this->_post('id')))->save($create);
		$this->Record('轮播图片修改成功');//后台操作
		$this->success('修改成功', '__APP__/TIFAWEB_DSWJCMS/Basis/shuffling');
    }

    //轮播图片删除
    public function delesh(){
            $Shuff=M('shuffling');
            $id=$this->_get('id');
            $Shuff->where('id='.$id)->delete();
			$this->Record('轮播图片删除成功');//后台操作
            $this->success('删除成功', '__APP__/TIFAWEB_DSWJCMS/Basis/shuffling');
    }
	
//--------友情链接-----------
    public function links(){
        $shuff = M('links');
        $list = $shuff->select();
        $this->assign('list',$list);
        $this->display();
    }
	
	//添加友情链接
    public function addli(){
		$info=$this->upload('undefined',1);
		$Links=D('Links');
		if(!$create=$Links->create()){
				$this->error($Links->getError());
		}
		//有图片上传处理
		if($info){
			$create['img']=$info[0]['savename'];
			
		}
		$create['time']=time();
		$last=$Links->add($create);
		if($last){
			$this->Record('添加友情链接成功');//后台操作
				$this->success('添加成功', '__APP__/TIFAWEB_DSWJCMS/Basis/links');
		}else{
			$this->Record('添加友情链接失败');//后台操作
				$this->error('友情链接添加失败');
		}
    }
	
    //排序修改
    public function saveli(){
            $Shuff=M('links');
            $id=$this->_post('id');
			$order=$this->_post('order');
			$state=$this->_post('state');
			$data['id']			= $id;
			if(isset($order)){
			$data['order']		= $order;
			}else if(isset($state)){
			$data['state']		= $state;	
			}
			$Shuff->save($data);
    }
	
    //友情链接编辑页
    public function editlink(){
            $Shuff = M('links');
            $id=$this->_get('id');
            $edlist = $Shuff->where('id='.$id)->select();
            $this->assign('edlist',$edlist);
            $this->display();
    }

    //友情链接编辑页保存
    public function editli(){
		$info=$this->upload('undefined',1);
		$links=D('Links');
		if(!$create=$links->create()){
				$this->error($links->getError());
		}
		//有图片上传处理
		if($info){
			$create['img']=$info[0]['savename'];
			
		}
		$links->where(array('id'=>$this->_post('id')))->save($create);
		$this->Record('友情链接修改成功');//后台操作
		$this->success('修改成功', '__APP__/TIFAWEB_DSWJCMS/Basis/links');
    }

    //友情链接删除
    public function deleli(){
            $Shuff=M('links');
            $id=$this->_get('id');
            $Shuff->where('id='.$id)->delete();
			$this->Record('友情链接删除成功');//后台操作
            $this->success('删除成功', '__APP__/TIFAWEB_DSWJCMS/Basis/links');
    }
	
	//--------数据库优化-----------
	public function optimization(){
		if($this->_post('oid')){
			$models = new Model();
			$models->query('OPTIMIZE TABLE 
			`ds_admin` ,
			`ds_article` ,
			`ds_article_add` ,
			`ds_auth_group` ,
			`ds_auth_group_access` ,
			`ds_auth_rule` ,
			`ds_city` ,
			`ds_links` ,
			`ds_operation` ,
			`ds_shuffling` ,
			`ds_site` ,
			`ds_site_add` ,
			`ds_smtp` ,
			`ds_system` ,
			`ds_unite` ,
			`ds_user` ,
			`ds_user_log`');
			$this->success('优化成功', '__APP__/TIFAWEB_DSWJCMS/Basis/optimization');
			exit;
		}	 
		$this->display();
	}
}
?>