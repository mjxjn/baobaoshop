/**
 *	JavaScript Document
 *		趣玩购物车、订单确认页面 
 * ===========================================================================
 *	版权所有 (C) 2008-2011 北京玩着天下网络技术有限公司，并保留所有权利。
 *	网站地址: http://www.quwan.com
 * ===========================================================================
 *	$Author:	tylergong	2011-03-22 $
 *	$Id:		flow_new.js $
 **/
$(document).ready(function(){
	
//=================================================================================
//	新 收货人地址 变更 处理  start
//---------------------------------------------------------------------------------
	// 确认收货人信息的提交表单按钮操作
	$('#new_addr_btn').click(function(){
		//判断收货地址表单项目填写是否合乎规范
		if(!checkaddr()){return false;}
		
		//这里编写向服务器提交表单的操作
		$('#AddNewConsignee').submit();	
	});
	
	// 修改地址信息打开点击操作-隐藏确定状态，打开编辑状态
	$('#new_back_consignee').click(function(){	
		$('#consignee1').show();
		$('#consignee2').hide();
		$('#payment2').hide();
	});
//---------------------------------------------------------------------------------
//	新 收货人地址  变更 处理  end
//=================================================================================


//=================================================================================
//	新 配送 与 支付 方式  变更 处理  start
//---------------------------------------------------------------------------------
	// 配送方式决定付款方式的操作
	$('#new_selway_box').find(':radio').live("click",function(){
		if($(this).attr("clicked") != 'clicked')
		{ 
			// 先全部清除 自定义选择属性
			$('#new_selway_box').find(':radio').attr("clicked",'');
			// 给当前 赋选择属性
			$(this).attr("clicked",'clicked');
			
			// ajax 调用
			var data = 	"shipping_id="+$(this).val()+
						"&shipping_fee="+$(this).attr('fee')
						;
			$.ajax({
				type: "POST",
				url: "source/flow_ajax.php?step=change_new_shipping",
				cache: false,
				data: data+"&m=" + Math.random(),
				beforeSend:function(){
					$('#new_payment_editbox').html("<img style='margin-left:50px;' src='http://i1.quwan.com/themes/default/imgs/global/loading.gif' />&nbsp;付款方式加载中... ...");
					},
				success:function(data){
					re = $.evalJSON(data);
					if(re.error == 1)
					{
						alert(re.tishi);
						window.location.href="flow.php?step=cart" + "&m=" + Math.random();
						return;
					}
			
					$('#new_payment_editbox').html(re.content_payment_table);
					if(re.pay_show == 0)
					{
						$('#bank_box').hide();
						$('#afterpay_box').hide();
						$('#plus20').hide()
					}
					else
					{
						// 在线支付
						if(re.shipping_id == 6)
						{
							$('#bank_box').show();
							$('#afterpay_box').hide();
							$('#radio_5').click();// 支付宝 默认
							$('#plus20').show();
						}
						// 货到付款
						if(re.shipping_id == 15)
						{	
							$('#bank_box').hide();
							$('#afterpay_box').show();
							$('#radio_1').click();// 货到付款 默认
							$('#plus20').hide()
						}
						// 邮政EMS
						if(re.shipping_id == 4)
						{
							$('#bank_box').show();
							$('#afterpay_box').hide();
							$('#radio_5').click();// 支付宝 默认
							$('#plus20').show()	
						}
					}
				}
			});
		}
	});	
	
	// 付款与配送方式确定按钮操作
	$('#new_payway_sbtn').live("click",function(){	
		// 判断配送方式是否有选择
		
		
		// 这里编写向服务器提交表单的操作
		$('#AddNewPayment').submit();	
		
	});
//---------------------------------------------------------------------------------
//	新 配送 与 支付 方式  变更 处理  end
//=================================================================================


//=================================================================================
//	收货人地址 各种事件 处理  start
//---------------------------------------------------------------------------------	
	// 点击 修改， 打开 收货人编辑区域
	$('#addr_modify').click(function(){	
		$.ajax({
			type: "POST",
			url: "source/flow_ajax.php?step=consignee_list",
			cache: false,
			data: "&m=" + Math.random(),
			beforeSend:function(){$('#addr_modify').html('[获取中... ...]')},
			success:function(data){
				re = $.evalJSON(data);
				if(re.error == 1)
				{
					alert(re.tishi);
					window.location.href="flow.php?step=cart" + "&m=" + Math.random();
					return;
				}	
				else if(re.error == 2)
				{
					alert(re.tishi);
					window.location.href="flow.php?step=consignee";
					return;
				}
							
				$('#addr_modify').hide();
				$('#addr_okbox').hide();
				$('#addr_editbox').show();
				$('#addr_editbox').html(re.content_list);
				$('#addr_edit_table').html(re.content_table);
			}
		})
	});
	
	// 收货人编辑区域 地址列表 单击事件
	$('.addr_list').find('li').live("click",function(){
		if($(this).find("input[name='addr']").eq(0).attr("clicked") != 'clicked')
		{ 
			// 先全部清除 自定义选择属性
			$('.addr_list').find(':radio').attr("clicked",'');
			// 给当前 赋选择属性
			$(this).find("input[name='addr']").eq(0).attr("clicked",'clicked');
			
			//点击1后项目加边框操作
			$(this).find("input[name='addr']").eq(0).attr('checked','checked');
			$('.addr_list').find('li').removeClass('addr_on');
			$(this).addClass('addr_on');
	
			$.ajax({
				type: "POST",
				url: "source/flow_ajax.php?step=change_consignee",
				cache: false,
				data: "addr_id="+$(this).find("input[name='addr']").eq(0).val()+"&m=" + Math.random(),
				beforeSend:function(){},
				success:function(data){
					re = $.evalJSON(data);
					if(re.error == 1)
					{
						alert(re.tishi);
						window.location.href="flow.php?step=cart" + "&m=" + Math.random();
						return;
					}
										
					$('#addr_edit_table').html(re.content_table);
				}
			})		
		}
	});

	// 收货人编辑区域 确认收货人信息 按钮 提交表单操作
	$('#addr_btn').live("click",function(){
		//判断收货地址表单项目填写是否合乎规范
		if(!checkaddr()){return false;}
		
		//这里编写向服务器提交表单的操作
		var data = 	"address_id="+$('#address_id').val()+
					"&consignee="+$('#consignee').val()+
					"&province="+$('#s1Province').val()+
					"&city="+$('#s2City').val()+
					"&district="+$('#s3Area').val()+
					"&address="+$('#address').val()+
					"&tel="+$('#tel').val()+
					"&mobile="+$('#mobile').val()+
					"&province_name="+$('#s1Province').find('option:selected').text()+
					"&city_name="+$('#s2City').find('option:selected').text()+
					"&district_name="+$('#s3Area').find('option:selected').text()
					;
		$.ajax({
			type: "POST",
			url: "source/flow_ajax.php?step=save_consignee",
			cache: false,
			data: data+"&m=" + Math.random(),
			beforeSend:function(){},
			success:function(data){
				re = $.evalJSON(data);
				if(re.error == 1)
				{
					alert(re.tishi);
					window.location.href="flow.php?step=cart" + "&m=" + Math.random();
					return;
				}
				
				// 返回界面显示
				$('#addr_okbox').find('p').eq(0).text($('#consignee').val());
				var str= $('#s1Province').find('option:selected').text()+"-"+$('#s2City').find('option:selected').text();
				if($('#s3Area').css('display') != 'none')
				{
					str = str + "-"+$('#s3Area').find('option:selected').text()
				}
				$('#addr_okbox').find('p').eq(1).text(str);
				$('#addr_okbox').find('p').eq(2).text($('#address').val());
				if($('#mobile').val() == ''){
					$('#addr_mobile').hide();
				}else{
					$('#addr_mobile').show();
					$('#addr_okbox').find('p').eq(3).text($('#mobile').val());
				}
				if($('#tel').val() == ''){
					$('#addr_tel').hide();
				}else{
					$('#addr_tel').show();
					$('#addr_okbox').find('p').eq(4).text($('#tel').val());
				}
				$('#addr_modify').html('[修改]');
				
				$('#addr_modify').show();
				$('#addr_editbox').hide();	
				$('#addr_okbox').show();
				
				$('#shipping_tishi').remove();// 移除提示信息
				
				// 是否展开 配送与支付方式
				if(re.is_normal == 1){
					// 展开
					$('#payment_modify').hide();
					$('#payment_okbox').hide();
					$('#shipping_payment_editbox').show();
					$('#shipping_editbox').html(re.content_shipping_table);
					$('#payment_editbox').html(re.content_payment_table);
					$('#now_pay_money').html(re.content_goods_money_table);
					if(re.pay_show == 0)
					{
						$('#bank_box').hide();
						$('#afterpay_box').hide();
					}
					if(re.tishi != null)
					{
						$('#wp_title').append('<span class="yhq_tip" id="shipping_tishi">'+re.tishi+'</span>');// 装载提示信息
					}
					$('#payway_cbtn').hide();// 取消按钮隐藏
					// 展开后定位
					var pos = $("#wp_title").offset().top;
    				$("html,body").animate({scrollTop: pos}, 10);
				}else{
					// 收起
					$('#payment_modify').html('[修改]')
					$('#payment_modify').show();
					$('#shipping_payment_editbox').hide();
					$('#payment_okbox').show();
					$('#now_pay_money').html(re.content_goods_money_table);
				}
			}
		})

	});

	// 收货人编辑区域  取消按钮操作
	$('#addr_cbtn').live("click",function(){
		$('#addr_modify').html('[修改]');
		$('#addr_modify').show();
		$('#addr_editbox').hide();
		$('#addr_okbox').show();
	});
//---------------------------------------------------------------------------------
//	收货人地址 各种事件 处理  end
//=================================================================================


//=================================================================================
//	配送 与 支付 方式  各种事件 处理  start
//---------------------------------------------------------------------------------	
	// 付款与配送方式修改打开的操作-隐藏确定状态，打开编辑状态
	$('#payment_modify').click(function(){	
		$.ajax({
			type: "POST",
			url: "source/flow_ajax.php?step=shipping_payment_show",
			cache: false,
			data: "&m=" + Math.random(),
			beforeSend:function(){$('#payment_modify').html('[获取中... ...]')},
			success:function(data){
				re = $.evalJSON(data);
				if(re.error == 1)
				{
					alert(re.tishi);
					window.location.href="flow.php?step=cart" + "&m=" + Math.random();
					return;
				}	
				else if(re.error == 2)
				{
					alert(re.tishi);
					window.location.href="flow.php?step=consignee";
					return;
				}
							
				$('#payment_modify').hide();
				$('#payment_okbox').hide();
				$('#shipping_payment_editbox').show();
				$('#shipping_editbox').html(re.content_shipping_table);
				$('#payment_editbox').html(re.content_payment_table);
				// 是否现显示除现金账户外的其他付款方式
				if(re.pay_show == 0 || re.pay_bouns_tishi == 1)
				{
					$('#bank_box').hide();
					$('#afterpay_box').hide();
				}
			}
		})
	});

	// 选择配送方式 事件
	$('#selway_box').find(':radio').live("click",function(){
		if($(this).attr("clicked") != 'clicked')
		{ 
			// 先全部清除 自定义选择属性
			$('#selway_box').find(':radio').attr("clicked",'');
			// 给当前 赋选择属性
			$(this).attr("clicked",'clicked');
			
			// ajax 调用
			var data = 	"shipping_id="+$(this).val()+
						"&shipping_fee="+$(this).attr('fee')+
						"&active_click="+$('#active_click').val()
						;
			$.ajax({
				type: "POST",
				url: "source/flow_ajax.php?step=change_shipping",
				cache: false,
				data: data+"&m=" + Math.random(),
				beforeSend:function(){
					$('#payment_editbox').html("<img style='margin-left:50px;' src='http://i1.quwan.com/themes/default/imgs/global/loading.gif' />&nbsp;付款方式加载中... ...");
					},
				success:function(data){
					re = $.evalJSON(data);
					if(re.error == 1)
					{
						alert(re.tishi);
						window.location.href="flow.php?step=cart" + "&m=" + Math.random();
						return;
					}
										
					$('#payment_editbox').html(re.content_payment_table);
					$('#now_pay_money').html(re.content_goods_money_table);
					
					// 是否是主动修改（被动修改不显示取消按钮）
					if(re.active_click == 0)
					{
						$('#payway_cbtn').hide();
					}
					
					if(re.pay_show == 0 || re.pay_bouns_tishi == 1)
					{
						$('#bank_box').hide();
						$('#afterpay_box').hide();
						$('#plus20').hide()
					}
					else
					{
						// 在线支付
						if(re.shipping_id == 6)
						{
							$('#bank_box').show();
							$('#afterpay_box').hide();
							$('#radio_5').click();// 支付宝 默认
							$('#plus20').show();
						}
						// 货到付款
						if(re.shipping_id == 15)
						{	
							$('#bank_box').hide();
							$('#afterpay_box').show();
							$('#radio_1').click();// 货到付款 默认
							$('#plus20').hide();
						}
						// 邮政EMS
						if(re.shipping_id == 4)
						{
							$('#bank_box').show();
							$('#afterpay_box').hide();
							$('#radio_5').click();// 支付宝 默认	
							$('#plus20').show();
						}
					}
				}
			})
		}
	});
	
	// 付款与配送方式 确定按钮 操作
	$('#payway_sbtn').live("click",function(){	
	
		//这里编写向服务器提交表单的操作
		var data = 	"shipping_payment_id="+$('#shipping_payment_id').val()+
					"&shipping_id="+$('input[name=shipping_id]:checked').val()+
					"&pay_id="+$('input[name=pay_id]:checked').val()+
					"&now_account_money="+$('#now_account_money').val()+
					"&is_account="+$('#is_account').val()+
					"&enough_account="+$('#enough_account').val()+
					"&enough_bouns="+$('#enough_bouns').val()+
					"&enough_ticket="+$('#enough_ticket').val()
					;
		$.ajax({
			type: "POST",
			url: "source/flow_ajax.php?step=save_payment",
			cache: false,
			data: data+"&m=" + Math.random(),
			beforeSend:function(){},
			success:function(data){
				re = $.evalJSON(data);
				if(re.error == 1)
				{
					alert(re.tishi);
					window.location.href="flow.php?step=cart" + "&m=" + Math.random();
					return;
				}else if(re.error == -2){
					alert("很抱歉，数据库信息有误，请刷新页面。");
					window.location.href="flow.php?step=checkout" + "&m=" + Math.random();
					return;
				}
				
				// 返回界面显示
				// 定义送货方式字符串－得到所选radio项目的自定义属性way
				var deliverway=$('input[name=shipping_id]:checked').attr('way');
				// 定义付款方式字符串－得到所选radio项目的自定义属性way
				var paymentway="";
				// 判断支付方式显示文字
				if($('#enough_account').val() == 1){
					paymentway = '现金账户';
				}else{
					if($('#enough_bouns').val() == 1){
						paymentway = '礼品卡全额支付';
					}else{
						if($('#enough_ticket').val() == 1){
							paymentway = '商品兑换券';
						}else{
							if($('input[name=pay_id]:checked').val()==1 || $('input[name=pay_id]:checked').val()==5 || $('input[name=pay_id]:checked').val()==7 || $('input[name=pay_id]:checked').val()==29){
								paymentway = $('input[name=pay_id]:checked').attr('way');
							}else{
								paymentway = '网银-'+$('input[name=pay_id]:checked').attr('way');
							}
						}
					}
				}
				// 把判断好的配送方式字符串和付款方式字符串填写到确定状态的相应列表里
				$('#payment_okbox').find('p').eq(0).text(deliverway);
				$('#payment_okbox').find('p').eq(1).text(paymentway);
				
				$('#shipping_tishi').remove();// 移除提示信息
				
				$('#payment_modify').html('[修改]');
				
				$('#payment_modify').show();
				$('#shipping_payment_editbox').hide();
				$('#payment_okbox').show();
				$('#win7_tishi').hide();
			}
		})
	});
	
	// 付款与配送方式 取消按钮 操作
	$('#payway_cbtn').live("click",function(){	
		$('#payment_modify').html('[修改]')
		$('#payment_modify').show();
		$('#shipping_payment_editbox').hide();
		$('#payment_okbox').show();
		$('#win7_tishi').hide();
	});
//---------------------------------------------------------------------------------
//	配送 与 支付 方式 各种事件 处理  end
//=================================================================================



//=================================================================================
//	购物凭证  各种事件 处理  start
//---------------------------------------------------------------------------------	
	// 购物凭证修改打开的操作-隐藏确定状态，打开编辑状态
	$('#fp_modify').click(function(){	
		$.ajax({
			type: "POST",
			url: "source/flow_ajax.php?step=show_invoice",
			cache: false,
			data: "&m=" + Math.random(),
			beforeSend:function(){},
			success:function(data){
				re = $.evalJSON(data);
				if(re.error == 1)
				{
					alert(re.tishi);
					window.location.href="flow.php?step=cart" + "&m=" + Math.random();
					return;
				}	
							
				$('.fp_box').addClass('fp_on');
				$('#fp_ok').hide();
				$('#flow_invoice_table').html(re.content_flow_invoive);
				$('#fp_edit').show();
			}
		})
	});
	
	// 选择购物清单　和　购物清单+发票操作
	$('#fp_type').live("click",function(){	
		if($(this).val()==1)
		{
			$('#invoice_title_show').hide();
			$('#invoice_content_show').hide();		
		}
		if($(this).val()==2)
		{
		 	$('#invoice_title_show').show();
			$('#invoice_content_show').show();
			$('.yhq_tip').remove();	// 移除提示抬头信息
		}		
	});
	
	// 购物凭证确定按钮操作
	$('#fp_sbtn').live("click",function(){	
		
		// 判断当选择购物凭证加发票时发票抬头填写与否的操作
		if(($('#fp_type').val()==2)&&($.trim($('#fp_title').val())==""))
		{
			$('#fp_title').parent().next().empty();
			$('#fp_title').parent().next().append("<span class='yhq_tip'>请填写发票抬头！</span>");
			$('#fp_title').focus();
			return;
		}
		else
		{	
			//这里编写向服务器提交表单的ajax等操作
			var data = "invoice_type="+$('#fp_type').val()+
						"&invoice_price="+$('input[name=fp_price]:checked').val()+
						"&invoice_title="+$('#fp_title').val()+
						"&invoice_content="+$('#fp_content').val()
						;
			$.ajax({
				type: "POST",
				url: "source/flow_ajax.php?step=save_invoice",
				cache: false,
				data: data+"&m=" + Math.random(),
				beforeSend:function(){},
				success:function(data){
					re = $.evalJSON(data);
					if(re.error == 1)
					{
						alert(re.tishi);
						window.location.href="flow.php?step=cart" + "&m=" + Math.random();
						return;
					}
					
					$('.fp_box').removeClass('fp_on');		
					$('#fp_ok').show();		
					$('#fp_edit').hide();
					// 填充数据
					// 定义前段显示购物凭证字符串
					var fp_print="";			
					if($('input[name=fp_price]:checked').val()=="1")
					{
						fp_print=$('#fp_type').find('option:selected').text()+"(打印价格)";
					}
					else
					{
						fp_print=$('#fp_type').find('option:selected').text()+"(不打印价格)";
					}
					
					//填写到确定状态的列表
					$('#fp_ok').find('span').eq(0).text(fp_print);
					
					//判断选的是那种购物凭证选项
					if($('#fp_type').val()=="1")
					{
						//不带发票时候的确定状态的列表填写操作
						$('#fp_ok').find('span').eq(1).text("");
						$('#fp_ok').find('span').eq(2).text("");
						$('#fp_ok').find('b').eq(1).hide();
						$('#fp_ok').find('b').eq(2).hide();
					}
					else
					{
						//带发票时候的确定状态的列表填写操作
						$('#fp_ok').find('b').eq(1).show();
						$('#fp_ok').find('b').eq(2).show();
						$('#fp_ok').find('span').eq(1).text($('#fp_title').val());
						$('#fp_ok').find('span').eq(2).text($('#fp_content').find('option:selected').text());
					}
				}
			})
		}
	});
	
	// 购物凭证取消按钮操作
	$('#fp_cbtn').live("click",function(){	
		$('.fp_box').removeClass('fp_on');						 
		$('#fp_ok').show();	
		$('#fp_edit').hide();
	});	
//---------------------------------------------------------------------------------
//	购物凭证 各种事件 处理  end
//=================================================================================



//=================================================================================
//	订单提交按钮  事件 处理  start
//---------------------------------------------------------------------------------	
	//提交订单按钮操作
	$('#porder_btn').click(function(){	
		
		//清空提交按钮下方提示文字
		$('#porder_btn').parent().next().empty(); 
		
		//判断3项信息是否都确定只有确定后才能执行提交操作
		if($('#addr_editbox').css('display')=='block')
		{
			// 展开后定位
			var pos = $("#addr_edit_table").offset().top;
			$("html,body").animate({scrollTop: pos}, 10);
			$('#addr_btnul').find('li').eq(3).html("<span class='yhq_tip'>请确认收货人信息，再提交订单！</span>")
			$('#porder_btn').parent().next().append("<span class='yhq_tip'>请确认收货人信息，再提交订单！</span>");	
			return;
		}
		if($('#shipping_payment_editbox').css('display')=='block')
		{
			// 展开后定位
			var pos = $("#payment_editbox").offset().top;
			$("html,body").animate({scrollTop: pos}, 10);
			$('#pay_btnul').html("<span class='yhq_tip'>请确认配送与付款方式，再提交订单！</span>")
			$('#porder_btn').parent().next().append("<span class='yhq_tip'>请确认配送与付款方式，再提交订单！</span>");	
			return;
		}
		if($('.fp_box').hasClass('fp_on'))
		{
			//alert('请确定购物凭证，再提交订单！');
			$('#fp_btnul').html("<span class='yhq_tip'>请确定购物凭证，再提交订单！</span>")
			$('#porder_btn').parent().next().append("<span class='yhq_tip'>请确定购物凭证，再提交订单！</span>");	
			return;
		}	
			
		//这里编写向服务器提交表单的ajax等操作
		$.ajax({
			type: "POST",
			url: "source/flow_ajax.php?step=flow_done",
			cache: false,
			data: "m=" + Math.random(),
			beforeSend:function(){
				//加载正在处理中按钮样式
				$('#porder_btn').addClass('orderp_btn');
				},
			success:function(data){
				re = $.evalJSON(data);
				if(re.error == 1)
				{
					alert(re.tishi);
					window.location.href="flow.php?step=cart" + "&m=" + Math.random();
					return;
				}
				else if(re.error == 2)
				{
					alert(re.tishi);
					window.location.href="flow.php?step=consignee";
					return;
				}
				//如果地址信息不匹配，展开地址信息
				else if(re.error == 3)
				{
					alert(re.tishi);
						//--------mwq add for收货地址验证
						$.ajax({
									type: "POST",
									url: "source/flow_ajax.php?step=consignee_list",
									cache: false,
									data: "&m=" + Math.random(),
									beforeSend:function(){$('#addr_modify').html('[获取中... ...]')},
									success:function(data){
										re = $.evalJSON(data);
										if(re.error == 1)
										{
											alert(re.tishi);
											window.location.href="flow.php?step=cart" + "&m=" + Math.random();
											return;
										}	
										else if(re.error == 2)
										{
											alert(re.tishi);
											window.location.href="flow.php?step=consignee";
											return;
										}
													
										$('#addr_modify').hide();
										$('#addr_okbox').hide();
										$('#addr_editbox').show();
										$('#addr_editbox').html(re.content_list);
										$('#addr_edit_table').html(re.content_table);
									}
								});
								var pos = $("#main").offset().top;
    							$("html,body").animate({scrollTop: pos}, 10);
//								$('#porder_btn').show();
								$('#porder_btn').removeClass('orderp_btn');
//								$('.loading').hide();
							//----------
					return;
				}
				
				$('#porder_btn').removeClass('orderp_btn');
				if(re.is_normal == 1)
				{
					$('#payment_modify').hide();
					$('#payment_okbox').hide();
					$('#shipping_payment_editbox').show();
					$('#shipping_editbox').html(re.content_shipping_table);
					$('#payment_editbox').html(re.content_payment_table);
					if(re.pay_show == 0 || re.pay_bouns_tishi == 1)
					{
						$('#bank_box').hide();
						$('#afterpay_box').hide();
					}
					if(re.tishi != null)
					{
						$('#wp_title').append('<span class="yhq_tip" id="shipping_tishi">'+re.tishi+'</span>');// 装载提示信息
					}
					$('#payway_cbtn').hide();// 取消按钮隐藏
					// 展开后定位
					var pos = $("#wp_title").offset().top;
    				$("html,body").animate({scrollTop: pos}, 10);
				}
				else
				{
					if(re.submit_ok == 1)
					{
						// 成功提交订单逻辑
						window.location.href = "flow.php?step=done&id="+re.id;
					}
					else
					{
						// 数据有变处理逻辑
						alert(re.tishi);
						window.location.href="flow.php?step=cart" + "&m=" + Math.random();
					}
				}
			}
		})
		
		//然后收起编辑状态，打开确定状态
		//$('#porder_btn').removeClass('orderp_btn');
		
	});
//---------------------------------------------------------------------------------
//	订单提交按钮 事件 处理  end
//=================================================================================



});




// 收货地址检测
function checkaddr()
{
	//判断收货人姓名填写
	if($.trim($('#consignee').val())=="")
	{			
		$('#consignee').parent().parent().find('li:last').empty();
		$('#consignee').parent().parent().find('li:last').html("<span class='yhq_tip'>请填写收货人姓名！</span>");	
		$('#consignee').focus();
		return false; 
	}
	else
	{
		$('#consignee').parent().parent().find('li:last').empty();
	}
	
	//判断省份填写
	if($('#selProvinces').val()=="0")
	{
		$('#selProvinces').parent().parent().find('li:last').empty();
		$('#selProvinces').parent().parent().find('li:last').html("<span class='yhq_tip'>请选择省份！</span>");	
		$('#selProvinces').focus();
		return false; 
	}
	else
	{
		$('#selProvinces').parent().parent().find('li:last').empty();
	}
	
	if($('#s1Province').val()=="0")
	{
		$('#s1Province').parent().parent().find('li:last').empty();
		$('#s1Province').parent().parent().find('li:last').html("<span class='yhq_tip'>请选择省份！</span>");	
		$('#s1Province').focus();
		return false; 
	}
	else
	{
		$('#s1Province').parent().parent().find('li:last').empty();
	}
	
	
	
	//判断城市填写
	if($('#selCities').val()=="0")
	{
		$('#selCities').parent().parent().find('li:last').empty();
		$('#selCities').parent().parent().find('li:last').html("<span class='yhq_tip'>请选择城市！</span>");	
		$('#selCities').focus();
		return false; 
	}
	else
	{
		$('#selCities').parent().parent().find('li:last').empty();
	}
	
	if($('#s2City').val()=="0")
	{
		$('#s2City').parent().parent().find('li:last').empty();
		$('#s2City').parent().parent().find('li:last').html("<span class='yhq_tip'>请选择城市！</span>");	
		$('#ss2City').focus();
		return false; 
	}
	else
	{
		$('#s2City').parent().parent().find('li:last').empty();
	}
	
	//判断市区填写
	if($('#selDistricts').val()=="0" && $('#selDistricts').css('display') != 'none')
	{
		$('#selDistricts').parent().parent().find('li:last').empty();
		$('#selDistricts').parent().parent().find('li:last').html("<span class='yhq_tip'>请选择区县！</span>");	
		$('#selDistricts').focus();
		return false; 
	}
	else
	{
		$('#selDistricts').parent().parent().find('li:last').empty();
	}
	
	if($('#s3Area').val()=="0" && $('#s3Area').css('display') != 'none')
	{
		$('#s3Area').parent().parent().find('li:last').empty();
		$('#s3Area').parent().parent().find('li:last').html("<span class='yhq_tip'>请选择区县！</span>");	
		$('#s3Area').focus();
		return false; 
	}
	else
	{
		$('#selDistricts').parent().parent().find('li:last').empty();
	}
	
	
	//判断详细地址填写
	if($.trim($('#address').val())=="")
	{
		$('#address').parent().parent().find('li:last').empty();
		$('#address').parent().parent().find('li:last').html("<span class='yhq_tip'>请填写详细地址！</span>");	
		$('#address').focus();
		return false; 
	}
	else
	{
		$('#address').parent().parent().find('li:last').empty();
	}
	
	//判断电话和手机填写
	if(($.trim($('#mobile').val())=="")&&($.trim($('#tel').val())==""))
	{  
		$('#mobile').parent().parent().find('li:last').empty();
		$('#mobile').parent().parent().find('li:last').html("<span class='yhq_tip'>手机和固定电话至少填写一项！</span>");	
		$('#mobile').focus();
		return false;
	}
	else
	{
		$('#mobile').parent().parent().find('li:last').empty();
		//判断手机号码格式
		if($('#mobile').val()!="")
		{	
			// 支持现有号段手机号码	
			//var filter=/^13[0-9]{9}|15[012356789][0-9]{8}|18[0256789][0-9]{8}|147[0-9]{8}$/;  	
			//if (!filter.test($('#mobile').val())) 
			if(!(Tools.isTel($('#mobile').val())))
			{ 
				$('#mobile').parent().parent().find('li:last').html("<span class='yhq_tip'>手机号码的格式不正确！</span>");					
				$('#mobile').focus();
				return false; 
			}
		}
		//判断电话格式
		if($('#tel').val()!="")
		{	
			// 支持 3-4位区号  7-8位直播号  1-4位分机号
			//var filter=/^[0-9- ]{7,20}$/	  		
			//if (!filter.test($('#tel').val())) 
			if(!(Tools.isTel($('#tel').val())))
			{ 
				$('#tel').parent().parent().find('li:last').html("<span class='yhq_tip'>固定电话的格式不正确！</span>");					
				$('#tel').focus();
				return false; 
			}
		}
	}	
	return true;
}





/******************region.js*******************************/

var region = new Object();

region.isAdmin = false;

region.loadRegions = function(parent, type, target)
{
$.ajax({
     type: "GET",
     url: region.getFileName(),
     data: 'type=' + type + '&target=' + target + '&parent='+parent + "&m=" + Math.random(),
     success:region.response
  });
}

/* *
 * 载入指定的国家下所有的省份
 *
 * @country integer     国家的编号
 * @selName string      列表框的名称
 */
region.loadProvinces = function(country, selName)
{
  var objName = (typeof selName == "undefined") ? "selProvinces" : selName;

  region.loadRegions(country, 1, objName);
}

/* *
 * 载入指定的省份下所有的城市
 *
 * @province    integer 省份的编号
 * @selName     string  列表框的名称
 */
region.loadCities = function(province, selName)
{
  var objName = (typeof selName == "undefined") ? "selCities" : selName;

  region.loadRegions(province, 2, objName);
}

/* *
 * 载入指定的城市下的区 / 县
 *
 * @city    integer     城市的编号
 * @selName string      列表框的名称
 */
region.loadDistricts = function(city, selName)
{
  var objName = (typeof selName == "undefined") ? "selDistricts" : selName;

  region.loadRegions(city, 3, objName);
}

/* *
 * 处理下拉列表改变的函数
 *
 * @obj     object  下拉列表
 * @type    integer 类型
 * @selName string  目标列表框的名称
 */
region.changed = function(obj, type, selName)
{
  var parent = obj.options[obj.selectedIndex].value;

  region.loadRegions(parent, type, selName);
}

region.response = function(result, text_result)
{
  result = $.evalJSON(result);
  var sel = document.getElementById(result.target);
  sel.length = 1;
  sel.selectedIndex = 0;
  sel.style.display = (result.regions.length == 0 && ! region.isAdmin && result.type + 0 == 3) ? "none" : '';

  if (document.all)
  {
    sel.fireEvent("onchange");
  }
  else
  {
    var evt = document.createEvent("HTMLEvents");
    evt.initEvent('change', true, true);
    sel.dispatchEvent(evt);
  }

  if (result.regions)
  {
    for (i = 0; i < result.regions.length; i ++ )
    {
      var opt = document.createElement("OPTION");
      opt.value = result.regions[i].region_id;
      opt.text  = result.regions[i].region_name;

      sel.options.add(opt);
    }
  }
}

region.getFileName = function()
{
  if (region.isAdmin)
  {
    return "../region.php";
  }
  else
  {
    return WEB+"region.php";
  }
}


/******************************************************************/
/* *
 * 修改购买数量：页面
 */
function addorminus(opr,goods_id,rec_key)
{
  var forenum = Number($('#num_input_' + rec_key).attr('objNum'));
  var new_val = Number($('#num_input_' + rec_key).val());
  var price = Number($('#goods_price_' + rec_key).val());
  var jifen = Number($('#jifen_' + rec_key).val());
  var num = 0;
  var subtotal = 0;
  var totalprice = Number($('#totalprice').val());
  var totalamount = Number($('#totalamount').val());
  var totalhgintegral = Number($('#totalhgintegral').val());
  switch(opr)
  {
    case "add":
      num = parseInt(new_val) + 1;

      $('#num_input_' + rec_key).val(num);
      $('#num_input_' + rec_key).focus();
      $('#num_input_' + rec_key).blur();
      
    break
    case "minus":
      if (new_val >=2)
      {
        num = parseInt(new_val) - 1;

        $('#num_input_' + rec_key).val(num);
        $('#num_input_' + rec_key).focus();
        $('#num_input_' + rec_key).blur();
        
      }
    break
    case "change":
      if (new_val >=1)
      { 
        num = parseInt(new_val);
        var change = Number(num - forenum);
        subtotal = formatPrice(Number(price * num));
        totalprice = formatPrice(Number(totalprice + change*price));
        totalamount = formatPrice(Number(totalamount + change*price));
        totalhgintegral = Number(totalhgintegral + change*jifen);
        $('#subtotal_' + rec_key).html('¥'+subtotal);
        if(totalprice == totalamount)
        {
            $('#total_price').html('<span>花费积分：'+totalhgintegral+'</span>应付商品金额（不含运费）：<font>¥'+ totalprice +'</font>');
            $('#totalprice').val(totalprice);
            $('#total_amount').hide();
            $('#total_amount').html('应付商品金额（不含运费）：<font>¥'+ totalamount +'</font>');
            $('#totalamount').val(totalamount);
            $('#totalhgintegral').val(totalhgintegral);
        }else
        {
            $('#total_price').html('<span>花费积分：'+totalhgintegral+'</span>商品金额（不含运费）：<b>¥'+ totalprice +'</b>');
            $('#totalprice').val(totalprice);
            $('#total_amount').html('应付商品金额（不含运费）：<font>¥'+ totalamount +'</font>');
            $('#totalamount').val(totalamount);
            $('#totalhgintegral').val(totalhgintegral);
        }
        
        
        $('#num_input_' + rec_key).attr('objNum',num);
      }
    break
  }
}

/* *
 * 修改购买数量：数据库
 */
function updatecart(goods_id,rec_key){

  obj =$('#num_input_' + rec_key);

  var forenum = obj.attr('objNum',forenum);
  var num = obj.val()||forenum;

  //num =num.replace(/[^0-9]/g,'');
  //格式有误
  if(isNaN(num))
  {
    obj.val(forenum);
    return false;
  }else{ 
    num = parseInt(num);
    if(isNaN(num))
    {
      obj.val(forenum);
      return false;
    }

    if(num=='' || num == '0' ||num <= 0){
      obj.val(forenum);
      return false;
    }else{
      //数量没有改变
      if(forenum == num){
        obj.val(forenum);
        return false;
      }
      obj.val(num);
    }
  }
  addorminus('change',goods_id,rec_key)

  $.ajax({
     type: "POST",
     url: "source/flow_ajax.php?step=update_cart",
     data: 'goods_id=' + goods_id + '&goods_number=' + num + '&rec_key=' + rec_key + "&m=" + Math.random(),
     //success:,
     complete:function(XMLHttpRequest)
     {
         var result = $.evalJSON(XMLHttpRequest.responseText);
          if(result.error == -1)
          {
            //参数错误
            window.location.reload();
          }else
          {
            //商品被自动删除 后购物车没有主商品
            if(result.error == 2)
            {
                if(result.content.deal == 1)
                {
                    alert(result.message);
                }
                CartEmptyResponse(result);
            }
            else
            {
                //商品被自动删除
                if(result.error == 1)
                {
                    alert(result.message);
                    $('#goods_'+rec_key).hide();
                }
                //正常修改数量(包括数量超过库存，修改为原来的数量)
                else
                {
                    obj.val(result.content.goods_number);
                    obj.attr('objNum',result.content.goods_number);
                    $('#subtotal_'+rec_key).html('¥'+result.content.subtotal+'元');
                    if(result.message != '')
                    {
                        $('#num_tip_'+rec_key).html(result.message);
                        $('#num_tip_'+rec_key).show();
                    }else
                    {
                        $('#num_tip_'+rec_key).hide();
                    }
                }
                
                //自动删除赠品的提示
                if(result.content.tishi_delete_favor != '')
                {
                  $('#delete_favor').html(result.content.tishi_delete_favor);
                  $('#delete_favor').show();
                }
                 
                //引起其他区域变化
                if(result.content.youhui_show == 0)
                {
                  $('.fav_box').hide();//优惠活动
                }else if(result.content.youhui_show == 1)
                {
                  $('.fav_box').show();//优惠活动
                  $('.yh_box').hide();//优惠活动上半区域
                }else if(result.content.youhui_show == 2)
                {
                  $('.fav_box').show();//优惠活动
                  $('.yh_box').show();//优惠活动上半区域
                }
                //优惠活动赠品区域
                if(result.content.favor_out_cart > 0)
                {
                  $('#zengpin_area').show();
                }else
                {
                  $('#zengpin_area').hide();
                }
                $('#zengpin_area').html(result.content.zengpin_area);
                
                $('#cart_favor_area').html(result.content.cart_favor_area);
                $('#bonus_list_area').html(result.content.bonus_list_area);
                $('#total_area').html(result.content.total_area);
                $('#shipping_area_top').html(result.content.shipping_area.top);
                $('#shipping_area_down').html(result.content.shipping_area.down);
              
                $('#discount_area').html(result.content.discount_area);
                $('#bonus_area').html(result.content.bonus_area);
                
                //主商品关联赠品
                var have_gift_goods_key = result.content.have_gift_goods_key;
                var have_gift_goods_key_num = result.content.have_gift_goods_key.length;
                if(have_gift_goods_key_num > 0)
                {
                  for(i = 0; i < have_gift_goods_key_num; i++)
                  {
                    $('#goods_'+ have_gift_goods_key[i].rec_key).find('.del_opt').attr('gift', have_gift_goods_key[i].have_gift);
                  }
                }
                
                if(result.content.bonus_tishi != '')
                {
                    $("#yhq_tip_1").show();
                    $("#yhq_tip_1").html("<span class=\"yhq_tip\">"+result.content.bonus_tishi+"</span>");
                }
                
                yhq_list();//加载优惠券列表的js效果函数
            }
          }
    
     }
  });
  
}

/* *
 * 购物车主商品为空时，页面变化
 */
function CartEmptyResponse(result)
{
    //没有任何商品
   if(result.content.cart_goods_area != '')
   {
     $('#cart_goods_area').html(result.content.cart_goods_area);//商品区域
     $('.check_btn').hide();//去结算按钮
     $('.fav_box').hide();//优惠活动
     $('#shipping_area_top').html('');//上方运费提示
     $('#total_area').html('');
   }
   //有奖品
   else
   {
     $('#cart_goods_area').empty();//主商品区域
    
     //去结算按钮
     $('.check_btn').attr('id','');
     $('.check_btn').attr('href','lottery.php?act=fetch_rewards&step=add_address&m='+Math.random());
     
     $('#shipping_area_top').html(result.content.shipping_area.top);
     $('#shipping_area_down').html(result.content.shipping_area.down);
     $('.fav_box').show();//优惠活动
     $('.yh_box').show();//优惠活动上半区域
     $('#discount_area').empty();//折扣区域
     $('#bonus_area').empty();//返券区域
     $('#zengpin_area').hide();//返券区域
     $('#total_area').html(result.content.total_area);
   }
   
   $('#cart_info').show();//优惠券列表和金额总计区域
   $('#bonus_list_area').html(result.content.bonus_list_area);
   yhq_list();//加载优惠券列表的js效果函数
   $('#cart_favor_area').empty();//赠品区域
   
   //自动删除赠品的提示
   if(result.content.tishi_delete_favor != '')
   {
     $('#delete_favor').html(result.content.tishi_delete_favor);
     $('#delete_favor').show();
   }
}

/* *
 * 主商品加入购物车，页面局部更新（最受欢迎小玩意、兑换券商品）
 */
function AddToCartResponse(result)
{
    //去结算按钮
    $('.check_btn').eq(0).attr('id','checkout1');
    $('.check_btn').eq(1).attr('id','checkout2');
    $('.check_btn').removeAttr('href');
    
    //更新或者新增主商品
    if(result.content.new_goods != '')
    {
        if($('#cart_goods_area').find('table').length > 0)
        {
          $('.cart_goods_area:last').after(result.content.new_goods);
        }else
        {
          $('#cart_goods_area').html(result.content.new_goods);
          $('.check_btn').show();
        }
    }else
    {
        //兑换券商品更新数量
        if(result.content.is_ticket == true)
        {
            $('#num_input_'+ result.content.rec_key).html(result.content.old_goods.goods_number);
            $('#subtotal_'+ result.content.rec_key).html(result.content.old_goods.subtotal);
            
        }else
        {
            $('#num_input_'+ result.content.rec_key).val(result.content.old_goods.goods_number);
            $('#num_input_' + result.content.rec_key).attr('objNum',result.content.old_goods.goods_number);
            $('#subtotal_' + result.content.rec_key).html('¥'+result.content.old_goods.subtotal);
            
        }
        $('#goods_'+ result.content.rec_key).find('.del_opt').attr('gift', result.content.old_goods.have_gift);
    }
    
    //自动删除赠品的提示
    if(result.content.tishi_delete_favor != '')
    {
      $('#delete_favor').html(result.content.tishi_delete_favor);
      $('#delete_favor').show();
    }
    
    if(result.content.youhui_show == 0)
    {
      $('.fav_box').hide();//优惠活动
    }else if(result.content.youhui_show == 1)
    {
      $('.fav_box').show();//优惠活动
      $('.yh_box').hide();//优惠活动上半区域
    }else if(result.content.youhui_show == 2)
    {
      $('.fav_box').show();//优惠活动
      $('.yh_box').show();//优惠活动上半区域
    }
    
    //优惠活动赠品区域
    if(result.content.favor_out_cart > 0)
    {
      $('#zengpin_area').show();
    }else
    {
      $('#zengpin_area').hide();
    }
    $('#zengpin_area').html(result.content.zengpin_area);
    
    $('#cart_favor_area').html(result.content.cart_favor_area);
    $('#cart_info').show();//优惠券列表和金额总计区域
      
    if(result.content.is_ticket == false)
    {
      $('#bonus_list_area').html(result.content.bonus_list_area);
    }
      
    $('#total_area').html(result.content.total_area);
    $('#shipping_area_top').html(result.content.shipping_area.top);
    $('#shipping_area_down').html(result.content.shipping_area.down);
    
    $('#discount_area').html(result.content.discount_area);
    $('#bonus_area').html(result.content.bonus_area);
    $('#ticket_area').html(result.content.ticket_area);
    
    //主商品关联赠品
    var have_gift_goods_key = result.content.have_gift_goods_key;
    var have_gift_goods_key_num = result.content.have_gift_goods_key.length;
    if(have_gift_goods_key_num > 0)
    {
        for(i = 0; i < have_gift_goods_key_num; i++)
        {
          $('#goods_'+ have_gift_goods_key[i].rec_key).find('.del_opt').attr('gift', have_gift_goods_key[i].have_gift);
        }
    }
    
    if(result.content.bonus_tishi != '')
    {
        $("#yhq_tip_1").show();
        $("#yhq_tip_1").html("<span class=\"yhq_tip\">"+result.content.bonus_tishi+"</span>");
    }
    
    yhq_list();//加载优惠券列表的js效果函数
}

/* *
 * 改变红包
 */
function changeBonus(val,amount)
{
    var totalprice = Number($("#totalprice").val());
    var totaldiscount = Number($("#totaldiscount").val());
    var totalhgintegral = Number($('#totalhgintegral').val());
    amount = Number(amount);
    var totalamount = Number(totalprice - amount - totaldiscount);
    
    if(totalamount < 0){
        totalamount = 0;
    }
    
    if( Number(amount) > 0){
        
        $("#total_bonus").html('优惠券折扣：<b>-¥' + formatPrice(amount) + '</b>');
    }else{
        $("#total_bonus").html('');
    }
    
    totalprice = formatPrice(totalprice);
    totalamount = formatPrice(totalamount);
    if(totalprice == totalamount)
    {
        $('#total_price').html('<span>花费积分：'+totalhgintegral+'</span>应付商品金额（不含运费）：<font>¥'+ totalprice +'</font>');
        $('#totalprice').val(totalprice);
        $('#total_amount').hide();
        $('#total_amount').html('应付商品金额（不含运费）：<font>¥'+ totalamount +'</font>');
        $('#totalamount').val(totalamount);
    }else
    {
        $('#total_price').html('<span>花费积分：'+totalhgintegral+'</span>商品金额（不含运费）：<b>¥'+ totalprice +'</b>');
        $('#totalprice').val(totalprice);
        $('#total_amount').html('应付商品金额（不含运费）：<font>¥'+ totalamount +'</font>');
        $('#totalamount').val(totalamount);
    }

    
    $.ajax({
     type: "POST",
     url: "source/flow_ajax.php?step=change_bonus",
     cache: false,
     data: 'bonus=' + val + '&amount=' + amount + '&m=' + Math.random(),
     success:changeBonusResponse
   });
}



/* *
 * 改变红包的回调函数
 */
function changeBonusResponse(A)
{
    $("#yhq_tip_1").empty();
    $("#yhq_tip_1").hide();
    var result = $.evalJSON(A);
    
    //alert(result.error);
    //alert(result.message);
    //未登录
    if(result.error == -1)
    {
       $('#login_js_tishi').html('很抱歉，登录后才可使用优惠券。');
       $('#login_js_tishi').show();
       popdiv("#login_pop","620","auto",0.4);
    }
    //购物车没商品
    else if(result.error == 2)
    {
       CartEmptyResponse(result);
    }
    else
    {
        //判断是否隐藏优惠活动赠品区域
        var count_gift = Number($('#count_gift').val());
        
        //判断整个优惠活动不要错误区域是否显示
       if(result.content.youhui_show ==1 && count_gift == 0)
       {
         $('.fav_box').hide();//优惠活动
       }else
       {
         if(result.content.youhui_show == 1)
         {
           $('.fav_box').show();//优惠活动
           $('.yh_box').hide();//优惠活动上半区域
         }else if(result.content.youhui_show == 2)
         {
           $('.fav_box').show();//优惠活动
           $('.yh_box').show();//优惠活动上半区域
         }
       }

       $('#total_area').html(result.content.total_area);
       $('#discount_area').html(result.content.discount_area);
       $('#bonus_area').html(result.content.bonus_area);
    }
}

/* *
 * 购物车页面 验证优惠券
 */
function addBonus(bonusSn){
    
  $("#yhq_tip_2").empty();
  $("#yhq_tip_2").hide();
  if (bonusSn == '')
  {
    //优惠券号码为空
    $("#bonus_captcha").val('');
  }else
  {
    if($('.yhqyzm_box').css("display")!="none"){
		captcha = '&captcha=' +$("#bonus_captcha").val();
	}else{
	    captcha = '';
	}
    
    $.ajax({
     type: "POST",
     url: "user.php?act=ajax_act_add_bonus",
     data: 'bonus_sn=' + bonusSn + captcha + '&m=' + Math.random(),
     success:addBonusResponse
    });
  }
}
/* *
 * 购物车页面 验证优惠券回调函数
 */
function addBonusResponse(A)
{
    $("#bonus_sn").val('');
    $("#bonus_captcha").val('');
    
    var result = $.evalJSON(A);
    //alert(result.error);

    //数据库异常
    if(result.error == -3)
    {
       alert(result.message);
       window.location.reload();
    }
    //参数错误
    else if(result.error == -1){
       window.location.reload();
    }
    //用户未登录弹出登录层
    else if(result.error == -2){
       $('#login_js_tishi').html('很抱歉，登录后才可使用优惠券。');
       $('#login_js_tishi').show();
       popdiv("#login_pop","620","auto",0.4);
    }
    //兑换券商品缺货 弹出提示层
    else if(result.error == 2 && result.content.is_ticket == true)
    {
        $('#AddBooking').attr('href','user.php?act=add_booking&id='+result.content.ticket_goods);
        popdiv("#quehuo_pop","297","auto",0.4);
    }
    //无法绑定  显示提示信息
    else if(result.error == 1)
    {
        //验证码是否显示
        if(result.content == 1){
            $(".yhqyzm_box").show();
        }else{
            $(".yhqyzm_box").hide();
        }
        
        $("#yhq_tip_2").show();
        $("#yhq_tip_2").html("<span class=\"yhq_tip\">"+result.message+"</span>");
    }
    //绑定成功
    else if(result.error == 0)
    {
        if(result.content.is_ticket == true)
        {
            AddToCartResponse(result);
            $("#use_quan").append('<div class="pop_tip" id="use_quan_tip"><span>已放入购物车，您可以继续使用兑换券</span><div class="poptip_bar"></div></div>');
            setTimeout('$("#use_quan_tip").remove()',2000);
        }else
        {
            $("#bonus_list_area").html(result.content.bonus_list_area);//重新加载优惠券列表
            if(result.message != '')
            {
                $("#yhq_tip_1").show();
                $("#yhq_tip_1").html("<span class=\"yhq_tip\">"+result.message+"</span>");
            }else
            {
                changeBonus(result.content.bonus_id, result.content.type_money);//使用当前优惠券
            }
            yhq_list();//加载优惠券列表的js效果函数
        }
    }
}

/* *
 * 优惠券列表的js效果函数
 */
function yhq_list()
{
    $('.yhq_select').hover(function(){	

	if($('.yhq_list').css("display")=="none")
	{   
	    if($('.yhq_list').find('dd').length>=10)
		{
			$('.yhq_list').addClass('maxyhq');
		}
		else
		{
			$('.yhq_list').removeClass('maxyhq');
		}
		$('.yhq_list').show();	
		$('.yhq_selected').addClass('yhq_hover');			
	}	
    }, function(){											  
	$('.yhq_list').hide();	
    });

    $('.yhq_list').find('dd').hover(function(){											  
    	$(this).addClass('yhq_hover').siblings().removeClass('yhq_hover');;											  
    }, function(){		
    	$(this).removeClass('yhq_hover');
    });

    $('.yhq_list').find('dd').not('.yhq_off').click(function(){	
	$('#yhq_input').val($(this).html());
	$(this).addClass('yhq_selected').siblings().removeClass('yhq_selected');	
	$('.yhq_list').hide();
    	
    var bonus = $(this).attr('bonus');
    var amount = $(this).attr('amount');
    changeBonus(bonus,amount);
    
    });
    
    //IE7下解决优惠券列表不能自适应宽度的问题　//新添
    if($.browser.msie){ 
    $('.yhq_list').show();
    var yhq_listmax = $('.yhq_list').find('dd').eq(0).width(); 
    $('.yhq_list dd').each(function(){
    
    	if ($(this).width() > yhq_listmax) 
    	{ 
    	yhq_listmax = $(this).width(); 
    	}
    	
    });
    $('.yhq_list dd').width(yhq_listmax);
    if($('.yhq_list').find('dd').length>=10)
    {
    	$('.yhq_list').width(yhq_listmax+30);
    }
    $('.yhq_list').hide();
    }
}

/* *
 * 返回格式化价格 **.**
 */
function formatPrice(A){
    B = Math.round(Number(A)*100)/100;
    B = String(B);
    if(B.indexOf('.') == -1){
        B = B+'.00';
    }else{
        var C =B.substring(B.indexOf('.')).length;
        if(C == 2)
        {
            B = B+'0';
        }
    }
    return B;
}


// 关闭弹出层窗口
$(".close").live("click", function(){
	$("#popbg").fadeOut();
	$(".pop_out").fadeOut();
	});	

$(".cancle_btn").live("click", function(){
	$("#popbg").fadeOut();
	$(".pop_out").fadeOut();
	});
	

	
