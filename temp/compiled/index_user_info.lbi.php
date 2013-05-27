<?php if ($this->_var['user_info']): ?>	
					<div class="logon_index left">
			        <p class="left">
			        <a href="user.php" style="*margin-right:10px;_margin-right:5px;margin-right:10px;"><img src="/themes/yingge/user/images/<?php echo $this->_var['user_info']['sex']; ?>"  width="60" height="60" /></a>
			        </p>
			        <p class="left">
			        <b><a href="user.php"><?php echo $this->_var['user_info']['username']; ?></a>&nbsp;&nbsp;欢迎回来<br /></b>
			        <b style="color:#079d04">会员积分:<?php echo $this->_var['user_info']['user_points']; ?></b><br />
			        <b><a style="clear:both; *margin-right:10px;_margin-right:5px;margin-right:10px;" href="/user.php?act=order_list">查看订单</a><a href="/user.php?act=logout">退出系统</a></b>
			        </p>
			        </div>
<?php else: ?>
			        <div class="right login_index">
		                <a href="user.php?act=register" class="register"></a>
		                <a href="user.php" class="r_login"></a>
		            </div>
		            <div class="blank9"></div>
		            <div class="userloginword">
		            	<img src="/themes/yingge/images/userloginword.gif" width="203" height="16" />
		            </div>
<?php endif; ?>

    