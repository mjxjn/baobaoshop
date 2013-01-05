<?php
session_start();
include_once('config.php');
include_once('api/tblog.class.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>授权完成</title>
</head>
<body>

<?php
$oauth = new OAuth( WB_AKEY , WB_SKEY , $_SESSION['163keys']['oauth_token'] , $_SESSION['163keys']['oauth_token_secret']  );

if ($last_key = $oauth->getAccessToken(  $_REQUEST['oauth_token'] ) )
{
    $_SESSION['163lastkey'] = $last_key;
?>

    <h1>授权完成...</h1>
    <br/>
    <div><a href="home_timeline.php">微博列表</a></div>
    <br/>
    <div><a href="update.php">发送微博</a></div>
<?php
}
else
{
    echo "授权失败";
}
?>
</body>
</html>