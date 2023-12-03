<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</HEAD>

<BODY>
<?
require_once 'Log.php';

$logger = &Log::singleton('file', 'C:\WEB_APP\logs\test.log', 'Test'); # 로깅을 위한 객체 얻기
$logger->log('이래 저래 에러가 났잖아욧!'); # 로그 메시지 출력하기
/*
 * PEAR_LOG_EMERG   emerg() 시스템이 사용 불가 상태에 빠졌다.
 * PEAR_LOG_ALERT   alert() 즉시 처리가 필요하다.
 * PEAR_LOG_CRIT    crit() 심각한 상태이다.
 * PEAR_LOG_ERR     err() 오류
 * PEAR_LOG_WARNING warning() 경고
 * PEAR_LOG_NOTICE  notice() 주의
 * PEAR_LOG_INFO    info() 정보
 * PEAR_LOG_DEBUG   debug() 디버그 메시지
*/

echo 'PEAR_LOG_EMERG   : ' . PEAR_LOG_EMERG   . '<BR>';
echo 'PEAR_LOG_ALERT   : ' . PEAR_LOG_ALERT   . '<BR>';
echo 'PEAR_LOG_CRIT    : ' . PEAR_LOG_CRIT    . '<BR>';
echo 'PEAR_LOG_ERR     : ' . PEAR_LOG_ERR     . '<BR>';
echo 'PEAR_LOG_WARNING : ' . PEAR_LOG_WARNING . '<BR>';
echo 'PEAR_LOG_NOTICE  : ' . PEAR_LOG_NOTICE  . '<BR>';
echo 'PEAR_LOG_INFO    : ' . PEAR_LOG_INFO    . '<BR>';
echo 'PEAR_LOG_DEBUG   : ' . PEAR_LOG_DEBUG   . '<BR>';
error_reporting(0);
$conf = array('mode'=>0600, 'timeFormat'=>'%X %x');
$logger = &Log::singleton('display', '', 'ident', $conf);
for ($i = 0; $i < 10; $i++) {
    $logger->log("Log entry $1", PEAR_LOG_NOTICE);
}

$conf = array('error_prepend' => '<font color="#ff0000"><tt>',
              'error_append'  => '</tt></font>');
$logger = &Log::singleton('display', '', '', $conf, PEAR_LOG_DEBUG);
//$mask = Log::UPTO(PEAR_LOG_INFO);
//$logger->setMask($mask);

echo 'getMask() : ' . $logger->getMask() . '<BR>' ;
for ($i = 0; $i < 10; $i++) {
    $logger->log("display - Log entry $i");
}


function exceptionHandler($exception)
{
    global $logger;

    $logger->log($exception->getMessage(), PEAR_LOG_ALERT);
}

//set_exception_handler('exceptionHandler');
//throw new Exception('Uncaught Exception');



function errorHandler($code, $message, $file, $line)
{
    global $logger;

    /* Map the PHP error to a Log priority. */
    switch ($code) {
    case E_WARNING:
    case E_USER_WARNING:
        $priority = PEAR_LOG_WARNING;
        break;
    case E_NOTICE:
    case E_USER_NOTICE:
        $priority = PEAR_LOG_NOTICE;
        break;
    case E_ERROR:
    case E_USER_ERROR:
        $priority = PEAR_LOG_ERR;
        break;
    default:
        $priority = PEAR_LOG_INFO;
    }

    $logger->log($message . ' in ' . $file . ' at line ' . $line,
                 $priority);
}

//set_error_handler('errorHandler');
//trigger_error('This is an    log message.', E_USER_NOTICE);

$conf = array('mode' => 0600, 'timeFormat' => '%X %x');
$logger = &Log::singleton('file', 'C:\WEB_APP\logs\test.log', 'ident', $conf);
for ($i = 0; $i < 10; $i++) {
    $logger->log("file - Log entry $i");
}

$logger = &Log::singleton('firebug', '', 'ident');
for ($i = 0; $i < 10; $i++) {
    $logger->log("firebug - Log entry $i");
}

$logger = &Log::singleton('null');
for ($i = 0; $i < 10; $i++) {
    $logger->log("null - Log entry $i");
}
?>
</BODY>
</HTML>
