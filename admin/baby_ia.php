<?php

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . "includes/fckeditor/fckeditor.php");

if ($_REQUEST['act'] == 'list')
{
	/* 检查权限 */
    admin_priv('users_manage');
    
    $smarty->assign('ur_here',          $_LANG['baby_ia']);
    $smarty->assign('full_page',        1);
    
    $baby_ia_list=baby_ia();
    
    $smarty->assign('baby_ia_list',   $baby_ia_list['type']);
    $smarty->assign('filter',       $baby_ia_list['filter']);
    $smarty->assign('record_count', $baby_ia_list['record_count']);
    $smarty->assign('page_count',   $baby_ia_list['page_count']);
    
    $smarty->assign('action_link',  array('text' => $_LANG['01_baby_add'], 'href'=>'baby_ia.php?act=add'));
	assign_query_info();
    $smarty->display('baby_ia.htm');
}
/*------------------------------------------------------ */
//-- 获得列表
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'query')
{
    $baby_ia_list = baby_ia();

    $smarty->assign('baby_ia_list',   $baby_ia_list['type']);
    $smarty->assign('filter',       $baby_ia_list['filter']);
    $smarty->assign('record_count', $baby_ia_list['record_count']);
    $smarty->assign('page_count',   $baby_ia_list['page_count']);

    make_json_result($smarty->fetch('baby_ia.htm'), '',
        array('filter' => $baby_ia_list['filter'], 'page_count' => $baby_ia_list['page_count']));
}
/*------------------------------------------------------ */
//-- 添加商品类型
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'add')
{
    admin_priv('goods_type');

    $smarty->assign('ur_here',     $_LANG['new_goods_type']);
    $smarty->assign('action_link', array('href'=>'baby_ia.php?act=list', 'text' => $_LANG['goods_type_list']));
    $smarty->assign('action',      'add');
    $smarty->assign('form_act',    'insert');
    //$smarty->assign('goods_type',  array('enabled' => 1));

    assign_query_info();
    $smarty->display('baby_ia_info.htm');
}

elseif ($_REQUEST['act'] == 'insert')
{
    //$goods_type['cat_name']   = trim_right(sub_str($_POST['cat_name'], 60));
    //$goods_type['attr_group'] = trim_right(sub_str($_POST['attr_group'], 255));
    $goods_type['title']   = trim($_POST['title']);
    $goods_type['btime']   = trim($_POST['btime']);
    $goods_type['bcontent']   = trim($_POST['bcontent']);
    $goods_type['bqurie']   = trim($_POST['bqurie']);
    $goods_type['bage']   = trim($_POST['bage']);
    $goods_type['rules']   = trim($_POST['rules']);
    $goods_type['agoods']   = trim($_POST['agoods']);
    $goods_type['aothergoods']   = trim($_POST['aothergoods']);
    $goods_type['acontent']   = trim($_POST['acontent']);
    $goods_type['announcement'] =trim($_POST['announcement']);
    

    if ($db->autoExecute($ecs->table('baby_ia'), $goods_type) !== false)
    {
        $links = array(array('href' => 'baby_ia.php?act=list', 'text' => $_LANG['back_list']));
        sys_msg($_LANG['add_goodstype_success'], 0, $links);
    }
    else
    {
        sys_msg($_LANG['add_goodstype_failed'], 1);
    }
}

/*------------------------------------------------------ */
//-- 编辑商品类型
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit')
{
	$goods_type = get_baby_ia_info(intval($_GET['cat_id']));
    admin_priv('goods_type');

    /* 创建 html editor */
    /*create_html_editor2('title','title',$goods_type['title']);
    
    create_html_editor2('bcontent','bcontent',$goods_type['bcontent']);
    
    create_html_editor('FCKeditor_bqurie',$goods_type['bqurie']);
    
    create_html_editor('FCKeditor_bage',$goods_type['bage']);
    
    create_html_editor('FCKeditor_rules',$goods_type['rules']);
    
    create_html_editor('FCKeditor_agoods',$goods_type['agoods']);
    
    create_html_editor('FCKeditor_aothergoods',$goods_type['aothergoods']);
    
    create_html_editor('FCKeditor_acontent',$goods_type['acontent']);*/
    
    $smarty->assign('ur_here',     $_LANG['edit_goods_type']);
    $smarty->assign('action_link', array('href'=>'baby_ia.php?act=list', 'text' => $_LANG['goods_type_list']));
    $smarty->assign('action',      'add');
    $smarty->assign('form_act',    'update');
    $smarty->assign('baby_ia',  $goods_type);

    assign_query_info();
    $smarty->display('baby_ia_info.htm');
}

elseif ($_REQUEST['act'] == 'update')
{
    $goods_type['title']   = trim($_POST['title']);
    $goods_type['btime']   = trim($_POST['btime']);
    $goods_type['bcontent']   = trim($_POST['bcontent']);
    $goods_type['bqurie']   = trim($_POST['bqurie']);
    $goods_type['bage']   = trim($_POST['bage']);
    $goods_type['rules']   = trim($_POST['rules']);
    $goods_type['agoods']   = trim($_POST['agoods']);
    $goods_type['aothergoods']   = trim($_POST['aothergoods']);
    $goods_type['acontent']   = trim($_POST['acontent']);
    $goods_type['announcement'] =trim($_POST['announcement']);
    $cat_id                   = intval($_POST['ia_id']);
    

    if ($db->autoExecute($ecs->table('baby_ia'), $goods_type, 'UPDATE', "ia_id='$cat_id'") !== false)
    {
        

        $links = array(array('href' => 'baby_ia.php?act=list', 'text' => $_LANG['back_list']));
        sys_msg($_LANG['edit_goodstype_success'], 0, $links);
    }
    else
    {
        sys_msg($_LANG['edit_goodstype_failed'], 1);
    }
}

/*------------------------------------------------------ */
//-- 删除商品类型
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'remove')
{
     admin_priv('goods_type');

    $id = intval($_GET['id']);

    //$name = $exc->get_name($id);

    if (!empty($id))
    {
        admin_log("删除宝宝秀", 'remove', 'baby_ia');

       
		$GLOBALS['db']->query("DELETE FROM " .$ecs->table('baby_ia'). " WHERE ia_id=".$id);
        //$GLOBALS['db']->query("DELETE FROM " .$ecs->table('attribute'). " WHERE attr_id " . db_create_in($arr));
        $GLOBALS['db']->query("DELETE FROM " .$ecs->table('baby_baby'). " WHERE ia_id=".$id);

        /*$url = 'baby_ia.php?act=list&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

        ecs_header("Location: $url\n");*/
        $links = array(array('href' => 'baby_ia.php?act=list', 'text' => $_LANG['back_list']));
        sys_msg($_LANG['remove_sussecs'], 0, $links);
        exit;
    }
    else
    {
        make_json_error($_LANG['remove_failed']);
    }
}

function baby_ia(){
	$result = get_filter();
    if ($result === false)
    {
        /* 分页大小 */
        $filter = array();

        /* 记录总数以及页数 */
        $sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('baby_ia');
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        $filter = page_and_size($filter);

        /* 查询记录 */
        $sql = "SELECT ia_id,btime,COUNT(ia_id) AS attr_count ".
               "FROM ". $GLOBALS['ecs']->table('baby_ia').
               " GROUP BY ia_id " .
               'LIMIT ' . $filter['start'] . ',' . $filter['page_size'];
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $all = $GLOBALS['db']->getAll($sql);

    foreach ($all AS $key=>$val)
    {
        $all[$key]['attr_group'] = strtr($val['attr_group'], array("\r" => '', "\n" => ", "));
    }

    return array('type' => $all, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

function get_baby_ia_info($cat_id)
{
    $sql = "SELECT * FROM " .$GLOBALS['ecs']->table('baby_ia'). " WHERE ia_id='$cat_id'";

    return $GLOBALS['db']->getRow($sql);
}