<?
include ( "common/lib.inc"          ); // 공통 라이브러리

include 'common/board_lib.inc' ; // 게시판 라이브러리
include 'common/poll_lib.inc'  ; // 설문 라이브러리
include 'common/event_lib.inc' ; // 이벤트 라이브러리
include 'common/member_lib.inc'; // 멤버 라이브러리

include ( "common/message.inc"      ); // 에러 페이지 처리

if ( ereg($HTTP_HOST,$HTTP_REFERER) && ereg( "(uninstall.php)$", $HTTP_REFERER) && $REQUEST_METHOD == 'POST' ) {

    if ( !$config ) { 
        Message ('P', '0002', 'MOVE:setup.php:이동');
    }

    $memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음

    if ( $memInfor['admin_yn'] == "N" ) {
        //redirectPage ("admin.php");     // 페이지 이동
        head("디자인보드 삭제");        // Header 출력
        Message ('U', '0003', 'MOVE:admin.php:돌아가기');
    } else {
        if ( $host_nm && $db_nm && $id && $driver ) {
            include ( "common/db_connect.inc"   ); // Data Base 연결 클래스

            // 데이터베이스에 접속합니다.
            $db = initDBConnection ("$host_nm","$db_nm", "$id", "$password", "$driver");
            if ( isTable($tb_bbs_infor   , $db_nm, $driver) ) {
                $sql  = "select bbs_id from $tb_bbs_infor order by no desc";
                $stmt = multiRowSQLQuery($sql);
                while ( $row = multiRowFetch  ($stmt) ) {
                    $bbs_id = $row['bbs_id'];
                    if ( isTable($tb_bbs_data    . "_" . $bbs_id, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_bbs_data"    . "_" . $bbs_id . ";", $driver); /* 게시판               */ }
                    if ( isTable($tb_bbs_comment . "_" . $bbs_id, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_bbs_comment" . "_" . $bbs_id . ";", $driver); /* 게시판 간단 답변     */ }
                    if ( isTable($tb_bbs_category ."_" . $bbs_id, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_bbs_category". "_" . $bbs_id . ";", $driver); /* 게시판 카테고리      */ }
                }
                simpleSQLExecute("drop table $tb_bbs_infor   ;", $driver); /* 게시판 정보          */
            }

            if ( isTable($tb_bbs_abstract, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_bbs_abstract;", $driver); /* 게시물 추출 정보     */ }
            if ( isTable($tb_bbs_skin    , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_bbs_skin    ;", $driver); /* 게시판 스킨 정보     */ }
            if ( isTable($tb_bbs_grant   , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_bbs_grant   ;", $driver); /* 게시판 사용자별 권한 */ }

            if ( isTable($tb_poll_master  , $db_nm, $driver) ) { 
                $sql  = "select no from $tb_poll_master order by no desc";
                $stmt = multiRowSQLQuery($sql);
                while ( $row = multiRowFetch  ($stmt) ) {
                    $poll_id = $row['no'];
                    if ( isTable($tb_poll_comment . "_" . $poll_id, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_poll_comment" . "_" . $poll_id . ";", $driver); /* 설문 조사 간단 답변  */ }
                }

                simpleSQLExecute("drop table $tb_poll_master  ;", $driver); /* 설문 조사 정보       */
            }

            if ( isTable($tb_poll_item    , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_poll_item    ;", $driver); /* 설문 조사 항목       */ }
            if ( isTable($tb_poll_skin    , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_poll_skin    ;", $driver); /* 설문 조사 스킨       */ }
            if ( isTable($tb_poll_grant   , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_poll_grant   ;", $driver); /* 설문 조사 사용 권한  */ }

            if ( isTable($tb_member       , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_member       ;", $driver); /* 회원 정보            */ }
            if ( isTable($tb_member_kind  , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_member_kind  ;", $driver); /* 회원 종류            */ }
            if ( isTable($tb_member_config, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_member_config;", $driver); /* 회원 가입 폼 설정    */ }

            if ( isTable($tb_post               , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_post            ;", $driver); /* 우편 번호            */ }
            if ( isTable($tb_event              , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_event           ;", $driver); /* 이벤트 정보          */ }
            if ( isTable($tb_event_grant        , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_event_grant     ;", $driver); /* 이벤트 권한          */ }
            if ( isTable($tb_event_item         , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_event_item      ;", $driver); /* 이벤트 항목          */ }
            if ( isTable($tb_point_infor        , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_point_infor     ;", $driver); /* 게시판 포인트 정보   */ }
            if ( isTable($tb_poll_point_infor   , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_poll_point_infor;", $driver); /* 설문 포인트 정보     */ }

            if ( isTable($tb_event_result_master, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_event_result_master;", $driver); /* 이벤트 결과 메인 */ }
            if ( isTable($tb_event_result_detail, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_event_result_detail;", $driver); /* 이벤트 결과 상세 */ }
            if ( isTable($tb_login_abstract     , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_login_abstract     ;", $driver); /* 로그인 추출      */ }

            if ( isTable($tb_dic_member_statistic, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_dic_member_statistic     ;", $driver); /* 회원 통계	*/ }

            closeDBConnection ($driver); // 데이터베이스와의 연결 설정을 해제 합니다.

            if ( file_exists ( 'config.php' ) ) {
                @unlink ('config.php');
            }
            @session_destroy ();

            head("디자인보드 삭제");        // Header 출력
            Message ('U', '0013', 'MOVE:setup.php:이동');
    //      redirectPage ("admin.php"); // 페이지 이동
            footer(); // Footer 출력
        }
    }
}
?>