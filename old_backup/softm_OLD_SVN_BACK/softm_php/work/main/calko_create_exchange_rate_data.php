<?
//#!/usr/local/php/bin/php -q


/*
 Filename       : /calko/calko_write.php
 Fuction        : 견적작성
 Comment        :
 Make   Date    : 2009-08-21,
 Update Date    : 2009-08-21, v1.0 first
 Writer         : 김지훈
 Updater        :
 @version       : 1.0
*/
?>
<?php
/*
*/
//ECHO $_ENV['TERM'];
//echo $_SERVER['HTTP_USER_AGENT'];
if ( strpos(strtoupper($_ENV['TERM']), 'XTERM') === false ) {
    //echo 'window';
    require_once 'C:/WEB_APP/doc/inc/calko.lib'   ; // calko.lib
} else {
    //echo 'unix';
    require_once '/usr/local/apache/htdocs/inc/calko.lib'   ; // calko.lib
}
if (
    ( SERVER_GUBUN == '2' && strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), 'LYNX'   ) === false ) ||
    ( SERVER_GUBUN == '1' && strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), 'MOZILLA') === false )
    //false
) {
    header("HTTP/4.0 404 Not Found");
//    print $_SERVER[HTTP_USER_AGENT];
} else {

if ( SERVER_GUBUN == '1' ) {
    define ("HOME_DIR" , 'C:/WEB_APP/doc/' );
    define ('SERVICE'  , 'CALKO' );
    define ('BASE_DIR' , '..' );
    define ('SERVICE_DIR', 'C:/WEB_APP/doc/service');
} else {
    define ("HOME_DIR" , '/usr/local/apache/htdocs' );
    define ('SERVICE'  , 'CALKO' );
    define ('BASE_DIR' , '..' );
    define ('SERVICE_DIR', '/usr/local/apache/htdocs/service');
}

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
if ( SERVER_GUBUN == '1' ) {
    define('LOG_FILENAME'   , 'C:/WEB_APP/logs/calko.log');
} else {
    define('LOG_FILENAME'   , '/work/logs/calko.log');
}
define('LOG_LEVEL'      , PEAR_LOG_DEBUG    );
define('PHP_LOG_LEVEL'  , PEAR_LOG_WARNING  );

$today_date = date('Ymd', mktime()); // 오늘날짜 yyyymmdd 형태

$conf = array(
    'buffering' => false,
    'lineFormat' => '',
    'timeFormat' => '%Y-%m-%d %H:%M:%S'
/*
    'lineFormat' => '[%3$s] %2$s %1$s (%5$s %6$s %7$s) %4$s',
    'timeFormat' => '%Y%m%d %H:%M:%S'
*/
);
$logger = &Log::singleton('file', LOG_FILENAME . "." . $today_date, 'tp', $conf);
//$logger = &Log::singleton('display', '', 'tp', $conf);
//$logger = &Log::singleton('console', '', 'tp', $conf);

//$mask = Log::UPTO(^PEAR_LOG_WARNING | PEAR_LOG_WARNING);
$mask = PEAR_LOG_ALL ^ Log::MASK(PEAR_LOG_NOTICE);
$logger->setMask($mask);

require_once SERVICE_DIR . '/common/lib/logger.inc';

require_once HOME_DIR . '/inc/calko.lib'   ; // calko.lib
require_once HOME_DIR . '/inc/calko_array.lib'   ; // calko_array.lib

require_once SERVICE_DIR . '/common/lib/lib.inc'                      ; // standard lib
require_once SERVICE_DIR . '/common/lib/DB.php'                       ; // DB
require_once SERVICE_DIR . '/common/lib/class.inputfilter_clean.php'  ; // 필터
require_once SERVICE_DIR . '/common/lib/form.inc'                     ; // form
require_once SERVICE_DIR . '/common/Session.php';

require_once SERVICE_DIR . '/common/lib/mail.inc';
require_once SERVICE_DIR . '/common/lib/file.inc';

//$memInfor = Session::getSession();
//echo 'login_yn : ' . $memInfor['login_yn'];
//print $_SERVER[HTTP_USER_AGENT];
//var_dump($_REQUEST  );
//var_dump($_GET  );
//var_dump($http_response_header );
//var_dump($_ENV );
//var_dump($_SERVER);
//$logger->log($_SERVER[HTTP_USER_AGENT]);
$op = strtolower(trim($_GET["op"])) ;
$op = !$op?'default':$op                ;   // Process parameter [display, save]
$db = new DB (); // db instance
$NL = "\n";
$NL = "";
//print (iconv("UTF-8", "EUC-KR","## START ## TP RECEIVE & SENDMAIL ------------------------ START" . $NL));
?>
<?
$db->getConnect();
$logger->log($_SERVER[HTTP_USER_AGENT] . ' / ' . $_SERVER[REMOTE_ADDR]);
$logger->log(iconv("UTF-8", "EUC-KR","## START ## Create " . ACCOUNTING_BEFORE_YEAR . " TO "  . ACCOUNTING_YEAR. " - tbl_accounting_exchange_rate ------------------------ START" . $NL));

$tY = (int)substr(date('Y'),2,2);
$tM = (int)date('m')-1;
define('ACCOUNTING_BEFORE_YEAR' , sprintf("%02d%02d", ($tM<=9?$tY-1:$tY), ($tM<=9?$tY:$tY+1)));  // 회계년도
    try {
        if ( $db->starttransaction() ) {
            $sql = "INSERT INTO tbl_accounting_exchange_rate " . "\n"
                 . " (". "\n"
                 . " COUNTRY_CODE   ,". "\n"
                 . " CLASS_NAME     ,". "\n"
                 . " ACCOUNTING_YEAR,". "\n"
                 . " MARGIN_RATE    ,". "\n"
                 . " MARKUP_RATE    ,". "\n"
                 . " SGNA_RATE      ,". "\n"
                 . " EXCHANGE_RATE  ,". "\n"
                 . " USE_YN         ,". "\n"
                 . " REG_DATE       ,". "\n"
                 . " MOD_DATE       ,". "\n"
                 . " REG_USER_ID    ,". "\n"
                 . " MOD_USER_ID     ". "\n"
                 . " ) ". "\n"
                 . " SELECT                         ". "\n"
                 . " COUNTRY_CODE   ,". "\n"
                 . " CLASS_NAME     ,". "\n"
                 . "     '" . ACCOUNTING_YEAR ."',  ". "\n"
                 . " MARGIN_RATE    ,". "\n"
                 . " MARKUP_RATE    ,". "\n"
                 . " SGNA_RATE      ,". "\n"
                 . " EXCHANGE_RATE  ,". "\n"
                 . " USE_YN         ,". "\n"
                 . " now()          ,". "\n"
                 . " now()          ,". "\n"
                 . " 1              ,". "\n"
                 . " NULL            ". "\n"
                 . " FROM tbl_accounting_exchange_rate". "\n"
                 . " WHERE ACCOUnTING_YEAR = '" . ACCOUNTING_BEFORE_YEAR . "'". "\n"
                 . " AND USE_YN = 'Y'". "\n"
            ;
            //echo $sql;
            //exit;
            if (!$db->exec($sql)) {
                $errors[] = $db->getErrMsg() . ' / ' . $db->getLastSql();
            } else {
            }

            if ( empty($errors) && $db->commit() ) {
                $logger->log(iconv("UTF-8", "EUC-KR",'    ## SUCCESS'. $NL));
            } else {
                $logger->log(iconv("UTF-8", "EUC-KR",'    ## ERROR getMessage : ' . implode($errors, "', '"). $NL));
            }
        }
    } catch (Exception $e) {
        $logger->log(iconv("UTF-8", "EUC-KR",'    ## ERROR getMessage : ' . $e->getMessage(). $NL));
    }
}
$db->release();
$logger->log(iconv("UTF-8", "EUC-KR","## END ## Create " . ACCOUNTING_BEFORE_YEAR . " TO "  . ACCOUNTING_YEAR. " - tbl_accounting_exchange_rate ------------------------ END" . $NL));
$logger->log($NL);
?>