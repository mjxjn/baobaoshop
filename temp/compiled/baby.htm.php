<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $this->_var['page_title']; ?></title>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="/themes/yingge/style.css" rel="stylesheet" rev="stylesheet" type="text/css" />
<link href="/themes/yingge/head.css" rel="stylesheet" rev="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="/themes/yingge/foot.css">
<link href="/themes/yingge/starbaby/baby.css" rel="stylesheet" rev="stylesheet" type="text/css" />
<SCRIPT type=text/javascript src="/themes/yingge/js/jquery.min.js"></SCRIPT>
<SCRIPT type=text/javascript src="/themes/yingge/js/slider.js"></SCRIPT>
<SCRIPT type=text/javascript src="/themes/yingge/js/kissy.js"></SCRIPT>
<SCRIPT type=text/javascript src="/themes/yingge/js/BabyMarket.js"></SCRIPT>
<SCRIPT type=text/javascript src="/themes/yingge/js/AJBridge.js"></SCRIPT>
<SCRIPT type=text/javascript src="/themes/yingge/js/baby_pic.js"></SCRIPT>
<SCRIPT type=text/javascript src="/js/common.js"></SCRIPT>

<script type="text/javascript" src="/themes/yingge/js/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="/themes/yingge/js/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/themes/yingge/images/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

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
    
    $(".baby_btn").hover(function(){
		$(".baby_number").css("background","url(/themes/yingge/starbaby/images/babybtn_on.png) no-repeat");
    },
    function(){
            $(".baby_number").css("background","url(/themes/yingge/starbaby/images/babybtn.png) no-repeat");
    });
    
    $("a[rel=example_group]").fancybox({
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'titlePosition' 	: 'over',
		'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
			return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
		}
	});
	
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
<script type="text/javascript">   
function setCopy(content){    
    if(navigator.userAgent.toLowerCase().indexOf('ie') > -1) {    
        clipboardData.setData('Text',content);    
        alert ("该地址已经复制到剪切板");    
    } else {    
        prompt("请复制网站地址:",content);    
    }    
}  

function show_miaoshu(){
	if(<?php echo $_SESSION['user_id']; ?>==0)
	{
		alert("请登录后再投票。");
	}else{
		$("#miaoshu").show();
	}
}
function close_miaoshu(){
	$("#miaoshu").hide();
}
/*function submit_miaoshu(){
	act=$("#act").val();
	baby_id=$("#baby_id").val();
	miaoshu=$("#miaoshu_text").val();
	$.ajax({
		   type: "POST",
		   url: "baby.php",
		   data: "act="+act+"&baby_id="+baby_id+"&miaoshu="+miaoshu,
		   success: function(html){
		   	  if(html=='-1'){
					alert("描述内容过长，请修改下您的描述。");
			  }else if(html=='-2'){
				  alert("您刚刚发表过描述，30秒后您能再次发表。");
			  }else if(html=='-3'){
				  alert("描述内容包含关键字，请修改后提交。");
			  }else if(html=='-4'){
				  alert("请登录后评论。");
			  }else if(html=='-5'){
				  alert("请进入会员后台用户信息，认证EMail邮箱后投票。");
			  }else{
			      alert("谢谢您给我投出支持的一票。");
			      $("#yinxiang").append(html);
			  }
		   	close_miaoshu();
		   }
	});
	
*/
</script>
</head>
<body>
<?php echo $this->fetch('starbaby/library/baby_page_header.lbi'); ?>
<div id="baby" class="w990">
	<div class="nav_title"><span>婴格母婴商城[2013年第二届明星宝宝秀] - <?php echo $this->_var['baby_id']; ?>号参赛宝宝&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="starbaby.php" class="goback">返回宝宝达人秀首页</a></span></div>
	<div class="left baby_pic" id="wrapper">
	<?php if ($this->_var['onepic']): ?>
		<a href="<?php echo $this->_var['one_bigpic']; ?>" rel="example_group" title="<?php echo $this->_var['baby']['baby_name']; ?>"><img class="last" src="<?php echo $this->_var['one_pic']; ?>" width="382" height="382" border="0" /></a>
	<?php else: ?>

		<div id="J_Photos" class="photos slide">
            <ul class="photo-list">
            <?php $_from = $this->_var['pic']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'pic_0_00028200_1370565703');$this->_foreach['pic'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pic']['total'] > 0):
    foreach ($_from AS $this->_var['pic_0_00028200_1370565703']):
        $this->_foreach['pic']['iteration']++;
?>
            	<li class="photo" <?php if (($this->_foreach['pic']['iteration'] - 1) == 0): ?>style="display: block; position: absolute; opacity: 1; z-index: 9; "<?php else: ?>style="display: block; position: absolute; opacity: 0; z-index: 1; "<?php endif; ?>>
            	<a href="<?php echo $this->_var['pic_0_00028200_1370565703']['small']; ?>" rel="example_group" title="<?php echo $this->_var['baby']['baby_name']; ?>">
            	<img src="<?php echo $this->_var['pic_0_00028200_1370565703']['small']; ?>" height="380" width="380">
            	</a>
            	</li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				
			</ul>
	          <ul class="circle-nav-list">
	          <?php $_from = $this->_var['pic']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'pics');$this->_foreach['pics'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pics']['total'] > 0):
    foreach ($_from AS $this->_var['pics']):
        $this->_foreach['pics']['iteration']++;
?>
	          	<li class="<?php if (($this->_foreach['pics']['iteration'] - 1) == 0): ?>ks-active <?php endif; ?>"><?php echo $this->_foreach['pics']['iteration']; ?></li>
	          	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	         
	          </ul>
        </div>
	<?php endif; ?>
	</div>
	<div class="right baby_info">
		<div class="baby_name left">
			<ul>
				<li>昵称：<?php echo $this->_var['baby']['baby_name']; ?></li>
				<li>性别：<?php echo $this->_var['baby']['baby_sex']; ?></li>
				<li>宝宝生日：<?php echo $this->_var['baby']['baby_birthday']; ?></li>
				<li>所在地区：云南昆明</li>
				<li>上传者：<?php echo $this->_var['baby']['user_name']; ?></li>
				<li>上传时间：<?php echo $this->_var['baby']['baby_time']; ?></li>
				<li>宝宝人气：<script src="baby.php?act=click&id=<?php echo $this->_var['baby_id']; ?>&ia=<?php echo $this->_var['ia_id2']; ?>" type='text/javascript' language="javascript"></script></li>
			</ul>
                    
			<div class="copy_url"><a href="http://www.yinggebaby.com/starbaby/baby.php?id=<?php echo $this->_var['baby_id']; ?>&ia=<?php echo $this->_var['ia_id2']; ?>" onclick="setCopy(this.href);return false;">复制链接转发好友帮我拉票</a></div>
                    <?php if ($this->_var['enabled'] == 'true'): ?>
			<div class="baby_number"><span id="bb_number"><?php echo $this->_var['baby']['baby_number']; ?></span><a href="javascript:void();" onclick="show_Votes(<?php echo $this->_var['baby']['baby_number']; ?>,<?php echo $this->_var['baby']['baby_id']; ?>)" class="baby_btn">&nbsp;</a></div>
                    <?php else: ?>  
                    <div style="background: url(/themes/yingge/starbaby/images/unopen.png) no-repeat;width: 200px;height: 45px;line-height: 45px;margin-top: 10px;padding-left: 25px;clear: both;display: inline-block;"><span id="bb_number"><?php echo $this->_var['baby']['baby_number']; ?></span>&nbsp;</div>
                    <?php endif; ?>  
		</div>
<!--		<div class="baby_yinxiang right">
			<p class="yinxiang_title">大家对我的印象</p>
			<p class="yinxiang" id="yinxiang">
			 <?php if ($this->_var['yins']): ?> 
			<?php $_from = $this->_var['yin']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'yin_0_00151000_1370565703');$this->_foreach['yin'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['yin']['total'] > 0):
    foreach ($_from AS $this->_var['yin_0_00151000_1370565703']):
        $this->_foreach['yin']['iteration']++;
?>
			<span><?php echo $this->_var['yin_0_00151000_1370565703']; ?></span>
			 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
			 <?php endif; ?> 
			</p>
			<p class="yinxiang_sub"><a href="javascript:void();" onclick="show_miaoshu();">我要对他进行描述</a></p>
		</div> -->

                <div class="right">
                    <a href="http://www.yinggebaby.com/starbaby/register.php" target="_blank"><img src="/themes/yingge/starbaby/images/register.jpg" width="272" height="248" border="0" /></a>
                </div>

		<div class="blank"></div>
		<div class="share">
			
		    <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
		        <a class="bds_qzone"></a>
		        <a class="bds_tsina"></a>
		        <a class="bds_tqq"></a>
		        <a class="bds_tqf"></a>
		        <a class="bds_kaixin001"></a>
		        <a class="bds_renren"></a>
		        <a class="bds_douban"></a>
		        <a class="bds_baidu"></a>
		        <a class="bds_taobao"></a>
		        <a class="bds_fx"></a>
		        <a class="bds_ty"></a>
		        <a class="bds_zx"></a>
		        <span class="bds_more">更多</span>
		    </div>
			<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=19961" ></script>
			<script type="text/javascript" id="bdshell_js"></script>
			<script type="text/javascript">
				document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?t=" + new Date().getHours();
			</script>
			
		</div>
		<div class="blank"></div>
		<div class="xuanyan">
			<strong>参赛宣言：</strong><?php echo $this->_var['baby']['baby_content']; ?>
		</div>
	</div>
	<div class="blank"></div>
	<div class="baby_talk">
		<div class="baby_talktitle"></div>
	
		<div class="talk_content left">
			<?php echo $this->fetch('starbaby/library/baby_comments.lbi'); ?>
		</div>
		<div class="qqweibo">
			<iframe frameborder="0" scrolling="no" src="http://show.v.t.qq.com/index.php?c=show&a=index&n=helloyinggebaby&w=302&h=552&fl=1&l=4&o=23&co=4&cs=000066_FBC1CD_003363_F88499" width="302" height="552"></iframe>
		</div>
	</div>
<div class="miaoshu" id="miaoshu">
<p><a class="close_miaoshu" href="javascript:void();" onclick="close_miaoshu()"></a></p>
<p><strong>宝宝昵称：<?php echo $this->_var['baby']['baby_name']; ?></strong></p>
<p>用一个词对宝宝进行描述，例如：可爱、聪慧……</p>
<form name="miaoshu_form" id="miaoshu_form">
<textarea class="miaoshu_text" id="miaoshu_text" rows="" cols=""></textarea>
<input type="hidden" name="act" id="act" value="miaoshu" />
<input type="hidden" name="baby_id" id="baby_id" value="<?php echo $this->_var['baby']['baby_id']; ?>" />
<input type="button" value="提交" onclick="submit_miaoshu();" class="miaoshu_btn">
</form>
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

	//alert('网络投票活动暂时取消，修改为线下投票');

		$("#markup-vote").show("fast",function(){
				     $("#captcha_img").attr("src", "captcha.php?"+Math.random());
				   $("#number").val(number);
				   $("#baby_id").val(baby_id);
		 });

}
function Votes(){
	var baby_id=$("#baby_id").val();
	var number=$("#number").val();
	var captcha=$("#captcha").val();
	var mobile=$("#mobile").val();
	$.ajax({
		   type:"POST",
		   url: "starbaby.php",
		   data: "act=vote&baby_id="+baby_id+"&number="+number+"&captcha="+captcha+"&md5key=<?php echo $this->_var['md5key']; ?>",
		   success: function(html){
		   	  if(html=='-1'){
					//alert("您已经投票,不能够重复投票");
                                        alert("您今天已经投票给这个宝宝了,不能够再投票了");
			  }else if(html=='-2'){
					alert("投票出现问题，请刷新后在次投票");
			  }else if(html=='-3'){
					alert("验证码错误，请重新投票");
			  }else if(html=='-4'){
					alert("请登录后再投票。");
			  }else if(html=='-5'){
					if(confirm("您还没有验证邮箱，点击确定去进行验证"))
					{//如果是true ，那么就把页面转向http://www.3330777.com/user.php?act=profile
						 location.href="http://www.yinggebaby.com/user.php?act=profile";
					}
                                                                          }else if(html=='-6'){
                                                                              alert("您的投票频率太快了。请等等再投");
			  }else{
				  alert("谢谢您给我投出支持的一票");
			      $("#bb_number").empty();
			      $("#bb_number").append(html);
			  }
		   	close_Votes();
		   }
	});
}
</script>
<?php echo $this->fetch('starbaby/library/baby_page_footer2.lbi'); ?>
</body>
</html>