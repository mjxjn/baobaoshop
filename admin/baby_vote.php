<?php

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
/*------------------------------------------------------ */
//-- ajax返回用户列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'query')
{
	
    $vote = vote_list($_REQUEST[baby_id]);

    $smarty->assign('baby_vote_list',    $vote['vote_list']);
    $smarty->assign('filter',       $vote['filter']);
    $smarty->assign('record_count', $vote['record_count']);
    $smarty->assign('page_count',   $vote['page_count']);

    

    make_json_result($smarty->fetch('baby_vote_info.htm'), '', array('filter' => $vote['filter'], 'page_count' => $vote['page_count']));
}
elseif ($_REQUEST['act'] == 'vote')
{
/* 检查权限 */
    admin_priv('users_manage');
    
    $vote=vote_list($_GET['id'],$_GET['ia']);
    
	assign_query_info();
	
	$smarty->assign('baby_vote_list',    $vote['vote_list']);
	$smarty->assign('filter',       $vote['filter']);
    $smarty->assign('record_count', $vote['record_count']);
    $smarty->assign('page_count',   $vote['page_count']);

    $smarty->assign('full_page',    1);
    
	$smarty->display('baby_vote_info.htm');
}

function vote_list($baby_id,$ia){
	$result = get_filter();
	if ($result === false)
    {
		$filter['baby_id']=$baby_id;
		$filter['ia_id']=$ia;
		$ex_where = ' WHERE 1 ';
	    if($filter['baby_id'])
	    {
	        $ex_where .= " AND baby_id = '$filter[baby_id]' and ia_id=$ia";
	    }
	    $filter['record_count'] = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('baby_vote') . $ex_where);
    	/* 分页大小 */
        $filter = page_and_size($filter);
        $sql = "SELECT baby_id, ip, user_id, user_name, fvote_time, vote_time ".
                " FROM " . $GLOBALS['ecs']->table('baby_vote') . $ex_where .
                " ORDER by fvote_time desc" .
                " LIMIT " . $filter['start'] . ',' . $filter['page_size'];
        set_filter($filter, $sql);
		
    }else{
    	$sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $vote_list = $GLOBALS['db']->getAll($sql);

    $arr = array('vote_list' => $vote_list, 'filter' => $filter,
        'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}
