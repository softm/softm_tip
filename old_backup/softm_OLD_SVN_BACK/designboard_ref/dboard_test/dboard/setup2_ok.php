<?
include 'common/lib.inc'       ; // 공통 라이브러리

include 'common/board_lib.inc' ; // 게시판 라이브러리
include 'common/poll_lib.inc'  ; // 설문 라이브러리
include 'common/event_lib.inc' ; // 이벤트 라이브러리
include 'common/member_lib.inc'; // 멤버 라이브러리

include 'common/message.inc'   ; // 에러 페이지 처리
include 'common/db_connect.inc'; // Data Base 연결 클래스

setcookie ( "setup_id", $id );

head();          // Header 출력 ( 타이틀이 출력되는 경우는 에러가 발생한 경우)
css();
if ( !$config ) {
   MessageExit("U", "0002", "MOVE:setup.php:이동");
} else {
//    echo $HTTP_REFERER;
    if ( preg_match( "/(setup2.php)$/", $HTTP_REFERER) && $id && $password && $_SESSION['_s_setup_ok'] == '1' ) {
        // 데이터베이스에 접속합니다.
        $db = initDBConnection ();

        $sql = "select user_id, member_level from $tb_member where user_id = '$id';";
        $userInfor = singleRowSQLQuery($sql);
        $user_id      = $userInfor['user_id'     ]; // 사용자 아이디
        $member_level = $userInfor['member_level']; // 회원 레벨

        if ( $user_id ) {
            if ( $member_level == '99' ) {
                $sql = "update $tb_member set password = PASSWORD('$password') where user_id = '$id'";
                simpleSQLExecute($sql);
                // 설치정보 서버전송.
                include 'common/rest/set_install_info.inc';
                redirectPage ("admin.php");  // 로그인 페이지로 이동
            } else {
                MessageExit("U", "0014", "" );  // 아이디가 존재 합니다. 다른 관리자 아이디를 입력해주세요. [ 재설치 ]
            }
        } else {
            // 관리자 계정 입력
            $sql  = "insert into $tb_member ( user_id, member_level, password, name, post_no, reg_date,acc_date ) values ";
            $sql .= "('$id', 99, PASSWORD('$password'),'관리자','','". getYearToSecond() ."','". getYearToSecond() ."');";
            simpleSQLExecute($sql);

            $sql = "select count(user_id) from $tb_member where user_id = '';";
            $userCheck = simpleSQLQuery($sql);
            if ( !$userCheck ) {
                $sql  = "insert into $tb_member ( user_id, member_level, password, name, post_no,reg_date,acc_date ) values ";
                $sql .= "('', 0 , ''                      ,'비회원'    ,'','". getYearToSecond() ."','". getYearToSecond() ."');";
                simpleSQLExecute($sql);
            }
            // 설치정보 서버전송.
            include 'common/rest/set_install_info.inc';
            redirectPage("admin.php"); // 로그인 화면으로 이동
        }
        closeDBConnection (); // 데이터베이스 연결 설정 해제
    } else {
        redirectPage("setup2.php"); // 관리 계정 셋팅화면 으로 이동
    //  MessageExit("U", "0001", 1, "", "setup2.php");
    }
}
?>
</head>
<body>
<?
footer(); // Footer 출력
?>