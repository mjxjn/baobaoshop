<?php

/**
 * ECSHOP 短信模块 之 控制器
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: yehuaixiao $
 * $Id: sms.php 17155 2010-05-06 06:29:05Z yehuaixiao $
 */

define('IN_ECS', true);
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

require(dirname(__FILE__) . '/includes/init.php');
require_once(dirname(__FILE__) . '/includes/cls_sms.php');

$action = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'display_my_info';

	$sql = 'SELECT `serialNumber`, `password`, `smsnum`, `sessionKey`
            FROM ' . $GLOBALS['ecs']->table('sms_config') . "
            WHERE id=1";
    $result = $GLOBALS['db']->query($sql);
	$sms_site_info=array();
    if (!empty($result))
    {
        while ($temp_arr = $GLOBALS['db']->fetchRow($result))
        {
                $sms_site_info['serialNumber'] = $temp_arr['serialNumber'];
				$sms_site_info['password'] = $temp_arr['password'];
				$sms_site_info['smsnum'] = $temp_arr['smsnum'];
				$sms_site_info['sessionKey'] = $temp_arr['sessionKey'];
        }
    }
	header("Content-Type: text/html; charset=utf8");
	/**
	 * 网关地址
	 */	
	$gwUrl = 'http://sdkhttp.eucp.b2m.cn/sdk/SDKService?wsdl';


	/**
	 * 序列号,请通过亿美销售人员获取
	 */
	$serialNumber = $sms_site_info['serialNumber'];

	/**
	 * 密码,请通过亿美销售人员获取
	 */
	$password = $sms_site_info['password'];

	/**
	 * 登录后所持有的SESSION KEY，即可通过login方法时创建
	 */
	$sessionKey = $sms_site_info['sessionKey'];

	/**
	 * 连接超时时间，单位为秒
	 */
	$connectTimeOut = 2;

	/**
	 * 远程信息读取超时时间，单位为秒
	 */ 
	$readTimeOut = 10;

	/**
		$proxyhost		可选，代理服务器地址，默认为 false ,则不使用代理服务器
		$proxyport		可选，代理服务器端口，默认为 false
		$proxyusername	可选，代理服务器用户名，默认为 false
		$proxypassword	可选，代理服务器密码，默认为 false
	*/	
		$proxyhost = false;
		$proxyport = false;
		$proxyusername = false;
		$proxypassword = false; 

	$client = new Client($gwUrl,$serialNumber,$password,$sessionKey,$proxyhost,$proxyport,$proxyusername,$proxypassword,$connectTimeOut,$readTimeOut);

switch ($action)
{
	case 'display_my_info' :
		$smarty->assign('sms_site_info', get_sms_info());
		$smarty->display('sms_display_info.htm');
		break;
	case 'myinfo' :
		$link[] = array('text'  =>  $_LANG['back'],
                        'href'  =>  'sms.php?act=display_my_info');
		$serialNumber   = isset($_POST['serialNumber']) ? $_POST['serialNumber']    : '';
		$password   = isset($_POST['password']) ? $_POST['password']    : '';
		$smsnum   = isset($_POST['smsnum']) ? $_POST['smsnum']    : '';
		$sessionKey   = isset($_POST['sessionKey']) ? $_POST['sessionKey']    : '';
		$sql="update ". $GLOBALS['ecs']->table('sms_config') . " set 
			  serialNumber='$serialNumber', password='$password', smsnum='$smsnum', sessionKey='$sessionKey' where id=1";
		$result = $GLOBALS['db']->query($sql);
		if($result)
		{
			sys_msg($_LANG['config_ok'], 0, $link);
		}else
		{
			sys_msg($_LANG['config_error'], 1, $link);
		}
		break;
	case 'display_charge_ui' :
		$smarty->assign('sms_site_info', get_sms_info());
		$smarty->display('sms_charge_ui.htm');
		break;
	case 'charge' :
		$link[] = array('text'  =>  $_LANG['back'],
                        'href'  =>  'sms.php?act=display_charge_ui');
		$register_charge   = isset($_POST['register_charge']) ? $_POST['register_charge']    : '';
		$order_charge   = isset($_POST['order_charge']) ? $_POST['order_charge']    : '';
		$confirm_charge   = isset($_POST['confirm_charge']) ? $_POST['confirm_charge']    : '';
		$sql="update ".$GLOBALS['ecs']->table('sms_config') . " set 
			register_charge='$register_charge', order_charge='$order_charge',confirm_charge='$confirm_charge' where id=1";
		$result = $GLOBALS['db']->query($sql);
		if($result)
		{
			sys_msg($_LANG['charge_ok'], 0, $link);
		}else
		{
			sys_msg($_LANG['charge_error'], 1, $link);
		}	
		break;
	case 'display_send_ui' :
		$smarty->display('sms_send_ui.htm');
		break;
	case 'send_sms' :
		$link[] = array('text'  =>  $_LANG['back'],
                        'href'  =>  'sms.php?act=display_send_ui');
		$send_num = isset($_POST['send_num']) ? $_POST['send_num']   : '';
		$sendTime = isset($_POST['sendTime']) ? $_POST['sendTime']    : '';
		$msg = isset($_POST['msg']) ? $_POST['msg']    : '';
		$msg=iconv("UTF-8","GBK", $msg);
		$send_num=explode(",",$send_num);
		
		login();
			$result=send_sms($send_num,$msg,$sendTime);

			if($result!=null && $result=="0")
			{
				sys_msg($_LANG['send_ok'], 0, $link);
			}else
			{
				echo $result;
				//sys_msg($_LANG['send_error'], 1, $link);
			}
		
		break;
}

function get_sms_info()
{
	$sql = 'SELECT `serialNumber`, `password`, `smsnum`, `sessionKey`, `register_charge` , `order_charge` , `confirm_charge` 
            FROM ' . $GLOBALS['ecs']->table('sms_config') . "
            WHERE id=1";
    $result = $GLOBALS['db']->query($sql);
	$sms_site_info=array();
    if (!empty($result))
    {
        while ($temp_arr = $GLOBALS['db']->fetchRow($result))
        {
                $sms_site_info['serialNumber'] = $temp_arr['serialNumber'];
				$sms_site_info['password'] = $temp_arr['password'];
				$sms_site_info['smsnum'] = $temp_arr['smsnum'];
				$sms_site_info['sessionKey'] = $temp_arr['sessionKey'];
				$sms_site_info['register_charge'] = $temp_arr['register_charge'];
				$sms_site_info['order_charge'] = $temp_arr['order_charge'];
				$sms_site_info['confirm_charge'] = $temp_arr['confirm_charge'];
        }
    }
    return $sms_site_info;
}
function send_sms($mobiles=array(),$content,$sendTime)
{
	global $client;
	
	$statusCode = $client->sendSMS($mobiles,$content,$sendTime);
	return $statusCode;
}
/**
	* 登录 用例
 */
function login()
{
	global $client;
		
	/**
	 * 下面的操作是产生随机6位数 session key
	 * 注意: 如果要更换新的session key，则必须要求先成功执行 logout(注销操作)后才能更换
	 * 我们建议 sesson key不用常变
	 */
		//$sessionKey = $client->generateKey();
		//$statusCode = $client->login($sessionKey);
		
	$statusCode = $client->login();

	return $statusCode;

}
?>