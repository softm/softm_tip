<?
include 'common/lib.inc'       ; // ���� ���̺귯��

include 'common/board_lib.inc' ; // �Խ��� ���̺귯��
include 'common/poll_lib.inc'  ; // ���� ���̺귯��
include 'common/event_lib.inc' ; // �̺�Ʈ ���̺귯��
include 'common/member_lib.inc'; // ��� ���̺귯��

include 'common/message.inc'   ; // ���� ������ ó��
include 'common/db_connect.inc'; // Data Base ���� Ŭ����

setcookie ( "setup_id", $id );

head();          // Header ��� ( Ÿ��Ʋ�� ��µǴ� ���� ������ �߻��� ���)
_css();
if ( !$config ) {
   Message ("U", "0002", "MOVE:setup.php:�̵�");

} else {
//    echo $HTTP_REFERER;
    if ( ereg( "(setup2.php)$", $HTTP_REFERER) && $id && $password && $HTTP_SESSION_VARS['_s_setup_ok'] == '1' ) {
        // �����ͺ��̽��� �����մϴ�.
        $db = initDBConnection ();

        $sql = "select user_id, member_level from $tb_member where user_id = '$id';";
        $userInfor = singleRowSQLQuery($sql);
        $user_id      = $userInfor['user_id'     ]; // ����� ���̵�
        $member_level = $userInfor['member_level']; // ȸ�� ����

        if ( $user_id ) {
            if ( $member_level == '99' ) {
                $sql = "update $tb_member set password = PASSWORD('$password') where user_id = '$id'";
                simpleSQLExecute($sql);
                redirectPage ("admin.php");  // �α��� �������� �̵�
            } else {
                Message ("U", "0014", "" );  // ���̵� ���� �մϴ�. �ٸ� ������ ���̵� �Է����ּ���. [ �缳ġ ]
            }
        } else {
            // ������ ���� �Է�
            $sql  = "insert into $tb_member ( user_id, member_level, password, name, reg_date ) values ";
            $sql .= "('$id', 99, PASSWORD('$password'),'������','". getYearToSecond() ."');";
            simpleSQLExecute($sql);

            $sql = "select count(user_id) from $tb_member where user_id = '';";
            $userCheck = simpleSQLQuery($sql);
            if ( !$userCheck ) {
                $sql  = "insert into $tb_member ( user_id, member_level, password, name, reg_date ) values ";
                $sql .= "('', 0 , ''                      ,'��ȸ��'    ,'". getYearToSecond() ."');";
                simpleSQLExecute($sql);
            }
            redirectPage("admin.php"); // �α��� ȭ������ �̵�
        }
        closeDBConnection (); // �����ͺ��̽� ���� ���� ����
    } else {
        redirectPage("setup2.php"); // ���� ���� ����ȭ�� ���� �̵�
    //  Message ("U", "0001", 1, "", "setup2.php");
    }
}

footer(); // Footer ���
?>