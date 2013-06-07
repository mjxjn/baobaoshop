<?php
header('Content-Type:text/html;charset=GB2312');
define('IN_ECS', true);
require(dirname(__FILE__) .'/includes/init.php');
$i=array(0,3);
$arrTurn = array(30,80,140,205,260,325);
$jiangpin=  array("谢谢参与!","500元婴格购物卡!","纯净冰岛鱼油!","谢谢参与!","酵素护理喷雾!","IPHONE 5!!!");
if ( $_POST['act'] == 'turnPlate') {
    $ke=rand(0,1);
    $key=$i[$ke];
    $start = mt_rand(0,1000000) ;
    if($start<4){
        $key = $start;
        $sql="select count(id) from ". $ecs->table('choujiang') ." where lv=".($key+1);
        $count_jiangpin=$db->getOne($sql);
        switch ($start){
            case 1:
                if($count_jiangpin>1){
                    $key=0;
                }
                break;
            case 2:
                 if($count_jiangpin>8){
                    $key=3;
                }
                break;
            case 4:
                 if($count_jiangpin>12){
                    $key=3;
                }
                break;
            default :
                break;
        }
    }
    $sql = "select id from ". $ecs->table('choujiang') ." where user_id=".$_POST['uid']." and lv is null order by id desc limit 0,1";
     $choujiang_id=$db->getOne($sql);
     if(empty($choujiang_id)){
         exit;
     }
     $sql = "UPDATE ". $ecs->table('choujiang') ." SET lv=".($key+1).",jiangpin='".$jiangpin[$key]."' WHERE id=".$choujiang_id;
     $db->query($sql);
    $hudu =1080+$arrTurn[$key];    //随机选一种弧度，弧度你可以自己控制，前面720表是在原来基础上多加两圈
    $tips =$arrTurn[$key];
    $result['flash']= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="497" height="497" id="turnplate">
     	  <param name="allowScriptAccess" value="always" />
          <param name="FlashVars" id="FlashVars" value="fvar='.$hudu.'&tips='.$tips.'">
          <param name="movie" value="/themes/yingge/zt/images/turnplate.swf">
          <param name="menu" value="false">
          <param name="quality" value="high">
          <param name="wmode" value="transparent">
          <embed src="/themes/yingge/zt/images/turnplate.swf" FlashVars="fvar='.$hudu.'&tips='.$tips.'" id="FlashVars"  width="497" height="497"  quality="high" id="turnplate" name="turnplate" wmode="transparent" allowScriptAccess="always"  pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash">
          </embed>
          </object>';
    echo $result['flash']."|".$jiangpin[$key];
    exit();
}
if($_POST['act']=='showresult'){
    sleep(4);
    echo $_POST['content'];
    exit();
}
?>