<?php

define('IN_ECS', true);
define('discuz_auth_key', '3330777.com');
require('../includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

assign_template();
if($_REQUEST['act']=='click'){
	            $baby_id=$_REQUEST['id']; 	
				$sql="select click from ".$GLOBALS['ecs']->table('baby_baby')." where baby_id='".$baby_id."'";
				$click=$GLOBALS['db']->getOne($sql);
				$click+=1;
				$sql="update ".$GLOBALS['ecs']->table('baby_baby')." set click='".$click."' where baby_id='".$baby_id."'";
				$GLOBALS['db']->query($sql);
				echo "document.write('".$click."');";
			exit;
}
if($_REQUEST['act']=='miaoshu'){
	if($_SESSION['user_id']==0){
		echo '-4';
		exit;
	}else{
	/* 没有验证码时，用时间来限制机器人发帖或恶意发评论 */
            if (!isset($_SESSION['send_miaoshu_time']))
            {
                $_SESSION['send_miaoshu_time'] = 0;
            }

            $cur_time = gmtime();
            if (($cur_time - $_SESSION['send_miaoshu_time']) < 30) // 小于30秒禁止发评论
            {
                echo "-2";
                exit;
            }
            else
            {
            	$_SESSION['send_miaoshu_time']=$cur_time;
            	$baby_id=verify_id($_REQUEST['baby_id']);
            	if(!inject_check($_REQUEST['miaoshu'])){
            		$miaoshu=strip_tags($_REQUEST['miaoshu']);
            		$miaoshu=str_check($miaoshu);
            		$miaoshu = preg_replace( "@<script(.*?)</script>@is", "", $miaoshu ); 
					$miaoshu = preg_replace( "@<iframe(.*?)</iframe>@is", "", $miaoshu ); 
					$miaoshu = preg_replace( "@<style(.*?)</style>@is", "", $miaoshu ); 
					$miaoshu = preg_replace( "@<(.*?)>@is", "", $miaoshu ); 
            	}else{
            		echo "-3";
            		exit;
            	}
            	if(strlen($miaoshu) > 240)
            	{
            		echo "-1";
                	exit;
            	}
            	$sql="select baby_yin from ".$GLOBALS['ecs']->table('baby_baby')." where baby_id=".$baby_id;
            	$baby_yin=$GLOBALS['db']->getOne($sql);
            	
            	if(empty($baby_yin)){
            		$baby_yin=$miaoshu;
            	}else{
            		$baby_yin=$baby_yin.",".$miaoshu;
            	}
            	$sql="update ".$GLOBALS['ecs']->table('baby_baby')." SET baby_yin = '".$baby_yin."' WHERE baby_id = ".$baby_id;
            	$GLOBALS['db']->query($sql);
            	echo "<span>".$miaoshu."</span>";
            	exit;            	
            }
	}
}

$baby_id=(int)$_REQUEST['id'];
$ia_id=(int)$_REQUEST['ia'];

$sql="select * from ".$GLOBALS['ecs']->table('baby_baby')." where baby_id=".$baby_id." and ia_id=".$ia_id;
$res=$GLOBALS['db']->query($sql);
$idx=1;
while($baby=$GLOBALS['db']->fetchRow($res)){
	$babybaby[$idx]['baby_id']=$baby['baby_id'];
	$babybaby[$idx]['baby_pic']=$baby['baby_pic'];
	$pic=explode(",",$babybaby[$idx]['baby_pic']);
	
	$babybaby[$idx]['baby_sex']=$baby['baby_sex']==1 ? '男':'女';
	$babybaby[$idx]['baby_name']=$baby['baby_name'];
	$babybaby[$idx]['baby_birthday']=$baby['baby_birthday'];
	$babybaby[$idx]['user_name']=$baby['user_name'];
	$babybaby[$idx]['baby_time']=$baby['baby_time'];
	$babybaby[$idx]['baby_content']=$baby['baby_content'];
	$babybaby[$idx]['baby_number']=$baby['baby_number'];
	
	$yin=explode(",",$baby['baby_yin']);
	if(empty($yin['0'])){
		$yins=FALSE;
	}else{
		$yins=true;
	}
	$idx++;
	
	if(empty($pic['1'])){
		$onepic=true;
		$one_pic=$pic['0'];
		$one_bigpic=str_replace('_s.jpg','_lit.jpg',$one_pic);
	}elseif(empty($pic['2'])){
		$onepic=false;
		$pics['0']=array('small'=>$pic['0'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['0']));
		$pics['1']=array('small'=>$pic['1'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['1']));
	}elseif(empty($pic['3'])){
		$onepic=false;
		$pics['0']=array('small'=>$pic['0'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['0']));
		$pics['1']=array('small'=>$pic['1'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['1']));
		$pics['2']=array('small'=>$pic['2'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['2']));
	}elseif(empty($pic['4'])){
		$onepic=false;
		$pics['0']=array('small'=>$pic['0'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['0']));
		$pics['1']=array('small'=>$pic['1'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['1']));
		$pics['2']=array('small'=>$pic['2'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['2']));
		$pics['3']=array('small'=>$pic['3'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['3']));
	}elseif(empty($pic['5'])){
		$onepic=false;
		$pics['0']=array('small'=>$pic['0'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['0']));
		$pics['1']=array('small'=>$pic['1'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['1']));
		$pics['2']=array('small'=>$pic['2'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['2']));
		$pics['3']=array('small'=>$pic['3'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['3']));
		$pics['4']=array('small'=>$pic['4'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['4']));
	}else{
		$onepic=false;
		$pics['0']=array('small'=>$pic['0'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['0']));
		$pics['1']=array('small'=>$pic['1'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['1']));
		$pics['2']=array('small'=>$pic['2'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['2']));
		$pics['3']=array('small'=>$pic['3'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['3']));
		$pics['4']=array('small'=>$pic['4'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['4']));
		$pics['5']=array('small'=>$pic['5'],'big'=>str_replace('_s.jpg','_lit.jpg',$pic['5']));
	}
}

$smarty->assign('page_title',      $baby_id.'号参赛宝宝_明星宝宝秀_婴格母婴商城-云南最大的母婴一站式购物网站,妈妈们的放心选择,云南母婴第一品牌!');    // 页面标题
$smarty->assign('baby_id',            $baby_id);
$smarty->assign('ia_id',            '11'.$ia_id);
$smarty->assign('ia_id2',            $ia_id);
$smarty->assign('baby',            $babybaby['1']);
$smarty->assign('onepic',          $onepic);
$smarty->assign('one_bigpic',          $one_bigpic);
$smarty->assign('one_pic',          $one_pic);
$smarty->assign('pic',             $pics);
$smarty->assign('yin',             $yin);
$smarty->assign('yins',             $yins);
if(empty($_SESSION['md5key'])){
	$_SESSION['md5key']=rand(1000, 9999);
}
$now=gmtime();
$endtime=local_mktime(20, 0, 0, 6, 15, 2012);
if($enabled=$now>$endtime){
	$smarty->assign('enabled',       $enabled); //比赛结束
}
$smarty->assign('md5key',            authcode($GLOBALS['discuz_auth_key'].$_SESSION['md5key'], 'ENCODE', $_SESSION['md5key']));

$smarty->assign('helps',            get_shop_help());       // 网店帮助
$smarty->display('starbaby/baby.htm');

?>