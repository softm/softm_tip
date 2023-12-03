<?
/*
 Filename        : /master/main_exec.php
 Fuction         : 미디어 정보 실행모듈
 Comment         :
 시작 일자       : 2008-12-08,
 수정 일자       : 2008-12-12, v1.0 first
 작 성 자        : 김지훈
 수 정 자        :
 @version        : 1.0
 @author         : Copyright (c) npec.co.kr. All Rights Reserved.
*/
?>
<?
define ("HOME_DIR" , realpath(dirname(dirname(__FILE__))) );
define ('SERVICE'  , 'COMMON' );
define ('BASE_DIR' , '..' );
define ('SERVICE_DIR', '../service');

require_once SERVICE_DIR . "/common/lib/lib.inc";
require_once SERVICE_DIR . '/common/lib/var_database.inc';
require_once SERVICE_DIR . '/common/lib/database.class.lib';
require_once SERVICE_DIR . "/common/Util.php";
require_once SERVICE_DIR . '/common/Session.php' ; // 변수
$memInfor = Session::getSession();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
if ( $memInfor['login_yn'] == 'N' ) {
    echo ("로그인해주세요.");
} else {
    define('DB_KIND','MYSQL'); // db kind
    $db = new Database();
    $db->getConnect();
    set_time_limit ( 0 );
    $util = new Util();
/* 서버*/
    $load_sql = "LOAD DATA LOCAL INFILE 'C:/Project/11.12_PareLink/source/admin/post_data.csv'"
                . " INTO TABLE tbl_post"
                . " FIELDS TERMINATED BY '|'"
                . " OPTIONALLY ENCLOSED BY '\"'"
                . " LINES TERMINATED BY '\n'"
                . " (ZIPCODE, SIDO, GUGUN, DONG, RI, BUNJI,APT_NAME);";
    $cnt = $db->simpleSQLQuery("SELECT COUNT(*) FROM tbl_post");
    //echo $load_sql;
    if ( $cnt == 0 ) {
        $db->simpleSQLExecute($load_sql);
        echo '우편번호 데이터 로드 ===> ' . TB_POST     . ' <BR>';
    }
/**/
    //F:\WEB_APP\MYSQL50\bin>mysql.exe -u root -p*11admin* < F:\Project\09.03_09.06_homedirect.co.kr\work\20090224_post_data_insert_statment.sql

/* 로컬 
    mysql_query("SET GLOBAL max_allowed_packet =335544320000;" );
    mysql_query("SET SESSION max_allowed_packet =335544320000;");
    mysql_query("SET names utf8;"                              );

    $load_sql  = "INSERT INTO " . TB_POST . ' (ZIPCODE,SIDO,GUGUN,DONG,BUNJI ) VALUES '
              . f_readFile('F:/Project/09.03_09.06_homedirect.co.kr/work/20090224_post_data_insert_statment.csv');
    if ( !$db->simpleSQLExecute($load_sql) ) {
        echo 'ERROR|' . $db->getErrMsg();
    } else {
        echo 'SUCCESS';
    }
*/
    echo '----------- ----------- ----------- ----- ' . iconv('UTF-8', 'EUC-KR','!!@!@!완료!!@!@!') . ' ------ ----------- ----------- ----------- ' . "\n";
    $db->release();
}
?>
</td>
</table>

