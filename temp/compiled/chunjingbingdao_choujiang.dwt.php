<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>纯净冰岛活动答题</title>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="/themes/yingge/head.css" rel="stylesheet" rev="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="/themes/yingge/foot.css">
<style type="text/css">
.w990{width:990px; margin:0 auto; overflow:hidden;}
</style>
<SCRIPT type=text/javascript src="/themes/yingge/js/jquery.min.js"></SCRIPT>
<SCRIPT type=text/javascript>
function   sleep(n)   
    {   
        var   start=new   Date().getTime();   
        while(true)   if(new   Date().getTime()-start> n)   break;   
    }  
function turnPlate(){
  $.post("turn_plate.php",
	      {act: "turnPlate",uid:<?php echo $this->_var['uid']; ?>},
	      function( data ) {
var strs= new Array(); //定义一数组

strs=data.split("|"); //字符分割 
                            $('#flash').html(strs[0]);
$("#num").empty();
$("#num").html(0);
                           $.post("turn_plate.php",{act:"showresult",content:strs[1]},function(msg){
                  $('#jiangpin').empty();
          $('#jiangpin').html(msg);
});
                           
                        return false;
           });
}

</script>

</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div style="padding:20px 0; background:#ffcc66">
<div class="w990">
<div style="float:left; width:477px;height:497px;padding-right:20px" id="flash">
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="497" height="497" id="turnplate">
 	<param name="allowScriptAccess" value="always" />
    <param name="FlashVars" id="FlashVars" value="fvar=0&tips=" />
    <param name="movie" value="/themes/yingge/zt/images/turnplate.swf">
    <param name="menu" value="false">
    <param name="quality" value="high">
    <param name="wmode" value="transparent">
    <embed src="/themes/yingge/zt/images/turnplate.swf" FlashVars="fvar=0&tips=" id="FlashVars"  width="497" height="497"  quality="high" id="turnplate" name="turnplate" wmode="transparent" allowScriptAccess="always"  pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
</object>
</div>
<div style="float:left;color:#a63e1f; font-family:'微软雅黑'">
<div style="padding-top:50px;font-size:24px;line-height:45px;">您有<span id="num">1</span>次抽奖机会</div>
<p style="width:450px;height:3px;background:#a63e1f;margin-bottom:12px;">&nbsp;</p>
<div style="font-size:16px;padding-bottom:12px;">抽奖方法：点击立即抽奖，中奖结果会在下方提示</div>
<div style="background:url('/themes/yingge/zt/images/bingdao_11.gif') no-repeat; width:450px; height:323px;">
<p id="jiangpin" style="width:450px; text-align:center;font-size:24px;padding-top:100px;line-height:45px;">抽奖结果再这里显示</p>
<p style="width:450px; text-align:center;font-size:16px; line-height:25px;">回答问题再次参与</p>
<p style="width:450px; text-align:center; font-size:16px; line-height:25px;padding-top:30px;"><a href="/chunjingbingdao_question.php" style="color:#ffc74b;">返回回答问题</a></p></div>
</div>
</div>
</div>
<?php echo $this->fetch('library/page_footer2.lbi'); ?>

<map name="Map" id="Map">
  <area shape="rect" coords="400,79,622,114" href="http://weibo.com/signup/signup.php?url=http%3A%2F%2Fweibo.com%2F2480698510&c=&type=&inviteCode=2480698510&code=&spe=&lang=&entry=" />
  <area shape="rect" coords="673,78,895,112" href="http://t.qq.com/yinggemall" />
</map>
</body>
</html>