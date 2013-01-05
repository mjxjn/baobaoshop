<?php
define('IN_ECS', true);

require('../includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

assign_template();

$smarty->assign('page_title',      '活动介绍_明星宝宝秀_婴格母婴商城-云南最大的母婴一站式购物网站,妈妈们的放心选择,云南母婴第一品牌!');    // 页面标题
$smarty->assign('introduction',     get_baby_introduction());
$smarty->assign('helps',            get_shop_help());       // 网店帮助
$smarty->display('starbaby/introduction.htm');


function get_baby_introduction(){
	require('EncodeQ3boy.php');
	$u=new EncodeQ3boy();
	$sql="select * FROM ".$GLOBALS['ecs']->table('baby_ia')." order by ia_id desc limit 0,1";
	$res = $GLOBALS['db']->query($sql);
	$list = array();
	while ($row = $GLOBALS['db']->fetchRow($res))
	{
		$row['title']=$u->ubbEncode($row['title']);
		$row['btime']=$u->ubbEncode($row['btime']);
		$row['bcontent']=$u->ubbEncode($row['bcontent']);
		$row['bqurie']=$u->ubbEncode($row['bqurie']);
		$row['bage']=$u->ubbEncode($row['bage']);
		$row['rules']=$u->ubbEncode($row['rules']);
		$row['agoods']=$u->ubbEncode($row['agoods']);
		$row['aothergoods']=$u->ubbEncode($row['aothergoods']);
		$row['acontent']=$u->ubbEncode($row['acontent']);
		$list = $row;
	}
	return $list;
}
?>