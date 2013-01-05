<?php
//$domain = "http://sms2.eachwe.com";  
//$port = 80;  
//$uri = "/api.php";  
//$SMSUSER="婴格";
//$SMSPASS="123";
//$data="username={$SMSUSER}&password={$SMSPASS}&method=sendsms&mobile=15253771619&msg=您的验证码为21231";  
//$protocolstr ="POST {$uri} HTTP/1.1\r\nHost: {$domain}\r\nContent-type: application/x-www-form-urlencoded\r\nContent-length: " . strlen($data) . "\r\nReferer: http://10.10.10.10/ly/index.php\r\nUser-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; .NET CLR 1.1.4322)\r\nAccept: */*\r\n\r\n{$data}\r\n\r\n";  
//  
//  
//$sock = fsockopen($domain, $port, $errno, $errstr, 30);  
//if (!$sock) die("$errstr ($errno)\n");  
//fputs($sock, $protocolstr);  
//  
//$headers = "";  
//while ($str = trim(fgets($sock, 4096)))  
//  $headers .= "$str\n";  
//  
//$body = "";  
//while (!feof($sock))  
//  $body .= fgets($sock, 4096);  
//fclose($sock);  
//  
//echo "<h2>Response header:</h2>\n";  
//echo $headers;  
//echo "\n";  
//  
//echo "<h2>Response body:</h2>\n";  
//echo $body;  
?>
<form action="http://sms2.eachwe.com/api.php" method="post">
<input type="hidden" name="username" value="婴格">
<input type="hidden" name="password" value="123456">
<input type="hidden" name="method" value="sendsms">
<input type="hidden" name="mobile" value="15253771619">
<input type="hidden" name="msg" value="您的验证码为">
<input type="submit" value="发送">
</form>
