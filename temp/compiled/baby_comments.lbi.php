<SCRIPT type=text/javascript src="/js/transport.js"></SCRIPT>
<SCRIPT type=text/javascript src="/js/utils.js"></SCRIPT>
 <?php 
$k = array (
  'name' => 'baby_comments',
  'type' => $this->_var['ia_id'],
  'id' => $this->_var['baby_id'],
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>