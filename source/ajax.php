<?php
define('IN_ECS', true);

require('../includes/init.php');
//require('json.class.php');
require(ROOT_PATH . 'includes/lib_order.php');

/* 载入语言文件 */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/shopping_flow.php');

if ($_REQUEST['step'] == 'validate_bonus')
{
	$bonus_sn = trim($_REQUEST['bonus_sn']);
	if(!empty($bonus_sn))
	{
		include_once('../includes/cls_json.php');
		$result = array('error' => 0, 'message' => '', 'content' => '', 'package_id' => '');
    	$json  = new JSON;
		
		if (is_numeric($bonus_sn))
		{
			$bonus = bonus_info(0, $bonus_sn);
		}
		else
		{
			$bonus = array();
		}
		$bonus_kill = price_format($bonus['type_money'], false);
		
		/* 取得购物类型 */
		$flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;
	
		/* 获得收货人信息 */
		$consignee = get_consignee($_SESSION['user_id']);
	
		/* 对商品信息赋值 */
		$cart_goods = cart_goods($flow_type); // 取得商品列表，计算合计
		foreach ($cart_goods as $key => $val){
			if($val['is_gift']==0){
				$brand_ids[] = $val['brand_id'];
				$goods_ids[] = $val['goods_id'];
			}
		}
		/* 取得订单信息 */
        $order = flow_order_info();


        if (((!empty($bonus) && $bonus['user_id'] == $_SESSION['user_id']) || ($bonus['type_money'] > 0 && empty($bonus['user_id']))) && $bonus['order_id'] <= 0)
        {
            //$order['bonus_kill'] = $bonus['type_money'];
            if($bonus['coupon_type']==1){
	            $now = gmtime();
	            if ($now > $bonus['use_end_date'])
	            {
	                $order['bonus_id'] = '';
	                $result['error']=$_LANG['bonus_use_expire'];
	            }
	            else
	            {
	                $order['bonus_id'] = $bonus['bonus_id'];
	                $order['bonus_sn'] = $bonus_sn;
	            }
            }
            if($bonus['coupon_type']==2){
            	$ids = explode(",", $bonus['coupon_ids']);
            	foreach ($ids as $k => $v){
            		if(in_array($v,$brand_ids)){
            			$now = gmtime();
            			if ($now > $bonus['use_end_date'])
            			{
            				$order['bonus_id'] = '';
            				$result['error']=$_LANG['bonus_use_expire'];
            			}
            			else
            			{
            				$order['bonus_id'] = $bonus['bonus_id'];
            				$order['bonus_sn'] = $bonus_sn;
            			}
            			break;
            		}else{
            			$order['bonus_id'] = '';
            			$result['error']=$_LANG['invalid_bonus'];
            		}
            	}
            }
            if($bonus['coupon_type']==3){
            	$ids = explode(",", $bonus['coupon_ids']);
            	foreach ($ids as $k => $v){
            		if(in_array($v,$goods_ids)){
            			$now = gmtime();
            			if ($now > $bonus['use_end_date'])
            			{
            				$order['bonus_id'] = '';
            				$result['error']=$_LANG['bonus_use_expire'];
            			}
            			else
            			{
            				$order['bonus_id'] = $bonus['bonus_id'];
            				$order['bonus_sn'] = $bonus_sn;
            			}
            			break;
            		}else{
            			$order['bonus_id'] = '';
            			$result['error']=$_LANG['invalid_bonus'];
            		}
            	}
            }
        }
        else
        {
            //$order['bonus_kill'] = 0;
            $order['bonus_id'] = '';
            $result['error'] = $_LANG['invalid_bonus'];
        }

        /* 计算订单的费用 */
        $total = order_fee($order, $cart_goods, $consignee);

        $smarty->assign('total', $total);

        /* 团购标志 */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }
		
		$result['content']="<ul id=\"total_area\" class=\"fr cart_sum\">
				<li id=\"total_discount\" style=\"display:none;\">折扣：<b>-¥0.00</b></li>
                <li id=\"total_price\">应付商品金额：<font>".$total['goods_price_formated']."</font></li>
                <li id=\"total_discount\" style=\"display:none;\">兑换券折扣：<b>-¥0.00</b></li>
                <li id=\"total_bonus\">优惠券折扣：<b>-".$total['bonus_formated']."</b></li>
                <li id=\"total_amount\" style=\"padding-top: 10px; border-top: 1px solid rgb(234, 234, 234); margin-top: 6px;\">实付商品金额：<font>".$total['amount_formated']."</font></li>
                
                <input id=\"totalprice\" type=\"hidden\" value=\"".$total['goods_price']."\">
                <input id=\"totalhgintegral\" type=\"hidden\" value=\"0\">
                <input id=\"totalbonus\" type=\"hidden\" value=\"".$total['bonus']."\">
                <input id=\"totaldiscount\" type=\"hidden\" value=\"0.00\">
                <input id=\"totalticket\" type=\"hidden\" value=\"0.00\">
                <input id=\"totalamount\" type=\"hidden\" value=\"".$total['amount']."\">
            </ul>	
            <div class=\"clear\"></div>";
		die($json->encode($result));
	}else
	{
		$result['error'] = $_LANG['no_goods_in_cart'];
	}
}
if ($_REQUEST['step'] == 'change_bonus')
{
	if(!empty($_GET['bonus']))
	{
		include_once('../includes/cls_json.php');
		$result = array('error' => 0, 'message' => '', 'content' => '', 'package_id' => '');
    	$json  = new JSON;
		
		$flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;
		
		$consignee = get_consignee($_SESSION['user_id']);
		
		$cart_goods = cart_goods($flow_type); // 取得商品列表，计算合计
		
		$order = flow_order_info();
		
		$bonus = bonus_info(intval($_GET['bonus']));
		
		if ((!empty($bonus) && $bonus['user_id'] == $_SESSION['user_id']) || $_GET['bonus'] == 0)
        {
            $order['bonus_id'] = $_GET['bonus'];
        }
        else
        {
            $order['bonus_id'] = 0;
            $result['error'] = $_LANG['invalid_bonus'];
        }

        /* 计算订单的费用 */
        $total = order_fee($order, $cart_goods, $consignee);
		
		$result['content']="<ul id=\"total_area\" class=\"fr cart_sum\">
                <li id=\"total_price\">应付商品金额：<font>".$total['goods_price_formated']."</font></li>
                <li id=\"total_discount\" style=\"display:none;\">兑换券折扣：<b>-¥0.00</b></li>
                <li id=\"total_bonus\">优惠券折扣：<b>-".$total['bonus_formated']."</b></li>
                <li id=\"total_discount\" style=\"display:none;\">折扣：<b>-¥0.00</b></li>
                <li id=\"total_amount\" style=\"padding-top: 10px; border-top: 1px solid rgb(234, 234, 234); margin-top: 6px;\">实付商品金额：<font>".$total['amount_formated']."</font></li>
                
                <input id=\"totalprice\" type=\"hidden\" value=\"".$total['goods_price']."\">
                <input id=\"totalhgintegral\" type=\"hidden\" value=\"0\">
                <input id=\"totalbonus\" type=\"hidden\" value=\"".$total['bonus']."\">
                <input id=\"totaldiscount\" type=\"hidden\" value=\"0.00\">
                <input id=\"totalticket\" type=\"hidden\" value=\"0.00\">
                <input id=\"totalamount\" type=\"hidden\" value=\"".$total['amount']."\">
            </ul>	
            <div class=\"clear\"></div>";
		
		die($json->encode($result));
	}
	else
	{
		$result['error'] = $_LANG['no_goods_in_cart'];
	}
}
if ($_REQUEST['step'] == 'update_cart')
{
	if (isset($_POST['goods_number']) && isset($_POST['rec_key']) && isset($_POST['goods_id']))
    {
        include_once('../includes/cls_json.php');
		$result = array('error' => 0, 'message' => '', 'content' => '', 'package_id' => '');
    	$json  = new JSON;
		
		$key=$_POST['rec_key'];
		$content['goods_number']=$_POST['goods_number'];
		
		$sql = "SELECT `goods_id`, `goods_attr_id`, `product_id`, `extension_code` FROM" .$GLOBALS['ecs']->table('cart').
               " WHERE rec_id='$key' AND session_id='" . SESS_ID . "'";
        $goods = $GLOBALS['db']->getRow($sql);

        $sql = "SELECT g.goods_name, g.goods_number ".
                "FROM " .$GLOBALS['ecs']->table('goods'). " AS g, ".
                    $GLOBALS['ecs']->table('cart'). " AS c ".
                "WHERE g.goods_id = c.goods_id AND c.rec_id = '$key'";
        $row = $GLOBALS['db']->getRow($sql);
		
		//查询：系统启用了库存，检查输入的商品数量是否有效
        if (intval($GLOBALS['_CFG']['use_storage']) > 0 && $goods['extension_code'] != 'package_buy')
        {
            if ($row['goods_number'] < $_POST['goods_number'])
            {
                $result['message']=(sprintf($GLOBALS['_LANG']['stock_insufficiency'], $row['goods_name'],
                $row['goods_number'], $row['goods_number']));
				$content['goods_number']=$row['goods_number'];
            }
            /* 是货品 */
            $goods['product_id'] = trim($goods['product_id']);
            if (!empty($goods['product_id']))
            {
                $sql = "SELECT product_number FROM " .$GLOBALS['ecs']->table('products'). " WHERE goods_id = '" . $goods['goods_id'] . "' AND product_id = '" . $goods['product_id'] . "'";

                $product_number = $GLOBALS['db']->getOne($sql);
                if ($product_number < $_POST['goods_number'])
                {
                    $result['message']=(sprintf($GLOBALS['_LANG']['stock_insufficiency'], $row['goods_name'],
                    $product_number['product_number'], $product_number['product_number']));
					$content['goods_number']=$product_number;
                }
            }
			
        }
        elseif (intval($GLOBALS['_CFG']['use_storage']) > 0 && $goods['extension_code'] == 'package_buy')
        {
            if (judge_package_stock($goods['goods_id'], $key))
            {
                $result['message']=$GLOBALS['_LANG']['package_stock_insufficiency'];
				$content['goods_number']=$_POST['goods_number'];
            }
        }
		/* 查询：检查该项是否为基本件 以及是否存在配件 */
        /* 此处配件是指添加商品时附加的并且是设置了优惠价格的配件 此类配件都有parent_id goods_number为1 */
        $sql = "SELECT b.goods_number, b.rec_id
                FROM " .$GLOBALS['ecs']->table('cart') . " a, " .$GLOBALS['ecs']->table('cart') . " b
                WHERE a.rec_id = '$key'
                AND a.session_id = '" . SESS_ID . "'
                AND a.extension_code <> 'package_buy'
                AND b.parent_id = a.goods_id
                AND b.session_id = '" . SESS_ID . "'";

        $offers_accessories_res = $GLOBALS['db']->query($sql);
		//订货数量大于0
        if ($key > 0)
        {
            /* 判断是否为超出数量的优惠价格的配件 删除*/
            $row_num = 1;
            while ($offers_accessories_row = $GLOBALS['db']->fetchRow($offers_accessories_res))
            {
                if ($row_num > $goods_number)
                {
                    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') .
                            " WHERE session_id = '" . SESS_ID . "' " .
                            "AND rec_id = '" . $offers_accessories_row['rec_id'] ."' LIMIT 1";
                    $GLOBALS['db']->query($sql);
                }

                $row_num ++;
            }

            /* 处理超值礼包 */
            if ($goods['extension_code'] == 'package_buy')
            {
                //更新购物车中的商品数量
                $sql = "UPDATE " .$GLOBALS['ecs']->table('cart').
                        " SET goods_number = ".$content['goods_number']." WHERE rec_id='$key' AND session_id='" . SESS_ID . "'";
            }
            /* 处理普通商品或非优惠的配件 */
            else
            {
                $attr_id    = empty($goods['goods_attr_id']) ? array() : explode(',', $goods['goods_attr_id']);
                $goods_price = get_final_price($goods['goods_id'], $key, true, $attr_id);

                //更新购物车中的商品数量
                $sql = "UPDATE " .$GLOBALS['ecs']->table('cart').
                        " SET goods_number = ".$content['goods_number'].", goods_price = '$goods_price' WHERE rec_id='$key' AND session_id='" . SESS_ID . "'";
            }
        }
        //订货数量等于0
        else
        {
            /* 如果是基本件并且有优惠价格的配件则删除优惠价格的配件 */
            while ($offers_accessories_row = $GLOBALS['db']->fetchRow($offers_accessories_res))
            {
                $sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') .
                        " WHERE session_id = '" . SESS_ID . "' " .
                        "AND rec_id = '" . $offers_accessories_row['rec_id'] ."' LIMIT 1";
                $GLOBALS['db']->query($sql);
            }

            $sql = "DELETE FROM " .$GLOBALS['ecs']->table('cart').
                " WHERE rec_id='$key' AND session_id='" .SESS_ID. "'";
        }

        $GLOBALS['db']->query($sql);


		/* 删除所有赠品 */
		$sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') . " WHERE session_id = '" .SESS_ID. "' AND is_gift <> 0";
		$GLOBALS['db']->query($sql);
		
		
		$result['content']['goods_number']=$content['goods_number'];
		$content['subtotal']=$goods_price*$content['goods_number'];
		$result['content']['subtotal']=number_format($content['subtotal'], 2, '.', '');	
		
		/* 取得商品列表，计算合计 */
		$cart_goods = get_cart_goods();
		$total=$cart_goods['total'];
		$result['content']['total_area'] = "<li id=\"total_price\">应付商品金额：<font>".$total['goods_price']."</font></li>
                <li id=\"total_discount\" style=\"display:none;\">兑换券折扣：<b>-¥0.00</b></li>
                <li id=\"total_bonus\" style=\"display:none;\">优惠券折扣：<b>-¥0.00</b></li>
                <li id=\"total_discount\" style=\"display:none;\">折扣：<b>-¥0.00</b></li>
                <li id=\"total_amount\" style=\"padding-top: 10px; border-top: 1px solid rgb(234, 234, 234); margin-top: 6px;display:none;\">应付商品金额：<font>".$total['goods_price']."</font></li>
                
                <input id=\"totalprice\" type=\"hidden\" value=\"".$total['goods_amount']."\">
                <input id=\"totalhgintegral\" type=\"hidden\" value=\"0\">
                <input id=\"totalbonus\" type=\"hidden\" value=\"0.00\">
                <input id=\"totaldiscount\" type=\"hidden\" value=\"0.00\">
                <input id=\"totalticket\" type=\"hidden\" value=\"0.00\">
                <input id=\"totalamount\" type=\"hidden\" value=\"".$total['goods_amount']."\">" ;
		
		$favourable_list=favourable_list($_SESSION['user_rank'],$total['favourable_amount']);
		if($favourable_list['0']['available'])
		{
			$result['content']['youhui_show']=2;
			$result['content']['favor_out_cart']=1;
			$result['content']['zengpin_area']="
			<ul class=\"zp_t\"> 
			<li class=\"zp_r1\">特惠赠品</li>
			<li class=\"zp_r2\">起赠额度</li> 
			<li class=\"zp_r3\">最大增领数</li>
			<li class=\"zp_r4\">放入购物车的数量</li> 
			<li class=\"zp_r5\">操作</li> 
			<div class=\"clear\"></div> 
			</ul> 
			<div class=\"zp_box\">"; 
			
			$min_amount=0;
			foreach($favourable_list as $key => $val)
			{
				if($min_amount==0 || $min_amount > $val['min_amount'])
				{
					$min_amount=$val['min_amount'];
				}
				$result['content']['zengpin_area'].="<form action=\"flow.php\" method=\"post\" id=\"favourable_".$val['act_id']."\">";
				if($val['available'])
				{
				$favourable_list['gift']       = unserialize($favourable_list['gift']);
				foreach($val['gift'] as $value)
				{
					if($value['numb'] > 0){
				$result['content']['zengpin_area'].="<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"> 
				<tr> 
				<td class=\"zp_r11 zp_td\"><a href=\"goods.php?id=".$value['id']."\" target=\"_blank\"><img id=\"gift_img_\"".$value['id']." src=\"".$value['goods_thumb']."\" alt=\"".$value['name']."\" width=\"55\" height=\"55\" /></a></td> 
				<td class=\"zp_r12 zp_td\"><a href=\"goods.php?id=".$value['id']."\" target=\"_blank\">".$value['name']."</a></td> 
				<td class=\"zp_r2 zp_td\">".$val['formated_min_amount']."</td> 
				<td class=\"zp_r3 zp_td\">".$value['numb']."</td> 
				<td class=\"zp_r4 zp_td\" align=\"center\"><p class=\"num_line\">
                <input id=\"num_input\" objnum=\"1\" name=\"goods_number[".$value['id']."]\" onkeydown=\"showdiv(this)\" class=\"fl num_input\" maxlength=\"4\" type=\"text\" value=\"1\">
              </p></td> 
				<td class=\"zp_r5 zp_td\"> ";
				if($value['numb'] > 0)
				{
					$result['content']['zengpin_area'].="<a class=\"cbtn putin_btn\" href=\"javascript:add_favourable(".$val['act_id'].",".$value['id'].")\">加入购物车</a>";
				}else
				{
					$result['content']['zengpin_area'].="<a class=\"cbtn unin_btn\">加入购物车</a>";
				}
				 $result['content']['zengpin_area'].="</td> 
				</tr> 
				<tr> <td colspan=\"6\"><div class=\"zp_tip\">赠品说明：".$val['act_name']." 满".$val['formated_min_amount']."赠".$value['name']."</div></td> 
				</tr>
				</table>
				";
				}
				}
				}
				$result['content']['zengpin_area'].="<input type=\"hidden\" value=\"\" id=\"gift_id_".$val['act_id']."\" name=\"gift[]\" />
			    <input type=\"hidden\" name=\"act_id\" value=\"".$val['act_id']."\" />
			    <input type=\"hidden\" name=\"step\" value=\"add_favourable\" />
				</form>";
			}
			$result['content']['zengpin_area'].="</div>";
			
		}
		$min_amount=0;
		foreach($favourable_list as $key => $val)
		{
			if($min_amount==0 || $min_amount > $val['min_amount'])
			{
					$min_amount=$val['min_amount'];
			}
		}
		if($total['goods_amount'] >= $min_amount)
		{
				$result['content']['shipping_area']['down']="<li><span class=\"yh_t\">小提示</span></li>";
		}
		else
		{
				$m_amount=$min_amount-$total['favourable_amount'];
				$m_amount_s=price_format($m_amount, false);;
				$result['content']['shipping_area']['down']="<li><span class=\"yh_t\">小提示</span><p>您还差".$m_amount_s."即可享受".$min_amount."元赠品区，获得更多超值赠品！</p></li>";
		}
		
		$result['content']['cart_favor_area']="";

		if($_SESSION['user_id'] == 0)
		{
			$result['content']['bonus_list_area']="<dt id=\"yhq_2\">
        	<ul class=\"yhq_line\">
            	<li><span class=\"yhq_lab\">输入优惠券/兑换券代码:</span></li>
                <li style=\"width:165px;\" class=\"yhq_select yhq_inputbox\"><input type=\"text\" maxlength=\"25\" name=\"\" class=\"yhq_input\" id=\"bonus_sn\"></li>
                <li id=\"use_quan\" class=\"yhq_select\"><a class=\"cbtn use_btn yhq_js_login\">使用</a></li>
                <li><span class=\"yhq_lab\"><a style=\"padding-left:10px;\" class=\"blue yhq_js_login\">使用已有优惠券&gt;&gt;</a></span></li> 
                <li id=\"yhq_tip_2\"></li> 
            </ul><div class=\"clear\"></div>
        </dt>
		<input type=\"hidden\" id=\"bonus_list_num\" value=\"0\">";
		}else
		{
			/* 如果使用红包，取得用户可以使用的红包及用户选择的红包 */
			if ((!isset($_CFG['use_bonus']) || $_CFG['use_bonus'] == '1')
				&& ($flow_type != CART_GROUP_BUY_GOODS && $flow_type != CART_EXCHANGE_GOODS))
			{
				// 取得用户可用红包
				$user_bonus = user_bonus($_SESSION['user_id'], $total['goods_price']);
				if (!empty($user_bonus))
				{
					$bonus_list_num=0;
					foreach ($user_bonus AS $key => $val)
					{
						$bonus_list_num++;
						$user_bonus[$key]['bonus_money_formated'] = price_format($val['type_money'], false);
					}
					$bonus_list[]=$user_bonus;
					$bonus_list_num=$bonus_list_num;
				}else{
					$bonus_list_num=0;
				}
				// 能使用红包
				$allow_use_bonus=1;
			}
			$result['content']['bonus_list_area']="<dt id=\"yhq_1\" style=\"display:none\">
        	<ul class=\"yhq_line\">
            	<li><span class=\"yhq_lab\">使用已有优惠券:</span></li>";
			if($allow_use_bonus==1 && $bonus_list_num > 0)
			{
				$result['content']['bonus_list_area'].="<li style=\"padding-right:0;width:190px;\" class=\"yhq_select yhq_inputbox\">
                <input type=\"text\" readonly=\"readonly\" value=\"选择您的账户中优惠券...\" style=\"width:200px;cursor:pointer;\" name=\"bonus\" id=\"yhq_input\" class=\"yhq_input\">
                <dl class=\"yhq_list\" style=\"width:210px;cursor:pointer;\">";
				foreach($bonus_list as $bkey => $bval)
				{
					$result['content']['bonus_list_area'].="<dd bonus=\"".$bval['bonus_id']."\">".$bval['type_name']."[".$bval['bonus_money_formated']."]</dd>";
				}
				$result['content']['bonus_list_area'].="</dl>
                </li>";
			}else{
				$result['content']['bonus_list_area'].="<li style=\"padding-right:0;width:212px;\" class=\"yhq_select yhq_inputbox\"><input type=\"text\" readonly=\"readonly\" value=\"您的账户中没有优惠券...\" style=\"width:200px;cursor:pointer;\" name=\"\" id=\"yhq_input\" class=\"yhq_input\">
                </li>";
			}
			$result['content']['bonus_list_area'].="<li class=\"yhq_select\"><span class=\"cbtn yhq_sbtn\">选择</span></li>
                <li><span class=\"yhq_lab\"><a style=\"padding-left:10px;\" class=\"blue yhq_js_change\">输入优惠券/兑换券代码&gt;&gt; </a></span></li>
                <li id=\"yhq_tip_1\"></li> 
            	</ul><div class=\"clear\"></div>
			  </dt>
			   <dt id=\"yhq_2\">
					<ul class=\"yhq_line\">
						<li><span class=\"yhq_lab\">输入优惠券/兑换券代码:</span></li>
						<li style=\"width:165px;\" class=\"yhq_select yhq_inputbox\"><input type=\"text\" maxlength=\"25\" name=\"\" class=\"yhq_input\" id=\"bonus_sn\"></li>
						<li id=\"use_quan\" class=\"yhq_select\"><a class=\"cbtn use_btn\" onclick=\"validateBonus($('#bonus_sn').attr('value'))\">使用</a></li>
						<li><span class=\"yhq_lab\"><a style=\"padding-left:10px;\" class=\"blue yhq_js_change\">使用已有优惠券&gt;&gt;</a></span></li> 
						<li id=\"yhq_tip_2\"></li> 
					</ul><div class=\"clear\"></div>
				</dt>
				<input type=\"hidden\" id=\"bonus_list_num\" value=\"".$bonus_list_num."\">";
		}
		
		die($json->encode($result));
    }
	else{
		$result['error'] = 0;
	}
}
/**
 * 取得某用户等级当前时间可以享受的优惠活动
 * @param   int     $user_rank      用户等级id，0表示非会员
 * @return  array
 */
function favourable_list($user_rank,$price_amount=0)
{
    /* 购物车中已有的优惠活动及数量 */
    $used_list = cart_favourable();

    /* 当前用户可享受的优惠活动 */
    $favourable_list = array();
    $user_rank = ',' . $user_rank . ',';
    $now = gmtime();
    $sql = "SELECT * " .
            "FROM " . $GLOBALS['ecs']->table('favourable_activity') .
            " WHERE CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%'" .
            " AND start_time <= '$now' AND end_time >= '$now'" .
            " AND act_type = '" . FAT_GOODS . "'" .
            " ORDER BY sort_order";
    $res = $GLOBALS['db']->query($sql);
    while ($favourable = $GLOBALS['db']->fetchRow($res))
    {
		if($favourable['min_amount'] != 0 && $price_amount !=0 )
		{
			$numb = floor($price_amount/$favourable['min_amount']);
			$favourable['numb']=$numb;
		}else
		{
			$favourable['numb']=0;
		}
        $favourable['start_time'] = local_date($GLOBALS['_CFG']['time_format'], $favourable['start_time']);
        $favourable['end_time']   = local_date($GLOBALS['_CFG']['time_format'], $favourable['end_time']);
        $favourable['formated_min_amount'] = price_format($favourable['min_amount'], false);
        $favourable['formated_max_amount'] = price_format($favourable['max_amount'], false);
        $favourable['gift']       = unserialize($favourable['gift']);

        foreach ($favourable['gift'] as $key => $value)
        {
            $favourable['gift'][$key]['formated_price'] = price_format($value['price'], false);
			$sql = "SELECT goods_thumb FROM " . $GLOBALS['ecs']->table('goods') . " WHERE is_on_sale = 1 AND goods_id = ".$value['id'];
            $favourable['gift'][$key]['goods_thumb'] = $GLOBALS['db']->getOne($sql);
			$sql = "SELECT goods_number FROM " . $GLOBALS['ecs']->table('goods') . " WHERE is_on_sale = 1 AND goods_id = ".$value['id'];
            $favourable['gift'][$key]['goods_number'] = $GLOBALS['db']->getOne($sql);
			if($favourable['min_amount'] != 0 && $price_amount !=0 )
			{
				$numb = floor($price_amount/$favourable['min_amount']);
				if($favourable['gift'][$key]['goods_number']>$numb)
				{
					$favourable['gift'][$key]['numb']=$numb;
				}else
				{
					$favourable['gift'][$key]['numb']=$favourable['gift'][$key]['goods_number'];
				}
			}else
			{
				$favourable['numb']=0;
			}
            $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('goods') . " WHERE is_on_sale = 1 AND goods_id = ".$value['id'];
            $is_sale = $GLOBALS['db']->getOne($sql);
            if(!$is_sale)
            {
                unset($favourable['gift'][$key]);
            }
        }

        $favourable['act_range_desc'] = act_range_desc($favourable);
        $favourable['act_type_desc'] = sprintf($GLOBALS['_LANG']['fat_ext'][$favourable['act_type']], $favourable['act_type_ext']);
		
		if($favourable['act_type']==0)
		{
			$favourable['act_type_ext']=floor($favourable['act_type_ext']);
		}

        /* 是否能享受 */
        $favourable['available'] = favourable_available($favourable);
        if ($favourable['available'])
        {
            /* 是否尚未享受 */
            $favourable['available'] = !favourable_used($favourable, $used_list);
        }

        $favourable_list[] = $favourable;
    }

    return $favourable_list;
}
/**
 * 根据购物车判断是否可以享受某优惠活动
 * @param   array   $favourable     优惠活动信息
 * @return  bool
 */
function favourable_available($favourable)
{
    /* 会员等级是否符合 */
    $user_rank = $_SESSION['user_rank'];
    if (strpos(',' . $favourable['user_rank'] . ',', ',' . $user_rank . ',') === false)
    {
        return false;
    }

    /* 优惠范围内的商品总额 */
    $amount = cart_favourable_amount($favourable);

    /* 金额上限为0表示没有上限 */
    return $amount >= $favourable['min_amount'] &&
        ($amount <= $favourable['max_amount'] || $favourable['max_amount'] == 0);
}
/**
 * 取得购物车中已有的优惠活动及数量
 * @return  array
 */
function cart_favourable()
{
    $list = array();
    $sql = "SELECT is_gift, COUNT(*) AS num " .
            "FROM " . $GLOBALS['ecs']->table('cart') .
            " WHERE session_id = '" . SESS_ID . "'" .
            " AND rec_type = '" . CART_GENERAL_GOODS . "'" .
            " AND is_gift > 0" .
            " GROUP BY is_gift";
    $res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $list[$row['is_gift']] = $row['num'];
    }

    return $list;
}

/**
 * 购物车中是否已经有某优惠
 * @param   array   $favourable     优惠活动
 * @param   array   $cart_favourable购物车中已有的优惠活动及数量
 */
function favourable_used($favourable, $cart_favourable)
{
    if ($favourable['act_type'] == FAT_GOODS)
    {
        return isset($cart_favourable[$favourable['act_id']]) &&
            $cart_favourable[$favourable['act_id']] >= $favourable['act_type_ext'] &&
            $favourable['act_type_ext'] > 0;
    }
    else
    {
        return isset($cart_favourable[$favourable['act_id']]);
    }
}
/**
 * 取得优惠范围描述
 * @param   array   $favourable     优惠活动
 * @return  string
 */
function act_range_desc($favourable)
{
    if ($favourable['act_range'] == FAR_BRAND)
    {
        $sql = "SELECT brand_name FROM " . $GLOBALS['ecs']->table('brand') .
                " WHERE brand_id " . db_create_in($favourable['act_range_ext']);
        return join(',', $GLOBALS['db']->getCol($sql));
    }
    elseif ($favourable['act_range'] == FAR_CATEGORY)
    {
        $sql = "SELECT cat_name FROM " . $GLOBALS['ecs']->table('category') .
                " WHERE cat_id " . db_create_in($favourable['act_range_ext']);
        return join(',', $GLOBALS['db']->getCol($sql));
    }
    elseif ($favourable['act_range'] == FAR_GOODS)
    {
        $sql = "SELECT goods_name FROM " . $GLOBALS['ecs']->table('goods') .
                " WHERE goods_id " . db_create_in($favourable['act_range_ext']);
        return join(',', $GLOBALS['db']->getCol($sql));
    }
    else
    {
        return '';
    }
}
/**
 * 取得购物车中某优惠活动范围内的总金额
 * @param   array   $favourable     优惠活动
 * @return  float
 */
function cart_favourable_amount($favourable)
{
    /* 查询优惠范围内商品总额的sql */
    $sql = "SELECT SUM(c.goods_price * c.goods_number) " .
            "FROM " . $GLOBALS['ecs']->table('cart') . " AS c, " . $GLOBALS['ecs']->table('goods') . " AS g " .
            "WHERE c.goods_id = g.goods_id " .
            "AND c.session_id = '" . SESS_ID . "' " .
            "AND c.rec_type = '" . CART_GENERAL_GOODS . "' " .
            "AND c.is_gift = 0 " .
            "AND c.goods_id > 0 ";

    /* 根据优惠范围修正sql */
    if ($favourable['act_range'] == FAR_ALL)
    {
        // sql do not change
    }
    elseif ($favourable['act_range'] == FAR_CATEGORY)
    {
        /* 取得优惠范围分类的所有下级分类 */
        $id_list = array();
        $cat_list = explode(',', $favourable['act_range_ext']);
        foreach ($cat_list as $id)
        {
            $id_list = array_merge($id_list, array_keys(cat_list(intval($id), 0, false)));
        }

        $sql .= "AND g.cat_id " . db_create_in($id_list);
    }
    elseif ($favourable['act_range'] == FAR_BRAND)
    {
        $id_list = explode(',', $favourable['act_range_ext']);

        $sql .= "AND g.brand_id " . db_create_in($id_list);
    }
    else
    {
        $id_list = explode(',', $favourable['act_range_ext']);

        $sql .= "AND g.goods_id " . db_create_in($id_list);
    }

    /* 优惠范围内的商品总额 */
    return $GLOBALS['db']->getOne($sql);
}
?>