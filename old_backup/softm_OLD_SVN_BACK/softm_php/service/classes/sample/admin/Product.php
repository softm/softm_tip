<?php
require_once HOME_DIR . '/inc/var_database.inc' ; // 변수
require_once HOME_DIR . '/inc/file.inc'         ; // 파일

class Product
{
    function Product() {
    }

    /*
    * 함수명: getList
    * 조회리스트
    **/
    function getList($argus) {
        /*
        $s            = $argus[s            ];
        $s_user_level = $argus[s_user_level ];
        $s_direct_gb  = $argus[s_direct_gb  ];
        $s_prod_gb    = $argus[s_prod_gb    ];
        $s_trade_gb   = $argus[s_trade_gb   ];
        $s_state      = $argus[s_state      ];
        $s_gubun2     = $argus[s_gubun2     ];
        $s_search2_1  = $argus[s_search2_1  ];
        $s_search2_2  = $argus[s_search2_2  ];
        $s_directin_yn= $argus[s_directin_yn];
        $s_new_yn     = $argus[s_new_yn     ];
        $s_gubun      = $argus[s_gubun      ];
        $s_search     = $argus[s_search     ];

        $s_date_gubun   = $argus[s_date_gubun   ];
        $s_reg_date     = $argus[s_reg_date     ];
        $e_reg_date     = $argus[e_reg_date     ];
        $s_on_date_search   = $argus[s_on_date_search];
        $p_chg_state    = $argus[p_chg_state     ];
        */
        extract($argus);
        //var_dump($argus);
        $db = new DB();
        $db->getConnect();
        //echo '$UI_DIR : ' . UI_DIR. '<br>';
        //echo '$s_gubun : ' . $s_gubun . '<br>';
        //echo '$s_search : ' . $s_search . '<br>';
        include UI_DIR . '/product_list.php';
        $db->release();
    }

    /*
    * 함수명: getWrite
    * 입력화면
    **/
    function getWrite($argus) {
        $mode  = $argus[mode];
        $p_prod_no  = $argus[p_prod_no];
        $db = new DB();
        $db->getConnect();
        include UI_DIR . '/product_write.php';

        $db->release();
    }

    /*
    * 함수명: getWrite
    * 입력화면
    **/
    function writeExec($argus) {
        echo '미구현';
    }

    /*
    * 함수명: deleteExec
    * 삭제실행
    **/
    function deleteExec($argus) {
        echo '미구현';
    }

    /*
    * 함수명: getPaymentProdList
    * 히스토리리스트
    **/
    function getHistoryList($argus) {
        $s_prod_no      = $argus[s_prod_no  ];
        $db = new DB();
        $db->getConnect();
        //echo '$UI_DIR : ' . UI_DIR. '<br>';
        //echo '$s_gubun : ' . $s_gubun . '<br>';
        //echo '$s_search : ' . $s_search . '<br>';
        include UI_DIR . '/product_history_list.php';
        $db->release();
    }

    function createHistory($argus) {
        $direct_gb      = $argus[direct_gb];
        $pay_gb         = $argus[pay_gb   ];
        $pay_no         = $argus[pay_no   ];
        $prod_no        = $argus[prod_no  ];
        $use_cnt        = (int)$argus[use_cnt  ];
        $period         = (int)$argus[period   ];
        $pay_no         =      $argus[pay_no   ];
        $db             = $argus[db]?$argus[db]:null;

        $no_check_state =  $argus[no_check_state]?$argus[no_check_state]:false;
/*
        echo 'direct_gb : ' . $direct_gb . ' /<BR>';
        echo 'pay_gb    : ' . $pay_gb    . ' /<BR>';
        echo 'pay_no    : ' . $pay_no    . ' /<BR>';
        echo 'prod_no   : ' . $prod_no   . ' /<BR>';
        echo 'use_cnt   : ' . $use_cnt   . ' /<BR>';
        echo 'period    : ' . $period    . ' /<BR>';
        echo 'pay_no    : ' . $pay_no    . ' /<BR>';
*/
        if ( !$argus[db] ) {
            $db = new DB();
            $db->getConnect();
        }
        // '결제구분 : 월결제 : M, 건결제 : D'
        if ( $pay_gb == 'D' ) {
            $sql  = "INSERT INTO " . TB_PRODUCT_HISTORY
                  . " ( "
                  . " PROD_NO     ,HISTORY_SEQ ,"
                  . " USER_NO     ,USER_ID     ,USER_LEVEL  ,"
                  . " USE_CNT     ,"
                  . " RENEW_DATE  ,EXPIRE_DATE ,PERIOD      ,"
                  . " PAY_NO      ,"
                  . " REG_DATE     "
                  . " ) "
                  . " SELECT"
                  . "   a.PROD_NO PROD_NO   , MAX(IFNULL(b.HISTORY_SEQ,0)) + 1  HISTORY_SEQ,"
                  . "   a.USER_NO           ,a.USER_ID  ,a.USER_LEVEL  ,"
                  . "   a.PERIOD            ,"
                  . "   a.CONFIRM_DATE      , DATE_ADD(a.CONFIRM_DATE,INTERVAL a.PERIOD MONTH ), a.PERIOD,"
                  . "   a.PAY_NO            ,"
                  . "   now()                "
                  . " FROM " . TB_PAYMENT . " a LEFT OUTER JOIN " . TB_PRODUCT_HISTORY . " b"
                  . " ON a.PROD_NO = b.PROD_NO"
                  . " WHERE a.PAY_NO = '" . $pay_no . "'"
                  . ( !$no_check_state?" AND   a.STATE  = 'A'":"")
                  . " GROUP BY a.PROD_NO";
            //echo 'sql : ' . $sql . ' /<BR>';
            $rtn = false;
            $errMsg = array();
            if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
            if ( sizeof($errMsg) == 0 ) {
                $rtn = true;
            } else {
                $rtn = false;
            }
        } else if ( $pay_gb == 'M' ) {
            $sql  = "INSERT INTO " . TB_PRODUCT_HISTORY
                  . " ( "
                  . " PROD_NO     ,HISTORY_SEQ ," 
                  . " USER_NO     ,USER_ID     ,USER_LEVEL  ,"
                  . " USE_CNT     ,"
                  . " RENEW_DATE  ,EXPIRE_DATE ,PERIOD      ,"
                  . " PAY_NO      ,"
                  . " REG_DATE     "
                  . " ) "
                  . " SELECT"
                  . "   a.PROD_NO PROD_NO   , MAX(IFNULL(b.HISTORY_SEQ,0)) + 1  HISTORY_SEQ,"
                  . "   a.USER_NO           ,a.USER_ID  ,a.USER_LEVEL  ,"
                  . "" . $period . "        ,"
                  . "   now()               , DATE_ADD(now(),INTERVAL " . $period . " MONTH ), " . $period . ","
                  . "   a.PAY_NO            ,"
                  . "   now()                "
                  . " FROM " . TB_PAYMENT . " a LEFT OUTER JOIN " . TB_PRODUCT_HISTORY . " b"
                  . " ON a.PROD_NO = b.PROD_NO"
                  . " WHERE a.PAY_NO = '" . $pay_no . "'"
                  . " AND   a.STATE  = 'A'"
                  . " GROUP BY a.PROD_NO";
            $rtn = false;
            $errMsg = array();
            if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
            if ( sizeof($errMsg) == 0 ) {
                $rtn = true;
            } else {
                $rtn = false;
            }
        }
        if ( !$argus[db] ) $db->release();
        return $rtn;
    }

    /*
    * 함수명: deleteExec
    * 삭제실행
    **/
    function deleteHistoryExec($argus) {
        $p_prod_no      = $argus[p_prod_no];
        $history_seqs   = $argus[history_seqs];
        $db = new DB();
        $db->getConnect();
        $l = sizeof($history_seqs);
        $inStr = '';
        foreach ($history_seqs as $k => $v) {
            $inStr .= (($k==0)?'':',') . $v ;
        }
        if ( $inStr ) {
            $sql  = " DELETE FROM " . TB_PRODUCT_HISTORY . ""
                  . " WHERE PROD_NO = '" . $p_prod_no . "'"
                  . " AND   HISTORY_SEQ IN(" . $inStr. ")";

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

    /*
    * 함수명: changeState
    * Product 상태 변경
    **/
    function changeState($argus) {
        $trade_state= $argus[trade_state];
        $state      = $argus[state      ];
        $db         = $argus[db]?$argus[db]:null;
        $p_state_date = $argus[p_state_date];
        $start_date   = $p_state_date?$p_state_date:$argus[state_date ];
        $end_date     = $p_state_date?$p_state_date:$argus[end_date   ];
        $expire_date  = $p_state_date?$p_state_date:$argus[expire_date];
        $trade_state  = $argus[trade_state];

        if ( !$argus[db] ) {
            $db = new DB();
            $db->getConnect();
        }

        $prodInfo = array();
        if ( is_array($argus[prod_nos]) ) {
            $prodInfo = $argus[prod_nos];
        } else {
            $prodInfo = split(',',$argus[prod_nos]);
        }

        $l = sizeof($prodInfo);
        $inStr = '';
        foreach ($prodInfo as $k => $v) {
            $inStr .= (($k==0)?'':',') . $v ;
        }
        $prod_no_instr = $inStr;

        $rtn = false;
        $errMsg = array();

        if ( $prod_no_instr ) {

            if ( $state == 'D' ) {  // 삭제
                require_once HOME_DIR . '/inc/var.inc' ;
                $sql  = "DELETE FROM " . TB_PRODUCT     . " WHERE PROD_NO IN (" . $prod_no_instr . ")";
                if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();

                $sql  = "DELETE FROM " . TB_PRODUCT_HISTORY . " WHERE PROD_NO IN (" . $prod_no_instr . ")";
                if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();

                $sql  = "DELETE FROM " . TB_IMAGE . " WHERE PROD_NO IN (" . $prod_no_instr . ")";
                if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();

                $sql  = "DELETE FROM " . TB_PAYMENT . " WHERE PAY_GB = 'D' AND PROD_NO IN (" . $prod_no_instr . ")"; // 직거래 매물만 PROD_NO가 입력되어 있음 (결제구분 : 월결제 : M, 건결제 : D',")
                if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();

                $sql  = "DELETE FROM " . TB_PRODUCT_TMP . " WHERE PROD_NO IN (" . $prod_no_instr . ")";
                if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();

                $sql  = "DELETE FROM " . TB_COMMENT . " WHERE PROD_NO IN (" . $prod_no_instr . ")";
                if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();

                foreach ($prodInfo as $k => $v) {
                    $_fname = sprintf('%08d', $v);
                    f_unlink(DATA_DIR . '/prod/images/ground_plan/' . $_fname . '.*',true);
                    f_unlink(DATA_DIR . '/prod/images/block_plan/'  . $_fname . '.*',true);
                    f_unlink(DATA_DIR . '/prod/images/user/' . $_fname . '_??.*',true);
                }
            } else { // 'R' : 대기, 'U' : 사용, 'X' : 만료
                $sql  = "UPDATE " . TB_PRODUCT_TMP. " "
                      . " SET ";
                $sql  .= " MOD_DATE = now(),";
                if ( $state == 'R' ) { // 대기
                } else if ( $state == 'U' ) { // 사용
                    $sql  .= " EXPIRE_DATE  = " . ($expire_date ?"'".$expire_date."'":'now()') . ",";
                } else if ( $state == 'X' ) { // 만료
                    $sql  .= " EXPIRE_DATE  = " . ($expire_date ?"'".$expire_date."'":'now()') . ",";
                }
                if ( $start_date  ) $sql  .= " START_DATE   = '" . $start_date  . "',";
                if ( $end_date    ) $sql  .= " END_DATE     = '" . $end_date    . "',";
                if ( $trade_state ) $sql  .= " TRADE_STATE  = '" . $trade_state . "',";
                $sql  .= " STATE         = '" . $state           . "' "
                      . " WHERE PROD_NO IN (" . $prod_no_instr . ")";
                if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
                if (  $state == 'U' ) {
                    // TMP->라이브 매물
                    $argus2 = array();
                    $argus2[prod_nos   ] = $prodInfo;
                    $argus2[db         ] = $db      ;
                    $this->tmpToLive($argus2);
                } else {
                    $sql  = "DELETE FROM " . TB_PRODUCT     . " WHERE PROD_NO IN (" . $prod_no_instr . ")";
                    if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
                }
            }
        }
        if ( sizeof($errMsg) == 0 ) {
            echo 'SUCCESS|';
            $rtn = true;
        } else {
            echo 'ERROR|' . join($errMsg);
            $rtn = false;
        }

        //echo '|sql : ' . $sql;
        //echo '|prod_no_instr : ' . $prod_no_instr . ' /<BR>';
        if ( !$argus[db] ) {
            $db->release();
        }

        return $rtn;
    }


    /*
    * 함수명: tmpToLive
    * TB_PRODUCT_TMP --> TB_PRODUCT 데이터 동기화
    **/
    function tmpToLive($argus) {
        $db         = $argus[db]?$argus[db]:null;
        if ( !$argus[db] ) {
            $db = new DB();
            $db->getConnect();
        }

        $prodInfo = array();
        if ( is_array($argus[prod_nos]) ) {
            $prodInfo = $argus[prod_nos];
        } else {
            $prodInfo = split(',',$argus[prod_nos]);
        }
        $l = sizeof($prodInfo);

        $rtn = false;
        $errMsg = array();
        if ( $l > 0 ) {
            foreach ($prodInfo as $k => $v) {
                $sql = "SELECT COUNT(*) FROM " . TB_PRODUCT . " WHERE PROD_NO = '" . $v . "'";
                $cnt = $db->simpleSQLQuery ($sql);
                if ( $cnt == 0 ) {
                    $sql  = "INSERT INTO " . TB_PRODUCT
                          . " SELECT "
                          . " * "
                          . " FROM " . TB_PRODUCT_TMP . ""
                          . " WHERE PROD_NO = '" . $v . "'"
                          . " AND   STATE   = 'U'"
                          ;
                    //echo 'sql : ' . $sql . ' /<BR>';
                    if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
                } else {
                    $sql  = "UPDATE " . TB_PRODUCT . " a"
                          . " INNER JOIN " . TB_PRODUCT_TMP . " b"
                          . " ON a.PROD_NO = b.PROD_NO"
                          . " SET "
                        //. " a.PROD_NO          = b.PROD_NO         , "
                          . " a.DIRECT_GB        = b.DIRECT_GB       , "
                          . " a.PROD_GB          = b.PROD_GB         , "
                          . " a.TRADE_GB         = b.TRADE_GB        , "
                          . " a.USER_NO          = b.USER_NO         , "
                          . " a.USER_ID          = b.USER_ID         , "
                          . " a.USER_LEVEL       = b.USER_LEVEL      , "
                          . " a.USER_NAME        = b.USER_NAME       , "
                          . " a.COMPANY_NAME     = b.COMPANY_NAME    , "
                          . " a.HEAD_TITLE       = b.HEAD_TITLE      , "
                          . " a.TEL1             = b.TEL1            , "
                          . " a.TEL2             = b.TEL2            , "
                          . " a.ADDRESS1         = b.ADDRESS1        , "
                          . " a.ADDRESS2         = b.ADDRESS2        , "
                          . " a.POST_NO          = b.POST_NO         , "
                          . " a.X1               = b.X1              , "
                          . " a.Y1               = b.Y1              , "
                          . " a.X2               = b.X2              , "
                          . " a.Y2               = b.Y2              , "
                          . " a.COST1            = b.COST1           , "
                          . " a.COST2            = b.COST2           , "
                          . " a.COST3            = b.COST3           , "
                          . " a.COST4            = b.COST4           , "
                          . " a.DIRECTIN_YN      = b.DIRECTIN_YN     , "
                          . " a.IN_DATE          = b.IN_DATE         , "
                          . " a.ROOM_CNT1        = b.ROOM_CNT1       , "
                          . " a.ROOM_CNT2        = b.ROOM_CNT2       , "
                          . " a.SCALE1           = b.SCALE1          , "
                          . " a.SCALE2           = b.SCALE2          , "
                          . " a.BUILD_YEAR       = b.BUILD_YEAR      , "
                          . " a.NEW_YN           = b.NEW_YN          , "
                          . " a.FLOOR1           = b.FLOOR1          , "
                          . " a.FLOOR2           = b.FLOOR2          , "
                          . " a.HOUSE_NUM        = b.HOUSE_NUM       , "
                          . " a.DIRECTION        = b.DIRECTION       , "
                          . " a.BUILDING_COMPANY = b.BUILDING_COMPANY, "
                          . " a.IN_YEAR          = b.IN_YEAR         , "
                          . " a.HOUSEHOLD_NUM1   = b.HOUSEHOLD_NUM1  , "
                          . " a.HOUSEHOLD_NUM2   = b.HOUSEHOLD_NUM2  , "
                          . " a.HEATING_METHOD   = b.HEATING_METHOD  , "
                          . " a.PARKING_CNT1     = b.PARKING_CNT1    , "
                          . " a.FEATURE          = b.FEATURE         , "
                          . " a.FACILITIES       = b.FACILITIES      , "
                          . " a.BLOCK_PLAN       = b.BLOCK_PLAN      , "
                          . " a.GROUND_PLAN      = b.GROUND_PLAN     , "
                          . " a.OPT_PREMIUM      = b.OPT_PREMIUM     , "
                          . " a.OPT_HOT          = b.OPT_HOT         , "
                          . " a.OPT_SPEED        = b.OPT_SPEED       , "
                          . " a.READ_CNT         = b.READ_CNT        , "

                          . " a.REG_DATE         = b.REG_DATE        , "
                          . " a.MOD_DATE         = b.MOD_DATE        , "
                          . " a.EXPIRE_DATE      = b.EXPIRE_DATE     , "
                          . " a.START_DATE       = b.START_DATE      , "
                          . " a.END_DATE         = b.END_DATE        , "
                          . " a.PAY_NO           = b.PAY_NO          , "
                          . " a.TRADE_STATE      = b.TRADE_STATE     , "
                          . " a.STATE            = b.STATE             "
                          . " WHERE a.PROD_NO = '" . $v . "'"
                          . " AND   a.STATE   = 'U'"
                          ;
                    //echo 'sql : ' . $sql . ' /<BR>';
                    if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
                }
            }
        }
        if ( !$argus[db] ) {
            $db->release();
        }
        return $rtn;
    }
}
//MemberService::getList($s_user_id);
//echo 'ss';
?>