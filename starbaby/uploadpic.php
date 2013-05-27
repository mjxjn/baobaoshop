<?php
include("creatminiature.php");

if($_POST['act']=='cutimg'){
	$targ_w = $targ_h = 380; //保存的图片的大小
	$jpeg_quality = 100;
	$upload_dir = 'uploads/'.date("Ymd",time()).'/'; 
	$pic_id=$_POST['pic_id'];
	$newfile=$pic_id."_s.jpg";
	$newfile=$upload_dir.$newfile;
	$src = $_POST['bigpic'];

	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);

	header('Content-type: image/jpeg');
	imagejpeg($dst_r,$newfile,$jpeg_quality);
	if(file_exists($src)){
		unlink($src);
	}
	/*echo '<script type="text/javascript">
		<!--
		  $(document).ready(function(){';
	echo 'window.parent.buildAvatarEditor("'.$upload_dir.'","'.$pic_id.'");';
	echo '});
	-->
		  </script>';*/
}else{
@header("Expires: 0");
@header("Cache-Control: private, post-check=0, pre-check=0, max-age=0", FALSE);
@header("Pragma: no-cache");
$upload_dir = 'uploads/'.date("Ymd",time()).'/';  
$upfile = $_FILES["userfile"]; 
//$file_path = $upload_dir . $upfile['name'];   
$MAX_SIZE = 20000000;   


echo $_POST['buttoninfo'];   
if(!is_dir($upload_dir))   
{   
    if(!mkdir($upload_dir))   
        echo "文件上传目录不存在并且无法创建文件上传目录";   
    if(!chmod($upload_dir,0755))   
        echo "文件上传目录的权限无法设定为可读可写";   
}   

$fileinfo=pathinfo($upfile['name']);
$ext=$fileinfo["extension"];
do{
	$pic_id=date("YmdHis",time()).rand(1000,9999);
	$newfile=$pic_id.".".$fileinfo["extension"];
	$newfile=$upload_dir.$newfile;
	
}while(file_exists($newfile));

if($upfile['size']>$MAX_SIZE)   
    echo "上传的文件大小超过了规定大小";   
  
if($upfile['size'] == 0)   
    echo "请选择上传的文件";   
if(is_uploaded_file($upfile["tmp_name"])){ 
	if(!move_uploaded_file($upfile["tmp_name"],$newfile))   
	{	
		echo "复制文件失败，请重新上传";    
	}
}else{
	echo "不是一个上传文件！";
}
$profile=$upload_dir.$pic_id."_lit.".$ext;
$cm=new CreatMiniature();
$cm->SetVar($newfile,"file",255,255,255);
$cm->Prorate($profile,700,0);

if(file_exists($newfile)){
	unlink($newfile);
}
switch($upfile['error'])   
{   
    case 0:   
       // echo "/starbaby/".$newfile;   
        //echo '<script type="text/javascript">window.parent.hideLoading();window.parent.buildAvatarEditor("'.$pic_id.'","'.$newfile.'","photo");</script>';
        echo '<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /></head><title></title>';
    	echo '<style type="text/css">
.crop_preview{position:absolute; left:714px; top:7px; width:180px; height:180px; overflow:hidden;}
#crop_submit{position:absolute; left:714px; top:197px; overflow:hidden;}
#reset{position:absolute; left:814px; top:197px; overflow:hidden;}
</style>';
    	echo '<link rel="stylesheet" href="/themes/yingge/starbaby/jquery.Jcrop.css" type="text/css" />';
    	echo '<SCRIPT type=text/javascript src="/themes/yingge/js/jquery.min.js"></SCRIPT>';
    	echo '<script type="text/javascript" src="/themes/yingge/js/jquery.Jcrop.js"></script>';
    	echo '<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		//记得放在jQuery(window).load(...)内调用，否则Jcrop无法正确初始化
		$("#xuwanting").Jcrop({
			aspectRatio:1,
			onChange:showCoords,
			onSelect:showCoords
		});	
		//简单的事件处理程序，响应自onChange,onSelect事件，按照上面的Jcrop调用
		function showCoords(obj){
			
			$("#x").val(obj.x);
			$("#y").val(obj.y);
			$("#w").val(obj.w);
			$("#h").val(obj.h);
			if(parseInt(obj.w) > 0){
				//计算预览区域图片缩放的比例，通过计算显示区域的宽度(与高度)与剪裁的宽度(与高度)之比得到
				var rx = $("#preview_box").width() / obj.w; 
				var ry = $("#preview_box").height() / obj.h;
				//通过比例值控制图片的样式与显示
				$("#crop_preview").css({
					width:Math.round(rx * $("#xuwanting").width()) + "px",	//预览图片宽度为计算比例值与原图片宽度的乘积
					height:Math.round(rx * $("#xuwanting").height()) + "px",	//预览图片高度为计算比例值与原图片高度的乘积
					marginLeft:"-" + Math.round(rx * obj.x) + "px",
					marginTop:"-" + Math.round(ry * obj.y) + "px"
				});
			}
		}
		$("#crop_submit").click(function(){
			if(parseInt($("#w").val())){
				$("#crop_form").submit();
				window.parent.hideLoading();
				window.parent.buildAvatarEditor("'.$upload_dir.'","'.$pic_id.'");
			}else{
				alert("要先在图片上划一个选区再单击确认剪裁的按钮哦！");	
			}
		});
		$("#reset").click(function(){

				window.parent.hideLoading();
				
			
		});
	});
</script>';
    	echo '<div class="rel mb20">
    		<form action="uploadpic.php" method="post" id="crop_form">
                	<img id="xuwanting" src="'.$profile.'" />
                    <span id="preview_box" class="crop_preview"><img id="crop_preview" src="'.$profile.'" width="180" width="180"/></span>
                
                    <input type="hidden" id="x" name="x" />
                    <input type="hidden" id="y" name="y" />
                    <input type="hidden" id="w" name="w" />
                    <input type="hidden" id="h" name="h" />
                    <input type="hidden" name="bigpic" value="'.$profile.'" />
                     <input type="hidden" name="pic_id" value="'.$pic_id.'" />
                    <input type="hidden" name="act" value="cutimg" />
                    <input type="button" value="确认剪裁" id="crop_submit" />
                    <input type="button" value="取消上传" id="reset" />
                </form>
                    </div>
                ';
    	break;   
    case 1:   
        echo "上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值";   
        break;   
    case 2:   
        echo "上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值";   
        break;   
    case 3:   
        echo "文件只有部分被上传";   
        break;   
    case 4:   
        echo "没有文件被上传";   
        break;   
}
}
?>