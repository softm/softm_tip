<?
$baseDir = '../../../';
include $baseDir . 'common/event_lib.inc' ; // �̺�Ʈ ���̺귯��
include $baseDir . 'common/lib.inc'       ; // ���� ���̺귯��
include $baseDir . 'common/message.inc'   ; // ���� ������ ó��
include $baseDir . 'common/db_connect.inc'; // Data Base ���� Ŭ����
include $baseDir . 'common/_service.inc'  ; // ���� ȭ�� ����

include $baseDir . 'common/member_lib.inc'; // ��� ���̺귯��

//   echo 'event_id .' . $event_id . '<BR>';
//   echo 'event_exec .' . $event_exec . '<BR>';
//   echo '$REQUEST_METHOD .' . $REQUEST_METHOD . '<BR>';
    if ( $event_id && ( $event_exec == 'event_join_exec' ) && ereg($HTTP_HOST, $HTTP_REFERER) && $REQUEST_METHOD == 'POST' )
    {
        $db = initDBConnection ();             // �����ͺ��̽� ����

        /* ------- ���� -------------------------------------------------- */
        $memInfor   = getMemInfor  (                        ); // ȸ��   ����
        $user_id        = $memInfor['user_id' ]; // ���̵�
        $login_yn       = $memInfor['login_yn']; // �α��� ����
        $admin_yn       = $memInfor['admin_yn']; // ���� ����
        $memberlevel    = $memInfor['member_level']; // ȸ�� ���

//      echo '$user_id     :' . $user_id     . '<BR>';
//      echo '$login_yn    :' . $login_yn    . '<BR>';
//      echo '$admin_yn    :' . $admin_yn    . '<BR>';
//      echo '$memberlevel :' . $memberlevel . '<BR>';

        $eventInfor = getEventInfor($event_id               ); // �̺�Ʈ ����
        $eventGrant = getEventGrant($event_id, $memberlevel ); // ����   ����
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
            if ( $eventInfor )  { // �̺�Ʈ ���� ����
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
//                            echo '�Ķ���� �� : ' . '_dboard_item' . $i . '<BR>';
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

                        // ȸ�� ������ �̺�Ʈ ����Ʈ ��ȸ
                        $sql = "select join_point from $tb_event_grant where member_level = '" . $memberlevel . "'";
                        $point = simpleSQLQuery($sql);
                        $point       = (int) $point;
                        $sign        = '+'; // ��ȣ
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
            if  ( $login_yn == 'N' ) {                  // �α���
                $a_params = "?event_id=$event_id";
                Message ('S', '0073',"MOVE:" . $baseDir . "devent.php$a_params&lg=Y&exec=$exec:�α��� ..",$loginSkinDir);
            } else {
                Message ('S', '0073',"",$loginSkinDir);
            }
        }
    }
?>