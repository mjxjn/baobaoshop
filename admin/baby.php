<?php

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ($_REQUEST['act'] == 'list')
{
	/* 检查权限 */
    admin_priv('users_manage');
	$sql = "select ia_id from ".$GLOBALS['ecs']->table('baby_ia')." order by ia_id desc limit 0,1";
	$ia_id = $db->getOne($sql);
	$ia = isset($_GET['ia']) ?  (int)$_GET['ia'] : $ia_id;
    
	$baby_list = baby_list($ia);
	
	$smarty->assign('ia',    $ia_id);
	$smarty->assign('baby_list',    $baby_list['baby_list']);
    $smarty->assign('filter',       $baby_list['filter']);
    $smarty->assign('record_count', $baby_list['record_count']);
    $smarty->assign('page_count',   $baby_list['page_count']);
    $smarty->assign('full_page',    1);
    $smarty->assign('sort_baby_id', '<img src="images/sort_desc.gif">');

    assign_query_info();
    $smarty->display('baby_list.htm');
}
elseif ($_REQUEST['act'] == 'add')
{
	/* 检查权限 */
    admin_priv('users_manage');

    $smarty->assign('form_action',      'insert');
	assign_query_info();
    $smarty->display('baby_add.htm');
	
}
elseif ($_REQUEST['act'] == 'insert')
{
	/* 检查权限 */
    admin_priv('users_manage');
    $baby_name = empty($_POST['baby_name']) ? '' : trim($_POST['baby_name']);
	$baby_sex = empty($_POST['babysex']) ? 1 : trim($_POST['babysex']);
	$baby_birthday = empty($_POST['babybirthday']) ? 1 : trim($_POST['babybirthday']);
	$babyxingxiao=birthext($baby_birthday);
	$baby_xing=$babyxingxiao["xz"];
	$baby_xiao=$babyxingxiao["sx"];
    $_POST['pic']=empty($_POST['pic']) ? '' : $_POST['pic'];
	
    if(!empty($_POST['pic'][0]))
    {
    	$baby_pic=$_POST['pic'][0];
    }
	if(!empty($_POST['pic'][1]))
    {
    	if(empty($baby_pic)){
    		$baby_pic=$_POST['pic'][1];
    	}else{
    		$baby_pic=$baby_pic.','.$_POST['pic'][1];
    	}
    }
	if(!empty($_POST['pic'][2]))
    {
    	if(empty($baby_pic)){
    		$baby_pic=$_POST['pic'][2];
    	}else{
    		$baby_pic=$baby_pic.",".$_POST['pic'][2];
    	}
    }
	if(!empty($_POST['pic'][3]))
    {
    	if(empty($baby_pic)){
    		$baby_pic=$_POST['pic'][3];
    	}else{
    		$baby_pic=$baby_pic.",".$_POST['pic'][3];
    	}
    }
	if(!empty($_POST['pic'][4]))
    {
    	if(empty($baby_pic)){
    		$baby_pic=$_POST['pic'][4];
    	}else{
    		$baby_pic=$baby_pic.",".$_POST['pic'][4];
    	}
    }
	if(!empty($_POST['pic'][5]))
    {
    	if(empty($baby_pic)){
    		$baby_pic=$_POST['pic'][5];
    	}else{
    		$baby_pic=$baby_pic.",".$_POST['pic'][5];
    	}
    }
    $baby_tel=empty($_POST['babytel']) ? '' : trim($_POST['babytel']);
    $baby_content=empty($_POST['babycontent'])? '':trim($_POST['babycontent']);
    $baby_time=date("Y-m-d",time());
	$sql = "select ia_id from ".$GLOBALS['ecs']->table('baby_ia')." order by ia_id desc limit 0,1";
	$ia_id = $db->getOne($sql);
	$sql = "select baby_id from ".$GLOBALS['ecs']->table('baby_baby')." where ia_id=".$ia_id." order by baby_id desc limit 0,1";
	$baby_id = $db->getOne($sql);
	if(empty($baby_id)) $baby_id=0;
	$baby_id+=1;
	$sql = "INSERT INTO " .$GLOBALS['ecs']->table('baby_baby'). " (baby_id, baby_pic, baby_name, baby_sex, baby_birthday, baby_tel, baby_content, baby_xing, baby_xiao, user_id, user_name, baby_time, ia_id)" .
           "VALUES ('$baby_id','$baby_pic', '$baby_name', '$baby_sex' , '$baby_birthday' , '$baby_tel', '$baby_content', '$baby_xing', '$baby_xiao', '', '婴格母婴商城' , '$baby_time', '$ia_id')";
	$db->query($sql);

    /* 记录管理员操作 */
    admin_log($baby_name, 'insert', 'baby_baby');

    /* 提示信息 */
    $links[0]['text']    = $_LANG['goto_list'];
    $links[0]['href']    = 'baby.php?act=add&' . list_link_postfix();
    $links[1]['text']    = $_LANG['go_back'];
    $links[1]['href']    = 'javascript:history.back()';

    sys_msg(sprintf($_LANG['add_success'], htmlspecialchars(stripslashes($_POST['baby_name']))), 0, $links);
}
/*------------------------------------------------------ */
//-- ajax返回用户列表
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
	
    $baby_list = baby_list();

    $smarty->assign('baby_list',    $baby_list['baby_list']);
    $smarty->assign('filter',       $baby_list['filter']);
    $smarty->assign('record_count', $baby_list['record_count']);
    $smarty->assign('page_count',   $baby_list['page_count']);

    $sort_flag  = sort_flag($baby_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('baby_list.htm'), '', array('filter' => $baby_list['filter'], 'page_count' => $baby_list['page_count']));
}
/*------------------------------------------------------ */
//-- 编辑用户帐号
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit')
{
	/* 检查权限 */
    admin_priv('users_manage');
    $sql = "SELECT baby_id,baby_pic,baby_name,baby_sex,baby_birthday,baby_tel,baby_time,baby_content,baby_number,baby_xing,baby_xiao,user_id,user_name,baby_yin".
        " FROM " .$ecs->table('baby_baby'). " WHERE baby_id='$_GET[id]'";

    $row = $db->GetRow($sql);

    if ($row)
    {
        $user['baby_id']        = $row['baby_id'];
        $user['baby_sex']       = ($row['baby_sex']==1) ? "男":"女";
        $user['baby_birthday']  = $row['baby_birthday'];
        
        $baby_pic_list       = explode(",",$row['baby_pic']);
        
        
        $user['baby_name']    = $row['baby_name'];
        $user['baby_tel']      = $row['baby_tel'];
        $user['baby_time']     = $row['baby_time'];
        $user['baby_content']   = $row['baby_content'];
        $user['baby_number']    = $row['baby_number'];
        
        $user['user_id']             = $row['user_id'];
        $user['user_name']            = $row['user_name'];
        $user['baby_yin']            = $row['baby_yin'];
        
       
    }
    else
    {
          $link[] = array('text' => $_LANG['go_back'], 'href'=>'baby.php?act=list');
          sys_msg($_LANG['username_invalid'], 0, $links);
//        $user['sex']            = 0;
//        $user['pay_points']     = 0;
//        $user['rank_points']    = 0;
//        $user['user_money']     = 0;
//        $user['frozen_money']   = 0;
//        $user['credit_line']    = 0;
//        $user['formated_user_money'] = price_format(0);
//        $user['formated_frozen_money'] = price_format(0);
     }

    assign_query_info();
    //$smarty->assign('ur_here',          $_LANG['users_edit']);
    //$smarty->assign('action_link',      array('text' => $_LANG['03_users_list'], 'href'=>'users.php?act=list&' . list_link_postfix()));
    $smarty->assign('user',             $user);
    $smarty->assign('baby_pic_list',    $baby_pic_list);
    
    $smarty->assign('form_action',      'update');
    //$smarty->assign('special_ranks',    get_rank_list(true));
    $smarty->display('baby_info.htm');
}

/*------------------------------------------------------ */
//-- 更新用户帐号
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'update')
{
	/* 检查权限 */
    admin_priv('users_manage');
    $baby_id = empty($_POST['baby_id']) ? '' : trim($_POST['baby_id']);
    $baby_name = empty($_POST['baby_name']) ? '' : trim($_POST['baby_name']);
    $_POST['pic']=empty($_POST['pic']) ? '' : $_POST['pic'];
    if(!empty($_POST['pic'][0]))
    {
    	$baby_pic=$_POST['pic'][0];
    }
	if(!empty($_POST['pic'][1]))
    {
    	if(empty($baby_pic)){
    		$baby_pic=$_POST['pic'][1];
    	}else{
    		$baby_pic=$baby_pic.','.$_POST['pic'][1];
    	}
    }
	if(!empty($_POST['pic'][2]))
    {
    	if(empty($baby_pic)){
    		$baby_pic=$_POST['pic'][2];
    	}else{
    		$baby_pic=$baby_pic.",".$_POST['pic'][2];
    	}
    }
	if(!empty($_POST['pic'][3]))
    {
    	if(empty($baby_pic)){
    		$baby_pic=$_POST['pic'][3];
    	}else{
    		$baby_pic=$baby_pic.",".$_POST['pic'][3];
    	}
    }
	if(!empty($_POST['pic'][4]))
    {
    	if(empty($baby_pic)){
    		$baby_pic=$_POST['pic'][4];
    	}else{
    		$baby_pic=$baby_pic.",".$_POST['pic'][4];
    	}
    }
	if(!empty($_POST['pic'][5]))
    {
    	if(empty($baby_pic)){
    		$baby_pic=$_POST['pic'][5];
    	}else{
    		$baby_pic=$baby_pic.",".$_POST['pic'][5];
    	}
    }
    $baby_yin=empty($_POST['baby_yin']) ? '' : trim($_POST['baby_yin']);
    $baby_number=empty($_POST['baby_number']) ? '' : trim($_POST['baby_number']);
    $baby_content=empty($_POST['baby_content'])? '':trim($_POST['baby_content']);
    
    $sql="update ".$ecs->table('baby_baby')." set baby_name='".$baby_name."', baby_pic='".$baby_pic."', baby_content='".$baby_content."', baby_yin='".$baby_yin."', baby_number='".$baby_number."' where baby_id=".$baby_id;
	
    $db->query($sql);

    /* 记录管理员操作 */
    admin_log($baby_name, 'edit', 'baby_baby');

    /* 提示信息 */
    $links[0]['text']    = $_LANG['goto_list'];
    $links[0]['href']    = 'baby.php?act=list&' . list_link_postfix();
    $links[1]['text']    = $_LANG['go_back'];
    $links[1]['href']    = 'javascript:history.back()';

    sys_msg($_LANG['update_success'], 0, $links);

}

/*------------------------------------------------------ */
//-- 删除会员帐号
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'remove')
{
    /* 检查权限 */
    admin_priv('users_drop');

    $sql = "SELECT baby_name FROM " . $ecs->table('baby_baby') . " WHERE baby_id = '" . $_GET['id'] . "'";
    $username = $db->getOne($sql);
    
    $sql = "SELECT user_id FROM " . $ecs->table('baby_baby') . " WHERE baby_id = '" . $_GET['id'] . "'";
    $user_id = $db->getOne($sql);
    
	$sql="DELETE from ". $ecs->table('baby_baby') ." WHERE baby_id = '" . $_GET['id'] . "'";
	$db->query($sql);
	
	$sql = "select pay_points from ".$GLOBALS['ecs']->table('users'). " where user_id=".$user_id;
	$pay_points = $db->getOne($sql);
	$pay_points -= 200;
	$sql="update ".$GLOBALS['ecs']->table('users'). " set pay_points=".$pay_points."  where user_id=".$user_id;
	$db->query($sql);
	
	$nowdate=time();
	
	$sql="INSERT INTO " .$GLOBALS['ecs']->table('account_log')." (user_id,pay_points,change_time,change_desc,change_type)".
	"VALUES ('$user_id', '-200', '$nowdate','退出明星宝宝秀活动','88')";
	$db->query($sql);
	
    /* 记录管理员操作 */
    admin_log(addslashes($username), 'remove', 'baby_baby');

    /* 提示信息 */
    $link[] = array('text' => $_LANG['go_back'], 'href'=>'baby.php?act=list');
    sys_msg(sprintf($_LANG['remove_success'], $username), 0, $link);
}

/*------------------------------------------------------ */
//-- 批量删除会员帐号
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'batch_remove')
{
    /* 检查权限 */
    admin_priv('users_drop');

    if (isset($_POST['checkboxes']))
    {
        $sql = "SELECT baby_name FROM " . $ecs->table('baby_baby') . " WHERE baby_id " . db_create_in($_POST['checkboxes']);
        $col = $db->getCol($sql);
        $usernames = implode(',',addslashes_deep($col));
        $count = count($col);
        
        $sql = "SELECT user_id FROM " . $ecs->table('baby_baby') . " WHERE baby_id " . db_create_in($_POST['checkboxes']);
    	$user_col = $db->getCol($sql);
    	$user_id = implode(',',addslashes_deep($user_col));
    	$user_count = count($user_col);
        
		$sql= "DELETE FROM " . $ecs->table('baby_baby') . " WHERE baby_id " . db_create_in($_POST['checkboxes']);
		$db->query($sql);
		
		if($user_count!=0){
			
			$nowdate=time();
			for($i=0;$i<$user_count;$i++){
				$sql = "select pay_points from ".$GLOBALS['ecs']->table('users'). " where user_id=".$user_col[$i];
				$pay_points = $db->getOne($sql);
				$pay_points -= 200;
				$sql="update ".$GLOBALS['ecs']->table('users'). " set pay_points=".$pay_points."  where user_id=".$user_col[$i];
				$db->query($sql);
				
				$sql="INSERT INTO " .$GLOBALS['ecs']->table('account_log')." (user_id,pay_points,change_time,change_desc,change_type)".
				"VALUES ('$user_col[$i]', '-200', '$nowdate','退出明星宝宝秀活动','88')";
				$db->query($sql);
			}
		}
		
        admin_log($usernames, 'batch_remove', 'baby_baby');

        $lnk[] = array('text' => $_LANG['go_back'], 'href'=>'baby.php?act=list');
        sys_msg(sprintf($_LANG['batch_remove_success'], $count), 0, $lnk);
    }
    else
    {
        $lnk[] = array('text' => $_LANG['go_back'], 'href'=>'users.php?act=list');
        sys_msg($_LANG['no_select_user'], 0, $lnk);
    }
}

function baby_list($ia){
	$sql = "select ia_id from ".$GLOBALS['ecs']->table('baby_ia')." order by ia_id desc limit 0,1";
	$ia_id = $GLOBALS['db']->getOne($sql);
	$result = get_filter();
	if ($result === false)
    {
        /* 过滤条件 */
        $filter['baby_name'] = empty($_REQUEST['baby_name']) ? '' : trim($_REQUEST['baby_name']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['baby_name'] = json_str_iconv($filter['baby_name']);
        }
        
		$filter['ia']=$ia;
		
		$filter['baby_id']=empty($_REQUEST['baby_id'])? 0 : intval($_REQUEST['baby_id']);
        
        $filter['sort_by']    = empty($_REQUEST['sort_by'])    ? 'baby_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC'     : trim($_REQUEST['sort_order']);

        $ex_where = ' WHERE 1 ';
        if ($filter['baby_name'])
        {
            $ex_where .= " AND baby_name LIKE '%" . mysql_like_quote($filter['baby_name']) ."%' ";
        }

        if($filter['baby_id'])
        {
        	$ex_where .= " AND baby_id = '$filter[baby_id]' ";
        }
		
		if($filter['ia']===0)
		{
			$ex_where .= " AND ia_id <>".$ia_id;
		}else{
			$ex_where .= " AND ia_id =".$filter['ia'];
		}

        $filter['record_count'] = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('baby_baby') . $ex_where);

        /* 分页大小 */
        $filter = page_and_size($filter);
        $sql = "SELECT baby_id, baby_name, baby_sex,baby_birthday, user_name,baby_time,baby_tel,baby_number,ia_id ".
                " FROM " . $GLOBALS['ecs']->table('baby_baby') . $ex_where .
                " ORDER by " . $filter['sort_by'] . ' ' . $filter['sort_order'] .
                " LIMIT " . $filter['start'] . ',' . $filter['page_size'];

        $filter['baby_name'] = stripslashes($filter['baby_name']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $baby_list = $GLOBALS['db']->getAll($sql);

    $arr = array('baby_list' => $baby_list, 'filter' => $filter,
        'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

//初始化日历类
function &calendar()
{
	 global $calendar;
	 if(!$calendar){
	            $calendar = new Lunar();
	 }
     return $calendar;
}


/**
 * 判断干支、生肖和星座
 * @param string $type 返回类型: array.
 * @param date $birth = 时间戳,其它时间写法
 * @author bottle [email=hhyisw@163.com]hhyisw@163.com[/email]

//示例
$arr = birthext ( '474768000' ); //时间戳
print_r ( $arr );
$arr = birthext ( '1985-01-17' );
print_r ( $arr );
$arr = birthext ( '19850117' );
print_r ( $arr );
 */
function birthext($birth) {
	if (strstr ( $birth, '-' ) === false && strlen ( $birth ) !== 8)
		$birth = date ( "Y-m-d", $birth );
	if (strlen ( $birth ) === 8) {
		if (eregi ( '([0-9]{4})([0-9]{2})([0-9]{2})$', $birth, $bir ))
			$birth = "{$bir[1]}-{$bir[2]}-{$bir[3]}";
	}
	
	if (strlen ( $birth ) < 8)
		return false;
	
	$tmpstr = explode ( '-', $birth );
	
	if (count ( $tmpstr ) !== 3)
		return false;
	
	$y = ( int ) $tmpstr [0];
	$m = ( int ) $tmpstr [1];
	$d = ( int ) $tmpstr [2];
	$result = array ();
	$xzdict = array ('10', '11', '12', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
	$zone = array (1222, 122, 222, 321, 421, 522, 622, 722, 822, 922, 1022, 1122, 1222 );
	if ((100 * $m + $d) >= $zone [0] || (100 * $m + $d) < $zone [1]) {
		$i = 0;
	} else {
		for($i = 1; $i < 12; $i ++) {
			if ((100 * $m + $d) >= $zone [$i] && (100 * $m + $d) < $zone [$i + 1])
				break;
		}
	}
	$result ['xz'] = $xzdict [$i];
	
	/*$gzdict = array (array ('甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸' ), array ('子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥' ) );
	$i = $y - 1900 + 36;
	$result ['gz'] = $gzdict [0] [($i % 10)] . $gzdict [1] [($i % 12)];*/
	
	$sxdict = array ('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12' );
	$result ['sx'] = $sxdict [(($y - 4) % 12)];
	return $result;
}