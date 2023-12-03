<?php
require_once HOME_DIR . '/inc/var_database.inc'      ; // 변수

class Payment
{
    function Payment() {
    }

    /*
    * 함수명: getList
    * 조회리스트
    **/
    function getList($argus) {
        extract($argus);
        //var_dump($argus);
        $db = new DB();
        $db->getConnect();
        //echo '$UI_DIR : ' . UI_DIR. '<br>';
        //echo '$s_gubun : ' . $s_gubun . '<br>';
        //echo '$s_search : ' . $s_search . '<br>';
        include UI_DIR . '/payment_list.php';
        $db->release();
    }

    /*
    * 함수명: stateProcess
    * 결제상태 변경 및 삭제 처리 실행
    **/
    function stateProcess($argus) {
        require_once SERVICE_DIR . '/admin/Product.php' ; // 매물

        $state      = $argus[state   ];
        $db         = $argus[db]?$argus[db]:null;
        $p_state_date = $argus[p_state_date];

        $payInfo = array();
        if ( is_array($argus[pay_nos]) ) {
            $payInfo = $argus[pay_nos];
        } else {
            $payInfo = split(',',$argus[pay_nos]);
        }

        $l = sizeof($payInfo);
        $pay_no_instr = '';
        foreach ($payInfo as $k => $v) {
            $pay_no_instr .= (($k==0)?'':',') . $v ;
        }

        if ( !$argus[db] ) {
            $db = new DB();
            $db->getConnect();
        }

        if ( $pay_no_instr ) {
            $errMsg = array();
            $p  = new Product();
            if ( $state == 'A' ) { // 승인

                // 건결제 매물 승인
                $sql = " SELECT "
                     . " PAY_NO         ,"
                     . " PAY_GB         ,"
                     . " PAY_ADD_GB     ,"
                     . " DIRECT_GB      ,"
                     . " PROD_NO        ,"
                     . " PERIOD         ,"
                     . " CONFIRM_DATE    "
                     . " FROM "
                     .  TB_PAYMENT
                      . " WHERE PAY_NO IN(" . $pay_no_instr. ")"
                      . " AND   STATE = 'R'" // '요청'
                      ;
                //echo 'sql : ' . $sql . ' /<BR>';
                $stmt = $db->multiRowSQLQuery ($sql);
                $prodInfo = array();
                $idx = 0;
                $tmp_pay_no_instr= '';

                while ( $rs = $db->multiRowFetch  ($stmt) ) {
                    $argus = array();
                    if ( $rs[PAY_GB] == 'D' ) { // 건결제
                        $sql  = "UPDATE " . TB_PRODUCT_TMP. " "
                              . " SET "
                              . " MOD_DATE     = now(),";
                        if ( $rs[PAY_ADD_GB] == '1' ) { // 기본
                            $sql .= " EXPIRE_DATE  = DATE_ADD(now(),INTERVAL " . $rs[PERIOD] . " MONTH ),";
                            $sql .= " START_DATE   = now(),";
                        } else if ( $rs[PAY_ADD_GB] == '2' ) { // 추가
                            $sql  .= " EXPIRE_DATE  = DATE_ADD(IF(DATEDIFF(EXPIRE_DATE,now())>=0,EXPIRE_DATE,now()),INTERVAL " . $rs[PERIOD] . " MONTH ),";
                        }
                        $sql .= " TRADE_STATE  = 'I'  ,"
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
                                  . " WHERE PAY_NO   = '" . $rs[PAY_NO]  . "'";
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
                                  . " WHERE PAY_NO   = '" . $rs[PAY_NO]  . "'";
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
                        $argus2[prod_no ] = $prodInfo;
                        $argus2[db      ] = $db      ;
                        $p->tmpToLive($argus2);
                    } else if ( $p_pay_gb == 'M' ) {
                        $sql  = " UPDATE " . TB_PAYMENT . " SET"
                              . " CONFIRM_DATE = now(),"
                              . " END_DATE     = DATE_ADD(now(),INTERVAL PERIOD MONTH ),"
                              . " STATE        = 'A'" // 승인
                              . " WHERE PAY_NO = '" . $p_pay_no  . "'";
                        //echo 'sql : ' . $sql . ' /<BR>';
                        if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
                    }
                }
            } else if ( $state == 'C' ) {
                // 건결제 매물 승인
                $sql = " SELECT "
                     . " PAY_NO         ,"
                     . " PAY_GB         ,"
                     . " PAY_ADD_GB     ,"
                     . " DIRECT_GB      ,"
                     . " PROD_NO        ,"
                     . " PERIOD         ,"
                     . " CONFIRM_DATE    "
                     . " FROM "
                     .  TB_PAYMENT
                      . " WHERE PAY_NO IN(" . $pay_no_instr. ")"
                      . " AND   STATE = 'R'" // '요청'
                      ;
                //echo 'sql : ' . $sql . ' /<BR>';
                $stmt = $db->multiRowSQLQuery ($sql);
                $prodInfo = array();
                $idx = 0;
                $tmp_pay_no_instr= '';
                while ( $rs = $db->multiRowFetch  ($stmt) ) {
                    $sql  = " UPDATE " . TB_PAYMENT . " SET"
                          . " CONFIRM_DATE  = null,"
                          . " END_DATE      = null,"
                          . " STATE         = 'C'  "
                          . " WHERE PAY_NO IN(" . $rs[PAY_NO] . ")";
                    if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
                }
            } else if ( $state == 'D' ) { // 삭제
                $sql = " SELECT "
                     . " DISTINCT PROD_NO "
                     . " FROM "
                     .  TB_PRODUCT_TMP
                     . " WHERE PAY_NO IN(" . $pay_no_instr. ")"
                     . " UNION "
                     . " SELECT "
                     . " PROD_NO "
                     . " FROM "
                     .  TB_PAYMENT
                     . " WHERE PAY_NO IN(" . $pay_no_instr. ")"
                        ;
                //echo 'sql : ' . $sql . ' /<BR>';
                $stmt = $db->multiRowSQLQuery ($sql);
                //$prodInfo = array();
                $prod_no_instr = '';
                $idx = 0;
                while ( $rs = $db->multiRowFetch  ($stmt) ) {
                    //$prodInfo [] = $rs[PROD_NO];
                    $prod_no_instr .= (($idx==0)?'':',') . $rs[PROD_NO];
                    $idx++;
                    $_fname = sprintf('%08d', $rs[PROD_NO]);
                    f_unlink(DATA_DIR . '/prod/images/ground_plan/' . $_fname . '.*',true);
                    f_unlink(DATA_DIR . '/prod/images/block_plan/' . $_fname . '.*',true);
                    f_unlink(DATA_DIR . '/prod/images/user/' . $_fname . '_??.*',true);
                }
                if ( $prod_no_instr ) {
                    $sql  = "DELETE FROM " . TB_COMMENT . " WHERE PROD_NO IN (" . $prod_no_instr . ")"; // 매물 이미지
                    if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();

                    $sql  = "DELETE FROM " . TB_IMAGE . " WHERE PROD_NO IN (" . $prod_no_instr . ")"; // 매물 이미지
                    if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();

                    $sql  = "DELETE FROM " . TB_PRODUCT_HISTORY . " WHERE PROD_NO IN (" . $prod_no_instr . ")"; // 매물 이력
                    if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();

                    $sql  = "DELETE FROM " . TB_PRODUCT     . " WHERE PROD_NO IN (" . $prod_no_instr . ")"; // 매물
                    if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();

                    $sql  = "DELETE FROM " . TB_PRODUCT_TMP . " WHERE PROD_NO IN (" . $prod_no_instr . ")"; // 매물 템프
                    if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
                }
                $sql  = " DELETE FROM " . TB_PAYMENT . " WHERE PAY_NO IN(" . $pay_no_instr. ")"; // 결제
                if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
            }
            if ( sizeof($errMsg) == 0 ) {
                echo 'SUCCESS';
                $rtn = true;
            } else {
                echo 'ERROR|' . join($errMsg);
                $rtn = false;
            }
            //echo '|'.$sql;
        }
        $db->release();
    }

    /*
    * 함수명: getWrite
    * 입력화면
    **/
    function getWrite($argus) {
        $mode       = $argus[mode];
        $p_pay_no   = $argus[p_pay_no];
        //echo '$mode : ' . $mode . '<br>';
        //echo '$p_pay_no : ' . $p_pay_no . '<br>';
        $db = new DB();
        $db->getConnect();
        include UI_DIR . '/payment_write.php';

        $db->release();
    }

    /*
    * 함수명: writeExec
    * 실행
    **/
    function writeExec($argus) {
        $mode  = $argus[mode];
        $db = new DB();
        $db->getConnect();
        extract($argus);
        if ( $mode == 'I' ) {
        } else if ( $mode == 'U' ) {
            $sql  = " UPDATE " . TB_PAYMENT . " SET"
                //. " PAY_NO      = '" . $pay_no      . "'  ,"

                //. " PAY_GB      = '" . $pay_gb      . "'  ,"
                //. " DIRECT_GB   = '" . $direct_gb   . "'  ,"
                //. " USER_NO     = '" . $user_no     . "'  ,"
                //. " USER_ID     = '" . $user_id     . "'  ,"
                //. " USER_LEVEL  = '" . $user_level  . "'  ,"
                //. " USER_NAME   = '" . $user_name   . "'  ,"
                //. " COMPANY_NAME= '" . $company_name. "'  ,"

                //. " PAY_METHOD  = '" . $pay_method  . "'  ,"
                //. " OPT_PREMIUM = '" . $opt_premium . "'  ,"
                //. " OPT_HOT     = '" . $opt_hot     . "'  ,"
                //. " OPT_SPEED   = '" . $opt_speed   . "'  ,"

                  . " AMOUNT      = '" . $amount      . "'  ,"
                  . " SURTAX      = '" . $surtax      . "'  ,"
                  . " PERIOD      = '" . $period      . "'  ,"
                  . " TOT_AMOUNT  = '" . $tot_amount  . "'  ,"
                  . " IN_NAME     = '" . $in_name     . "'  ,"

                  . " AVAIL_CNT   = '" . $avail_cnt   . "'  ,"
                  . " REG_CNT     = '" . $reg_cnt     . "'  ,"

                  . " PAY_DATE    = " . ($pay_date?"'" . $pay_date    . "'":"null") . " ,"
                  . " CONFIRM_DATE= " . ($confirm_date?"'" . $confirm_date . "'":"null") . " ,"
                //. " END_DATE    = " . ($end_date?"'" . $end_date  . "'":"null") . " ,"

                  . " CONTENT     = '" . $content     . "'  "

                //. " PROD_NO     = '" . $prod_no     . "'   "

                //. " STATE       = '" . $state       . "'   "

                  . " WHERE PAY_NO = '" . $pay_no . "'"
                    ;
            if ( !$db->simpleSQLExecute($sql) ) {
                echo 'ERROR|' . $db->getErrMsg();
            } else {
                echo 'SUCCESS';
            }
            echo '|sql : ' . $sql;
        }
        $db->release();
    }

    /*
    * 함수명: deleteExec
    * 삭제실행
    **/
    function deleteExec($argus) {
        $mode  = $argus[mode];
        $user_nos  = $argus[user_nos];
        $db = new DB();
        $db->getConnect();
        $l = sizeof($user_nos);
        $inStr = '';
        foreach ($user_nos as $k => $v) {
            $inStr .= (($k==0)?'':',') . $v ;
        }
        if ( $mode == 'D' && $inStr ) {
            $sql  = " DELETE FROM " . TB_MEMBER . ""
                  . " WHERE USER_NO IN(" . $inStr. ")"
                  . " AND   USER_LEVEL = 2";

            if ( !$db->simpleSQLExecute($sql) ) {
                echo 'ERROR|' . $db->getErrMsg();
            } else {
                echo 'SUCCESS';
            }
            /**/
            echo '|sql : ' . $sql;
        }
        $db->release();
    }
}

//MemberService::getList($s_user_id);
//echo 'ss';
?>