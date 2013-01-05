<?php
/**
 * Inter��ܺ����ļ�֮������
 * ����������ԣ��ɶ���ʹ�á�
 * ���ļ��Ĵ�����˼·�ο������³����ڴ�һ����л��
 *     - ��̳����Mybb{@link http://www.mybbchina.net/}
 *     - PHP���Slightphp{@link http://phpchina.com/bbs/thread-150396-1-1.html}
 *     - PHP���DooPHP{@link http://doophp.com/blog/article/diagnostic-debug-view-in-doophp}
 *
 * @author Horse Luke<horseluke@126.com>
 * @copyright Horse Luke, 2009
 * @license the Apache License, Version 2.0 (the "License"). {@link http://www.apache.org/licenses/LICENSE-2.0}
 * @version $Id$
 * @package Inter_PHP_Framework
 */

class Inter_Error
{

    /**
         * ������������á��������������ϵ���Ϊ��
         * debugMode��
     * �Ƿ���debugģʽ����Ϊtrue���������������ʾ��ϸ��Ϣ�����򽫲���ʾ��
     * ����ѡ��Ĭ��Ϊfalse����ѡ����true����false��
     * �������ͣ�bool
     * 
     * friendlyExceptionPage��
     * ϵͳ����exception��ʱ���׳����Ѻ���ҳ�ļ�����·��
     * ����ѡ��Ĭ��Ϊ�ա�������ֻ�е�debugModeΪfalseʱ����Ч
     * ��ָ��Ϊ��ҳ�ļ�������·����������Ҫ�Ǿ���·���������ļ������ڻ���Ϊ�գ��򲻽����κβ�����
     * ����ʱ���ȡrequireģʽ�����������б�֤��ֹxss�Ĺ�����
     * �������ͣ�string
     * 
     * logType��
     * �Դ�����а�������׷�����ڵ���ϸ��¼��detail��������ֻ��Ҫ�򵥼�¼��simple������ʹ��PHP����error_log���м�¼����
     * false���������κμ�¼��
     * ����ѡ��Ĭ��Ϊfalse����ѡ��'detail'����'simple'���߲���ֵfalse��
     * ����������������������ϸ��¼��detail���������ڸ߷�����������£���־����Ŀ���ǳ����ң�
     * �������ͣ�bool|string
         * 
         * logDir��
     * ��¼��־���ļ��У�Ŀ¼·��������β��Ҫ����б�ܡ�
     * ����ѡ�� Ĭ��Ϊ�ա�������ֻ�е�logType��Ϊfalseʱ����Ч��
     * ���ҵ�Ϊ��Ϊ�ա����߲���Ŀ¼������Ŀ¼�����ڣ�����php.ini�����ý��д����¼����
     * �������ͣ�string
     * 
     * suffix��
     * ��¼��־���ļ���׺��
     * �������ͣ�string
     * 
     * variables��
     * ָ��Ҫ��������ı�������
     * �������ͣ�array
     * 
         * @var array
         */
    public static $conf = array(
                                'debugMode' => false,
                                'friendlyExceptionPage' => '',
                                'logType' => false,
                                'logDir' => '',
                                'suffix' => '-Inter-ErrorLog.log',
                                'variables' => array("_GET", "_POST", "_SESSION", "_COOKIE")
                                );

    /**
         * (˽��)���д����쳣����Ϣ�洢����
         * @var array
         */
    private static $_allError = array();

    /**
         * (˽��)�Ƿ����PHP��register_shutdown_functionע���˱��ྲ̬����error_display��error_display
         *
         * @var unknown_type
         */
    private static $_registered = false;


    /**
     * ����PHP�׳���exception
     *
     * @param Exception $e
     */
    public static function exception_handler(Exception $e){

        self::init();

        $errorInfo = array();
        $errorInfo['time'] = time();
        $errorInfo['type'] = 'EXCEPTION';
        $errorInfo['name'] = get_class($e);
        $errorInfo['code'] = $e->getCode();
        $errorInfo['message'] = $e->getMessage();
        $errorInfo['file'] = $e->getFile();
        $errorInfo['line'] = $e->getLine();
        $errorInfo['trace'] = self::_format_trace($e->getTrace());

        self::$_allError[] = $errorInfo;

        //$debugModeΪfalseʱ�򣬸���self::$friendlyExceptionPage�����Ѻô������
        if(false == self::$conf['debugMode']){
            if(is_file(self::$conf['friendlyExceptionPage'])){
                require(self::$conf['friendlyExceptionPage']);
            }
        }

    }


    /**
     * ����PHP���ֵĴ���
     *
     * @param integer $errno �������
     * @param string $errstr ������Ϣ
     * @param string $errfile ���������ļ�
     * @param string $errline ����������
     */
    public static function error_handler($errno, $errstr, $errfile, $errline) {

        self::init();

        $errorInfo = array();
        $errorInfo['time'] = time();
        $errorInfo['type'] = 'ERROR';

        //��error���ͽ���ֱ�ۻ�����~
        $errorText = array("1"=>"E_ERROR",
                            "2"=>"E_WARNING",
                            "4"=>"E_PARSE",
                            "8"=>"E_NOTICE",
                            "16"=>"E_CORE_ERROR",
                            "32"=>"E_CORE_WARNING",
                            "64"=>"E_COMPILE_ERROR",
                            "128"=>"E_COMPILE_WARNING",
                            "256"=>"E_USER_ERROR",
                            "512"=>"E_USER_WARNING",
                            "1024"=>"E_USER_NOTICE",
                            "2047"=>"E_ALL",
                            "2048"=>"E_STRICT"
                          );
        if(!empty($errorText[$errno])){
            $errorInfo['name'] = $errorText[$errno];
        }else{
            $errorInfo['name'] = '__UNKNOWN';
        }

        $errorInfo['code'] = $errno;
        $errorInfo['message'] = $errstr;
        $errorInfo['file'] = $errfile;
        $errorInfo['line'] = $errline;
        $trace = debug_backtrace();
        unset($trace[0]);    //���ø��������error_handler������������trace����ɾ��
        $errorInfo['trace'] = self::_format_trace($trace);

        self::$_allError[] = $errorInfo;
    }

    /**
     * ��ʼ������
     */
    public static function init(){
        if( false == self::$_registered ){
            register_shutdown_function(array('Inter_Error', 'write_errorlog'));
            register_shutdown_function(array('Inter_Error', 'error_display'));
            self::$_registered = true;
        }
    }


    /**
     * (˽��)�Դ������׷����Ϣ���и�ʽ���������
     *
     * @param array $trace �������׷����Ϣ����
     * @return array $trace �������׷����Ϣ����
     */
    private static function _format_trace($trace){
        $return = array();
        //����׷�ټ�¼����
        foreach ($trace as $stack => $detail){
            if(!empty($detail['args'])){
                $args_string = self::_args_to_string($detail['args']);
            }else{
                $args_string = '';
            }

            //�淶׷�ټ�¼���п�PHP̫�����ɣ���trace��¼Ҳ�ǲ�����ͬ-_-||��
            $return[$stack]['class'] = isset($trace[$stack]['class']) ? $trace[$stack]['class'] : '';
            $return[$stack]['type'] = isset($trace[$stack]['type']) ? $trace[$stack]['type'] : '';
            //ֻ�д���function��ʱ�򣬲ſ��ܴ���args�����Դ˺ϲ�֮
            $return[$stack]['function'] = isset($trace[$stack]['function']) ? $trace[$stack]['function'].'('.$args_string.')' : '';
            $return[$stack]['file']=isset($trace[$stack]['file']) ? $trace[$stack]['file'] :'' ;
            $return[$stack]['line']=isset($trace[$stack]['line']) ? $trace[$stack]['line'] :'' ;
        }
        return $return;
    }


    /**
     * (˽��)������ת��Ϊ�ɶ����ַ���
     * ��������$e->getTraceAsString()��Ч��
     *
     * @param array $args
     * @return string
     */
    private static function _args_to_string($args){
        $string = '';
        $argsAll = array();
        foreach ($args as $key => $value){
            if(true == is_object($value)){
                $argsAll[$key] = 'Object('.get_class($value).')';
            }elseif(true == is_numeric($value)){
                $argsAll[$key] = $value;
            }elseif(true == is_string($value)){
                $temp = $value;
                if(!extension_loaded('mbstring')){
                    if(strlen($temp) > 300){
                        $temp = substr($temp, 0 ,300).'...';
                    }
                }else{
                    if(mb_strlen($temp) > 300){
                        $temp = mb_substr($temp, 0 ,300).'...';
                    }
                }
                $argsAll[$key] = "'{$temp}'";
                $temp = null;
            }elseif(true == is_bool($value)){
                if(true == $value){
                    $argsAll[$key] = 'true';
                }else{
                    $argsAll[$key] = 'false';
                }
            }else{
                $argsAll[$key] = gettype($value);
            }
        }
        $string = implode(',', $argsAll);
        return $string;
    }


    /**
     * д�������־
     */
    public static function write_errorlog(){
        if( (false != (bool)self::$conf['logType']) && !empty(self::$_allError) ){
            $logText = '';

            foreach (self::$_allError as $key => $errorInfo){
                //Ϊ����PHP5.1.0�����ϰ汾����ʱ����STRICT ERROR��������ǰ��ʹ��date_default_timezone_set����֮~
                $logText .= date("Y-m-d H:i:s", $errorInfo['time']). "\t".
                $_SERVER["REQUEST_URI"]."\t".
                $errorInfo['type']. "\t".
                $errorInfo['name']. "\t".
                'Code '. $errorInfo['code']. "\t".
                $errorInfo['message']. "\t".
                $errorInfo['file']. "\t".
                'Line '. $errorInfo['line']. "\n";

                if('detail' == self::$conf['logType'] && !empty($errorInfo['trace'])){
                    $prefix = "TRACE\t#";
                    foreach ( $errorInfo['trace'] as $stack => $trace ){
                        $logText .= $prefix. $stack. "\t". $trace['file']. "\t". $trace['line']. "\t". $trace['class']. $trace['type']. $trace['function']. "\n";
                    }
                }

            }

            if(empty(self::$conf['logDir']) || false == is_dir(self::$conf['logDir'])){
                error_log($logText);
            }else{
                $logFilename= date("Y-m-d",time()). self::$conf['suffix'];
                error_log($logText, 3, self::$conf['logDir']. DIRECTORY_SEPARATOR. $logFilename);
            }
        }
    }

    /**
     * ��ʾ����
     */
    public static function error_display(){
        if(false != self::$conf['debugMode'] && !empty(self::$_allError) ){
            $htmlText = '';
            foreach (self::$_allError as $key => $errorInfo){


                //����divͷ
                $htmlText .= '<div class="intererrorblock">
                                                        <div class="intererrortitle">['.$errorInfo['name'].'][Code '.$errorInfo['code'].'] '.$errorInfo['message'].'</div>
                                                        <div class="intererrorsubtitle">Line '.$errorInfo['line'].' On <a href="'.$errorInfo['file'].'">'.$errorInfo['file'].'</a></div>
                                                        <div class="intererrorcontent">
                                                        ';

                //trace��ʾ��
                if(empty($errorInfo['trace'])){
                    $htmlText .= 'No Traceable Information.';
                }else{
                    $htmlText .= '<table width="100%" border="1" cellpadding="1" cellspacing="1" rules="rows">
                                                                        <tr>
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">File</th>
                                                                                <th scope="col">Line</th>
                                                                                <th scope="col">Class::Method(Args)</th>
                                                                        </tr>';
                    foreach ($errorInfo['trace'] as $stack => $trace){
                        $htmlText .= '<tr>
                                                                                <td>'.$stack.'</td>
                                                                                <td><a href="'.$trace['file'].'">'.$trace['file'].'</a></td>
                                                                                <td>'.$trace['line'].'</td>
                                                                                <td>'.$trace['class']. $trace['type']. htmlspecialchars($trace['function']) .'</td>
                                                                        </tr>';
                    }
                    $htmlText .= '</table>';
                }

                //����divβ
                $htmlText .= '  </div>
                                                </div>
                                                        ';
            }

            //���
            echo <<<END
<style type="text/css">
<!--
.intererrorblock {
        font-size: 12pt;
        background-color: #FFC;
        text-align: left;
        vertical-align: middle;
        display: inline-block;
        border-collapse: collapse;
        word-break: break-all;
        padding: 3px;
        width: 100%;
}

.intererrorblock a:link {
        color: #00F;
        text-decoration: none;
}
.intererrorblock a:visited {
        text-decoration: none;
        color: #00F;
}
.intererrorblock a:hover {
        text-decoration: underline;
        color: #00F;
}
.intererrorblock a:active {
        text-decoration: none;
        color: #00F;
}

.intererrortitle {
        color: #FFF;
        background-color: #963;
        padding: 3px;
        font-weight: bold;
}

.intererrorsubtitle {
        padding: 3px;
        font-weight: bold;
        color: #F00;
}

.intererrorcontent {
        font-size: 11pt;
        color: #000;
        background-color: #FFF;
        padding: 3px;
}

.intererrorcontent table{
        font-size:14px;
        word-break: break-all;
        background-color:#D4D0C8;
        border-color:#000000;
}

.intererrorblock table a:link {
        color: #00F;
        text-decoration: none;
}
.intererrorblock table a:visited {
        text-decoration: none;
        color: #00F;
}
.intererrorblock table a:hover {
        text-decoration: underline;
        color: #00F;
}
.intererrorblock table a:active {
        text-decoration: none;
        color: #00F;
}

-->
</style>
{$htmlText}
END;

        self::show_variables();
        }
    }
    
    /**
     * ָ��������������ʾ
     */
    public static function show_variables(){
        $variables_link = '';
        $variables_content = '';
        foreach( self::$conf['variables'] as $key ){
            $variables_link .= '<a href="#variables'.$key.'">$'.$key.'</a>&nbsp;';
            $variables_content .= '<div class="variablessubtitle"><a name="variables'.$key.'" id="variables'.$key.'"></a>$'.$key.'</strong></div>
                                                  <div class="variablescontent">';
            if(!isset($GLOBALS[$key])){
                $variables_content .= '$'. $key .' IS NOT SET.';
            }else{
                $variables_content .= nl2br(htmlspecialchars(var_export($GLOBALS[$key], true)));
            }
             $variables_content .= '</div>';
        }
        
            //���
            echo <<<END
<style type="text/css">
<!--
.variablesblock {
        font-size: 12pt;
        background-color: #CCC;
        text-align: left;
        vertical-align: middle;
        display: inline-block;
        border-collapse: collapse;
        word-break: break-all;
        padding: 3px;
        width: 100%;
        color: #000;
}

.variablesblock a:link {
        color: #000;
        text-decoration: none;
}
.variablesblock a:visited {
        text-decoration: none;
        color: #000;
}
.variablesblock a:hover {
        text-decoration: underline;
        color: #000;
}
.variablesblock a:active {
        text-decoration: none;
        color: #000;
}

.variablessubtitle {
        padding: 3px;
        font-weight: bold;
        border: 1px solid #FFF;
}

.variablescontent {
        font-size: 11pt;
        color: #000;
        background-color: #FFF;
        padding: 3px;
}
-->
</style>
<div class="variablesblock">
    <div class="variablessubtitle">Variables: {$variables_link}</div>
    {$variables_content}
</div>
END;

    }

}