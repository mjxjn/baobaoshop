<link type="text/css" rel="stylesheet" href="themes/yingge/foot.css">
<style type="text/css">
.footArticle .fArt {

    width: 170px;
}
.footArticle .fArt_f {
    float: right;
    width: 284px;
}
.footArticle img{border:0px;}
</style>
<div style="height:1px; clear:both;background-color:#eee; width:100%; margin:10px 0 20px;"></div>

<div id="fd_Foot" >
<div class="scroll_qq"><img  style="CURSOR: pointer" onclick="javascript:window.open('http://b.qq.com/webc.htm?new=0&sid=800005826&eid=2188z8p8p8p8p8R8z8K8x&o=www.yingge.com&q=7&ref='+document.location, '_blank', 'height=544, width=644,toolbar=no,scrollbars=no,menubar=no,status=no');"  border="0" SRC="themes/yingge/images/scrollqq.png"></div>
<div class="scroll_div"></div> <div class="footArticle"> <div class="fArt fArt_f"><div class="AdvBanner">  <a target="_blank" href=""> <img style="" src="themes/yingge/images/foot_logo.gif"> </a>  </div> </div> 


<?php if ($this->_var['helps']): ?>
<?php $_from = $this->_var['helps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'help_cat');if (count($_from)):
    foreach ($_from AS $this->_var['help_cat']):
?>
<div class="fArt"><div class="TreeList"> <div class="cat1 catfirst"><?php echo $this->_var['help_cat']['cat_name']; ?></div> 
<?php $_from = $this->_var['help_cat']['article']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
 <div class="cat2">&middot;<a href="<?php echo $this->_var['item']['url']; ?>"><?php echo $this->_var['item']['short_title']; ?></a></div> 
 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </div></div> 
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>

 
  <div class="clear10"></div> 
 
 <div class="Foot_Help">
 <div id="widgets_81" class="siderCommonBorder "> 
 <div class="top"><h3>友情链接：</h3></div> 
 <div class="body clearfix">  <div class="LinkList"> 
<ul>
 <?php if ($this->_var['txt_links']): ?>
 <?php $_from = $this->_var['txt_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?>
 <li> <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><?php echo $this->_var['link']['name']; ?></a> </li>
 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 <?php endif; ?>
</ul>
 </div> </div> </div>
 
 <div class="clear0"></div></div>

 <div class="themefoot"><div align="right">
<table cellspacing="0" cellpadding="0" border="0" align="right" width="100%">
<tbody>
<tr>
<td style="TEXT-ALIGN: left">
<p>关注婴格: <a target="_blank" type="url" href="http://t.qq.com/helloyinggebaby" title="腾讯微博">腾讯微博</a>　<a target="_blank" type="url" href="http://weibo.com/helloyinggebaby" title="新浪微博">新浪微博</a></p>

<p>&nbsp;</p>
</td>
<td style="TEXT-ALIGN: right">
<p>&copy;&nbsp; 2011-2012 昆明婴格经贸有限公司 <?php if ($this->_var['icp_number']): ?>
  <?php echo $this->_var['icp_number']; ?> 
<script type="text/javascript" src="http://static.b.qq.com/account/bizqq/js/wpa.js?wty=0&kfuin=800005826&key=%0Ek%032Rg%063%09%3DR1TlT%3F%05cViTnU2%000%06%60V0%04c%08m%074%030"></script>
<script src="http://s13.cnzz.com/stat.php?id=3791333&web_id=3791333" language="JavaScript"></script> <script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F4e968208cd80c8cfb147e487bfb59c46' type='text/javascript'%3E%3C/script%3E"));
</script> <script type="text/javascript" src="http://tajs.qq.com/stats?sId=12792461" charset="UTF-8"></script>
<script type="text/javascript"> 
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-27441941-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>  <?php endif; ?>
 </p>
</td></tr></tbody></table></div>
</div> </div>
<center><a href="http://61.159.214.200/" target="_blank" title="云南网警报警平台"><img src="/qualification/baojing.png" ></a> <a href="http://www.yn.cyberpolice.cn:81/RecValidate/RecView.aspx?RecordID=53011203402346" target="_blank" title="云南网警ICP备案"><img src="/qualification/wangjing.png"</a> <a href="http://www.ynfybj.com/" target="_blank" title="云南优生优育保健协会"><img src="/qualification/xiehui.png" ></a> <a href="http://webscan.360.cn/index/checkwebsite/url/www.yinggebaby.com" target="_blank" title="安全放心购物网站"><img src="/qualification/360anquan.png" ></a> <a href="http://cn.unionpay.com/" target="_blank" title="银联特约商户"><img src="/qualification/unionpay.png" ></a></center>

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
        $(".scroll_qq").css("left",scroll_div_left);
    });
    reshow(scroll_div_left,show_delay);
})    
/* 回到页面顶部按钮显示 */
function reshow(marign_l,show_d) {
	$(".scroll_div").css("left",marign_l);
	$(".scroll_qq").css("left",marign_l);
	if((document.documentElement.scrollTop+document.body.scrollTop)!=0) 
	{
	    $(".scroll_div").css("display","block");
	}   
	else
	{
	    $(".scroll_div").css("display","block");  
	}
    if(show_d) window.clearTimeout(show_d) ;
    show_d=setTimeout("reshow()",500);
}

</script>