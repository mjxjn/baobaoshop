<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>纯净冰岛活动</title>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="/themes/yingge/head.css" rel="stylesheet" rev="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="/themes/yingge/foot.css">
<SCRIPT type=text/javascript src="/themes/yingge/js/jquery.min.js"></SCRIPT>
<style type="text/css">
.w990{width:990px; margin:0 auto;}
.niuruizi_01{height:300px; background:#fdf7d7; border-bottom:1px solid #d9d7cc;}
.niuruizi_03{height:422px; background:#ffffff; border-bottom:1px solid #d9d7cc;}
.niuruizi_05{height:456px; background:#fdf7d7; border-bottom:1px solid #d9d7cc;}
</style>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div style=" margin:0 auto;" class="niuruizi_01">
	<div class="w990" style="background:url('/themes/yingge/zt/images/bingdao_01.gif') no-repeat;height:300px;">
	<div style="position: relative;left: 64px;top: 146px;"><a href="http://www.pure-iceland.com/" target="_blank">纯净冰岛是什么产品？<font style="color:red">点击了解</font></a></div>
	<div style="position: relative;left: 48px;top: 154px;"><a href="http://www.yingge.com/chunjingbingdao_question.php"><img src="/themes/yingge/zt/images/bingdao_02.gif" border=0></a></div>
        <div style="position: relative;left: 48px;top: 160px; font-size:13px; color:#4e5256;">活动时间：2013.05.26-2013.06.26</div>
        <div style="position: relative;left: 48px;top: 170px; font-size:13px; color:#4e5256;">每天开始时间：08：00</div>
	</div>
</div>
<div style=" margin:0 auto;" class="niuruizi_03">
	<div class="w990" style="background:url('/themes/yingge/zt/images/bingdao_03.gif') no-repeat;height:422px;">
	<div style="color:#7e6b5a;position: relative;left: 15px;top: 100px;">欢迎您，请登录后再参加[<a href="/user.php" target="_blank" style="color:#7e6b5a;">登录</a>]</div>
	<div style="position: relative;left: 429px;top: 134px;width: 96px;"><a style="color:#fff;" href="/brand-378-c0.html" target="_blank">查看纯净冰岛产品</a></div>
	<div style="position: relative;left: 600px;top: 155px;width:350px;">
		<ul style="width:350px;height:225px; overflow:hidden;" class="line">
		<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list_0_46889300_1369809268');if (count($_from)):
    foreach ($_from AS $this->_var['list_0_46889300_1369809268']):
?>
			<li style="line-height:25px; clear:both;"><div style="float:left;width:130px;"><?php echo $this->_var['list_0_46889300_1369809268']['user_name']; ?></div><span style="float:left;width:95px;">用户获得</span><div style="color:#f3822c;font-weight:bold;float:left; width:125px;"><?php echo $this->_var['list_0_46889300_1369809268']['jiangpin']; ?></div></li>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
	</div>
	</div>
</div>
<div style=" margin:0 auto;" class="niuruizi_05">
	<div class="w990" style="background:url('/themes/yingge/zt/images/bingdao_05.gif') no-repeat;height:456px;">
	<div style="position: relative;left: 780px;top: 177px; width:180px;"><a href="http://cnrdn.com/fEA5"><img src="/themes/yingge/zt/images/bingdao_04.gif" border=0></a></div>
	</div>
</div>
<?php echo $this->fetch('library/page_footer2.lbi'); ?>

<map name="Map" id="Map">
  <area shape="rect" coords="400,79,622,114" href="http://weibo.com/signup/signup.php?url=http%3A%2F%2Fweibo.com%2F2480698510&c=&type=&inviteCode=2480698510&code=&spe=&lang=&entry=" />
  <area shape="rect" coords="673,78,895,112" href="http://t.qq.com/yinggemall" />
</map>
</body>
</html>
<script> 
 $(function(){ 
//单行应用@Mr.Think 
var _wrap=$('ul.line');//定义滚动区域 
var _interval=2000;//定义滚动间隙时间 
var _moving;//需要清除的动画 
_wrap.hover(function(){ 
clearInterval(_moving);//当鼠标在滚动区域中时,停止滚动 
},function(){ 
_moving=setInterval(function(){ 
var _field=_wrap.find('li:first');//此变量不可放置于函数起始处,li:first取值是变化的 
var _h=_field.height();//取得每次滚动高度 
_field.animate({marginTop:-_h+'px'},600,function(){//通过取负margin值,隐藏第一行 
_field.css('marginTop',0).appendTo(_wrap);//隐藏后,将该行的margin值置零,并插入到最后,实现无缝滚动 
}) 
},_interval)//滚动间隔时间取决于_interval 
}).trigger('mouseleave');//函数载入时,模拟执行mouseleave,即自动滚动 
}); 
</script> 