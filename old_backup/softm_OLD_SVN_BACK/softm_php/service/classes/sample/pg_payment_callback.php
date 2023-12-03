<?
define ("HOME_DIR" , realpath(dirname(dirname(dirname(__FILE__)))) );
define ('SERVICE'  , 'IEXEC' );
define ('BASE_DIR' , '..' );
define ('SERVICE_DIR', '../../service');

require_once HOME_DIR . '/inc/lib.inc';
require_once SERVICE_DIR . '/common/Session.php' ; // 변수
require_once SERVICE_DIR . '/front/Product.php' ; // 매물

require_once HOME_DIR . '/inc/var.inc' ;
require_once HOME_DIR . '/inc/class.inputfilter_clean.php' ;

if ( $p_pay_no ) {
    require_once HOME_DIR . '/inc/DB.php'           ; // DB
    $db = new DB();
    $db->getConnect();
    if ( $p_pg_confirm == 'Y' ) {
        $sql = " SELECT "
             . " PAY_NO     , "
             . " PROD_NO    , "
             . " DIRECT_GB  , "
             . " PAY_GB     , "
             . " PAY_ADD_GB , "
             . " PERIOD     , "
             . " STATE        "
             . " FROM " . TB_PAYMENT
             . " WHERE PAY_NO   = '" . $p_pay_no  . "'"
             . " AND   STATE    = 'R'"
             ;
    //echo 'sql : ' . $sql . ' /<BR>';
        $rs = $db->singleRowSQLQuery ($sql);
        if ( $rs[PAY_NO] ) {
            $errMsg = array();
            if ( $rs[PAY_GB] == 'D' ) { // 건결제
                //echo '$rs[PAY_ADD_GB] : ' . $rs[PAY_ADD_GB] . ' /<BR>';
                $p  = new Product();
                $argus = array();
                $sql  = "UPDATE " . TB_PRODUCT_TMP. " "
                      . " SET "
                      . " MOD_DATE     = now(),";
                if ( $rs[PAY_ADD_GB] == '1' ) { // 기본
                    $sql  .= " EXPIRE_DATE  = DATE_ADD(now(),INTERVAL " . $rs[PERIOD] . " MONTH ),";
                } else if ( $rs[PAY_ADD_GB] == '2' ) { // 추가
                    $sql  .= " EXPIRE_DATE  = DATE_ADD(IF(DATEDIFF(EXPIRE_DATE,now())>=0,EXPIRE_DATE,now()),INTERVAL " . $rs[PERIOD] . " MONTH ),";
                }
                $sql  .= " START_DATE   = now(),"
                      . " TRADE_STATE  = 'I'  ,"
                      . " STATE        = 'U'   "
                      . " WHERE PROD_NO = '" . $rs[PROD_NO] . "'";
                //echo 'sql : ' . $sql . ' /<BR>';
                if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();

                if ( $rs[PAY_ADD_GB] == '1' ) { // 기본
                    $sql  = " UPDATE " . TB_PAYMENT . " SET"
                          . " CONFIRM_DATE = now(),"
                          . " END_DATE     = DATE_ADD(now(),INTERVAL PERIOD MONTH ),"
                          . " REG_CNT      = AVAIL_CNT," // 건결제
                          . " STATE        = 'A'" // 승인
                          . " WHERE PAY_NO   = '" . $p_pay_no  . "'";
                    //echo 'sql : ' . $sql . ' /<BR>';
                    if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
                } else if ( $rs[PAY_ADD_GB] == '2' ) { // 연장
                    $argus[extension  ] = true           ;
                    $sql = " SELECT "
                         . " EXPIRE_DATE "
                         . " FROM " . TB_PRODUCT_TMP
                         . " WHERE PROD_NO  = '" . $rs[PROD_NO]  . "'"
                         ;
                    //echo 'sql : ' . $sql . ' /<BR>';
                    $up_expire_date = $db->simpleSQLQuery ($sql);
                    //echo 'up_expire_date : ' . $up_expire_date . ' /<BR>';
                    $sql  = " UPDATE " . TB_PAYMENT . " SET"
                          . " CONFIRM_DATE = now(),"
                          . " END_DATE     = '" . $up_expire_date . "',"
                          . " REG_CNT      = AVAIL_CNT," // 건결제
                          . " STATE        = 'A'" // 승인
                          . " WHERE PAY_NO   = '" . $p_pay_no  . "'";
                    //echo 'sql : ' . $sql . ' /<BR>';
                    if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
                }

                // 매물 히스토리 생성
                $argus[direct_gb  ] = $rs[DIRECT_GB ];
                $argus[pay_gb     ] = $rs[PAY_GB    ];
                $argus[pay_no     ] = $rs[PAY_NO    ];
                $argus[prod_no    ] = $rs[PROD_NO   ];
                $argus[period     ] = $rs[PERIOD    ];
                $argus[db         ] = $db           ;
                $p->createHistory($argus);

                // TMP->라이브 매물
                $argus2 = array();
                $argus2[prod_no ] = $rs[PROD_NO];
                $argus2[db      ] = $db         ;
                $p->tmpToLive($argus2);

                Session::setSession('tmp_pay_no'        ,$rs[PAY_NO ]   );
                Session::setSession('tmp_pay_prod_no'   ,$rs[PROD_NO]   );
                Session::setSession('tmp_pay_direct_gb' ,$rs[DIRECT_GB] );
                javascriptExec('opener.document.location="/member/menul.php"');
                echo '- 직결재 - 결제승인완료 -';
                echo '- 매물 - 히스토리생성 -';
            } else if ( $p_pay_gb == 'M' ) {
                $sql  = " UPDATE " . TB_PAYMENT . " SET"
                      . " CONFIRM_DATE = now(),"
                      . " END_DATE     = DATE_ADD(now(),INTERVAL PERIOD MONTH ),"
                      . " STATE        = 'A'" // 승인
                      . " WHERE PAY_NO   = '" . $p_pay_no  . "'";
                //echo 'sql : ' . $sql . ' /<BR>';
                if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();

                Session::setSession('tmp_pay_no'        ,$p_pay_no      );
                Session::setSession('tmp_pay_prod_no'   ,$p_prod_no     );
                Session::setSession('tmp_pay_direct_gb' ,$rs[DIRECT_GB] );
                javascriptExec('opener.document.location="/member/menul.php"');
                echo '- 월결재 - 결제승인완료 -';
            }

            if ( sizeof($errMsg) == 0 ) {
                echo 'SUCCESS';
                $rtn = true;
            } else {
                echo 'ERROR|' . join($errMsg);
                $rtn = false;
            }
            echo '- 승인 -';
        } else {
            echo '- 이미승인됨 -';
        }
    } else {
        echo '- 결제 에러 -';
    }
    $db->release();
} else {
}
?>