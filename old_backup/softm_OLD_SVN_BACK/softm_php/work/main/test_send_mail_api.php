<?
define ("HOME_DIR" , realpath(dirname(dirname(__FILE__))) );
define ('SERVICE'  , 'CALKO' );
define ('BASE_DIR' , '..' );
define ('SERVICE_DIR', '../service');
//ECHO $_ENV['TERM'];
//var_dump($GLOBALS);

if ( strpos(strtoupper($_ENV['TERM']), 'XTERM') === false ) {
    //echo 'window';
    require_once 'C:/WEB_APP/doc/inc/calko.lib'   ; // calko.lib
} else {
    //echo 'unix';
    require_once '/usr/local/apache/htdocs/inc/calko.lib'   ; // calko.lib
}

require_once '../inc/calko_array.lib'   ; // calko_array.lib

require_once SERVICE_DIR . '/common/lib/lib.inc'                      ; // standard lib
require_once SERVICE_DIR . '/common/lib/DB.php'                       ; // DB
require_once SERVICE_DIR . '/common/lib/class.inputfilter_clean.php'  ; // 필터
require_once SERVICE_DIR . '/common/lib/form.inc'                     ; // form

require_once SERVICE_DIR . '/common/Session.php';
$db = new DB (); // db instance
    $db->getConnect();
        $p_esti_no = 'XX09100007001';
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
        //echo 'SERVER_GUBUN : ' . SERVER_GUBUN . '<BR>';
        if ( SERVER_GUBUN == '1' ) {
            define('LOG_FILENAME'   , 'C:/WEB_APP/logs/calko_tp_receive_n_sendmail.php.log');
        } else {
            define('LOG_FILENAME'   , '/work/logs/calko_tp_receive_n_sendmail.php.log');
        }
        @chmod(LOG_FILENAME, 0777);

        //unlock(LOG_FILENAME);
        define('LOG_LEVEL'      , PEAR_LOG_DEBUG    );
        define('PHP_LOG_LEVEL'  , PEAR_LOG_WARNING  );
        //echo 'LOG_FILENAME : ' . LOG_FILENAME;
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
        $e_mail = 'jihun.kim@tkek.co.kr';
       $e_mail = 'softm@nate.com';
        $user_name = 'test';
        if ( $e_mail ) {
            require_once SERVICE_DIR . '/common/lib/mail.inc';

            $sql = "SELECT \n"
                 . "  USER_NAME,\n"
                 . "  E_MAIL    \n"
                 . " FROM tbl_member\n"
                 . " WHERE USER_ID = 'admin'\n"
               //. " WHERE USER_LEVEL = 9\n"
                 ;
            $adminInfo = $db->get($sql);
            //echo 'e_mail : ' . $e_mail . '<BR>';
            //echo 'user_name : ' . $user_name . '<BR>';
            //echo 'E_MAIL : ' . $adminInfo->E_MAIL . '<BR>';
            //echo 'USER_NAME : ' . $adminInfo->USER_NAME . '<BR>';
             $message = '<html>' . "\n"
                      . '<body>' ."\n"
                      . "Quotation Number : " . substr($p_esti_no,0,6) . '-' . substr($p_esti_no,6,5) . '-' . substr($p_esti_no,11) . "<br>" . "\n"
                      . "TP Completed!" . "<BR><b><a href=\"http://" . SERVER_DOMAIN . "/?backurl=". urlencode("/calko/calko_write.php?p_esti_no=") . $p_esti_no . "\">Go Site!!</a></b>" . "\n"
                    //. '<iframe src="http://www.daum.net/"></iframe>' . "\n"
                    //. '<a href=# onclick="alert(\'test\');">test</a>' . "\n"
                      . '</body>' . "\n"
                      . '</html>' . "\n"
            ;

            $fInfo = array();
            $p_file_cnt = 1;
            for ( $i=0;$i<$p_file_cnt;$i++) {
                if ( @file_exists(iconv("UTF-8", "EUC-KR","C:\WEB_APP\logs\test.log")) ) {
                    $tmpFinfo[dir      ] = 'C:\WEB_APP\logs';
                    $tmpFinfo[real_name] = iconv("UTF-8", "EUC-KR","test.log");
                    $tmpFinfo[size     ] = @filesize('C:\WEB_APP\logs\test.log');
                    $tmpFinfo[name     ] = '';
                    //echo 'size : ' . $tmpFinfo[size     ]. "\n";
                    $fInfo[] = $tmpFinfo;
                }
            }

            $sendMailItem = new sendMailItem("mail.tkek.co.kr",25,
                                             $e_mail, $user_name,
                                             $adminInfo->E_MAIL ,$adminInfo->USER_NAME,
                                             "Quotation Completed - " . substr($p_esti_no,0,6) . '-' . substr($p_esti_no,6,5) . '-' . substr($p_esti_no,11) . ' / ' . date('Y/m/d h:i:s A') ,"text/html",
                                             $message,
                                             $fInfo
                                            );
            $sendmail_flag = sendMail($sendMailItem);
            //echo '$sendmail_flag : ' . $sendmail_flag;
            if ($sendmail_flag) {
                $logger->log(iconv("UTF-8", "EUC-KR","## Send Mail Success(PHP) : " . $p_esti_no . $NL));
            } else {
                $logger->log(iconv("UTF-8", "EUC-KR","## Send Mail Fail(PHP) : " . $p_esti_no . $NL));
            }
        } else {
            $logger->log(iconv("UTF-8", "EUC-KR","## invalid Mail (PHP) : " . $p_esti_no . $NL));
        }
    $db->release();
?>