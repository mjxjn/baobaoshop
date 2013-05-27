<?php if ($this->_var['user_info']): ?>
 欢迎您，<strong><a href="/user.php"><?php echo $this->_var['user_info']['username']; ?></a></strong>&nbsp;&nbsp;<a href="/user.php?act=logout">[退出]</a>&nbsp;&nbsp;
<?php else: ?>
 您好！  <span id="loginBar_widgets_83">  <a href="/user.php">[请登录]</a> <a href="/user.php?act=register">[免费注册]</a>&nbsp;|&nbsp;</span>
<?php endif; ?>