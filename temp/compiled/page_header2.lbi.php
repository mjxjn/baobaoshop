<link href="themes/yingge/page_header2.css" rel="stylesheet" rev="stylesheet" type="text/css" />
<div id="yg-nav" class="w970">
	<div class="left nav_jylist" id="nav_jylist">
    	<p id="jy_vois" class="jy_ti"><span class="fl2">全部商品分类</span></p>
        <ol style="display:none;" id="jy_list" class="nav_jyc">
			<?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['categories'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categories']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['categories']['iteration']++;
?>
			<li class="top">
            <h2><u class="n<?php echo ($this->_foreach['categories']['iteration'] - 1); ?>"><a href="<?php echo $this->_var['cat']['url']; ?>"><?php echo htmlspecialchars($this->_var['cat']['name']); ?></a></u></h2>
            <em></em>
            <dl class="submenu" style="display: none;">
                <dt>
                    <strong>选择分类</strong>
                    <p class="walink">
                    <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');if (count($_from)):
    foreach ($_from AS $this->_var['child']):
?>
                                <a href="<?php echo $this->_var['child']['url']; ?>"><?php echo htmlspecialchars($this->_var['child']['name']); ?> </a>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                    </p>
                </dt>
                <dt>
                    <strong>推荐产品</strong>
                    <p class="walink">
                                <a href="/brand-222-c0.html">美赞臣</a>
                                <a href="/brand-74-c0.html">多美滋</a>
                                <a href="/brand-102-c0.html">惠氏</a>
                                <a href="/brand-92-c0.html">合生元</a>
                                <a href="/brand-95-c0.html">花王</a>
                                <a href="/brand-68-c0.html">大王</a>
                                <a href="/brand-89-c0.html">好奇</a>
                                <a href="/brand-63-c0.html">贝亲</a>
                                <a href="/brand-115-c0.html">康贝</a>
                                <a href="/brand-22-c0.html">bobo</a>
                                <a href="/brand-202-c0.html">新安怡</a>
                                <a href="/brand-227-c0.html">培宝康</a>
                                <a href="/brand-219-c0.html">智灵通</a>
                                <a href="/brand-160-c0.html">生命阳光</a>
                                <a href="/brand-111-c0.html">金奇仕</a>
                                <a href="/brand-188-c0.html">味奇</a>
                                <a href="/brand-94-c0.html">亨氏</a>
                                <a href="/brand-67-c0.html">布朗博士</a>
                    </p>
                </dt>
            </dl>
            </li>
           <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>  
            <li class="bom">
                <u class="n80"><a href="map.php">全部交易分类&gt;&gt;</a></u>
            </li>
    </ol>
    </div>
    <div class="right" id="nav_indx">
    	<div class="right gz">

<script type="text/javascript" src="http://static.b.qq.com/account/bizqq/js/wpa.js?wty=1&type=2&kfuin=800005826&ws=www.yinggebaby.com&btn1=%E5%9C%A8%E7%BA%BFQQ%E4%BA%A4%E8%B0%88&aty=0&a=&key=%01d%010Pe%0F%3A%004%07dPhT%3FX%3E%03%3CTnQ6Rb%04bS5P7%0DhS%60%021"></script>

		</div>
        <div class="right ud_nav_today">
        	<a id="nav_today_up" class="ud_up" href="#"></a>
			<a id="nav_today_down" class="ud_down" href="#"></a>
        </div>
        <div id="nav_today" class="right nav_gonggao">
        	<?php echo $this->_var['shop_notice']; ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<script type="Text/Javascript" language="JavaScript">


$(document).ready(function(){
$("#nav_jylist").hover(
				function () {
				$(".nav_jyc").css("display","block");
				},
				function () {
				$(".nav_jyc").css("display","none");
				}
);
});
/*导行滚动，上下，今日，本月*/
(function(){
var nav_today=$("#nav_today"),
nav_today_up=$("#nav_today_up"),
nav_today_down=$("#nav_today_down"),
ul=nav_today.find("ul");
ul_h=nav_today.height();
nav_today.append(ul.clone());
var n=0;
var ul_size=ul.size();
function start()
{
scrollUp();
if(n==ul_size)
{
nav_today.scrollTop(0);
n=0;
}
}
var timer=window.setInterval(function(){
start();
},2000);
function stop()
{
clearInterval(timer);
}
function restart()
{
timer=window.setInterval(function(){
start();
},2000);
}
//向上卷动一个ul
function scrollUp(){
if(nav_today.is(":animated")){return false;}
nav_today.animate({scrollTop:nav_today.scrollTop()+ul_h},"normal",function(){
n++;
if(n==ul_size){
nav_today.scrollTop(0);
n=0;
}
}
);
}
//向下卷动一个ul
function scrollDown(){
if(nav_today.is(":animated")){return false;}
nav_today.animate({scrollTop:nav_today.scrollTop()-ul_h},"normal",function(){
n--;
if(n==0){
n=ul_size;
nav_today.scrollTop(ul_h*ul_size);
};
}
);
}
nav_today.mouseover(function(){
stop();
}).mouseout(function(){
restart();
})
nav_today_up.click(function(){
if(n==0){
n=ul_size;
nav_today.scrollTop(ul_h*ul_size);
}
scrollDown();
return false;
});
nav_today_down.click(function(){
if(n==ul_size)
{
n=0;
nav_today.scrollTop(0);
}
scrollUp();
return false;
});
})();

/*下拉分类*/
(function() {
var jy_v=$("#jy_vois");
var jy_b=$("#jy_vois b");
var jy_c=$("#jy_list");
var jy_li=$("#jy_list li");
var jy_dl=$("#jy_list li dl");
jy_c.hide();
jy_b.addClass("ja");
jy_v.hover(function(){
jy_v.addClass("jy_ti_hover");
},function(){
jy_v.removeClass("jy_ti_hover");
})
jy_li.hover(function(){
var lis=jy_li.index(this);
jy_li.eq(lis).addClass("select");
jy_dl.eq(lis).show();
},function(){
$(this).removeClass("select");
jy_dl.hide();
});
})();
 

</script>