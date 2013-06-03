<?php 
define('IN_ECS', true);

require('../includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}
$now=gmtime();
$endtime=local_mktime(23, 59, 59, 6, 6, 2013);
if($now>$endtime){
	show_starbaby_message('第二届宝宝明星秀活动报名结束，感谢您的积极参与！', '', '', 'warning');
	exit;
}
if ($_SESSION['user_id'] == 0)
{
   /* 用户没有登录，转向到登录页面 */
   ecs_header("Location: /user.php\n");
   exit;
}

if($_POST['act']=="insert"){
	$pic=$_POST['pic'];
	$babyname=str_check($_POST['babyname']);
	$babysex=verify_id($_POST['babysex']);
	$babybirthday=str_check($_POST['babybirthday']);
	$babytel=str_check($_POST['babytel']);
	$babycontent=str_check($_POST['babycontent']);
	$userid=verify_id($_POST['userid']);
	
	/* *
	 * var_dump($pic) ;
	
	 array(3) { 
	 [0]=> string(40) "/starbaby/uploads/201205021500227996.jpg" 
	 [1]=> string(40) "/starbaby/uploads/201205021500251964.jpg" 
	 [2]=> string(40) "/starbaby/uploads/201205021500288171.jpg" 
	 }
	 
	echo "<br />".$babybirthday."<br />";
	$babyxingxiao=birthext($babybirthday);
	var_dump($dd) ;
	
	 * array(2) { ["xz"]=> string(9) "金牛座" ["sx"]=> string(3) "龙" }
	 * */
	
	$baby_pic=$pic['0'].",".$pic['1'].",".$pic['2'].",".$pic['3'];

	$baby_name=$babyname;
	$baby_sex=$babysex;
	$baby_birthday=$babybirthday;
	$baby_tel=$babytel;
	$baby_content=$babycontent;
	$babyxingxiao=birthext($babybirthday);
	$baby_xing=$babyxingxiao["xz"];
	$baby_xiao=$babyxingxiao["sx"];
	$user_id=$userid;
	$baby_time=date("Y-m-d",time());
	if($pic['0']==""){
		show_starbaby_message('请上传宝宝图片', '', '', 'warning');
		exit;
	}
	if(empty($baby_name)||$baby_name=='还没填写'){
		show_starbaby_message('请填写宝宝昵称', '', '', 'warning');
		exit;
	}
	if(!preg_match("/^\d{7,12}$/",$baby_tel)&&!empty($baby_tel)&&$baby_tel!='还没填写'){
		show_starbaby_message('请填写正确的联系电话', '', '', 'warning');
		exit;
	}
	if(empty($baby_content)||$baby_content=="请输入您的宝宝参赛宣言！(50字内)"){
		show_starbaby_message('请填写宝宝参赛宣言', '', '', 'warning');
		exit;
	}
	$sql = "select user_name from ".$GLOBALS['ecs']->table('users'). " where user_id=".$user_id;
	$user_name = $db->getOne($sql);
	$sql = "select ia_id from ".$GLOBALS['ecs']->table('baby_ia')." order by ia_id desc limit 0,1";
	$ia_id = $db->getOne($sql);
	$sql = "select count(*) as u from ".$GLOBALS['ecs']->table('baby_baby')." where user_id=".$user_id." and ia_id=".$ia_id;
	$u = $db->getOne($sql);
	if($u > 0){
		show_starbaby_message('您已经参与了本期明星宝宝秀活动', '', '', 'warning');
		exit;
	}
        $sql = "select baby_id from ".$GLOBALS['ecs']->table('baby_baby'). " where ia_id=".$ia_id." order by baby_id desc limit 0,1";
        $baby_id = $db->getOne($sql);
        if(empty($baby_id)){
            $sql = "INSERT INTO " .$GLOBALS['ecs']->table('baby_baby'). " (baby_id,baby_pic, baby_name, baby_sex, baby_birthday, baby_tel, baby_content, baby_xing, baby_xiao, user_id, user_name, baby_time, ia_id)" .
           "VALUES ('1','$baby_pic', '$baby_name', '$baby_sex' , '$baby_birthday' , '$baby_tel', '$baby_content', '$baby_xing', '$baby_xiao', '$user_id', '$user_name' , '$baby_time', '$ia_id')";
        }else{
            $baby_id = $baby_id+1;
            $sql = "INSERT INTO " .$GLOBALS['ecs']->table('baby_baby'). " (baby_id,baby_pic, baby_name, baby_sex, baby_birthday, baby_tel, baby_content, baby_xing, baby_xiao, user_id, user_name, baby_time, ia_id)" .
           "VALUES ('$baby_id','$baby_pic', '$baby_name', '$baby_sex' , '$baby_birthday' , '$baby_tel', '$baby_content', '$baby_xing', '$baby_xiao', '$user_id', '$user_name' , '$baby_time', '$ia_id')";
        }
	$db->query($sql);
	$sql = "select pay_points from ".$GLOBALS['ecs']->table('users'). " where user_id=".$user_id;
	$pay_points = $db->getOne($sql);
	$pay_points += 200;
	$sql="update ".$GLOBALS['ecs']->table('users'). " set pay_points=".$pay_points."  where user_id=".$user_id;
	$db->query($sql);
	$sql="select bonus_id from ".$GLOBALS['ecs']->table('user_bonus')." where user_id=0 and bonus_type_id=20 order by bonus_id asc limit 0,1";
	$bonus_id = $db->getOne($sql);
	$nowdate=time();
	$sql="INSERT INTO " .$GLOBALS['ecs']->table('account_log')." (user_id,pay_points,change_time,change_desc,change_type)".
	"VALUES ('$user_id', '200', '$nowdate','参加明星宝宝秀活动','88')";
	$db->query($sql);
	if($bonus_id){
		$sql="update ".$GLOBALS['ecs']->table('user_bonus')." set user_id=".$user_id." where bonus_type_id=20 and bonus_id=".$bonus_id;
		$db->query($sql);
		show_starbaby_message('恭喜您，您已报名成功，告诉您的朋友给您投上支持的一票吧<br />系统自动赠送您200积分，并赠送您婴格母婴商城5元代金券一张', '返回明星宝宝秀首页', 'starbaby.php', 'info', false);
		exit;
	}else{
		show_starbaby_message('恭喜您，您已报名成功，告诉您的朋友给您投上支持的一票吧<br />系统自动赠送您200积分', '返回明星宝宝秀首页', 'starbaby.php', 'info', false);
		exit;
	}
}
assign_template();


$sql = "select user_name from ".$GLOBALS['ecs']->table('users'). " where user_id=".$_SESSION['user_id'];
$user_name = $db->getOne($sql);
$sql = "select ia_id from ".$GLOBALS['ecs']->table('baby_ia')." order by ia_id desc limit 0,1";
$ia_id = $db->getOne($sql);
$sql = "select count(*) as u from ".$GLOBALS['ecs']->table('baby_baby')." where user_id=".$_SESSION['user_id']." and ia_id=".$ia_id;
$u = $db->getOne($sql);
if($u > 0){
	show_starbaby_message('您已经参加了本期明星宝宝秀', '', '', 'warning');
	exit;
}

$smarty->assign('page_title',      '明星宝宝报名_婴格母婴商城-云南最大的母婴一站式购物网站,妈妈们的放心选择,云南母婴第一品牌!');    // 页面标题

$smarty->assign('helps',            get_shop_help());       // 网店帮助
$smarty->assign('todaydate',        date("Y-m-d"),time());
$smarty->assign('user_id',          $_SESSION['user_id']);

$smarty->display('starbaby/register.htm');



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

?>