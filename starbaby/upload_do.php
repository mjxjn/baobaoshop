<?php
include("upload.helper.php");
$dopost=$_REQUEST['dopost'];
$litpic=$_REQUEST['litpic'];


if($dopost=="uploadLitpic")
{
    $upfile = UserUpload($litpic, 'imagelit', 0, false );
	
    if($upfile=='-1')
    {
        $msg = "<script language='javascript'>
                parent.document.getElementById('uploadwait').style.display = 'none';
                alert('你没指定要上传的文件或文件大小超过限制！');
            </script>";
    }
    else if($upfile=='-2')
    {
        $msg = "<script language='javascript'>
                parent.document.getElementById('uploadwait').style.display = 'none';
                alert('上传文件失败，请检查原因！');
            </script>";
    }
    else if($upfile=='0')
    {
        $msg = "<script language='javascript'>
                parent.document.getElementById('uploadwait').style.display = 'none';
                alert('文件类型不正确！');
            </script>";
    }
    else
    {
         /*if(!empty($cfg_uplitpic_cut) && $cfg_uplitpic_cut=='N')
         {
                 $msg = "<script language='javascript'>
                    parent.document.getElementById('uploadwait').style.display = 'none';
                    parent.document.getElementById('picname').value = '{$upfile}';
                    if(parent.document.getElementById('divpicview'))
                    {
                        parent.document.getElementById('divpicview').style.width = '150px';
                        parent.document.getElementById('divpicview').innerHTML = \"<img src='{$upfile}?n' width='150' />\";
                    }
                </script>";
         }
         else
         {*/
               $msg = "<script language='javascript'>
                    parent.document.getElementById('uploadwait').style.display = 'none';
                    window.open('/starbaby/imagecut.php?f=picname&isupload=yes&file={$upfile}', 'popUpImagesWin', 'scrollbars=yes,resizable=yes,statebar=no,width=800,height=600,left=150, top=50');
                </script>";
         /*}*/
   }
    echo $msg;
    exit();
}
?>