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
    define('LOG_FILENAME'   , 'C:/WEB_APP/logs/calko_tp_receive_n_sendmail.log');
} else {
    define('LOG_FILENAME'   , '/work/logs/calko_tp_receive_n_sendmail.log');
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
//echo 'where : ' . $where . '<BR>';
//$p_esti_no = 'XX09100012101';
// USER_NO

$sql = "SELECT \n"
     . "  USER_NAME,\n"
     . "  E_MAIL    \n"
     . " FROM tbl_member\n"
     . " WHERE USER_ID = 'admin'\n"
   //. " WHERE USER_LEVEL = 9\n"
     ;
$adminInfo = $db->get($sql);
//$adminInfo->USER_NAME;
//$adminInfo->E_MAIL   ;
$sql = "SELECT "
   //. " DISTINCT STATE "
     . " COUNT(*) cnt"
     . " FROM tbl_calko_header a LEFT OUTER JOIN tbl_member c"
     . " ON a.REG_USER_ID = c.USER_NO,"
     . " tbl_calko_result b\n"
     . " WHERE a.ESTI_NO    = b.ESTI_NO\n"
     . " AND   b.STATE      IN( '8','P' )\n"
     . " AND   b.SEQ        = '1'\n"
     . " AND   b.tp_send_date >= date_add(now(), interval -2 day)\n"
;
$cnt = $db->get($sql)->cnt;
//echo $_SERVER[HTTP_USER_AGENT] . ' / ' . $_SERVER[REMOTE_ADDR];
//echo $cnt . ' / ' . $cnt;
if ( $cnt <= 0 ) exit;
//echo '$cnt : ' . $cnt; 
$logger->log($_SERVER[HTTP_USER_AGENT] . ' / ' . $_SERVER[REMOTE_ADDR]);
$logger->log(iconv("UTF-8", "EUC-KR","## START ## TP RECEIVE & SENDMAIL ------------------------ START" . $NL));

$sql = "SELECT "
   //. " DISTINCT STATE "
     . " a.ESTI_NO      ESTI_NO     ,"
     . " a.COUNTRY_CODE COUNTRY_CODE,"
     . " a.PROJECT_NAME PROJECT_NAME,"
     . " b.VALUE        CLASS_NAME  ,"
     . " b.SEND_MAIL    SEND_MAIL   ,"
     . " a.STATE        STATE       ,"
     . " b.TP_XML_DATA  TP_XML_DATA ,"
     . " b.TP_SEND_DATE TP_SEND_DATE ,"
     . " c.USER_NAME    USER_NAME   ,"
     . " c.E_MAIL       E_MAIL       "
     . " FROM tbl_calko_header a LEFT OUTER JOIN tbl_member c"
     . " ON a.REG_USER_ID = c.USER_NO,"
     . " tbl_calko_result b\n"
     . " WHERE a.ESTI_NO    = b.ESTI_NO\n"
   //. " AND " . ( $memInfor['user_level'] >= 2 ?" a.REG_USER_ID <> ''":" a.REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
   //. " AND   a.ESTI_NO    = '{$p_esti_no}'\n"
     . " AND   a.STATE      IN( '8','P' )\n"
     . " AND   b.SEQ        = '1'\n"
     . " AND   b.tp_send_date >= date_add(now(), interval -2 day)\n"
   //. " ORDER BY STATE asc"
;

//echo 'sql :' . $sql . "\n";
$stmt = $db->multiRowSQLQuery($sql);
$totCnt  = 0;
$procCnt = 0;
$sendCnt = 0;

while ($r = $db->multiRowFetch($stmt)) {
    $totCnt++;
    $p_esti_no   = $r->ESTI_NO;
    $country_code= $r->COUNTRY_CODE ;
    $project_name= $r->PROJECT_NAME ;
    $class_name  = $r->CLASS_NAME   ;
    $send_mail   = $r->SEND_MAIL    ;
    $state       = $r->STATE        ;
    $tp_xml_data = $r->TP_XML_DATA  ;
    $tp_send_date= $r->TP_SEND_DATE ;
    $user_name   = $r->USER_NAME    ;
    $e_mail      = $r->E_MAIL       ;
    //echo $state;
    $errors = array();
    $tp_state = '';

    $logger->log(iconv("UTF-8", "EUC-KR",'## START - ' . $p_esti_no . ' / ' .$state . ' / ' .$country_code . $NL));
/////////////// /////////////// /////////////// /////////////// /////////////// ///////////////
    $logXML = '<?xml version="1.0" encoding="UTF-8"?>'. "\n"
            .  "<ns0:MT_CALKO_QUOT_LOG_REQUEST xmlns:ns0='http://lm-erp.tkeasia.com/SD/CALKO_QUOT_LOG'>\n"
            .  "<ZKSSD0001>\n"
            .  "<BSTKD>" . $p_esti_no . "</BSTKD>\n"
            .  "</ZKSSD0001>\n"
            .  "\n</ns0:MT_CALKO_QUOT_LOG_REQUEST>\n";

    //$logger->log(iconv("UTF-8", "EUC-KR",'    ## CHECK LOG - ' . $p_esti_no . $NL));
    $XI_MESSAGE = ( get_url_fsockopen( "http://".XI_SERVER_IP.":8000/sap/xi/adapter_plain?namespace=http%3A//lm-erp.tkeasia.com/SD/CALKO_QUOT_LOG&interface=MI_CALKO_QUOT_LOG_REQUEST&service=" . XI_SERVICE_ID . "&party=&agency=&scheme=&QOS=BE&sap-user=pisuper&sap-password=tkd12345&sap-client=001&sap-language=EN",$logXML,"text/xml; charset=UTF-8") ); // POST

    $xml_data = str_replace(array('<?xml version="1.0"?>',
                                  '<?xml version="1.0" encoding="UTF-8"?>',
                                  'xmlns:ns1="http://lm-erp.tkeasia.com/SD/CALKO_QUOT_LOG"',
                                  '<ns1:MT_CALKO_QUOT_LOG_RETURN >',
                                  '</ns1:MT_CALKO_QUOT_LOG_RETURN>'
                                  ), '', $XI_MESSAGE);
    //echo $xml_data;
   // echo '<textarea>' . ($xml_data) . '</textarea>';
    if (!$xml_data ) $errors[] = iconv("UTF-8", "EUC-KR",'The XML Data is empty');
    try {
        $xml = @simplexml_load_string('<xml>'.$xml_data.'</xml>');
        //echo '길이 :' . sizeof($xml->T_ZKTXI0002) . '<BR>';
        //echo 'xml_data :' . $xml_data . $NL;

        if (empty($errors)) {
            $lCnt = sizeof($xml->T_ZKTXI0002);
            if ( $lCnt > 0 ) {
                $procCnt++;

                $sCnt = 0;
                $fCnt = 0;
                foreach( $xml->T_ZKTXI0002 as $x ) {
                    if ( $x->MSGTYP == 'S' &&
                         strpos(strtoupper($x->MESSAGE), 'COMPLETED') !== false ) {
                        $sCnt++;
                    }
                    if ( $x->MSGTYP == 'E' &&
                         strpos(strtoupper($x->MESSAGE), 'FAILURE') !== false ) {
                        $fCnt++;
                    }
                }
                $sql = "SELECT "
                     . " COUNT(*) CNT"
                     . " FROM tbl_calko_result "
                     . " WHERE ESTI_NO    = '$p_esti_no'"
                ;
                $QUOTCOUNT = $db->get($sql )->CNT; // 견적갯수

                $savedata = array();
                if ( $sCnt >= $QUOTCOUNT ) { // 성공
                    $tp_state = 'S';
                } else if ( $fCnt > 0 ) { // 실패
                    $tp_state = 'E';
                } else { // 대기
                    $tp_state = 'P';
                }

                //echo $tp_state ;
                // 에러일경우에만 state를 'E'로 업데이트함
                // 성공일경우에는 tp 수신후 'S'상태로
                $savedata['ESTI_NO' ] = "'" . $p_esti_no . "'";
                $savedata['STATE'   ] = "'" . ($tp_state == 'S'?'P':$tp_state) . "'"; // P : Processing,S : Complete,E : Failure
                if ( !($success=specSave('U',$savedata,"STATE !='S'")) ) {
                    $errors[] = iconv("UTF-8", "EUC-KR",'tbl_calko_result TP_LOG Update (STATE) Error.');
                }

                // 첫번째견적만(Seq==1) 로그 기록
                $savedata = array();
                $savedata['ESTI_NO'         ] = "'" . $p_esti_no    . "'";
                $savedata['SEQ'             ] = "'1'"   ;
                $savedata['LOG_XML_DATA'    ] = "'" . addslashes($xml_data) . "'";
                if ( !($success=specSave('U',$savedata,"STATE !='S'")) ) {
                    $errors[] = iconv("UTF-8", "EUC-KR",'tbl_calko_result TP_LOG Update (LOG_XML_DATA) Error.');
                }

                if ( $success ) {
                    $savedata = array();
                    $savedata['ESTI_NO'                ] = "'" . $p_esti_no . "'";
                    $savedata['STATE'                  ] = "'" . ($tp_state == 'S'?'P':$tp_state) . "'"; // P : Processing,S : Complete,E : Failure
                    $success = specHeaderSave('U',$savedata,"STATE !='S'");
                    if ( !$success ) $errors[] = xlate('tbl_calko_header update error!!!');
                }

            } else {
                $errors[] = iconv("UTF-8", "EUC-KR",'T_ZKTXI0002 node size zero!!');
            }
        } else {
            $errors[] = iconv("UTF-8", "EUC-KR",'XML data emplty!!');
        }

        if ( empty($errors) ) {
            if ( $tp_state == 'S' ) {
                $logger->log(iconv("UTF-8", "EUC-KR",'    ## SUCCESS : QUOTCOUNT / STATE : ' . $QUOTCOUNT . ' / ' . $tp_state . $NL));
            } else if ( $tp_state == 'E' ) {
                $logger->log(iconv("UTF-8", "EUC-KR",'    ## ERROR   : QUOTCOUNT / STATE : ' . $QUOTCOUNT . ' / ' . $tp_state . $NL));
            } else if ( $tp_state == 'P' ) {
                $logger->log(iconv("UTF-8", "EUC-KR",'    ## PROCESS : QUOTCOUNT / STATE : ' . $QUOTCOUNT . ' / ' . $tp_state . $NL));
            }
        } else {
            $logger->log(iconv("UTF-8", "EUC-KR",'    ## ERROR : ' . join($errors,',') . $NL));
        }
    } catch (Exception $e) {
        $logger->log(iconv("UTF-8", "EUC-KR",'    ## ERROR getMessage : ' . $e->getMessage(). $NL));
    }

/////////////// /////////////// /////////////// /////////////// /////////////// ///////////////
    //$logger->log('$tp_state : ' . $tp_state. $NL);
    if ($tp_state == 'S'  && empty($errors)) {
        //header("content-type: application/xml; charset=UTF-8");
        //$p_esti_no = 'AO09100005101'; //test fixed tp log
        //$p_esti_no = 'X0809006201'; //test fixed tp price
        //$p_esti_no = 'X0709008501'; //test fixed tp price
        $logXML = '<?xml version="1.0" encoding="UTF-8"?>'. "\n"
                .  "<ns0:MT_CALKO_TRANSFER_PRICE_REQUEST xmlns:ns0='http://lm-erp.tkeasia.com/SD/CALKO_TRANSFER_PRICE'>\n"
                .  "<ZKSSD0001>\n"
                .  "<BSTKD>" . $p_esti_no . "</BSTKD>\n"
                .  "</ZKSSD0001>\n"
                .  "\n</ns0:MT_CALKO_TRANSFER_PRICE_REQUEST>\n";
        //echo $logXML;
        //echo $logXML . "\n";
        //echo "http://".XI_SERVER_IP.":8000/sap/xi/adapter_plain?namespace=http%3A//lm-erp.tkeasia.com/SD/CALKO_TRANSFER_PRICE&interface=MI_CALKO_TRANSFER_PRICE_REQUEST&service=" . XI_SERVICE_ID . "&party=&agency=&scheme=&QOS=BE&sap-user=pisuper&sap-password=tkd12345&sap-client=001&sap-language=EN" . "\n";
        $logger->log(iconv("UTF-8", "EUC-KR",'    ## CHECK TP - ' . $p_esti_no . $NL));

        $XI_MESSAGE = ( get_url_fsockopen( "http://".XI_SERVER_IP.":8000/sap/xi/adapter_plain?namespace=http%3A//lm-erp.tkeasia.com/SD/CALKO_TRANSFER_PRICE&interface=MI_CALKO_TRANSFER_PRICE_REQUEST&service=" . XI_SERVICE_ID . "&party=&agency=&scheme=&QOS=BE&sap-user=pisuper&sap-password=tkd12345&sap-client=001&sap-language=EN",$logXML,"text/xml; charset=UTF-8") ); // POST
        //echo '$XI_MESSAGE : ' . $XI_MESSAGE . "\n";

        if ( $XI_MESSAGE ) {
            $xml_data = str_replace(array('<?xml version="1.0"?>',
                                          '<?xml version="1.0" encoding="UTF-8"?>',
                                          'xmlns:ns1="http://lm-erp.tkeasia.com/SD/CALKO_TRANSFER_PRICE"',
                                          '<ns1:MT_CALKO_TRANSFER_PRICE_RETURN >',
                                          '</ns1:MT_CALKO_TRANSFER_PRICE_RETURN>'
                                          ), '', $XI_MESSAGE);

            if (!$xml_data ) $errors[] = iconv("UTF-8", "EUC-KR",'The XML Data is empty'. "\n");

            try {
                $xml = @simplexml_load_string('<xml>'.addslashes($xml_data).'</xml>');
                //echo '길이 :' . sizeof($xml->ZKSDT0003) . '<BR>';
                if (empty($errors)) {
    //echo '<textarea>' . ($xml_data) . '</textarea>';
    //echo '<textarea>' . ($xml->asXML()) . '</textarea>';
                    if ( sizeof($xml->ZKSDT0003) > 0 ) {
    /*
                        $sql = "SELECT "
                             . " COUNT(*) CNT"
                             . " FROM tbl_calko_result "
                             . " WHERE REG_USER_ID= '" . $memInfor[user_no] . "'\n"
                             . " AND   ESTI_NO    = '$p_esti_no'"
                           //. " ORDER BY STATE asc"
                        ;
                        $QUOTCOUNT = $db->get($sql )->CNT; // 견적갯수
    */
                        $sql = "SELECT \n"
                             . "  a.ACCOUNTING_NO   ACCOUNTING_NO  ,\n"
                             . "  a.ACCOUNTING_YEAR ACCOUNTING_YEAR,\n"
                             . "  a.MARGIN_RATE     MARGIN_RATE    ,\n"
                             . "  a.MARKUP_RATE     MARKUP_RATE    ,\n"
                             . "  a.SGNA_RATE       SGNA_RATE      ,\n"
                             . "  a.EXCHANGE_RATE   EXCHANGE_RATE   \n"
                             . " FROM tbl_accounting_exchange_rate a, tbl_calko_class_name cn\n"
                             . " WHERE a.USE_YN = 'Y'\n"
                             . " AND   a.COUNTRY_CODE = '" . $country_code . "'\n"
                             . " AND   a.CLASS_NAME   = '" . $class_name   . "'\n"
                             . " AND   a.ACCOUNTING_YEAR = '" . ACCOUNTING_YEAR . "'\n"
                             . " AND   a.CLASS_NAME   = cn.CLASS_NAME\n"
                             . " AND   cn.USE_YN = 'Y'\n"
                        ;
                        $exchangeInfo = $db->get($sql);
                        //echo 'MARKUP_RATE   :' . $exchangeInfo->MARKUP_RATE     . '<BR>';
                        //echo 'SGNA_RATE     :' . $exchangeInfo->SGNA_RATE       . '<BR>';
                        //echo 'EXCHANGE_RATE :' . $exchangeInfo->EXCHANGE_RATE   . '<BR>';
                        if ( !empty($exchangeInfo) ) {
                            $margin_rate   = $exchangeInfo->MARGIN_RATE     ;
                            $markup_rate   = $exchangeInfo->MARKUP_RATE     ;
                            $sgna_rate     = $exchangeInfo->SGNA_RATE       ;
                            $exchange_rate = $exchangeInfo->EXCHANGE_RATE   ;

                            $tp_amt_arrs = array();
                            $tp_xml_arrs = array();
                            $sap_esti_no = ''; // sap 견적번호

                            foreach( $xml->ZKSDT0003 as $x ) {
                                $sap_esti_no    = $x->VBELN;
                                $posnr          = $x->POSNR;
                                $kursk          = (float) $x->KURSK;
                                $tp_amt_arrs[$posnr/10] += (float) $x->TP_NETWR * ($kursk?$kursk:1);
                                $tp_xml_arrs[$posnr/10][] = $x->asXML();
                            }
                            //echo '길이 :' . sizeof($tp_xml_arrs) . '<BR>';
                            foreach ($tp_xml_arrs as $k => $v) {
                                //echo "키: $k; 값: $v :: " . join($v) . "<br />\n";
                                $savedata = array();
                                $savedata['ESTI_NO'         ] = "'" . $p_esti_no    . "'";
                                $savedata['SEQ'             ] = "'" . $k            . "'";
                                $savedata['TP_RECV_DATE'    ] = "now()";
                                $savedata['TP_XML_DATA'     ] = "'" . addslashes(join($v))  . "'";
                                $savedata['TP_AMT'          ] = "'" . $tp_amt_arrs[$k]      . "'";
                                $savedata['SAP_ESTI_NO'     ] = "'" . $sap_esti_no          . "'";
                                $savedata['STATE'           ] = "'S'"; // P : Processing,S : Complete,E : Failure
                                $savedata['MARGIN_RATE'     ] = "'" . $margin_rate          . "'";
                                $savedata['MARKUP_RATE'     ] = "'" . $markup_rate          . "'";
                                $savedata['SGNA_RATE'       ] = "'" . $sgna_rate            . "'";
                                $savedata['EXCHANGE_RATE'   ] = "'" . $exchange_rate        . "'";

                                if ( !($success=specSave('U',$savedata)) ) {
                                    $errors[] = xlate('tbl_calko_result TP_PRICE Update Error.\n p_msgtyp : "S"' );
                                } else {
                                    $savedata = array();
                                    $savedata['ESTI_NO'                ] = "'" . $p_esti_no . "'";
                                    $savedata['STATE'                  ] = "'S'"; // P : Processing,S : Complete,E : Failure
                                    $success = specHeaderSave('U',$savedata);
                                    if ( !$success ) $errors[] = xlate('tbl_calko_header TP_PRICE Update Error.\n p_msgtyp : "S"' );

                                    $logger->log(iconv("UTF-8", "EUC-KR",'        ## SUCCESS - ' . $p_esti_no . " / " . $k . $NL));
                                }
                            }
                        } else {
                            $margin_rate   = 0;
                            $markup_rate   = 0;
                            $sgna_rate     = 0;
                            $exchange_rate = 0;
                            $errors[] = xlate('Exchange of information does not exist.( \'' . ACCOUNTING_YEAR . '\' - \'' . $country_code . '\' - \'' . $class_name . '\')');
                        }
                    } else {
                        $errors[] = xlate('ZKSDT0003 node size zero!!');
                    }
                }
            } catch (Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        if ( empty($errors)  ) {
      //if ( empty($errors) && $send_mail == 'N' ) {
            //echo $e_mail;
            if ( $e_mail ) {
                 $sendCnt++;
                 $message = '<html>' . "\n"
                          . '<body>' ."\n"
                          . 'Dear Sir or Madam,' . "<br>" ."<br>" ."<br>" ."\n"
                          . 'Thanks for using Calko, TKEK Quotation System.' . "<br>" ."<br>" . "\n"
                          . 'Attached please find the quotation link for your review.' . "<br>" ."<br>" . "\n"
                          . 'Please don\'t hesitate to contact TKEK Oversea team if you have any queries.' . "<br><br>" . "\n"

                          . "<TABLE style='padding:10px;border-collapse:collapse;border:1px solid black' border=1>" . "\n"
                          . "    <TR>" . "\n"
                          . "    <TD style='padding:0px 4px 0px 4px;background-color:#7B7B7B;color:white;height:30px;font-weight:bold'>Quotation Number</TD>". "\n"
                          . "    <TD style='padding:0px 4px 0px 4px'>" . substr($p_esti_no,0,6) . '-' . substr($p_esti_no,6,5) . '-' . substr($p_esti_no,11) . "</TD>". "\n"
                          . "    </TR>". "\n"
                          . "    <TR>". "\n"
                          . "    <TD style='padding:0px 4px 0px 4px;background-color:#7B7B7B;color:white;height:30px;font-weight:bold'>Requesting Date</TD>". "\n"
                          . "    <TD style='padding:0px 4px 0px 4px'>" . $tp_send_date . "</TD>". "\n"
                          . "    </TR>". "\n"
                          . "    <TR>". "\n"
                          . "    <TD style='padding:0px 4px 0px 4px;background-color:#7B7B7B;color:white;height:30px;font-weight:bold'>Quotation Link</TD>". "\n"
                          . "    <TD style='padding:0px 4px 0px 4px'>" . "<b><a href=\"http://" . SERVER_DOMAIN . "/?backurl=". urlencode("/calko/calko_write.php?p_esti_no=") . $p_esti_no . "\">" . "http://" . SERVER_DOMAIN . "/?backurl=/calko/calko_write.php?p_esti_no=" . $p_esti_no . "</a></b>" . "</TD>". "\n"
                          . "    </TR>". "\n"
                          . "</TABLE>". "\n"
                          . "<BR>". "\n"
                        //. 'CENE Team : 82-2-2610-7764' ."<br>" . "<br>" . "\n"
                        //. 'AMS Team  : ...' . "<br>" . "\n"
                          . 'Best Regards, TKEK oversea team.' . "<br>" . "\n"
                          . '</body>' . "\n"
                          . '</html>' . "\n";
                ;

                $data = file_wget_contents('http://'.SERVER_DOMAIN.'/calko/calko_tp_print_data_create.php?p_esti_no=' . $p_esti_no . '&p_seq=' . $p_seq, 30, '');
                //echo $data ;
                f_writeFile(SERVER_TMP.'/Quotation_'.$p_esti_no.'.html', $data );

                $fInfo = array();
                $p_file_cnt = 1;
                for ( $i=0;$i<$p_file_cnt;$i++) {
                    if ( @file_exists(SERVER_TMP.'/Quotation_'.$p_esti_no.'.html') ) {
                        $tmpFinfo[dir      ] = SERVER_TMP;
                        $tmpFinfo[real_name] = iconv("UTF-8", "EUC-KR",'Quotation_'.$p_esti_no.'.html');
                        $tmpFinfo[size     ] = @filesize(SERVER_TMP.'/Quotation_'.$p_esti_no.'.html');
                        $tmpFinfo[name     ] = '';
                        //echo 'size : ' . $tmpFinfo[size     ]. "\n";
                        $fInfo[] = $tmpFinfo;
                    }
                }

                //echo SERVER_TMP.'/Quotation_'.$p_esti_no.'.html';
                //$e_mail = 'jihun.kim@tkek.co.kr';
                //$user_name = '관뤼자';
                $sendMailItem = new sendMailItem("mail.tkek.co.kr",25,
                                                 $e_mail, $user_name,
                                                 $adminInfo->E_MAIL ,$adminInfo->USER_NAME,
                                                 "[TKEK] Quotation Completed - " . $project_name . '(' . substr($p_esti_no,0,6) . '-' . substr($p_esti_no,6,5) . '-' . substr($p_esti_no,11) . ') / ' . date('Y/m/d h:i:s A') ,"text/html",
                                               //$message
                                                 $message,$fInfo
                                                );
                $sendmail_flag = sendMail($sendMailItem);
                //exec("rm " . SERVER_TMP.'/Quotation_'.$p_esti_no.'.html');
                f_unlink(SERVER_TMP.'/Quotation_'.$p_esti_no.'.html');

                //echo '$sendmail_flag : ' . $sendmail_flag;
                if ($sendmail_flag) {
                    $logger->log(iconv("UTF-8", "EUC-KR","        ## Send Mail Success : " . $adminInfo->E_MAIL . ' / ' . $adminInfo->USER_NAME . $NL));
                } else {
                    $logger->log(iconv("UTF-8", "EUC-KR","        ## Send Mail Fail"    . $NL));
                }

                $savedata = array();
                $savedata['ESTI_NO'         ] = "'" . $p_esti_no    . "'";
                $savedata['SEND_MAIL'       ] = "'" . ($sendmail_flag?'S':'F'). "'";
                $savedata['SEND_MAIL_DATE'  ] = "now()";

                if ( !($success=specSave('U',$savedata)) ) {
                    $logger->log(iconv("UTF-8", "EUC-KR","        ## tbl_calko_result SEND_MAIL Update Error" . $NL));
                }

            } else {
                $logger->log(iconv("UTF-8", "EUC-KR","        ## invalid Mail " . $NL));
            }
        } else {
            $logger->log(iconv("UTF-8", "EUC-KR",'        ## ERROR : ' . join($errors,',') . $NL));
        }
    }

    $logger->log(iconv("UTF-8", "EUC-KR",'## END - ' . $p_esti_no . ' / ' .$state . ' / ' .$country_code . $NL . $NL));
    $logger->log('');

}
$db->release();
$logger->log(iconv("UTF-8", "EUC-KR","## Information : totCnt / procCnt / mailSendCnt : " . $totCnt . ' / ' . $procCnt . ' / ' . $sendCnt . ' / ' . $NL));

$logger->log(iconv("UTF-8", "EUC-KR","## END  ## TP RECEIVE & SENDMAIL ------------------------ END" . $NL));
$logger->log($NL);
?>
<?
/*
//phpinfo();
//json_encode($arg);
$to     = 'softm@nate.com';
$to     = 'jihun.kim@tkek.co.kr';
$from   ="jihun.kim@tkek.co.kr";
$subject = ('the subjectxxxxxxxxx');
$message = 'hello';
$headers = 'From: ' . $from. "\r\n" .
    'Reply-To: ' . $to . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
//phpinfo();
$fromname = ('관리자');
$toname = ('받는사람');
function sendmail($to,$from,$fromname,$subject,$content){
   $add_header ="From: $fromname <$from> \n";
   $add_header .="Reply-To: $from \n";
   $add_header .="Content-Type: text/html;charset=EUC-KR";
   return mail ("$to","$subject",$content,$add_header);
}

$subject = $subject . '/' . $_SERVER['HTTP_HOST']  ;
echo $subject . '<BR>';
echo 'mail : ' . mail($to, $subject, $message, $headers). '<BR>';
echo 'sendmail : ' .sendmail($to,$from,$fromname,$subject,$message). '<BR>';
echo 'MailFunc : ' . MailFunc('utf-8',$toname,$to,$fromname,$from,$subject,$message,'1','3',$fInfo). '<BR>';
*/
}
?>