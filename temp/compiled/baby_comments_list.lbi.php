<div class="scrip_box" id="scrip_box">
<div class="clear"></div>


      <div class="commentsList talk_content">
      <form action="javascript:;" onsubmit="submitComment(this)" method="post" name="commentForm" id="commentForm">
       <table width="652" border="0" cellspacing="0" cellpadding="0">
        <tr>
         
          <td width="552" height="30" <?php if (! $this->_var['enabled_captcha']): ?><?php endif; ?>>欢迎您：<?php if ($_SESSION['user_name']): ?><?php echo $_SESSION['user_name']; ?><?php else: ?><?php echo $this->_var['lang']['anonymous']; ?><?php endif; ?><input name="username" type="hidden" value="<?php echo $_SESSION['user_name']; ?>" id="username" /></td>
        </tr>
        <tr>
         
          <td height="30">
          <textarea name="content" class="inputBorder" cols="90" rows="10"></textarea>
          <input type="hidden" name="cmt_type" value="<?php echo $this->_var['comment_type']; ?>" />
          <input type="hidden" name="id" value="<?php echo $this->_var['id']; ?>" />
          </td>
        </tr>
        <tr>
          <td height="30" align="right">
          
          <input name="" type="submit" class="talkbtn"  value="" style="margin-right:10px">
          </td>
        </tr>
      </table>
      </form>
      </div>
      
      
      
      <div class="zixun_bar">
                    
                  </div>
		<div id="goods_comments_list_box_body">
		<?php if ($this->_var['comments']): ?>
		<?php $_from = $this->_var['comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'comment');if (count($_from)):
    foreach ($_from AS $this->_var['comment']):
?>
		<div class="pl_line ">
		  <ul class="pl_zone pl">
		    <li><strong>
		    <?php if ($this->_var['comment']['username']): ?>
		    <?php echo htmlspecialchars($this->_var['comment']['username']); ?>
		    <?php else: ?>
		    <?php echo $this->_var['lang']['anonymous']; ?>
		    <?php endif; ?>
		    </strong>&nbsp;&nbsp;<span>发表于 <?php echo $this->_var['comment']['add_time']; ?></span></li>
		    <li class="pl_txt"> <?php echo $this->_var['comment']['content']; ?></li>
		      </ul>
		  
		  <div class="clear"></div>
		</div>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		<?php else: ?>
		        <?php echo $this->_var['lang']['no_comments']; ?>
		<?php endif; ?>
		<div class="page_box" id="page_box_pl">
		<form name="selectPageForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
		 <span><font><a href="<?php echo $this->_var['pager']['page_first']; ?>">«首页</a></font></span><span><font><a href="<?php echo $this->_var['pager']['page_prev']; ?>">­上一页</a></font></span>
		 <?php $_from = $this->_var['pager']['page_number']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item_0_87422500_1372238120');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item_0_87422500_1372238120']):
?>
		  <?php if ($this->_var['pager']['page'] == $this->_var['key']): ?>
		 <span id="page_on"><?php echo $this->_var['key']; ?></span>
		 <?php else: ?>
		 <span><font><a href="<?php echo $this->_var['item_0_87422500_1372238120']; ?>"><?php echo $this->_var['key']; ?></a></font></span>
		 <?php endif; ?>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		 <span><font><a href="<?php echo $this->_var['pager']['page_next']; ?>">­下一页</a></font></span><span><font><a href="<?php echo $this->_var['pager']['page_last']; ?>">­尾页»</a></font></span><span><font><?php echo $this->_var['pager']['page']; ?>/共<?php echo $this->_var['pager']['page_count']; ?>页</font></span> 
		 </form>
		 </div>
		 
		</div>
</div>

<script type="text/javascript">
//<![CDATA[
<?php $_from = $this->_var['lang']['cmt_lang']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item_0_87474700_1372238120');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item_0_87474700_1372238120']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item_0_87474700_1372238120']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

/**
 * 提交评论信息
*/
function submitComment(frm)
{
  var cmt = new Object;

  cmt.username        = frm.elements['username'].value;
  //cmt.email           = frm.elements['email'].value;
  cmt.content         = frm.elements['content'].value;
  cmt.type            = frm.elements['cmt_type'].value;
  cmt.id              = frm.elements['id'].value;
  cmt.enabled_captcha = frm.elements['enabled_captcha'] ? frm.elements['enabled_captcha'].value : '0';
  cmt.captcha         = frm.elements['captcha'] ? frm.elements['captcha'].value : '';
  cmt.rank            = 0;

  /*for (i = 0; i < frm.elements['comment_rank'].length; i++)
  {
    if (frm.elements['comment_rank'][i].checked)
    {
       cmt.rank = frm.elements['comment_rank'][i].value;
     }
  }*/

  if (cmt.username.length == 0)
  {
     alert("对不起，请登录后评论");
     return false;
  }

  /*if (cmt.email.length > 0)
  {
     if (!(Utils.isEmail(cmt.email)))
     {
        alert(cmt_error_email);
        return false;
      }
   }
   else
   {
        alert(cmt_empty_email);
        return false;
   }*/

   if (cmt.content.length == 0)
   {
      alert(cmt_empty_content);
      return false;
   }
	
	var data_lg="{"
 for (var a in cmt){
	 data_lg += '"' ;
	 data_lg += a ;
	 data_lg += '"' ;
	 data_lg += ':' ;
	 
	 
	 data_lg += '"' ;
	 data_lg += cmt[a] ;
	 data_lg += '"' ;
	  if(a != 'rank') data_lg += ',' ;
	 }
	 data_lg += '}' ;
	 //alert(data_lg);
	 Ajax.call('/comment.php', 'cmt=' + data_lg, commentResponse, 'POST', 'JSON');
   return false;

   /*if (cmt.enabled_captcha > 0 && cmt.captcha.length == 0 )
   {
      alert(captcha_not_null);
      return false;
   }

   Ajax.call('comment.php', 'cmt=' + cmt.toJSONString(), commentResponse, 'POST', 'JSON');
   return false;*/
}

/**
 * 处理提交评论的反馈信息
*/
  function commentResponse(result)
  {
    if (result.message)
    {
      alert(result.message);
    }

    if (result.error == 0)
    {
      var layer = document.getElementById('ECS_COMMENT');

      if (layer)
      {
        layer.innerHTML = result.content;
      }
    }
  }

//]]>
</script>