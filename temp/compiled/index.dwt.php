<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<link rel="alternate" type="application/rss+xml" title="RSS|<?php echo $this->_var['page_title']; ?>" href="<?php echo $this->_var['feed_url']; ?>" />

<link href="themes/yingge/style.css" rel="stylesheet" rev="stylesheet" type="text/css" />
<link href="themes/yingge/head.css" rel="stylesheet" rev="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="themes/yingge/foot.css">
<link href="themes/yingge/index.css" rel="stylesheet" rev="stylesheet" type="text/css" />
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="themes/yingge/ie6.css"/>
<![endif]--><!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="themes/yingge/ie7.css"/>
<![endif]--><!--[if IE 8]><LINK rel=stylesheet type=text/css 
href="themes/yingge/ie8.css"><![endif]-->
<LINK rel=stylesheet type=text/css href="themes/yingge/ie8.css">
<?php $_from = $this->_var['ad_bg_i']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ad');$this->_foreach['ad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ad']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['ad']):
        $this->_foreach['ad']['iteration']++;
?>
<?php if ($this->_foreach['ad']['iteration'] == 1): ?>
	<style type="text/css">
		body{
		background:url(<?php echo $this->_var['ad']['content']; ?>);
		background-color: <?php echo $this->_var['ad']['url']; ?>;
		background-repeat: repeat-x;
		background-position: center 172px;
		}
	</style>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<SCRIPT type=text/javascript src="themes/yingge/js/jquery.min.js"></SCRIPT>
<script type="text/javascript">

$(document).ready(function(){
	
	$("#advbanner").slideDown("slow");
	setTimeout("displayimg()",10000);	
})
 function displayimg(){
	$("#advbanner").slideUp(1000,function(){
		$("#advtop").slideDown(1000);
	})
  }
  
</script>

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,index.js')); ?>
</head>
<body>
<?php echo $this->fetch('library/page_header_index1.lbi'); ?>
<div id="body" style="width:987px; margin:0 auto;background: white;">
<div id="yg-nav" class="w973">
	<div class="left nav_jylist" id="nav_jylist">
    	<p id="jy_vois" class="jy_ti"><span class="fl2">全部商品分类</span></p>
        <?php echo $this->fetch('library/index_category_tree.lbi'); ?>
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
<div class="blank9"></div>

<div id="flash_ad" class="w973">
	<div id="flash_login">
    	<div class="login_ad right">
    		<div class="userlogin">
		        <?php echo $this->fetch('library/index_user_center.lbi'); ?>
		        <div class="blank9"></div>
		        <div class="userloginurl">
		        	<a href="" style="color:#3bb3cb;">新手购物指南</a><a href="" style="margin-left: 48px;color:#f52c7c;">积分获取方式</a>
		        </div>
		        <div class="blank9"></div>
		        <div class="userlogintel">咨询电话：0871-68082929</div>
        	</div>
            <div class="blank9"></div>
            <div class="commitment" id="commitment">
            	<img src="/themes/yingge/images/commitment.gif" width="252" height="94" />
            </div>
        </div>
    	<div class="flash_index right">
<script type="text/javascript">
$(function() {
	var sWidth = $("#focus").width(); //获取焦点图的宽度（显示面积）
	var len = $("#focus ul li").length; //获取焦点图个数
	var index = 0;
	var picTimer;
	
	//以下代码添加数字按钮和按钮后的半透明条，还有上一页、下一页两个按钮
	var btn = "<div class='btnBg'></div><div class='btn'>";
	for(var i=0; i < len; i++) {
		btn += "<span></span>";
	}
	
	$("#focus").append(btn);
	$("#focus .btnBg").css("opacity",0.5);

	//为小按钮添加鼠标滑入事件，以显示相应的内容
	$("#focus .btn span").css("opacity",0.4).mouseenter(function() {
		index = $("#focus .btn span").index(this);
		showPics(index);
	}).eq(0).trigger("mouseenter");

	//本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
	$("#focus ul").css("width",sWidth * (len));
	
	//鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
	$("#focus").hover(function() {
		clearInterval(picTimer);
	},function() {
		picTimer = setInterval(function() {
			showPics(index);
			index++;
			if(index == len) {index = 0;}
		},4000); //此4000代表自动播放的间隔，单位：毫秒
	}).trigger("mouseleave");
	
	//显示图片函数，根据接收的index值显示相应的内容
	function showPics(index) { //普通切换
		var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
		$("#focus ul").stop(true,false).animate({"left":nowLeft},300); //通过animate()调整ul元素滚动到计算出的position
		//$("#focus .btn span").removeClass("on").eq(index).addClass("on"); //为当前的按钮切换到选中的效果
		$("#focus .btn span").stop(true,false).animate({"opacity":"0.4"},300).eq(index).stop(true,false).animate({"opacity":"1"},300); //为当前的按钮切换到选中的效果
	}
});

</script>

<div id="focus">
		<ul>
		<?php $_from = $this->_var['playerdb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'flay');$this->_foreach['playerdb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['playerdb']['total'] > 0):
    foreach ($_from AS $this->_var['flay']):
        $this->_foreach['playerdb']['iteration']++;
?>
			<li>
				<a href="<?php echo $this->_var['flay']['url']; ?>"><img src="<?php echo $this->_var['flay']['src']; ?>" width="523" height="285" alt="<?php echo $this->_var['flay']['text']; ?>" /></a>
			</li>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
</div>  
		  
        </div>
    </div>
    <div class="blank9"></div>
    <div id="zhinan-box" class="three_ad">
        <div>
        <?php $_from = $this->_var['ad_index_i']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ad');$this->_foreach['ad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ad']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['ad']):
        $this->_foreach['ad']['iteration']++;
?>
		<?php if ($this->_foreach['ad']['iteration'] == 1): ?>
			<a href="<?php echo $this->_var['ad']['url']; ?>"><img src='<?php echo $this->_var['ad']['content']; ?>' width="784" height="74" /></a>
		<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <div class="clear"></div>
    	</div>
    </div>
    <div class="blank9"></div>
    
</div>
<div class="blank9"></div>
<div id="body_index" class="w973">
	<div class="new_one">
		<div class="tuijian left">
			<ul>
				<li><a onmouseover="setTab('one',1,4);" id="one1" class="hover">新品推荐</a></li>
				<li><a onmouseover="setTab('one',2,4);" id="one2" class="">畅销商品</a></li>
				<li><a onmouseover="setTab('one',3,4);" id="one3" class="">促销商品</a></li>
				<li><a onmouseover="setTab('one',4,4);" id="one4" class="">猜您喜欢</a></li>
			</ul>
			<div id="con_one_1" class="show_cur" style="display:block">
				<dl>
					<?php $_from = $this->_var['best_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'best_goods_0_41277300_1368867339');$this->_foreach['best_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['best_goods']['total'] > 0):
    foreach ($_from AS $this->_var['best_goods_0_41277300_1368867339']):
        $this->_foreach['best_goods']['iteration']++;
?>
					<dd>
					<p style="display:block; padding-bottom:10px;"><a href="<?php echo $this->_var['best_goods_0_41277300_1368867339']['url']; ?>"><img src="<?php echo $this->_var['best_goods_0_41277300_1368867339']['thumb']; ?>" width="145" height="145" border="0" /></a></p>
					<p><a href="<?php echo $this->_var['best_goods_0_41277300_1368867339']['url']; ?>"><?php echo $this->_var['best_goods_0_41277300_1368867339']['name']; ?></a></p>
					<p>婴格价：<font style="color:#e71f19;"><?php echo $this->_var['best_goods_0_41277300_1368867339']['shop_price']; ?></font></p>
					</dd>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</dl>
			</div>
			<div id="con_one_2" class="show_cur" style="display:none">
				<dl>
					<?php $_from = $this->_var['hot_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'hot_goods_0_41313100_1368867339');$this->_foreach['hot_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['hot_goods']['total'] > 0):
    foreach ($_from AS $this->_var['hot_goods_0_41313100_1368867339']):
        $this->_foreach['hot_goods']['iteration']++;
?>
					<dd>
					<p style="display:block; padding-bottom:10px;"><a href="<?php echo $this->_var['hot_goods_0_41313100_1368867339']['url']; ?>"><img src="<?php echo $this->_var['hot_goods_0_41313100_1368867339']['thumb']; ?>" width="145" height="145" border="0" /></a></p>
					<p><a href="<?php echo $this->_var['hot_goods_0_41313100_1368867339']['url']; ?>"><?php echo $this->_var['hot_goods_0_41313100_1368867339']['name']; ?></a></p>
					<p>婴格价：<font style="color:#e71f19;"><?php echo $this->_var['hot_goods_0_41313100_1368867339']['shop_price']; ?></font></p>
					</dd>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</dl>
			</div>
			<div id="con_one_3" class="show_cur" style="display:none">
				<dl>
					<?php $_from = $this->_var['promotion_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'promotion_goods_0_41349000_1368867339');$this->_foreach['promotion_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['promotion_goods']['total'] > 0):
    foreach ($_from AS $this->_var['promotion_goods_0_41349000_1368867339']):
        $this->_foreach['promotion_goods']['iteration']++;
?>
					<dd>
					<p style="display:block; padding-bottom:10px;"><a href="<?php echo $this->_var['promotion_goods_0_41349000_1368867339']['url']; ?>"><img src="<?php echo $this->_var['promotion_goods_0_41349000_1368867339']['thumb']; ?>" width="145" height="145" border="0" /></a></p>
					<p><a href="<?php echo $this->_var['promotion_goods_0_41349000_1368867339']['url']; ?>"><?php echo $this->_var['promotion_goods_0_41349000_1368867339']['name']; ?></a></p>
					<p>婴格价：<font style="color:#e71f19;"><?php echo $this->_var['promotion_goods_0_41349000_1368867339']['promote_price']; ?></font></p>
					</dd>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</dl>
			</div>
			<div id="con_one_4" class="show_cur" style="display:none">
				<dl>
					<?php $_from = $this->_var['rand_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'rand_goods_0_41380700_1368867339');$this->_foreach['rand_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['rand_goods']['total'] > 0):
    foreach ($_from AS $this->_var['rand_goods_0_41380700_1368867339']):
        $this->_foreach['rand_goods']['iteration']++;
?>
					<dd>
					<p style="display:block; padding-bottom:10px;"><a href="<?php echo $this->_var['rand_goods_0_41380700_1368867339']['url']; ?>"><img src="<?php echo $this->_var['rand_goods_0_41380700_1368867339']['thumb']; ?>" width="145" height="145" border="0" /></a></p>
					<p><a href="<?php echo $this->_var['rand_goods_0_41380700_1368867339']['url']; ?>"><?php echo $this->_var['rand_goods_0_41380700_1368867339']['name']; ?></a></p>
					<p>婴格价：<font style="color:#e71f19;"><?php echo $this->_var['rand_goods_0_41380700_1368867339']['shop_price']; ?></font></p>
					</dd>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</dl>
			</div>
		</div>
		<div class="chuxiao right">
			<div class="chutitle">婴格「<font style="color:#e71f19;">购</font>」实惠</div>
			
			<div class="settime" id="<?php echo $this->_var['affordable']['end_time']; ?>" endTime="<?php echo $this->_var['affordable']['end_time']; ?>"></div>

			<p style="width:248px; margin:8px auto; ">
			<a href="<?php echo $this->_var['affordable']['url']; ?>" title="<?php echo $this->_var['affordable']['aff_name']; ?>">
			<img src="<?php echo $this->_var['affordable']['pic']; ?>" width="248" height="213">
			</a>
			</p>
		</div>
<script type=text/javascript>
$(document).ready(function(){
updateEndTime();
});
function setTab(name,cursel,n){

	for(var i=1;i<=n;i++){
	
		var menu=document.getElementById(name+i);
		
		var con=document.getElementById("con_"+name+"_"+i);
		
		menu.className=i==cursel?"hover":"";
		
		con.style.display=i==cursel?"block":"none";
		
	}
}
function updateEndTime()
{
	var date = new Date();
	var time = date.getTime();
	var m_endtime = $(".settime").attr("endTime");
	
	$(".settime").each(function(i){
		var endDate =new Date(m_endtime);
		var endTime = endDate.getTime();
		var n = {}; 
		var h = endTime - time;
		var lag = (endTime - time) / 1000;
		
		if(lag > 0)
		{
			   var l = [ "mill", "second", "minute" ];
				for ( var k in l) {
					var q = (k == 0 ? 1000 : (k == 3 ? 24 : 60));
					n[l[k]] = h % q;
					h = parseInt(h / q, 10)
				}
				l[3] = "hour";
				n[l[3]] = h ;
				//l[4] = "day";
				//n[l[4]] = h;
				var p = "", o = [ "毫秒", "秒", "分", "时" ];
				for ( var m = l.length, k = m - 1; k > 0; k--) {
					var r = l[k];
					if (k === (m - 1) && !n[r]) {
						continue
					}
					if (k !== (m - 1)) {
						n[r] = n[r] < 10 ? ("0" + n[r].toString()) : n[r];
						if (k === 1) {
							n[r] += "." + (parseInt(n.mill / 100, 10))
						}
					}
					p += '<span class="strong">' + n[r] + "</span>" + o[k]
			}
			$(this).html("剩余："+p);
		}
		else
			$(this).html("已经结束啦！");
	});
	
	setTimeout("updateEndTime()",100);
}
</script>
	</div>
	<div class="showpro">
		<div class="stitle">
			<span class="fl">孕婴食品</span>
			<span class="sl"><a href="/category-28-b0.html">配方奶粉</a> | <a href="/category-30-b0.html">羊奶粉</a> | <a href="/category-31-b0.html">米粉&菜粉</a> | <a href="/category-34-b0.html">营养面</a>  | <a href="/category-37-b0.html">长牙期食品</a></span>
			<div class="fr tabBut" id="tabBut1"> <a class="prev" href="javascript:"></a> <b class="tabOn"></b> <b class=""></b> <b class=""></b> <a class="next" href="javascript:"></a> </div>
		</div>
		<div class="sbox left" id="nbox1">
			<div class="nbox_in switch_item" style="display: block; ">
		<?php $_from = $this->_var['food1']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              
         
                <ul id="clear"></ul>
      </div>
      <div class="switch_item" style="display: none; "> 
         
               <?php $_from = $this->_var['food2']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <ul id="clear">
        </ul>
      </div>
      <div class="switch_item" style="display: none; "> 
         
                <?php $_from = $this->_var['food3']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <ul id="clear">
        </ul>
      </div>
		</div>
		
		<div class="top-pro right floor_con">
			<div class="pro_ad">
				<dl>
				<?php $_from = $this->_var['ad_food_t']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ad');$this->_foreach['ad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ad']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['ad']):
        $this->_foreach['ad']['iteration']++;
?>
					<dd <?php if ($this->_foreach['ad']['iteration'] == 1): ?>class="bottomline"<?php endif; ?>><a href="<?php echo $this->_var['ad']['url']; ?>"><?php echo $this->_var['ad']['content']; ?></a></dd>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</dl>
			</div>
			
			<div class="fc_sale_rank">
            <h3>大家都喜欢买</h3>
            <div class="sr_list">
                  <ul>
                  <?php $_from = $this->_var['top_food']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
                    <li class="item <?php if ($this->_foreach['goods']['iteration'] == 1): ?>hover<?php endif; ?>" onmouseover="setTab('food',<?php echo $this->_foreach['goods']['iteration']; ?>,8);" id="food<?php echo $this->_foreach['goods']['iteration']; ?>" style="<?php if ($this->_foreach['goods']['iteration'] == 8): ?>border:0;<?php endif; ?>">
                                    <p class="clearfix tit">
                                        <em class="fl"><?php echo $this->_foreach['goods']['iteration']; ?></em>
                                        <a target="_blank" title="<?php echo $this->_var['goods']['goods_name']; ?>" href="<?php echo $this->_var['goods']['url']; ?>" class="fl"><?php echo $this->_var['goods']['short_name']; ?></a>
                                    </p>
                                    <div class="sr_con" id="con_food_<?php echo $this->_foreach['goods']['iteration']; ?>">

                                        <a title="<?php echo $this->_var['goods']['goods_name']; ?>" href="<?php echo $this->_var['goods']['url']; ?>" class="sr_img" target="_blank">
                                            <img src="<?php echo $this->_var['goods']['thumb']; ?>" width="95" height="95">
                                        </a>
                                        <p class="text">婴格价格：<?php if ($this->_var['goods']['promote_price'] == ''): ?><?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></p>
                                        <p><span>市场价格：<del><?php echo $this->_var['goods']['market_price']; ?></del></span></p>
                                        
                                    </div>
                                </li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>        
                   </ul>
                            </div>
        </div>
		</div>
	</div>
	<?php $_from = $this->_var['ad_food_i']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ad');$this->_foreach['ad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ad']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['ad']):
        $this->_foreach['ad']['iteration']++;
?>
	<?php if ($this->_foreach['ad']['iteration'] == 1): ?>
		<div class="showpro"><a href="<?php echo $this->_var['ad']['url']; ?>"><img src='<?php echo $this->_var['ad']['content']; ?>' width="973" height="90" /></a></div>
	<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<div class="showpro">
		<div class="stitle">
			<span class="fl">孕婴用品</span><span class="sl"><a href="/category-51-b0.html">纸尿裤</a> | <a href="/category-53-b0.html">尿片</a> | <a href="/category-65-b0.html">餐椅/摇椅</a> | <a href="/category-83-b0.html">奶瓶</a>  | <a href="/category-71-b0.html">洗澡用具</a> | <a href="/category-70-b0.html">毛巾/浴巾</a> </span>
			<div class="fr tabBut" id="tabBut2"> <a class="prev" href="javascript:"></a> <b class="tabOn"></b> <b class=""></b> <b class=""></b> <a class="next" href="javascript:"></a> </div>
		</div>
		<div class="sbox left" id="nbox2">
			<div class="nbox_in switch_item" style="display: block; ">
		<?php $_from = $this->_var['supplies1']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              
         
                <ul id="clear"></ul>
      </div>
      <div class="switch_item" style="display: none; "> 
         
               <?php $_from = $this->_var['supplies2']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <ul id="clear">
        </ul>
      </div>
      <div class="switch_item" style="display: none; "> 
         
                <?php $_from = $this->_var['supplies3']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <ul id="clear">
        </ul>
      </div>
		</div>
		
		<div class="top-pro right floor_con">
			<div class="pro_ad">
				<dl>
					<?php $_from = $this->_var['ad_supplies_t']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ad');$this->_foreach['ad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ad']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['ad']):
        $this->_foreach['ad']['iteration']++;
?>
					<dd <?php if ($this->_foreach['ad']['iteration'] == 1): ?>class="bottomline"<?php endif; ?>><a href="<?php echo $this->_var['ad']['url']; ?>"><?php echo $this->_var['ad']['content']; ?></a></dd>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</dl>
			</div>
			
			<div class="fc_sale_rank">
            <h3>大家都喜欢买</h3>
            <div class="sr_list">
                  <ul>
                  <?php $_from = $this->_var['top_supplies']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
                    <li class="item <?php if ($this->_foreach['goods']['iteration'] == 1): ?>hover<?php endif; ?>" onmouseover="setTab('supplies',<?php echo $this->_foreach['goods']['iteration']; ?>,8);" id="supplies<?php echo $this->_foreach['goods']['iteration']; ?>" style="<?php if ($this->_foreach['goods']['iteration'] == 8): ?>border:0;<?php endif; ?>">
                                    <p class="clearfix tit">
                                        <em class="fl"><?php echo $this->_foreach['goods']['iteration']; ?></em>
                                        <a target="_blank" title="<?php echo $this->_var['goods']['goods_name']; ?>" href="<?php echo $this->_var['goods']['url']; ?>" class="fl"><?php echo $this->_var['goods']['short_name']; ?></a>
                                    </p>
                                    <div class="sr_con" id="con_supplies_<?php echo $this->_foreach['goods']['iteration']; ?>">

                                        <a title="<?php echo $this->_var['goods']['goods_name']; ?>" href="<?php echo $this->_var['goods']['url']; ?>" class="sr_img" target="_blank">
                                            <img src="<?php echo $this->_var['goods']['thumb']; ?>" width="95" height="95">
                                        </a>
                                        <p class="text">婴格价格：<?php if ($this->_var['goods']['promote_price'] == ''): ?><?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></p>
                                        <p><span>市场价格：<del><?php echo $this->_var['goods']['market_price']; ?></del></span></p>
                                        
                                    </div>
                                </li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>        
                   </ul>
                            </div>
        </div>
		</div>
	</div>
	<?php $_from = $this->_var['ad_supplies_i']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ad');$this->_foreach['ad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ad']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['ad']):
        $this->_foreach['ad']['iteration']++;
?>
	<?php if ($this->_foreach['ad']['iteration'] == 1): ?>
		<div class="showpro"><a href="<?php echo $this->_var['ad']['url']; ?>"><img src='<?php echo $this->_var['ad']['content']; ?>' width="973" height="90" /></a></div>
	<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<div class="showpro">
		<div class="stitle">
			<span class="fl">宝宝娱乐</span><span class="sl"><a href="/category-87-b0.html">床挂玩具</a> | <a href="/category-88-b0.html">游戏垫/爬行垫</a> | <a href="/category-92-b0.html">学习益智</a> | <a href="/category-93-b0.html">毛绒玩具</a>  | <a href="/category-94-b0.html">遥控玩具</a> | <a href="/category-95-b0.html">沙滩/戏水玩具</a></span>
			<div class="fr tabBut" id="tabBut3"> <a class="prev" href="javascript:"></a> <b class="tabOn"></b> <b class=""></b> <b class=""></b> <a class="next" href="javascript:"></a> </div>
		</div>
		<div class="sbox left" id="nbox3">
			<div class="nbox_in switch_item" style="display: block; ">
		<?php $_from = $this->_var['entertainment1']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              
         
                <ul id="clear"></ul>
      </div>
      <div class="switch_item" style="display: none; "> 
         
               <?php $_from = $this->_var['entertainment2']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <ul id="clear">
        </ul>
      </div>
      <div class="switch_item" style="display: none; "> 
         
                <?php $_from = $this->_var['entertainment3']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <ul id="clear">
        </ul>
      </div>
		</div>
		
		<div class="top-pro right floor_con">
			<div class="pro_ad">
				<dl>
					<?php $_from = $this->_var['ad_entertainment_t']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ad');$this->_foreach['ad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ad']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['ad']):
        $this->_foreach['ad']['iteration']++;
?>
					<dd <?php if ($this->_foreach['ad']['iteration'] == 1): ?>class="bottomline"<?php endif; ?>><a href="<?php echo $this->_var['ad']['url']; ?>"><?php echo $this->_var['ad']['content']; ?></a></dd>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</dl>
			</div>
			
			<div class="fc_sale_rank">
            <h3>大家都喜欢买</h3>
            <div class="sr_list">
                  <ul>
                  <?php $_from = $this->_var['top_entertainment']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
                    <li class="item <?php if ($this->_foreach['goods']['iteration'] == 1): ?>hover<?php endif; ?>" onmouseover="setTab('entertainment',<?php echo $this->_foreach['goods']['iteration']; ?>,8);" id="entertainment<?php echo $this->_foreach['goods']['iteration']; ?>" style="<?php if ($this->_foreach['goods']['iteration'] == 8): ?>border:0;<?php endif; ?>">
                                    <p class="clearfix tit">
                                        <em class="fl"><?php echo $this->_foreach['goods']['iteration']; ?></em>
                                        <a target="_blank" title="<?php echo $this->_var['goods']['goods_name']; ?>" href="<?php echo $this->_var['goods']['url']; ?>" class="fl"><?php echo $this->_var['goods']['short_name']; ?></a>
                                    </p>
                                    <div class="sr_con" id="con_entertainment_<?php echo $this->_foreach['goods']['iteration']; ?>">

                                        <a title="<?php echo $this->_var['goods']['goods_name']; ?>" href="<?php echo $this->_var['goods']['url']; ?>" class="sr_img" target="_blank">
                                            <img src="<?php echo $this->_var['goods']['thumb']; ?>" width="95" height="95">
                                        </a>
                                        <p class="text">婴格价格：<?php if ($this->_var['goods']['promote_price'] == ''): ?><?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></p>
                                        <p><span>市场价格：<del><?php echo $this->_var['goods']['market_price']; ?></del></span></p>
                                        
                                    </div>
                                </li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>        
                   </ul>
                            </div>
        </div>
		</div>
	</div>
	<?php $_from = $this->_var['ad_entertainment_i']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ad');$this->_foreach['ad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ad']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['ad']):
        $this->_foreach['ad']['iteration']++;
?>
	<?php if ($this->_foreach['ad']['iteration'] == 1): ?>
		<div class="showpro"><a href="<?php echo $this->_var['ad']['url']; ?>"><img src='<?php echo $this->_var['ad']['content']; ?>' width="973" height="90" /></a></div>
	<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<div class="showpro">
		<div class="stitle">
			<span class="fl">宝宝服装</span><span class="sl"><a href="/category-104-b0.html">童鞋/袜</a> | <a href="/category-105-b0.html">童帽</a> | <a href="/category-24-b0.html">头套及服饰配件</a> | <a href="/category-100-b0.html">婴儿枕</a></span>
			<div class="fr tabBut" id="tabBut4"> <a class="prev" href="javascript:"></a> <b class="tabOn"></b> <b class=""></b> <b class=""></b> <a class="next" href="javascript:"></a> </div>
		</div>
		<div class="sbox left" id="nbox4">
			<div class="nbox_in switch_item" style="display: block; ">
		<?php $_from = $this->_var['clothing1']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              
         
                <ul id="clear"></ul>
      </div>
      <div class="switch_item" style="display: none; "> 
         
               <?php $_from = $this->_var['clothing2']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <ul id="clear">
        </ul>
      </div>
      <div class="switch_item" style="display: none; "> 
         
                <?php $_from = $this->_var['clothing3']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <ul id="clear">
        </ul>
      </div>
		</div>
		
		<div class="top-pro right floor_con">
			<div class="pro_ad">
				<dl>
					<?php $_from = $this->_var['ad_clothing_t']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ad');$this->_foreach['ad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ad']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['ad']):
        $this->_foreach['ad']['iteration']++;
?>
					<dd <?php if ($this->_foreach['ad']['iteration'] == 1): ?>class="bottomline"<?php endif; ?>><a href="<?php echo $this->_var['ad']['url']; ?>"><?php echo $this->_var['ad']['content']; ?></a></dd>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</dl>
			</div>
			
			<div class="fc_sale_rank">
            <h3>大家都喜欢买</h3>
            <div class="sr_list">
                  <ul>
                  <?php $_from = $this->_var['top_clothing']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
                    <li class="item <?php if ($this->_foreach['goods']['iteration'] == 1): ?>hover<?php endif; ?>" onmouseover="setTab('clothing',<?php echo $this->_foreach['goods']['iteration']; ?>,8);" id="clothing<?php echo $this->_foreach['goods']['iteration']; ?>" style="<?php if ($this->_foreach['goods']['iteration'] == 8): ?>border:0;<?php endif; ?>">
                                    <p class="clearfix tit">
                                        <em class="fl"><?php echo $this->_foreach['goods']['iteration']; ?></em>
                                        <a target="_blank" title="<?php echo $this->_var['goods']['goods_name']; ?>" href="<?php echo $this->_var['goods']['url']; ?>" class="fl"><?php echo $this->_var['goods']['short_name']; ?></a>
                                    </p>
                                    <div class="sr_con" id="con_clothing_<?php echo $this->_foreach['goods']['iteration']; ?>">

                                        <a title="<?php echo $this->_var['goods']['goods_name']; ?>" href="<?php echo $this->_var['goods']['url']; ?>" class="sr_img" target="_blank">
                                            <img src="<?php echo $this->_var['goods']['thumb']; ?>" width="95" height="95">
                                        </a>
                                        <p class="text">婴格价格：<?php if ($this->_var['goods']['promote_price'] == ''): ?><?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></p>
                                        <p><span>市场价格：<del><?php echo $this->_var['goods']['market_price']; ?></del></span></p>
                                        
                                    </div>
                                </li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>        
                   </ul>
                            </div>
        </div>
		</div>
	</div>
	<?php $_from = $this->_var['ad_clothing_i']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ad');$this->_foreach['ad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ad']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['ad']):
        $this->_foreach['ad']['iteration']++;
?>
	<?php if ($this->_foreach['ad']['iteration'] == 1): ?>
		<div class="showpro"><a href="<?php echo $this->_var['ad']['url']; ?>"><img src='<?php echo $this->_var['ad']['content']; ?>' width="973" height="90" /></a></div>
	<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<div class="showpro">
		<div class="stitle">
			<span class="fl">宝宝学习</span><span class="sl"><a href="/category-115-b0.html">育儿经典</a> | <a href="/category-117-b0.html">认知启蒙</a> | <a href="/category-119-b0.html">亲子故事</a> | <a href="/category-120-b0.html">童话故事</a>  | <a href="/category-132-b0.html">开心游戏</a> | <a href="/category-134-b0.html">DVD/VCD</a></span>
			<div class="fr tabBut" id="tabBut5"> <a class="prev" href="javascript:"></a> <b class="tabOn"></b> <b class=""></b> <b class=""></b> <a class="next" href="javascript:"></a> </div>
		</div>
		<div class="sbox left" id="nbox5">
			<div class="nbox_in switch_item" style="display: block; ">
		<?php $_from = $this->_var['learning1']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              
         
                <ul id="clear"></ul>
      </div>
      <div class="switch_item" style="display: none; "> 
         
               <?php $_from = $this->_var['learning2']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <ul id="clear">
        </ul>
      </div>
      <div class="switch_item" style="display: none; "> 
         
                <?php $_from = $this->_var['learning3']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <ul id="clear">
        </ul>
      </div>
		</div>
		
		<div class="top-pro right floor_con">
			<div class="pro_ad">
				<dl>
					<?php $_from = $this->_var['ad_learning_t']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ad');$this->_foreach['ad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ad']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['ad']):
        $this->_foreach['ad']['iteration']++;
?>
					<dd <?php if ($this->_foreach['ad']['iteration'] == 1): ?>class="bottomline"<?php endif; ?>><a href="<?php echo $this->_var['ad']['url']; ?>"><?php echo $this->_var['ad']['content']; ?></a></dd>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</dl>
			</div>
			
			<div class="fc_sale_rank">
            <h3>大家都喜欢买</h3>
            <div class="sr_list">
                  <ul>
                  <?php $_from = $this->_var['top_learning']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
                    <li class="item <?php if ($this->_foreach['goods']['iteration'] == 1): ?>hover<?php endif; ?>" onmouseover="setTab('learning',<?php echo $this->_foreach['goods']['iteration']; ?>,8);" id="learning<?php echo $this->_foreach['goods']['iteration']; ?>" style="<?php if ($this->_foreach['goods']['iteration'] == 8): ?>border:0;<?php endif; ?>">
                                    <p class="clearfix tit">
                                        <em class="fl"><?php echo $this->_foreach['goods']['iteration']; ?></em>
                                        <a target="_blank" title="<?php echo $this->_var['goods']['goods_name']; ?>" href="<?php echo $this->_var['goods']['url']; ?>" class="fl"><?php echo $this->_var['goods']['short_name']; ?></a>
                                    </p>
                                    <div class="sr_con" id="con_learning_<?php echo $this->_foreach['goods']['iteration']; ?>">

                                        <a title="<?php echo $this->_var['goods']['goods_name']; ?>" href="<?php echo $this->_var['goods']['url']; ?>" class="sr_img" target="_blank">
                                            <img src="<?php echo $this->_var['goods']['thumb']; ?>" width="95" height="95">
                                        </a>
                                        <p class="text">婴格价格：<?php if ($this->_var['goods']['promote_price'] == ''): ?><?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></p>
                                        <p><span>市场价格：<del><?php echo $this->_var['goods']['market_price']; ?></del></span></p>
                                        
                                    </div>
                                </li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>        
                   </ul>
                            </div>
        </div>
		</div>
	</div>
	<?php $_from = $this->_var['ad_learning_i']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ad');$this->_foreach['ad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ad']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['ad']):
        $this->_foreach['ad']['iteration']++;
?>
	<?php if ($this->_foreach['ad']['iteration'] == 1): ?>
		<div class="showpro"><a href="<?php echo $this->_var['ad']['url']; ?>"><img src='<?php echo $this->_var['ad']['content']; ?>' width="973" height="90" /></a></div>
	<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<div class="showpro">
		<div class="stitle">
			<span class="fl">孕妈专区</span><span class="sl"><a href="/category-127-b0.html">防辐射服</a> | <a href="/category-126-b0.html">孕产期内衣</a> | <a href="/category-124-b0.html">孕产妇营养品</a> | <a href="/category-129-b0.html">吸乳器</a></span>
			<div class="fr tabBut" id="tabBut6"> <a class="prev" href="javascript:"></a> <b class="tabOn"></b> <b class=""></b> <b class=""></b> <a class="next" href="javascript:"></a> </div>
		</div>
		<div class="sbox left" id="nbox6">
			<div class="nbox_in switch_item" style="display: block; ">
		<?php $_from = $this->_var['mother1']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              
         
                <ul id="clear"></ul>
      </div>
      <div class="switch_item" style="display: none; "> 
         
               <?php $_from = $this->_var['mother2']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <ul id="clear">
        </ul>
      </div>
      <div class="switch_item" style="display: none; "> 
         
                <?php $_from = $this->_var['mother3']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <ul class="new_ul">
          <li class="new_img"> <a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" height="150" width="150" alt="<?php echo $this->_var['goods']['name']; ?>"></a> 
             
          </li>
          <li><a href="/goods-<?php echo $this->_var['goods']['id']; ?>.html" title="<?php echo $this->_var['goods']['name']; ?>" target="_blank"><?php echo $this->_var['goods']['short_name']; ?></a></li>
          <li><span><?php if ($this->_var['goods']['promote_price'] == ''): ?>¥<?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></span></li>
        </ul>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <ul id="clear">
        </ul>
      </div>
		</div>
		
		<div class="top-pro right floor_con">
			<div class="pro_ad">
				<dl>
					<?php $_from = $this->_var['ad_mother_t']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ad');$this->_foreach['ad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ad']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['ad']):
        $this->_foreach['ad']['iteration']++;
?>
					<dd <?php if ($this->_foreach['ad']['iteration'] == 1): ?>class="bottomline"<?php endif; ?>><a href="<?php echo $this->_var['ad']['url']; ?>"><?php echo $this->_var['ad']['content']; ?></a></dd>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</dl>
			</div>
			
			<div class="fc_sale_rank">
            <h3>大家都喜欢买</h3>
            <div class="sr_list">
                  <ul>
                  <?php $_from = $this->_var['top_mother']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
                    <li class="item <?php if ($this->_foreach['goods']['iteration'] == 1): ?>hover<?php endif; ?>" onmouseover="setTab('mother',<?php echo $this->_foreach['goods']['iteration']; ?>,8);" id="mother<?php echo $this->_foreach['goods']['iteration']; ?>" style="<?php if ($this->_foreach['goods']['iteration'] == 8): ?>border:0;<?php endif; ?>">
                                    <p class="clearfix tit">
                                        <em class="fl"><?php echo $this->_foreach['goods']['iteration']; ?></em>
                                        <a target="_blank" title="<?php echo $this->_var['goods']['goods_name']; ?>" href="<?php echo $this->_var['goods']['url']; ?>" class="fl"><?php echo $this->_var['goods']['short_name']; ?></a>
                                    </p>
                                    <div class="sr_con" id="con_mother_<?php echo $this->_foreach['goods']['iteration']; ?>">

                                        <a title="<?php echo $this->_var['goods']['goods_name']; ?>" href="<?php echo $this->_var['goods']['url']; ?>" class="sr_img" target="_blank">
                                            <img src="<?php echo $this->_var['goods']['thumb']; ?>" width="95" height="95">
                                        </a>
                                        <p class="text">婴格价格：<?php if ($this->_var['goods']['promote_price'] == ''): ?><?php echo $this->_var['goods']['price']; ?><?php else: ?><?php echo $this->_var['goods']['promote_price']; ?><?php endif; ?></p>
                                      
                                        <p><span>市场价格：<del><?php echo $this->_var['goods']['market_price']; ?></del></span></p>
                                    </div>
                                </li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>        
                   </ul>
                            </div>
        </div>
		</div>
	</div>
	<?php $_from = $this->_var['ad_mother_i']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ad');$this->_foreach['ad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ad']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['ad']):
        $this->_foreach['ad']['iteration']++;
?>
	<?php if ($this->_foreach['ad']['iteration'] == 1): ?>
		<div class="showpro"><a href="<?php echo $this->_var['ad']['url']; ?>"><img src='<?php echo $this->_var['ad']['content']; ?>' width="973" height="90" /></a></div>
	<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<script language="javascript"  type=text/javascript src="/themes/yingge/js/tab-pic.js"></script>

	<script language="javascript"  type=text/javascript>

$(function(){
	$(document).WIT_SetTab({
			Nav:$('#tabBut1 b'),
			Field:$('#nbox1>div'),
			Prev:$('#tabBut1 .prev'),
			Next:$('#tabBut1 .next'),
			Auto:true,
			CurCls:'tabOn',
			CrossTime:120,
			AutoTime:5000
	});
	$(document).WIT_SetTab({
			Nav:$('#tabBut2 b'),
			Field:$('#nbox2>div'),
			Prev:$('#tabBut2 .prev'),
			Next:$('#tabBut2 .next'),
			Auto:true,
			CurCls:'tabOn',
			CrossTime:120,
			AutoTime:5000
	});
	$(document).WIT_SetTab({
			Nav:$('#tabBut3 b'),
			Field:$('#nbox3>div'),
			Prev:$('#tabBut3 .prev'),
			Next:$('#tabBut3 .next'),
			Auto:true,
			CurCls:'tabOn',
			CrossTime:120,
			AutoTime:5000
	});
	$(document).WIT_SetTab({
			Nav:$('#tabBut4 b'),
			Field:$('#nbox4>div'),
			Prev:$('#tabBut4 .prev'),
			Next:$('#tabBut4 .next'),
			Auto:true,
			CurCls:'tabOn',
			CrossTime:120,
			AutoTime:5000
	});
	$(document).WIT_SetTab({
			Nav:$('#tabBut5 b'),
			Field:$('#nbox5>div'),
			Prev:$('#tabBut5 .prev'),
			Next:$('#tabBut5 .next'),
			Auto:true,
			CurCls:'tabOn',
			CrossTime:120,
			AutoTime:5000
	});
	$(document).WIT_SetTab({
			Nav:$('#tabBut6 b'),
			Field:$('#nbox6>div'),
			Prev:$('#tabBut6 .prev'),
			Next:$('#tabBut6 .next'),
			Auto:true,
			CurCls:'tabOn',
			CrossTime:120,
			AutoTime:5000
	});
})
	</script>
</div>
</div>
<div id="aa" style="width:310px; height:260px; display:none;"><?php 
$k = array (
  'name' => 'ads',
  'id' => '7',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>

<script>
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
jy_c.show();
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

jQuery(".topdiv ul li.li2").hover(
	function () {
    $(this).addClass("li2H");
	},
	function () {
	$(this).removeClass("li2H");
	}
);

var $_ = function (id) {
        return "string" == typeof id ? document.getElementById(id) : id;
};
var Extend = function(destination, source) {
        for (var property in source) {
                destination[property] = source[property];
        }
        return destination;
}
var CurrentStyle = function(element){
        return element.currentStyle || document.defaultView.getComputedStyle(element, null);
}
var Bind = function(object, fun) {
        var args = Array.prototype.slice.call(arguments).slice(2);
        return function() {
                return fun.apply(object, args.concat(Array.prototype.slice.call(arguments)));
        }
}
var Tween = {
        Quart: {
                easeOut: function(t,b,c,d){
                        return -c * ((t=t/d-1)*t*t*t - 1) + b;
                }
        },
        Back: {
                easeOut: function(t,b,c,d,s){
                        if (s == undefined) s = 1.70158;
                        return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
                }
        },
        Bounce: {
                easeOut: function(t,b,c,d){
                        if ((t/=d) < (1/2.75)) {
                                return c*(7.5625*t*t) + b;
                        } else if (t < (2/2.75)) {
                                return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
                        } else if (t < (2.5/2.75)) {
                                return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
                        } else {
                                return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
                        }
                }
        }
}
//容器对象,滑动对象,切换数量
var SlideTrans = function(container, slider, count, options) {
        this._slider = $_(slider);
        this._container = $_(container);//容器对象
        this._timer = null;//定时器
        this._count = Math.abs(count);//切换数量
        this._target = 0;//目标值
        this._t = this._b = this._c = 0;//tween参数
        
        this.Index = 0;//当前索引
        
        this.SetOptions(options);
        
        this.Auto = !!this.options.Auto;
        this.Duration = Math.abs(this.options.Duration);
        this.Time = Math.abs(this.options.Time);
        this.Pause = Math.abs(this.options.Pause);
        this.Tween = this.options.Tween;
        this.onStart = this.options.onStart;
        this.onFinish = this.options.onFinish;
        
        var bVertical = !!this.options.Vertical;
        this._css = bVertical ? "left" : "left";//方向
        
        //样式设置
        var p = CurrentStyle(this._container).position;
        p == "relative" || p == "absolute" || (this._container.style.position = "relative");
        //this._container.style.overflow = "hidden";
        this._slider.style.position = "absolute";
        
        this.Change = this.options.Change ? this.options.Change :
                this._slider[bVertical ? "offsetHeight" : "offsetWidth"] / this._count;
};
SlideTrans.prototype = {
  //设置默认属性
  SetOptions: function(options) {
        this.options = {//默认值
                Vertical:        true,//是否垂直方向（方向不能改）
                Auto:                true,//是否自动
                Change:                0,//改变量
                Duration:        50,//滑动持续时间
                Time:                10,//滑动延时
                Pause:                2000,//停顿时间(Auto为true时有效)
                onStart:        function(){},//开始转换时执行
                onFinish:        function(){},//完成转换时执行
                Tween:                Tween.Quart.easeOut//tween算子
        };
        Extend(this.options, options || {});
  },
  //开始切换
  Run: function(index) {
        //修正index
        index == undefined && (index = this.Index);
        index < 0 && (index = this._count - 1) || index >= this._count && (index = 0);
        //设置参数
        this._target = -Math.abs(this.Change) * (this.Index = index);
        this._t = 0;
        this._b = parseInt(CurrentStyle(this._slider)[this.options.Vertical ? "left" : "left"]);
        this._c = this._target - this._b;
        
        this.onStart();
        this.Move();
  },
  //移动
  Move: function() {
        clearTimeout(this._timer);
        //未到达目标继续移动否则进行下一次滑动
        if (this._c && this._t < this.Duration) {
                this.MoveTo(Math.round(this.Tween(this._t++, this._b, this._c, this.Duration)));
                this._timer = setTimeout(Bind(this, this.Move), this.Time);
        }else{
                this.MoveTo(this._target);
                this.Auto && (this._timer = setTimeout(Bind(this, this.Next), this.Pause));
        }
  },
  //移动到
  MoveTo: function(i) {
        this._slider.style[this._css] = i + "px";
  },
  //下一个
  Next: function() {
        this.Run(++this.Index);
  },
  //上一个
  Previous: function() {
        this.Run(--this.Index);
  },
  //停止
  Stop: function() {
        clearTimeout(this._timer); this.MoveTo(this._target);
  }
};

var forEach = function(array, callback, thisObject){
        if(array.forEach){
                array.forEach(callback, thisObject);
        }else{
                for (var i = 0, len = array.length; i < len; i++) {callback.call(thisObject, array[i], i, array);}
        }
}
var st = new SlideTrans("idContainer2", "idSlider2", 3, {Vertical: false});
var nums = [];
//设置按钮样式
st.onStart = function(){
        forEach(nums, function(o, i){o.className = st.Index == i ? "on" : "";})
}
st.Run();

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

<div style="z-index:999;background:#fff;">
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</div>

  <script type="text/javascript" src="themes/yingge/js/lazyload.js"></script>
<script>
$(document).ready(function(){
//$("#body_index").find("img").lazyload({effect : "fadeIn",placeholder : " /themes/yingge/images/grey.gif"}); 
}); 
</script> 
<script>
function scrollx(p){
var d = document,dd = d.documentElement,db = d.body,w = window,o = d.getElementById(p.id),ie6 = /msie 6/i.test(navigator.userAgent),style,timer;
if(o){
o.style.cssText +=";position:"+(p.f&&!ie6?'fixed':'absolute')+";"+(p.l==undefined?'right:0;':'left:'+p.l+'px;')+(p.t!=undefined?'top:'+p.t+'px':'bottom:0');
if(p.f&&ie6){
o.style.cssText +=';left:expression(documentElement.scrollLeft + '+(p.l==undefined?dd.clientWidth-o.offsetWidth:p.l)+' + "px");top:expression(documentElement.scrollTop +'+(p.t==undefined?dd.clientHeight-o.offsetHeight:p.t)+'+ "px" );';
dd.style.cssText +=';background-image: url(about:blank);background-attachment:fixed;';
}else{
if(!p.f){
w.onresize = w.onscroll = function(){
clearInterval(timer);
timer = setInterval(function(){
//双选择为了修复chrome 下xhtml解析时dd.scrollTop为 0
var st = (dd.scrollTop||db.scrollTop),c;
c = st - o.offsetTop + (p.t!=undefined?p.t:(w.innerHeight||dd.clientHeight)-o.offsetHeight);
if(c!=0){
o.style.top = o.offsetTop + Math.ceil(Math.abs(c)/10)*(c<0?-1:1) + 'px';
}else{
clearInterval(timer);
}
},10)
}
}
}
}
}
scrollx({
id:'aa'
})
scrollx({
id:'bb',
l:0,
t:200,
f:1
})
/*
id 你要滚动的内容的id
l 横坐标的位置 不写为紧贴右边
t 你要放在页面的那个位置默认是贴着底边 0是贴着顶边
f 1表示固定 不写或者0表示滚动
*/
</script>

</body>
</html>
