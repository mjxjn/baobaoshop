<?php
/**
 * ECSHOP 首页设置购实惠
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

$exc = new exchange($ecs->table('affordable_index'), $db, 'aff_id', 'aff_name');

/*------------------------------------------------------ */
//-- 活动列表页
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
	admin_priv('favourable');

	/* 模板赋值 */
	$smarty->assign('full_page',   1);
	$smarty->assign('ur_here',     $_LANG['affordable_list']);
	$smarty->assign('action_link', array('href' => 'affordable.php?act=add', 'text' => $_LANG['add_favourable']));

	$list = affordable_list();

	$smarty->assign('affordable_list', $list['item']);
	$smarty->assign('filter',          $list['filter']);
	$smarty->assign('record_count',    $list['record_count']);
	$smarty->assign('page_count',      $list['page_count']);

	$sort_flag  = sort_flag($list['filter']);
	$smarty->assign($sort_flag['tag'], $sort_flag['img']);

	/* 显示商品列表页面 */
	assign_query_info();
	$smarty->display('affordable_list.htm');
}

elseif ($_REQUEST['act'] == 'query')
{
	$list = affordable_list();

	$smarty->assign('affordable_list', $list['item']);
	$smarty->assign('filter',          $list['filter']);
	$smarty->assign('record_count',    $list['record_count']);
	$smarty->assign('page_count',      $list['page_count']);

	$sort_flag  = sort_flag($list['filter']);
	$smarty->assign($sort_flag['tag'], $sort_flag['img']);

	make_json_result($smarty->fetch('affordable_list.htm'), '',
	array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}

/*------------------------------------------------------ */
//-- 删除
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
	check_authz_json('favourable');

	$id = intval($_GET['id']);
	$favourable = affordable_info($id);
	if (empty($favourable))
	{
		make_json_error($_LANG['affordable_not_exist']);
	}
	$name = $favourable['aff_name'];
	$exc->drop($id);

	/* 记日志 */
	admin_log($name, 'remove', 'affordable');

	/* 清除缓存 */
	clear_cache_files();

	$url = 'affordable.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

	ecs_header("Location: $url\n");
	exit;
}

/*------------------------------------------------------ */
//-- 批量操作
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'batch')
{
	/* 取得要操作的记录编号 */
	if (empty($_POST['checkboxes']))
	{
		sys_msg($_LANG['no_record_selected']);
	}
	else
	{
		/* 检查权限 */
		admin_priv('favourable');

		$ids = $_POST['checkboxes'];

		if (isset($_POST['drop']))
		{
			/* 删除记录 */
			$sql = "DELETE FROM " . $ecs->table('affordable_index') .
			" WHERE aff_id " . db_create_in($ids);
			$db->query($sql);

			/* 记日志 */
			admin_log('', 'batch_remove', 'affordable');

			/* 清除缓存 */
			clear_cache_files();

			$links[] = array('text' => $_LANG['back_affordable_list'], 'href' => 'affordable.php?act=list&' . list_link_postfix());
			sys_msg($_LANG['batch_drop_ok']);
		}
	}
}

/*------------------------------------------------------ */
//-- 修改排序
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_sort')
{
	check_authz_json('favourable');

	$id  = intval($_POST['id']);
	$val = intval($_POST['val']);

	$sql = "UPDATE " . $ecs->table('affordable_index') .
	" SET sort = '$val'" .
	" WHERE aff_id = '$id' LIMIT 1";
	$db->query($sql);

	make_json_result($val);
}

/*------------------------------------------------------ */
//-- 添加、编辑
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'add' || $_REQUEST['act'] == 'edit')
{
	/* 检查权限 */
	admin_priv('favourable');

	/* 是否添加 */
	$is_add = $_REQUEST['act'] == 'add';
	$smarty->assign('form_action', $is_add ? 'insert' : 'update');
	
	/* 初始化、取得优惠活动信息 */
	if ($is_add)
	{
		$favourable = array(
				'aff_id'        => 0,
				'aff_name'      => '',
				'start_time'    => date('Y-m-d', time() + 86400),
				'end_time'      => date('Y-m-d', time() + 4 * 86400),
				'goods_id'  => '',
				'sort'          => 0,
				'pic'           => '',
				'url'            => ''
		);
	}
	else
	{
		if (empty($_GET['id']))
		{
			sys_msg('invalid param');
		}
		$id = intval($_GET['id']);
		$affordable = affordable_info($id);
		if (empty($affordable))
		{
			sys_msg($_LANG['favourable_not_exist']);
		}
	}
	$smarty->assign('favourable', $affordable);
	
	/* 赋值时间控件的语言 */
	$smarty->assign('cfg_lang', $_CFG['lang']);
	
	/* 显示模板 */
	if ($is_add)
	{
		$smarty->assign('ur_here', $_LANG['add_favourable']);
	}
	else
	{
		$smarty->assign('ur_here', $_LANG['edit_favourable']);
	}
	$href = 'affordable.php?act=list';
	if (!$is_add)
	{
		$href .= '&' . list_link_postfix();
	}
	$smarty->assign('action_link', array('href' => $href, 'text' => $_LANG['favourable_list']));
	assign_query_info();
	$smarty->display('affordable_info.htm');
}

/*------------------------------------------------------ */
//-- 添加、编辑后提交
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'insert' || $_REQUEST['act'] == 'update')
{
	/* 检查权限 */
	admin_priv('favourable');

	/* 是否添加 */
	$is_add = $_REQUEST['act'] == 'insert';

	/* 检查名称是否重复 */
	$act_name = sub_str($_POST['aff_name'], 255, false);
	if (!$exc->is_only('aff_name', $act_name, intval($_POST['id'])))
	{
		sys_msg($_LANG['act_name_exists']);
	}
	
	/* 处理图片 */
	if (!empty($_FILES['pic1']["size"]))
	{
		$upload_img = $image->upload_image($_FILES['pic1'],"affordable", '');
		if ($upload_img == false)
		{
			sys_msg($image->error_msg);
		}
		$img_name = basename($upload_img);
	}
	else
	{
		$upload_img =  trim($_POST['pic']);
		$img_name = '';
	}

	/* 提交值 */
	$affordable = array(
			'aff_id'        => intval($_POST['id']),
			'aff_name'      => $act_name,
			'start_time'    => local_strtotime($_POST['start_time']),
			'end_time'      => local_strtotime($_POST['end_time']),
			'pic'      => $upload_img,
			'url'  => trim($_POST['url']),
			'sort'          =>  intval($_POST['sort']),
	);

	/* 保存数据 */
	if ($is_add)
	{
		$db->autoExecute($ecs->table('affordable_index'), $affordable, 'INSERT');
		$affordable['aff_id'] = $db->insert_id();
	}
	else
	{
		$db->autoExecute($ecs->table('affordable_index'), $affordable, 'UPDATE', "aff_id = '$affordable[aff_id]'");
	}

	/* 记日志 */
	if ($is_add)
	{
		admin_log($affordable['aff_name'], 'add', 'affordable');
	}
	else
	{
		admin_log($affordable['aff_name'], 'edit', 'affordable');
	}

	/* 清除缓存 */
	clear_cache_files();

	/* 提示信息 */
	if ($is_add)
	{
		$links = array(
				array('href' => 'affordable.php?act=add', 'text' => $_LANG['continue_add_favourable']),
				array('href' => 'affordable.php?act=list', 'text' => $_LANG['back_favourable_list'])
		);
		sys_msg($_LANG['add_favourable_ok'], 0, $links);
	}
	else
	{
		$links = array(
				array('href' => 'affordable.php?act=list&' . list_link_postfix(), 'text' => $_LANG['back_favourable_list'])
		);
		sys_msg($_LANG['edit_favourable_ok'], 0, $links);
	}
}

/*
 * 取得优惠活动列表
* @return   array
*/
function affordable_list()
{
	$result = get_filter();
	if ($result === false)
	{
		/* 过滤条件 */
		$filter['keyword']    = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
		if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
		{
			$filter['keyword'] = json_str_iconv($filter['keyword']);
		}
		$filter['is_going']   = empty($_REQUEST['is_going']) ? 0 : 1;
		$filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'aff_id' : trim($_REQUEST['sort_by']);
		$filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

		$where = "";
		if (!empty($filter['keyword']))
		{
			$where .= " AND aff_name LIKE '%" . mysql_like_quote($filter['keyword']) . "%'";
		}
		if ($filter['is_going'])
		{
			$now = gmtime();
			$where .= " AND start_time <= '$now' AND end_time >= '$now' ";
		}

		$sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('affordable_index') .
		" WHERE 1 $where";
		$filter['record_count'] = $GLOBALS['db']->getOne($sql);

		/* 分页大小 */
		$filter = page_and_size($filter);

		/* 查询 */
		$sql = "SELECT * ".
				"FROM " . $GLOBALS['ecs']->table('affordable_index') .
				" WHERE 1 $where ".
				" ORDER BY $filter[sort_by] $filter[sort_order] ".
				" LIMIT ". $filter['start'] .", $filter[page_size]";

		$filter['keyword'] = stripslashes($filter['keyword']);
		set_filter($filter, $sql);
	}
	else
	{
		$sql    = $result['sql'];
		$filter = $result['filter'];
	}
	$res = $GLOBALS['db']->query($sql);

	$list = array();
	while ($row = $GLOBALS['db']->fetchRow($res))
	{
		$row['start_time']  = local_date('Y-m-d H:i', $row['start_time']);
		$row['end_time']    = local_date('Y-m-d H:i', $row['end_time']);

		$list[] = $row;
	}

	return array('item' => $list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

function affordable_info($id){
	$sql = "SELECT * " .
			" FROM " . $GLOBALS['ecs']->table('affordable_index') .
			" WHERE aff_id = ".$id;
	$row = $GLOBALS['db']->getRow($sql);
    if (!empty($row))
    {
    	$row['start_time'] = local_date('Y-m-d H:i', $row['start_time']);
    	$row['end_time'] = local_date('Y-m-d H:i', $row['end_time']);
	}
	return $row;
}
?>