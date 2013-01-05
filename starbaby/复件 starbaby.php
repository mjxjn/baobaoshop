<?php
define('IN_ECS', true);
define('discuz_auth_key', '3330777.com');
require('../includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
	$smarty->caching = true;
}

assign_template();

$act= isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
if(!empty($act)&&$act=='vote'){
if($_SESSION['user_id']==0){
	echo "-4";
	exit();
}else{
	//验证邮箱是否已验证通过
	/*
	$sql="select is_validated from ".$GLOBALS['ecs']->table('users'). " where user_id='".$_SESSION['user_id']."'";
	$is_validated=$GLOBALS['db']->getOne($sql);
	if($is_validated==0){
		echo "-5";
		exit();
	}
	*/
	$captcha=isset($_REQUEST['captcha']) ? $_REQUEST['captcha'] : '';
	$baby_number=isset($_REQUEST['number']) ? $_REQUEST['number'] : '';
	$baby_id=isset($_REQUEST['baby_id']) ? $_REQUEST['baby_id'] : '';
	$md5key=isset($_REQUEST['md5key']) ? $_REQUEST['md5key'] : '';
	$baby_id=verify_id($baby_id);
	if(empty($baby_number)&&empty($baby_id)&&empty($md5key)){
	   echo "-2";
	   exit;
	}
	/* 验证码检查 */
    
        if (empty($captcha))
        {
            echo "-3";
			exit;
        }

        /* 检查验证码 */
        include_once('../includes/cls_captcha.php');

        $validator = new captcha();
        if (!$validator->check_word($captcha))
        {
            echo "-3";
			exit;
        }
		$year=local_date("Y",gmtime());
		$month=local_date("m",gmtime());
		$day=local_date("d",gmtime());
	$startime=local_mktime(0,0,0,$month,$day,$year);
	$endtime=local_mktime(23,59,59,$month,$day,$year);
	$sql="select COUNT(*) AS svote from ".$GLOBALS['ecs']->table('baby_vote')." where user_id='".$_SESSION['user_id']."' and baby_id='".$baby_id."' and vote_time >= ".$startime." and vote_time <= ".$endtime;
	
	$svote=$GLOBALS['db']->getOne($sql);
	if($svote != 0)
	{
	   /* 此会员id投票 */
	   echo "-1";
	   exit;
	}
    /*if(authcode($md5key,'DECODE',$_SESSION['md5key'])!=$GLOBALS['discuz_auth_key'].$_SESSION['md5key']){
		echo "-2";
	    exit;
	}
	if(!empty($_COOKIE['vote_name'])){
		if($_COOKIE['vote_name']==$baby_id){
			echo "-1";
	   	 	exit;
		}
	}else{
		setcookie("vote_name", $baby_id);
	}*/
	
	
	$sql="select baby_number from ".$GLOBALS['ecs']->table('baby_baby')." where baby_id='".$baby_id."'";
	
	$baby_number=$GLOBALS['db']->getOne($sql);
	$baby_number+=1;
	
	$sql="insert into".$GLOBALS['ecs']->table('baby_vote'). "(baby_id,user_id, user_name,ip,vote_time,fvote_time) VALUES ('$baby_id', '".$_SESSION['user_id']."','".$_SESSION['user_name']."','".real_ip()."','".gmtime()."','".local_date("Y-m-d H:i:s",gmtime())."')";
	$GLOBALS['db']->query($sql);
	$sql="update ".$GLOBALS['ecs']->table('baby_baby')." SET baby_number = '".$baby_number."' WHERE baby_id = '".$baby_id."'";
	$GLOBALS['db']->query($sql);
	echo $baby_number;
	exit;
	}
}

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

$sql="select COUNT(*) AS sum from ".$GLOBALS['ecs']->table('baby_baby'). "where ia_id=".$ia_id.$where;
$sum=$GLOBALS['db']->getOne($sql);

$sql="select * from ".$GLOBALS['ecs']->table('baby_baby'). " where ia_id=".$ia_id.$where ." order by ". $sort." desc limit ".$size*($page-1)." , ".$size;
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
	$idx++;
}

$smarty->assign('page_title',      '明星宝宝秀列表_婴格母婴商城-云南最大的母婴一站式购物网站,妈妈们的放心选择,云南母婴第一品牌!');    // 页面标题
$smarty->assign('sum',              $sum);
$smarty->assign('sort1',              $sort1); 
$smarty->assign('sort2',              $sort2);
$smarty->assign('xz',                 $xz); 
$smarty->assign('sx',                 $sx); 
$smarty->assign('ia_id',              $ia_id); 
$smarty->assign('baby',              $babybaby); 
$_SESSION['md5key']=rand(1000, 9999);
$smarty->assign('md5key',            authcode($GLOBALS['discuz_auth_key'].$_SESSION['md5key'], 'ENCODE', $_SESSION['md5key']));

$now=gmtime();
$endtime=local_mktime(20, 0, 0, 6, 15, 2012);
if($enabled=$now>$endtime){
	$smarty->assign('enabled',       $enabled); //比赛结束
}
$order="desc";
$brand=$sort2;
$price_min=$xz;
$price_max=$sx;
assign_pager('starbaby',  $ia_id, $sum, $size, $sort, $order, $page, $key, $brand, $price_min, $price_max, $display, $filter_attr_str); // 分页

$smarty->assign('helps',            get_shop_help());       // 网店帮助
$smarty->display('starbaby/starbaby.htm');

?>