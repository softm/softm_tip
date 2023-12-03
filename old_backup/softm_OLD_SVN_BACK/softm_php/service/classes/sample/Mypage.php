<?php
require_once HOME_DIR . '/inc/var_database.inc'     ; // 변수

class Mypage
{
    function Mypage() {
    }

    /*
    * 함수명: getProductRegList
    * 등록매물관리-조회
    **/
    function getProductRegList($argus) {
        $s              = $argus[s            ];
        $s_user_level   = $argus[s_user_level ];
        $s_gubun        = $argus[s_gubun      ];
        $s_search       = $argus[s_search     ];
        //var_dump($argus);
        $db = new DB();
        $db->getConnect();
        include UI_DIR . '/product_reg_list.php';
        $db->release();
    }

    /*
    * 함수명: getPaymentList
    * 결제내역조회-조회
    **/
    function getPaymentList($argus) {
/*
        $s              = $argus[s            ];
        $s_user_level   = $argus[s_user_level ];
        $s_gubun        = $argus[s_gubun      ];
        $s_search       = $argus[s_search     ];
*/
        @extract($argus);
        //var_dump($argus);
        $db = new DB();
        $db->getConnect();
        include UI_DIR . '/payment_list.php';
        $db->release();
    }

    /*
    * 함수명: getProductInterestList
    * 관심매물관리-조회
    **/
    function getProductInterestList($argus) {
/*
        $s              = $argus[s            ];
        $s_user_level   = $argus[s_user_level ];
        $s_gubun        = $argus[s_gubun      ];
        $s_search       = $argus[s_search     ];
*/
        @extract($argus);
        //var_dump($argus);
        $db = new DB();
        $db->getConnect();
        include UI_DIR . '/product_interest_list.php';
        $db->release();
    }

    /*
    * 함수명: getDealerProductExtension
    * 중개매물 연장
    **/
    function getDealerProductExtension($argus) {
/*
        $s              = $argus[s            ];
        $s_user_level   = $argus[s_user_level ];
        $s_gubun        = $argus[s_gubun      ];
        $s_search       = $argus[s_search     ];
*/
        @extract($argus);
        //var_dump($argus);
        $db = new DB();
        $db->getConnect();
        include UI_DIR . '/dealer_extension_payment_01.php';
        $db->release();
    }

    /*
    * 함수명: getDealerProductExtension
    * 중개매물 연장
    **/
    function execDealerProductExtension($argus) {
/*
        $s              = $argus[s            ];
        $s_user_level   = $argus[s_user_level ];
        $s_gubun        = $argus[s_gubun      ];
        $s_search       = $argus[s_search     ];
*/
        require HOME_DIR . '/inc/var.inc'              ; // 변수
        @extract($argus);
        //var_dump($argus);
        $db = new DB();
        $db->getConnect();
        $memInfor = Session::getSession();
        $errMsg = array();

        $sql  = " UPDATE " . TB_PAYMENT . " SET"
              . " REG_CNT = REG_CNT + " . $use_cnt . ""
              . " WHERE PAY_NO = '" . $pay_no. "'";
        //echo 'sql : ' . $sql . ' /<BR>';
        if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();


        $sql  = "UPDATE " . TB_PRODUCT_TMP
              . " SET   "
              . " EXPIRE_DATE   = DATE_ADD(EXPIRE_DATE,INTERVAL " . $period . " MONTH ),"
              . " MOD_DATE      = now()                       "
              . " WHERE PROD_NO = '" . $prod_no  . "'"
              . " AND   USER_NO = '" . $memInfor[user_no]. "'";
        if ( !$db->simpleSQLExecute($sql) ) {
            require_once SERVICE_DIR . '/front/Product.php' ; // 매물
            // 매물 히스토리 생성
            $p  = new Product();
            $argus = array();
            $argus[extension  ] = true      ;
            $argus[direct_gb  ] = $direct_gb;
            $argus[pay_gb     ] = $pay_gb   ;
            $argus[prod_no    ] = $prod_no  ;
            $argus[pay_no     ] = $pay_no   ;
            $argus[period     ] = $period   ;
            $argus[use_cnt    ] = $use_cnt  ;
            $argus[db         ] = $db       ;
            $p->createHistory($argus);
        }

        if ( sizeof($errMsg) == 0 ) {
            echo 'SUCCESS';
            $rtn = true;
        } else {
            echo 'ERROR|' . join($errMsg);
            $rtn = false;
        }
        echo '|sql : ' . $sql;

        $db->release();
    }

    /*
    * 함수명: getDirectProductExtension
    * 직거래 연장
    **/
    function getDirectProductExtension($argus) {
/*
        $s              = $argus[s            ];
        $s_user_level   = $argus[s_user_level ];
        $s_gubun        = $argus[s_gubun      ];
        $s_search       = $argus[s_search     ];
*/
        @extract($argus);
        //var_dump($argus);
        $db = new DB();
        $db->getConnect();
        include UI_DIR . '/direct_extension_payment_01.php';
        $db->release();
    }

    /*
    * 함수명: execDirectProductExtension
    * 직거래 연장
    **/
    function execDirectProductExtension($argus) {
        @extract($argus);
        if ( $prod_no ) {
            //var_dump($argus);
            $db = new DB();
            $db->getConnect();
            $memInfor = Session::getSession();
            $errMsg = array();
            require HOME_DIR . '/inc/var.inc'              ; // 변수

            $p_user_no      = $memInfor[user_no     ];
            $p_user_id      = $memInfor[user_id     ];
            $p_user_level   = $memInfor[user_level  ];
            $p_company_name = $memInfor[company_name];

            // PAYMENT 관련
            $trade_gb       = $trade_gb     ;
            $pay_method     = $pay_method   ;
            $pay_gb         = $pay_gb       ;
            $direct_gb      = $direct_gb    ;
            $pay_add_gb     = $pay_add_gb   ;
            
            $opt_premium    = $opt_premium  =='Y'   ?$opt_premium   :'N';
            $opt_hot        = $opt_hot      =='Y'   ?$opt_hot       :'N';
            $opt_speed      = $opt_speed    =='Y'   ?$opt_speed     :'N';

            $base_amount    = 0;

            if ( $direct_gb == 'D' ) { // 직거래
                if ( $memInfor[user_level] == 1 ) {
                    if ( $pay_add_gb == '1' ) {
                        $base_amount = DIRECT_BASE_AMOUNT;
                    } else if ( $pay_add_gb == '2' ) {
                        $base_amount = DIRECT_EXTENSION_AMOUNT;
                    }
                } else if ( $memInfor[user_level] == 2 ) {
                    if ( $pay_add_gb == '1' ) {
                        $base_amount = AGENT_BASE_AMOUNT;
                    } else if ( $pay_add_gb == '2' ) {
                        $base_amount = AGENT_EXTENSION_AMOUNT;
                    }
                }
            } else if ( $direct_gb == 'A' ) { // 중개인
                if ( $pay_add_gb == '1' ) {
                    $base_amount = AGENT_MONTH_BASE_AMOUNT;
                } else if ( $pay_add_gb == '2' ) {
                    $base_amount = AGENT_MONTH_EXTENSION_AMOUNT;
                }
            }
            //echo '$base_amount : ' . $base_amount;
            $opt_amount = 0;
            $opt_amount += $opt_premium =='Y'?(int)OPT_PREMIUM_AMOUNT:0; // 프리미엄매물가격
            $opt_amount += $opt_hot     =='Y'?(int)OPT_HOT_AMOUNT    :0; // 핫매물가격      
            $opt_amount += $opt_speed   =='Y'?(int)OPT_SPEED_AMOUNT  :0; // 스피드매물가격  

            $period         = (int)$period;
            $amount         = ((int)$base_amount + (int)$opt_amount) * $period;
            $surtax         = (int)$amount * 0.1;
            $tot_amount     = (int)$amount + $surtax;

            $errMsgStr = '';
            $errMsg = array();

            if ( $direct_gb == 'D' ) {
                $sql  = "INSERT INTO " . TB_PAYMENT
                      . " ( "
                      //. " PAY_NO      ,                                       "
                      . " PAY_GB      ,DIRECT_GB   ,PAY_ADD_GB  ,                          "
                      . " USER_NO     ,USER_ID     ,USER_LEVEL  ,USER_NAME   ,COMPANY_NAME,"
                      . " PAY_METHOD  ,                                                    "
                      . " OPT_PREMIUM ,OPT_HOT     ,OPT_SPEED   ,                          "
                      . " AMOUNT      ,SURTAX      ,PERIOD      ,TOT_AMOUNT  ,             "
                      . " IN_NAME     ,                                                    "
                      . " AVAIL_CNT   ,REG_CNT     ,                                       "
                      . " PAY_DATE    ,CONFIRM_DATE,END_DATE    ,                          "
                      . " CONTENT     ,                                                    "
                      . " PROD_NO     ,                                                    "
                      . " STATE                                                            "
                      . " ) VALUES ("
                      . " '" . $pay_gb          . "','" . $direct_gb            . "','" . $pay_add_gb   . "',"
                      . " '" . $p_user_no       . "','" . strtolower($p_user_id). "','" . $p_user_level . "','" . $p_user_name  . "','" . $p_company_name . "',"
                      . " '" . $pay_method      . "',"
                      . " '" . $opt_premium     . "','" . $opt_hot              . "','" . $opt_speed    . "',"
                      . " '" . $amount          . "','" . $surtax               . "','" . $period       . "','" . $tot_amount       . "',"
                      . " '" . $in_name         . "',"
                      . " " . $period . ",0,"
                      . " now() ,null,null,"
                      . " '',"
                      . " '" . $prod_no         . "',"
                      . " 'R'"  // 요청 : R, 승인 : A, 취소 : C
                      . " )";
                //echo 'sql : ' . $sql . ' /<BR>';
                if ( !$db->simpleSQLExecute($sql) ) {
                    $errMsg[] = $db->getErrMsg();
                } else {
                    $newPayNo = $db->getInsertId();
                }
            } else {
                $newPayNo = 0;
            }

            if ( sizeof($errMsg) > 0 ) {
                $errMsg = array_unique ( $errMsg );
                $errMsgStr = join ( '\n', $errMsg);
                echo 'ERROR|매물연장중 에러가 발생하였습니다. [' . $errMsgStr . ']|' . $prod_no . '|' . $newPayNo;
            } else {
                echo 'SUCCESS|매물연장이 정상적으로 처리되었습니다.|' . $prod_no . '|' . $newPayNo;
            }

            echo '|sql : ' . $sql;

            $db->release();
        }
    }
}

//MemberService::getList($s_user_id);
//echo 'ss';
?>