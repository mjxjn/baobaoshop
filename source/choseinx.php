<?php
define('IN_ECS', true);

require('../includes/init.php');
//require('json.class.php');
require(ROOT_PATH . 'includes/lib_order.php');

/* 载入语言文件 */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/shopping_flow.php');

if ($_REQUEST['act'] == 'check_packaging_goods')
{
	include_once('../includes/cls_json.php');
	$result = array('err_msg' => 0, 'result' => '', 'content' => '', 'count' => '0', 'goods' => '');
    $json  = new JSON;
	
	$id=$_REQUEST['id'];
	$packaging_type=$_REQUEST['packaging_type'];
	if($packaging_type == 5)
	{
		$goods_id=split(',',$_REQUEST['goods_id']);
		$s=sizeof($goods_id);
		for($i=0;$i<$s;$i++)
		{
			$sql = "SELECT goods_name,goods_number ".
                "FROM " .$GLOBALS['ecs']->table('goods'). 
                "WHERE goods_id = ".$goods_id[$i];
        	$row = $GLOBALS['db']->getRow($sql);
			//查询：系统启用了库存，检查输入的商品数量是否有效
			if (intval($GLOBALS['_CFG']['use_storage']) > 0)
			{
				if ($row['goods_number'] < 1)
				{
					$m['err_msg']=-1;
					$goods_name.=$row['goods_name'].' ';
				}
			}
			$goods[$i]=$goods_id[$i];
		}
		
		if($m['err_msg']==-1)
		{
			$m['content']='由于商品'.$goods_name.'库存不足，不能选购';
		}else{
			$m['err_msg']=0;
			$m['count']=$s;
			$m['content']=$s;
			$m['goods']=$goods;
		}
	}
	die($json->encode($m));
}
?>