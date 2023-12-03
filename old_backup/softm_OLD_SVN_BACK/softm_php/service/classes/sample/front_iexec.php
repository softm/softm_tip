<?
define ("HOME_DIR" , realpath(dirname(dirname(dirname(__FILE__)))) );
define ('SERVICE'  , 'IEXEC' );
define ('BASE_DIR' , '..' );
define ('SERVICE_DIR', '../../service');

require_once HOME_DIR . '/inc/lib.inc';
require_once HOME_DIR . '/inc/admin_common.inc';
require_once SERVICE_DIR . '/common/Session.php' ; // 변수

require_once HOME_DIR . '/inc/file.inc'           ;
require_once HOME_DIR . '/inc/FileUpload.inc'     ; // 파일 업로드 클래스

require_once HOME_DIR . '/inc/var.inc' ;
require_once HOME_DIR . '/inc/class.inputfilter_clean.php' ;

html_head('홈다이렉트 :: 중개수수료 없는 부동산 직거래');
?>
<body>
<?
//echo __FILE__;
$memInfor = Session::getSession();
if ( $memInfor[login_yn] == "Y" ) {
    if ( $exec_mode == 'PROD_WRITE' ) {
        $upFile  = FileUpload ( ); // 업로드 인스턴스 생성
        if ( ( $_FILES['block_plan' ][name] && $upFile->restrictedCheck(ALLOW_UPLOAD_IMAGE_EXT, getFileExtraName($_FILES['block_plan' ][name]) ) ) || 
             ( $_FILES['ground_plan'][name] && $upFile->restrictedCheck(ALLOW_UPLOAD_IMAGE_EXT, getFileExtraName($_FILES['ground_plan'][name]) ) ) || 
             ( $_FILES['image1'     ][name] && $upFile->restrictedCheck(ALLOW_UPLOAD_IMAGE_EXT, getFileExtraName($_FILES['image1'     ][name]) ) ) || 
             ( $_FILES['image2'     ][name] && $upFile->restrictedCheck(ALLOW_UPLOAD_IMAGE_EXT, getFileExtraName($_FILES['image2'     ][name]) ) ) || 
             ( $_FILES['image3'     ][name] && $upFile->restrictedCheck(ALLOW_UPLOAD_IMAGE_EXT, getFileExtraName($_FILES['image3'     ][name]) ) ) || 
             ( $_FILES['image4'     ][name] && $upFile->restrictedCheck(ALLOW_UPLOAD_IMAGE_EXT, getFileExtraName($_FILES['image4'     ][name]) ) )
           )
        {
            echo 'ERROR|매물이미지는 ' . str_replace('^',',',ALLOW_UPLOAD_IMAGE_EXT) . ' 만 등록 가능합니다.';
        } else {

            $p_user_no = $memInfor[user_no];
            $p_user_id = $memInfor[user_id];
            $p_company_name = $memInfor[company_name];

            //echo '$mode : ' . $mode . '<BR>';
            $tags = explode(',', "xmp, script, table, tr, th, td, thead, tbody, tfoot, html, head, title, meta, body, div, span");
            $attr = explode(',', "style,src");
            $myFilter = new InputFilter($tags,$attr,1,0,1);

            $head_title         = $myFilter->process($head_title);

            if ( $head_title ) {
                require_once HOME_DIR . '/inc/DB.php'           ; // DB
                $db = new DB();
                $db->getConnect();

                // PRODUCT 관련
                $address1           = $myFilter->process($address1  );
                $address2           = $myFilter->process($address2  );

                $cost1              = (int)$cost1;
                $cost2              = (int)$cost2;
                $cost3              = (int)$cost3;
                $cost4              = (int)$cost4;

                $directin_yn        = $directin_yn=='Y'?$directin_yn:'N';

                $room_cnt1          = (int)$room_cnt1;
                $room_cnt2          = (int)$room_cnt2;
                $scale1             = (float)$scale1;
                $scale2             = (float)$scale2;
                $build_year         = (int)$build_year;

                $new_yn             = $new_yn=='Y'?$new_yn:'N';

                $floor1             = (int)$floor1;
                $floor2             = (int)$floor2;

                $house_num          = $myFilter->process($house_num);
                $direction          = $myFilter->process($direction);
                $building_company   = $myFilter->process($building_company);
                $in_year            = (int)$in_year;

                $household_num1     = (int)$household_num1;
                $household_num2     = (int)$household_num2;

                $heating_method     = $myFilter->process($heating_method);
                $parking_cnt1       = (int)$parking_cnt1;

                $feature            = $myFilter->process($feature);
                $facilities         = $myFilter->process($facilities);

                $tel1 = $tel1_1 . $tel1_2 . $tel1_3;

                $tel1 = preg_replace('/[^0-9]/','',$tel1);
                $tel1_1 = substr($tel1,0,3);
                $tel1_2 = strlen( $tel1 )>10?substr($tel1,3,4):substr($tel1,3,3);
                $tel1_3 = strlen( $tel1 )>10?substr($tel1,7):substr($tel1,6);
                $tel1 = $tel1_1 . '-' . $tel1_2 . '-' . $tel1_3;

                $tel2 = $tel2_1 . $tel2_2 . $tel2_3;
                $tel2 = preg_replace('/[^0-9]/','',$tel2);
                if ( substr($tel2,0,2)=='02' ) {
                    $tel2_1 = '02';
                    $tel2_2 = strlen( substr($tel2,2) )>7?substr($tel2,2,4):substr($tel2,2,3);
                    $tel2_3 = strlen( substr($tel2,2) )>7?substr($tel2,6  ):substr($tel2,5);
                } else {
                    $tel2_1 = substr($tel2,0,3);
                    $tel2_2 = strlen( substr($tel2,3) )>7?substr($tel2,3,4):substr($tel2,3,3);
                    $tel2_3 = strlen( substr($tel2,3) )>7?substr($tel2,7  ):substr($tel2,6)  ;
                }
                $tel2 = $tel2_1 . '-' . $tel2_2 . '-' . $tel2_3;

                $block_plan  = $_FILES['block_plan' ][name]?$_FILES['block_plan' ][name]:'';
                $ground_plan = $_FILES['ground_plan'][name]?$_FILES['ground_plan'][name]:'';

                //echo 'block_plan : ' . $block_plan . ' /<BR>';
                //echo 'ground_plan : ' . $ground_plan . ' /<BR>';

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

                $opt_amount = 0;
                $opt_amount += $opt_premium =='Y'?(int)OPT_PREMIUM_AMOUNT:0; // 프리미엄매물가격
                $opt_amount += $opt_hot     =='Y'?(int)OPT_HOT_AMOUNT    :0; // 핫매물가격      
                $opt_amount += $opt_speed   =='Y'?(int)OPT_SPEED_AMOUNT  :0; // 스피드매물가격  

                $period         = (int)$period;
                $amount         = ((int)$base_amount + (int)$opt_amount) * $period;
                $surtax         = (int)$amount * 0.1;
                $tot_amount     = (int)$amount + $surtax;

                $x1             = (int)$x1             ;
                $y1             = (int)$y1             ;
                $x2             = (int)$x2             ;
                $y2             = (int)$y2             ;

                if ( $mode == 'U' ) {
                    if ( $_FILES['block_plan'  ][size] > 0 ) $del_block_plan  = 'Y';
                    if ( $_FILES['ground_plan' ][size] > 0 ) $del_ground_plan = 'Y';

                    if ( $del_block_plan    == 'Y' ||
                         $del_ground_plan   == 'Y' ) {
                        $sql = " SELECT "
                             . " BLOCK_PLAN ,"
                             . " GROUND_PLAN "
                             . " FROM " . TB_PRODUCT_TMP
                             . " WHERE PROD_NO = '" . $prod_no  . "'"
                             . " AND   USER_NO = '" . $p_user_no. "'";
                        $rs = $db->singleRowSQLQuery ($sql);
                        $_fname = sprintf('%08d', $prod_no);
                        if ( $del_block_plan    == 'Y' ) {
                            $_fext = getFileExtraName($rs[BLOCK_PLAN]);
                            @unlink(DATA_DIR . '/prod/images/block_plan/' . $_fname . '.' . $_fext );
                        }
                        if ( $del_ground_plan    == 'Y' ) {
                            $_fext = getFileExtraName($rs[GROUND_PLAN]);
                            @unlink(DATA_DIR . '/prod/images/ground_plan/' . $_fname . '.' . $_fext );
                            //echo '여기 : ' . DATA_DIR . '/prod/images/ground_plan/' . $_fname . '.' . $_fext;
                        }
                    }
                    if ( $del_image1 == 'Y' ||
                         $del_image2 == 'Y' ||
                         $del_image3 == 'Y' ||
                         $del_image4 == 'Y' ) {

                        $sql =  " SELECT"
                              . " a.SEQ        SEQ       ,"
                              . " b.USER_NO    USER_NO   ,"
                              . " b.USER_LEVEL USER_LEVEL,"
                              . " b.PROD_NO    PROD_NO   ,"
                              . " b.FILE_NAME  FILE_NAME ,"
                              . " b.FILE_EXT   FILE_EXT  ,"
                              . " b.FILE_SIZE  FILE_SIZE ,"
                              . " b.REG_DATE   REG_DATE   "
                              . " FROM"
                              . " ("
                              . ($del_image1 == 'Y'?" SELECT 1 SEQ ":'')
                              . ($del_image2 == 'Y'?($del_image1 == 'Y'?'UNION ':'') . " SELECT 2 SEQ ":'')
                              . ($del_image3 == 'Y'?($del_image2 == 'Y'?'UNION ':'') . " SELECT 3 SEQ ":'')
                              . ($del_image4 == 'Y'?($del_image3 == 'Y'?'UNION ':'') . " SELECT 4 SEQ ":'')
                              . " ) a LEFT OUTER JOIN " . TB_IMAGE . " b"
                              . " ON  a.SEQ = b.SEQ"
                              . " AND b.USER_NO = '" . $p_user_no   . "'"
                              . " AND b.PROD_NO = '" . $prod_no     . "'"
                              . " ORDER BY a.SEQ";

                        //echo 'sql : ' . $sql . ' /<BR>';
                        $stmt = $db->multiRowSQLQuery ($sql);
                        $delInSeq= "";
                        $delCnt = 0;
                        while ( $rs2 = $db->multiRowFetch  ($stmt) ) {
                            if ( $rs2[FILE_NAME] ) {
                                $_fname = sprintf('%08d_%02d', $prod_no,$rs2[SEQ]);
                                $_fext  = $rs2[FILE_EXT];
                                @unlink(DATA_DIR . '/prod/images/user/' . $_fname . '.' . $_fext );
                                if ( $delCnt == 0 ) $delInSeq  = $rs2[SEQ];
                                else                $delInSeq .= ',' . $rs2[SEQ];
                                $delCnt++;
                                //echo '_fname : ' . $_fname . ' /<BR>';
                            }
                        }
                        if ( $delInSeq ) {
                            $sql  = "DELETE FROM " . TB_IMAGE
                                  . " WHERE USER_NO = '" . $p_user_no   . "'"
                                  . " AND   PROD_NO = '" . $prod_no     . "'"
                                  . " AND   SEQ     IN (" . $delInSeq . ")";
                            $db->simpleSQLExecute($sql);
                            //echo 'sql : ' . $sql . ' /<BR>';
                        }
                    }

                    $sql  = "UPDATE " . TB_PRODUCT_TMP
                          . " SET   "
                          . " PROD_GB         = '" . $prod_gb          . "',"
                          . " TRADE_GB        = '" . $trade_gb         . "',"

                        //. " USER_NO         = '" . $user_no          . "',"
                        //. " USER_ID         = '" . $user_id          . "',"
                        //. " USER_LEVEL      = '" . $user_level       . "',"
                          . " USER_NAME       = '" . $p_user_name      . "',"
                          . " COMPANY_NAME    = '" . $company_name     . "',"
                          . " HEAD_TITLE      = '" . $head_title       . "',"
                          . " TEL1            = '" . $tel1             . "',"
                          . " TEL2            = '" . $tel2             . "',"
                          . " ADDRESS1        = '" . $address1         . "',"
                          . " ADDRESS2        = '" . $address2         . "',"
                          . " POST_NO         = '" . $post_no          . "',"
                          . " X1              = '" . $x1               . "',"
                          . " Y1              = '" . $y1               . "',"
                          . " X2              = '" . $x2               . "',"
                          . " Y2              = '" . $y2               . "',"
                          . " COST1           = '" . $cost1            . "',"
                          . " COST2           = '" . $cost2            . "',"
                          . " COST3           = '" . $cost3            . "',"
                          . " COST4           = '" . $cost4            . "',"
                          . " DIRECTIN_YN     = '" . $directin_yn      . "',"
                          . " IN_DATE         = '" . $in_date          . "',"
                          . " ROOM_CNT1       = '" . $room_cnt1        . "',"
                          . " ROOM_CNT2       = '" . $room_cnt2        . "',"
                          . " SCALE1          = '" . $scale1           . "',"
                          . " SCALE2          = '" . $scale2           . "',"
                          . " BUILD_YEAR      = '" . $build_year       . "',"
                          . " NEW_YN          = '" . $new_yn           . "',"
                          . " FLOOR1          = '" . $floor1           . "',"
                          . " FLOOR2          = '" . $floor2           . "',"
                          . " HOUSE_NUM       = '" . $house_num        . "',"
                          . " DIRECTION       = '" . $direction        . "',"
                          . " BUILDING_COMPANY= '" . $building_company . "',"
                          . " IN_YEAR         = '" . $in_year          . "',"
                          . " HOUSEHOLD_NUM1  = '" . $household_num1   . "',"
                          . " HOUSEHOLD_NUM2  = '" . $household_num2   . "',"
                          . " HEATING_METHOD  = '" . $heating_method   . "',"
                          . " PARKING_CNT1    = '" . $parking_cnt1     . "',"
                          . " FEATURE         = '" . $feature          . "',"
                          . " FACILITIES      = '" . $facilities       . "',"
                          . ( $block_plan  || $del_block_plan   == 'Y' ?" BLOCK_PLAN      = '" . $block_plan   . "',":'')
                          . ( $ground_plan || $del_ground_plan  == 'Y' ?" GROUND_PLAN     = '" . $ground_plan  . "',":'')
                          . " OPT_PREMIUM     = '" . $opt_premium      . "',"
                          . " OPT_HOT         = '" . $opt_hot          . "',"
                          . " OPT_SPEED       = '" . $opt_speed        . "',"
                        //. " REG_DATE        = '" . $reg_date         . "',"
                          . " MOD_DATE        = now()                       "
                          . " WHERE PROD_NO = '" . $prod_no  . "'"
                          . " AND   USER_NO = '" . $p_user_no. "'";
//echo 'sql : ' . $sql . ' /<BR>';
                    if ( !$db->simpleSQLExecute($sql) ) {
                        $errMsg[] = $db->getErrMsg();
                        $errMsg = array_unique ( $errMsg );
                        $errMsgStr = join ( '\n', $errMsg);
                        echo 'ERROR|매물수정중 에러가 발생하였습니다. [' . $errMsgStr . ']';
                    } else {
                        $uploadCnt = sizeof($_FILES); // 파일 업로드 갯수
                        $errMsgStr = '';
                        $errMsg = array();

                        $_fname = sprintf('%08d', $prod_no);
                        $_fext = getFileExtraName($_FILES['block_plan'][name]);
                        $upFile->addUploadFile ($_FILES['block_plan'], DATA_DIR . '/prod/images/block_plan/' , $_FILES['block_plan' ][size] > 0 ?  $_fname . ($_fext?'.'.$_fext:''):'', ALLOW_UPLOAD_IMAGE_EXT, 15);

                        $_fext = getFileExtraName($_FILES['ground_plan'][name]);
                        $upFile->addUploadFile ($_FILES['ground_plan'], DATA_DIR . '/prod/images/ground_plan/', $_FILES['ground_plan'][size] > 0 ? $_fname . ($_fext?'.'.$_fext:''):'', ALLOW_UPLOAD_IMAGE_EXT, 15);

                        $sql =  " SELECT"
                              . " a.SEQ        SEQ       ,"
                              . " b.USER_NO    USER_NO   ,"
                              . " b.PROD_NO    PROD_NO   ,"
                              . " b.FILE_NAME  FILE_NAME ,"
                              . " b.FILE_EXT   FILE_EXT  ,"
                              . " b.FILE_SIZE  FILE_SIZE ,"
                              . " b.REG_DATE   REG_DATE   "
                              . " FROM"
                              . " ("
                              . " SELECT 1 SEQ UNION"
                              . " SELECT 2 SEQ UNION"
                              . " SELECT 3 SEQ UNION"
                              . " SELECT 4 SEQ "
                              . " ) a LEFT OUTER JOIN " . TB_IMAGE . " b"
                              . " ON  a.SEQ = b.SEQ"
                              . " AND b.USER_NO = '" . $p_user_no   . "'"
                              . " AND b.PROD_NO = '" . $prod_no     . "'"
                              . " ORDER BY a.SEQ";
                        //echo $sql . '<br>';

                        $inSql = '';
                        $inCnt = 0 ;
                        $upSql = '';
                        $upCnt = 0 ;

                        $stmt = $db->multiRowSQLQuery ($sql);
                        while ( $rs2 = $db->multiRowFetch  ($stmt) ) {

                            $_fname = sprintf('%08d_%02d', $prod_no,$rs2[SEQ]);
                            $_fext = getFileExtraName($_FILES['image' .$rs2[SEQ]][name]);
                            $upFile->addUploadFile ($_FILES['image' .$rs2[SEQ]], DATA_DIR . '/prod/images/user/', $_FILES['image' .$rs2[SEQ]][size] > 0 ? $_fname . ($_fext?'.'.$_fext:''):'', ALLOW_UPLOAD_IMAGE_EXT, 15);
                            $idx = $upFile->item_cnt-1;
                            // echo '여기 : ' . $_FILES['image' .$rs2[SEQ]][size] . ' /<BR>';
                            // echo '여기 : ' . $rs2[SEQ] . ' /<BR>';
                            if ( $upFile->size[$idx] > 0 ) {
                                if ( $rs2[FILE_NAME] ) {
                                    $upSql .= ($upCnt>0?'UNION':'') . " SELECT '" . $rs2[SEQ] . "' SEQ,'" . $upFile->name[$idx] . "' FILE_NAME,'" . $upFile->ext[$idx] . "' FILE_EXT,'" . $upFile->size[$idx] . "' FILE_SIZE";
                                    $upCnt++;
                                } else {
                                    $inSql .= ($inCnt>0?',':'') .  "('" . $p_user_no . "','" . $prod_no . "','" . $rs2[SEQ] . "','" . $upFile->name[$idx] . "','" . $upFile->ext[$idx] . "','" . $upFile->size[$idx] . "',now())";
                                    $inCnt++;
                                }
                            }
                        }

                        if ( $upSql ) {
                            $sql =  " UPDATE " . TB_IMAGE . " a"
                                  . " INNER JOIN ("
                                  . $upSql
                                  . " ) b"
                                  . " ON  a.SEQ     = b.SEQ"
                                  . " AND a.USER_NO = '" . $p_user_no   . "'"
                                  . " AND a.PROD_NO = '" . $prod_no     . "'"
                                  . " SET a.FILE_NAME   = b.FILE_NAME  ,"
                                  . "     a.FILE_EXT    = b.FILE_EXT   ,"
                                  . "     a.FILE_SIZE   = b.FILE_SIZE   ";
                            //echo 'sql : ' . $sql . ' /<BR>';
                            if ( !$db->simpleSQLExecute($sql) ) {
                                $errMsg[] = $db->getErrMsg();
                            }
                        }
                        //echo 'upSql : ' . $upSql . ' /<BR>';
                        if ( $inSql ) {
                            $sql  = "INSERT INTO " . TB_IMAGE
                                  . " ( "
                                  . " USER_NO   ,PROD_NO   ,SEQ       ,"
                                  . " FILE_NAME ,FILE_EXT  ,FILE_SIZE ,REG_DATE   "
                                  . " ) VALUES " . $inSql . '';
                            //echo 'sql : ' . $sql . ' /<BR>';
                            if ( !$db->simpleSQLExecute($sql) ) {
                                $errMsg[] = $db->getErrMsg();
                            }
                        }

                        for ( $i=0; $i<$uploadCnt; $i++ ) {
                            if ( sizeof($upFile->error[$i]) > 0 ) {
                                for ( $j=0; $j<sizeof($upFile->error[$i]); $j++ ) {
                                    $errMsg[] = $upFile->error[$i][$j];
                                }
                            }
                        }

                        $upFile->Upload(); // 업로드 시작

                        if ( sizeof($errMsg) > 0 ) {
                            $errMsg = array_unique ( $errMsg );
                            $errMsgStr = join ( '\n', $errMsg);
                            echo 'SUCCESS|매물등록이 정상적으로 처리되었습니다. [' . $errMsgStr . ']|' . $prod_no . '|' . $pay_no;
                        } else {
                            echo 'SUCCESS|매물등록이 정상적으로 처리되었습니다.|' . $prod_no . '|' . $pay_no;
                        }
                    }

                } else if ( $mode == 'I' ) {

                    $sql = " SELECT "
                         . " USER_NO        ,"
                         . " USER_ID        ,"
                         . " USER_LEVEL     ,"
                         . " USER_NAME      ,"
                         . " COMPANY_NAME   ,"
                         . " E_MAIL         ,"
                         . " ACCESS         ,"
                         . " STATE           "
                         . " FROM " . TB_MEMBER
                         . " WHERE USER_ID = '" . $p_user_id . "'";
                    $rs = $db->singleRowSQLQuery ($sql);

                    if ( !$rs['USER_NO'] ) {
                        echo 'ERROR|매물등록 정보 올바르지 않습니다.';
                    } else {
                        $p_user_no   = $rs['USER_NO'     ];
                        $p_user_id   = $rs['USER_ID'     ];
                        $p_user_level= $rs['USER_LEVEL'  ];

                        $errMsgStr = '';
                        $errMsg = array();
                        if ( $direct_gb == 'D' ) { // 직거래
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

                        $sql  = "INSERT INTO " . TB_PRODUCT_TMP
                              . " ( "
                              . " DIRECT_GB,       PROD_GB         ,TRADE_GB        ,"
                              . " USER_NO         ,USER_ID         ,USER_LEVEL      ,USER_NAME       ,COMPANY_NAME    ,"
                              . " HEAD_TITLE      ,"
                              . " TEL1            ,TEL2            ,"
                              . " ADDRESS1        ,ADDRESS2        ,POST_NO         ,"
                              . " X1              ,Y1              ,X2              ,Y2              ,"
                              . " COST1           ,COST2           ,COST3           ,COST4           ,"
                              . " DIRECTIN_YN     ,IN_DATE         ,"
                              . " ROOM_CNT1       ,ROOM_CNT2       ,SCALE1          ,SCALE2          ,"
                              . " BUILD_YEAR      ,NEW_YN          ,"
                              . " FLOOR1          ,FLOOR2          ,"
                              . " HOUSE_NUM       ,DIRECTION       ,"
                              . " BUILDING_COMPANY,IN_YEAR         ,"
                              . " HOUSEHOLD_NUM1  ,HOUSEHOLD_NUM2  ,"
                              . " HEATING_METHOD  ,"
                              . " PARKING_CNT1    ,"
                              . " FEATURE         ,FACILITIES      ,"
                              . " BLOCK_PLAN      ,GROUND_PLAN     ,"
                              . " OPT_PREMIUM     ,OPT_HOT         ,OPT_SPEED       ,"
                              . " PAY_NO          ,"

                              . " REG_DATE      ,MOD_DATE           ,"
                              . " EXPIRE_DATE   ,                    "
                              . " START_DATE    ,END_DATE           ,"

                              . " TRADE_STATE   ,STATE"
                              . " ) VALUES ("
                              . " '" . $direct_gb       . "','" . $prod_gb         . "','" . $trade_gb             . "',"
                              . " '" . $p_user_no       . "','" . strtolower($p_user_id). "','" . $p_user_level . "','" . $p_user_name  . "','" . $p_company_name . "',"
                              . " '" . $head_title      . "',"
                              . " '" . $tel1            . "','" . $tel2                 . "',"
                              . " '" . $address1        . "','" . $address2             . "','" . $post_no      . "',"
                              . " '" . $x1              . "','" . $y1                   . "','" . $x2           . "','" . $y2           . "',"
                              . " '" . $cost1           . "','" . $cost2                . "','" . $cost3        . "','" . $cost4        . "',"
                              . " '" . $directin_yn     . "','" . $in_date              . "',"
                              . " '" . $room_cnt1       . "','" . $room_cnt2            . "','" . $scale1       . "','" . $scale2       . "',"
                              . " '" . $build_year      . "','" . $new_yn               . "',"
                              . " '" . $floor1          . "','" . $floor2               . "',"
                              . " '" . $house_num       . "','" . $direction            . "',"
                              . " '" . $building_company. "','" . $in_year              . "',"
                              . " '" . $household_num1  . "','" . $household_num2       . "',"
                              . " '" . $heating_method  . "',"
                              . " '" . $parking_cnt1    . "',"
                              . " '" . $feature         . "','" . $facilities           . "',"
                              . " '" . $block_plan      . "','" . $ground_plan          . "',"
                              . " '" . $opt_premium     . "','" . $opt_hot              . "','" . $opt_speed    . "',"
                              . " '" . $newPayNo        . "',"

                              . " now(),null,";

                            // 결제구분 : 월결제 : M, 건결제 : D'
                            if ( $pay_gb == 'D' ) { // 건결제
                                $sql .= " null ,"
                                     .  " null ,null,"
                                     .  " 'R','R'";
                            } else if ( $pay_gb == 'M' ) { // 월결제
                                $sql .= " DATE_ADD(now(),INTERVAL " . $period . " MONTH ) ,"
                                     .  " now() ,null,"
                                     .  " 'I','U'";
                            }
                            $sql .= " )";
                            //echo 'sql : ' . $sql . ' /<BR>';

                        if ( !$db->simpleSQLExecute($sql) ) {
                            $errMsg[] = $db->getErrMsg(); 
                            $errMsg = array_unique ( $errMsg );
                            $errMsgStr = join ( '\n', $errMsg);
                            echo 'ERROR|매물등록중 에러가 발생하였습니다. [' . $errMsgStr . ']';
                        } else {
                            $newProdNo = $db->getInsertId();

                            if ( $pay_gb == 'D' ) { // 건결제
                                // 직거래 매물일경우에만 PROD번호 보관
                                $sql  = " UPDATE " . TB_PAYMENT . " SET"
                                      . " PROD_NO = '" . $newProdNo. "'"
                                      . " WHERE PAY_NO IN(" . $newPayNo. ")";
                                if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
                            } else if ( $pay_gb == 'M' ) { // 월결제
                                require_once SERVICE_DIR . '/front/Product.php' ; // 매물
                                // 사용량 차감
                                $sql  = " UPDATE " . TB_PAYMENT . " SET"
                                      . " REG_CNT = REG_CNT + " . $use_cnt . ""
                                      . " WHERE PAY_NO = '" . $pay_no. "'";
                                //echo 'sql : ' . $sql . ' /<BR>';
                                if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();

                                // 매물 히스토리 생성
                                $p  = new Product();
                                $argus = array();
                                $argus[extension  ] = false     ;
                                $argus[direct_gb  ] = $direct_gb;
                                $argus[pay_gb     ] = $pay_gb   ;
                                $argus[prod_no    ] = $newProdNo;
                                $argus[pay_no     ] = $pay_no   ;
                                $argus[period     ] = $period   ;
                                $argus[use_cnt    ] = $use_cnt  ;
                                $argus[db         ] = $db       ;
                                $p->createHistory($argus);

                                $sql  = "INSERT INTO " . TB_PRODUCT
                                      . " SELECT "
                                      . " * "
                                      . " FROM " . TB_PRODUCT_TMP . ""
                                      . " WHERE PROD_NO = '" . $newProdNo . "'";
                                if ( !$db->simpleSQLExecute($sql) ) $errMsg[] = $db->getErrMsg();
                            }

                            $uploadCnt = sizeof($_FILES); // 파일 업로드 갯수

                            $_fname = sprintf('%08d', $newProdNo);
                            $_fext = getFileExtraName($_FILES['block_plan'][name]);
                            $upFile->addUploadFile ($_FILES['block_plan'], DATA_DIR . '/prod/images/block_plan/' , $_FILES['block_plan' ][size] > 0 ?  $_fname . ($_fext?'.'.$_fext:''):'', ALLOW_UPLOAD_IMAGE_EXT, 15);

                            $_fext = getFileExtraName($_FILES['ground_plan'][name]);
                            $upFile->addUploadFile ($_FILES['ground_plan'], DATA_DIR . '/prod/images/ground_plan/', $_FILES['ground_plan'][size] > 0 ? $_fname . ($_fext?'.'.$_fext:''):'', ALLOW_UPLOAD_IMAGE_EXT, 15);

                            $inSql = '';
                            $inCnt = 0;
                            for ( $j=1; $j<=4; $j++) {
                                $_fname = sprintf('%08d_%02d', $newProdNo,$j);
                                $_fext = getFileExtraName($_FILES['image' .$j][name]);
                                $upFile->addUploadFile ($_FILES['image' .$j], DATA_DIR . '/prod/images/user/', $_FILES['image' .$j][size] > 0 ? $_fname . ($_fext?'.'.$_fext:''):'', ALLOW_UPLOAD_IMAGE_EXT, 15);
                                $idx = $upFile->item_cnt-1;
                                if ( $upFile->size[$idx] > 0 ) {
                                    $inSql .= ($inCnt>0?',':'') .  "('" . $p_user_no . "','" . $newProdNo . "','" . $j . "','" . $upFile->name[$idx] . "','" . $upFile->ext[$idx] . "','" . $upFile->size[$idx] . "',now())";
                                    $inCnt++;
                                }
                            }
                            //$upFile->upLoadInfor(1);
                            //echo $inSql ;

                            if ( $inSql ) {
                                $sql  = "INSERT INTO " . TB_IMAGE
                                      . " ( "
                                      . " USER_NO   ,PROD_NO   ,SEQ       ,"
                                      . " FILE_NAME ,FILE_EXT  ,FILE_SIZE ,REG_DATE   "
                                      . " ) VALUES " . $inSql . '';
                                //echo 'sql : ' . $sql . ' /<BR>';
                                if ( !$db->simpleSQLExecute($sql) ) {
                                    $errMsg[] = $db->getErrMsg();
                                }
                            }

                            for ( $i=0; $i<$uploadCnt; $i++ ) {
                                if ( sizeof($upFile->error[$i]) > 0 ) {
                                    for ( $j=0; $j<sizeof($upFile->error[$i]); $j++ ) {
                                        $errMsg[] = $upFile->error[$i][$j];
                                    }
                                }
                            }
                            $upFile->Upload(); // 업로드 시작

                            if ( sizeof($errMsg) > 0 ) {
                                $errMsg = array_unique ( $errMsg );
                                $errMsgStr = join ( '\n', $errMsg);
                                echo 'SUCCESS|매물등록이 정상적으로 처리되었습니다. [' . $errMsgStr . ']|' . $newProdNo . '|' . $newPayNo;

                            } else {
                                echo 'SUCCESS|매물등록이 정상적으로 처리되었습니다.|' . $newProdNo . '|' . $newPayNo;
                            }
                        }
                    }
                    //echo '|sql : ' . $sql;
                    $db->release();
                }
            } else {
                echo 'ERROR|글머리가 입력되지 않았습니다.';
            }
        }
    }
}
html_foot();
?>