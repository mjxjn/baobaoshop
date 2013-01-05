<?php
define('IN_ECS', true);

require('../includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

assign_template();

$smarty->assign('page_title',      '活动公告_明星宝宝秀_婴格母婴商城-云南最大的母婴一站式购物网站,妈妈们的放心选择,云南母婴第一品牌!');    // 页面标题
$smarty->assign('announcement',     get_baby_announcement());
$smarty->assign('helps',            get_shop_help());       // 网店帮助
$smarty->display('starbaby/announcement.htm');


function get_baby_announcement(){
	require('EncodeQ3boy.php');
	$u=new EncodeQ3boy();
	$sql="select * FROM ".$GLOBALS['ecs']->table('baby_ia')." order by ia_id desc limit 0,1";
	$res = $GLOBALS['db']->query($sql);
	$list = array();
	while ($row = $GLOBALS['db']->fetchRow($res))
	{
		$row['announcement']=$u->ubbEncode($row['announcement']);
		$list = $row;
	}
	return $list;
}

?>