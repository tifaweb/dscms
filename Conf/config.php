<?php
return array(
//'配置项'=>'配置值'
 'DB_TYPE'   => 'mysql', // 数据库类型
 'DB_PORT'   => 3306, // 端口   
      
'DB_SQL_BUILD_CACHE' => true,//SQL缓存
 'APP_GROUP_LIST' => 'Home,Admin,Api,Win', //项目分组设定
 //'TMPL_EXCEPTION_FILE'=>'./Tpl/Home/Logo/error.html',// 定义公共错误模板
 //'URL_404_REDIRECT'=>__ROOT__.'/error.html',
 'TMPL_PARSE_STRING'  =>array(
     'TIFAWEB_DSWJCMS' => 'Dswjcms',
  ),
 'DS_PATH'=>'',
 'AUTH_CONFIG'=>array(
	'AUTH_ON' => true, //认证开关
	'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
	'AUTH_GROUP' => 'ds_auth_group', //用户组数据表名
	'AUTH_GROUP_ACCESS' => 'ds_auth_group_access', //用户组明细表
	'AUTH_RULE' => 'ds_auth_rule', //权限规则表
	'AUTH_USER' => 'ds_admin'//用户信息表
 ),
 //'SHOW_PAGE_TRACE' =>true, // 显示页面Trace信息
 'URL_ROUTER_ON'   => true, //开启路由
 //'DATA_CACHE_TYPE'=>'Memcache',
 'URL_ROUTE_RULES' => array( //定义路由规则
		'Center/invest/:mid\s'        			=> 'Center/invest',
		'Center/loan/:mid\s'         			=> 'Center/loan',
		'Center/security/:mid\s'         		=> 'Center/security',
		'Center/fund/:mid\s'          			=> 'Center/fund',
		'Center/approve/:mid\s'      			=> 'Center/approve',
		'Center/basic/:mid\s'         			=> 'Center/basic',
		'Center/emailVerifyConfirm/:email_audit'=> 'Center/emailVerifyConfirm',
		'Center/stationexit/:id\s'         		=> 'Center/stationexit',
		'Admin/Index/editsys/:id\d'				=> 'Admin/Index/editsys',
		'Admin/Basis/editlin/:id\d'				=> 'Admin/Basis/editlin',
		'Admin/Basis/delelin/:id\d'				=> 'Admin/Basis/delelin',
		'Admin/Basis/editint/:id\d'				=> 'Admin/Basis/editint',
		'Admin/Basis/deleint/:id\d'				=> 'Admin/Basis/deleint',
		'Admin/Basis/editshu/:id\d'				=> 'Admin/Basis/editshu',
		'Admin/Basis/delesh/:id\d'				=> 'Admin/Basis/delesh',
		'Admin/Basis/editlink/:id\d'			=> 'Admin/Basis/editlink',
		'Admin/Basis/deleli/:id\d'				=> 'Admin/Basis/deleli',
		'Admin/Ganged/index/:id\d'				=> 'Admin/Ganged/index',
		'Admin/Ganged/exitgan/:id\d'			=> 'Admin/Ganged/exitgan',
	),
	'DS_ENTERPRISE'			=>	'dscms',
	'DS_EN_ENTERPRISE'		=>	'dswjjd',
	'DS_TOP_POWERED'		=>	'Powered by Dswjcms!',
	'DS_POWERED'			=>	'<p class="pull-left">Powered by <strong><a href="https://www.dswjcms.com" target="_blank">Dswjcms!</a></strong><em>0.1</em><br/>&copy; 2013-2017 <a href="http://www.tifaweb.com" target="_blank">Tf Inc.</a></p>',
);
?>