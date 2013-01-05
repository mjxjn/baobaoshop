<?php
session_start();
include_once('config.php');
include_once('api/tblog.class.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>发送微博</title>
</head>
<body>

<h2>发送微博</h2>
<form action="update.php" >
文字：<input type="text" name="text" style="width:300px" />
<br/>
<br/>
<br/>
图片：<input type="file" name="pic" style="width:300px" />
<br/>
<br/>
<br/>
<input type="submit" value="发送微博"/>
</form>

<?php

$tblog = new TBlog(WB_AKEY, WB_SKEY, $_SESSION['163lastkey']['oauth_token'], $_SESSION['163lastkey']['oauth_token_secret']);

if(isset($_REQUEST['pic']))
{
    $tblog ->upload($_REQUEST['text'], $_REQUEST['pic']);    // 发送带图片微博
    echo '<h3>发送成功！</h3>';
}
elseif(isset($_REQUEST['text']))
{
    $tblog->update($test);    // 发送纯文本微博
    echo '<h3>发送成功！</h3>';
}

?>

</body>
</html>