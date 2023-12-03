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
if ( $config ) {
    $memInfor = getMemInfor();
    if ( $memInfor['member_level'] == 99 ) {
        set_time_limit ( 0 );
        $isIncDbConn = false; 
        if ( !$db ) {
	        $db = initDBConnection ();
	        $isIncDbConn = true;
        }
        
        if ( PATCH_VERSION < 3.454 ) { //3.454 패치
            $columnType = getColumnType($tb_member, 'password');
            if ( $columnType != 'varchar(41)' ) {
            	$patch_title = "비밀번호/주민번호 테이블 구조 변경";            	
                $patch_msg .= '1. 비밀번호 자리수 증가 20 -> 41'.PHP_EOL;
                simpleSQLExecute('alter table ' . $tb_member . " modify password VARCHAR (41) NOT NULL;"); /* 비밀번호   */
                $patch_msg .= '2. 주민번호 자리수 증가 20 -> 41' .PHP_EOL;
                simpleSQLExecute('alter table ' . $tb_member . " modify jumin    VARCHAR (41)         ;"); /* 주민번호   */
                $patch_execute = true;  

            // set patch version-------------------------------------------------------
                $send_data = array();
                $send_data['base_dir'      ] = $sysInfor["base_dir"  ]     ;
                $send_data['SERVER_NAME'   ] = $_SERVER["SERVER_NAME"]     ;
                $send_data['SERVER_PORT'   ] = $_SERVER["SERVER_PORT"]     ;
                $send_data['SERVER_ADDR'   ] = $_SERVER["SERVER_ADDR"]     ;
                $send_data['DBOARD_VERSION'] = $_dboard_ver_str            ;
                $url  = "http://".DBOARD_DOMAIN."/DBD/rest/set_version.php";
                //$cType = "text/plain";
                //echo urlencode(json_encode($send_data));
                $v = get_url_fsockopen( $url,"v=".urlencode(json_encode($send_data)),$cType );
            // -------------------------------------------------------set patch version
            }
            
            // 마이그레이션 정보.
            //$mig_version = '3.454';
            //$mig_info[]="비밀번호 데이터 변경(암호화 변경에따른 마이그레이션).";
            //$mig_info[]="주민번호 데이터 변경(암호화 변경에따른 마이그레이션).";            
        } 
        
        if ( PATCH_VERSION < 3.458 ) { //3.458 패치
            $sql  = "select no, bbs_id, design_method from $tb_bbs_infor ";
            $stmt = multiRowSQLQuery($sql);
            while ( $row = multiRowFetch  ($stmt) ) {
                $columnType = getColumnType($tb_bbs_data . "_" . $row['bbs_id'], 'password');
                $patch_title = "# 비밀번호 테이블 구조 변경";
                if ( $columnType != 'varchar(41)' ) {
                    $patch_msg .= ' 1. ' . $row['bbs_id']  . '-게시판 비밀번호 자리수 증가 20 -> 41'.PHP_EOL;
                    simpleSQLExecute('alter table ' . $tb_bbs_data      . "_" . $row['bbs_id'] . " modify password VARCHAR (41) ;"); /* 비밀번호   */
                    simpleSQLExecute('alter table ' . $tb_bbs_comment   . "_" . $row['bbs_id'] . " modify password VARCHAR (41) ;"); /* 비밀번호   */
                    $patch_execute = true;  
                }
            }

            $sql  = "select no, title from $tb_poll_master ";
            $stmt = multiRowSQLQuery($sql);
            while ( $row = multiRowFetch  ($stmt) ) {
                $columnType = getColumnType($tb_poll_comment . "_" . $row['no'], 'password');
                if ( $columnType != 'varchar(41)' ) {
                    $patch_msg .= ' 2. ' . $row['title']  . '-설문 비밀번호 자리수 증가 20 -> 41'.PHP_EOL;
                    simpleSQLExecute('alter table ' . $tb_poll_comment . "_" . $row['no'] . " modify password VARCHAR (41)  ;"); /* 비밀번호   */
                    $patch_execute = true;  
                }
            }

            if ( $patch_execute ) {
            // set patch version-------------------------------------------------------
                $send_data = array();
                $send_data['base_dir'      ] = $sysInfor["base_dir"  ]     ;
                $send_data['SERVER_NAME'   ] = $_SERVER["SERVER_NAME"]     ;
                $send_data['SERVER_PORT'   ] = $_SERVER["SERVER_PORT"]     ;
                $send_data['SERVER_ADDR'   ] = $_SERVER["SERVER_ADDR"]     ;
                $send_data['DBOARD_VERSION'] = $_dboard_ver_str            ;
                $url  = "http://".DBOARD_DOMAIN."/DBD/rest/set_version.php";
                //$cType = "text/plain";
                //echo urlencode(json_encode($send_data));
                $v = get_url_fsockopen( $url,"v=".urlencode(json_encode($send_data)),$cType );
            // -------------------------------------------------------set patch version
            }
        }

        if ( $patch_msg ) {
        	$patch_msg .=  '※ 완료되었습니다';
        }
        if ($isIncDbConn) {
        	closeDBConnection ();
        }
    }
}
?>