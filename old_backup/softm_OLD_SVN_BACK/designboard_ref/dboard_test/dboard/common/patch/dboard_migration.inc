<?
include_once ( 'common/lib.inc'          ); // 공통 라이브러리
include_once ( 'common/message.inc'      ); // 에러 페이지 처리
include_once ( 'common/db_connect.inc'   ); // Data Base 연결 클래스
include_once ( 'common/_service.inc'     ); // 서비스 화면 관련
include_once ( 'common/file.inc'         ); // 파일 시스템 관련
include_once ( 'common/lib/var/table.inc'); // 테이블 정보 설정

$patch_execute = false;
$patch_title   = "";
$patch_msg     = "";
$mig_version = 0; // 마이그레이션 여부. 사이트의 버전보다 마이그레이션버전이 작으면을 마이그레이션 실행.
$mig_info    = array();
$is_db_schema_update = true; // DB업데이트여부.(false이면 designboard.net의 디비와 싱크한다.)

if ( $config ) {
    $memInfor = getMemInfor();
    if ( $memInfor['member_level'] == 99 ) {
        set_time_limit ( 0 );
        $isIncDbConn = false; 
        if ( !$db ) {
	        $db = initDBConnection ();
	        $isIncDbConn = true;
        }
        
        if ( MIG_VERSION ==  0.001 ) { // 디비스키마 최신화.
        	$is_db_schema_update = false;
        } 
        
        if ($isIncDbConn) {
        	closeDBConnection ();
        }
    }
}

/**
 * DB업데이트여부.(false이면 designboard.net의 디비와 싱크한다.)
 */
define(IS_DB_SCHEMA_UPDATE,$is_db_schema_update);
?>