<ol style="display: block;" id="jy_list" class="nav_jyc">
			<?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['categories'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categories']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['categories']['iteration']++;
?>
			<li class="top">
            <h2><u class="n<?php echo ($this->_foreach['categories']['iteration'] - 1); ?>"><a href="<?php echo $this->_var['cat']['url']; ?>"><?php echo htmlspecialchars($this->_var['cat']['name']); ?></a></u></h2>
            <em></em>
            <dl class="submenu" style="display: none;">
                <dt>
                    <strong>选择分类</strong>
                    <p class="walink">
                    <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');if (count($_from)):
    foreach ($_from AS $this->_var['child']):
?>
                                <a href="<?php echo $this->_var['child']['url']; ?>"><?php echo htmlspecialchars($this->_var['child']['name']); ?> </a>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                    </p>
                </dt>
                <dt>
                    <strong>推荐品牌</strong>
                    <p class="walink">
                                <a href="/brand-222-c0.html">美赞臣</a>
                                <a href="/brand-74-c0.html">多美滋</a>
                                <a href="/brand-102-c0.html">惠氏</a>
                                <a href="/brand-92-c0.html">合生元</a>
                                <a href="/brand-95-c0.html">花王</a>
                                <a href="/brand-68-c0.html">大王</a>
                                <a href="/brand-89-c0.html">好奇</a>
                                <a href="/brand-63-c0.html">贝亲</a>
                                <a href="/brand-115-c0.html">康贝</a>
                                <a href="/brand-22-c0.html">bobo</a>
                                <a href="/brand-202-c0.html">新安怡</a>
                                <a href="/brand-227-c0.html">培宝康</a>
                                <a href="/brand-219-c0.html">智灵通</a>
                                <a href="/brand-160-c0.html">生命阳光</a>
                                <a href="/brand-111-c0.html">金奇仕</a>
                                <a href="/brand-188-c0.html">味奇</a>
                                <a href="/brand-94-c0.html">亨氏</a>
                                <a href="/brand-67-c0.html">布朗博士</a>
                    </p>
                </dt>
            </dl>
            </li>
           <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>  
            <!--<li class="bom">
                <u class="n80"><a href="map.php">全部交易分类&gt;&gt;</a></u>
            </li>-->
    </ol>
