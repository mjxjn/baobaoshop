<?php
define('IN_ECS', true);

require(dirname(__FILE__) .'/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
include_once(ROOT_PATH . 'includes/lib_transaction.php');

/* 载入语言文件 */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/shopping_flow.php');
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');

assign_template();

$sql = "SELECT ". $GLOBALS['ecs']->table('user_bonus') .".user_id,". $GLOBALS['ecs']->table('users') .".user_name FROM ". $GLOBALS['ecs']->table('user_bonus') ."  left join ". $GLOBALS['ecs']->table('users')." on ". $GLOBALS['ecs']->table('user_bonus') .".user_id = ". $GLOBALS['ecs']->table('users').".user_id WHERE bonus_type_id=9 and ". $GLOBALS['ecs']->table('user_bonus') .".user_id<>0 order by ". $GLOBALS['ecs']->table('user_bonus') .".bonus_id desc limit 0,20";
$res = $GLOBALS['db']->getAll($sql);
if (!empty($res))
{
	foreach ($res as $key => $row){
		$res[$key]['user_name']=sub_str($row['user_name'],2)."****";
	}
}
$smarty->assign('list',       $res);
	$smarty->assign('categories',       get_categories_tree()); 
	$smarty->assign('helps',            get_shop_help()); 
$smarty->assign('lang',             $_LANG);
$smarty->display('/zt/chunjingbingdao.dwt');
?>