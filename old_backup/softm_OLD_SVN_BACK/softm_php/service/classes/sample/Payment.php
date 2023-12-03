<?php
require      HOME_DIR . '/inc/var.inc'              ; // 변수
require_once HOME_DIR . '/inc/var_database.inc' ; // 디비 변수
require_once SERVICE_DIR . '/common/Session.php' ; // 변수

class Payment
{
    function Payment() {
    }

    /*
    * 함수명: checkPayment
    * 중개인매물 등록 경우의수 검사
    **/
    function checkPayment($argus) {

        $memInfor = Session::getSession();

        $p_direct_gb = $argus[p_direct_gb]; // 직거래구분 : 직거래 매물 : D, 중개인 매물 : A

      //echo '$s_search : ' . $s_search . '<br>';
      //echo 'SITE : ' . SERVICE. '<br>';
      //include UI_DIR . '/Common_list.php';

        session_cache_limiter('none');
        //$host = 'http://' . getenv('HTTP_HOST');
        //$host = 'http://gears.kr';
        //echo $HTTP_REFERER;
        //if ($host != substr(getenv('HTTP_REFERER'), 0, strlen($host))){
        //    header("HTTP/4.0 404 Not Found");
        //} else {
            header("content-type: application/xml");
            //header("content-type: text/xml");

            //header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            //header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            //header("Cache-Control: no-store, no-cache, must-revalidate");
            //header("Cache-Control: post-check=0, pre-check=0", false);
            //header("Pragma: no-cache");

            $db = new DB();
            $db->getConnect();

            $xw = new xmlWriter();

            $xw->openMemory();

            $xw->startElement('payment');
            if ( $p_direct_gb == 'A' ) { // 중개인매물
                $sql = "SELECT "
                     . " MIN(PAY_NO)"
                     . " FROM " . TB_PAYMENT
                     . " WHERE USER_NO      = '" . $memInfor[user_no] . "'"
                     . " AND   PAY_GB       = 'M'"  // 월결제
                     . " AND   STATE        = 'A'"  // 요청 : R, 승인 : A, 취소 : C
                     . " AND   END_DATE > now()" // 승인일로부터 +1달 --> 만료일이 현제일보다 큰 자료중에
                     . " AND   AVAIL_CNT > REG_CNT"
                        ;
                //echo 'sql : ' . $sql;
                $pay_no = $db->simpleSQLQuery($sql);

                $sql = "SELECT "
                     . " PAY_NO                         PAY_NO      ,   "
                     . " PAY_ADD_GB                     PAY_ADD_GB  ,   "
                     . " PAY_DATE                       PAY_DATE    ,   "
                     . " CONFIRM_DATE                   START_DATE  ,   "
                     . " END_DATE                       END_DATE    ,   "
                     . " DATEDIFF(END_DATE,now())       REMIND_DAY  ,   "
                     . " AVAIL_CNT                      AVAIL_CNT   ,   "
                     . " REG_CNT                        REG_CNT         "
                     . " FROM " . TB_PAYMENT
                     . " WHERE PAY_NO   = '" . $pay_no . "'"
                        ;

// 추가 결제의 경우 START_DATE는 기본결제건의 일자와 동일하게 입력되어야함

                //echo 'sql : ' . $sql;
                $rs = $db->singleRowSQLQuery($sql);
                if ($rs[PAY_NO    ]) {
                    // PAY_GB : 월결제 : M, 건결제 : D'
                    $xw->writeAttribute('info'      , 'SUCCESS'   );
                    //if ( $rs[AVAIL_CNT] > $rs[REG_CNT] ) {
                    //    $xw->writeAttribute('info'      , 'SUCCESS'   );
                    //} else {
                    //    $xw->writeAttribute('info'      , 'NOT_ENOUGH');
                    //}
                    $xw->writeAttribute('pay_gb'    , 'M'            );
                    $xw->writeAttribute('pay_no'    , $rs[PAY_NO    ]);
                    $xw->writeAttribute('pay_add_gb', $rs[PAY_ADD_GB]);
                    $xw->writeAttribute('pay_date'  , $rs[PAY_DATE  ]);
                    $xw->writeAttribute('start_date', $rs[START_DATE]);
                    $xw->writeAttribute('end_date'  , $rs[END_DATE  ]);
                    $xw->writeAttribute('remind_day', $rs[REMIND_DAY]);
                    $xw->writeAttribute('state'     , $rs[STATE     ]);
                    $xw->writeAttribute('avail_cnt' , $rs[AVAIL_CNT ]);
                    $xw->writeAttribute('reg_cnt'   , $rs[REG_CNT   ]);
                } else {
                    $sql = "SELECT "
                         . " MIN(PAY_NO) "
                         . " FROM " . TB_PAYMENT
                         . " WHERE USER_NO      = '" . $memInfor[user_no] . "'"
                         . " AND   PAY_GB       = 'M'"  // 월결제
                         . " AND   STATE        = 'R'"  // 요청 : R, 승인 : A, 취소 : C
                            ;
                    //echo 'sql : ' . $sql;
                    $pay_no = $db->simpleSQLQuery($sql);

                    $sql = "SELECT "
                         . " PAY_NO     ,"
                         . " PAY_ADD_GB ,"
                         . " PAY_DATE   ,"
                         . " STATE       "
                         . " FROM " . TB_PAYMENT
                         . " WHERE PAY_NO   = '" . $pay_no . "'"
                            ;
                    //echo 'sql : ' . $sql;
                    $rs = $db->singleRowSQLQuery($sql);
                    if ( $rs[PAY_NO] ) {
                        $xw->writeAttribute('info'      , 'REQUEST'      );
                        $xw->writeAttribute('pay_gb'    , 'M'            );
                        $xw->writeAttribute('pay_no'    , $rs[PAY_NO    ]);
                        $xw->writeAttribute('pay_add_gb', $rs[PAY_ADD_GB]);
                        $xw->writeAttribute('pay_date'  , $rs[PAY_DATE  ]);
                        $xw->writeAttribute('state'     , $rs[STATE     ]);
                    } else {
                        $sql = "SELECT "
                             . " COUNT(*)"
                             . " FROM " . TB_PAYMENT
                             . " WHERE USER_NO      = '" . $memInfor[user_no] . "'"
                             . " AND   PAY_GB       = 'M'"  // 월결제
                             . " AND   STATE        = 'A'"  // 요청 : R, 승인 : A, 취소 : C
                             . " AND   PAY_ADD_GB   = '1'"  // 기본결제
                             . " AND   END_DATE > now()" // 승인일로부터 +1달 --> 만료일이 현제일보다 큰 자료중에
                                ;
                        //echo 'sql : ' . $sql;
                        $payCnt = $db->simpleSQLQuery($sql);
                        if ( $payCnt == 0 ) {
                            $xw->writeAttribute('pay_add_gb'    , '1');
                        } else {
                            $xw->writeAttribute('pay_add_gb'    , '2');
                        }
                        $xw->writeAttribute('info'      , 'NOT_EXIST'    );
                        $xw->writeAttribute('pay_gb'    , 'M'            );
                        $xw->writeAttribute('pay_no'    , ''             );
                        $xw->writeAttribute('pay_date'  , ''             );
                        $xw->writeAttribute('state'     , ''             );
                    }
                    $xw->writeAttribute('start_date', '');
                    $xw->writeAttribute('end_date'  , '');
                    $xw->writeAttribute('remind_day', '0');
                    $xw->writeAttribute('avail_cnt' , '0');
                    $xw->writeAttribute('reg_cnt'   , '0');

                }
            } else if ( $p_direct_gb == 'D' ) { // 직거래 매물
/*
                $sql = "SELECT "
                     . " COUNT(*)"
                     . " FROM " . TB_PAYMENT
                     . " WHERE USER_NO      = '" . $memInfor[user_no] . "'"
                     . " AND   PAY_GB       = 'D'"  // 직거래
                     . " AND   STATE        = 'A'"  // 요청 : R, 승인 : A, 취소 : C
                     . " AND   PAY_ADD_GB   = '1'"  // 기본결제
                     . " AND   END_DATE > now()" // 승인일로부터 +1달 --> 만료일이 현제일보다 큰 자료중에
                        ;
                $cnt = $db->simpleSQLQuery($sql);
                $xw->writeAttribute('info'      , 'SUCCESS'   );
                if ( $cnt == 0 ) {
                    $xw->writeAttribute('pay_add_gb'    , '1');
                } else {
                    $xw->writeAttribute('pay_add_gb'    , '2');
                }
*/
            }

            $xw->endElement();
            $xw->endDtd();
            print $xw->outputMemory(true);

            $db->release();
        //}
    }

    /*
    * 함수명: getWrite
    * 입력화면
    **/
    function monthlyPaymentExec($argus) {
        @extract($argus);
        $memInfor = Session::getSession();
        $p_user_no      = $memInfor[user_no     ];
        $p_user_id      = $memInfor[user_id     ];
        $p_user_level   = $memInfor[user_level  ];
        $p_user_name    = $memInfor[user_name   ];
        $p_company_name = $memInfor[company_name];

        $opt_premium    = $opt_premium  =='Y'   ?$opt_premium   :'N';
        $opt_hot        = $opt_hot      =='Y'   ?$opt_hot       :'N';
        $opt_speed      = $opt_speed    =='Y'   ?$opt_speed     :'N';
        $base_amount = 0;
        $avail_cnt   = 0;
        if ( $pay_add_gb == '1' ) {
            $base_amount    = AGENT_MONTH_BASE_AMOUNT;
            $avail_cnt      = AGENT_REGISTABLE_BASE_COUNT;
        } else if ( $pay_add_gb == '2' ) {
            $base_amount    = AGENT_MONTH_EXTENSION_AMOUNT;
            $avail_cnt      = AGENT_REGISTABLE_EXTENSION_COUNT;
        }

        $period         = (int)$period;
        $amount         = (int)$base_amount * $period;
        $surtax         = (int)$amount * 0.1;
        $tot_amount     = (int)$amount + $surtax;


        $db = new DB();
        $db->getConnect();
        $errMsg = array();
        $sql  = "INSERT INTO " . TB_PAYMENT
              . " ( "
              //. " PAY_NO      ,"
              . " PAY_GB      ,DIRECT_GB   ,PAY_ADD_GB  ,                          "
              . " USER_NO     ,USER_ID     ,USER_LEVEL  ,USER_NAME   ,COMPANY_NAME,"
              . " PAY_METHOD  ,                                                    "
              . " OPT_PREMIUM ,OPT_HOT     ,OPT_SPEED   ,                          "
              . " AMOUNT      ,SURTAX      ,PERIOD      ,TOT_AMOUNT  ,             "
              . " IN_NAME     ,                                                    "
              . " AVAIL_CNT   ,REG_CNT     ,                                       "
              . " PAY_DATE    ,CONFIRM_DATE,                                       "
              . " CONTENT     ,PROD_NO     ,                                       "
              . " STATE                                                            "
              . " ) VALUES ("
              . " '" . $pay_gb          . "','" . $direct_gb            . "','" . $pay_add_gb           . "',"
              . " '" . $p_user_no       . "','" . strtolower($p_user_id). "','" . $p_user_level . "','" . $p_user_name  . "','" . $p_company_name . "',"
              . " '" . $pay_method      . "',"
              . " '" . $opt_premium     . "','" . $opt_hot              . "','" . $opt_speed    . "',"
              . " '" . $amount          . "','" . $surtax               . "','" . $period       . "','" . $tot_amount       . "',"
              . " '" . $in_name         . "',"
              . " '" . ( $avail_cnt * $period ). "',0,"
              . " now() ,null,"
              . " '',0,"
              . " 'R'"  // 요청 : R, 승인 : A, 취소 : C
              . " )";

        if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
       //echo 'sql : ' . $sql . ' /<BR>';
        if ( sizeof($errMsg) > 0 ) {
            $errMsg = array_unique ( $errMsg );
            $errMsgStr = join ( '\n', $errMsg);
            $newPayNo = '';
            $newProdNo = '';
            echo 'ERROR|결제 데이터처리중 에러가 발생하였습니다. [' . $errMsgStr . ']|' . $newProdNo . '|' . $newPayNo;
        } else {
            $newPayNo = $db->getInsertId();
            $newProdNo = '';
            echo 'SUCCESS|결제 데이터처리가 정상적으로 실행되었습니다.|' . $newProdNo . '|' . $newPayNo;
        }
        echo '|sql : ' . $sql;
        $db->release();
    }
}

//MemberService::getList($s_user_id);
//echo 'ss';
?>