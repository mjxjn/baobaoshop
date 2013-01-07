<style type="text/css">@import url("/js/suggest/SuggestFramework.css");</style>
<script src="/js/suggest/SuggestFramework.js" type=text/javascript /></script>
<script type="text/javascript">window.onload = initializeSuggestFramework;</script>
<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
</script>
<div id="top" class="topdiv">
	<div class="w990 line26">
    	<div class="left f12">欢迎来到婴格母婴商城&nbsp;|&nbsp;<strong>配送范围：</strong>云南地区&nbsp;|&nbsp;<strong>付款方式：</strong>货到付款(昆明地区)</div>
         <div class="right f12">
        	<ul> 
            	<li class="li1">
					<?php 
$k = array (
  'name' => 'member_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
                </li> 
                <li class="li2">
                	<div class="TreeList">  
                    	<div class="cat0"><a href="user.php">我的婴格</a></div> 
                        <div class="cat1"><a href="user.php?act=order_list">我的订单</a></div> 
                        <div class="cat1"><a href="user.php?act=comment_list">我的评论</a></div> 
                        <div class="cat1"><a href="user.php?act=collection_list">我的收藏</a></div> 
                        <div class="cat1"><a href="user.php?act=bonus">我的优惠券</a></div> 
                     </div>
                </li> 
                <li class="li3"><div class="ShopCartWrap">&nbsp;&nbsp;<a href="flow.php">购物车中有<b class="cart-number" id="ECS_CARTINFO"> <?php 
$k = array (
  'name' => 'cart_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </b>件商品</a> &nbsp;<a class="cart-container" href="flow.php">去结算</a> </div> 
                </li>
            </ul>
        </div>
        <div class="blank9"></div>
    </div>
</div>
<?php 
$k = array (
  'name' => 'ads',
  'id' => '10',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
<div id="head">
	<div id="logo_head" class="w980">
    	<div id="logo" class="left"><a href="index.php"><img src="/themes/yingge/images/LOGO.jpg" width="124" height="60" border="0" title="婴格母婴网" /></a></div>
        <div id="search_head" class="right">
        <script src="/js/CalendarData.js" type=text/javascript /></script>
            <div class="tel f12"><iframe src="http://m.weather.com.cn/m/pn6/weather.htm?id=101290101T " width="140" height="20" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no"></iframe></div>
			<script type="text/javascript">
			
			
			$(".topdiv ul li.li2").hover(
				function () {
				$(this).addClass("li2H");
				},
				function () {
				$(this).removeClass("li2H");
				}
			);
			$(document).ready(function(){
				$("#mq").click(
					function(){
						$(this).css("visibility","hidden");
						$("#keywords").focus();
					}
				)
				$("#keywords").focus(
					function(){
						$("#mq").css("visibility","hidden");
					}
				)
				$("#keywords").blur(
					function(){
						if($(this).val()==""){
							$("#mq").css("visibility","visible");
						}
					}
				);
			});
			function checkSearchForm()
			{
				if(document.getElementById('keyword').value)
				{
					return true;
				}
				else
				{
					alert("输入您要的商品名称/关键词/货号");
					return false;
				}
			}
			
			
			</script>
            <table cellspacing="0" cellpadding="0" border="0">
                <tbody>
                <tr class="m_search">
                    <td class="searchs"> 
                        <form class="SearchBar" id="searchForm" name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm()"> 
                        <table cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td class="search_label">
								<label id="mq" style="visibility: visible; color: #ccc; ">输入您要的商品名称/关键词/货号</label>
								<input class="inputstyle keywords" size="10" name="keywords" id="keywords" type="text" action="sug.php" columns="1" capture="1"> </td>
                                <td><input type="hidden" name="category" value="0"><input type="submit" class="btn_search" value="搜索"> </td>
                                <td></td>
                            </tr>
                         </tbody>
                         </table> 
                         </form> 
                    </td>
                    <td class="search_word" rowspan="2">
                        <a target="_blank" href="">新手上路</a> 
                        <a target="_blank" href="/user/service.html">在线客服</a>
                    </td>
                 </tr>
                 <tr>
                    <td>
                        <div class="sleft">
                        <?php if ($this->_var['searchkeywords']): ?>
                        <?php $_from = $this->_var['searchkeywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');$this->_foreach['searchkeywords'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['searchkeywords']['total'] > 0):
    foreach ($_from AS $this->_var['val']):
        $this->_foreach['searchkeywords']['iteration']++;
?>
                           <a href="search.php?keywords=<?php echo urlencode($this->_var['val']); ?>" target="_blank"><?php echo $this->_var['val']; ?></a>
                           <?php if (($this->_foreach['searchkeywords']['iteration'] == $this->_foreach['searchkeywords']['total'])): ?>
                           <?php else: ?>
                           <font size="-0">|</font>
                           <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        <?php endif; ?>
                        </div>
                        <div class="sright">全场正品 7天无条件退换 昆明地区 货到付款!</div>
                     </td> 
                  </tr>
                </tbody>
             </table>
        </div>
    </div>
    <div class="blank9"></div>
</div>
<div id="menu">
    <div class=" w990 menu_main f14">
    	<ul>
        	<li><a href="index.php">首页</a></li>
			<?php $_from = $this->_var['navigator_list']['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_middle_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_middle_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_middle_list']['iteration']++;
?>
				<li><a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?>target="_blank" <?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a></li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

            <?php $_from = $this->_var['navigator_list']['top']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_top_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_top_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_top_list']['iteration']++;
?>
            <li class="menu_h"><a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?> target="_blank" <?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a></li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    </div>
</div>