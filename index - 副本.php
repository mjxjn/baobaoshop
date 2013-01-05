<?php

/**
 * ECSHOP 首页文件
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: index.php 17063 2010-03-25 06:35:46Z liuhui $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);

$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i";

if(($ua == '' || preg_match($uachar, $ua))&& !strpos(strtolower($_SERVER['REQUEST_URI']),'wap'))
{
    $Loaction = 'mobile/';

    if (!empty($Loaction))
    {
        ecs_header("Location: $Loaction\n");

        exit;
    }

}
/*------------------------------------------------------ */
//-- Shopex系统地址转换
/*------------------------------------------------------ */
if (!empty($_GET['gOo']))
{
    if (!empty($_GET['gcat']))
    {
        /* 商品分类。*/
        $Loaction = 'category.php?id=' . $_GET['gcat'];
    }
    elseif (!empty($_GET['acat']))
    {
        /* 文章分类。*/
        $Loaction = 'article_cat.php?id=' . $_GET['acat'];
    }
    elseif (!empty($_GET['goodsid']))
    {
        /* 商品详情。*/
        $Loaction = 'goods.php?id=' . $_GET['goodsid'];
    }
    elseif (!empty($_GET['articleid']))
    {
        /* 文章详情。*/
        $Loaction = 'article.php?id=' . $_GET['articleid'];
    }

    if (!empty($Loaction))
    {
        ecs_header("Location: $Loaction\n");

        exit;
    }
}

//判断是否有ajax请求
$act = !empty($_GET['act']) ? $_GET['act'] : '';
if ($act == 'cat_rec')
{
    $rec_array = array(1 => 'best', 2 => 'new', 3 => 'hot');
    $rec_type = !empty($_REQUEST['rec_type']) ? intval($_REQUEST['rec_type']) : '1';
    $cat_id = !empty($_REQUEST['cid']) ? intval($_REQUEST['cid']) : '0';
    include_once('includes/cls_json.php');
    $json = new JSON;
    $result   = array('error' => 0, 'content' => '', 'type' => $rec_type, 'cat_id' => $cat_id);

    $children = get_children($cat_id);
    $smarty->assign($rec_array[$rec_type] . '_goods',      get_category_recommend_goods($rec_array[$rec_type], $children));    // 推荐商品
    $smarty->assign('cat_rec_sign', 1);
    $result['content'] = $smarty->fetch('library/recommend_' . $rec_array[$rec_type] . '.lbi');
    die($json->encode($result));
}

/*------------------------------------------------------ */
//-- 判断是否存在缓存，如果存在则调用缓存，反之读取相应内容
/*------------------------------------------------------ */
/* 缓存编号 */
$cache_id = sprintf('%X', crc32($_SESSION['user_rank'] . '-' . $_CFG['lang']));

if (!$smarty->is_cached('index.dwt', $cache_id))
{
    assign_template();

    $position = assign_ur_here();
    $smarty->assign('page_title',      $position['title']);    // 页面标题
    $smarty->assign('ur_here',         $position['ur_here']);  // 当前位置

    /* meta information */
    $smarty->assign('keywords',        htmlspecialchars($_CFG['shop_keywords']));
    $smarty->assign('description',     htmlspecialchars($_CFG['shop_desc']));
    $smarty->assign('flash_theme',     $_CFG['flash_theme']);  // Flash轮播图片模板
	
	if(empty($_SESSION['user_id']) && $_SESSION['user_id'] < 1)
	{
		$smarty->assign('login',      0);
	}
	else
	{
		$smarty->assign('user_id',      $_SESSION['user_id']);
		$smarty->assign('login',       1);
	}
	$uri = $ecs->url();
	$playerdb = get_flash_xml();
	foreach ($playerdb as $key => $val)
	{
		if (strpos($val['src'], 'http') === false)
		{
			$playerdb[$key]['src'] = $uri . $val['src'];
		}
	}
	
	$smarty->assign('playerdb',       $playerdb);           // 销售排行

    $smarty->assign('feed_url',        ($_CFG['rewrite'] == 1) ? 'feed.xml' : 'feed.php'); // RSS URL

    $smarty->assign('categories',      get_categories_tree()); // 分类树
    $smarty->assign('helps',           get_shop_help());       // 网店帮助
    $smarty->assign('top_goods',       get_top10());           // 销售排行

    $smarty->assign('best_goods',      get_recommend_goods('best'));    // 推荐商品
    $smarty->assign('new_goods',       get_recommend_goods('new'));     // 最新商品
    $smarty->assign('hot_goods',       get_recommend_goods('hot'));     // 热点文章
    $smarty->assign('promotion_goods', get_promote_goods(0,5,1)); // 特价商品
    $smarty->assign('brand_list',      get_brands());
    $smarty->assign('promotion_info',  get_promotion_info()); // 增加一个动态显示所有促销信息的标签栏

    $smarty->assign('invoice_list',    index_get_invoice_query());  // 发货查询
    $smarty->assign('new_articles',    index_get_new_articles());   // 最新文章
    $smarty->assign('group_buy_goods', index_get_group_buy());      // 团购商品
    $smarty->assign('auction_list',    index_get_auction());        // 拍卖活动
    $smarty->assign('shop_notice',     $_CFG['shop_notice']);       // 商店公告
	
	/*
	* 首页自定义
	*/
	$smarty->assign('today_t1',     $_CFG['today_t1']);       
	$smarty->assign('today_url1',     $_CFG['today_url1']);
	$smarty->assign('today_t2',     $_CFG['today_t2']);       
	$smarty->assign('today_url2',     $_CFG['today_url2']);
	$smarty->assign('today_t3',     $_CFG['today_t3']);       
	$smarty->assign('today_url3',     $_CFG['today_url3']);
	
	$smarty->assign('food_bigpic',     $_CFG['food_bigpic']); 
	$smarty->assign('food_bigpic_url',     $_CFG['food_bigpic_url']);
	$smarty->assign('food_keyword',     $_CFG['food_keyword']);
	$smarty->assign('food_pro_p1',     $_CFG['food_pro_p1']);       
	$smarty->assign('food_pro_u1',     $_CFG['food_pro_u1']);
	$smarty->assign('food_pro_p2',     $_CFG['food_pro_p2']);       
	$smarty->assign('food_pro_u2',     $_CFG['food_pro_u2']);
	$smarty->assign('food_pro_p3',     $_CFG['food_pro_p3']);       
	$smarty->assign('food_pro_u3',     $_CFG['food_pro_u3']);
	$smarty->assign('food_pro_p4',     $_CFG['food_pro_p4']);       
	$smarty->assign('food_pro_u4',     $_CFG['food_pro_u4']);
	$smarty->assign('food_pro_p5',     $_CFG['food_pro_p5']);       
	$smarty->assign('food_pro_u5',     $_CFG['food_pro_u5']); 
	$smarty->assign('food_pro_p6',     $_CFG['food_pro_p6']);       
	$smarty->assign('food_pro_u6',     $_CFG['food_pro_u6']);
	$smarty->assign('food_pro_p7',     $_CFG['food_pro_p7']);       
	$smarty->assign('food_pro_u7',     $_CFG['food_pro_u7']);
	$smarty->assign('food_pro_p8',     $_CFG['food_pro_p8']);       
	$smarty->assign('food_pro_u8',     $_CFG['food_pro_u8']);
	$smarty->assign('food_arc_p1',     $_CFG['food_arc_p1']);
	$smarty->assign('food_arc_u1',     $_CFG['food_arc_u1']);
	$smarty->assign('food_arc_t',     $_CFG['food_arc_t']);
	$smarty->assign('food_brand_p1',     $_CFG['food_brand_p1']);       
	$smarty->assign('food_brand_u1',     $_CFG['food_brand_u1']);
	$smarty->assign('food_brand_p2',     $_CFG['food_brand_p2']);       
	$smarty->assign('food_brand_u2',     $_CFG['food_brand_u2']);
	$smarty->assign('food_brand_p3',     $_CFG['food_brand_p3']);       
	$smarty->assign('food_brand_u3',     $_CFG['food_brand_u3']);
	$smarty->assign('food_brand_p4',     $_CFG['food_brand_p4']);       
	$smarty->assign('food_brand_u4',     $_CFG['food_brand_u4']);
	$smarty->assign('food_brand_p5',     $_CFG['food_brand_p5']);       
	$smarty->assign('food_brand_u5',     $_CFG['food_brand_u5']); 
	$smarty->assign('food_brand_p6',     $_CFG['food_brand_p6']);       
	$smarty->assign('food_brand_u6',     $_CFG['food_brand_u6']);
	$smarty->assign('food_brand_p7',     $_CFG['food_brand_p7']);       
	$smarty->assign('food_brand_u7',     $_CFG['food_brand_u7']);
	$smarty->assign('food_brand_p8',     $_CFG['food_brand_p8']);       
	$smarty->assign('food_brand_u8',     $_CFG['food_brand_u8']);
	
	$smarty->assign('live_bigpic',     $_CFG['live_bigpic']); 
	$smarty->assign('live_bigpic_url',     $_CFG['live_bigpic_url']);
	$smarty->assign('live_keyword',     $_CFG['live_keyword']);
	$smarty->assign('live_pro_p1',     $_CFG['live_pro_p1']);       
	$smarty->assign('live_pro_u1',     $_CFG['live_pro_u1']);
	$smarty->assign('live_pro_p2',     $_CFG['live_pro_p2']);       
	$smarty->assign('live_pro_u2',     $_CFG['live_pro_u2']);
	$smarty->assign('live_pro_p3',     $_CFG['live_pro_p3']);       
	$smarty->assign('live_pro_u3',     $_CFG['live_pro_u3']);
	$smarty->assign('live_pro_p4',     $_CFG['live_pro_p4']);       
	$smarty->assign('live_pro_u4',     $_CFG['live_pro_u4']);
	$smarty->assign('live_pro_p5',     $_CFG['live_pro_p5']);       
	$smarty->assign('live_pro_u5',     $_CFG['live_pro_u5']); 
	$smarty->assign('live_pro_p6',     $_CFG['live_pro_p6']);       
	$smarty->assign('live_pro_u6',     $_CFG['live_pro_u6']);
	$smarty->assign('live_pro_p7',     $_CFG['live_pro_p7']);       
	$smarty->assign('live_pro_u7',     $_CFG['live_pro_u7']);
	$smarty->assign('live_pro_p8',     $_CFG['live_pro_p8']);       
	$smarty->assign('live_pro_u8',     $_CFG['live_pro_u8']);
	$smarty->assign('live_arc_p1',     $_CFG['live_arc_p1']);
	$smarty->assign('live_arc_u1',     $_CFG['live_arc_u1']);
	$smarty->assign('live_arc_t',     $_CFG['live_arc_t']);
	$smarty->assign('live_brand_p1',     $_CFG['live_brand_p1']);       
	$smarty->assign('live_brand_u1',     $_CFG['live_brand_u1']);
	$smarty->assign('live_brand_p2',     $_CFG['live_brand_p2']);       
	$smarty->assign('live_brand_u2',     $_CFG['live_brand_u2']);
	$smarty->assign('live_brand_p3',     $_CFG['live_brand_p3']);       
	$smarty->assign('live_brand_u3',     $_CFG['live_brand_u3']);
	$smarty->assign('live_brand_p4',     $_CFG['live_brand_p4']);       
	$smarty->assign('live_brand_u4',     $_CFG['live_brand_u4']);
	$smarty->assign('live_brand_p5',     $_CFG['live_brand_p5']);       
	$smarty->assign('live_brand_u5',     $_CFG['live_brand_u5']); 
	$smarty->assign('live_brand_p6',     $_CFG['live_brand_p6']);       
	$smarty->assign('live_brand_u6',     $_CFG['live_brand_u6']);
	$smarty->assign('live_brand_p7',     $_CFG['live_brand_p7']);       
	$smarty->assign('live_brand_u7',     $_CFG['live_brand_u7']);
	$smarty->assign('live_brand_p8',     $_CFG['live_brand_p8']);       
	$smarty->assign('live_brand_u8',     $_CFG['live_brand_u8']);
	
	$smarty->assign('Entertainment_bigpic',     $_CFG['Entertainment_bigpic']); 
	$smarty->assign('Entertainment_bigpic_url',     $_CFG['Entertainment_bigpic_url']);
	$smarty->assign('ent_keyword',     $_CFG['ent_keyword']);
	$smarty->assign('ent_pro_p1',     $_CFG['ent_pro_p1']);       
	$smarty->assign('ent_pro_u1',     $_CFG['ent_pro_u1']);
	$smarty->assign('ent_pro_p2',     $_CFG['ent_pro_p2']);       
	$smarty->assign('ent_pro_u2',     $_CFG['ent_pro_u2']);
	$smarty->assign('ent_pro_p3',     $_CFG['ent_pro_p3']);       
	$smarty->assign('ent_pro_u3',     $_CFG['ent_pro_u3']);
	$smarty->assign('ent_pro_p4',     $_CFG['ent_pro_p4']);       
	$smarty->assign('ent_pro_u4',     $_CFG['ent_pro_u4']);
	$smarty->assign('ent_pro_p5',     $_CFG['ent_pro_p5']);       
	$smarty->assign('ent_pro_u5',     $_CFG['ent_pro_u5']); 
	$smarty->assign('ent_pro_p6',     $_CFG['ent_pro_p6']);       
	$smarty->assign('ent_pro_u6',     $_CFG['ent_pro_u6']);
	$smarty->assign('ent_pro_p7',     $_CFG['ent_pro_p7']);       
	$smarty->assign('ent_pro_u7',     $_CFG['ent_pro_u7']);
	$smarty->assign('ent_pro_p8',     $_CFG['ent_pro_p8']);       
	$smarty->assign('ent_pro_u8',     $_CFG['ent_pro_u8']);
	$smarty->assign('ent_arc_p1',     $_CFG['ent_arc_p1']);
	$smarty->assign('ent_arc_u1',     $_CFG['ent_arc_u1']);
	$smarty->assign('ent_arc_t',     $_CFG['ent_arc_t']);
	$smarty->assign('ent_brand_p1',     $_CFG['ent_brand_p1']);       
	$smarty->assign('ent_brand_u1',     $_CFG['ent_brand_u1']);
	$smarty->assign('ent_brand_p2',     $_CFG['ent_brand_p2']);       
	$smarty->assign('ent_brand_u2',     $_CFG['ent_brand_u2']);
	$smarty->assign('ent_brand_p3',     $_CFG['ent_brand_p3']);       
	$smarty->assign('ent_brand_u3',     $_CFG['ent_brand_u3']);
	$smarty->assign('ent_brand_p4',     $_CFG['ent_brand_p4']);       
	$smarty->assign('ent_brand_u4',     $_CFG['ent_brand_u4']);
	$smarty->assign('ent_brand_p5',     $_CFG['ent_brand_p5']);       
	$smarty->assign('ent_brand_u5',     $_CFG['ent_brand_u5']); 
	$smarty->assign('ent_brand_p6',     $_CFG['ent_brand_p6']);       
	$smarty->assign('ent_brand_u6',     $_CFG['ent_brand_u6']);
	$smarty->assign('ent_brand_p7',     $_CFG['ent_brand_p7']);       
	$smarty->assign('ent_brand_u7',     $_CFG['ent_brand_u7']);
	$smarty->assign('ent_brand_p8',     $_CFG['ent_brand_p8']);       
	$smarty->assign('ent_brand_u8',     $_CFG['ent_brand_u8']);
	
	$smarty->assign('clothes_bigpic',     $_CFG['clothes_bigpic']); 
	$smarty->assign('clothes_bigpic_url',     $_CFG['clothes_bigpic_url']);
	$smarty->assign('clo_keyword',     $_CFG['clo_keyword']);
	$smarty->assign('clo_pro_p1',     $_CFG['clo_pro_p1']);       
	$smarty->assign('clo_pro_u1',     $_CFG['clo_pro_u1']);
	$smarty->assign('clo_pro_p2',     $_CFG['clo_pro_p2']);       
	$smarty->assign('clo_pro_u2',     $_CFG['clo_pro_u2']);
	$smarty->assign('clo_pro_p3',     $_CFG['clo_pro_p3']);       
	$smarty->assign('clo_pro_u3',     $_CFG['clo_pro_u3']);
	$smarty->assign('clo_pro_p4',     $_CFG['clo_pro_p4']);       
	$smarty->assign('clo_pro_u4',     $_CFG['clo_pro_u4']);
	$smarty->assign('clo_pro_p5',     $_CFG['clo_pro_p5']);       
	$smarty->assign('clo_pro_u5',     $_CFG['clo_pro_u5']); 
	$smarty->assign('clo_pro_p6',     $_CFG['clo_pro_p6']);       
	$smarty->assign('clo_pro_u6',     $_CFG['clo_pro_u6']);
	$smarty->assign('clo_pro_p7',     $_CFG['clo_pro_p7']);       
	$smarty->assign('clo_pro_u7',     $_CFG['clo_pro_u7']);
	$smarty->assign('clo_pro_p8',     $_CFG['clo_pro_p8']);       
	$smarty->assign('clo_pro_u8',     $_CFG['clo_pro_u8']);
	$smarty->assign('clo_arc_p1',     $_CFG['clo_arc_p1']);
	$smarty->assign('clo_arc_u1',     $_CFG['clo_arc_u1']);
	$smarty->assign('clo_arc_t',     $_CFG['clo_arc_t']);
	$smarty->assign('clo_brand_p1',     $_CFG['clo_brand_p1']);       
	$smarty->assign('clo_brand_u1',     $_CFG['clo_brand_u1']);
	$smarty->assign('clo_brand_p2',     $_CFG['clo_brand_p2']);       
	$smarty->assign('clo_brand_u2',     $_CFG['clo_brand_u2']);
	$smarty->assign('clo_brand_p3',     $_CFG['clo_brand_p3']);       
	$smarty->assign('clo_brand_u3',     $_CFG['clo_brand_u3']);
	$smarty->assign('clo_brand_p4',     $_CFG['clo_brand_p4']);       
	$smarty->assign('clo_brand_u4',     $_CFG['clo_brand_u4']);
	$smarty->assign('clo_brand_p5',     $_CFG['clo_brand_p5']);       
	$smarty->assign('clo_brand_u5',     $_CFG['clo_brand_u5']); 
	$smarty->assign('clo_brand_p6',     $_CFG['clo_brand_p6']);       
	$smarty->assign('clo_brand_u6',     $_CFG['clo_brand_u6']);
	$smarty->assign('clo_brand_p7',     $_CFG['clo_brand_p7']);       
	$smarty->assign('clo_brand_u7',     $_CFG['clo_brand_u7']);
	$smarty->assign('clo_brand_p8',     $_CFG['clo_brand_p8']);       
	$smarty->assign('clo_brand_u8',     $_CFG['clo_brand_u8']);
	
	$smarty->assign('Picture_bigpic',     $_CFG['Picture_bigpic']); 
	$smarty->assign('Picture_bigpic_url',     $_CFG['Picture_bigpic_url']);
	$smarty->assign('pic_keyword',     $_CFG['pic_keyword']);
	$smarty->assign('pic_pro_p1',     $_CFG['pic_pro_p1']);       
	$smarty->assign('pic_pro_u1',     $_CFG['pic_pro_u1']);
	$smarty->assign('pic_pro_p2',     $_CFG['pic_pro_p2']);       
	$smarty->assign('pic_pro_u2',     $_CFG['pic_pro_u2']);
	$smarty->assign('pic_pro_p3',     $_CFG['pic_pro_p3']);       
	$smarty->assign('pic_pro_u3',     $_CFG['pic_pro_u3']);
	$smarty->assign('pic_pro_p4',     $_CFG['pic_pro_p4']);       
	$smarty->assign('pic_pro_u4',     $_CFG['pic_pro_u4']);
	$smarty->assign('pic_pro_p5',     $_CFG['pic_pro_p5']);       
	$smarty->assign('pic_pro_u5',     $_CFG['pic_pro_u5']); 
	$smarty->assign('pic_pro_p6',     $_CFG['pic_pro_p6']);       
	$smarty->assign('pic_pro_u6',     $_CFG['pic_pro_u6']);
	$smarty->assign('pic_pro_p7',     $_CFG['pic_pro_p7']);       
	$smarty->assign('pic_pro_u7',     $_CFG['pic_pro_u7']);
	$smarty->assign('pic_pro_p8',     $_CFG['pic_pro_p8']);       
	$smarty->assign('pic_pro_u8',     $_CFG['pic_pro_u8']);
	$smarty->assign('pic_arc_p1',     $_CFG['pic_arc_p1']);
	$smarty->assign('pic_arc_u1',     $_CFG['pic_arc_u1']);
	$smarty->assign('pic_arc_t',     $_CFG['pic_arc_t']);
	$smarty->assign('pic_brand_p1',     $_CFG['pic_brand_p1']);       
	$smarty->assign('pic_brand_u1',     $_CFG['pic_brand_u1']);
	$smarty->assign('pic_brand_p2',     $_CFG['pic_brand_p2']);       
	$smarty->assign('pic_brand_u2',     $_CFG['pic_brand_u2']);
	$smarty->assign('pic_brand_p3',     $_CFG['pic_brand_p3']);       
	$smarty->assign('pic_brand_u3',     $_CFG['pic_brand_u3']);
	$smarty->assign('pic_brand_p4',     $_CFG['pic_brand_p4']);       
	$smarty->assign('pic_brand_u4',     $_CFG['pic_brand_u4']);
	$smarty->assign('pic_brand_p5',     $_CFG['pic_brand_p5']);       
	$smarty->assign('pic_brand_u5',     $_CFG['pic_brand_u5']); 
	$smarty->assign('pic_brand_p6',     $_CFG['pic_brand_p6']);       
	$smarty->assign('pic_brand_u6',     $_CFG['pic_brand_u6']);
	$smarty->assign('pic_brand_p7',     $_CFG['pic_brand_p7']);       
	$smarty->assign('pic_brand_u7',     $_CFG['pic_brand_u7']);
	$smarty->assign('pic_brand_p8',     $_CFG['pic_brand_p8']);       
	$smarty->assign('pic_brand_u8',     $_CFG['pic_brand_u8']);
	
	$smarty->assign('Mom_bigpic',     $_CFG['Mom_bigpic']); 
	$smarty->assign('Mom_bigpic_url',     $_CFG['Mom_bigpic_url']);
	$smarty->assign('mom_keyword',     $_CFG['mom_keyword']);
	$smarty->assign('mom_pro_p1',     $_CFG['mom_pro_p1']);       
	$smarty->assign('mom_pro_u1',     $_CFG['mom_pro_u1']);
	$smarty->assign('mom_pro_p2',     $_CFG['mom_pro_p2']);       
	$smarty->assign('mom_pro_u2',     $_CFG['mom_pro_u2']);
	$smarty->assign('mom_pro_p3',     $_CFG['mom_pro_p3']);       
	$smarty->assign('mom_pro_u3',     $_CFG['mom_pro_u3']);
	$smarty->assign('mom_pro_p4',     $_CFG['mom_pro_p4']);       
	$smarty->assign('mom_pro_u4',     $_CFG['mom_pro_u4']);
	$smarty->assign('mom_pro_p5',     $_CFG['mom_pro_p5']);       
	$smarty->assign('mom_pro_u5',     $_CFG['mom_pro_u5']); 
	$smarty->assign('mom_pro_p6',     $_CFG['mom_pro_p6']);       
	$smarty->assign('mom_pro_u6',     $_CFG['mom_pro_u6']);
	$smarty->assign('mom_pro_p7',     $_CFG['mom_pro_p7']);       
	$smarty->assign('mom_pro_u7',     $_CFG['mom_pro_u7']);
	$smarty->assign('mom_pro_p8',     $_CFG['mom_pro_p8']);       
	$smarty->assign('mom_pro_u8',     $_CFG['mom_pro_u8']);
	$smarty->assign('mom_arc_p1',     $_CFG['mom_arc_p1']);
	$smarty->assign('mom_arc_u1',     $_CFG['mom_arc_u1']);
	$smarty->assign('mom_arc_t',     $_CFG['mom_arc_t']);
	$smarty->assign('mom_brand_p1',     $_CFG['mom_brand_p1']);       
	$smarty->assign('mom_brand_u1',     $_CFG['mom_brand_u1']);
	$smarty->assign('mom_brand_p2',     $_CFG['mom_brand_p2']);       
	$smarty->assign('mom_brand_u2',     $_CFG['mom_brand_u2']);
	$smarty->assign('mom_brand_p3',     $_CFG['mom_brand_p3']);       
	$smarty->assign('mom_brand_u3',     $_CFG['mom_brand_u3']);
	$smarty->assign('mom_brand_p4',     $_CFG['mom_brand_p4']);       
	$smarty->assign('mom_brand_u4',     $_CFG['mom_brand_u4']);
	$smarty->assign('mom_brand_p5',     $_CFG['mom_brand_p5']);       
	$smarty->assign('mom_brand_u5',     $_CFG['mom_brand_u5']); 
	$smarty->assign('mom_brand_p6',     $_CFG['mom_brand_p6']);       
	$smarty->assign('mom_brand_u6',     $_CFG['mom_brand_u6']);
	$smarty->assign('mom_brand_p7',     $_CFG['mom_brand_p7']);       
	$smarty->assign('mom_brand_u7',     $_CFG['mom_brand_u7']);
	$smarty->assign('mom_brand_p8',     $_CFG['mom_brand_p8']);       
	$smarty->assign('mom_brand_u8',     $_CFG['mom_brand_u8']);

    /* 首页主广告设置 */
    $smarty->assign('index_ad',     $_CFG['index_ad']);
    if ($_CFG['index_ad'] == 'cus')
    {
        $sql = 'SELECT ad_type, content, url FROM ' . $ecs->table("ad_custom") . ' WHERE ad_status = 1';
        $ad = $db->getRow($sql, true);
        $smarty->assign('ad', $ad);
    }

    /* links */
    $links = index_get_links();
    $smarty->assign('img_links',       $links['img']);
    $smarty->assign('txt_links',       $links['txt']);
    $smarty->assign('data_dir',        DATA_DIR);       // 数据目录

    /* 首页推荐分类 */
    $cat_recommend_res = $db->getAll("SELECT c.cat_id, c.cat_name, cr.recommend_type FROM " . $ecs->table("cat_recommend") . " AS cr INNER JOIN " . $ecs->table("category") . " AS c ON cr.cat_id=c.cat_id");
    if (!empty($cat_recommend_res))
    {
        $cat_rec_array = array();
        foreach($cat_recommend_res as $cat_recommend_data)
        {
            $cat_rec[$cat_recommend_data['recommend_type']][] = array('cat_id' => $cat_recommend_data['cat_id'], 'cat_name' => $cat_recommend_data['cat_name']);
        }
        $smarty->assign('cat_rec', $cat_rec);
    }

    /* 页面中的动态内容 */
    assign_dynamic('index');
}

$smarty->display('index.dwt', $cache_id);

/*------------------------------------------------------ */
//-- PRIVATE FUNCTIONS
/*------------------------------------------------------ */

/**
 * 调用发货单查询
 *
 * @access  private
 * @return  array
 */
function index_get_invoice_query()
{
    $sql = 'SELECT o.order_sn, o.invoice_no, s.shipping_code FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS o' .
            ' LEFT JOIN ' . $GLOBALS['ecs']->table('shipping') . ' AS s ON s.shipping_id = o.shipping_id' .
            " WHERE invoice_no > '' AND shipping_status = " . SS_SHIPPED .
            ' ORDER BY shipping_time DESC LIMIT 10';
    $all = $GLOBALS['db']->getAll($sql);

    foreach ($all AS $key => $row)
    {
        $plugin = ROOT_PATH . 'includes/modules/shipping/' . $row['shipping_code'] . '.php';

        if (file_exists($plugin))
        {
            include_once($plugin);

            $shipping = new $row['shipping_code'];
            $all[$key]['invoice_no'] = $shipping->query((string)$row['invoice_no']);
        }
    }

    clearstatcache();

    return $all;
}

/**
 * 获得最新的文章列表。
 *
 * @access  private
 * @return  array
 */
function index_get_new_articles()
{
    $sql = 'SELECT a.article_id, a.title, ac.cat_name, a.add_time, a.file_url, a.open_type, ac.cat_id, ac.cat_name ' .
            ' FROM ' . $GLOBALS['ecs']->table('article') . ' AS a, ' .
                $GLOBALS['ecs']->table('article_cat') . ' AS ac' .
            ' WHERE a.is_open = 1 AND a.cat_id = ac.cat_id AND ac.cat_type = 1' .
            ' ORDER BY a.article_type DESC, a.add_time DESC LIMIT ' . $GLOBALS['_CFG']['article_number'];
    $res = $GLOBALS['db']->getAll($sql);

    $arr = array();
    foreach ($res AS $idx => $row)
    {
        $arr[$idx]['id']          = $row['article_id'];
        $arr[$idx]['title']       = $row['title'];
        $arr[$idx]['short_title'] = $GLOBALS['_CFG']['article_title_length'] > 0 ?
                                        sub_str($row['title'], $GLOBALS['_CFG']['article_title_length']) : $row['title'];
        $arr[$idx]['cat_name']    = $row['cat_name'];
        $arr[$idx]['add_time']    = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']);
        $arr[$idx]['url']         = $row['open_type'] != 1 ?
                                        build_uri('article', array('aid' => $row['article_id']), $row['title']) : trim($row['file_url']);
        $arr[$idx]['cat_url']     = build_uri('article_cat', array('acid' => $row['cat_id']), $row['cat_name']);
    }

    return $arr;
}

/**
 * 获得最新的团购活动
 *
 * @access  private
 * @return  array
 */
function index_get_group_buy()
{
    $time = gmtime();
    $limit = get_library_number('group_buy', 'index');

    $group_buy_list = array();
    if ($limit > 0)
    {
        $sql = 'SELECT gb.act_id AS group_buy_id, gb.goods_id, gb.ext_info, gb.goods_name, g.goods_thumb, g.goods_img ' .
                'FROM ' . $GLOBALS['ecs']->table('goods_activity') . ' AS gb, ' .
                    $GLOBALS['ecs']->table('goods') . ' AS g ' .
                "WHERE gb.act_type = '" . GAT_GROUP_BUY . "' " .
                "AND g.goods_id = gb.goods_id " .
                "AND gb.start_time <= '" . $time . "' " .
                "AND gb.end_time >= '" . $time . "' " .
                "AND g.is_delete = 0 " .
                "ORDER BY gb.act_id DESC " .
                "LIMIT $limit" ;
        $res = $GLOBALS['db']->query($sql);

        while ($row = $GLOBALS['db']->fetchRow($res))
        {
            /* 如果缩略图为空，使用默认图片 */
            $row['goods_img'] = get_image_path($row['goods_id'], $row['goods_img']);
            $row['thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);

            /* 根据价格阶梯，计算最低价 */
            $ext_info = unserialize($row['ext_info']);
            $price_ladder = $ext_info['price_ladder'];
            if (!is_array($price_ladder) || empty($price_ladder))
            {
                $row['last_price'] = price_format(0);
            }
            else
            {
                foreach ($price_ladder AS $amount_price)
                {
                    $price_ladder[$amount_price['amount']] = $amount_price['price'];
                }
            }
            ksort($price_ladder);
            $row['last_price'] = price_format(end($price_ladder));
            $row['url'] = build_uri('group_buy', array('gbid' => $row['group_buy_id']));
            $row['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
                                           sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
            $row['short_style_name']   = add_style($row['short_name'],'');
            $group_buy_list[] = $row;
        }
    }

    return $group_buy_list;
}

/**
 * 取得拍卖活动列表
 * @return  array
 */
function index_get_auction()
{
    $now = gmtime();
    $limit = get_library_number('auction', 'index');
    $sql = "SELECT a.act_id, a.goods_id, a.goods_name, a.ext_info, g.goods_thumb ".
            "FROM " . $GLOBALS['ecs']->table('goods_activity') . " AS a," .
                      $GLOBALS['ecs']->table('goods') . " AS g" .
            " WHERE a.goods_id = g.goods_id" .
            " AND a.act_type = '" . GAT_AUCTION . "'" .
            " AND a.is_finished = 0" .
            " AND a.start_time <= '$now'" .
            " AND a.end_time >= '$now'" .
            " AND g.is_delete = 0" .
            " ORDER BY a.start_time DESC" .
            " LIMIT $limit";
    $res = $GLOBALS['db']->query($sql);

    $list = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $ext_info = unserialize($row['ext_info']);
        $arr = array_merge($row, $ext_info);
        $arr['formated_start_price'] = price_format($arr['start_price']);
        $arr['formated_end_price'] = price_format($arr['end_price']);
        $arr['thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr['url'] = build_uri('auction', array('auid' => $arr['act_id']));
        $arr['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
                                           sub_str($arr['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $arr['goods_name'];
        $arr['short_style_name']   = add_style($arr['short_name'],'');
        $list[] = $arr;
    }

    return $list;
}

/**
 * 获得所有的友情链接
 *
 * @access  private
 * @return  array
 */
function index_get_links()
{
    $sql = 'SELECT link_logo, link_name, link_url FROM ' . $GLOBALS['ecs']->table('friend_link') . ' ORDER BY show_order';
    $res = $GLOBALS['db']->getAll($sql);

    $links['img'] = $links['txt'] = array();

    foreach ($res AS $row)
    {
        if (!empty($row['link_logo']))
        {
            $links['img'][] = array('name' => $row['link_name'],
                                    'url'  => $row['link_url'],
                                    'logo' => $row['link_logo']);
        }
        else
        {
            $links['txt'][] = array('name' => $row['link_name'],
                                    'url'  => $row['link_url']);
        }
    }

    return $links;
}

/**
 * 获得所有的焦点图
 *
 * @access  private
 * @return  array
 */
function get_flash_xml()
{
	$flashdb = array();
	if (file_exists(ROOT_PATH . DATA_DIR . '/flash_data.xml'))
	{

		// 兼容v2.7.0及以前版本
		if (!preg_match_all('/item_url="([^"]+)"\slink="([^"]+)"\stext="([^"]*)"\ssort="([^"]*)"/', file_get_contents(ROOT_PATH . DATA_DIR . '/flash_data.xml'), $t, PREG_SET_ORDER))
		{
			preg_match_all('/item_url="([^"]+)"\slink="([^"]+)"\stext="([^"]*)"/', file_get_contents(ROOT_PATH . DATA_DIR . '/flash_data.xml'), $t, PREG_SET_ORDER);
		}

		if (!empty($t))
		{
			foreach ($t as $key => $val)
			{
				$val[4] = isset($val[4]) ? $val[4] : 0;
				$flashdb[] = array('src'=>$val[1],'url'=>$val[2],'text'=>$val[3],'sort'=>$val[4]);
			}
		}
	}
	return $flashdb;
}

?>