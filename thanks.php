<?php
define('IN_ECS', true);

require(dirname(__FILE__) .'/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
include_once(ROOT_PATH . 'includes/lib_transaction.php');

/* ���������ļ� */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/shopping_flow.php');
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');

assign_template();

/* ȡ���û��ȼ� */
    $user_rank_list = array();
    $user_rank_list[0] = $_LANG['not_user'];
    $sql = "SELECT rank_id, rank_name FROM " . $ecs->table('user_rank');
    $res = $db->query($sql);
    while ($row = $db->fetchRow($res))
    {
        $user_rank_list[$row['rank_id']] = $row['rank_name'];
    }
	$smarty->assign('categories',       get_categories_tree()); // ������
	$smarty->assign('helps',            get_shop_help());       // �������
$smarty->assign('lang',             $_LANG);
$smarty->display('/zt/thanks.dwt');
?>