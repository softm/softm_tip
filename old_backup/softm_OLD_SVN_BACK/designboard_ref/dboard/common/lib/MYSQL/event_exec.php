<?
$baseDir = '../../../';
include $baseDir . 'common/event_lib.inc' ; // 이벤트 라이브러리
include $baseDir . 'common/lib.inc'       ; // 공통 라이브러리
include $baseDir . 'common/message.inc'   ; // 에러 페이지 처리
include $baseDir . 'common/db_connect.inc'; // Data Base 연결 클래스
include $baseDir . 'common/_service.inc'  ; // 서비스 화면 관련

include $baseDir . 'common/member_lib.inc'; // 멤버 라이브러리

//   echo 'event_id .' . $event_id . '<BR>';
//   echo 'event_exec .' . $event_exec . '<BR>';
//   echo '$REQUEST_METHOD .' . $REQUEST_METHOD . '<BR>';
    if ( $event_id && ( $event_exec == 'event_join_exec' ) && ereg($HTTP_HOST, $HTTP_REFERER) && $REQUEST_METHOD == 'POST' )
    {
        $db = initDBConnection ();             // 데이터베이스 접속

        /* ------- 정보 -------------------------------------------------- */
        $memInfor   = getMemInfor  (                        ); // 회원   정보
        $user_id        = $memInfor['user_id' ]; // 아이디
        $login_yn       = $memInfor['login_yn']; // 로그인 여부
        $admin_yn       = $memInfor['admin_yn']; // 어드민 여부
        $memberlevel    = $memInfor['member_level']; // 회원 등급

//      echo '$user_id     :' . $user_id     . '<BR>';
//      echo '$login_yn    :' . $login_yn    . '<BR>';
//      echo '$admin_yn    :' . $admin_yn    . '<BR>';
//      echo '$memberlevel :' . $memberlevel . '<BR>';

        $eventInfor = getEventInfor($event_id               ); // 이벤트 정보
        $eventGrant = getEventGrant($event_id, $memberlevel ); // 권한   정보
        $grant      = $eventGrant['grant_join'];
        _head ($eventInfor[title]);
        _css($baseDir);

        $use_default_login = $eventInfor['use_default_login'];
        $login_skin_name   = '';
        if ( $use_default_login == 'Y' ) {
            $login_skin_name   = $sysInfor['login_skin'];
        } else {
            $login_skin_name   = $eventInfor['login_skin_name'];
        }
        $loginSkinDir= $baseDir . 'skin/login/' . $login_skin_name . '/';

//      echo '$grant.' . $grant . '<BR>';

        if ( $grant == 'Y' ) {
            if ( $eventInfor )  { // 이벤트 정보 존재
                if ( $event_exec == 'event_join_exec' ) {
                    $chkSql  = "select count(no) from $tb_event_result_master ";
                    $chkSql .= " where  no      = '" . $event_id      . "'";
                    $chkSql .= " and    user_id = '" . $user_id       . "'";
                    $existChk = simpleSQLQuery($chkSql);

                    if ( !$existChk ) {
                        $sql  = "insert into $tb_event_result_master";
                        $sql .= "(";
                        $sql .= "no, user_id, prize_yn, prize_point, join_date";
                        $sql .= ") values (";
                        $sql .= "$event_id, '$user_id', 'N', '0', '" . getYearToMicro() . "'";
                        $sql .= ");";
        //              logs ( '$sql : '. $sql . '<BR>' , true);
                        simpleSQLExecute($sql);

                        $sql  = "select max(g_no) m_g_no, max(seq) m_seq from $tb_event_item";
                        $row = singleRowSQLQuery($sql);
                        $m_g_no = $row ['m_g_no'];
                        $m_seq  = $row ['m_seq' ];
//                        echo '$m_g_no : ' . $m_g_no . '<BR>';
                        for ( $i=1;$i<=$m_g_no;$i++) {
                            $itemArray = $HTTP_POST_VARS['_dboard_item' . $i];
//                            echo '파라메터 명 : ' . '_dboard_item' . $i . '<BR>';
//                            echo '$itemArray : ' . $itemArray . '<BR>';
//                            echo 'sizeof($itemArray) : ' . sizeof($itemArray) . '<BR>';
                            if ( is_array($itemArray) ) {
                                for ( $j=0;$j<sizeof($itemArray);$j++) {
                                    if ( $itemArray[$j] ) {
                                        $detailSql  = "insert into $tb_event_result_detail";
                                        $detailSql .= "(";
                                        $detailSql .= "no, user_id, g_no, key_seq, choice_data";
                                        $detailSql .= ") values (";
                                        $detailSql .= "$event_id, '$user_id', '$i', '$j', '" . $itemArray[$j] ."'";
                                        $detailSql .= ");";
//                                      logs ( '$detailSql : '. $detailSql . '<BR>' , true);
                                        simpleSQLExecute($detailSql);
                                    }
                                }
                            } else {
                                    if ( $itemArray[0] ) {
                                        $detailSql  = "insert into $tb_event_result_detail";
                                        $detailSql .= "(";
                                        $detailSql .= "no, user_id, g_no, key_seq, choice_data";
                                        $detailSql .= ") values (";
                                        $detailSql .= "$event_id, '$user_id', '$i', '', '" . $itemArray[0] ."'";
                                        $detailSql .= ");";
//                                      logs ( '$detailSql : '. $detailSql . '<BR>' , true);
                                        simpleSQLExecute($detailSql);
                                    }
                            }
                        }

                        // 회원 종류별 이벤트 포인트 조회
                        $sql = "select join_point from $tb_event_grant where member_level = '" . $memberlevel . "'";
                        $point = simpleSQLQuery($sql);
                        $point       = (int) $point;
                        $sign        = '+'; // 부호
                        if ( $point < 0 ) { $sign = '-'; $point = abs($point); }

                        $sql  = "update $tb_member";
                        $sql .= " set point = point $sign $point ";
                        $sql .= " where user_id = '" . $user_id . "';";
                        simpleSQLExecute($sql);

                        $retunPage  = getUrlPath ($HTTP_REFERER) . getReqPageName ($HTTP_REFERER);
                        $retunPage .= "?event_id=" . $event_id . "&event_join=Y";
                        redirectPage($retunPage );
                    } else {
                        $retunPage  = getUrlPath ($HTTP_REFERER) . getReqPageName ($HTTP_REFERER);
                        $retunPage .= "?event_id=" . $event_id . "&join_check=Y";
                        redirectPage($retunPage );
                    }
                }
            } // if END
        } else {
            if  ( $login_yn == 'N' ) {                  // 로그인
                $a_params = "?event_id=$event_id";
                Message ('S', '0073',"MOVE:" . $baseDir . "devent.php$a_params&lg=Y&exec=$exec:로그인 ..",$loginSkinDir);
            } else {
                Message ('S', '0073',"",$loginSkinDir);
            }
        }
    }
?>