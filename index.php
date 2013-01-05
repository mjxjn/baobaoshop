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
$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|coolpad|k-touch|tcl|oppo|doov|amoi|bbk|cect|amoi|zte|huawei)/i";
$smartuachar = "/(iphone|ipad|android|smartphone|windows)/i";
//$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i";

//if(($ua == '' || preg_match($uachar, $ua))&& !strpos(strtolower($_SERVER['REQUEST_URI']),'wap'))
$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i";
$smartuachar = "/(iphone|ipad|android|smartphone|windows)/i";
if(!(preg_match($smartuachar, $ua)) && ($ua == '' || preg_match($uachar, $ua))&& !strpos(strtolower($_SERVER['REQUEST_URI']),'wap'))
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
		$smarty->assign('user',           get_user_info($_SESSION['user_id']));
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
    //$smarty->assign('top_goods',       get_top10());           // 销售排行

    $smarty->assign('best_goods',      get_recommend_goods('best'));    // 新品推荐
    $smarty->assign('new_goods',       get_recommend_goods('new'));     // 最新商品
    $smarty->assign('hot_goods',       get_recommend_goods('hot'));     // 畅销商品
    $smarty->assign('promotion_goods', get_promote_goods(0,4,1)); // 促销商品
    $smarty->assign('rand_goods',   get_rand_goods(4));//猜您喜欢
    $smarty->assign('brand_list',      get_brands());
    $smarty->assign('promotion_info',  get_promotion_info()); // 增加一个动态显示所有促销信息的标签栏

    //$smarty->assign('invoice_list',    index_get_invoice_query());  // 发货查询
    //$smarty->assign('new_articles',    index_get_new_articles());   // 最新文章
    //$smarty->assign('group_buy_goods', index_get_group_buy());      // 团购商品
    //$smarty->assign('auction_list',    index_get_auction());        // 拍卖活动
    $smarty->assign('shop_notice',     $_CFG['shop_notice']);       // 商店公告
	
	/*
	* 首页自定义
	*/
    $smarty->assign('affordable',       get_affordable_info());     // 购实惠
    $food=get_index('food');

    for($i=0;$i<8;$i++){
    	$food1['gift'][] = $food['gift'][$i];
    }
    for($i=8;$i<16;$i++){
    	$food2['gift'][] = $food['gift'][$i];
    }
    for($i=16;$i<24;$i++){
    	$food3['gift'][] = $food['gift'][$i];
    }
    $smarty->assign('food1',     $food1);//孕婴食品
    $smarty->assign('food2',     $food2);//孕婴食品
    $smarty->assign('food3',     $food3);//孕婴食品

    $smarty->assign('top_food',       get_top10('16','8',''));           // 销售排行
    
    
    $supplies=get_index('supplies');
    
    for($i=0;$i<8;$i++){
    	$supplies1['gift'][] = $supplies['gift'][$i];
    }
    for($i=8;$i<16;$i++){
    	$supplies2['gift'][] = $supplies['gift'][$i];
    }
    for($i=16;$i<24;$i++){
    	$supplies3['gift'][] = $supplies['gift'][$i];
    }
    $smarty->assign('supplies1',    $supplies1);//孕婴食品
    $smarty->assign('supplies2',    $supplies2);//孕婴食品
    $smarty->assign('supplies3',    $supplies3);//孕婴食品
    
    $smarty->assign('top_supplies',       get_top10('19','8',''));           // 销售排行
    
    
    $entertainment=get_index('entertainment');
    
    for($i=0;$i<8;$i++){
    	$entertainment1['gift'][] = $entertainment['gift'][$i];
    }
    for($i=8;$i<16;$i++){
    	$entertainment2['gift'][] = $entertainment['gift'][$i];
    }
    for($i=16;$i<24;$i++){
    	$entertainment3['gift'][] = $entertainment['gift'][$i];
    }
    $smarty->assign('entertainment1',    $entertainment1);//孕婴食品
    $smarty->assign('entertainment2',    $entertainment2);//孕婴食品
    $smarty->assign('entertainment3',    $entertainment3);//孕婴食品
    
    $smarty->assign('top_entertainment',       get_top10('23','8',''));           // 销售排行

    
    $clothing=get_index('clothing');
    
    for($i=0;$i<8;$i++){
    	$clothing1['gift'][] = $clothing['gift'][$i];
    }
    for($i=8;$i<16;$i++){
    	$clothing2['gift'][] = $clothing['gift'][$i];
    }
    for($i=16;$i<24;$i++){
    	$clothing3['gift'][] = $clothing['gift'][$i];
    }
    $smarty->assign('clothing1',    $clothing1);//孕婴食品
    $smarty->assign('clothing2',    $clothing2);//孕婴食品
    $smarty->assign('clothing3',    $clothing3);//孕婴食品
    
    $smarty->assign('top_clothing',       get_top10('24','8',''));           // 销售排行

    
    $learning=get_index('learning');
    
    for($i=0;$i<8;$i++){
    	$learning1['gift'][] = $learning['gift'][$i];
    }
    for($i=8;$i<16;$i++){
    	$learning2['gift'][] = $learning['gift'][$i];
    }
    for($i=16;$i<24;$i++){
    	$learning3['gift'][] = $learning['gift'][$i];
    }
    $smarty->assign('learning1',    $learning1);//孕婴食品
    $smarty->assign('learning2',    $learning2);//孕婴食品
    $smarty->assign('learning3',    $learning3);//孕婴食品
    
    $smarty->assign('top_learning',       get_top10('26','8',''));           // 销售排行

    
    $mother=get_index('mother');
    
    for($i=0;$i<8;$i++){
    	$mother1['gift'][] = $mother['gift'][$i];
    }
    for($i=8;$i<16;$i++){
    	$mother2['gift'][] = $mother['gift'][$i];
    }
    for($i=16;$i<24;$i++){
    	$mother3['gift'][] = $mother['gift'][$i];
    }
    $smarty->assign('mother1',    $mother1);//孕婴食品
    $smarty->assign('mother2',    $mother2);//孕婴食品
    $smarty->assign('mother3',    $mother3);//孕婴食品
    
    $smarty->assign('top_mother',       get_top10('27','8',''));           // 销售排行


    /* 首页主广告设置 */
    $smarty->assign('ad_food_t', get_index_ad('food','1'));
    $smarty->assign('ad_food_i', get_index_ad('food','2'));
    $smarty->assign('ad_supplies_t', get_index_ad('supplies','1'));
    $smarty->assign('ad_supplies_i', get_index_ad('supplies','2'));
    $smarty->assign('ad_entertainment_t', get_index_ad('entertainment','1'));
    $smarty->assign('ad_entertainment_i', get_index_ad('entertainment','2'));
    $smarty->assign('ad_clothing_t', get_index_ad('clothing','1'));
    $smarty->assign('ad_clothing_i', get_index_ad('clothing','2'));
    $smarty->assign('ad_learning_t', get_index_ad('learning','1'));
    $smarty->assign('ad_learning_i', get_index_ad('learning','2'));
    $smarty->assign('ad_mother_t', get_index_ad('mother','1'));
    $smarty->assign('ad_mother_i', get_index_ad('mother','2'));
    
    $smarty->assign('ad_index_i', get_index_ad('index1','2'));
    $smarty->assign('ad_logo_i', get_index_ad('index2','2'));
    $smarty->assign('ad_bg_i', get_index_ad('index3','2'));
    /*$smarty->assign('index_ad',     $_CFG['index_ad']);
    if ($_CFG['index_ad'] == 'cus')
    {
        $sql = 'SELECT ad_type, content, url FROM ' . $ecs->table("ad_custom") . ' WHERE ad_status = 1';
        $ad = $db->getRow($sql, true);
        $smarty->assign('ad', $ad);
    }*/

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

function get_affordable_info(){
	$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('affordable_index') . ' ORDER BY sort';
	$res = $GLOBALS['db']->getAll($sql);
	$list =array();
	foreach ($res AS $row)
	{
		$nowtime = gmtime();
		if($row['start_time']<$nowtime && $row['end_time']>$nowtime){
			$list['end_time']=date('D, d M Y H:i:s O', $row['end_time']);
			$list['url']=$row['url'];
			$list['pic']=$row['pic'];
			$list['aff_name']=$row['aff_name'];
		}
	}
	return $list;
}

function get_index($type){
	$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('index') .
	" WHERE id = 1";
	$row = $GLOBALS['db']->getRow($sql);
	if (!empty($row))
	{
		if($type=='food'){
			$row['gift'] = unserialize($row['food']);
			if(is_array($row['gift'])){
				$i=0;
			foreach ($row['gift'] as $key =>$val){
				
				$sql = "SELECT goods_thumb,goods_number,promote_price,promote_start_date,promote_end_date FROM " . $GLOBALS['ecs']->table('goods') ." WHERE goods_id = ".$val['id'];
				$arr = $GLOBALS['db']->getRow($sql);
				if($arr['goods_number']>0){
					if(empty($arr['goods_thumb'])){
						$row_i['gift'][$i]['goods_thumb']='/images/no_picture.gif';
					}else{
						$row_i['gift'][$i]['goods_thumb']=$arr['goods_thumb'];
					}
					$row_i['gift'][$i]['short_name']=sub_str($row['gift'][$key]['name'],20);	
					if ($arr['promote_price'] > 0)
					{
						$promote_price = bargain_price($arr['promote_price'], $arr['promote_start_date'], $arr['promote_end_date']);
					}
					else
					{
						$promote_price = 0;
					}
					$row_i['gift'][$i]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
					$row_i['gift'][$i]['id']=$val['id'];
					$row_i['gift'][$i]['name']=$row['gift'][$key]['name'];
					$row_i['gift'][$i]['price']=$row['gift'][$key]['price'];
					$i++;
				}
				
			}	
			}
		}
		if($type=='supplies'){
			$row['gift'] = unserialize($row['supplies']);
			if(is_array($row['gift'])){
				$i=0;
			foreach ($row['gift'] as $key =>$val){
					
				$sql = "SELECT goods_thumb,goods_number,promote_price,promote_start_date,promote_end_date FROM " . $GLOBALS['ecs']->table('goods') ." WHERE goods_id = ".$val['id'];
				$arr = $GLOBALS['db']->getRow($sql);
				if($arr['goods_number']>0){
					if(empty($arr['goods_thumb'])){
						$row_i['gift'][$i]['goods_thumb']='/images/no_picture.gif';
					}else{
						$row_i['gift'][$i]['goods_thumb']=$arr['goods_thumb'];
					}
					$row_i['gift'][$i]['short_name']=sub_str($row['gift'][$key]['name'],20);
					if ($arr['promote_price'] > 0)
					{
						$promote_price = bargain_price($arr['promote_price'], $arr['promote_start_date'], $arr['promote_end_date']);
					}
					else
					{
						$promote_price = 0;
					}
					$row_i['gift'][$i]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
					$row_i['gift'][$i]['id']=$val['id'];
					$row_i['gift'][$i]['name']=$row['gift'][$key]['name'];
					$row_i['gift'][$i]['price']=$row['gift'][$key]['price'];
					$i++;
				}
				
			}
			}
		}
		if($type=='entertainment'){
			$row['gift'] = unserialize($row['entertainment']);
			if(is_array($row['gift'])){
				$i=0;
			foreach ($row['gift'] as $key =>$val){
				
					$sql = "SELECT goods_thumb,goods_number,promote_price,promote_start_date,promote_end_date FROM " . $GLOBALS['ecs']->table('goods') ." WHERE goods_id = ".$val['id'];
					$arr = $GLOBALS['db']->getRow($sql);
					if($arr['goods_number']>0){
						if(empty($arr['goods_thumb'])){
							$row_i['gift'][$i]['goods_thumb']='/images/no_picture.gif';
						}else{
							$row_i['gift'][$i]['goods_thumb']=$arr['goods_thumb'];
						}
						$row_i['gift'][$i]['short_name']=sub_str($row['gift'][$key]['name'],20);
						if ($arr['promote_price'] > 0)
						{
							$promote_price = bargain_price($arr['promote_price'], $arr['promote_start_date'], $arr['promote_end_date']);
						}
						else
						{
							$promote_price = 0;
						}
						$row_i['gift'][$i]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
						$row_i['gift'][$i]['id']=$val['id'];
						$row_i['gift'][$i]['name']=$row['gift'][$key]['name'];
						$row_i['gift'][$i]['price']=$row['gift'][$key]['price'];
						$i++;
					}
			}
			}
		}
		if($type=='clothing'){
			$row['gift'] = unserialize($row['clothing']);
			if(is_array($row['gift'])){
				$i=0;
			foreach ($row['gift'] as $key =>$val){
				
					$sql = "SELECT goods_thumb,goods_number,promote_price,promote_start_date,promote_end_date FROM " . $GLOBALS['ecs']->table('goods') ." WHERE goods_id = ".$val['id'];
					$arr = $GLOBALS['db']->getRow($sql);
					if($arr['goods_number']>0){
						if(empty($arr['goods_thumb'])){
							$row_i['gift'][$i]['goods_thumb']='/images/no_picture.gif';
						}else{
							$row_i['gift'][$i]['goods_thumb']=$arr['goods_thumb'];
						}
						$row_i['gift'][$i]['short_name']=sub_str($row['gift'][$key]['name'],20);
						if ($arr['promote_price'] > 0)
						{
							$promote_price = bargain_price($arr['promote_price'], $arr['promote_start_date'], $arr['promote_end_date']);
						}
						else
						{
							$promote_price = 0;
						}
						$row_i['gift'][$i]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
						$row_i['gift'][$i]['id']=$val['id'];
						$row_i['gift'][$i]['name']=$row['gift'][$key]['name'];
						$row_i['gift'][$i]['price']=$row['gift'][$key]['price'];
						$i++;
					}
			}
			}
		}
		if($type=='learning'){
			$row['gift'] = unserialize($row['learning']);
			if(is_array($row['gift'])){
				$i=0;
			foreach ($row['gift'] as $key =>$val){
				
					$sql = "SELECT goods_thumb,goods_number,promote_price,promote_start_date,promote_end_date FROM " . $GLOBALS['ecs']->table('goods') ." WHERE goods_id = ".$val['id'];
					$arr = $GLOBALS['db']->getRow($sql);
					if($arr['goods_number']>0){
						if(empty($arr['goods_thumb'])){
							$row_i['gift'][$i]['goods_thumb']='/images/no_picture.gif';
						}else{
							$row_i['gift'][$i]['goods_thumb']=$arr['goods_thumb'];
						}
						$row_i['gift'][$i]['short_name']=sub_str($row['gift'][$key]['name'],20);
						if ($arr['promote_price'] > 0)
						{
							$promote_price = bargain_price($arr['promote_price'], $arr['promote_start_date'], $arr['promote_end_date']);
						}
						else
						{
							$promote_price = 0;
						}
						$row_i['gift'][$i]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
						$row_i['gift'][$i]['id']=$val['id'];
						$row_i['gift'][$i]['name']=$row['gift'][$key]['name'];
						$row_i['gift'][$i]['price']=$row['gift'][$key]['price'];
						$i++;
					}
			}
			}
		}
		if($type=='mother'){
			$row['gift'] = unserialize($row['mother']);
			if(is_array($row['gift'])){
				$i=0;
			foreach ($row['gift'] as $key =>$val){
				
					$sql = "SELECT goods_thumb,goods_number,promote_price,promote_start_date,promote_end_date FROM " . $GLOBALS['ecs']->table('goods') ." WHERE goods_id = ".$val['id'];
					$arr = $GLOBALS['db']->getRow($sql);
					if($arr['goods_number']>0){
						if(empty($arr['goods_thumb'])){
							$row_i['gift'][$i]['goods_thumb']='/images/no_picture.gif';
						}else{
							$row_i['gift'][$i]['goods_thumb']=$arr['goods_thumb'];
						}
						$row_i['gift'][$i]['short_name']=sub_str($row['gift'][$key]['name'],20);
						if ($arr['promote_price'] > 0)
						{
							$promote_price = bargain_price($arr['promote_price'], $arr['promote_start_date'], $arr['promote_end_date']);
						}
						else
						{
							$promote_price = 0;
						}
						$row_i['gift'][$i]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
						$row_i['gift'][$i]['id']=$val['id'];
						$row_i['gift'][$i]['name']=$row['gift'][$key]['name'];
						$row_i['gift'][$i]['price']=$row['gift'][$key]['price'];
						$i++;
					}
			}
			}
		}
	}

	return $row_i;
}

function get_index_ad($ad_cats='',$ad_type='',$aid=''){
	$where = " and 1";
	if(!empty($ad_cats)){
		$where .= " and ad_cats = '".$ad_cats."' ";
	}
	if(!empty($ad_type)){
		$where .= " and ad_type = ".$ad_type." ";
	}
	if(!empty($aid)){
		$where .= " and aid = ".$aid." ";
	}
	$sql="select * from ".$GLOBALS['ecs']->table('ad_index') .
	" WHERE ad_status = 1 " .$where." order by aid";
	$row = $GLOBALS['db']->getAll($sql);

	return $row;
}
?>