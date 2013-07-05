<?php

define('IN_ECS', true);

require('../includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

assign_template();

$smarty->assign('page_title',       '明星宝宝秀_婴格母婴商城-云南最大的母婴一站式购物网站,妈妈们的放心选择,云南母婴第一品牌!');    // 页面标题
$smarty->assign('top_baby',         top_baby());       // 网店帮助
$smarty->assign('helps',            get_shop_help());       // 网店帮助
$smarty->display('starbaby/index.htm');


function top_baby(){
	$sql = "select ia_id from ".$GLOBALS['ecs']->table('baby_ia')." order by ia_id desc limit 0,1";
	$ia_id = $GLOBALS['db']->getOne($sql);
	$sql = "SELECT * FROM " .$GLOBALS['ecs']->table('baby_baby')." where ia_id=".$ia_id." and baby_id NOT IN (25,73,57,46,39,96) order by baby_number desc limit 0,10";
	$res = $GLOBALS['db']->query($sql);
	$i=1;
	while ($topbaby = $GLOBALS['db']->fetchRow($res))
	{
		if($i<10){
			$top_baby[$i]['top_number']="00".$i;
		}else{
			$top_baby[$i]['top_number']="0".$i;
		}
		$top_baby[$i]['baby_id']=$topbaby['baby_id'];
		$top_baby[$i]['baby_pic']=$topbaby['baby_pic'];
		$pic=explode(",",$top_baby[$i]['baby_pic']);
		$top_baby[$i]['baby_pic']=$pic['0'];
		$top_baby[$i]['baby_name']=$topbaby['baby_name'];
		$top_baby[$i]['baby_content']=$topbaby['baby_content'];
		$top_baby[$i]['baby_number']=$topbaby['baby_number'];
		$top_baby[$i]['ia_id']=$topbaby['ia_id'];
		$i++;
	}
	return $top_baby;
}
?>