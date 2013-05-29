<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/html/login_auntion.css" rel="stylesheet" type="text/css" />
<link href="/html/login.css" rel="stylesheet" type="text/css" />
<link href="/html/head.css" rel="stylesheet" rev="stylesheet" type="text/css" />
<script type="text/javascript" src="/html/js/jquery.min.js"></script>
<script language="javascript">
function subCheck()  
{  
	if(event.keyCode==13)  
	{
		document.formLogin.submit(); 
	}  
}  
</script>
<title>婴格会员登录</title>
</head>
<body>

<?php echo $this->fetch('/library/page_top.lbi'); ?>
 
 <div class="login_page">
    <div style="text-align:center; background-image:none;" class="l_pic">
         <img border="0" class="mt15 ml15" usemap="#Map" src="/html/images/login_bg.gif">
         <map name="Map" id="Map">
           <area shape="rect" coords="13,4,162,74" href="index.php" />
         </map>
	   <div style="height:25px; overflow:hidden; margin-top:10px; font-size:15px; color:#555;" id="nav_today">
		<ul class="clearfix">
			
		</ul>
		<ul class="clearfix">
			
		</ul>
	
		<ul class="clearfix">
			
		</ul><ul class="clearfix">
			
		</ul><ul class="clearfix">
			
		</ul></div>
    </div>
    
    <div class="l_box">
    <form  action="user.php" method="post" enctype="multipart/form-data" name="formLogin" id="login_box" onkeydown="subCheck();">

    <input type="hidden" value="" name="fromurl" id="fromurl">

        <dl>
            <dt class="tit"><strong>会员登录</strong></dt>
						<dd id="error_tip" class="error mb10"><p class="clearfix"><i></i><span id="error"></span></p></dd>
			            <dd class="clearfix mb10">
                <em class="lab">账&nbsp; 号</em>
                <span class="at_text t_1_d">
                    <input type="text" onblur="if(this.value==''||this.value=='用户名/手机/邮箱') this.value='用户名/手机/邮箱'" onfocus="if(this.value=='用户名/手机/邮箱') this.value=''" value="用户名/手机/邮箱" name="username" id="user_name">
                </span>
            </dd>
        <dd id="zbj_pasd_div" class="clearfix">
            <em class="lab">密&nbsp; 码</em>
            <span class="at_text t_1_d mb5"> <input type="password" maxlength="24" value="" name="password" id="user_pas"></span>
        </dd>        
       
		<dd class="mt5">
		<p class="tips gray3">
			<label style="width:110px;" class="clearfix fl" for="auto_login"><em class="auto_login">
			 <input type="checkbox" id="auto_login" value="1" name="cache"></em>一周内自动登录</label>
			<em class="orange1 safe">为了账户安全，请勿在公用电脑上勾选此项</em><img title="点击查看登录帮助" onclick="showHelp()" style="cursor:pointer; margin-top:3px;" class="ml5 fl" src="themes/yingge/images/help.png">
		</p>
		</dd>
        <dd class="clearfix mt10">
        <input type="hidden" name="act" value="act_login" />
            <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
         
            
          
            <em class="lab"></em>
            <a id="l_sub" class="at_but b_1_y" href="#" ><u></u>登录</a> &nbsp;
            <a class="gray3" target="_blank" href="user.php?act=get_password">忘记密码？</a>&nbsp;<a target="_blank" href="user.php?act=register">立即注册</a>
        </dd>
        </dl>
        
        <p class="heZuoDengL-t">使用合作网站账号登录</p>
        <p class="heZuoDengL">
            <a class="QQ" href="/app/redirect/act/qq">QQ</a>
            <a class="xinL" href="/app/redirect/act/sina">新浪微博</a>
            <a class="wangY" href="/redirect/t163">网易</a>
            <a class="renR" href="/app/redirect/act/renren">人人网</a>
            <a class="taoB" href="/app/redirect/act/taobao">淘宝网</a>
        </p>
    <style type="text/css">
        .heZuoDengL-t{padding:0 22px; background:url("images/login_box1.png") no-repeat scroll -553px top transparent; padding-top:14px;}
        .heZuoDengL{padding:0 0 0 22px; background:url("images/login_box1.png") no-repeat scroll -553px bottom transparent; padding-bottom:20px;margin-top: 4px;}
        .heZuoDengL a{background:url(" ../images/fenxiang.gif?v=2") no-repeat 2px 2px; height:16px; display:inline-block; padding:3px 3px 3px 13px; margin-right: 4px; overflow:hidden;}
        .heZuoDengL a:hover {border:1px solid #CCC; padding:2px 2px 2px 12px; text-decoration:none; border-radius:2px;}
        .heZuoDengL a.QQ{background-position:2px -252px;}
        .heZuoDengL a.wangY{background-position:2px -58px;}
        .heZuoDengL a.renR{background-position:2px -232px;}
        .heZuoDengL a.kaiX{background-position:2px -78px;}
        .heZuoDengL a.taoB{background-position:0 -272px;}
        
    </style>
	
    </form>
    </div>

    <div class="clear"></div>
	<div class="footer">
    <p class="reView"><s></s>我对婴格商城有意见或建议，<a href="#" target="_blank">跟婴格商城说说。</a></p>
    <p>
    <a target="_blank" href="#">关于我们</a>|
    <a target="_blank" href="#">支付方式</a>|
    <a target="_blank" href="#">联系方式</a>|
	<a target="_blank" href="#">媒体中心</a>|
    <a target="_blank" href="#">客服中心</a>|
    <a target="_blank" href="#">网站地图</a>
    </p>
    <p class="copyright">Copyright 2011 婴格经贸有限公司 版权所有 渝ICP备10202274号</p>
</div>

<script type="text/javascript">    
$(document).ready(function(){
	var errorTip = $("#error_tip");
	function judge(){
		var user_name = $("#user_name");
		var user_pas = $("#user_pas");
		if(user_name.val()==''||user_name.val()=='用户名/手机/邮箱'){
			errorTip.show().find("p").html("<i></i>用户名不能为空!");
			user_name.focus();
			return false;
		}
		if(user_pas.val()==''){
			errorTip.show().find("p").html("<i></i>密码不能为空!");
			user_pas.focus();
			return false;
		}
	}
	
	$("#l_sub").click(function(){
		$("#login_box").submit();
		});
		
	$("#login_box").submit(function(){
		
		 if( judge()==false ){
            //error_box.show(100);
			return false;
        } else {
		  $("#l_sub").addClass("l_sub_hover").html('<u></u>加载中');
		}
		
		})	

})

</script>
   
</div>
</body>
</html>
