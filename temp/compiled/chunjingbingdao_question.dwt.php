<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>纯净冰岛活动答题</title>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="/themes/yingge/head.css" rel="stylesheet" rev="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="/themes/yingge/foot.css">
<SCRIPT type=text/javascript src="/themes/yingge/js/jquery.min.js"></SCRIPT>
<style type="text/css">
.w1030{width:1030px; margin:0 auto;}
.niuruizi_08{background:#fdf7d7; border-bottom:1px solid #d9d7cc;}
.niuruizi_08 p{line-height:35px;}
</style>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div style=" margin:0 auto;" class="niuruizi_08">
<form action="?act=answer" method="post" name="form1">
	<div class="w1030" style="background:url('/themes/yingge/zt/images/bingdao_08.gif') repeat-y;height: auto;margin-bottom: 30px;">
                   <div style=""><img src="/themes/yingge/zt/images/bingdao_09.gif" border="0" width="1030" height="72" /></div>
	<div style="position: relative;left: 44px;top: 26px; font-size:16px; font-weight:bold;font-family:'微软雅黑';width:944px;">
	<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list_0_47840500_1369813928');$this->_foreach['ad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ad']['total'] > 0):
    foreach ($_from AS $this->_var['list_0_47840500_1369813928']):
        $this->_foreach['ad']['iteration']++;
?>
		<p><?php echo $this->_foreach['ad']['iteration']; ?>.<?php echo $this->_var['list_0_47840500_1369813928']['question']; ?></p>
		<p>&nbsp;&nbsp;<label><input type="radio" name="question<?php echo $this->_foreach['ad']['iteration']; ?>" value="1" />&nbsp;<?php echo $this->_var['list_0_47840500_1369813928']['answer_a']; ?></label></p>
		<p>&nbsp;&nbsp;<label><input type="radio" name="question<?php echo $this->_foreach['ad']['iteration']; ?>" value="2" />&nbsp;<?php echo $this->_var['list_0_47840500_1369813928']['answer_b']; ?></label></p>
                                    <?php if ($this->_var['list_0_47840500_1369813928']['answer_c'] != ""): ?><p>&nbsp;&nbsp;<label><input type="radio" name="question<?php echo $this->_foreach['ad']['iteration']; ?>" value="3" />&nbsp;<?php echo $this->_var['list_0_47840500_1369813928']['answer_c']; ?></label></p><?php endif; ?>
                                    <?php if ($this->_var['list_0_47840500_1369813928']['answer_d'] != ""): ?><p>&nbsp;&nbsp;<label><input type="radio" name="question<?php echo $this->_foreach['ad']['iteration']; ?>" value="4" />&nbsp;<?php echo $this->_var['list_0_47840500_1369813928']['answer_d']; ?></label></p><?php endif; ?>
		<input type="hidden" name="question[]" value="<?php echo $this->_var['list_0_47840500_1369813928']['id']; ?>">
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</div>
	<div style="position: relative;left: 255px; top: 108px; float:left;"><input type="submit" style="background:url('/themes/yingge/zt/images/niuruizi_06.gif') no-repeat; border:0; width:130px; height:41px; cursor:pointer" value="" /></div>
	<div style="position: relative;left: 485px; top: 108px; width:400px;"><a href="/chunjingbingdao.php"><img src="/themes/yingge/zt/images/niuruizi_07.gif" width=152 height=41 border="0"/></a></div>
                  <div ><img src="/themes/yingge/zt/images/bingdao_10.gif" border="0"  width="1030" height="252" /></div>
	</div>
</form>
</div>
<?php echo $this->fetch('library/page_footer2.lbi'); ?>

<map name="Map" id="Map">
  <area shape="rect" coords="400,79,622,114" href="http://weibo.com/signup/signup.php?url=http%3A%2F%2Fweibo.com%2F2480698510&c=&type=&inviteCode=2480698510&code=&spe=&lang=&entry=" />
  <area shape="rect" coords="673,78,895,112" href="http://t.qq.com/yinggemall" />
</map>
</body>
</html>