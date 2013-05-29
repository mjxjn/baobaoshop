<?php
define('IN_ECS', true);
define('SCRIPT_ROOT',  dirname(__FILE__).'/admin/');
require(dirname(__FILE__) .'/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
include_once(ROOT_PATH . 'includes/lib_transaction.php');

/* 载入语言文件 */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/shopping_flow.php');
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');

$user_id = $_SESSION['user_id'];

assign_template();

if (empty($user_id) && $user_id == 0)
{
	ecs_header("Location: user.php\n");
	exit;
}
$starttime=local_mktime('0','0','0','9','1','2012');
$endtime=local_mktime('23','59','59','9','10','2013');
$nowtime=gmtime();
if($nowtime<$starttime || $nowtime>$endtime)
{
	show_message($_LANG['niuruizi_start'],'','','warning');
	exit;
}
$daystart = local_mktime('8','0','0',date("m"),date("d"),date("Y"));
/*if($nowtime<$daystart)
{
	show_message($_LANG['niuruizi_daystart'],'','','warning');
	exit;
}*/
$sql ="select count(id) from ".$GLOBALS['ecs']->table('choujiang')." where date>".$daystart." and lv>1";
$choujiang_count=$GLOBALS['db']->getOne($sql);
if($choujiang_count>50&&empty($_GET['g'])){
    show_message("今天的50份抽奖资格已经结束",'继续答题','/chunjingbingdao_question.php?g=g','info');
}
$sql="SELECT order_id FROM ".$GLOBALS['ecs']->table('order_info') ." where user_id=".$user_id." and order_status=5";
$res = $GLOBALS['db']->getAll($sql);
if (empty($res))
{
	show_message($_LANG['niuruizi_msg'],'','','warning');
	exit;
}
$act = trim($_GET['act']);
if($act=='answer'){
	$question = $_POST['question'];
	$i=1;
	$j=0;
	foreach ($question as $res){
		$sql="SELECT answer FROM ".$ecs->table('chunjingbingdao') ." where id=".$res;
		$qa=$db->getOne($sql);
		$qus =  (int)$_POST['question'.$i];
		if($qa==$qus){
			$j++;
		}
		$i++;
	}
	if($j==20){
		/*$sql = "SELECT * FROM ". $GLOBALS['ecs']->table('user_bonus') ." WHERE bonus_type_id=9 and user_id=".$user_id." order by bonus_id asc";
		$res = $GLOBALS['db']->getAll($sql);
		if (!empty($res))
		{
			show_message($_LANG['niuruizi_over'],'','','warning');
			exit;
		}else{
				$starttime=local_mktime('9','0','0','9','1','2012');
				$nowtime=gmtime();
				$t= $nowtime-$starttime;
				if($t<0){
					$mod=0;
				}else{
					$mod =50*intval($t/86400);
				}
				
			$sql = "SELECT bonus_id FROM ". $GLOBALS['ecs']->table('user_bonus') ." WHERE bonus_type_id=9 order by bonus_id asc limit ".$mod.",50";
			$res = $GLOBALS['db']->getAll($sql);
			if(empty($res)){
				show_message($_LANG['niuruizi_limit'],'','','warning');
				exit;
			}else{
				foreach($res as $row){
					if($row['user_id']!=0){
						$con+=1;
					}
					if($con==50){
						show_message($_LANG['niuruizi_limit'],'','','warning');
						exit;
					}
				}
			$sql = "SELECT bonus_id FROM ". $GLOBALS['ecs']->table('user_bonus') ." WHERE bonus_type_id=9 and user_id=0 order by bonus_id asc limit 0,1";
			$bonus_id=$db->getOne($sql);
			$sql = "UPDATE ". $ecs->table('user_bonus') ." SET user_id=".$user_id." WHERE bonus_id=".$bonus_id;
       		$su=$db->query($sql);
       		

	       		require_once(dirname(__FILE__) . '/admin/includes/cls_sms.php');
	       		
	       		$sql="SELECT mobile_phone FROM ".$ecs->table('users') ."where user_id=".$user_id;
	       		$mobile_phone =$db->getOne($sql);
				
	       		$sql = 'SELECT `serialNumber`, `password`, `smsnum`, `sessionKey`, `order_charge` FROM ' . $ecs->table('sms_config') . " WHERE id=1";
	       		$result = $db->query($sql);
	       		$sms_site_info=array();
	       		if (!empty($result))
	       		{
	       			while ($temp_arr = $db->fetchRow($result))
	       			{
	       				$sms_site_info['serialNumber'] = $temp_arr['serialNumber'];
	       				$sms_site_info['password'] = $temp_arr['password'];
	       				$sms_site_info['smsnum'] = $temp_arr['smsnum'];
	       				$sms_site_info['sessionKey'] = $temp_arr['sessionKey'];
	       				$sms_site_info['order_charge'] = $temp_arr['order_charge'];
	       			}
	       		}
	       		header("Content-Type: text/html; charset=utf8");
	       		
	       		$gwUrl = 'http://sdkhttp.eucp.b2m.cn/sdk/SDKService?wsdl';
	       		
	       		$serialNumber = $sms_site_info['serialNumber'];
	
	       		$password = $sms_site_info['password'];
	
	       		$sessionKey = $sms_site_info['sessionKey'];
	
	       		$connectTimeOut = 2;
	   
	       		$readTimeOut = 10;
	       		
	       		$proxyhost = false;
	       		$proxyport = false;
	       		$proxyusername = false;
	       		$proxypassword = false;
	       		
	       		$client = new Client($gwUrl,$serialNumber,$password,$sessionKey,$proxyhost,$proxyport,$proxyusername,$proxypassword,$connectTimeOut,$readTimeOut);
	       		$msg="尊敬的婴格母婴商城会员，您参加婴格与纽瑞滋的答题活动，获得30元代金券一张，有效期至2012年9月30日。[婴格]";
	       		$msg=iconv("UTF-8","GBK", $msg);
	       		
	       		
	       		$result=send_sms($mobile_phone,$msg);
	       		if($result!=null && $result=="0")
	       		{
	       		
	       		}
	       		
				show_message($_LANG['niuruizi_success'],$_LANG['label_bonus'],'/user.php?act=bonus','info');
				exit;

			}
		}*/
                                                
	}else{
		show_message($_LANG['niuruizi_error'],'','','warning');
		exit;
	}
}

$sql="SELECT * from ".$ecs->table('chunjingbingdao') ." order by RAND() limit 0,20 ";
$res = $GLOBALS['db']->getAll($sql);

$smarty->assign('list',       $res);
$smarty->assign('categories',       get_categories_tree()); 
$smarty->assign('helps',            get_shop_help()); 
$smarty->assign('lang',             $_LANG);
$smarty->display('/zt/chunjingbingdao_question.dwt');

function send_sms($mobiles,$content)
{
	global $client;
	$sendTime="";
	$statusCode = $client->sendSMS(array($mobiles),$content,$sendTime);
	return $statusCode;
}
?>