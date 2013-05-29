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
<div style="height:1px; background-color:#eee; width:100%; margin:0px 0 20px;"></div>
<div id="fd_Foot">
<div class="scroll_qq"><img  style="CURSOR: pointer" onclick="javascript:window.open('http://b.qq.com/webc.htm?new=0&sid=800005826&eid=2188z8p8p8p8p8R8z8K8x&o=www.yingge.com&q=7&ref='+document.location, '_blank', 'height=544, width=644,toolbar=no,scrollbars=no,menubar=no,status=no');"  border="0" SRC="themes/yingge/images/scrollqq.png"></div>
<div class="scroll_div"></div>
<div class="footArticle"> <div class="fArt fArt_f"><div class="AdvBanner">  <a target="_blank" href=""> <img style="" src="themes/yingge/images/foot_logo.gif"> </a>  </div> </div> 


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
 <table><tbody>
 <tr> 
 <?php if ($this->_var['txt_links']): ?>
 <?php $_from = $this->_var['txt_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?>
 <td> <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><?php echo $this->_var['link']['name']; ?></a> </td>
 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 <?php endif; ?>
 </tr></tbody></table> 
 </div> </div> </div>
 
 <div class="clear0"></div></div>

 <div class="themefoot"><div align="right">
<table cellspacing="0" cellpadding="0" border="0" align="right" width="100%">
<tbody>
<tr>
<td style="TEXT-ALIGN: left">
<p>关注婴格: <a target="_blank" type="url" href="http://weibo.com/yinggebaby" title="新浪微博">新浪微博</a>　<a target="_blank" type="url" href="http://t.qq.com/helloyinggebaby" title="腾讯微博">腾讯微博</a></p>

<p>&nbsp;</p>
</td>
<td style="TEXT-ALIGN: right">
<p>&copy;&nbsp; 2011 昆明婴格经贸有限公司 <?php if ($this->_var['icp_number']): ?>
  <?php echo $this->_var['icp_number']; ?> <script src="http://s13.cnzz.com/stat.php?id=3791333&web_id=3791333" language="JavaScript"></script> <script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F82ae7ba41caa7513c5b2119a551bad65' type='text/javascript'%3E%3C/script%3E"));
</script>
  <?php endif; ?>
 </p>
</td></tr></tbody></table></div>
</div> </div>
<center><img src="/qualification/baojing.png" > <img src="/qualification/yingyezhizhao.png" > <img src="/qualification/xiehui.png" > <img src="/qualification/360anquan.png" ></center>

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