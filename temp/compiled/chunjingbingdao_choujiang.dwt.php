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
<SCRIPT type=text/javascript src="/themes/yingge/js/jquery.min.js"></SCRIPT>
<script>
function turnPlate() {
  $.post("turn_plate.php",
	      {act: "turnPlate",uid:<?php echo $this->_var['uid']; ?>},
	      function( data ) {
                            $('#flash').html(data);
                        return false;
           });
}
</script>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div style=" margin:0 auto;">
<div class="flash" id="flash">
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
</div>
<?php echo $this->fetch('library/page_footer2.lbi'); ?>

<map name="Map" id="Map">
  <area shape="rect" coords="400,79,622,114" href="http://weibo.com/signup/signup.php?url=http%3A%2F%2Fweibo.com%2F2480698510&c=&type=&inviteCode=2480698510&code=&spe=&lang=&entry=" />
  <area shape="rect" coords="673,78,895,112" href="http://t.qq.com/yinggemall" />
</map>
</body>
</html>