<?php if ($this->_var['pager']['page_count'] != 1): ?>

<form name="selectPageForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
<div class="ft baby-paginator">         
			<div class="dpl-paginator">
                 <?php if ($this->_var['pager']['page_prev']): ?>
                 <a class="dpl-paginator-pre" href="<?php echo $this->_var['pager']['page_prev']; ?>" hidefocus="true">上一页<span class="dpl-paginator-arrow-left"></span></a>
                 <?php else: ?>
                 <span class="page-prev">            
                 <span>上一页</span>
                 </span>
                 <?php endif; ?>
                 
	        	 <?php $_from = $this->_var['pager']['page_number']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
	             <?php if ($this->_var['pager']['page'] == $this->_var['key']): ?>
	             <span class="dpl-paginator-break"><?php echo $this->_var['key']; ?></span>
	             <?php else: ?>
                 <a href="<?php echo $this->_var['item']; ?>"><?php echo $this->_var['key']; ?></a>
                 <?php endif; ?>
                 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                 
                 <?php if ($this->_var['pager']['page_next']): ?>
                 <a href="<?php echo $this->_var['pager']['page_next']; ?>" class="dpl-paginator-next">下一页<span class="dpl-paginator-arrow-right"></span></a>
        		 <?php else: ?>
        		 <span class="page-next"><span>下一页</span></span>
        		 <?php endif; ?>
        		 <span class="dpl-paginator-skip">共<?php echo $this->_var['pager']['page_count']; ?>页&nbsp;到第</span>
		 		 
				     
				     <input class="J_Dpl_Paginator_JumpTo" maxlength="8" name="page" size="6" type="text" value="1">
				     <span>页</span>
				     
					 <input type="hidden" name="xz" value="<?php echo $this->_var['xz']; ?>">
					 <input type="hidden" name="sx" value="<?php echo $this->_var['sx']; ?>">
					 <input type="hidden" name="sort1" value="<?php echo $this->_var['sort1']; ?>">
					 <input type="hidden" name="sort2" value="<?php echo $this->_var['sort2']; ?>">
					 <button type="submit">确定</button>
				 
    		</div>
</div>
<?php if ($this->_var['pager']['page_kbd']): ?>
    <?php $_from = $this->_var['pager']['search']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
      <?php if ($this->_var['key'] == 'keywords'): ?>
          <input type="hidden" name="<?php echo $this->_var['key']; ?>" value="<?php echo urldecode($this->_var['item']); ?>" />
        <?php else: ?>
          <input type="hidden" name="<?php echo $this->_var['key']; ?>" value="<?php echo $this->_var['item']; ?>" />
      <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
</form>
<script type="Text/Javascript" language="JavaScript">
<!--

function selectPage(sel)
{
  sel.form.submit();
}

//-->
</script>
<?php endif; ?>