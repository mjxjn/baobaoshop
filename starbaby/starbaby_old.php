<?php
define('IN_ECS', true);

require('../includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
	$smarty->caching = true;
}

assign_template();

$page = isset($_REQUEST['page'])   && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
$size = 25;

$sort1  = isset($_REQUEST['sort1'])?$_REQUEST['sort1'] : 'baby_id';
$sort2  = isset($_REQUEST['sort2'])?$_REQUEST['sort2'] : 'baby_all';

$xz = isset($_REQUEST['xz']) ? $_REQUEST['xz'] : '';
$sx = isset($_REQUEST['sx']) ? $_REQUEST['sx'] : '';

$key = isset($_REQUEST['key']) ? $_REQUEST['key'] : '';

$page=verify_id($page);



if(!empty($sort1)){
	$sort=$sort1." ";
}

if(empty($key)){
	if(!empty($sort2)){
		if($sort2=='baby_all'){
	
		}elseif($sort2=="baby_boy"){
			$where.=" and baby_sex=1 ";
		}elseif($sort2=="baby_girl"){
			$where.=" and baby_sex=2 ";
		}
	}
	if(!empty($xz)){
		$xz=verify_id($xz);
		$where.=" and baby_xing=".$xz." ";
	}
	if(!empty($sx)){
		$sx=verify_id($sx);
		$where.=" and baby_xiao=".$sx." ";
	}
}else{
	
	$key=verify_id($key);
	if(!is_numeric($key)){
		show_starbaby_message('请正确输入宝宝编号', '', '', 'warning');
		exit;
	}
	$where.=" and baby_id=".$key." ";
}
$sql = "select ia_id from ".$GLOBALS['ecs']->table('baby_ia')." order by ia_id desc limit 0,1";
$ia_id = $GLOBALS['db']->getOne($sql);

$sql="select COUNT(*) AS sum from ".$GLOBALS['ecs']->table('baby_baby'). "where ia_id<>".$ia_id.$where;
$sum=$GLOBALS['db']->getOne($sql);

$sql="select * from ".$GLOBALS['ecs']->table('baby_baby'). " where ia_id<>".$ia_id.$where ." order by ". $sort." desc limit ".$size*($page-1)." , ".$size;
$res=$GLOBALS['db']->query($sql);
$idx=1;
while($baby=$GLOBALS['db']->fetchRow($res)){
	$babybaby[$idx]['baby_id']=$baby['baby_id'];
	$babybaby[$idx]['baby_pic']=$baby['baby_pic'];
	$pic=explode(",",$babybaby[$idx]['baby_pic']);
	$babybaby[$idx]['baby_pic']=$pic['0'];
	$babybaby[$idx]['baby_name']=$baby['baby_name'];
	$babybaby[$idx]['baby_content']=$baby['baby_content'];
	$babybaby[$idx]['baby_number']=$baby['baby_number'];
	$babybaby[$idx]['ia_id']=$baby['ia_id'];
	$idx++;
}

$smarty->assign('page_title',      '往期明星宝宝秀列表_婴格母婴商城-云南最大的母婴一站式购物网站,妈妈们的放心选择,云南母婴第一品牌!');    // 页面标题
$smarty->assign('sum',              $sum);
$smarty->assign('sort1',              $sort1); 
$smarty->assign('sort2',              $sort2);
$smarty->assign('xz',                 $xz); 
$smarty->assign('sx',                 $sx); 
$smarty->assign('ia_id',              $ia_id); 
$smarty->assign('baby',              $babybaby); 
$_SESSION['md5key']=rand(1000, 9999);
$smarty->assign('md5key',            authcode($GLOBALS['discuz_auth_key'].$_SESSION['md5key'], 'ENCODE', $_SESSION['md5key']));

$order="desc";
$brand=$sort2;
$price_min=$xz;
$price_max=$sx;
assign_pager('starbaby_old',  $ia_id, $sum, $size, $sort, $order, $page, $key, $brand, $price_min, $price_max, $display, $filter_attr_str); // 分页

$smarty->assign('helps',            get_shop_help());       // 网店帮助
$smarty->display('starbaby/starbaby_old.htm');

?>