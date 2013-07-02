<?php

define('IN_ECS', true);

require('../includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

assign_template();
if($_REQUEST['act']=='bu'){
	$limit = empty($_REQUEST['p'])?1:$_REQUEST['p'];
	$limit = ($limit-1)*200;
	$sql = "select ia_id from ".$GLOBALS['ecs']->table('baby_ia')." order by ia_id desc limit 0,1";
	$ia_id = $GLOBALS['db']->getOne($sql);
	$sql = "SELECT user_id FROM " .$GLOBALS['ecs']->table('baby_baby')." where ia_id=".$ia_id." order by baby_id desc limit ".$limit.",200";
	$res = $GLOBALS['db']->query($sql);
	$i=1;
	while ($baby_userid = $GLOBALS['db']->fetchRow($res))
	{
		//echo $baby_userid['user_id']."<br />";
		$sql="select bonus_id from ".$GLOBALS['ecs']->table('user_bonus')." where user_id=0 and bonus_type_id=20 order by bonus_id asc limit 0,1";
		$bonus_id = $db->getOne($sql);
		echo "NO：".$bonus_id."<br />";
		$sql="update ".$GLOBALS['ecs']->table('user_bonus')." set user_id=".$baby_userid['user_id']." where bonus_type_id=20 and bonus_id=".$bonus_id;
		$db->query($sql);
		$i++;
	}
	echo "ok   ".$i;
}