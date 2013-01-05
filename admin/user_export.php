<?php

/**
 * ECSHOP 会员管理程序
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: users.php 17063 2010-03-25 06:35:46Z liuhui $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if($_REQUEST['act'] == 'users_download'){
    assign_query_info();
    $GLOBALS['smarty']->display('users_download.htm');
}
elseif ($_REQUEST['act'] == 'user_export')
{
    /* 检查权限 */
    admin_priv('goods_export');
    
    error_reporting(E_ALL);
    
    date_default_timezone_set('PRC');
    
    require_once 'PHPExcel/Classes/PHPExcel.php';
    
    $objPHPExcel = new PHPExcel();
    
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("USER info file");
							 
	$objPHPExcel->setActiveSheetIndex(0);
	
	$objPHPExcel->getActiveSheet()->setCellValue("A1", "会员名");
	$objPHPExcel->getActiveSheet()->setCellValue("B1", "手机号");
	$objPHPExcel->getActiveSheet()->setCellValue("C1", "积分");
	$objPHPExcel->getActiveSheet()->setCellValue("D1", "邮箱");
	$objPHPExcel->getActiveSheet()->setCellValue("E1", "联系人");
	$objPHPExcel->getActiveSheet()->setCellValue("F1", "收货地址");
	$objPHPExcel->getActiveSheet()->setCellValue("G1", "宝宝生日");
	$objPHPExcel->getActiveSheet()->setCellValue("H1", "宝宝性别");
	
	$objPHPExcel->getActiveSheet()->setTitle("Simple");
	
	$startime = isset($_REQUEST['start_date'])?local_strtotime($_REQUEST['start_date']):'';
	$endtime =isset($_REQUEST['end_date'])?local_strtotime($_REQUEST['end_date']):'';
	$type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
	$startid=isset($_REQUEST['start_id'])?$_REQUEST['start_id']:'';
	$endid=isset($_REQUEST['end_id'])?$_REQUEST['end_id']:'';
	
	 if(!empty($startime)){ 
		if($type==1){
		$sql = "SELECT distinct u.user_name,u.mobile_phone,u.pay_points,u.email,ad.consignee,ad.address,u.babybirthday,u.baby".
	    " FROM " . $ecs->table('users') ." as u LEFT JOIN" . $ecs->table('user_address') . " AS ad " .
		"ON u.user_id = ad.user_id left join ".$ecs->table('order_info')." as o on o.user_id=u.user_id where o.add_time between ".$startime." and ".$endtime;
		}else{
			$sql = "SELECT distinct u.user_name,u.mobile_phone,u.pay_points,u.email,ad.consignee,ad.address,u.babybirthday,u.baby".
					" FROM " . $ecs->table('users') ." as u LEFT JOIN" . $ecs->table('user_address') . " AS ad " .
					"ON u.user_id = ad.user_id where u.last_login between ".$startime." and ".$endtime;
		}
	 }else{
		if($type==1){
			$sql = "SELECT distinct u.user_name,u.mobile_phone,u.pay_points,u.email,ad.consignee,ad.address,u.babybirthday,u.baby".
					" FROM " . $ecs->table('users') ." as u LEFT JOIN" . $ecs->table('user_address') . " AS ad " .
					"ON u.user_id = ad.user_id left join ".$ecs->table('order_info')." as o on o.user_id=u.user_id where o.user_id between ".$startid." and ".$endid;
		}else{
			$sql = "SELECT distinct u.user_name,u.mobile_phone,u.pay_points,u.email,ad.consignee,ad.address,u.babybirthday,u.baby".
					" FROM " . $ecs->table('users') ." as u LEFT JOIN" . $ecs->table('user_address') . " AS ad " .
					"ON u.user_id = ad.user_id where u.user_id  between ".$startid." and ".$endid;
		}
	} 

	//echo $sql;
	$res = $db->query($sql);
	
	$i=2;
	while ($row = $db->fetchRow($res))
    {
    	//iconv("gbk","UTF-8",$row['user_name'])
    	if($row['baby']==1)
		{
			$row['baby']="男宝宝";
		}elseif($row['baby']==2)
		{
			$row['baby']="女宝宝";
		}elseif($row['baby']==3){
			$row['baby']="预产期";
		}else{
			$row['baby']="";
		}
		$objPHPExcel->getActiveSheet()->setCellValue("A".$i, $row['user_name']);
		$objPHPExcel->getActiveSheet()->setCellValue("B".$i, $row['mobile_phone']);
		$objPHPExcel->getActiveSheet()->setCellValue("C".$i, $row['pay_points']);
		$objPHPExcel->getActiveSheet()->setCellValue("D".$i, $row['email']);
		$objPHPExcel->getActiveSheet()->setCellValue("E".$i, $row['consignee']);
		$objPHPExcel->getActiveSheet()->setCellValue("F".$i, $row['address']);
		$objPHPExcel->getActiveSheet()->setCellValue("G".$i, $row['babybirthday']);
		$objPHPExcel->getActiveSheet()->setCellValue("H".$i, $row['baby']);
		$i++;
	}
	
	$objPHPExcel->setActiveSheetIndex(0);
	
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="UserInfo.xls"');
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
}