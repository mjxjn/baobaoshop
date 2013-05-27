<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $this->_var['page_title']; ?></title>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="/themes/yingge/style.css" rel="stylesheet" rev="stylesheet" type="text/css" />
<link href="/themes/yingge/head.css" rel="stylesheet" rev="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="/themes/yingge/foot.css">
<link href="/themes/yingge/starbaby/index.css" rel="stylesheet" rev="stylesheet" type="text/css" />
<SCRIPT type=text/javascript src="/themes/yingge/js/jquery.min.js"></SCRIPT>
<SCRIPT type=text/javascript src="/themes/yingge/js/starbaby.js"></SCRIPT>
<script type="text/javascript">
$(document).ready(function(){
	//回到顶部按钮操作事件 
    var show_delay;
    var scroll_div_left=parseInt((document.body.offsetWidth-990)/2)+990;    
    $(".scroll_div").click(function (){
        document.documentElement.scrollTop=0;
        document.body.scrollTop=0;
    });
    $(window).resize(function (){
        scroll_div_left=parseInt((document.body.offsetWidth-990)/2)+990;
        $(".scroll_div").css("left",scroll_div_left);
    });
    reshow(scroll_div_left,show_delay);
});
/* 回到页面顶部按钮显示 */
function reshow(marign_l,show_d) {
$(".scroll_div").css("left",marign_l);
if((document.documentElement.scrollTop+document.body.scrollTop)!=0) 
    {
    $(".scroll_div").css("display","block");
    }   
    else
    {
    $(".scroll_div").css("display","none");  }
    if(show_d) window.clearTimeout(show_d) ;
    show_d=setTimeout("reshow()",500);
}
</script>
</head>
<body>
<?php echo $this->fetch('starbaby/library/baby_page_header.lbi'); ?>
<div id="bigpic">
	<div class="bigpic_starbaby w990"><div class="bigpic_btn"><a href="register.php">参加宝宝秀赢取超级大奖</a></div></div>
</div>
<div id="starbaby">
	<div class="starbaby_nav w990">
		<ul class="starbaby_navul">
			<li><a href="index.php">人气明星宝宝</a></li>
			<li><a href="introduction.php">活动介绍</a></li>
			<li><a href="awards.php">奖项设置</a></li>
			<li><a href="register.php" target="_blank">报名参加</a></li>
			<li><a href="announcement.php">活动公告</a></li>
		</ul>
		<div class="starbaby_navmore"><a href="starbaby.php">查看全部宝宝</a></div>
	</div>
	<div class="w990">
<div class="bd">
<ul class="baobaos clearfix">
<?php $_from = $this->_var['top_baby']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'baby');$this->_foreach['top_baby'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['top_baby']['total'] > 0):
    foreach ($_from AS $this->_var['baby']):
        $this->_foreach['top_baby']['iteration']++;
?>
	<li class="J_Baobao">
		<div class="list-con">
		<div class="img"><a	href="baby.php?id=<?php echo $this->_var['baby']['baby_id']; ?>&ia=<?php echo $this->_var['baby']['ia_id']; ?>" target="_blank"> <img src="<?php echo $this->_var['baby']['baby_pic']; ?>" width='170' height='170'>
		</a>
		<div class="says"><span class="bg"></span> <span class="an"><i></i><b>参赛宣言:</b><?php echo $this->_var['baby']['baby_content']; ?></span>
		</div>
		<div class="tape"></div>
		<div class="tips no1"><?php echo $this->_var['baby']['top_number']; ?></div>
		</div>
		<div class="text clearfix"><span class="l"> <b><?php echo $this->_var['baby']['baby_id']; ?>号</b>&nbsp;&nbsp;<?php echo $this->_var['baby']['baby_name']; ?></span>
		<span class="r"> <b class="J_VoteNum_122239"><?php echo $this->_var['baby']['baby_number']; ?></b>票 </span></div>
		</div>
		<div class="shadow"></div>
	</li>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</ul>
</div>
</div>
</div>
<?php echo $this->fetch('starbaby/library/baby_page_footer2.lbi'); ?>
</body>
</html>