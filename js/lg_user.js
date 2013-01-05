// JavaScript Document
var lc={time:"NULL"};
function checkphone(){
var Testphone = /^1[3|5|8][0-9]\d{4,8}$/;
	if(0==$("#selCities_").val()){ alert('请填写配置区域');return false;}
	if("" == $("#address_").val()){alert('请填写街道地址');return false;}
	if("" == $("#consignee_").val()){alert('请填写收货人');return false;}
	if(!Testphone.test($("#mobile_").val())){alert('请填写正确手机号码');return false;}
	LG.appendbody($("#mobile_").val());
	$.post("sms.php",{act:'getCode',phone:$('#mobile_').val()},function(MSG){
	
		 lc.time=window.setInterval("LG.countdown()",1000); 
		});

$("#yes").click(function(){
	$.post("sms.php",{act:'validateCode',code:$('#usercode').val()},function(MSG){
	    if(MSG=="1"){
			//验证成功 
			
			LG.resetbody();
			LG.checksuccess();
			window.setTimeout("LG.submitto()",1000);
			}else{
				alert('验证失败;返回重新验证！');
				LG.resetbody();
				}
		});
	});

$("#resetform").click(function(){
 LG.resetbody();
	  })

	
	return false;
	}
	
	
	
var LG={
	    appendbody:function(phone){
		 $("body").append("<div id='FLOATMASK' style='position:absolute; z-index:1; left:0; top:0; width:100%; height:1000px; '></div");
		  $("#FLOATMASK").append("<div id='MASK' style='position:absolute; z-index:10; left:0; top:0; width:100%; height:1000px; background:#CCC; filter:alpha(Opacity=80);-moz-opacity:0.5;opacity: 0.5;'></div");

	     $("#FLOATMASK").append("<div class='registerphone' ><p class='reg_1'>手机号码："+phone+" 已向号码发送免费发送短信</p><p class='reg_2'><input type='text' id='usercode' maxlength='6'/></p><p class='reg_3' id='reg_3'><a class='yes' id='yes' href='#'>验证</a><a class='no' href='#'><i>60</i>&nbsp;秒后重新发送</a></p><p class='reg_4'>如果您在一分钟内没有收到效验码请重新发送 或 <a class='resetform' id='resetform' href='#'>返回修改手机号</a></p></div>");
		},
		resetbody:function(){
			 $("#FLOATMASK").remove();
			  
			},
		countdown:function(){
			var T=parseInt($(".registerphone i").text())-1;
			if(T>0){
			     $(".registerphone i").html(T);
		     	}else{
				 window.clearInterval(lc.time);
				   $(".registerphone .reg_3 .yes").fadeOut('flow');
				 $(".registerphone input").after("<a href='#' onclick='LG.resend()'>重新发送</a>");
				}
			},
			checksuccess:function(){
				 $("body").append("<div id='FLOATMASK' style='position:absolute; z-index:1; left:0; top:0; width:100%; height:1000px; '></div");
		  $("#FLOATMASK").append("<div id='MASK' style='position:absolute; z-index:10; left:0; top:0; width:100%; height:1000px; background:#CCC; filter:alpha(Opacity=80);-moz-opacity:0.5;opacity: 0.5;'></div");

	     $("#FLOATMASK").append("  <div class='registerphone' ><p class='reg2_0'>&nbsp;</p><p class='reg2_1'><img src='/html/images/register2_bg.gif'/>恭喜您，验证成功！ </p><p class='reg2_2' id='reg_3'>    页面正在跳转。请稍候...   </p><p class='reg_4'>如果您在一分钟内没有收到效验码请重新发送 或 <a class='resetform' id='resetform' href='#'>返回修改手机号</a></p></div>");
				},
			submitto:function(){
				$("form").submit();
				},
			resend:function(){
				this.resetbody();
				checkphone();
				}	
			
	}	