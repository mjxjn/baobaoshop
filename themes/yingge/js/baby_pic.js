/*pub-2|2011-12-22 18:02:57*/(function(a,b){var c=a.DOM,d=a.Event,e=location.protocol+"//"+location.hostname+"/json/login_success.htm",f=null,g=function(c,d){var g=location.hostname.indexOf("daily.taobao.net")!==-1?"login.daily.taobao.net":"login.taobao.com",h="https://"+g+"/member/login.jhtml?style=mini&redirect_url="+escape(e)+"&full_redirect=false&is_ignore=false";a.use("overlay",function(){f?f.get("contentEl").one("iframe")[0].src=h+"&_="+(new Date).getTime():d?f=new a.Dialog({width:345,headerContent:"",bodyContent:'<iframe src="'+h+'" width="343" height="225" frameborder="0" scrolling="no" />',autoRender:!0,mask:!0,zIndex:10003}):(f=new a.Dialog({content:'<div class="baobao-popup-window-wrapper"><div class="hd"><h3></h3><a class="J_BP_Hide closeButton" href="#" title="\u5173\u95ed" tabindex="0"></a></div><div class="bd"><iframe src="'+h+'" width="410" height="270" frameborder="0" scrolling="0" />'+"</div>"+"</div>",elCls:"baobao-popup-window",width:412,height:305,autoRender:!0,mask:!0,closable:!1}),f.get("contentEl").one("a").on("click",function(a){a.halt(),f.hide()})),f.center(),f.show()}),c&&(b.Login.success=function(){c(f)!==!1&&f.hide()})};b.Login={show:g,success:function(){f&&f.hide()}}})(KISSY,BabyMarket);/*pub-2|2011-12-22 18:02:53*/(function(a,b){var c=a.DOM,d=a.Event;b.Vote=function(){var b=this;this.config={markup:'<div class="baobao-popup-window-wrapper"><div class="hd"><h3></h3><a class="J_BP_Hide closeButton" href="#" title="\u5173\u95ed" tabindex="0"></a></div><div class="bd"><div class="J_BP_Infos infos clearfix"></div><div class="vote-buttons clearfix"><a href="#" class="J_BP_Hide ok">\u786e\u5b9a</a><a href="" class="pinglun">\u53bb\u8bc4\u8bba</a></div></div></div>',api:"http://"+document.domain+"/json/star_baby_vote.htm",commmentURL:"http://"+document.domain+"/starbaby/detail.htm?",successText:"\u6295\u7968\u6210\u529f\u611f\u8c22\u4f60\u5bf9\u5b9d\u5b9d\u7684\u652f\u6301\uff01",faildText:"\u4eb2\uff0c\u4f60\u5df2\u7ecf\u7ed9\u8fd9\u4e2a\u5b9d\u5b9d\u6295\u8fc7\u7968\u4e86\u54e6\uff01",lastdayText:"\u672c\u671f\u6295\u7968\u5df2\u7ed3\u675f\uff0c\u6b22\u8fce\u4e0b\u6b21\u518d\u6765\uff01",unknownText:"\u4eb2\uff0c\u4e0d\u77e5\u600e\u4e48\u7684\u6295\u7968\u6ca1\u6709\u6210\u529f\uff0c\u5237\u65b0\u8bd5\u8bd5\u5427\uff01",curVote:{},dialog:"",resTmp:'<img src="{{pic}}" /><div class="text">{{text}}</div>'},this.request=function(){b.config.curVote.voteid||a.log("\u6ca1\u6709\u8bf7\u6c42\u53c2\u6570\uff0c\u8bf7\u68c0\u67e5\uff01"),a.jsonp(b.config.api,{_tb_token_:b.config.curVote.voteToken,voteId:b.config.curVote.voteid},b._dealRes)},this._dealRes=function(d){var e=b.config.resTmp.replace(/{{pic}}/g,b.config.curVote.votepic),f;if(d&&d.result&&d.result=="success"){e='<img class="emo" src="http://assets.taobaocdn.com/sys/wangwang/smiley/48x48/11.gif"/><div class="text">\u4eb2\uff0c\u60a8\u7684\u6295\u7968\u5df2\u6210\u529f\uff01\u611f\u8c22\u652f\u6301\uff01</div><span class="vote-buttons success-button"><a href="#" class="J_BP_Hide ok">\u786e\u5b9a</a></span>',f='<iframe width="350" height="180" frameborder="0" src="/vote_success.htm"></iframe>';var g=a.query(".J_VoteNum_"+b.config.curVote.voteid);a.each(g,function(a){isNaN(c.html(a)*1)||c.html(a,c.html(a)*1+1)})}else{if(d&&d.result&&d.result=="notlogin"){b.loginPopup();return}if(d&&d.result&&d.result=="need_validate"){b._validateVote(d.codeUrl,d.result);return}if(d&&d.result&&d.result=="validate_invalid"){b._validateVote(d.codeUrl,d.result);return}d&&d.result&&d.result=="fail"?e=e.replace(/{{text}}/g,b.config.faildText):d&&d.result&&d.result=="over"?e=e.replace(/{{text}}/g,b.config.lastdayText):e=e.replace(/{{text}}/g,b.config.unknownText)}b._openDialog(e,f)},this._openDialog=function(c,d){d===undefined?(d='<a href="#" class="J_BP_Hide ok">\u786e\u5b9a</a><a href="" class="pinglun">\u53bb\u8bc4\u8bba</a>',a.one(".J_BP_Infos","#markup-vote").html(c),a.one("div.vote-buttons","#markup-vote").removeClass(".frame-container").html(d),a.get("a.pinglun","#markup-vote").href=b.config.commmentURL+"hd="+b.config.curVote.votehd+"&"+"num="+b.config.curVote.votenum+"&"+"t="+Math.random()+"#comments"):(a.one(".J_BP_Infos","#markup-vote").html(c),a.one("div.vote-buttons","#markup-vote").addClass(".frame-container").html(d)),b.config.dialog.center(),b.config.dialog.show()},this._validateVote=function(c,e){var e=e=="validate_invalid"?"\u9a8c\u8bc1\u7801\u9519\u8bef":"\u8bf7\u8f93\u5165\u9a8c\u8bc1\u7801",f='<label id="validate-label" for="validate-code">'+e+'</label><input id="validate-code"/><img id="validate-img" src="'+c+"&_ts="+a.now()+'" /><a id="change-code" href="#">\u66f4\u6362\u9a8c\u8bc1\u7801</a>',g='<a href="#" class="J_ValidateSubmit ok">\u786e\u5b9a</a>';a.one(".J_BP_Infos","#markup-vote").html(f),a.one(".vote-buttons","#markup-vote").html(g),a.one("#validate-code").on("focusin",function(b){a.one("#validate-label").hide()}).on("focusout",function(b){a.one(this).val()||a.one("#validate-label").show()}),d.on("#change-code","click",function(b){a.one("#validate-img").attr("src",c+"&_ts="+a.now()),b.halt()}),d.on("#validate-img","click",function(b){a.one("#validate-img").attr("src",c+"&_ts="+a.now()),b.halt()}),a.one(".J_ValidateSubmit").on("click",function(c){b.config.curVote.voteid||a.log("\u6ca1\u6709\u8bf7\u6c42\u53c2\u6570\uff0c\u8bf7\u68c0\u67e5\uff01"),a.jsonp(b.config.api,{voteId:b.config.curVote.voteid,_tb_token_:b.config.curVote.voteToken,validateCode:a.one("#validate-code").val()},b._dealRes),c.halt()}),b.config.dialog.center(),b.config.dialog.show()},this.checkLogin=function(){return a.Cookie.get("_l_g_")&&a.Cookie.get("_nk_")},this.loginPopup=function(b){var c=arguments.callee,d="";document.location.href.indexOf("daily.taobao.net")>-1?d="https://login.daily.taobao.net/member/login.jhtml?redirect_url="+escape(document.location.href)+"&style=mini":d="https://login.taobao.com/member/login.jhtml?redirect_url="+escape(document.location.href)+"&style=mini",a.use("overlay",function(a,b){var e=c.dialog;e||(e=new a.Dialog({content:'<div class="baobao-popup-window-wrapper"><div class="hd"><h3></h3><a class="J_BP_Hide closeButton" href="#" title="\u5173\u95ed" tabindex="0"></a></div><div class="bd"><iframe src="'+d+'" width="410" height="270" frameborder="0" scrolling="0" />'+"</div>"+"</div>",elCls:"baobao-popup-window",width:412,height:305,autoRender:!0,closable:!1,mask:!0}),e.get("contentEl").one(".J_BP_Hide").on("click",function(a){a.halt(),e.hide()}),c.dialog=e),e.center(),e.show()}),b&&b.halt()},this.markup=function(){var e=c.create('<div id="markup-vote" class="baobao-popup-window vote"></div>');a.UA.ie<7&&d.on(window,"scroll",function(){c.css(e,"top",document.documentElement.scrollTop+document.documentElement.clientHeight*.34)}),c.html(e,b.config.markup),c.append(e,document.body)},this.init=function(){b.markup(),a.use("overlay",function(a,e){b.config.dialog=new a.Overlay({srcNode:"#markup-vote",autoRender:!0,mask:!0}),b.config.dialog.hide(),a.one("#markup-vote").on("click",function(a){c.hasClass(a.target,"J_BP_Hide")&&(a.halt(),b.config.dialog.hide())}),d.on("#content","click",function(a){var d=a.target;if(c.hasClass(d,"J_Votes")){if(!b.checkLogin()){b.loginPopup(a);return}b.config.curVote={voteid:c.attr(d,"data-id"),votepic:c.attr(d,"data-pic")||"http://img03.taobaocdn.com/tps/i3/T1LTCmXmBcXXXXXXXX-120-120.png_80x80.jpg",voteToken:c.attr(d,"data-token"),votehd:c.attr(d,"data-hd"),votenum:c.attr(d,"data-num")},b.request(),a.halt()}})})}}})(KISSY,BabyMarket);/*pub-2|2011-12-22 18:02:53*/(function(a,b){function e(b,c,d){var f=this;f.config=a.merge(e.Config,d),f.textarea=a.get(b),f.counter=a.get(c);if(!f.textarea||!f.counter)return;f.init()}var c=a.DOM,d=a.Event;e.Config={limitOver:!0,strictCount:!0,maxLength:140,trim:!1},a.augment(e,a.EventTarget,{init:function(){var a=this;d.on(a.textarea,"keyup focus blur",function(b){a.flush()}),a.flush()},__getContent:function(){var b=this,d=b.textarea;return d.value==c.attr(d,"placeholder")?"":b.config.trim?a.trim(d.value):d.value},getLength:function(){var a=this,b=a.__getContent();return a.config.strictCount?a.__strictCount(b):b.length},__strictCount:function(a){var b=0;for(var c=0,d=a.length;c<d;c++)a.charCodeAt(c)>255?b+=2:b++;return Math.ceil(b/2)},flush:function(){var a=this,b=a.config.maxLength,c=a.getLength();a.config.limitOver&&c>b?a.textarea.value=a.lastValue:(a.lastValue=a.textarea.value,setTimeout(function(){a.counter.innerHTML=b-c},0))}}),b.Counter=e})(KISSY,BabyMarket);/*pub-2|2011-12-22 18:02:55*/(function(a,b){var c=a.DOM,d=a.Event,e=function(a){a.setSelectionRange(0,a.value.length)},f=function(a){var b=a.createTextRange();b.collapse(!0),b.moveStart("character",0),b.moveEnd("character",a.value.length),b.select()};b.Paginator={init:function(){var b=a.query(".J_Dpl_Paginator_JumpTo");d.add(b,"keyup",function(){this.value.match(/[^0-9]/)&&(this.value=this.value.replace(/[^0-9]/g,""))}),d.add(b,"focus",function(){if(!this.setSelectionRange){var a=this;setTimeout(function(){f(a)},100)}else setTimeout(e,100,this)})}}})(KISSY,BabyMarket);/*pub-2|2011-12-22 18:02:52*/AJBridge.add("clipboard",function(a){function c(a,d){d=d||{};var e={};b.each(["data","format","btn","hand"],function(a){a in d&&(e[a]=d[a])}),d.params=d.params||{},d.params.flashvars=b.merge(d.params.flashvars,e),c.superclass.constructor.call(this,a,d)}var b=KISSY;b.extend(c,a),a.augment(c,["getData","clearData","setData"]),c.version="1.0.0",a.Clipboard=c});/*pub-2|2011-12-22 18:02:53*/var S=KISSY,D=S.DOM;KISSY.use("switchable",function(a){a.Slide("#J_Photos",{effect:"fade",navCls:"circle-nav-list",contentCls:"photo-list"})});var vote=new BabyMarket.Vote;vote.init();var Clipboard=AJBridge.Clipboard,clipboard=new Clipboard("J_Copy",{src:"http://a.tbcdn.cn/apps/babymarket/r/20110923/ui/clipboard.swf",params:{bgcolor:"#FFCCCC",wmode:"transparent",scale:"showall"},attrs:{width:"100%",height:45},hand:!0,btn:!0});clipboard.on("mouseUp",function(a){var b=D.attr("#J_Copy","data-url");clipboard.setData(b),clipboard.getData()!==b?window.prompt("\u60a8\u7684\u6d4f\u89c8\u5668\u4e0d\u652f\u6301\u81ea\u52a8\u590d\u5236",b):alert("\u590d\u5236\u6210\u529f\uff01\n\u73b0\u5728\u60a8\u53ef\u4ee5\u7c98\u8d34\uff08Ctrl+V\uff09")}),clipboard.init(),new BabyMarket.Counter("#J_Comment","#J_Counter",{strictCount:!1}),BabyMarket.Paginator.init(),function(a,b){function c(){var c=a.one("#J_Login");if(!c)return;c.on("click",function(){b.Login.show(function(){location.href=location.href.split("#")[0]})}),a.one("#J_Comment").on("focus",function(){b.Login.show(function(){location.href=location.href.split("#")[0]})})}"#comments"==location.hash&&a.get("#J_Comment").focus(),c(),!0===(b.Msg.get("kfc")||b.Msg.get("url"))&&a.use("overlay",function(a,c){var d=new a.Overlay({content:'<div class="kfc-tip baobao-popup-window-wrapper"><div class="hd"><h3>\u5c0f\u63d0\u793a</h3><a class="J_BP_Hide closeButton" href="#" title="\u5173\u95ed" tabindex="0"></a></div><div class="bd">'+(b.Msg.get("url")?"\u8bc4\u8bba\u5185\u5bb9\u4e2d\u4e0d\u5141\u8bb8\u5305\u542b\u94fe\u63a5\uff0c\u8bf7\u91cd\u65b0\u8f93\u5165...":"\u60a8\u8f93\u5165\u7684\u5185\u5bb9\u4e2d\u5305\u542b\u654f\u611f\u8bcd\uff0c\u8bc4\u8bba\u672a\u53d1\u8868\u6210\u529f\uff01")+"</div>"+'<div class="ft">'+'<button class="J_BP_Hide">\u786e\u5b9a</button>'+"</div>"+"</div>",elCls:"baobao-popup-window",autoRender:!0,mask:!0});a.all(".J_BP_Hide").on("click",function(a){a.halt(),d.hide()}),d.center(),d.show()})}(KISSY,BabyMarket);