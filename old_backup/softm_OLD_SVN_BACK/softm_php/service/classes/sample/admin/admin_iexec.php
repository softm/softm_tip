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
if ( $memInfor[admin_yn] == "Y" ) {
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

            //echo '$mode : ' . $mode . '<BR>';
            $tags = explode(',', "xmp, script, table, tr, th, td, thead, tbody, tfoot, html, head, title, meta, body, div, span");
            $attr = explode(',', "style,src");
            $myFilter = new InputFilter($tags,$attr,1,0,1);

            $head_title         = $myFilter->process($head_title);

            if ( $head_title ) {
                require_once HOME_DIR . '/inc/DB.php'           ; // DB
                require_once SERVICE_DIR . '/admin/Product.php' ; // 매물

                $db = new DB();
                $db->getConnect();
                $prodObj = new Product();


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

                $direct_gb      = $direct_gb    ;

                $opt_premium    = $opt_premium  =='Y'   ?$opt_premium   :'N';
                $opt_hot        = $opt_hot      =='Y'   ?$opt_hot       :'N';
                $opt_speed      = $opt_speed    =='Y'   ?$opt_speed     :'N';

                $x1             = (int)$x1             ;
                $y1             = (int)$y1             ;
                $x2             = (int)$x2             ;
                $y2             = (int)$y2             ;

                $read_cnt       = (int)$read_cnt       ;
                $pay_no         = (int)$pay_no         ;


                if ( $mode == 'U' ) {
                    if ( $_FILES['block_plan'  ][size] > 0 ) $del_block_plan  = 'Y';
                    if ( $_FILES['ground_plan' ][size] > 0 ) $del_ground_plan = 'Y';

                    if ( $del_block_plan    == 'Y' ||
                         $del_ground_plan   == 'Y' ) {
                        $sql = " SELECT "
                             . " BLOCK_PLAN ,"
                             . " GROUND_PLAN "
                             . " FROM " . TB_PRODUCT_TMP
                             . " WHERE PROD_NO = '" . $prod_no . "'";
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

                          . " READ_CNT        = '" . $read_cnt         . "',"

                          . " REG_DATE        = '" . $reg_date         . "',"
                          . " MOD_DATE        = " . ($mod_date ?"'".$mod_date."'":'now()') . ","
                          . " EXPIRE_DATE     = " . ($state == 'X' ?($expire_date?"'".$expire_date."'":'null'):'null') . ","
                          . " START_DATE      = " . ($start_date ?"'".$start_date."'":'null') . ","
                          . " END_DATE        = " . ($end_date ?"'".$end_date."'":'null') . ","

                          . " PAY_NO          = '" . $pay_no            . "',"

                          . " TRADE_STATE     = '" . $trade_state       . "',"   // 'I' : 진행중, 'E' : 완료, 'C' : 취소
                          . " STATE           = '" . $state             . "' "   // 'R' : 대기, 'U' : 사용, 'X' : 만료
                          . " WHERE PROD_NO  = '" . $prod_no . "'";
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

                        if ( $state == 'U' ) {
                            if ( $db->simpleSQLQuery("SELECT COUNT(*) FROM ". TB_PRODUCT . " WHERE PROD_NO = '" . $prod_no . "'") == 0 ) {
                                $sql  = "INSERT INTO " . TB_PRODUCT
                                      . " SELECT "
                                      . " * "
                                      . " FROM " . TB_PRODUCT_TMP . " a "
                                      . " WHERE a.PROD_NO = '" . $prod_no . "'";
                                if ( !$db->simpleSQLExecute($sql) ) {
                                    $errMsg[] = $db->getErrMsg();
                                }
                            }
                        }

                        $upFile->Upload(); // 업로드 시작

                        if ( sizeof($errMsg) > 0 ) {
                            $errMsg = array_unique ( $errMsg );
                            $errMsgStr = join ( '\n', $errMsg);
                            echo 'ERROR|매물등록이 정상적으로 처리되었습니다. [이미지 : ' . $errMsgStr . $sql . ']';
                        } else {
                            echo 'SUCCESS|매물등록이 정상적으로 처리되었습니다.';
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

                              . " TRADE_STATE        ,STATE"

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
                              . " '" . $pay_no   . "',"
                              . " now(),null,"
                              . " ".($state == 'X' ?"'".$expire_date."'":'null').","
                              . " null ,null,"
                              . " '" . $trade_state . "','" . $state . "'"
                              . " )";
                       //echo 'sql : ' . $sql . ' /<BR>';
                        
                        if ( !$db->simpleSQLExecute($sql) ) {
                            $errMsg[] = $db->getErrMsg();
                            $errMsg = array_unique ( $errMsg );
                            $errMsgStr = join ( '\n', $errMsg);
                            echo 'ERROR|매물등록중 에러가 발생하였습니다. [' . $errMsgStr . ']';
                        } else {
                            $newProdNo = $db->getInsertId();

                            $uploadCnt = sizeof($_FILES); // 파일 업로드 갯수
                            $errMsgStr = '';
                            $errMsg = array();

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
                                echo 'ERROR|매물등록이 정상적으로 처리되었습니다. [이미지 : ' . $errMsgStr . $sql . ']';

                            } else {

                                echo 'SUCCESS|매물등록이 정상적으로 처리되었습니다.';
                            }
                            //echo 'newProdNo : ' . $newProdNo . ' /<BR>';
                        }
                    }
                }

                echo '|' . ($mode=='I'?$newProdNo:$prod_no);
                // 매물상태 변경
                $argus = array();
                $argus[prod_nos ] = $mode=='I'?$newProdNo:$prod_no;
                $argus[state    ] = $state    ;
                $argus[db       ] = $db       ;

                $prodObj->changeState($argus);

                $db->release();

            } else {
                echo 'ERROR|글머리가 입력되지 않았습니다.';
            }
        }
    }
}

html_foot();
?>