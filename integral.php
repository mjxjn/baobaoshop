<?php
/**
 * ECSHOP 积分商城
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: exchange.php 17063 2010-03-25 06:35:46Z liuhui $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
	$smarty->caching = true;
}

/*------------------------------------------------------ */
//-- act 操作项的初始化
/*------------------------------------------------------ */
if (empty($_REQUEST['act']))
{
	$_REQUEST['act'] = 'index';
}
$smarty->assign("act",$_REQUEST['act']);
$user_id = $_SESSION['user_id'];
//获取指定日期所在星期的开始时间与结束时间
function getWeekRange(){
	$ret=array();
	$timestamp=gmtime();
	$year=local_date("Y",$timestamp);
	$month=local_date("m",$timestamp);
	$date=local_date("d",$timestamp);
	$w=local_date("w",$timestamp);
	$stimestamp = local_mktime(0,0,0,$month,$date,$year);
	$etimestamp = local_mktime(23,59,59,$month,$date,$year);
	$ret['w']=$w;
	$ret['sdate']=$stimestamp-($w-1)*86400;
	$ret['ssdate']=local_date("Y-m-d H:i:s",$ret['sdate']);
	$ret['edate']=$etimestamp+(7-$w)*86400;
	$ret['eedate']=local_date("Y-m-d H:i:s",$ret['edate']);
	return $ret;
}
$wdate = getWeekRange();

$weekaccount = accountweek_log($user_id,$wdate);

if(!empty($weekaccount)){
	foreach ($weekaccount as $key => $val){
		if($val['pay_points']>0){
			$weekcount += $val['pay_points'];
		}
		if($val['pay_points']<0){
			$fweekcount += $val['pay_points'];
		}
	}
	if(empty($weekcount)){
		$weekcount=0;
	}
	if(empty($fweekcount)){
		$fweekcount=0;
	}
}else{
	$weekcount=0;
	$fweekcount = 0;
}
$smarty->assign("weekcount",$weekcount);
$smarty->assign("fweekcount",$fweekcount);
//积分领取
$timestamp=gmtime();
$year=local_date("Y",$timestamp);
$month=local_date("m",$timestamp);
$date=local_date("d",$timestamp);
$account=account_log($user_id);
if(!empty($account)){
	
	$start_time=local_mktime(0,0,0,$month,$date,$year);
	$end_time=local_mktime(23,59,59,$month,$date,$year);
	if($account['change_time']>$start_time&&$account['change_time']<$end_time){
		$is_account=0;
	}else{
		$is_account=1;
	}
}else{
	$is_account=1;
}

$smarty->assign("day",$date);
$smarty->assign("month",$month);
$smarty->assign("is_account",$is_account);
$smarty->assign('promotion_goods',  get_promote_goods(0,5,1));    // 特价商品
/*------------------------------------------------------ */
//-- AJAX每天获得积分
/*------------------------------------------------------ */
if($_REQUEST['act'] == 'geteverydayexchange'){
	if(empty($user_id)){
		echo "-1";
	}else{
		if($is_account==1){
			
			$sql = "INSERT INTO " .$GLOBALS['ecs']->table('account_log'). " (user_id, user_money, frozen_money, rank_points, pay_points, change_time, change_desc,change_type)" .
			 "VALUES ('$_SESSION[user_id]', 0,0,0,2,".gmtime().",'每天签到获得2积分','123')";
	    	$db->query($sql);
	    	
	    	$userinfo=get_user_default($user_id);
	    	$user_integral = $userinfo['user_integral']+2;
	    	$sql = "UPDATE " .$GLOBALS['ecs']->table('users').
	    	" SET pay_points = '$user_integral' WHERE user_id='$user_id'";
	    	if($db->query($sql)){
	    		echo $user_integral;
	    	}else{
	    		echo "-2";
	    	}
		}else{
			echo "2";
		}
	}
}
/*------------------------------------------------------ */
//-- AJAX积分换优惠券
/*------------------------------------------------------ */
if($_REQUEST['act']=="getcoupon"){
	if(empty($user_id)){
		echo "-1";//未登录
	}else{
		$bonusid = $_REQUEST['bonus_id'];
		if(empty($bonusid)){
			echo "-2";//缺少参数
		}else{
			$info = getcoupon($bonusid);
			if(empty($info)){
				echo "-3";//无此优惠券
			}else{
				$userinfo = get_user_default($user_id);
				if($userinfo['user_integral']<$info){
					echo "-4";//积分不足
				}else{
					$bonusinfo = setcoupon($bonusid);
					if($bonusinfo){
						echo "1";//成功
					}else{
						echo "-5";//一天一次
					}
				}
			}
		}
	}
}
/*------------------------------------------------------ */
//-- 积分兑换商品首页
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'index')
{
	$cat = get_cat_info(0);   // 获得分类的相关信息
	
	if (!empty($cat))
	{
		$smarty->assign('keywords',    htmlspecialchars($cat['keywords']));
		$smarty->assign('description', htmlspecialchars($cat['cat_desc']));
	}
	assign_template();
	
	$position = assign_ur_here();
	$smarty->assign('page_title',       $position['title']);    // 页面标题
	$smarty->assign('ur_here',          $position['ur_here']);  // 当前位置
	
	if($user_id==0){
		$smarty->assign('is_login',0);
	}else{
		$smarty->assign('is_login',1);
		$smarty->assign('info',        get_user_default($user_id));
	}
	$smarty->assign('goods_type',       get_goods_type());        // 分类树
	$smarty->assign('helps',            get_shop_help());              // 网店帮助
	$smarty->assign('top_goods',        get_top10());                  // 销售排行
	$smarty->assign('promotion_info',   get_promotion_info());         // 促销活动信息
	
	$smarty->assign('categories',     get_categories_tree());        // 分类树
	
	$smarty->assign('shop_notice',     $_CFG['shop_notice']);       // 商店公告
	//实物
	$goodslist = exchange_get_goods("", "","", 8, 1, "goods_id", "desc");
	$smarty->assign('goods_list',       $goodslist);
	//优惠券
	$bonuslist = exchange_get_bonus("", "","", 8, 1, "type_id", "desc");
	$smarty->assign('bonus_list',       $bonuslist);
	
	$smarty->display('integral/integral_index.html');
}
/*------------------------------------------------------ */
//-- 积分兑换商品实物
/*------------------------------------------------------ */
if($_REQUEST['act'] == 'goods'){
	
	/* 初始化分页信息 */
	$page         = isset($_REQUEST['page'])   && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
	//$size         = isset($_CFG['page_size'])  && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 16;
	$size = 16;
	$integral_max = isset($_REQUEST['integral_max']) && intval($_REQUEST['integral_max']) > 0 ? intval($_REQUEST['integral_max']) : 0;
	$integral_min = isset($_REQUEST['integral_min']) && intval($_REQUEST['integral_min']) > 0 ? intval($_REQUEST['integral_min']) : 0;
	/* 排序、显示方式以及类型 */
	$default_display_type      = $_CFG['show_order_type'] == '0' ? 'list' : ($_CFG['show_order_type'] == '1' ? 'grid' : 'text');
	$default_sort_order_method = $_CFG['sort_order_method'] == '0' ? 'DESC' : 'ASC';
	$default_sort_order_type   = $_CFG['sort_order_type'] == '0' ? 'goods_id' : ($_CFG['sort_order_type'] == '1' ? 'exchange_integral' : 'shop_price');
	
	$sort    = (isset($_REQUEST['sort'])  && in_array(trim(strtolower($_REQUEST['sort'])), array('goods_id', 'exchange_integral', 'shop_price'))) ? trim($_REQUEST['sort'])  : $default_sort_order_type;
	$order   = (isset($_REQUEST['order']) && in_array(trim(strtoupper($_REQUEST['order'])), array('ASC', 'DESC'))) ? trim($_REQUEST['order']) : $default_sort_order_method;
	$display = (isset($_REQUEST['display']) && in_array(trim(strtolower($_REQUEST['display'])), array('list', 'grid', 'text'))) ? trim($_REQUEST['display'])  : (isset($_COOKIE['ECS']['display']) ? $_COOKIE['ECS']['display'] : $default_display_type);
	$display  = in_array($display, array('list', 'grid', 'text')) ? $display : 'text';
	$cat_id=0;
	$cat = get_cat_info($cat_id);   // 获得分类的相关信息
	if (!empty($cat))
	{
		$smarty->assign('keywords',    htmlspecialchars($cat['keywords']));
		$smarty->assign('description', htmlspecialchars($cat['cat_desc']));
	}
	assign_template();
	
	$position = assign_ur_here();
	$smarty->assign('page_title',       $position['title']);    // 页面标题
	$smarty->assign('ur_here',          $position['ur_here']);  // 当前位置
	
	if($user_id==0){
		$smarty->assign('is_login',0);
	}else{
		$smarty->assign('is_login',1);
		$smarty->assign('info',        get_user_default($user_id));
	}
	
	$smarty->assign('goods_type',       get_goods_type());        // 分类树
	$smarty->assign('helps',            get_shop_help());              // 网店帮助
	$smarty->assign('top_goods',        get_top10());                  // 销售排行
	$smarty->assign('promotion_info',   get_promotion_info());         // 促销活动信息
	
	$smarty->assign('categories',     get_categories_tree());        // 分类树
	
	$smarty->assign('shop_notice',     $_CFG['shop_notice']);       // 商店公告
	
	$count = get_exchange_goods_count($integral_min, $integral_max, "", $cat_id);
	$max_page = ($count> 0) ? ceil($count / $size) : 1;
	if ($page > $max_page)
	{
		$page = $max_page;
	}
	
	$goodslist = exchange_get_goods($integral_min, $integral_max,"", $size, $page, $sort, $order);
	$smarty->assign('goods_list',       $goodslist);
	
	assign_pager('integral_goods',            $cat_id, $count, $size, $sort, $order, $page, '', '', $integral_min, $integral_max, $display); // 分页
	//assign_dynamic('exchange_list'); // 动态内容
	if($order=="DESC"){
		$order="ASC";
	}else{
		$order="DESC";
	}
	$smarty->assign('sort',       $sort);
	$smarty->assign('order',       $order);
	$smarty->assign('integral_max',       $integral_max);
	$smarty->assign('integral_min',       $integral_min);
	
	$smarty->display('integral/integral_goods.html');
}
if($_REQUEST['act']=='coupon'){
	
	/* 初始化分页信息 */
	$page         = isset($_REQUEST['page'])   && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
	//$size         = isset($_CFG['page_size'])  && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;
	$size           =16;
	$integral_max = isset($_REQUEST['integral_max']) && intval($_REQUEST['integral_max']) > 0 ? intval($_REQUEST['integral_max']) : 0;
	$integral_min = isset($_REQUEST['integral_min']) && intval($_REQUEST['integral_min']) > 0 ? intval($_REQUEST['integral_min']) : 0;
	/* 排序、显示方式以及类型 */
	$default_display_type      = $_CFG['show_order_type'] == '0' ? 'list' : ($_CFG['show_order_type'] == '1' ? 'grid' : 'text');
	$default_sort_order_method = $_CFG['sort_order_method'] == '0' ? 'DESC' : 'ASC';
	$default_sort_order_type   = $_CFG['sort_order_type'] == '0' ? 'type_id' : ($_CFG['sort_order_type'] == '1' ? 'type_money' : 'pay_points');
	
	$sort    = (isset($_REQUEST['sort'])  && in_array(trim(strtolower($_REQUEST['sort'])), array('type_id', 'type_money', 'pay_points'))) ? trim($_REQUEST['sort'])  : $default_sort_order_type;
	$order   = (isset($_REQUEST['order']) && in_array(trim(strtoupper($_REQUEST['order'])), array('ASC', 'DESC'))) ? trim($_REQUEST['order']) : $default_sort_order_method;
	$display = (isset($_REQUEST['display']) && in_array(trim(strtolower($_REQUEST['display'])), array('list', 'grid', 'text'))) ? trim($_REQUEST['display'])  : (isset($_COOKIE['ECS']['display']) ? $_COOKIE['ECS']['display'] : $default_display_type);
	$display  = in_array($display, array('list', 'grid', 'text')) ? $display : 'text';
	$cat_id=0;
	$cat = get_cat_info($cat_id);   // 获得分类的相关信息
	if (!empty($cat))
	{
		$smarty->assign('keywords',    htmlspecialchars($cat['keywords']));
		$smarty->assign('description', htmlspecialchars($cat['cat_desc']));
	}
	assign_template();
	
	$position = assign_ur_here();
	$smarty->assign('page_title',       $position['title']);    // 页面标题
	$smarty->assign('ur_here',          $position['ur_here']);  // 当前位置
	
	if($user_id==0){
		$smarty->assign('is_login',0);
	}else{
		$smarty->assign('is_login',1);
		$smarty->assign('info',        get_user_default($user_id));
	}
	
	$smarty->assign('goods_type',       get_goods_type());        // 分类树
	$smarty->assign('helps',            get_shop_help());              // 网店帮助
	$smarty->assign('top_goods',        get_top10());                  // 销售排行
	$smarty->assign('promotion_info',   get_promotion_info());         // 促销活动信息
	
	$smarty->assign('categories',     get_categories_tree());        // 分类树
	
	$smarty->assign('shop_notice',     $_CFG['shop_notice']);       // 商店公告
	
	$count = get_exchange_coupon_count($integral_min, $integral_max, "");
	$max_page = ($count> 0) ? ceil($count / $size) : 1;
	if ($page > $max_page)
	{
		$page = $max_page;
	}
	
	$bonuslist = exchange_get_bonus($integral_min, $integral_max,"", $size, $page, $sort, $order);
	$smarty->assign('bonus_list',       $bonuslist);
	
	assign_pager('integral_bonus',            $cat_id, $count, $size, $sort, $order, $page, '', '', $integral_min, $integral_max, $display); // 分页
	
	if($order=="DESC"){
		$order="ASC";
	}else{
		$order="DESC";
	}
	$smarty->assign('sort',       $sort);
	$smarty->assign('order',       $order);
	$smarty->assign('integral_max',       $integral_max);
	$smarty->assign('integral_min',       $integral_min);
	
	$smarty->display('integral/integral_coupon.html');
}
/**
 * 获得分类的信息
 *
 * @param   integer $cat_id
 *
 * @return  void
 */
function get_goods_type(){
	$sql = 'SELECT cat_id, cat_name FROM ' . $GLOBALS['ecs']->table('goods_type') ." WHERE enabled=1";
	$res = $GLOBALS['db']->getAll($sql);

	$goods_type = array();
	foreach ($res AS $key => $val)
	{
		$goods_type[$key]['id'] = $val['cat_id'];
		$goods_type[$key]['name'] = $val['cat_name'];
	}

	return $goods_type;
}
/**
 * 获得分类的信息
 *
 * @param   integer $cat_id
 *
 * @return  void
 */
function get_cat_info($cat_id)
{
	return $GLOBALS['db']->getRow('SELECT keywords, cat_desc, style, grade, filter_attr, parent_id FROM ' . $GLOBALS['ecs']->table('category') .
			" WHERE cat_id = '$cat_id'");
}
/**
 * 获得签到积分信息
 * */
function account_log($userid){
	return $GLOBALS['db']->getRow('SELECT log_id,change_time FROM ' . $GLOBALS['ecs']->table('account_log') .
			" WHERE user_id = '$userid' and change_type=123 order by log_id desc limit 0,1");
}
/**
 * 获得一周全部积分信息
 * */
function accountweek_log($userid,$wdate){
	return $GLOBALS['db']->getAll('SELECT log_id,change_time,pay_points FROM ' . $GLOBALS['ecs']->table('account_log') .
			" WHERE user_id = '$userid' and change_time>".$wdate['sdate']." and change_time<".$wdate['edate']." order by log_id desc");
}
/**
 * 获取用户中心默认页面所需的数据
 *
 * @access  public
 * @param   int         $user_id            用户ID
 *
 * @return  array       $info               默认页面所需资料数组
 */
function get_user_default($user_id)
{
	$user_bonus = get_user_bonus();

	$sql = "SELECT pay_points, user_money, sex, credit_line, last_login,mobile_phone, is_validated FROM " .$GLOBALS['ecs']->table('users'). " WHERE user_id = '$user_id'";
	$row = $GLOBALS['db']->getRow($sql);
	$info = array();
	$info['username']  = stripslashes($_SESSION['user_name']);
	$info['shop_name'] = $GLOBALS['_CFG']['shop_name'];
	$info['integral']  = $row['pay_points'] . $GLOBALS['_CFG']['integral_name'];
	$info['user_integral']  = $row['pay_points'];
	/* 增加是否开启会员邮件验证开关 */
	$info['is_validate'] = ($GLOBALS['_CFG']['member_email_validate'] && !$row['is_validated'])?0:1;
	$info['credit_line'] = $row['credit_line'];
	$info['sex'] = $row['sex'];
	$info['mobile_phone'] = $row['mobile_phone'];
	$info['formated_credit_line'] = price_format($info['credit_line'], false);

	//如果$_SESSION中时间无效说明用户是第一次登录。取当前登录时间。
	$last_time = !isset($_SESSION['last_time']) ? $row['last_login'] : $_SESSION['last_time'];

	if ($last_time == 0)
	{
		$_SESSION['last_time'] = $last_time = gmtime();
	}

	$info['last_time'] = local_date($GLOBALS['_CFG']['time_format'], $last_time);
	$info['surplus']   = price_format($row['user_money'], false);
	$info['bonus']     = $user_bonus['bonus_count'];

	$sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('order_info').
	" WHERE user_id = '" .$user_id. "' AND add_time > '" .local_strtotime('-1 months'). "'";
	$info['order_count'] = $GLOBALS['db']->getOne($sql);

	include_once(ROOT_PATH . 'includes/lib_order.php');
	$sql = "SELECT order_id, order_sn ".
			" FROM " .$GLOBALS['ecs']->table('order_info').
			" WHERE user_id = '" .$user_id. "' AND shipping_time > '" .$last_time. "'". order_query_sql('shipped');
	$info['shipped_order'] = $GLOBALS['db']->getAll($sql);

	return $info;
}
/**
 * 获得分类下的商品
 *
 * @access  public
 * @param   string  $children
 * @return  array
 */
function exchange_get_goods($min, $max,$ext, $size, $page, $sort, $order)
{
	$display = $GLOBALS['display'];
	$where = "eg.is_exchange = 1 AND g.is_delete = 0 ";
	if ($min > 0)
	{
		$where .= " AND eg.exchange_integral >= $min ";
	}
	
	if ($max > 0)
	{
		$where .= " AND eg.exchange_integral <= $max ";
	}
	/* 获得商品列表 */
	$sql = 'SELECT g.goods_id, g.goods_name, g.goods_name_style, g.goods_number, eg.exchange_integral, ' .
			'g.goods_type, g.goods_brief, g.goods_thumb , g.goods_img, eg.is_hot,g.shop_price ' .
			'FROM ' . $GLOBALS['ecs']->table('exchange_goods') . ' AS eg, ' .$GLOBALS['ecs']->table('goods') . ' AS g ' .
			"WHERE eg.goods_id = g.goods_id AND $where $ext ORDER BY $sort $order";
	$res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);

	$arr = array();
	while ($row = $GLOBALS['db']->fetchRow($res))
	{
		/* 处理商品水印图片 */
		$watermark_img = '';

		if ($row['is_hot'] != 0)
		{
			$watermark_img = 'watermark_hot_small';
		}

		if ($watermark_img != '')
		{
			$arr[$row['goods_id']]['watermark_img'] =  $watermark_img;
		}

		$arr[$row['goods_id']]['goods_id']          = $row['goods_id'];
		if($display == 'grid')
		{
			$arr[$row['goods_id']]['goods_name']    = $GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
		}
		else
		{
			$arr[$row['goods_id']]['goods_name']    = $row['goods_name'];
		}
		$arr[$row['goods_id']]['name']              = $row['goods_name'];
		$arr[$row['goods_id']]['goods_brief']       = $row['goods_brief'];
		$arr[$row['goods_id']]['goods_style_name']  = add_style($row['goods_name'],$row['goods_name_style']);
		$arr[$row['goods_id']]['exchange_integral'] = $row['exchange_integral'];
		$arr[$row['goods_id']]['type']              = $row['goods_type'];
		$arr[$row['goods_id']]['goods_thumb']       = get_image_path($row['goods_id'], $row['goods_thumb'], true);
		$arr[$row['goods_id']]['goods_img']         = get_image_path($row['goods_id'], $row['goods_img']);
		$arr[$row['goods_id']]['url']               = build_uri('exchange_goods', array('gid'=>$row['goods_id']), $row['goods_name']);
		$arr[$row['goods_id']]['goods_number']=$row['goods_number'];
		$arr[$row['goods_id']]['shop_price']=$row['shop_price'];
	}

	return $arr;
}
/**
 * 获得积分兑换优惠券
 *
 * @access  public
 * @param   string 
 * @return  array
 */
function exchange_get_bonus($min, $max,$ext, $size, $page, $sort, $order){
	$timestamp=gmtime();
	/* $year=local_date("Y",$timestamp);
	$month=local_date("m",$timestamp);
	$date=local_date("d",$timestamp);
	$stimestamp = local_mktime(0,0,0,$month,$date,$year); */
	$stimestamp = $timestamp;
	$where = " send_type = 4 AND use_start_date < ".$stimestamp." AND use_end_date >".$stimestamp." AND pay_points>0 ";
	if ($min > 0)
	{
		$where .= " AND pay_points >= $min ";
	}
	
	if ($max > 0)
	{
		$where .= " AND pay_points <= $max ";
	}
	$sql = "select * from ". $GLOBALS['ecs']->table('bonus_type') ." where $where $ext ORDER BY $sort $order";
	$res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);
	$arr = array();
	while ($row = $GLOBALS['db']->fetchRow($res))
	{
		$arr[$row['type_id']]['type_id']          = $row['type_id'];
		$arr[$row['type_id']]['type_name']     = $row['type_name'];
		$arr[$row['type_id']]['type_money']   = price_format($row['type_money']);
		$arr[$row['type_id']]['use_start_date']   = local_date("Y-m-d",$row['use_start_date']);
		$arr[$row['type_id']]['use_end_date']    = local_date("Y-m-d",$row['use_end_date']);
		$arr[$row['type_id']]['pay_points']    =  $row['pay_points'];
		$arr[$row['type_id']]['img']    =  $row['img'];
		switch ($row['coupon_type']){
			case 1:
				$arr[$row['type_id']]['coupon_type']="婴格母婴商城-全场商品立减优惠券";
				break;
			case 2:
				$sql = "select brand_name from ". $GLOBALS['ecs']->table('brand') ." where brand_id in (".$row['coupon_ids'].")";
				$brand_names = $GLOBALS['db']->getAll($sql);
				foreach ($brand_names as $k => $val){
					$name .= "[".$val['brand_name']."],";
				}
				$name=substr($name,0,-1);
				$arr[$row['type_id']]['coupon_type']="婴格母婴商城-".$name."品牌下商品立减优惠券";
				break;
			case 3:
				$sql = "select goods_name from ". $GLOBALS['ecs']->table('goods') ." where goods_id in (".$row['coupon_ids'].")";
				$goods_names = $GLOBALS['db']->getAll($sql);
				foreach ($goods_names as $k => $val){
					$name .= "[".$val['goods_name']."],";
				}
				$name=substr($name,0,-1);
				$arr[$row['type_id']]['coupon_type']="婴格母婴商城-".$name."商品立减优惠券";
				break;
			case 4:
				$arr[$row['type_id']]['coupon_type']="婴格母婴商城-全场免运费优惠券";
				break;
		}
	}
	return $arr;
}
/**
 * 获得分类下的商品总数
 *
 * @access  public
 * @param   string     $cat_id
 * @return  integer
 */
function get_exchange_goods_count($min = 0, $max = 0, $ext='', $cat_id)
{
	$where  = " eg.is_exchange = 1 AND g.is_delete = 0 ";

	if($cat_id != 0)
	{
		$where .= " AND g.goods_type = ".$cat_id;
	}
	if ($min > 0)
	{
		$where .= " AND eg.exchange_integral >= $min ";
	}

	if ($max > 0)
	{
		$where .= " AND eg.exchange_integral <= $max ";
	}

	$sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('exchange_goods') . ' AS eg, ' .
			$GLOBALS['ecs']->table('goods') . " AS g WHERE eg.goods_id = g.goods_id AND $where $ext";
	/* 返回商品总数 */
	return $GLOBALS['db']->getOne($sql);
}
/**
 * 获得分类下的优惠券总数
 *
 * @access  public
 * @param   string     $cat_id
 * @return  integer
 */
function get_exchange_coupon_count($min = 0, $max = 0, $ext='')
{
	$timestamp=gmtime();
	$stimestamp = $timestamp;
	$where = " send_type = 4 AND use_start_date < ".$stimestamp." AND use_end_date >".$stimestamp." AND pay_points>0 ";
	
	if ($min > 0)
	{
		$where .= " AND pay_points >= $min ";
	}
	
	if ($max > 0)
	{
		$where .= " AND pay_points <= $max ";
	}
	
	$sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('bonus_type') . " WHERE $where $ext";
	/* 返回商品总数 */
	return $GLOBALS['db']->getOne($sql);
}
/**
 * 取得优惠券
 *
 * @access  public
 * @param   string     $cat_id
 * @return  integer
 */
function getcoupon($id){
	$time = gmtime();
	$where=" type_id=$id and send_type = 4 AND use_start_date < ".$time." AND use_end_date >".$time." AND pay_points>0 ";
	
	$sql = 'SELECT pay_points FROM ' . $GLOBALS['ecs']->table('bonus_type') . " WHERE $where ";
	/* 返回商品总数 */
	return $GLOBALS['db']->getOne($sql);
}
/**
 * 获得优惠券
 *
 * @access  public
 * @param   string     $cat_id
 * @return  integer
 */
function setcoupon($id){
	$timestamp=gmtime();
	$year=local_date("Y",$timestamp);
	 $month=local_date("m",$timestamp);
	$date=local_date("d",$timestamp);
	$startdate = local_mktime(0,0,0,$month,$date,$year);
	$enddate = local_mktime(23,59,59,$month,$date,$year);
	$where=" bonus_type_id=".$id." and user_id=".$_SESSION['user_id']." and cre_time>".$startdate." and cre_time<".$enddate ;
	$sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['ecs']->table('user_bonus'). " WHERE $where ";
	$count = $GLOBALS['db']->getOne($sql);
	if($count==0){
		$bonus_sn = gmtime().rand(1000,9999);
		$sql = 'SELECT pay_points FROM ' . $GLOBALS['ecs']->table('bonus_type') . " WHERE type_id=".$id;
		$bonus_type = $GLOBALS['db']->getOne($sql);
		
		$sql = "INSERT INTO " .$GLOBALS['ecs']->table('account_log'). " (user_id, user_money, frozen_money, rank_points, pay_points, change_time, change_desc,change_type)" .
				"VALUES ('$_SESSION[user_id]', 0,0,0,-".$bonus_type.",".gmtime().",'积分兑换优惠券','124')";
		$GLOBALS['db']->query($sql);
		$sql = "INSERT INTO " .$GLOBALS['ecs']->table('user_bonus'). " (bonus_type_id,bonus_sn,user_id,cre_time)".
				"VALUES (".$id.",".$bonus_sn.",'$_SESSION[user_id]',".gmtime().")";
		$GLOBALS['db']->query($sql);
		$sql = "UPDATE " . $GLOBALS['ecs']->table('users') . " SET pay_points = pay_points -". $bonus_type." WHERE user_id = ".$_SESSION[user_id];
		$GLOBALS['db']->query($sql);
		return true;
	}else{
		return false;
	}
}
?>