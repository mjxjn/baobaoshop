<?php

/**
 * ECSHOP 即时促销
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: promotion.php 17063 2010-03-25 06:35:46Z liuhui $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
include_once(ROOT_PATH . 'includes/lib_transaction.php');

/* 载入语言文件 */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/shopping_flow.php');
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');

/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

assign_template();
assign_dynamic('promootion');
$position = assign_ur_here(0, $_LANG['shopping_promootion']);
$smarty->assign('page_title',       $position['title']);    // 页面标题
$smarty->assign('ur_here',          $position['ur_here']);  // 当前位置

// 数据准备


// 开始工作
    $page = isset($_REQUEST['page']) && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
    $ajax = isset($_REQUEST['ajax']) && intval($_REQUEST['ajax'])  > 0 ? intval($_REQUEST['ajax'])  : 0;
    $ajaxpage = isset($_REQUEST['ajaxpage']) && intval($_REQUEST['ajaxpage'])  > 0 ? intval($_REQUEST['ajaxpage'])  : 0;
    $size = '24';
	$cat_id = empty($_REQUEST['cat_id']) ? 0 : $_REQUEST['cat_id'];
    $count = get_promote_goods_count($cat_id);
    $max_page = ($count> 0) ? ceil($count / $size) : 1;
    if ($page > $max_page)
    {
        $page = $max_page;
    }
	$promotion_goods = get_promote_goods($cat_id,$size,$page);
	
	if($ajax==1){
		include_once('includes/cls_json.php');
        $json = new JSON;
		$result = array('html' => '', 'cat_id' => '','page' => '', 'ajaxpage' => '');
		if($ajaxpage <= $max_page){		
			foreach($promotion_goods as $key => $val)
			{
				$html .= "<div class=\"goodinfo\">
					<div class=\"good_top\"><a href=\"".$val['url']."\">".$val['name']."</a></div>
					<div class=\"good_body\">
					<a href=\"".$val['url']."\"><img src=\"".$val['goods_img']."\" class=\"scrollLoading\" width=\"266\" height=\"266\" alt=\"".$val['name']."\" border='0'/></a>
					<div class=\"ty\">婴格特价商品不参与<a href=\"activity.php\" target=\"_blank\">满百赠品</a>,可获购物积分</div>
					<div class=\"buy\">
						<div class=\"price\">".$val['promote_price']."</div>
						<div class=\"buy_btn\"><a href=\"".$val['url']."\"><img src=\"/themes/yingge/images/buy_btn.gif\" border=\"0\"/></a></div>
					</div>
					<div class=\"blank9\"></div>
					</div>
					<div class=\"good_btm\"></div>
				</div>";
			}
			$ajaxpage=$page+1;
			$page=$page+1;
			$result['html']=$html;
			$result['cat_id']=$cat_id;
			$result['page']=$page;
			$result['ajaxpage']=$ajaxpage;
			echo $json->encode($result);
			exit;
		}else{
			
			$result['html']='';
			$result['cat_id']=$cat_id;
			$result['page']=$page;
			$result['ajaxpage']=$ajaxpage;
			echo $json->encode($result);
			exit;
			
		}
		
	}
$ajaxpage=$page+1;
$page=$page+1;
$smarty->assign('page',             $page);
$smarty->assign('ajaxpage',          $ajaxpage);
$smarty->assign('cat_id',             $cat_id);
$smarty->assign('list',             $promotion_goods);
$smarty->assign('categories',      get_categories_tree()); // 分类树
$smarty->assign('shop_notice',     $_CFG['shop_notice']);       // 商店公告
$smarty->assign('helps',            get_shop_help());       // 网店帮助
$smarty->assign('lang',             $_LANG);

$smarty->assign('feed_url',         ($_CFG['rewrite'] == 1) ? "feed-typeactivity.xml" : 'feed.php?type=activity'); // RSS URL
if($ajax!=1){
$smarty->display('promotion.dwt');
}
?>