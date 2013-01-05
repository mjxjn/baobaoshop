<?php

/*
	*功能：ECSHOP设置支付宝确认订单有关信息
	*版本：2.0
	*日期：2009-01-05
	*作者：支付宝公司销售部技术支持团队
	*联系：0571-26888888
	*版权：支付宝公司
	*修改：lkcp@163.com
    * $Author: wqdngslqw $
    * $Id: queren_fahuo.php 16929 2010-02-10 08:28:21Z wqdngslqw $
    */
/*-------------------------------------------------------------------*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
 if (!empty($_POST))
        {
            foreach($_POST as $key => $data)
            {
                $_GET[$key] = $data;
            }
        }
   $order_id      = trim($_GET['order_id']);//取得提交过来的订单ID
   $invoice_no    = trim($_GET['invoice_no']);//提交过来的物流单号
   $order     = order_info($order_id);//根据订单ID查询订单信息，返回数组$order
   $pay_id    = $order['pay_id'];//支付方式的ID
   $pay_name  = $order['pay_name'];//支付方式的名称
   $payment   = payment_info($pay_id);//取得支付方式信息
   
if($payment['pay_code'] == "alipay")       //判断支付方式是否支付宝
  {   
	  
	  /*获取支付宝的配置信息*/
      if (is_string($payment['pay_config']))
	     {
           $store = unserialize($payment['pay_config']);//逆向已序列化的变量为数组
           /* 取出已经设置属性的code */
           $code_list = array();
			foreach ($store as $key=>$value)
			{
				$code_list[$value['name']] = $value['value'];
			}

		$partner         = $code_list['alipay_partner'];//合作伙伴ID
		$security_code   = $code_list['alipay_key'];//安全检验码
        $alipay_account  = $code_list['alipay_account'];//支付宝帐户 
		$pay_method =$code_list['alipay_pay_method'];//接口类型
         }
       	   
	   $shipping_id   = $order['shipping_id'];//配送方式id
	   $shipping_name = $order['shipping_name'];//配送方式的名称
	   $trade_no      = $order['trade_no'];   //支付宝交易号
	   $shipping_info = shipping_info($shipping_id);//物流信息
       $shipping_code = $shipping_info['shipping_code'];//物流代码
		/*判断物流的发货类型*/
        $no_post = "post";
        $no_ems  = "ems";
        if(stristr($shipping_code,$no_post)){
	        $transport_type = "POST"; 
           }   
        elseif(stristr($shipping_code,$no_ems)){
        	$transport_type = "EMS";   
		} 
		else{
		    $transport_type = "EXPRESS";
		}  
		
	/*
		*功能：设置帐户有关信息
		*版本：2.0
		*日期：2009-01-05
		*作者：支付宝公司销售部技术支持团队
		*联系：0571-26888888
		*版权：支付宝公司
	$partner         = "********647";            //合作伙伴ID
	$security_code   = "********k48l3";        //安全检验码
	*/
	$_input_charset  = "utf-8";   //字符编码格式 目前支持 GBK 或 utf-8
	$sign_type       = "MD5";     //加密方式 系统默认(不要修改)

	/** 提示：如何获取安全校验码和合作ID
	1.访问 www.alipay.com，然后登陆您的帐户($seller_email).
	2.点商家服务.导航栏的下面可以看到
	*/
	$parameter = array(
		"service"         => "send_goods_confirm_by_platform",  //接口类型
		"partner"         => $partner,           //合作商户号
		"_input_charset"  => $_input_charset,    //字符集，默认为GBK
		//"trade_no"        => $_POST['TxtTrade_no'], 支付宝交易号
		"trade_no"        => $trade_no, //支付宝交易号
		//"logistics_name"  => $_POST['TxtLogistics_name'], //物流公司名称
		"logistics_name"  => $shipping_code, //物流公司名称
		//"invoice_no"      => $_POST['TxtInvoice_no'], //物流单号
        "invoice_no"      => $invoice_no, //物流单号
		//"transport_type"  => $_POST['DDLTransport_type'], //发货类型，POST（平邮），EXPRESS（快递），EMS（EMS）
		"transport_type"  => $transport_type,
	);
 
	$alipay = new alipay_service($parameter,$security_code,$sign_type);
	//$link=$alipay->create_url();
    
	//header("Location: $link ");
    
	$xml_file=$alipay->create_url();
	//创建一个XML 解析器起始元素处理器函数startElement（）
	function startElement($parser_instance, $element_name, $attrs) {
		global $k;
		switch($element_name) {
			case "IS_SUCCESS"     : 
				$k = 1; 
				echo $element_name."=";
				break;
			case "TRADE_STATUS"     : 
				$k = 1; 
				echo $element_name."=";
				break;
			case "TRADE_NO" :
				$k = 1; 
				echo $element_name."=";
				break;
		}
	}
	//创建一个XML 解析器需要的函数characterData（）
	function characterData($parser_instance, $xml_data) {
		global $k;
		if($k == 1) {
			echo $xml_data."<br>";
			$k = 0;
		}
	}
	//建立解析器的终止元素处理器函数
	function endElement($parser_instance, $element_name) {
	}

	$parser = xml_parser_create();//建立一个 XML 解析器$parser
	xml_set_element_handler($parser, "startElement", "endElement");//建立解析器的起始和终止元素处理器

	xml_set_character_data_handler($parser, "characterData");//建立字符数据处理器
	//判断并读入$xml_file变量
	if (!($filehandler = fopen($xml_file, "r"))) {
		die("could not open XML input");
	}
	//循环处理
	while ($data = fread($filehandler, 4096)) {
		//开始解析一个 XML 文档
		if (!xml_parse($parser, $data, feof($filehandler))) {
				die(sprintf("XML error: %s at line %d",
				xml_error_string(xml_get_error_code($parser)),//获取错误代码de错误字符串
				xml_get_current_line_number($parser)));//获取 XML 解析器的当前行号
		}
		
	}
  
	fclose($filehandler);//关闭一个已打开的文件指针
   
	xml_parser_free($parser);//释放指定的 XML 解析器
    echo"如果你见到：<br><span style=\"color:#FF0000;\"><strong>TRADE_STATUS=WAIT_BUYER_CONFIRM_GOODS</strong></span><br>恭喜你！支付宝已经完成发货!";  
  
  }//支付宝支付方式判断结束

/**
	*类名：alipay_service
	*功能：支付宝外部服务接口控制
	*版本：2.0
	*日期：2009-01-05
	*作者：支付宝公司销售部技术支持团队
	*联系：0571-26888888
	*版权：支付宝公司
*/

class alipay_service {

	var $gateway = "https://www.alipay.com/cooperate/gateway.do?";         //支付接口
	var $parameter;       //全部需要传递的参数
	var $security_code;   //安全校验码
	var $mysign;          //签名

	//构造支付宝外部服务接口控制
	function alipay_service($parameter,$security_code,$sign_type = "MD5",$transport= "https") {
		$this->parameter      = $this->para_filter($parameter);
		$this->security_code  = $security_code;
		$this->sign_type      = $sign_type;
		$this->mysign         = '';
		$this->transport      = $transport;
		if($parameter['_input_charset'] == "")
		$this->parameter['_input_charset']='GBK';
		if($this->transport == "https") {
			$this->gateway = "https://www.alipay.com/cooperate/gateway.do?";
		} else $this->gateway = "http://www.alipay.com/cooperate/gateway.do?";
		$sort_array  = array();
		$arg         = "";
		$sort_array  = $this->arg_sort($this->parameter);
		while (list ($key, $val) = each ($sort_array)) {
			$arg.=$key."=".$this->charset_encode($val,$this->parameter['_input_charset'])."&";
		}
		$prestr = substr($arg,0,count($arg)-2);  //去掉最后一个问号
		$this->mysign = $this->sign($prestr.$this->security_code);
	}

	function create_url() {
		$url         = $this->gateway;
		$sort_array  = array();
		$arg         = "";
		$sort_array  = $this->arg_sort($this->parameter);
		while (list ($key, $val) = each ($sort_array)) {
			$arg.=$key."=".urlencode($this->charset_encode($val,$this->parameter['_input_charset']))."&";
		}
		$url.= $arg."sign=" .$this->mysign ."&sign_type=".$this->sign_type;
		return $url;
	}

	function arg_sort($array) {
		ksort($array);
		reset($array);
		return $array;
	}

	function sign($prestr) {
		$mysign = "";
		if($this->sign_type == 'MD5') {
			$mysign = md5($prestr);
		}elseif($this->sign_type =='DSA') {
			//DSA 签名方法待后续开发
			die("DSA 签名方法待后续开发，请先使用MD5签名方式");
		}else {
			die("支付宝暂不支持".$this->sign_type."类型的签名方式");
		}
		return $mysign;
	}
	function para_filter($parameter) { //除去数组中的空值和签名模式
		$para = array();
		while (list ($key, $val) = each ($parameter)) {
			if($key == "sign" || $key == "sign_type" || $val == "")continue;
			else	$para[$key] = $parameter[$key];
		}
		return $para;
	}
	//实现多种字符编码方式
	function charset_encode($input,$_output_charset ,$_input_charset ="GBK" ) {
		$output = "";
		if(!isset($_output_charset) )$_output_charset  = $this->parameter['_input_charset '];
		if($_input_charset == $_output_charset || $input ==null) {
			$output = $input;
		} elseif (function_exists("mb_convert_encoding")){
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
            
		} elseif(function_exists("iconv")) {
			$output = iconv($_input_charset,$_output_charset,$input);
		} else die("sorry, you have no libs support for charset change.");
		return $output;
	}
}
?>