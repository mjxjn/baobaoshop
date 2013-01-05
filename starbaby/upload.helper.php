<?php
if ( ! function_exists('UserUpload'))

{

    function UserUpload($uploadname, $ftype='image', $rnddd=0, $watermark=TRUE, $filetype='' )

    {
    	return $uploadname;

        if($watermark) include_once(DEDEINC.'/image.func.php');

        

        $file_tmp = isset($uploadname) ? $uploadname : '';

        if($file_tmp=='' || !is_uploaded_file($file_tmp) )

        {

            return -1;

        }

        

        $file_tmp = $uploadname;

        $file_size = filesize($file_tmp);

        $file_type = $filetype=='' ? strtolower(trim('litpic_type')) : $filetype;

        
		$uploadname_name='litpic_name';
        $file_name = isset($uploadname_name) ? $uploadname_name : '';

        $file_snames = explode('.', $file_name);

        $file_sname = strtolower(trim($file_snames[count($file_snames)-1]));

        

        if($ftype=='image' || $ftype=='imagelit')

        {

            $filetype = '1';

            $sparr = Array('image/pjpeg', 'image/jpeg', 'image/gif', 'image/png', 'image/xpng', 'image/wbmp','image/bmp');

            if(!in_array($file_type, $sparr)) return 0;

            if($file_sname=='')

            {

                if($file_type=='image/gif') $file_sname = 'jpg';

                else if($file_type=='image/png' || $file_type=='image/xpng') $file_sname = 'png';

                else if($file_type=='image/wbmp') $file_sname = 'bmp';

                else $file_sname = 'jpg';

            }

            $filedir = '/starbaby/uploads/'.date("Ymd");

        }

        else if($ftype=='media')

        {

            $filetype = '3';

            if( !preg_match('/'.$cfg_mediatype.'/', $file_sname) ) return 0;

            $filedir = $cfg_other_medias.'/'.MyDate($cfg_addon_savetype, time());

        }

        else

        {

            $filetype = '4';

            $cfg_softtype .= '|'.$cfg_mediatype.'|'.$cfg_imgtype;

            $cfg_softtype = str_replace('||', '|', $cfg_softtype);

            if( !preg_match('/'.$cfg_softtype.'/', $file_sname) ) return 0;

            $filedir = $cfg_soft_dir.'/'.MyDate($cfg_addon_savetype, time());

        }

        if(!is_dir($filedir))

        {

            if(!mkdir($filedir))   
		        echo "文件上传目录不存在并且无法创建文件上传目录";   
		    if(!chmod($filedir,0755))   
		        echo "文件上传目录的权限无法设定为可读可写";

        }

        $filename = date('ymdHis').rand(1000,9999);

        if($ftype=='imagelit') $filename .= '-L';

        if( file_exists($filedir.'/'.$filename.'.'.$file_sname) )

        {

            for($i=50; $i <= 5000; $i++)

            {

                if( !file_exists($filedir.'/'.$filename.'-'.$i.'.'.$file_sname) )

                {

                    $filename = $filename.'-'.$i;

                    break;

                }

            }

        }

        $fileurl = $filedir.'/'.$filename.'.'.$file_sname;

        $rs = move_uploaded_file($file_tmp, $fileurl);

        if(!$rs) return -2;

        if($ftype=='image' && $watermark)

        {

            WaterImg($cfg_basedir.$fileurl, 'up');

        }

        

        

        return $fileurl;

    }

}
?>