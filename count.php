<?php
/**
 *
 * 文档统计
 *
 * 如果想显示点击次数,请增加view参数,即把下面ＪＳ调用放到文档模板适当位置
 * <script src="/count.php?view=yes&aid={dede:field name='id'/}" language="javascript"></script>
 * 普通计数器为
 * <script src="/count.php?aid={dede:field name='id'/}" language="javascript"></script>
 *
 * @version        $Id: count.php 1 20:43 2010年7月8日Z tianya $
 * @package        DedeCMS.Site
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

$arcID = isset($_GET['aid']) ? intval($_GET['aid']) : 0;

$view = isset($_GET['view']) ? 'yes' : '';

$arcID = $aid = empty($arcID)? 0 : intval(preg_replace("/[^\d]/",'', $arcID));

$maintable = $GLOBALS['ecs']->table('article');

$idtype='article_id';

if($aid==0) exit();

//UpdateStat();
if(!empty($maintable))
{
    $GLOBALS['db']->query(" UPDATE {$maintable} SET click=click+1 WHERE {$idtype}='$aid' ");
}
if(!empty($view))
{
    $row = $GLOBALS['db']->getRow(" SELECT click FROM {$maintable} WHERE {$idtype}='$aid' ");
    if(is_array($row))
    {
        echo "document.write('".$row['click']."');\r\n";
    }
}

exit();