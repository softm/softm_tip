<?php
// 로그레벨 설정 상수가 Log.php에 들어 있기 때문에
// 로그 레벨 설정과 logger.php보다 Log.php를 먼저 require 해줘야 한다.
require_once 'Log.php';
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
define('LOG_FILENAME'   , 'C:/WEB_APP/logs/test.log');
define('LOG_LEVEL'      , PEAR_LOG_DEBUG    );
define('PHP_LOG_LEVEL'  , PEAR_LOG_WARNING  );
echo $_SERVER['SERVER_SOFTWARE'];
//phpinfo();
$today_date = date('Ymd', mktime()); // 오늘날짜 yyyymmdd 형태

$conf = array(
    'buffering' => false,
    'lineFormat' => '[%3$s] %2$s %1$s (%5$s %6$s %7$s) %4$s',
    'timeFormat' => '%Y%m%d %H:%M:%S'
);
echo 'LOG_FILENAME : ' . LOG_FILENAME .'<BR>';
$logger = &Log::singleton('file', LOG_FILENAME . "." . $today_date, 'test', $conf);
$mask = Log::UPTO(PEAR_LOG_DEBUG);
$logger->setMask($mask);


require_once '../service/common/lib/logger.inc';

echo "Why?<br/>";

$logger->log("하하..", PEAR_LOG_INFO);
$logger->debug("허허.. 이건 DEBUG레벨");
$logger->alert("경고야!!");
$arr = array("key" => "value",
    "array-" => "var_export_str 함수를 이용해서 감싸서 로그를 남기세요."
);
$logger->info("객체나 배열같은 변수를 로깅 하는 방법은 두가지가 있다.");
$logger->info($arr); # 이처럼 변수를 그냥 넘기는 방법과
$logger->info("배열 : " . var_export_str($arr)); # 이렇게 var_export_str()로 감싸는 방법
?>