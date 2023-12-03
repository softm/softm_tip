<?
$baseDir = '../../../';
include $baseDir . 'common/board_lib.inc';  // 게시판 라이브러리
include $baseDir . 'common/member_lib.inc'; // 멤버 라이브러리
include $baseDir . 'common/lib.inc'    ; // 공통 라이브러리
include $baseDir . 'common/message.inc'; // 에러 페이지 처리
include $baseDir . 'common/file.inc'   ; // 파일

$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음

if ( $memInfor['admin_yn'] == "Y" ) {
    @set_time_limit ( 0 );

// ⓘ : 게시판 설정
// ⓓ : 게시판
// ⓨ : 게시판 카테고리
// ⓒ : 게시판 의견글
// ⓖ : 게시판 권한
// ⓟ : 게시판 포인트
// ⓜ : 회원
// ⓚ : 회원 종류
// │ : 데이터 시작
// ┟ : 필드 구분자
// ┩ : 자료 하나의 끝
    if ( $gubun == 'bbs_back_up' ) { // 게시판 백업
        include ( $baseDir . 'common/db_connect.inc'   ); // Data Base 연결 클래스
        // 데이터베이스에 접속합니다.
        $db = initDBConnection ();
        $sql  = "select bbs_id from $tb_bbs_infor where no = '$no'";
        $bbs_id = simpleSQLQuery($sql);
        downHeader('', 'DBD_'.str_pad($no, 4, "0", STR_PAD_LEFT).'_bbs_' . $bbs_id  . '_' . getYearToSecond() . '.sql');
        ob_start();
        echo "##D'B'O'A'R'D'_ID_START". "##\r\n";
        echo $bbs_id . "\r\n";
        echo "##D'B'O'A'R'D'_ID_END". "##\r\n";

        getTableFieldOrder ($tb_bbs_infor,"where bbs_id = '$bbs_id'");
        echo "##D'B'O'A'R'D'_INFOR_START". "##\r\n";
        getData ($tb_bbs_infor, "where bbs_id = '$bbs_id'", 'ⓘ');
        echo "##D'B'O'A'R'D'_INFOR_END". "##\r\n";

        getTableFieldOrder ($tb_bbs_data     . '_' . $bbs_id);
        echo "##D'B'O'A'R'D'_BBS_DATA_START"   . "##\r\n";
        getData ($tb_bbs_data     . '_' . $bbs_id, '', 'ⓓ');
        echo "##D'B'O'A'R'D'_BBS_DATA_END"     . "##\r\n";

        getTableFieldOrder ($tb_bbs_category   . '_' . $bbs_id);
        echo "##D'B'O'A'R'D'_BBS_CATEGORY_START"   . "##\r\n";
        getData ($tb_bbs_category   . '_' . $bbs_id, '', 'ⓨ');
        echo "##D'B'O'A'R'D'_BBS_CATEGORY_END"     . "##\r\n";


        echo "##D'B'O'A'R'D'_BBS_COMMENT"   . "##\r\n";
        getTableFieldOrder ($tb_bbs_comment  . '_' . $bbs_id);
        echo "##D'B'O'A'R'D'_BBS_COMMENT_START"   . "##\r\n";
        getData ($tb_bbs_comment  . '_' . $bbs_id, '', 'ⓒ');
        echo "##D'B'O'A'R'D'_BBS_COMMENT_END"     . "##\r\n";

        echo "##D'B'O'A'R'D'_BBS_POINT"   . "##\r\n";
        getTableFieldOrder ($tb_point_infor,"where bbs_id = '$bbs_id'");
        echo "##D'B'O'A'R'D'_BBS_POINT_START"   . "##\r\n";
        getData ($tb_point_infor,"where bbs_id = '$bbs_id'",'ⓟ');
        echo "##D'B'O'A'R'D'_BBS_POINT_END"     . "##\r\n";

        echo "##D'B'O'A'R'D'_BBS_GRANT"   . "##\r\n";
        getTableFieldOrder ($tb_bbs_grant,"where bbs_id = '$bbs_id'");
        echo "##D'B'O'A'R'D'_BBS_GRANT_START"   . "##\r\n";
        getData ($tb_bbs_grant,"where bbs_id = '$bbs_id'",'ⓖ');
        echo "##D'B'O'A'R'D'_BBS_GRANT_END"     . "##\r\n";

        echo "##D'B'O'A'R'D'_BBS_HEADER_START##"     . "##\r\n";
        echo f_readFile( $baseDir . "data/html/_dboard_header_"  . $bbs_id . ".php");
        echo "##D'B'O'A'R'D'_BBS_HEADER_END##"       . "##\r\n";

        echo "##D'B'O'A'R'D'_BBS_FOOTER_START##"     . "##\r\n";
        echo f_readFile( $baseDir . "data/html/_dboard_footer_"  . $bbs_id . ".php");
        echo "##D'B'O'A'R'D'_BBS_FOOTER_END##"       . "##\r\n";

        echo "##D'B'O'A'R'D'_BBS_NOTICE_HEADER_START##"     . "##\r\n";
        echo f_readFile( $baseDir . "data/html/_dnotice_header_" . $bbs_id . ".php");
        echo "##D'B'O'A'R'D'_BBS_NOTICE_HEADER_END##"       . "##\r\n";

        echo "##D'B'O'A'R'D'_BBS_NOTICE_FOOTER_START##"     . "##\r\n";
        echo f_readFile( $baseDir . "data/html/_dnotice_footer_" . $bbs_id . ".php");
        echo "##D'B'O'A'R'D'_BBS_NOTICE_FOOTER_END##"       . "##\r\n";

        ob_end_flush();

        closeDBConnection (); // 데이터베이스 연결 설정 해제
    } else if ( $gubun == 'member_back_up' ) { // 회원 백업
        include ( $baseDir . 'common/db_connect.inc'   ); // Data Base 연결 클래스
        // 데이터베이스에 접속합니다.
        $db = initDBConnection ();
        downHeader('', 'DBD_member_' . getYearToSecond() . '.sql');
        ob_start();

        getTableFieldOrder ($tb_member     );
        echo "##D'B'O'A'R'D'_MEMBER_START"  . "##\r\n";
        getData      ($tb_member     ,"where member_level != 0 and user_id !=''", 'ⓜ');
        echo "##D'B'O'A'R'D'_MEMBER_END"    . "##\r\n";

        getTableFieldOrder ($tb_member_kind);
        echo "##D'B'O'A'R'D'_MEMBER_KIND_START"   . "##\r\n";
        getData      ($tb_member_kind,'where member_level != 0 and member_level != 1 and member_level != 99', 'ⓚ');
        echo "##D'B'O'A'R'D'_MEMBER_KIND_END"     . "##\r\n";

        ob_end_flush();
        closeDBConnection (); // 데이터베이스 연결 설정 해제
    }
}
    function getTableFieldOrder ($tableName) {
        $stmt = multiRowSQLQuery("show fields from $tableName;");
        $_rtn = '';
        while ( $row = multiRowFetch  ($stmt) ) {
            $field   = $row['Field'   ];
            $_rtn .= 'ⓓ' . $field;
        }
        $_rtn = $_rtn . 'ⓓ';
        echo "##" . $tableName . "_FIELD_ORDER_START##" . "\r\n";
        echo $_rtn . "\r\n";
        echo "##" . $tableName . "_FIELD_ORDER_END##";
    }

    function getTableFields ($tableName) {
        $field_schema = '';
        $stmt = multiRowSQLQuery("show fields from $tableName;");
        while ( $row = multiRowFetch  ($stmt) ) {
            $field   = $row['Field'   ];
            $type    = $row['Type'    ];
            $null    = $row['Null'    ];
            $key     = $row['Key'     ];
            $default = $row['Default' ];
            $extra   = $row['Extra'   ];
            $null    = ( $null    == 'YES' ) ? ""                           : " not null" ;
//          $key     = ( $key     == 'PRI' ) ? "primary key"                : ""          ;
            if ( $key == 'PRI' || $key == 'MUL' ) $key = "";
            $default = ( $default          ) ? "default '" . $default . "'" : ""          ;
            $field_schema .= $field  . ' ' . $type   . ' ' . $null   . ' ' . $default. ' ' . $extra  . ' ' . $key . ",\r\n";
        }
        $field_schema = preg_replace("/,\r\n$/", "", $field_schema);
        //$field_schema = preg_replace("/,\r\n$/", "", $field_schema); // 5.3지원
        return $field_schema;
    }

    function getTableKeys ($tableName) {
        $stmt = multiRowSQLQuery("show keys from $tableName;");
        while ( $row = multiRowFetch  ($stmt) ) {
            $key_name    = $row['Key_name'    ];
            //Non_unique | Key_name | Seq_in_index | Column_name
            //-----------+----------+--------------+-------------
            //         0 | PRIMARY  |            1 | no           == > Primary Key
            //         0 | 111111   |            1 | ip           == > Unique  Key
            //         1 | sss      |            1 | ip           == > Index   Key ( ip, comment_date
            //         1 | sss      |            2 | comment_date
            $non_unique  = $row['Non_unique'  ];
            $column_name = $row['Column_name' ];
            if(!is_array($index[$key_name])){
                $index[$key_name] = array();
            }
            $index [$key_name][] = $column_name;
            $noUniq[$key_name]   = $non_unique ;

        }
        $key_schema = '';
        while(list($key_name, $columns) = @each($index)) {
            if($key_name == "PRIMARY") {
                $key_schema .= " PRIMARY KEY (" . implode($columns, ", ") . "),\r\n";
            } else {
                $non_unique = $noUniq[$key_name];
                if ( $non_unique == '0' ) {
                    $key_schema .= " UNIQUE $key_name (" . implode($columns, ", ") . "),\r\n";
                } else {
                    $key_schema .= " KEY $key_name (" . implode($columns, ", ") . "),\r\n";
                }
            }
        }
        $key_schema = preg_replace("/,\r\n$/", "", $key_schema);
        //$key_schema = preg_replace("/,\r\n$/", "", $key_schema); // 5.3지원
        return $key_schema;
    }

    function getInsertData ($tableName,$where='') {
        $stmt = multiRowSQLQuery("show fields from $tableName;");

        while ( $row = multiRowFetch  ($stmt) ) {
            $field .= $row["Field"].",";
        }
        $field = substr($field,0,strlen($field)-1);
        $field_array = explode(",",$field);
        $field_count = count($field_array);

        $stmt = multiRowSQLQuery("select $field from $tableName ". $where . ";");

        while ( $row = multiRowFetch  ($stmt) ) {
            $str = '';
            for($i=0;$i<$field_count;$i++) {
                $str .= " '".addslashes(stripslashes($row[$field_array[$i]]))."',";
            }
            $str = substr($str,0,strlen($str)-1);
            echo "INSERT INTO ".$tableName." VALUES (".$str.");";
            print "\r\n";
            flush();
        }
    }


    function getData ($tableName,$where='',$sep) {
        $stmt = multiRowSQLQuery("show fields from $tableName;");

        while ( $row = multiRowFetch  ($stmt) ) {
            $field .= $row["Field"] . ",";
        }
        $field = substr($field,0,strlen($field)-1);
        $field_array = explode(",",$field);
        $field_count = count($field_array);

        $stmt = multiRowSQLQuery("select $field from $tableName ". $where . ";");

        while ( $row = multiRowFetch  ($stmt) ) {
            $str = '';
            for($i=0;$i<$field_count;$i++) {
//              $str .= $row[$field_array[$i]];
                $val = str_replace("\\","\\\\",$row[$field_array[$i]]);
                $val = str_replace("'" ,"\'"  ,$val);
                $str .= $val . $sep . '┟';
            }
//          $str = substr($str,0,strlen($str)-2);
            echo $sep . '│' . $str . $sep . '┩' . "\r\n";
            flush();
        }
    }


?>