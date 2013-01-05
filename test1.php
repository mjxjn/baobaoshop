<?php

$SMSUSER="婴格";
$SMSPASS="123456";

$post_data=array();
$post_data['username']=$SMSUSER;
$post_data['password']=$SMSPASS;
$post_data['method']="sendsms";
$post_data['mobile']="13792324551";
$post_data['msg']="您的验证码为123131";

$url='http://sms2.eachwe.com/api.php';
$o="";
foreach($post_data as $k=>$v)
{
    $o.="$k=".urlencode($v)."&";
}
$post_data=substr($o,0,-1);
$ch=curl_init();
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_HEADER,0);
curl_setopt($ch,CURLOPT_URL,$url);
//为了支持cookie
curl_setopt($ch,CURLOPT_COOKIEJAR,'cookie.txt');
curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
$result=curl_exec($ch);

?>