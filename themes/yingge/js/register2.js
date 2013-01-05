var reg = function(page,uid){	
	this.box = $("#reg_box");	//表单
	this.input = this.box.find("span.at_text>input");
	this.u = $("#u_name");		//用户名
	this.sugNameCon = this.u.parent().parent();//放置推荐用户名的位置
	this.uCheck = false;
	this.p = $("#u_pas");		//密码
	this.pCheck = false;
	this.p1 = $("#u_pas1");		//确认密码
	this.p1Check = false;
	this.p2 = $("#o_pas");		//当前密码
	this.p2Check = false;
	this.e = $("#e_name");		//邮箱
	this.eCheck = false;	
	this.m = $("#p_name");		//手机	
	this.mCheck = false;
	this.ca=$("#catcha");   //验证码
	this.cacheck = false;
	this.btn = $("#reg_sub");	//提交按钮	

	this.c = $("#auto_login");	//同意协议
	
	this.q = $("#strong");		//密码强度
	this.uid = uid||null;		//重设密码时返回的用户名
	var me = this;  //page  1快速 2邮箱 3手机 4修改密码 5创建安全密码 6修改安全密码 7重设密码 
	
	var isloading=false;
	
	//提示信息
	var h_on='<em class="on">';	
	var h_err = '<em class="orr"><u class="at_msg m_3_e"></u>';
	var h_pas = '<u class="at_passking"><s class="at_txt">安全等级：</s><s class="at_bar"><span></span><span></span><span class="at_end"></span></s></u>';
	var name_o = h_on+'<span id="namecount">·4-16个字符，1个汉字为2个字符<br />·不能以数字开头</span></em>';
	var same_pas='·密码不能包含用户名<br />';
	//if(page=1||page=2||page=3) same_pas='';
	var pas_o = h_on+'<u class="at_msg m_3_i"></u>'+h_pas+'<br class="clear" />·密码由6~16位字母、数字或特殊符号组成<br /><a class="pas_link blue1 ml10" href="http://help.zhubajie.com/main/view/id-370.html" target="_blank">如何设置高强度的密码？</a></em>';	
	var pas_o1 = h_on+'·再一次输入您的密码</em>';
	var pas_o2 = h_on+'·请输入您的当前密码</em>';
	var ename_o = h_on+'·请输入您常用的邮箱</em>';
	var nname_o = h_on+'·4-16个字符，包括字母、数字、下划线<br />·支持汉字（1个汉字等于2字符）</em>';
	var pname_o = h_on+'·请输入您的手机号码</em>';		
	var name_e1 = h_err+'长度为4-16字符 (1个汉字等于2字符)</em>';//错误
	var name_e2 = h_err+'用户名第一位不能为数字</em>';
	var name_e3 = h_err+'只能使用字母、数字、下划线、汉字</em>';
	var name_e4 = h_err+'用户名不能超过16个字符</em>';
	var ename_e = h_err+'请输入您真实的邮箱地址</em>';
	var nname_e = h_err+'请输入一个您对外展示的昵称</em>';
	var pas_e1_n = '两次输入的密码不一致'; 
	var pas_e1 = h_err+pas_e1_n+'</em>';
	var pas_e2 = h_err+'密码不能为空</em>';
	var pas_e3 = h_err+'密码应为6-16个字符</em>';
	var pas_e4_n = '密码太过简单';
	var pas_e4 = h_err+pas_e4_n+'</em>';
	var pas_e5_n = '密码不能是用户名的一部分';
	var pas_e5 = h_err+pas_e5_n+'</em>';
	var pname_e = h_err+'请您填写真实的手机号码</em>';
	var name_g = '<em><u class="at_msg m_3_o"></u></em>';//正确	
	var pas_g = '<em class="g"><u class="at_msg m_3_o"></u>'+h_pas+'</em>';//密码正确
	var name_ld = '<em class="ld"><u class="at_msg at_write"></u>正在检测中……</em>';
	var name_in = h_err+'很遗憾！此用户名已被注册，<a href="http://u.zhubajie.com/login/" target="_blank">登录？</a><br /></em>';
	var ename_in = h_err+'很遗憾，该邮箱已被注册！请更换邮箱重试</em>';
	if(page==2) ename_in= h_err+'很遗憾，该邮箱已被注册！请更换邮箱重试或用该邮箱<a href="http://u.zhubajie.com/login/" target="_blank">登录</a></em>';
	var pname_in = h_err+'很遗憾，该手机号已被注册！请更换号码重试或用该号码<a href="http://u.zhubajie.com/login/" target="_blank">登录</a></em>';	
	var opas_in_n = '当前密码输入错误！';
	var opas_in = h_err+opas_in_n+'</em>';
	var ca_on=h_on+"·看不清楚可以点击验证码进行刷新</em>";
	var ca_in=h_err+'验证码输入错误</em>';
	var keyName = new Array('zhubajie','admin','administrator','root','user','test','系统消息','客服','官方','系统','客户','秘书','中奖','工作人员','管理','猪八戒','财务');

	function txt(t){var a=t.parents(".at_text");return a};	
	this.input.focus(function(){//获得焦点
		txt($(this)).attr("class","at_text t_1_i");		
		txt($(this)).find("em").remove();	
		$(this).parents("dd").css("z-index",999);
	})
	this.input.blur(function(){//失去焦点
		txt($(this)).attr("class","at_text t_1_d");
		txt($(this)).find("em").remove();
		$(this).parents("dd");
	})	
	var inErr = function(a,b){//错误
		var at_text = txt(a);
		at_text.attr("class","at_text t_1_e");
		at_text.find("em").remove();
		at_text.append(b);
		return false;
	}
	var inOk = function(a){//正确
		var at_text = txt(a);
		at_text.attr("class","at_text t_1_o");
		at_text.find("em").remove();
		at_text.append(name_g);		
	}
	var namelength = function(a) {
		var name = a.val(),
			length = 0;
		for(var i=0; i<name.length; i++) {
			if(/[\u4e00-\u9fa5]/.test(name.charAt(i))) length+=2;
			else length+=1;
		}
		return length;
	};
	var passmode = function(a) {//计算密码组合种类
		var num = 0;
		if(/[0-9]+/.test(a)) num++
		if(/[a-zA-Z]+/.test(a)) num++
		if(/[^0-9a-zA-Z\s\u4e00-\u9fa5]+/.test(a)) num++
		return num;
	};
	var clearEmpty = function(O) {//禁止输入空格
		O.val(O.val().replace(/\s*/g,""));
	}
	
	//绑定选中某个推荐的用户名事件
	this.bindSelectSugName = function(){
	    $("#sugNameCon input").click(function(){
	        me.u.val($(this).val());
	        me.u.blur();
	    });
	}
	
	//显示推荐的用户名
	this.showSuggestName = function(arr){
	    var snCon=$("#sugNameCon");
	    if(snCon.size()==0){
	        snCon=$(document.createElement("div"));
	        snCon.attr("id","sugNameCon");
	        snCon.addClass("sugNameCon");
	        snCon.css({clear:"both"});
	        me.sugNameCon.append(snCon);
	    }
	    var sughtml=[];
	    sughtml.push("&nbsp;推荐您使用：<br />");
	    for(var i=0;i<arr.length;i++){
	        sughtml.push("<input type='radio' name='sugname' id='sugname_"+i+"' value='"+arr[i]+"'><label for='sugname_"+i+"'>"+arr[i]+"</label><br/>");
	    }
	    snCon.html(sughtml.join(""));
	    snCon.show();
	    me.bindSelectSugName();
	}
	
	this.nameCheck = function(i,s){//验证账号		
		var len = namelength(i);		
		if(len==0){
		    $("#sugNameCon").hide();
		}
        if (len < 4 || len > 16) {//4-16字符 (1汉字等于2字符)
            me.uCheck = inErr(i,name_e1);			
			return;
        }
        if (/^\d{1}.+?$/.test(i.val())) {//第一位是否为数字
            me.uCheck = inErr(i,name_e2);
			return;
        }
        if (!/^[\u4e00-\u9fa5\w]*$/.test(i.val())) {//特殊字符
            me.uCheck = inErr(i,name_e3);			
			return;
        }
		
		//跟据地址判断是否猪八戒工作人员注册
		 var url = location.href;
		 url=url.substring(url.lastIndexOf("=")+1,url.length);
		 if(url=="zbj"){		
					
		 }else{
			 for (var j=0;j<keyName.length;j++ )	{
					if(i.val().indexOf(keyName[j])!=-1) {
						me.uCheck = inErr(i,h_err+'您的用户名包含被过滤字符,无法注册！</em>');			
						return;
					}
				}
			 }
		
		txt(i).attr("class","at_text t_1_l").append(name_ld);
		$.getJSON("http://u.zhubajie.com/register/check.php?mode=checkusername&username="+encodeURIComponent(i.val())+"&jsoncallback=?", function(json){				
			if(json.state == 1) {					
				inOk(i);				
				me.uCheck = true;
				if(s) me.regIn();	
			}else if(json.state == -9){// 包含敏感字符
				me.uCheck = inErr(i,h_err+json.msg+"</em>");
				if(s) me.regIn();
			}else{
				me.uCheck = inErr(i,name_in);				
				if(s) me.regIn();	
                if(json.state==-3){//用户名重复，显示推荐用户名
			        me.showSuggestName(json.aName);
			        return false;
			    }
			}
			$("#sugNameCon").hide();
		});
	}	
	this.pasCheck = function(i,s){//验证密码	
		var password = i.val().replace(/\s*/, "");
		if (password == "") {//不能为空
			me.pCheck=inErr(i,pas_e2);
		} else if(!/^.{6,16}$/.test(password)) {//6-16字符
			me.pCheck=inErr(i,pas_e3);
		} else if(/^(.)\1*$/.test(password) || me.p.val()=='123456' || me.p.val()=='12345678') {//过于简单
			me.pCheck=inErr(i,pas_e4);
		} else {//密码不能包含用户名;
			if(page==4||page==5||page==6) {
				txt(i).attr("class","at_text t_1_l").append(name_ld);
				$.getJSON("http://u.zhubajie.com/changepass/getusername.php?jsoncallback=?", function(json){		
					if(json.state == 1) {
						var username = json.msg;
						if(username.indexOf(password)!=-1) me.pCheck=inErr(i,pas_e5);
						else rightPas();
						if(s) me.regIn();
					}
				});	
			} else if(page==7){									
				if(me.uid.indexOf(password) !=-1) me.pCheck=inErr(i,pas_e5);
				else rightPas();				
			} else {
				if(me.u.val().indexOf(password) !=-1 && me.u.val()!='') me.pCheck=inErr(i,pas_e5); 
				else rightPas();
			}
		}
		function rightPas(){
			txt(i).attr("class","at_text t_1_o").append(pas_g);
			me.pasCheckQ(i);
			me.pCheck=true;
		}
	}	
	this.pasCheckQ = function(i){//密码强度
		clearEmpty(i);	
		var password = i.val().replace(/\s*/, "");
		var passleng = password.length;
		var _pass = passmode(password);
		var pasking = txt(i).find(".at_passking");
		var king = pasking.find("span");
		king.removeClass("at_current").text('');	
		var pas_link = pasking.next(".pas_link");
		pas_link.show();
		if (passleng < 8) {//弱
			king.eq(0).addClass("at_current").text('弱');
			me.q.val(0);
			return;
		}	
		if(/(?:(.)\1{3,})/.test(password) && _pass == 1) {
			//任何字符重复3次以上，并密码字符种类只有一种，弱
			king.eq(0).addClass("at_current").text('弱');
			me.q.val(0);			
		} else if(_pass == 2 || (!/(?:(.)\1{3,})/.test(password)&&passleng >=8&&_pass == 1)) {
			//密码种类超过8位存在两种 或 没有3次以上重复超过8位 中
			king.not(king.eq(2)).addClass("at_current");
			king.eq(1).text('中');
			me.q.val(1);			
		} else if(_pass == 3){//不管是否重复字符，密码种类存在三种，长度大于等于8，强
			king.addClass("at_current");
			pas_link.hide();
			king.eq(2).text('强');
			me.q.val(2);
		}
	}
	this.pasCheck1 = function(i,s){//确认密码		
		if(me.p.val()!='') {			
			if(i.val()!=me.p.val()){				
				me.p1Check=inErr(i,pas_e1);
			}else{inOk(i);
				me.p1Check=true;
			}
		}
		if(s) me.regIn();
	}
	this.opasCheck = function(i,s){//修改时验证当前密码
		if (i.val().replace(/\s*/, "") == "") {//不能为空
			me.p2Check=inErr(i,pas_e2);
			return;
		}
		txt(i).attr("class","at_text t_1_l").append(name_ld);
		var _url;
		if (page==4) _url ='http://u.zhubajie.com/changepass/check.php?opas='+hex_md5(i.val())+'&jsoncallback=?';
		if (page==6) _url ='http://u.zhubajie.com/safepass/check.php?opas='+hex_md5(i.val())+'&jsoncallback=?';
		
		$.getJSON(_url, function(json){	
			if(json.state == 1) {					
				inOk(i);
				me.p2Check=true;
				if(s) me.regIn();
			} else {				
				me.p2Check=inErr(i,opas_in);	
				if(s) me.regIn();
			}
		});
	}
	this.enameCheck = function(i,s){//验证邮箱		
		var e_nameStr = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/.test(i.val());		
		if (!e_nameStr) {
			me.eCheck=inErr(i,ename_e);
			return;
		}	
		txt(i).attr("class","at_text t_1_l").append(name_ld);
		$.getJSON("http://u.zhubajie.com/register/check.php?mode=checkemail&username="+i.val()+"&jsoncallback=?", function(json){				
			if(json.state == 1) {					
				inOk(i);
				me.eCheck=true;
				if(s) me.regIn();
			} else {									
				me.eCheck=inErr(i,'<em class="orr"><u class="at_msg m_3_e"></u>'+ json.msg + '</em>');
				if(s) me.regIn();
			}
		});	
	}
	this.pnameCheck = function(i,s){//验证手机
		var n_nameStr = /^0{0,1}(13[0-9]|15[0-9]|18[5-9])[0-9]{8}$/.test(i.val());
		if(!n_nameStr) {
			me.mCheck=inErr(i,pname_e);
			return;
		}				
		txt(i).attr("class","at_text t_1_l").append(name_ld);
		$.getJSON("http://u.zhubajie.com/register/check.php?mode=checkmobile&username="+i.val()+"&jsoncallback=?", function(json){				
			if(json.state == 1) {					
				inOk(i);
				me.mCheck=true;
				if(s) me.regIn();
			}else {									
				me.mCheck=inErr(i,pname_in);
				if(s) me.regIn();
			}
		});	
	}
	
	//验证用户输入的验证码
	this.caCheck=function(i,s){
		txt(i).attr("class","at_text t_1_l");
		$.getJSON("http://u.zhubajie.com/register-checkcode?seed="+$("#seed").val()+"&code="+i.val()+"&jsoncallback=?", function(json){				
			if(json.state == 1) {					
				inOk(i);
				me.cacheck=true;
				if(s) me.regln();
			}else {
				me.cacheck=inErr(i,ca_in);
				if(s) me.regIn();
			}
		});	
	}
	
	this.btn.click(function(){//按钮提交
	    if(isloading){return false;}
		if(page==3){
			if(me.mCheck==false) {me.pnameCheck(me.m,true);return;}
		}			
		if(page==2||page==3){			
			if(me.eCheck==false) {me.enameCheck(me.e,true);return;}				
		}		
		if(page==1||page==2||page==3){
			if(me.uCheck==false) {me.nameCheck(me.u,true);return;}
			if(me.eCheck==false) {me.enameCheck(me.e,true);return;}	
		}	
		if(me.pCheck==false) {me.pasCheck(me.p,true);return;}
		if(me.p1Check==false) {me.pasCheck1(me.p1,true);return;}	
		//if(me.ca.size()==1 && me.cacheck==false) { me.caCheck(me.ca,true);return;}			
		me.regIn();
		return false;
	})
	this.regIn = function(){
		if(page==3){			
			if(me.mCheck==false) {at_infoTrace.show('手机号码输入错误！','i');return;}
		}		
		if(page==2||page==3){
			if(me.eCheck==false) {at_infoTrace.show('邮箱输入错误！','i');me.e.blur();return;}
		}		
		if(page==1||page==2||page==3){
			if(me.uCheck==false) {at_infoTrace.show('用户名输入错误！','i');return;}
			if(me.u.val().indexOf(me.p.val()) !=-1) {
				at_infoTrace.show(pas_e5_n,'i');
				me.u.blur();
				return;
			}
			if(me.eCheck==false) {at_infoTrace.show('邮箱输入错误！','i');me.e.blur();return;}		
		}	
		if(me.pCheck==false) {at_infoTrace.show('密码输入错误！','i');me.p.blur();return;}		
		if(me.p.val()!=me.p1.val()) {
			at_infoTrace.show(pas_e1_n,'i');me.p1.blur();return;
		}		
		if(me.ca.size()==1 && me.ca.val()===""){
		    inErr(me.ca,ca_in);
		    return false;
		}
		if(page==1||page==2||page==3){			
			if(me.c.attr("checked")==false) {at_infoTrace.show('请先查看并同意《猪八戒网服务协议（试行）》！','i');return;}			
		}
		if(page==1||page==2||page==3){
			at_loading.show();
			isloading=true;	
			$.ajax({
			    url:me.box.attr("action"),
			    type:"POST",
			    data:me.box.serialize(),
			    success:function(json){
			        isloading=false;	
			        if(json.state==1){
			            if(json.url){
			                location.href=json.url;
			            }
//			            else{
//			                var traces = new at_trace();
//                            traces.setContact("请输入手机验证码",json.msg,
//                                [
//		                            traces.getButton("确定", "yellow", function(){
//                        				
//		                            })
//	                            ]
//                            );
//                            
//                            traces.setWidth(760);
//                            traces.setDisplay('show');
//			            }
			            
			        }else if(json.state==-2){
			            $("#catchaimg").click();
			            at_loading.hide();
			            inErr(me.ca,ca_in);
			        }else{
			            at_loading.hide();
			            at_infoTrace.show(json.msg,"i");
			        }
			    }
			});
		}
	}	

	this.u.focus(function(){
		txt(me.u).append(name_o);
		me.u.isCheck=false;
	})
	this.u.blur(function(){me.nameCheck(me.u)});
	this.u.keyup(function(){
	    var pattern=/^\d/;
	    var length=namelength(me.u);
	    if(pattern.test(me.u.val())){
	        me.uCheck=inErr(me.u,name_e2);
	    }else if(length>16){
            me.uCheck=inErr(me.u,name_e4);
	    }else if(length==0){
	        me.u.focus();
	    }else{
		    txt(me.u).attr("class","at_text t_1_i").find("em").attr("class","on").html(name_o);
	        $("#namecount").html("已输入<b>"+length+"</b>个字符，还可以输入<b>"+(16-length)+"</b>个字符");
	    }
	});
	
	this.p.focus(function(){
		me.pCheck=false;
		txt(me.p).append(pas_o);
		var links = txt(me.p).find(".pas_link");		
		links.hover(function(){							 
			me.p.unbind("blur")			
		},function(){
			me.p.bind("blur",function(){
				me.p.next("em").remove();
				me.p.parents("dd").css({position:"static"});
				me.pasCheck(me.p);
			})	
		})
		links.bind("click",function(){
			$(this).mouseout();
			me.p.blur();			
		})	
		if(me.p.val()!='') me.pasCheckQ(me.p);
		me.p.keyup(function(){ 
			me.pasCheckQ(me.p);
		})		
	})
	this.p.blur(function(){me.pasCheck(me.p)})	
	
	this.p1.focus(function(){
		txt(me.p1).append(pas_o1);
		me.p1Check=false;
	})
	this.p1.blur(function(){me.pasCheck1(me.p1)})

	this.p2.focus(function(){
		txt(me.p2).append(pas_o2);
		me.p2Check=false;
	})
	this.p2.blur(function(){me.opasCheck(me.p2)})
	
	this.e.focus(function(){
		txt(me.e).append(ename_o);
		me.eCheck=false;
	})
	//延时200毫秒才触发验证
	this.e.blur(function(){setTimeout(function(){ me.enameCheck(me.e)},200)})	

	this.m.focus(function(){
		txt(me.m).append(pname_o);
		me.mCheck=false;
	})
	this.m.blur(function(){me.pnameCheck(me.m)})
	
	this.ca.focus(function(){txt(me.ca).append(ca_on)});
	//this.ca.blur(function(){me.caCheck(me.ca)});
	
	this.input.eq(0).focus();	
	
	me.box.submit(function(){
	    me.btn.click();
	    return false;
	});
}

//邮件地址自动补全
function suggest(obj,domains,nextObj){
    var suggest={
        //补全框容器
        sugCon:null,
        //补全项
        childSug:null,
        //是否处于显示状态中
        isShow:false,
        //延时提示
        timer:null,
        //文本框在页面中的位置和高宽信息
        objOffset:{
            h:obj.outerHeight(),
            w:obj.outerWidth()
        },
        //隐藏补全框
        hideSugCon:function(){
            suggest.sugCon.hide();
            suggest.isShow=false;
        },
        //调整补全框位置
        adjustCon:function(){
            var oOffset=obj.offset();
            suggest.sugCon.css({
                top:oOffset.top+suggest.objOffset.h,
                left:oOffset.left,
                width:suggest.objOffset.w,
                position:"absolute"
            });
        },
        //显示补全框并调整位置
        showSugCon:function(){
            suggest.isShow=true;
            suggest.sugCon.show();
        },
        //点击页面任何地方时，隐藏补全框
        bindBodyClick:function(){
            $(document.body).click(function(){
                if(suggest.sugCon){
                    suggest.hideSugCon();
                }
            });
            $(window).resize(function(){
                if(suggest.sugCon && suggest.isShow){
                    suggest.adjustCon();
                }
            });
        },
        //绑定补全选项点击事件
        bindSelectSug:function(){
            suggest.childSug.click(function(){
                obj.val($(this).html());
                suggest.hideSugCon();
            });
        },
        //创建补全内容容器
        createSugCon:function(){
            var con=$(document.createElement("div"));
            con.addClass("zbj_suggest");
            con.attr("id","zbj_suggest_"+(new Date()).getTime());
            con.hide();
            suggest.sugCon=con;
            $(document.body).append(con);
        },
        //根据用户输入内容，创建补全内容
        createSug:function(){
            var val=obj.val();
            var indexOfat=val.indexOf("@");
            var has_at=(indexOfat>-1?true:false);
            var prefix=val;
            if(has_at){
                prefix=val.substr(0,indexOfat);
            }
            var tempArr=[];
            for(var i=0;i<domains.length;i++){
                tempArr.push(prefix+"@"+domains[i]);
            }
            var pattern=eval("/^"+val+"/");
            var html=[];
            
            for(var i=0;i<tempArr.length;i++){
                if(pattern.test(tempArr[i])){
                    html.push("<div>"+tempArr[i]+"</div>");
                }
            }
            obj.attr("length",tempArr.length);
            return html.join("");
        },
        //光标向上移动
        prev:function(){
            if(suggest.sugCon && suggest.isShow){
                var index=obj.attr("index");
                var size=parseInt(obj.attr("length"));
                if((typeof index=="undefined") || index===""){
                    index=size-1;
                }else if(index=="0"){
                    suggest.childSug.removeClass("select");
                    obj.attr("index","");
                    obj.val(obj.attr("old"));
                    return false;
                }else{
                    index=parseInt(index)-1;
                }
                suggest.childSug.removeClass("select");
                suggest.childSug.eq(index).addClass("select");
                obj.val(suggest.childSug.eq(index).html());
                obj.attr("index",index);
            }else{
                return false;
            }
        },
        //光标向下移动
        next:function(){
            if(suggest.sugCon && suggest.isShow){
                var index=obj.attr("index");
                var size=parseInt(obj.attr("length"));
                if((typeof index=="undefined") || index===""){
                    index=0;
                }else if(index==size-1){
                    suggest.childSug.removeClass("select");
                    obj.attr("index","");
                    obj.val(obj.attr("old"));
                    return false;
                }else{
                    index=parseInt(index)+1;
                }
                suggest.childSug.removeClass("select");
                suggest.childSug.eq(index).addClass("select");
                obj.val(suggest.childSug.eq(index).html());
                obj.attr("index",index);
            }else{
                return false;
            }
        },
        //开始生成建议内容
        start:function(){
            //不存在补全框容器
            if(!suggest.sugCon){
                //则创建
                suggest.createSugCon();
            }
            //清空原来的内容
            suggest.sugCon.html("");
            //生成补全的内容并插入到容器
            var html=suggest.createSug();
            if(html==""){suggest.hideSugCon();return false;}
            suggest.sugCon.append(html);
            suggest.childSug=suggest.sugCon.find("div");
            suggest.bindSelectSug();
            //将补全框显示出来
            suggest.adjustCon();
            suggest.showSugCon();
            obj.attr("index","");
            obj.attr("length",suggest.childSug.size());
        },
        //绑定按键事件
        bindKeyEvent:function(){
            obj.keyup(function(e){
                if(obj.val().replace(/\s/g,"")=="" || /[^a-zA-Z0-9\-\_\@\.]/.test(obj.val())){
                    if(suggest.sugCon){suggest.hideSugCon();}
                    return false;
                }
                var keycode=e.keyCode;
                switch(keycode){
                    case 37:
                    case 39:
                    case 38:
                    case 40:
                        break;
                    default:
                        if(suggest.timer){ clearTimeout(suggest.timer);}
                        obj.attr("old",obj.val());
                        suggest.timer=setTimeout(function(){
                            suggest.start();
                        },100);
                        break;
                }
            }).focus(function(e){
                if(obj.val().replace(/\s/g,"")=="" || /[^a-zA-Z0-9\-\_\@\.]/.test(obj.val())){
                    return false;
                }
                if(e.cancelBubble){
                    e.cancelBubble=true;
                }else{
                    e.stopPropagation();
                }
                if(suggest.sugCon && suggest.isShow){
                    return false;
                }else{
                    obj.attr("old",obj.val());
                    suggest.start();
                }
            }).click(function(e){
                if(e.cancelBubble){
                    e.cancelBubble=true;
                }else{
                    e.stopPropagation();
                }
            }).keydown(function(e){
                var keycode=e.keyCode;
                switch(keycode){
                    case 13:
                        if(suggest.sugCon && obj.attr("index")!==""){
                            obj.blur();
                            if(nextObj && nextObj.size()==1){
                                nextObj.focus();
                            }
                            if(window.event){
                                window.event.returnValue=false;
                            }else{
                                return false;
                            }
                        }
                        break;
                    case 38:
                        if(!suggest.isShow){return false;}
                        suggest.prev();
                        break;
                    case 40:
                        if(!suggest.isShow){return false;}
                        suggest.next();
                        break;
                }
            }).blur(function(){
                if(suggest.sugCon){
                    setTimeout(function(){
                        suggest.hideSugCon();
                        obj.attr("index","");
                    },100);
                }
            });
        }
    }
    suggest.bindKeyEvent();
    suggest.bindBodyClick();
}