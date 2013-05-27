<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>

<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="themes/yingge/head.css" rel="stylesheet" rev="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="themes/yingge/promotion.css">
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
<script src="js/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript">
function getList(page,ajaxpage,cat_id){
		$.ajax({
		   type: "POST",
		   url: "promotion.php",
		   dataType: "json",
		   data: "page="+page+"&ajax=1&ajaxpage="+ajaxpage+"&cat_id="+cat_id,
		   success: function(obj){
		        
		     $("#pro_goods").append(obj.html);
		     $("#ajax_btn").empty();
		     $("#ajax_btn").append("<a href='javascript:void(0);' onclick='getList("+obj.page+","+obj.ajaxpage+","+obj.cat_id+")'>更多特价商品</a>");
		   }
		});
	$("#loading").ajaxStart(function(){
             $(this).show();
         }).ajaxStop(function(){
           $(this).hide();
    });
}
</script>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<?php echo $this->fetch('library/page_header2.lbi'); ?>

<div id="cx_body" class="w973">
<div class="Navigation">
  <?php echo $this->fetch('library/ur_here.lbi'); ?>
 </div>
<div class="blank9"></div>
<div class="promotion">
	<div class="pro_top"></div>
	<div class="pro_body">
		<div class="pro_menu"><a href="promotion.php" <?php if ($this->_var['cat_id'] == '0'): ?>class="pro_cur" <?php endif; ?>>全部特价商品</a><a href="?cat_id=16" <?php if ($this->_var['cat_id'] == '16'): ?>class="pro_cur" <?php endif; ?>>婴幼儿奶粉</a><a href="?cat_id=17" <?php if ($this->_var['cat_id'] == '17'): ?>class="pro_cur" <?php endif; ?>>婴幼儿辅食</a><a href="?cat_id=18" <?php if ($this->_var['cat_id'] == '18'): ?>class="pro_cur" <?php endif; ?>>营养保健品</a><a href="?cat_id=19" <?php if ($this->_var['cat_id'] == '19'): ?>class="pro_cur" <?php endif; ?>>防尿用品</a><a href="?cat_id=20" <?php if ($this->_var['cat_id'] == '20'): ?>class="pro_cur" <?php endif; ?>>车/床/椅</a><a href="?cat_id=21" <?php if ($this->_var['cat_id'] == '21'): ?>class="pro_cur" <?php endif; ?>>日常用品</a><a href="?cat_id=22" <?php if ($this->_var['cat_id'] == '22'): ?>class="pro_cur" <?php endif; ?>>喂养用品</a><a href="?cat_id=23" <?php if ($this->_var['cat_id'] == '23'): ?>class="pro_cur" <?php endif; ?>>启智玩具</a><a href="?cat_id=24" <?php if ($this->_var['cat_id'] == '24'): ?>class="pro_cur" <?php endif; ?>>睡寝/宝宝服饰</a><a href="?cat_id=25" <?php if ($this->_var['cat_id'] == '25'): ?>class="pro_cur" <?php endif; ?>>婴幼儿洗浴/护肤</a><a href="?cat_id=26" <?php if ($this->_var['cat_id'] == '26'): ?>class="pro_cur" <?php endif; ?>>图书/影像</a><a href="?cat_id=27" <?php if ($this->_var['cat_id'] == '27'): ?>class="pro_cur" <?php endif; ?>>妈妈专区</a></div>
		<div class="pro_title">
		<?php if ($this->_var['cat_id'] == '0'): ?>全部特价商品 <?php endif; ?>
		<?php if ($this->_var['cat_id'] == '16'): ?>婴幼儿奶粉<?php endif; ?>
		<?php if ($this->_var['cat_id'] == '17'): ?>婴幼儿辅食 <?php endif; ?>
		<?php if ($this->_var['cat_id'] == '18'): ?>营养保健品 <?php endif; ?>
		<?php if ($this->_var['cat_id'] == '19'): ?>防尿用品 <?php endif; ?>
		<?php if ($this->_var['cat_id'] == '20'): ?>车/床/椅 <?php endif; ?>
		<?php if ($this->_var['cat_id'] == '21'): ?>日常用品 <?php endif; ?>
		<?php if ($this->_var['cat_id'] == '22'): ?>喂养用品 <?php endif; ?>
		<?php if ($this->_var['cat_id'] == '23'): ?>启智玩具 <?php endif; ?>
		<?php if ($this->_var['cat_id'] == '24'): ?>睡寝/宝宝服饰 <?php endif; ?>
		<?php if ($this->_var['cat_id'] == '25'): ?>婴幼儿洗浴/护肤 <?php endif; ?>
		<?php if ($this->_var['cat_id'] == '26'): ?>图书/影像 <?php endif; ?>
		<?php if ($this->_var['cat_id'] == '27'): ?>妈妈专区 <?php endif; ?>
		</div>
		<div id="pro_goods" class="pro_goods">
		<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');$this->_foreach['list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['list']['total'] > 0):
    foreach ($_from AS $this->_var['val']):
        $this->_foreach['list']['iteration']++;
?>
			<div class="goodinfo">
				<div class="good_top"><a href="<?php echo $this->_var['val']['url']; ?>"><?php echo $this->_var['val']['name']; ?></a></div>
				<div class="good_body">
				<a href="<?php echo $this->_var['val']['url']; ?>"><img src="<?php echo $this->_var['val']['goods_img']; ?>" class="scrollLoading" width="266" height="266" alt="<?php echo $this->_var['val']['name']; ?>" border='0'/></a>
				<div class="ty">婴格特价商品不参与<a href="activity.php" target="_blank">满百赠品</a>,可获购物积分</div>
				<div class="buy">
					<div class="price"><?php echo $this->_var['val']['promote_price']; ?></div>
					<div class="buy_btn"><a href="<?php echo $this->_var['val']['url']; ?>"><img src="/themes/yingge/images/buy_btn.gif" border="0"/></a></div>
				</div>
				<div class="blank9"></div>
				</div>
				<div class="good_btm"></div>
			</div>
		<?php endforeach; else: ?>
		    <div style="width:960px; margin:0 auto; text-align: center; font-size:14px; color:red; line-height:30px;">
	          	亲，本分类下暂时没有特价商品哦！
	        </div>
		<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>	
			
		</div>
		<div id="loading" style="display:none; width:960px; margin:0 auto; text-align: center;">
	        <img src="themes/yingge/images/loading.gif" width='32' height='32' />
	    </div>
	</div>
	<div class="pro_btm" id="ajax_btn"><a href="javascript:void(0);" onclick="getList(<?php echo $this->_var['page']; ?>,<?php echo $this->_var['ajaxpage']; ?>,<?php echo $this->_var['cat_id']; ?>)">更多特价商品</a></div>
</div>
</div>
<div class="blank9"></div>


<?php echo $this->fetch('library/page_footer.lbi'); ?>
<SCRIPT type=text/javascript src="themes/yingge/js/agestate.js"></SCRIPT>
  <script type="text/javascript" src="themes/yingge/js/lazyload.js"></script>
<script>
$(document).ready(function(){
$("#pro_goods").find("img").lazyload({effect : "fadeIn",placeholder : " /themes/yingge/images/grey.gif"});
}); 
</script> 
</body>
</html>
