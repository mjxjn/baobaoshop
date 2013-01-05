<?php

/**
 * ECSHOP 管理中心优惠活动管理
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: favourable.php 17063 2010-03-25 06:35:46Z liuhui $
 */

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . 'includes/cls_image.php');
require(ROOT_PATH . 'includes/lib_goods.php');
$image = new cls_image($_CFG['bgcolor']);

$exc = new exchange($ecs->table('index'), $db, 'act_id', 'act_name');

/*------------------------------------------------------ */
//-- 添加、编辑
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'food')
{
    /* 检查权限 */
    admin_priv('favourable');
    $smarty->assign('form_action', 'update');
    $smarty->assign('set', 'food');
    $smarty->assign('ur_here', '设置孕婴食品');
    $smarty->assign('setindex', get_index('food'));
    $href = 'setindex.php?act=food';
    $smarty->assign('action_link', array('href' => $href, 'text' => '设置孕婴食品'));
    assign_query_info();
    $smarty->display('setindex.htm');
}
elseif ($_REQUEST['act'] == 'supplies')
{
	/* 检查权限 */
	admin_priv('favourable');
	$smarty->assign('form_action', 'update');
	$smarty->assign('set', 'supplies');
	$smarty->assign('ur_here', '设置孕婴食品');
	$smarty->assign('setindex', get_index('supplies'));
	$href = 'setindex.php?act=supplies';
	$smarty->assign('action_link', array('href' => $href, 'text' => '设置孕婴食品'));
	assign_query_info();
	$smarty->display('setindex.htm');
}
elseif ($_REQUEST['act'] == 'entertainment')
{
	/* 检查权限 */
	admin_priv('favourable');
	$smarty->assign('form_action', 'update');
	$smarty->assign('set', 'entertainment');
	$smarty->assign('ur_here', '设置孕婴食品');
	$smarty->assign('setindex', get_index('entertainment'));
	$href = 'setindex.php?act=entertainment';
	$smarty->assign('action_link', array('href' => $href, 'text' => '设置孕婴食品'));
	assign_query_info();
	$smarty->display('setindex.htm');
}
elseif ($_REQUEST['act'] == 'clothing')
{
	/* 检查权限 */
	admin_priv('favourable');
	$smarty->assign('form_action', 'update');
	$smarty->assign('set', 'clothing');
	$smarty->assign('ur_here', '设置孕婴食品');
	$smarty->assign('setindex', get_index('clothing'));
	$href = 'setindex.php?act=clothing';
	$smarty->assign('action_link', array('href' => $href, 'text' => '设置孕婴食品'));
	assign_query_info();
	$smarty->display('setindex.htm');
}
elseif($_REQUEST['act'] == 'learning')
{
	/* 检查权限 */
	admin_priv('favourable');
	$smarty->assign('form_action', 'update');
	$smarty->assign('set', 'learning');
	$smarty->assign('ur_here', '设置孕婴食品');
	$smarty->assign('setindex', get_index('learning'));
	$href = 'setindex.php?act=learning';
	$smarty->assign('action_link', array('href' => $href, 'text' => '设置孕婴食品'));
	assign_query_info();
	$smarty->display('setindex.htm');
}
elseif ($_REQUEST['act'] == 'mother')
{
	/* 检查权限 */
	admin_priv('favourable');
	$smarty->assign('form_action', 'update');
	$smarty->assign('set', 'mother');
	$smarty->assign('ur_here', '设置孕婴食品');
	$smarty->assign('setindex', get_index('mother'));
	$href = 'setindex.php?act=mother';
	$smarty->assign('action_link', array('href' => $href, 'text' => '设置孕婴食品'));
	assign_query_info();
	$smarty->display('setindex.htm');
}
elseif($_REQUEST['act'] == 'promotion'){
	/* 检查权限 */
	admin_priv('favourable');
	$smarty->assign('full_page',   1);
	$smarty->assign('form_action', 'update_ad');
	$smarty->assign('ur_here', '设置首页促销位管理');
	$href = 'setindex.php?act=promotion';
	$smarty->assign('action_link', array('href' => $href, 'text' => '首页促销位管理'));
	$smarty->assign('index_ad_list',get_index_ad());
	assign_query_info();
	$smarty->display('setindex_ad.htm');
}
/*------------------------------------------------------ */
//-- 修改排序
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_sort')
{
	check_authz_json('favourable');

	$id  = intval($_POST['id']);
	$val = intval($_POST['val']);

	$sql = "UPDATE " . $ecs->table('ad_index') .
	" SET ad_sort = '$val'" .
	" WHERE aid = '$id' LIMIT 1";
	$db->query($sql);

	make_json_result($val);
}
/*------------------------------------------------------ */
//-- 修改显示
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'toggle_status')
{
	check_authz_json('favourable');

	$id  = intval($_POST['id']);
	$val = intval($_POST['val']);

	$sql = "UPDATE " . $ecs->table('ad_index') .
	" SET ad_status = '$val'" .
	" WHERE aid = '$id' LIMIT 1";
	$db->query($sql);

	make_json_result($val);
}
elseif($_REQUEST['act']=='edit_ad'){
	/* 检查权限 */
    admin_priv('favourable');
	$smarty->assign('full_page',   1);
	$aid=$_REQUEST['id'];
	$ad = get_index_ad('','',$aid);
	$ads = $ad[0];
	$smarty->assign('ad',   $ads);
	$smarty->assign('form_action', 'update_ad');
	$smarty->assign('ur_here', '设置首页促销位管理');
	$href = 'setindex.php?act=promotion';
	$smarty->assign('action_link', array('href' => $href, 'text' => '首页促销位管理'));
	assign_query_info();
	$smarty->display('setindex_editad.htm');
}
elseif($_REQUEST['act']=='update_ad'){
	/* 检查权限 */
    admin_priv('favourable');
	/* 处理图片 */
	if (!empty($_FILES['pic1']["size"]))
	{
		$upload_img = $image->upload_image($_FILES['pic1'],"indexad", '');
		if ($upload_img == false)
		{
			sys_msg($image->error_msg);
		}
		$img_name = basename($upload_img);
	}
	else
	{
		$upload_img =  trim($_POST['content']);
		$img_name = '';
	}
	/* 提交值 */
	$adindex = array(
			'aid'        => intval($_POST['aid']),
			'ad_status'      => intval($_POST['ad_status']),
			'content'      => $upload_img,
			'url'  => trim($_POST['url']),
			'ad_sort'          =>  intval($_POST['ad_sort']),
	);

	$db->autoExecute($ecs->table('ad_index'), $adindex, 'UPDATE', "aid = '$adindex[aid]'");
	
	$links = array(
				array('href' => 'setindex.php?act=promotion', 'text' => '修改成功')
		);
	sys_msg('修改成功', 0, $links);
	
}
/*------------------------------------------------------ */
//-- 添加、编辑后提交
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'insert' || $_REQUEST['act'] == 'update')
{
    /* 检查权限 */
    admin_priv('favourable');

    /* 取得商品 */
    $gift = array();
    if (isset($_POST['gift_id']))
    {
    	if($_POST['set']=='food'){
	        foreach ($_POST['gift_id'] as $key => $id)
	        {
	           		$food[$_POST['gift_sort'][$key]] = array('id' => $id, 'name' => $_POST['gift_name'][$key], 'price' => $_POST['gift_price'][$key], 'sort'=>$_POST['gift_sort'][$key]);
	        }
    	}
    	if($_POST['set']=='supplies'){
	        foreach ($_POST['gift_id'] as $key => $id)
	        {
	           		$supplies[$_POST['gift_sort'][$key]] = array('id' => $id, 'name' => $_POST['gift_name'][$key], 'price' => $_POST['gift_price'][$key], 'sort'=>$_POST['gift_sort'][$key]);
	        }
    	}
    	if($_POST['set']=='entertainment'){
    		foreach ($_POST['gift_id'] as $key => $id)
    		{
    			$entertainment[$_POST['gift_sort'][$key]] = array('id' => $id, 'name' => $_POST['gift_name'][$key], 'price' => $_POST['gift_price'][$key], 'sort'=>$_POST['gift_sort'][$key]);
    		}
    	}
    	if($_POST['set']=='clothing'){
    		foreach ($_POST['gift_id'] as $key => $id)
    		{
    			$clothing[$_POST['gift_sort'][$key]] = array('id' => $id, 'name' => $_POST['gift_name'][$key], 'price' => $_POST['gift_price'][$key], 'sort'=>$_POST['gift_sort'][$key]);
    		}
    	}
    	if($_POST['set']=='learning'){
    		foreach ($_POST['gift_id'] as $key => $id)
    		{
    			$learning[$_POST['gift_sort'][$key]] = array('id' => $id, 'name' => $_POST['gift_name'][$key], 'price' => $_POST['gift_price'][$key], 'sort'=>$_POST['gift_sort'][$key]);
    		}
    	}
    	if($_POST['set']=='mother'){
    		foreach ($_POST['gift_id'] as $key => $id)
    		{
    			$mother[$_POST['gift_sort'][$key]] = array('id' => $id, 'name' => $_POST['gift_name'][$key], 'price' => $_POST['gift_price'][$key], 'sort'=>$_POST['gift_sort'][$key]);
    		}
    	}
    }

    /* 提交值 */
    if($_POST['set']=='food'){
	    $index = array(
	       		'food'          => serialize($food),
	    );
    }
    if($_POST['set']=='supplies'){
    	$index = array(
    			'supplies'          => serialize($supplies),
    	);
    }
    if($_POST['set']=='entertainment'){
    	$index = array(
    			'entertainment'          => serialize($entertainment),
    	);
    }
    if($_POST['set']=='clothing'){
    	$index = array(
    			'clothing'          => serialize($clothing),
    	);
    }
    if($_POST['set']=='learning'){
    	$index = array(
    			'learning'          => serialize($learning),
    	);
    }
    if($_POST['set']=='mother'){
    	$index = array(
    			'mother'          => serialize($mother),
    	);
    }

    /* 保存数据 */

    $db->autoExecute($ecs->table('index'), $index, 'UPDATE', "id =1");


   
     admin_log('首页设置', 'edit', 'setindex');


    /* 清除缓存 */
    clear_cache_files();

    if($_POST['set']=='food'){
        $links = array(
            array('href' => 'setindex.php?act=food', 'text' => '返回首页孕婴食品设置')
        );
        sys_msg('设置成功', 0, $links);
    }
    if($_POST['set']=='supplies'){
    	$links = array(
    			array('href' => 'setindex.php?act=supplies', 'text' => '返回首页宝宝用品设置')
    	);
    	sys_msg('设置成功', 0, $links);
    }
    if($_POST['set']=='entertainment'){
    	$links = array(
    			array('href' => 'setindex.php?act=entertainment', 'text' => '返回首页宝宝娱乐设置')
    	);
    	sys_msg('设置成功', 0, $links);
    }
    if($_POST['set']=='clothing'){
    	$links = array(
    			array('href' => 'setindex.php?act=clothing', 'text' => '返回首页宝宝服装设置')
    	);
    	sys_msg('设置成功', 0, $links);
    }
    if($_POST['set']=='learning'){
    	$links = array(
    			array('href' => 'setindex.php?act=learning', 'text' => '返回首页宝宝学习设置')
    	);
    	sys_msg('设置成功', 0, $links);
    }
    if($_POST['set']=='mother'){
    	$links = array(
    			array('href' => 'setindex.php?act=mother', 'text' => '返回首页孕妈专区设置')
    	);
    	sys_msg('设置成功', 0, $links);
    }
   
}

/*------------------------------------------------------ */
//-- 搜索商品
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'search')
{
    /* 检查权限 */
    check_authz_json('favourable');

    include_once(ROOT_PATH . 'includes/cls_json.php');

    $json   = new JSON;
    $filter = $json->decode($_GET['JSON']);
    $filter->keyword = json_str_iconv($filter->keyword);
    
        $sql = "SELECT goods_id AS id, goods_name AS name, shop_price AS price,promote_price,promote_start_date,promote_end_date FROM " . $ecs->table('goods') .
            " WHERE goods_name LIKE '%" . mysql_like_quote($filter->keyword) . "%'" .
            " OR goods_sn LIKE '%" . mysql_like_quote($filter->keyword) . "%' and goods_number>0 and is_on_sale=1 and is_alone_sale=1 and is_delete=0";
        $arr = $db->getAll($sql);

    if (empty($arr))
    {
        $arr = array(0 => array(
            'id'   => 0,
            'name' => $_LANG['search_result_empty'],
        	'price'=>0
        ));
    }else{
    	foreach ($arr as $key => $row){
	    	$nowtime = local_gettime();
	    	if($row['promote_start_date']<$nowtime&&$row['promote_end_date']>$nowtime){
	    		$arr[$key]['price']=$row['promote_price'];
	    	}else{
	    		$arr[$key]['price']=$row['price'];
	    	}
    	}
    }

    make_json_result($arr);
}

function get_index($type){
	$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('index') .
	" WHERE id = 1";
	$row = $GLOBALS['db']->getRow($sql);
	if (!empty($row))
	{
		if($type=='food'){
			$row['gift'] = unserialize($row['food']);
		}
		if($type=='supplies'){
			$row['gift'] = unserialize($row['supplies']);
		}
		if($type=='entertainment'){
			$row['gift'] = unserialize($row['entertainment']);
		}
		if($type=='clothing'){
			$row['gift'] = unserialize($row['clothing']);
		}
		if($type=='learning'){
			$row['gift'] = unserialize($row['learning']);
		}
		if($type=='mother'){
			$row['gift'] = unserialize($row['mother']);
		}
	}
	
	return $row;
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
	" WHERE 1 " .$where." order by aid";
	$row = $GLOBALS['db']->getAll($sql);
	foreach($row as $key => $val){
		$row[$key]['ad_type']=getadtype($val['ad_type']);
		$row[$key]['ad_cats']=getadcats($val['ad_cats']);
	}
	return $row;
}

function getadtype($type){
	$adtype=array(
			'1'=>"文字",
			'2'=>'图片'
	);
	if(!isset($type)){
		return '';
	}else{
		return $adtype[$type];
	}
}
function getadcats($cats){
	$adcats=array(
			'food'=>"孕婴食品",
			'supplies'=>'孕婴用品',
			'entertainment'=>'宝宝娱乐',
			'clothing'=>'宝宝服装',
			'learning'=>'宝宝学习',
			'mother'=>'孕妈专区',
			'index1'=>'首页广告',
			'index2'=>'首页logo广告',
			'index3'=>'首页背景广告'
	);
	if(!isset($cats)){
		return '';
	}else{
		return $adcats[$cats];
	}
}
?>