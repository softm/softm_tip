<?
$baseDir = '../';
include $baseDir . 'common/member_lib.inc'; // ��� ���̺귯��
include $baseDir . 'common/lib.inc'       ; // ���� ���̺귯��
include $baseDir . 'common/message.inc'   ; // ���� ������ ó��
$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����

if ( $memInfor['admin_yn'] == "Y" ) {
    include $baseDir . 'common/db_connect.inc'; // Data Base ���� Ŭ����

    // �����ͺ��̽��� �����մϴ�.
    $db = initDBConnection ();
    $totCnt = 0;
        setcookie ("start", 'N');
        head("����_��������");        // Header ���
        _css($baseDir);
        include $baseDir . 'common/js/common_js.php'; // ���� javascript
?>

    <form name='saveMailForm' method='post'>
    <input type='hidden' name='data'    value="">
    <input type='hidden' name='title'   value="">
    <input type='hidden' name='content' value="">
<?
        if ( $send == '1' ) { // ��ü ȸ�� �������� �߼� [ �������� ]

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
        } else if ( $send == '0' ) { // ���� ȸ�� ���� �߼� [ ���� ]
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
        } else if ( $send == '2' ) { // �ܵ� ȸ�� ���� �߼� [ ���� ]
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
        } else if ( $send == '3' ) { // �̺�Ʈ ���� ���� �߼�
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
        } else if ( $send == '4' ) { // �̺�Ʈ ��ü ���� �߼�
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
        echo '<b>ȸ�� ���Ϲ߼� </b>: ';
    } else if ( $send == '1' ) {
        echo '<b>��ü �������� </b>: ';
    } else if ( $send == '2' ) {
        echo '<b>���� �߼�     </b>: ';
    } else if ( $send == '3' ) {
        echo '<b>�̺�Ʈ ����   </b>: ';
    } else if ( $send == '4' ) {
        echo '<b>�̺�Ʈ ��ü   </b>: ';
    }
?>
              </td>
              <td class="text_01" align='left'>
<?
    if ( $totCnt > 0 ) {
        if ( $send == '0' ) {
            echo "<div id='send_message'>* �� <span class='text_04'>" . $allCnt ."</span>�� �� �����Ͻ� ȸ�� <span class='text_04'>" . $totCnt ."</span>�� �߼�.</div>";
        } else if ( $send == '1' ) {
            echo "<div id='send_message'>* �� <span class='text_04'>" . $allCnt ."</span>�� �� �������� ���ȸ�� <span class='text_04'>" . $totCnt ."</span>�� �߼�.</div>";
        } else if ( $send == '2' ) {
            echo "<div id='send_message'>* $name" . "�Կ��� ������ �߼��մϴ�.</div>";
        } else if ( $send == '3' ) {
            echo "<div id='send_message'>* �� <span class='text_04'>" . $allCnt ."</span>���� �̺�Ʈ ������ �� �����Ͻ� ȸ�� <span class='text_04'>" . $totCnt ."</span>�� �߼�.</div>";
        } else if ( $send == '4' ) {
            echo "<div id='send_message'>* �� <span class='text_04'>" . $allCnt ."</span>���� �̺�Ʈ �����ڿ��� ���� �߼�.</div>";
        }
    } else {
        if ( $allCnt == 0 || $totCnt == 0 ) {
            echo '* ���� �߼� ȸ���� �����ϴ�. ( ȸ���� ������ �ֽʽÿ�. )';
        } else {
            if ( $send == '0' ) {
                echo "<div id='send_message'>* �� <span class='text_04'>" . $allCnt ."</span>�� �� �����Ͻ� ȸ�� <span class='text_04'>" . $totCnt ."</span>�� �߼�.</div>";
            } else if ( $send == '1' ) {
                echo "<div id='send_message'>* �� <span class='text_04'>" . $allCnt ."</span>�� �� �������� ���ȸ�� <span class='text_04'>" . $totCnt ."</span>�� �߼�.</div>";
            } else if ( $send == '2' ) {
                echo "<div id='send_message'>* �� <span class='text_04'>" . $allCnt ."</span>�� �� �������� ���ȸ�� <span class='text_04'>" . $totCnt ."</span>�� �߼�.</div>";
            } else if ( $send == '3' ) {
                echo "<div id='send_message'>* �� <span class='text_04'>" . $allCnt ."</span>���� �̺�Ʈ ������ �� �����Ͻ� ȸ�� <span class='text_04'>" . $totCnt ."</span>�� �߼�.</div>";
            } else if ( $send == '4' ) {
                echo "<div id='send_message'>* �� <span class='text_04'>" . $allCnt ."</span>���� �̺�Ʈ �����ڿ��� ���� �߼�.</div>";
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
        closeDBConnection (); // �����ͺ��̽� ���� ���� ����
        footer(); // Footer ���
}
?>