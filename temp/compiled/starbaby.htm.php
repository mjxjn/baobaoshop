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
<link href="/themes/yingge/starbaby/starbaby.css" rel="stylesheet" rev="stylesheet" type="text/css" />
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
		所有参赛宝宝
	</div>
	<div id="filter" class="w990">
		<ul class="filter_ul">
			<li class="fli on left"><a href="starbaby.php">本期所有参赛宝宝</a></li>
			<li class="left"><a href="starbaby_old.php">往期所有参赛宝宝</a></li>
			<li class="right"><a target="_blank" href="register.php">报名参加</a></li>
		</ul>
		<div class="search-box">
				<form action="starbaby.php" method="POST" id="J_BBSeachForm">
    				<span class="icon"></span>
    				<span class="text">您要搜索的宝宝编号为：</span>
    				<input class="input" type="text" name="key" id="J_BB_Search">
					<input class="hidden" type="text" name="ia_id" value="<?php echo $this->_var['ia_id']; ?>">
    				<input href="#" type="submit" class="submit">
				</form>
		</div>

<div class="filter-bd">
<div class="selection">
<h4>&nbsp;</h4>
<img src="/themes/yingge/starbaby/images/starbaby_liucheng.gif">
<div class="filter-ft">
	<span style="color:#f78499">明星宝宝秀筛选</span>&nbsp;&nbsp;共有&nbsp;<span style="color:#f78499"><?php echo $this->_var['sum']; ?></span>&nbsp;位宝宝参赛
	<br />
	排序：默认是按照宝宝投票数排序。
	<div class="sort">
      <a href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>" class="by-id <?php if ($this->_var['sort1'] == 'baby_id'): ?>active <?php endif; ?> by-id-active">序号</a>
	  <a href="starbaby.php?sort1=baby_number&sort2=<?php echo $this->_var['sort2']; ?>" class="by-vote <?php if ($this->_var['sort1'] == 'baby_number'): ?>active <?php endif; ?> ">投票数</a>							
   	</div>
   	<div class="sort">
      <a href="starbaby.php?sort1=<?php echo $this->_var['sort1']; ?>&sort2=baby_boy" class="by-id <?php if ($this->_var['sort2'] == 'baby_boy'): ?>active <?php endif; ?> by-id-active">男宝宝</a>
	  <a href="starbaby.php?sort1=<?php echo $this->_var['sort1']; ?>&sort2=baby_girl" class="by-vote <?php if ($this->_var['sort2'] == 'baby_girl'): ?>active <?php endif; ?>">女宝宝</a>
	  <a href="starbaby.php?sort1=<?php echo $this->_var['sort1']; ?>&sort2=baby_all" class="by-vote <?php if ($this->_var['sort2'] == 'baby_all'): ?>active <?php endif; ?>">全部</a>							
   	</div>
</div>
</div>
<div class="selection astro">
<h4>星座</h4>
<ol class="J_Hover">

	<li><a class="<?php if ($this->_var['xz'] == '1'): ?>active <?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=1&sx=<?php echo $this->_var['sx']; ?>">白羊座
	(3.21-4.19)</a></li>

	<li><a class="<?php if ($this->_var['xz'] == '2'): ?>active <?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=2&sx=<?php echo $this->_var['sx']; ?>">金牛座
	(4.20-5.20)</a></li>

	<li><a class="<?php if ($this->_var['xz'] == '3'): ?>active <?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=3&sx=<?php echo $this->_var['sx']; ?>">双子座
	(5.21-6.21)</a></li>

	<li><a class="<?php if ($this->_var['xz'] == '4'): ?>active <?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=4&sx=<?php echo $this->_var['sx']; ?>">巨蟹座
	(6.22-7.22)</a></li>

	<li><a class="<?php if ($this->_var['xz'] == '5'): ?>active <?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=5&sx=<?php echo $this->_var['sx']; ?>">狮子座
	(7.23-8.22)</a></li>

	<li><a class="<?php if ($this->_var['xz'] == '6'): ?>active <?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=6&sx=<?php echo $this->_var['sx']; ?>">处女座
	(8.23-9.22)</a></li>

	<li><a class="<?php if ($this->_var['xz'] == '7'): ?>active <?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=7&sx=<?php echo $this->_var['sx']; ?>">天秤座
	(9.23-10.23)</a></li>

	<li><a class="<?php if ($this->_var['xz'] == '8'): ?>active <?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=8&sx=<?php echo $this->_var['sx']; ?>">天蝎座
	(10.24-11.22)</a></li>

	<li><a class="<?php if ($this->_var['xz'] == '9'): ?>active <?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=9&sx=<?php echo $this->_var['sx']; ?>">射手座
	(11.23-12.21)</a></li>

	<li><a class="<?php if ($this->_var['xz'] == '10'): ?>active <?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=10&sx=<?php echo $this->_var['sx']; ?>">魔羯座
	(12.22-1.19)</a></li>

	<li><a class="<?php if ($this->_var['xz'] == '11'): ?>active <?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=11&sx=<?php echo $this->_var['sx']; ?>">水瓶座
	(1.20-2.18)</a></li>

	<li><a class="<?php if ($this->_var['xz'] == '12'): ?>active <?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=12&sx=<?php echo $this->_var['sx']; ?>">双鱼座
	(2.19-3.20)</a></li>
</ol>
</div>
<div class="selection shengxiao">
<h4>生肖</h4>
<ol class="J_Hover">

	<li><a class="sx-1 <?php if ($this->_var['sx'] == '1'): ?>sx-1-active<?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=<?php echo $this->_var['xz']; ?>&sx=1">鼠</a></li>

	<li><a class="sx-2 <?php if ($this->_var['sx'] == '2'): ?>sx-2-active<?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=<?php echo $this->_var['xz']; ?>&sx=2">牛</a></li>

	<li><a class="sx-3 <?php if ($this->_var['sx'] == '3'): ?>sx-3-active<?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=<?php echo $this->_var['xz']; ?>&sx=3">虎</a></li>

	<li><a class="sx-4 <?php if ($this->_var['sx'] == '4'): ?>sx-4-active<?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=<?php echo $this->_var['xz']; ?>&sx=4">兔</a></li>

	<li><a class="sx-5 <?php if ($this->_var['sx'] == '5'): ?>sx-5-active<?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=<?php echo $this->_var['xz']; ?>&sx=5">龙</a></li>

	<li><a class="sx-6 <?php if ($this->_var['sx'] == '6'): ?>sx-6-active<?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=<?php echo $this->_var['xz']; ?>&sx=6">蛇</a></li>

	<li><a class="sx-7 <?php if ($this->_var['sx'] == '7'): ?>sx-7-active<?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=<?php echo $this->_var['xz']; ?>&sx=7">马</a></li>

	<li><a class="sx-8 <?php if ($this->_var['sx'] == '8'): ?>sx-8-active<?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=<?php echo $this->_var['xz']; ?>&sx=8">羊</a></li>

	<li><a class="sx-9 <?php if ($this->_var['sx'] == '9'): ?>sx-9-active<?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=<?php echo $this->_var['xz']; ?>&sx=9">猴</a></li>

	<li><a class="sx-10 <?php if ($this->_var['sx'] == '10'): ?>sx-10-active<?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=<?php echo $this->_var['xz']; ?>&sx=10">鸡</a></li>

	<li><a class="sx-11 <?php if ($this->_var['sx'] == '11'): ?>sx-11-active<?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=<?php echo $this->_var['xz']; ?>&sx=11">狗</a></li>

	<li><a class="sx-12 <?php if ($this->_var['sx'] == '12'): ?>sx-12-active<?php endif; ?>"
		href="starbaby.php?sort1=baby_id&sort2=<?php echo $this->_var['sort2']; ?>&xz=<?php echo $this->_var['xz']; ?>&sx=12">猪</a></li>
</ol>
</div>
</div>
	</div>
	<div class="box pics-list among">
		<div class="bd">
			<ul class="baobaos clearfix">
			<?php $_from = $this->_var['baby']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'baby_0_04726300_1369190805');$this->_foreach['baby'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['baby']['total'] > 0):
    foreach ($_from AS $this->_var['baby_0_04726300_1369190805']):
        $this->_foreach['baby']['iteration']++;
?>
				 <li class="J_Baobao">
                        <div class="list-con">
                            <div class="img">
                            <a href="baby.php?id=<?php echo $this->_var['baby_0_04726300_1369190805']['baby_id']; ?>&ia=<?php echo $this->_var['baby_0_04726300_1369190805']['ia_id']; ?>" target="_blank"><img src="<?php echo $this->_var['baby_0_04726300_1369190805']['baby_pic']; ?>" width="170" height="170"></a>
                                <div class="says">
                                    <span class="bg"></span>
                                    <span class="an"><i></i><b>参赛宣言:</b><?php echo $this->_var['baby_0_04726300_1369190805']['baby_content']; ?></span>
                                </div>
                                <div class="tape"></div>
                            </div>
                            <div class="text clearfix">
                               <span class="l">
                               		<b><?php echo $this->_var['baby_0_04726300_1369190805']['baby_id']; ?>号</b>&nbsp;&nbsp;<?php echo $this->_var['baby_0_04726300_1369190805']['baby_name']; ?>
                               	</span>
								<span class="r">
									<b class="J_VoteNum_<?php echo $this->_var['baby_0_04726300_1369190805']['baby_id']; ?>"><?php echo $this->_var['baby_0_04726300_1369190805']['baby_number']; ?></b>票
								</span>
                            </div>
							<div class="baobao-btn">
                                                            <?php if ($this->_var['enabled'] == true): ?>
							<a href="javascript:void();" onclick="show_Votes(<?php echo $this->_var['baby_0_04726300_1369190805']['baby_number']; ?>,<?php echo $this->_var['baby_0_04726300_1369190805']['baby_id']; ?>)" class="J_Votes vote-btn">投票</a><?php endif; ?>																						 									                            </div>
                        </div>
                        <div class="shadow"></div>
                  </li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>		                    
		    </ul>
		</div>
		
		
		<?php echo $this->fetch('starbaby/library/baby_pages.lbi'); ?>
	</div>
</div>
<div id="markup-vote" class="baobao-popup-window vote ks-overlay ks-ext-position" style="z-index: 9999; left: 514.5px; top: 207.5px; visibility: visible; position: fixed;">
<div class="ks-contentbox ">
<div class="baobao-popup-window-wrapper">
<div class="hd">
<h3></h3>
<a class="J_BP_Hide closeButton" href="javascript:void();" onclick="close_Votes();" title="关闭" tabindex="0"></a>
</div>
<div class="bd">
<div class="J_BP_Infos infos clearfix">
<div class="text">
<img src="" width="100" height="21" id="captcha_img" alt="CAPTCHA" border="1" onclick= this.src="captcha.php?"+Math.random() style="cursor: pointer;margin:0 0 10px 0;vertical-align:middle;" />&nbsp;&nbsp;<a href="javascript:void();" style=" color:#333;" onclick="changer_captcha_img()">更换验证码</a><br />
验证码：
<input type="text" name="captcha" id="captcha" value="" style="border:1px solid #999; height:25px; line-height:25px;"/>
<input type="hidden" name="number" id="number" value="">
<input type="hidden" name="baby_id" id="baby_id" value="">
</div>
</div>
<div class="vote-buttons clearfix">
<a href="javascript:void();" class="J_BP_Hide ok" onclick="Votes()">确定</a>
</div>
</div>
</div>
</div>
<a tabindex="0" href='javascript:void("关闭")' role="button" class="ks-ext-close" style="display: none; ">
<span class="ks-ext-close-x">关闭</span>
</a>
</div>
<script type="text/javascript">
function changer_captcha_img(){
	$("#captcha_img").attr("src", "captcha.php?"+Math.random());
}
function close_Votes(){
	$("#markup-vote").hide();
}
function show_Votes(number,baby_id){
//	if(<?php echo $_SESSION['user_id']; ?>==0)
//	{
//		alert("请登录后再投票。");
//	}else{
		$("#markup-vote").show("fast",function(){
				   $("#captcha_img").attr("src", "captcha.php?"+Math.random());
				   $("#number").val(number);
				   $("#baby_id").val(baby_id);
		 });
//	 }
}
function Votes(){
	var baby_id=$("#baby_id").val();
	var number=$("#number").val();
	var captcha=$("#captcha").val();
	$.ajax({
		   type:"POST",
		   url: "starbaby.php",
		   data: "act=vote&baby_id="+baby_id+"&number="+number+"&captcha="+captcha+"&md5key=<?php echo $this->_var['md5key']; ?>",
		   success: function(html){
		   	  if(html=='-1'){
					//alert("您已经投票,不能够重复投票");
                                        alert("您今天的投票数到达最大数,不能够再投票了");
			  }else if(html=='-2'){
					alert("投票出现问题，请刷新后在次投票");
			  }else if(html=='-3'){
					alert("验证码错误，请重新投票");
			  }else if(html=='-4'){
					alert("请登录后再投票。");
			  }else if(html=='-5'){
					if(confirm("您还没有验证邮箱，点击确定去进行验证"))
					{//如果是true ，那么就把页面转向http://www.3330777.com/user.php?act=profile
						 location.href="http://www.3330777.com/user.php?act=profile";
					}
			  }else{
				  alert("谢谢您给我投出支持的一票");
			      $(".J_VoteNum_"+baby_id).empty();
			      $(".J_VoteNum_"+baby_id).append(html);
			  }
		   	close_Votes();
		   }
	});
}
</script>
<?php echo $this->fetch('starbaby/library/baby_page_footer2.lbi'); ?>
</body>
</html>