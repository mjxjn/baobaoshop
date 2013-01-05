<?php
/***************************************
*作者：天才贝贝（beibei）
*完成时间：2011-10-18
*类名：CreatMiniature
*功能：生成多种类型的缩略图
*基本参数：$srcFile,$echoType
*方法用到的参数：
				$toFile,生成的文件
				$toW,生成的宽
				$toH,生成的高
				$bk1,背景颜色参数 以255为最高
				$bk2,背景颜色参数
				$bk3,背景颜色参数
*例：
	include("creatminiature.php");
	$cm=new CreatMiniature();
	$cm->SetVar("bei1.jpg","file");
	$cm->Distortion("dis_bei.jpg",200,300);
	$cm->Prorate("pro_bei.jpg",200,300);
	$cm->Cut("cut_bei.jpg",200,300);
	$cm->BackFill("fill_bei.jpg",200,300);
	
	imagecopy -- 拷贝图像的一部分
	说明
	int imagecopy ( resource dst_im, resource src_im, int dst_x, int dst_y, int src_x, int src_y, int src_w, int src_h )

	即 int imagecopy (截取后图片,截取目标图片，
	将 src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。

***************************************/
class CreatMiniature
{
	//公共变量
	var $srcFile="";        //原图
	var $echoType;			//输出图片类型，link--不保存为文件；file--保存为文件
	var $im="";				//临时变量
	var $srcW="";			//原图宽
	var $srcH="";			//原高度
	var $bgk1="";
	var $bgk2="";
	var $bgk3="";
	

	//设置变量及初始化
	function SetVar($srcFile,$echoType,$bgk1,$bgk2,$bgk3)
	{
		$this->srcFile=$srcFile;
		$this->echoType=$echoType;
		
		$this->bgk1=$bgk1;
		$this->bgk2=$bgk2;
		$this->bgk3=$bgk3;
		

	    $info = "";
	    $data = GetImageSize($this->srcFile,$info);//GetImageSize获取图片的参数array getimagesize ( string $filename [, array &$imageinfo ] )
	    switch ($data[2]) //（string $file，高度，宽带，类型1：gif2：jpg3：png，宽和高字符串）获取图片格式 $info在上面定义了 为图片的类型
	    {
		 case 1:  //gig
		   if(!function_exists("imagecreatefromgif")){
		    echo "你的GD库不能使用GIF格式的图片，请使用Jpeg或PNG格式！<a href='javascript:go(-1);'>返回</a>";
		    exit();
		   }
		   $this->im = imagecreateFromGIF($this->srcFile);//方法：SetVar->im
		   break;
		case 2:  //jpg
		  if(!function_exists("imagecreatefromjpeg")){
		   echo "你的GD库不能使用jpeg格式的图片，请使用其它格式的图片！<a href='javascript:go(-1);'>返回</a>";
		   exit();
		  }
		  $this->im = imagecreateFromJpeg($this->srcFile);    
		  break;
		case 3:   //png
		  $this->im = imagecreateFromPNG($this->srcFile);    
		  break;
	  }
	  $this->srcW=ImageSX($this->im);//int imagesx(int im)取得图片的宽度
	  $this->srcH=ImageSY($this->im); 
	}
	
	//生成扭曲型缩图
	function Distortion($toFile,$toW,$toH)
	{
		$cImg=$this->CreatImage($this->im,$toW,$toH,0,0,0,0,$this->srcW,$this->srcH);
		return $this->EchoImage($cImg,$toFile);
		ImageDestroy($cImg);
	}
	
	//生成按比例缩放的缩图
	function Prorate($toFile,$toW,$toH)
	{
		if($toW > 0 && $toH > 0)

				$scale = min($toW/$this->srcW, $toH/$this->srcH); // 计算缩放比例

			elseif($toW == 0)

				$scale = $toH/$this->srcH;

			elseif($toH == 0)

				$scale = $toW/$this->srcW;
		
		if($scale >= 1)

		{

                // 超过原图大小不再缩略

                $ftoW   =  $this->srcW;

                $ftoH  =  $this->srcH;

        }

		else

		{

                // 缩略图尺寸

                $ftoW  = (int)($this->srcW*$scale);

                $ftoH = (int)($this->srcH*$scale);

        }
		

			$cImg=$this->CreatImage($this->im,$ftoW,$ftoH,0,0,0,0,$this->srcW,$this->srcH);
			return $this->EchoImage($cImg,$toFile);
			ImageDestroy($cImg);

	}
	
	//生成最小裁剪后的缩图
	function Cut($toFile,$toW,$toH)
	{
		  $toWH=$toW/$toH;
		  $srcWH=$this->srcW/$this->srcH;
		  if($toWH<=$srcWH)
		  {
			   $ctoH=$toH;
			   $ctoW=$ctoH*($this->srcW/$this->srcH);
		  }
		  else
		  {
			  $ctoW=$toW;
			  $ctoH=$ctoW*($this->srcH/$this->srcW);
		  } 
		$allImg=$this->CreatImage($this->im,$ctoW,$ctoH,0,0,0,0,$this->srcW,$this->srcH);
		$cImg=$this->CreatImage($allImg,$toW,$toH,0,0,($ctoW-$toW)/2,($ctoH-$toH)/2,$toW,$toH);
		return $this->EchoImage($cImg,$toFile);
		ImageDestroy($cImg);
		ImageDestroy($allImg);
	}

	//生成背景填充的缩图
	function BackFill($toFile,$toW,$toH,$bk1=255,$bk2=255,$bk3=255)
	{	$bk1=$this->bgk1;
		$bk2=$this->bgk2;
		$bk3=$this->bgk3;
		$toWH=$toW/$toH;
		
		$srcWH=$this->srcW/$this->srcH;
		if($toWH<=$srcWH)
		{
			$ftoW=$toW;
		    $ftoH=$ftoW*($this->srcH/$this->srcW);
		}
		else
		{
			  $ftoH=$toH;
			  $ftoW=$ftoH*($this->srcW/$this->srcH);
		}
		if(function_exists("imagecreatetruecolor"))
		{
			@$cImg=imagecreatetruecolor($toW,$toH);
			if(!$cImg)
			{
				$cImg=imagecreate($toW,$toH);
			}
		}
		else
		{
			$cImg=imagecreate($toW,$toH);
		}
		//$cImg=imagecreate($toW,$toH);
		$backcolor = imagecolorallocate($cImg, $bk1, $bk2, $bk3);	
	
	
		//echo 'cImg='.$cImg.'<br/>';
		//echo 'cImg='.$cImg.'<br/>';
		//填充的背景颜色
		imagefilledrectangle($cImg,0,0,$toW,$toH,$backcolor);
		
		if($this->srcW>$toW||$this->srcH>$toH)
		{	 
			$proImg=$this->CreatImage($this->im,$ftoW,$ftoH,0,0,0,0,$this->srcW,$this->srcH);
	
			 if($ftoW<$toW)
			 {
				 imagecopy($cImg,$proImg,($toW-$ftoW)/2,0,0,0,$ftoW,$ftoH);
			 }
			 else if($ftoH<$toH)
			 {
				 imagecopy($cImg,$proImg,0,($toH-$ftoH)/2,0,0,$ftoW,$ftoH);
			 }
			 else
			 {
				 imagecopy($cImg,$proImg,0,0,0,0,$ftoW,$ftoH);
			 }
		}
		else
		{
			
			 imagecopy($cImg,$this->im,($toW-$this->srcW)/2,($toH-$this->srcH)/2,0,0,$this->srcW,$this->srcH);
		}
		return $this->EchoImage($cImg,$toFile);
		ImageDestroy($cImg);
	}
	

	function CreatImage($img,$creatW,$creatH,$dstX,$dstY,$srcX,$srcY,$srcImgW,$srcImgH)//方法CreatImage（$img,宽度，高，开始的横坐标，开始的纵坐标，w，h，原w,原h）
	{
		if(function_exists("imagecreatetruecolor"))
		{
			
			@$creatImg = imagecreatetruecolor($creatW,$creatH);
			$tgbakbg=imagecolorallocate($creatImg,$this->bgk1,$this->bgk2,$this->bgk3);
			//echo $tgbakbg;
			imagefilledrectangle($creatImg,0,0,$creatW,$creatH,$tgbakbg);
			if($creatImg) 
				imagecopyResampled($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);
			else
			{
				$creatImg=imagecreate($creatW,$creatH);
			    imagecopyresized($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);
			}
		 }
		 else
		 {
			$creatImg=imagecreate($creatW,$creatH);
			imagecopyresized($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);
		 }
		 return $creatImg;
	}
	
	//输出图片，link---只输出，不保存文件。file--保存为文件
	function EchoImage($img,$to_File)//EchoImage()方法
	{
		switch($this->echoType)
		{
			case "link":
				if(function_exists('imagejpeg')) return ImageJpeg($img);
				else return ImagePNG($img);
			    break;
			case "file":
				if(function_exists('imagejpeg')) return ImageJpeg($img,$to_File);
		        else return ImagePNG($img,$to_File);
				break;
		}
	}

}
?>
