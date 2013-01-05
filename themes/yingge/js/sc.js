//function $(){return document.getElementById(arguments[0]);}
function rollAdFun(){
	var obj=$('#rollAd');
	var leftDivObj=document.getElementsById('mjx');
	var leftUlObj=leftDivObj.getElementsByTagName('ul')[0];
	var leftLiObj=leftUlObj.getElementsByTagName('li');
	var rightDivObj=obj.getElementsByTagName('div')[1];
	var rightUlObj=rightDivObj.getElementsByTagName('ul')[0];
	var rightTopImgObj=rightUlObj.getElementsByTagName('img');
	var rightPObj=rightDivObj.getElementsByTagName('p')[0];
	var leftBottomImgObj=rightPObj.getElementsByTagName('img')[0];
	var rightBottomImgObj=rightPObj.getElementsByTagName('img')[1];
	var _s=1,_l=null,_r=null,_ll=null,_rr=null;
	leftUlObj.style.width=(leftLiObj.length*140+5)+'px';
	if(leftLiObj.length<=6){return false;}
	function rollAdLeftADDFun(leftDivObjScrollLeft){
		var leftLiObj=leftUlObj.getElementsByTagName('li');
		if(leftDivObjScrollLeft>=leftLiObj.length*140-(840+leftLiObj.length%6*140)){
			leftUlObj.innerHTML+=leftUlObj.innerHTML;
			leftUlObj.style.width=(leftUlObj.getElementsByTagName('li').length*140+5)+'px';
		}
		if(_s<840){
			_s=Math.ceil(_s*1.08);
			leftDivObj.scrollLeft=leftDivObjScrollLeft+_s;
		}else{
			clearInterval(_l);
			leftDivObj.scrollLeft=leftDivObjScrollLeft+840;
			_s=1;
			imgLightFun();
		}
	}
	function rollAdRightADDFun(leftDivObjScrollLeft){
		if(_s<840){
			_s=Math.ceil(_s*1.08);
			leftDivObj.scrollLeft=leftDivObjScrollLeft-_s;
		}else{
			clearInterval(_r);
			leftDivObj.scrollLeft=leftDivObjScrollLeft-840;
			_s=1;
			imgLightFun();
		}
	}
	function rollAdLeftFun(){
		if(_s==1){
			var leftDivObjScrollLeft=leftDivObj.scrollLeft;
			_l=setInterval(function(){rollAdLeftADDFun(leftDivObjScrollLeft);},1);
		}else{
			return false;
		}
	}
	function rollAdRightFun(){
		if(_s==1){
			var leftDivObjScrollLeft=leftDivObj.scrollLeft;
			_r=setInterval(function(){rollAdRightADDFun(leftDivObjScrollLeft);},1);
		}else{
			return false;
		}
	}
	function imgLightFun(){
		if(leftDivObj.scrollLeft/840%3==0){
			for(var i=0,j=rightTopImgObj.length;i<j;i++){rightTopImgObj[i].src='http://style.stonebuy.com/index/images/gray_dian.gif';}
			rightTopImgObj[0].src='http://style.stonebuy.com/index/images/blue_dian.gif';
		}else if(leftDivObj.scrollLeft/840%3==1){
			for(var i=0,j=rightTopImgObj.length;i<j;i++){rightTopImgObj[i].src='http://style.stonebuy.com/index/images/gray_dian.gif';}
			rightTopImgObj[1].src='http://style.stonebuy.com/index/images/blue_dian.gif';
		}else if(leftDivObj.scrollLeft/840%3==2){
			for(var i=0,j=rightTopImgObj.length;i<j;i++){rightTopImgObj[i].src='http://style.stonebuy.com/index/images/gray_dian.gif';}
			rightTopImgObj[2].src='http://style.stonebuy.com/index/images/blue_dian.gif';
		}
	}
	function stopRollAdFun(){
		if(_s==1){
			clearInterval(_ll);
		}
	}
	function startRollAdFun(){
		if(_s==1){
			_ll=setInterval(rollAdLeftFun,6000);
		}
	}
	_ll=setInterval(rollAdLeftFun,6000);
	leftBottomImgObj.onclick=rollAdLeftFun;
	rightBottomImgObj.onclick=rollAdRightFun;
	leftUlObj.onmouseover=stopRollAdFun;
	leftUlObj.onmouseout=startRollAdFun;
}
rollAdFun();
