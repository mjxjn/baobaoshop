<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
</script>
<div id="top" class="topdiv">
	<div class="w990 line26">
    	<div class="left f12">欢迎来到婴格母婴网&nbsp;|&nbsp;<strong>配送范围：</strong>昆明&nbsp;|&nbsp;<strong> 服务时间：</strong>9:30-17:30(节假日除外)</div>
        <div class="right f12">
        	<ul> 
            	<li class="li1"><?php 
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
                <li class="li3"><div class="ShopCartWrap">&nbsp;&nbsp;  购物车中有<b class="cart-number" id="ECS_CARTINFO"> <?php 
$k = array (
  'name' => 'cart_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </b>件商品   &nbsp;<a class="cart-container" href="flow.php">去结算</a></div> 
                </li>
            </ul>
        </div>
        <div class="blank9"></div>
    </div>
    <script type="text/javascript">
			
			
			$(".topdiv ul li.li2").hover(
				function () {
				$(this).addClass("li2H");
				},
				function () {
				$(this).removeClass("li2H");
				}
			);
			
	</script>
</div>
