<?
$baseDir = '../';
include $baseDir . 'common/member_lib.inc'; // 멤버 라이브러리
include $baseDir . 'common/lib.inc'       ; // 공통 라이브러리
include $baseDir . 'common/message.inc'   ; // 에러 페이지 처리
$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음

if ( $memInfor['admin_yn'] == "Y" ) {
    include $baseDir . 'common/db_connect.inc'; // Data Base 연결 클래스

    // 데이터베이스에 접속합니다.
    $db = initDBConnection ();
    $totCnt = 0;
        setcookie ("start", 'N');
        head("어드민_뉴스레터");        // Header 출력
        _css($baseDir);
        include $baseDir . 'common/js/common_js.php'; // 공통 javascript
?>

    <form name='saveMailForm' method='post'>
    <input type='hidden' name='data'    value="">
    <input type='hidden' name='title'   value="">
    <input type='hidden' name='content' value="">
<?
        if ( $send == '1' ) { // 전체 회원 뉴스레터 발송 [ 뉴스레터 ]

            $sql    = "select count(user_id) from $tb_member where member_level > 0;";
            $allCnt = simpleSQLQuery($sql);

            $sql  = "select name, e_mail from $tb_member where member_level > 0 and news_yn = 'Y';";
            $stmt = multiRowSQLQuery($sql);
            $data = '';
            while ( $row = multiRowFetch  ($stmt) ) {
                $totCnt++;
                $data  = $row['name'  ] . '$$';
                $data .= $row['e_mail']       ;
                echo "<input type='hidden' name='data' value=" . $data . ">";
            }
        } else if ( $send == '0' ) { // 선택 회원 메일 발송 [ 메일 ]
            $mailNo = stripslashes($HTTP_COOKIE_VARS["mailNo"]);
            if ( $mailNo ) {
                $sql    = "select count(user_id) from $tb_member where member_level > 0;";
                $allCnt = simpleSQLQuery($sql);

                $sql  = "select name, e_mail from $tb_member where user_id in ( $mailNo );";
                $stmt = multiRowSQLQuery($sql);
                $data = '';
                while ( $row = multiRowFetch  ($stmt) ) {
                    $totCnt++;
                    $data  = $row['name'  ] . '$$';
                    $data .= $row['e_mail']       ;
                    echo "<input type='hidden' name='data' value=" . $data . ">";
                }
            }
        } else if ( $send == '2' ) { // 단독 회원 메일 발송 [ 메일 ]
            $mailNo = stripslashes($HTTP_COOKIE_VARS["mailNo"]);
            $sql  = "select name, e_mail from $tb_member where user_id = '$mailNo';";
            $row  = singleRowSQLQuery($sql);
            if ( $row ) {
                $totCnt++;
                $name   = $row['name'   ];
                $e_mail = $row['e_mail' ];
                $data  = $name . '$$';
                $data .= $e_mail     ;
            }
            echo "<input type='hidden' name='data' value=" . $data . ">";
        } else if ( $send == '3' ) { // 이벤트 선택 메일 발송
            $mailNo = stripslashes($HTTP_COOKIE_VARS["mailNo"]);
            $event_id = $HTTP_COOKIE_VARS["event_id"];
            if ( $mailNo ) {
                $sql    = "select count(a.user_id)";
                $sql   .= " from kyh_event_result_master a, kyh_member b";
                $sql   .= " where a.user_id = b.user_id";
                $sql   .= " and   a.no      = '$event_id';";
                $allCnt = simpleSQLQuery($sql);

                $sql  = "select name, e_mail from $tb_member where user_id in ( $mailNo );";
                $stmt = multiRowSQLQuery($sql);
                $data = '';
                while ( $row = multiRowFetch  ($stmt) ) {
                    $totCnt++;
                    $data  = $row['name'  ] . '$$';
                    $data .= $row['e_mail']       ;
                    echo "<input type='hidden' name='data' value=" . $data . ">";
                }
            }
        } else if ( $send == '4' ) { // 이벤트 전체 메일 발송
            $event_id = $HTTP_COOKIE_VARS["event_id"];

            $sql    = "select count(a.user_id)";
            $sql   .= " from kyh_event_result_master a, kyh_member b";
            $sql   .= " where a.user_id = b.user_id";
            $sql   .= " and   a.no      = '$event_id';";
            $allCnt = simpleSQLQuery($sql);

            $sql    = "select b.name name, b.e_mail e_mail";
            $sql   .= " from kyh_event_result_master a, kyh_member b";
            $sql   .= " where a.user_id = b.user_id";
            $sql   .= " and   a.no      = '$event_id';";
            $stmt = multiRowSQLQuery($sql);
            $data = '';
            while ( $row = multiRowFetch  ($stmt) ) {
                $totCnt++;
                $data  = $row['name'  ] . '$$';
                $data .= $row['e_mail']       ;
                echo "<input type='hidden' name='data' value=" . $data . ">";
            }
        }
?>

    <SCRIPT LANGUAGE="JavaScript">
    <!--
        var mailSend = "N";
        var totCnt   = "<?=$totCnt?>";
        var curIdx   = 1            ;
        var send     = "<?=$send?>";
    //-->
    </SCRIPT>
    <table width="500" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="17" height="17"><img src="<?=$baseDir?>images/join_01.gif" width="17" height="17"></td>
        <td background="<?=$baseDir?>images/join_bg01.gif"></td>
        <td width="17" height="17"><img src="<?=$baseDir?>images/join_02.gif" width="17" height="17"></td>
      </tr>
      <tr>
        <td background="<?=$baseDir?>images/join_bg02.gif"></td>
        <td>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="text_01" height="10"></td>
            </tr>
            <tr>
              <td class="text_01" width='100'>
<?
    if ( $send == '0' ) {
        echo '<b>회원 메일발송 </b>: ';
    } else if ( $send == '1' ) {
        echo '<b>전체 뉴스레터 </b>: ';
    } else if ( $send == '2' ) {
        echo '<b>메일 발송     </b>: ';
    } else if ( $send == '3' ) {
        echo '<b>이벤트 선택   </b>: ';
    } else if ( $send == '4' ) {
        echo '<b>이벤트 전체   </b>: ';
    }
?>
              </td>
              <td class="text_01" align='left'>
<?
    if ( $totCnt > 0 ) {
        if ( $send == '0' ) {
            echo "<div id='send_message'>* 총 <span class='text_04'>" . $allCnt ."</span>명 중 선택하신 회원 <span class='text_04'>" . $totCnt ."</span>명 발송.</div>";
        } else if ( $send == '1' ) {
            echo "<div id='send_message'>* 총 <span class='text_04'>" . $allCnt ."</span>명 중 뉴스레터 허용회원 <span class='text_04'>" . $totCnt ."</span>명 발송.</div>";
        } else if ( $send == '2' ) {
            echo "<div id='send_message'>* $name" . "님에게 메일을 발송합니다.</div>";
        } else if ( $send == '3' ) {
            echo "<div id='send_message'>* 총 <span class='text_04'>" . $allCnt ."</span>명의 이벤트 참가자 중 선택하신 회원 <span class='text_04'>" . $totCnt ."</span>명 발송.</div>";
        } else if ( $send == '4' ) {
            echo "<div id='send_message'>* 총 <span class='text_04'>" . $allCnt ."</span>명의 이벤트 참가자에게 메일 발송.</div>";
        }
    } else {
        if ( $allCnt == 0 || $totCnt == 0 ) {
            echo '* 메일 발송 회원이 없습니다. ( 회원을 선택해 주십시요. )';
        } else {
            if ( $send == '0' ) {
                echo "<div id='send_message'>* 총 <span class='text_04'>" . $allCnt ."</span>명 중 선택하신 회원 <span class='text_04'>" . $totCnt ."</span>명 발송.</div>";
            } else if ( $send == '1' ) {
                echo "<div id='send_message'>* 총 <span class='text_04'>" . $allCnt ."</span>명 중 뉴스레터 허용회원 <span class='text_04'>" . $totCnt ."</span>명 발송.</div>";
            } else if ( $send == '2' ) {
                echo "<div id='send_message'>* 총 <span class='text_04'>" . $allCnt ."</span>명 중 뉴스레터 허용회원 <span class='text_04'>" . $totCnt ."</span>명 발송.</div>";
            } else if ( $send == '3' ) {
                echo "<div id='send_message'>* 총 <span class='text_04'>" . $allCnt ."</span>명의 이벤트 참가자 중 선택하신 회원 <span class='text_04'>" . $totCnt ."</span>명 발송.</div>";
            } else if ( $send == '4' ) {
                echo "<div id='send_message'>* 총 <span class='text_04'>" . $allCnt ."</span>명의 이벤트 참가자에게 메일 발송.</div>";
            }
        }
    }?>
              </td>
            </tr>
          </table>
          <br>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td bgcolor="CCCCCC" height="1"></td>
            </tr>
            <tr>
              <td bgcolor="efefef" height="5"></td>
            </tr>
          </table>
          <br>
        </td>
        <td background="<?=$baseDir?>images/join_bg03.gif"></td>
      </tr>
    </table>

    </form>

<?
        closeDBConnection (); // 데이터베이스 연결 설정 해제
        footer(); // Footer 출력
}
?>