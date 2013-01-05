<?php
/**
 * ECSHOP 智能搜索程序
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: search.php 17163 2010-05-20 10:13:23Z liuhui $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

$_REQUEST['q']   = !empty($_REQUEST['q'])   ? htmlspecialchars(trim($_REQUEST['q']))     : '';

$adv_value['keywords']  = htmlspecialchars(stripcslashes($_REQUEST['q']));

$sql = 'SELECT g.goods_name,count(og.goods_number) as su FROM ' . $ecs->table('goods') . " g , ". $ecs->table('order_goods') ." og  WHERE  g.goods_id = og.goods_id and g.goods_name LIKE '%".$adv_value['keywords']."%' GROUP BY g.goods_id order by su desc LIMIT 10";

$res = $db->query($sql);
$cat = $GLOBALS['db']->getAll($sql);
if (!empty($cat))
{
	while ($row = $db->FetchRow($res))
	{
		$values[] = '"' . $row['goods_name'] . '"';
	}
	print "new Array(" . implode(", ", $values) . ");";
}
?>