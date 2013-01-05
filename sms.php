<?php
/*
SMS 短信发送文件；

*/



$act=$_POST["act"];



switch($act){
	case "getCode":

	//$_COOKIE['PHPSESSID']=session_id();
	$lg_code=create_password(6);
setcookie("lg_sendcode",$lg_code , time()+1200);

//$_SESSION['smspass']=create_password(6);

$SMSCONTENT="欢迎加入婴格Baby，您的手机验证{$lg_code}，如有任何问题，请致电婴格0871-3330777咨询【婴格】";
     $phone=$_POST['phone'];
	 	echo($phone.$SMSCONTENT.$lg_code);
	send_Sms($phone,$SMSCONTENT);
	

	break;
	case "validateCode":

	
	$code=$_POST['code'];
	
	if($code==$_COOKIE['lg_sendcode'])
	echo('1');
	else
    echo('0');

	break;
	default : 
	 break;
	
	}
function create_password($pw_length = 6)  
{  
    $randpwd = '';  
    for ($i = 0; $i < $pw_length; $i++)  
    {  
        $randpwd .= mt_rand(0, 9);  
    }  
    return $randpwd;  
}  
function send_Sms($phone,$content){

$SMSUSER="婴格";
$SMSPASS="123456";

$post_data=array();
$post_data['username']=$SMSUSER;
$post_data['password']=$SMSPASS;
$post_data['method']="sendsms";
$post_data['mobile']=$phone;
$post_data['msg']=$content;

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

	}








?>