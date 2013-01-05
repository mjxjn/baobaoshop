<?php
/**
 * ECSHOP 导出取货商品插件
 * ============================================================================
 * 插件开发: maxiang
 * QQ: 22743285
*/
define('IN_ECS', true);
require(dirname(__FILE__) . '/../../includes/init.php');
include_once(ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/admin/goods_booking.php');
include_once(ROOT_PATH . 'includes/lib_goods.php');

$type = empty($_GET['type'])?0:(int)$_GET['type'];
$s = empty($_GET['s'])?0:(int)$_GET['s'];
$e = empty($_GET['e'])?0:(int)$_GET['e'];
$key = $_GET['author'];

if($key!='maxiang'){
	exit;
}

if($type==0){
	exit;
}elseif($type==1){
	$where=" g.goods_number < 3 and is_delete =0 ";
	$limit='';
}elseif($type==2){
	$where=" is_delete =0 ";

	//$sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('goods').
	//   " WHERE ".$where;
	//$count = $GLOBALS['db']->getOne($sql);
	
	//$pagesize = '2000';
	
	$limit=" LIMIT ".$s.",".$e;
}

echo $s."||||||".$e;


$sql = "SELECT g.goods_id,g.goods_sn,g.goods_num,g.goods_name,g.goods_number,g.shop_price,g.is_on_sale,g.is_best,".
	   " g.is_new,g.is_hot,g.sort_order,b.brand_name,c.cat_name ".
	   " FROM ".$GLOBALS['ecs']->table('goods'). " AS g ".
	   " LEFT JOIN ". $GLOBALS['ecs']->table('brand') ." AS b ON b.brand_id=g.brand_id ".
	   " LEFT JOIN ". $GLOBALS['ecs']->table('category') ." AS c ON c.cat_id=g.cat_id ".
	   " WHERE ".$where." order by g.goods_id desc ".$limit;

		
		
		
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
echo '<td>'.gstr('编号').'</td>';
echo '<td>'.gstr('商品名称').'</td>';
echo '<td>'.gstr('商品分类').'</td>';
echo '<td>'.gstr('商品品牌').'</td>';
echo '<td>'.gstr('货号').'</td>';
echo '<td>'.gstr('商品条码').'</td>';
echo '<td>'.gstr('价格').'</td>';
echo '<td>'.gstr('上架').'</td>';
echo '<td>'.gstr('目录').'</td>';
echo '<td>'.gstr('新品').'</td>';
echo '<td>'.gstr('热销').'</td>';
echo '<td>'.gstr('推荐排序').'</td>';
echo '<td>'.gstr('库存').'</td>';
echo '</tr>';

		
$res = $GLOBALS['db']->query($sql);
while ($row = $GLOBALS['db']->fetchRow($res))
{
	if($row['is_on_sale']==0){
		$row['is_on_sale']="否";
	}else{
		$row['is_on_sale']="是";
	}
	if($row['is_best']==0){
		$row['is_best']="否";
	}else{
		$row['is_best']="是";
	}
	if($row['is_new']==0){
		$row['is_new']="否";
	}else{
		$row['is_new']="是";
	}
	if($row['is_hot']==0){
		$row['is_hot']="否";
	}else{
		$row['is_hot']="是";
	}
	echo '<tr>';
	echo "<td style='vnd.ms-excel.numberformat:@'>$row[goods_id]</td>";
	echo "<td>".gstr($row['goods_name'])."</td>";
	echo "<td>".gstr($row['cat_name'])."</td>";
	echo "<td>".gstr($row['brand_name'])."</td>";
	echo "<td style='vnd.ms-excel.numberformat:@'>$row[goods_sn]</td>";
	echo "<td style='vnd.ms-excel.numberformat:@'>$row[goods_num]</td>";
	echo "<td>".gstr($row['shop_price'])."</td>";
	echo "<td>".gstr($row['is_on_sale'])."</td>";
	echo "<td>".gstr($row['is_best'])."</td>";
	echo "<td>".gstr($row['is_new'])."</td>";
	echo "<td>".gstr($row['is_hot'])."</td>";
	echo "<td>".gstr($row['sort_order'])."</td>";
	echo "<td>".gstr($row['goods_number'])."</td>";
	echo '</tr>';
}

echo '</table>';


function gstr($str)
{
	return iconv('UTF-8', 'GB2312', $str);
}
?>