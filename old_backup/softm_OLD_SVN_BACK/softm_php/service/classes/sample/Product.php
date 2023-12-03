<?php
require_once HOME_DIR . '/inc/var_database.inc'      ; // 변수

class Product
{
    function Product() {
    }

    /*
    * 함수명: getWrite
    * 입력화면
    **/
    function getWrite($argus) {
        $mode         = $argus[mode];
        $p_prod_no    = $argus[p_prod_no];
        $p_pay_gb     = $argus[p_pay_gb];
        $p_direct_gb  = $argus[p_direct_gb];
        $p_pay_add_gb = $argus[p_pay_add_gb];

        //echo '$mode : ' . $mode . '<br>';
        //echo '$p_user_no : ' . $p_user_no . '<br>';
        $db = new DB();
        $db->getConnect();
        include UI_DIR . '/product_write.php';
        $db->release();
    }

    /*
    * 함수명: changeTradeState
    * TB_PRODUCT_TMP --> TB_PRODUCT 데이터 동기화
    **/
    function changeTradeState($argus) {
        $prodInfo = array();
        @extract($argus);
        /*
        $trade_state      = $argus[trade_state   ];
        $db         = $argus[db      ];
        $p_state_date = $argus[p_state_date];
        */
        $rtn = false;
        $errMsg = array();
        if ( !$argus[db] ) {
            $db = new DB();
            $db->getConnect();
        }

        $sql  = "UPDATE " . TB_PRODUCT_TMP. " "
              . " SET "
              . " MOD_DATE  = now(),"
              . " END_DATE  = " . ($end_date ?"'".$end_date."'":'now()') . ","
              . " TRADE_STATE   = '" . $trade_state . "' " // 'I' : 진행중, 'E' : 완료, 'C' : 취소
              . " WHERE PROD_NO = '" . $prod_no . "'";
        //echo 'sql : ' . $sql . ' /<BR>';
        if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();

        $sql  = "UPDATE " . TB_PRODUCT . " "
              . " SET "
              . " MOD_DATE  = now(),"
              . " END_DATE  = " . ($end_date ?"'".$end_date."'":'now()') . ","
              . " TRADE_STATE   = '" . $trade_state . "' " // 'I' : 진행중, 'E' : 완료, 'C' : 취소
              . " WHERE PROD_NO = '" . $prod_no . "'";
        //echo 'sql : ' . $sql . ' /<BR>';
        if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();

        if ( sizeof($errMsg) == 0 ) {
            echo 'SUCCESS';
            $rtn = true;
        } else {
            echo 'ERROR|' . join($errMsg);
            $rtn = false;
        }

        //echo '|sql : ' . $sql;
        //echo '|prod_no : ' . $prod_no . ' /<BR>';
        //var_dump($argus);

        if ( !$argus[db] ) {
            $db->release();
        }

        return $rtn;
    }
            //var_dump($argus);
            /*
            SELECT                                                                     
                   a.PROD_NO                         PROD_NO     ,                     
                   MAX(IFNULL(b.HISTORY_SEQ,0)) + 1  HISTORY_SEQ ,                     
                   a.USER_NO                         USER_NO     ,                     
                   a.USER_ID                         USER_ID     ,                     
                   a.USER_LEVEL                      USER_LEVEL  ,                     
                   CASE c.DIRECT_GB WHEN 'D' THEN  c.PERIOD                            
                                    WHEN 'A' THEN  '1'                                 
                   END                               USE_CNT     ,                     
                   now()                             RENEW_DATE  ,                     
                   DATE_ADD(IFNULL(MAX(b.EXPIRE_DATE),now()),INTERVAL c.PERIOD MONTH ),
                   CASE c.DIRECT_GB WHEN 'D' THEN  c.PERIOD                            
                                    WHEN 'A' THEN  '1'                                 
                   END                               PERIOD                            
            FROM hd_product_tmp a LEFT OUTER JOIN hd_product_history b                 
            ON a.PROD_NO = b.PROD_NO,                                                  
            hd_payment c                                                               
            WHERE a.PAY_NO IN( 1 )                                                     
            AND   a.PAY_NO = c.PAY_NO                                                  
            GROUP BY a.PROD_NO                                                         
            */
/*
            $sql  = "INSERT INTO " . TB_PRODUCT_HISTORY
                  . " ( "
                  . " PROD_NO     ,HISTORY_SEQ ,"
                  . " USER_NO     ,USER_ID     ,USER_LEVEL  ,"
                  . " USE_CNT     ,"
                  . " RENEW_DATE  ,EXPIRE_DATE ,PERIOD       "
                  . " ) "
                  . " SELECT"
                  . "        a.PROD_NO                         PROD_NO     ,                     "
                  . "        MAX(IFNULL(b.HISTORY_SEQ,0)) + 1  HISTORY_SEQ ,                     "
                  . "        a.USER_NO                         USER_NO     ,                     "
                  . "        a.USER_ID                         USER_ID     ,                     "
                  . "        a.USER_LEVEL                      USER_LEVEL  ,                     "
                  . "        CASE c.DIRECT_GB WHEN 'D' THEN  c.PERIOD                            "
                  . "                         WHEN 'A' THEN  '1'                                 "
                  . "        END                               USE_CNT     ,                     "
                  . "        now()                             RENEW_DATE  ,                     "
                  . "        DATE_ADD(IFNULL(MAX(b.EXPIRE_DATE),now()),INTERVAL c.PERIOD MONTH ),"
                  . "        CASE c.DIRECT_GB WHEN 'D' THEN  c.PERIOD                            "
                  . "                         WHEN 'A' THEN  '1'                                 "
                  . "        END                               PERIOD                            "
                  . " FROM " . TB_PRODUCT_TMP . " a LEFT OUTER JOIN " . TB_PRODUCT_HISTORY . " b"
                  . " ON a.PROD_NO = b.PROD_NO,"
                  . " " . TB_PAYMENT . " c"
                  . " WHERE a.PAY_NO = '" . $pay_no . "'"
                  . " AND   a.PAY_NO = c.PAY_NO"
                  . " GROUP BY a.PROD_NO";
*/
    function createHistory($argus) {
        $direct_gb      = $argus[direct_gb];
        $pay_gb         = $argus[pay_gb   ];
        $pay_no         = $argus[pay_no   ];
        $prod_no        = $argus[prod_no  ];
        $use_cnt        = (int)$argus[use_cnt  ];
        $period         = (int)$argus[period   ];
        $pay_no         =      $argus[pay_no   ];
        $db             = $argus[db]?$argus[db]:null;
        $extension      = $argus[extension]; // 연장 true/false

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
                  . " AND   a.STATE  = 'A'"
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
            if ( $prod_no ) {
                $sql  = "INSERT INTO " . TB_PRODUCT_HISTORY
                      . " ( "
                      . " PROD_NO     ,HISTORY_SEQ ," 
                      . " USER_NO     ,USER_ID     ,USER_LEVEL  ,"
                      . " USE_CNT     ,"
                      . " RENEW_DATE  ,EXPIRE_DATE ,PERIOD      ,"
                      . " PAY_NO      ,"
                      . " REG_DATE     "
                      . " ) ";
                if ( $extension ) {
                    $sql  .= " SELECT"
                          . "   a.USER_NO           ,a.USER_ID  ,a.USER_LEVEL  ,"
                          . "" . $period . "        ,"
                          . "   a.EXPIRE_DATE       , DATE_ADD(a.EXPIRE_DATE,INTERVAL " . $period . " MONTH ), " . $period . ","
                          . "   a.PAY_NO            ,"
                          . "   now()                "
                          . " FROM " . TB_PRODUCT_TMP . " a LEFT OUTER JOIN " . TB_PRODUCT_HISTORY . " b"
                          . " ON a.PROD_NO = b.PROD_NO"
                          . " WHERE a.PROD_NO = '" . $prod_no . "'"
                          . " GROUP BY a.PROD_NO";
                } else {
                    $sql  .= "SELECT"
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
                }
                $rtn = false;
                $errMsg = array();
                if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
                if ( sizeof($errMsg) == 0 ) {
                    $rtn = true;
                } else {
                    $rtn = false;
                }
            }
        }
        if ( !$argus[db] ) $db->release();
        return $rtn;
    }

    /*
    * 함수명: changeState
    * TB_PRODUCT_TMP --> TB_PRODUCT 데이터 동기화
    **/
    function tmpToLive($argus) {
        $db         = $argus[db]?$argus[db]:null;
        $prod_no    = $argus[prod_no]?$argus[prod_no]:null;
        if ( !$argus[db] ) {
            $db = new DB();
            $db->getConnect();
        }

        $rtn = false;
        $errMsg = array();

        $sql = "SELECT COUNT(*) FROM " . TB_PRODUCT . " WHERE PROD_NO = '" . $prod_no . "'";
        $cnt = $db->simpleSQLQuery ($sql);
        if ( $cnt == 0 ) {
            $sql  = "INSERT INTO " . TB_PRODUCT
                  . " SELECT "
                  . " * "
                  . " FROM " . TB_PRODUCT_TMP . ""
                  . " WHERE PROD_NO = '" . $prod_no . "'"
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
                  . " WHERE a.PROD_NO = '" . $prod_no . "'"
                  . " AND   a.STATE   = 'U'"
                  ;
            //echo 'sql : ' . $sql . ' /<BR>';
            if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
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