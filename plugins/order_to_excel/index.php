<?php
/**
 * ECSHOP 导出订单插件
 * ============================================================================
 * 插件开发: http://www.cmsok.com
 * QQ: 307150302
*/
define('IN_ECS', true);
require(dirname(__FILE__) . '/../../includes/init.php');
include_once(ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/admin/order.php');
include_once(ROOT_PATH . 'includes/lib_order.php');


$order_sn = trim($_GET['order_sn']);
$consignee = trim($_GET['consignee']);
$status = intval($_GET['status']);


if (!empty($order_sn))
{
	$where .= " AND o.order_sn like '%$order_sn%'";
}
if (!empty($consignee))
{
	$where .= " AND o.consignee like '%$consignee%'";
}

switch($status)
{
	case CS_AWAIT_PAY :
		$where .= order_query_sql('await_pay','o.');
		break;

	case CS_AWAIT_SHIP :
		$where .= order_query_sql('await_ship','o.');
		break;

	case CS_FINISHED :
		$where .= order_query_sql('finished','o.');
		break;

	case PS_PAYING :
		if ($status != -1)
		{
			$where .= " AND o.pay_status = '$status' ";
		}
		break;

	default:
		if ($status != -1)
		{
			$where .= " AND o.order_status = '$status' ";
		}
}

$sql = "SELECT o.*, ( o.goods_amount + o.tax + o.shipping_fee + o.insure_fee + o.pay_fee + o.pack_fee + o.card_fee ) AS total_fee, ".
		"ra.region_name AS country_name, ".
		"rb.region_name AS province_name, ".
		"rc.region_name AS city_name, ".
		"rd.region_name AS district_name ".
		"FROM " .$GLOBALS['ecs']->table('order_info'). " AS o ".
		"LEFT JOIN " .$GLOBALS['ecs']->table('region'). " AS ra ON ra.region_id=o.country ".
		"LEFT JOIN " .$GLOBALS['ecs']->table('region'). " AS rb ON rb.region_id=o.province ".
		"LEFT JOIN " .$GLOBALS['ecs']->table('region'). " AS rc ON rc.region_id=o.city ".
		"LEFT JOIN " .$GLOBALS['ecs']->table('region'). " AS rd ON rd.region_id=o.district ".
		"WHERE 1 $where ORDER BY o.order_id DESC";
		
		
		
header("Content-type:application/vnd.ms-excel");
header("Accept-Ranges:bytes");
header("Content-Disposition:filename=".time().".xls");
header("Pragma: no-cache");

echo '
	<html xmlns:o="urn:schemas-microsoft-com:office:office"
	xmlns:x="urn:schemas-microsoft-com:office:excel"
	xmlns="http://www.w3.org/TR/REC-html40">
	<head>
	<meta http-equiv="expires" content="Mon, 06 Jan 1999 00:00:01 GMT">
	<meta http-equiv=Content-Type content="text/html; charset=gb2312">
	<!--[if gte mso 9]><xml>
	<x:ExcelWorkbook>
	<x:ExcelWorksheets>
	<x:ExcelWorksheet>
	<x:Name></x:Name>
	<x:WorksheetOptions>
	<x:DisplayGridlines/>
	</x:WorksheetOptions>
	</x:ExcelWorksheet>
	</x:ExcelWorksheets>
	</x:ExcelWorkbook>
	</xml><![endif]-->
	</head>
';

echo '<table>';
echo '<tr>';
echo '<td>'.gstr('订单号').'</td>';
echo '<td>'.gstr('下单时间').'</td>';
echo '<td>'.gstr('收货人').'</td>';
echo '<td>'.gstr('国家').'</td>';
echo '<td>'.gstr('省').'</td>';
echo '<td>'.gstr('市').'</td>';
echo '<td>'.gstr('区').'</td>';
echo '<td>'.gstr('地址').'</td>';
echo '<td>'.gstr('邮政编码').'</td>';
echo '<td>'.gstr('电话').'</td>';
echo '<td>'.gstr('手机').'</td>';
echo '<td>'.gstr('Email').'</td>';
echo '<td>'.gstr('总金额').'</td>';
echo '<td>'.gstr('应付金额').'</td>';
echo '<td>'.gstr('订单状态').'</td>';
echo '<td>'.gstr('付款状态').'</td>';
echo '<td>'.gstr('发货状态').'</td>';
echo '</tr>';

		
$res = $GLOBALS['db']->query($sql);
while ($row = $GLOBALS['db']->fetchRow($res))
{
	echo '<tr>';
	echo "<td style='vnd.ms-excel.numberformat:@'>$row[order_sn]</td>";
	echo "<td>".date("Y-m-d H:i:s",$row['add_time'])."</td>";
	echo "<td>".gstr($row['consignee'])."</td>";
	echo "<td>".gstr($row['country_name'])."</td>";
	echo "<td>".gstr($row['province_name'])."</td>";
	echo "<td>".gstr($row['city_name'])."</td>";
	echo "<td>".gstr($row['district_name'])."</td>";
	echo "<td>".gstr($row['address'])."</td>";
	echo "<td>$row[zipcode]</td>";
	echo "<td>".gstr($row['tel'])."</td>";
	echo "<td>".gstr($row['mobile'])."</td>";
	echo "<td>".gstr($row['email'])."</td>";
	echo "<td>$row[total_fee]</td>";
	echo "<td>$row[order_amount]</td>";
	echo "<td>".gstr($_LANG['cs'][$row['order_status']])."</td>";
	echo "<td>".gstr($_LANG['ps'][$row['pay_status']])."</td>";
	echo "<td>".gstr($_LANG['ss'][$row['shipping_status']])."</td>";
	echo '</tr>';
}

echo '</table>';


function gstr($str)
{
	return iconv('UTF-8', 'GB2312', $str);
}
?>