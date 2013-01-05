<?php

/**
 * ECSHOP 排行榜
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: activity.php 17063 2010-03-25 06:35:46Z liuhui $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
include_once(ROOT_PATH . 'includes/lib_transaction.php');

/* 载入语言文件 */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/shopping_flow.php');
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');

/* 获得请求的分类 ID */
if (isset($_REQUEST['id']))
{
    $cat_id = intval($_REQUEST['id']);
}
else
{
    $cat_id = 0;
}

/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

assign_template();
assign_dynamic('top10');
$position = assign_ur_here(0, $_LANG['shopping_top10']);
$smarty->assign('page_title',       $position['title']);    // 页面标题
$smarty->assign('ur_here',          $position['ur_here']);  // 当前位置

// 数据准备

$goods_top10_data = get_top10($cat_id);
$smarty->assign('goods_top10_data', $goods_top10_data);
//$smarty->assign('filter',           $goods_top10_data['filter']);
/**
 * 取得销售排行数据信息
 * @param   int  $top10 排行榜前10
 * @return  array   销售排行数据
 */
/*
function get_top10_order($top10 = 10, $cat_id)
{
	$end_date = date('Y-m-d');
    $filter['start_date'] = local_strtotime("2000-1-1");
    $filter['end_date'] = local_strtotime($end_date);
    $filter['sort_by'] = 'goods_num';
    $filter['sort_order'] = 'DESC';
	
    $where = " WHERE og.order_id = oi.order_id ". order_query_sql('finished', 'oi.');
	
    if ($filter['start_date'])
    {
        $where .= " AND oi.add_time >= '" . $filter['start_date'] . "'";
    }
    if ($filter['end_date'])
    {
        $where .= " AND oi.add_time <= '" . $filter['end_date'] . "'";
    }

    $sql = "SELECT COUNT(distinct(og.goods_id)) FROM " .
           $GLOBALS['ecs']->table('order_info') . ' AS oi,'.
           $GLOBALS['ecs']->table('order_goods') . ' AS og '.
           $where;
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

	if($cat_id!=0)
	{
		$get_top10_tree = get_child_tree($cat_id);
		foreach ($get_top10_tree AS $row)
		{
				$cat_ids .= "'".$row['id']."',";
		}
		$cat_ids = substr($cat_ids,0,strlen($cat_ids)-1);
		$where .= " AND gs.cat_id IN (".$cat_ids.") ";
	}
	
    $sql = "SELECT og.goods_id, og.goods_sn, og.goods_name, gs.market_price, gs.shop_price, gs.promote_price, gs.promote_start_date, gs.promote_end_date, gs.goods_thumb, gs.is_on_sale, gs.is_delete, SUM(co.status) AS co_number, SUM(co.comment_rank) AS co_rank, oi.order_status, " .
           "SUM(og.goods_number) AS goods_num, SUM(og.goods_number * og.goods_price) AS turnover ".
           "FROM ".$GLOBALS['ecs']->table('order_goods')." AS og left join ".$GLOBALS['ecs']->table('goods')." AS gs ON og.goods_id = gs.goods_id left join ".$GLOBALS['ecs']->table('comment')." AS co ON og.goods_id = co.id_value," .
           $GLOBALS['ecs']->table('order_info')." AS oi  " .$where . " and gs.is_on_sale = 1 and gs.is_delete = 0 " .
           " GROUP BY og.goods_id ".
           ' ORDER BY ' . $filter['sort_by'] . ' ' . $filter['sort_order'] ;
    if ($top10)
    {
        $sql .= " LIMIT 0, " . $top10;
    }

    $sales_order_data = $GLOBALS['db']->getAll($sql);

    foreach ($sales_order_data as $key => $item)
    {
        $sales_order_data[$key]['wvera_price'] = price_format($item['goods_num'] ? $item['turnover'] / $item['goods_num'] : 0);
		
		$sales_order_data[$key]['wvera_rank']  = $item['co_number']!=0 ? number_format(($item['co_rank'] / $item['co_number'])*20,1,'.','') : 100;
        $sales_order_data[$key]['short_name']  = sub_str($item['goods_name'], 30, true);
        //$sales_order_data[$key]['turnover']    = price_format($item['turnover']);
        //$sales_order_data[$key]['taxis']       = $key + 1;
		if ($sales_order_data[$key]['promote_price'] > 0)
        {
            $promote_price = bargain_price($sales_order_data[$key]['promote_price'], $sales_order_data[$key]['promote_start_date'], $sales_order_data[$key]['promote_end_date']);
        }
        else
        {
            $promote_price = 0;
        }
		$sales_order_data[$key]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
		$sales_order_data[$key]['zhekou']      =($promote_price > 0) ? number_format($promote_price/$item['market_price'],2,'.','')*10 : number_format($item['shop_price']/$item['market_price'],2,'.','')*10;
		$sales_order_data[$key]['jiesheng'] = ($promote_price > 0) ? $item['market_price']-$promote_price : $item['market_price']-$item['shop_price'];
		$sales_order_data[$key]['co_number'] = ($sales_order_data[$key]['co_number'] == '') ? 0 : $sales_order_data[$key]['co_number'] ; 
    }

    $arr = array('sales_order_data' => $sales_order_data, 'filter' => $filter);

    return $arr;
}
*/

//print_r($list);


$smarty->assign('cat_id',       $cat_id); // 分类树

$smarty->assign('categories',       get_top10_tree()); // 分类树
$smarty->assign('helps',            get_shop_help());       // 网店帮助
$smarty->assign('shop_notice',     $_CFG['shop_notice']);       // 商店公告
$smarty->assign('lang',             $_LANG);

$smarty->assign('feed_url',         ($_CFG['rewrite'] == 1) ? "feed-typeactivity.xml" : 'feed.php?type=activity'); // RSS URL
$smarty->display('top10.dwt');

