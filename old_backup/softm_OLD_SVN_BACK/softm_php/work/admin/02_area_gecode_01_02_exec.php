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
if ( $memInfor[user_level] != 'A' ) {
    echo("로그인해주세요.");
} else {
    define('DB_KIND','MYSQL'); // db kind
    $db = new Database();
    $db->getConnect();

    set_time_limit ( 0 );
    $nl = "<BR>\n";
    $util = new Util();
    $encoding = 'UTF-8'; // 로컬
    $encoding = 'EUC-KR'; // 서버
    $sql = " SELECT "
          . " CAP_CD, CAP_NM, X1, Y1, X2, Y2"
          . " FROM " . TB_AREA_01;
    $stmt = $db->multiRowSQLQuery ($sql);
    //echo 'sql : ' . $sql . ' /<BR>';
    echo '----------- ----------- ----------- ----- ' . iconv($encoding, 'EUC-KR','시') . ' ------ ----------- ----------- ----------- ' . $nl;
    while ( $rs = $db->multiRowFetch  ($stmt) ) {
        $xDom = $util->getNaverGeocodeToXY(urlencode($rs[CAP_NM]));
        if ( $xDom->x ) {
            //echo iconv('UTF-8', 'EUC-KR','' . $rs[CAP_NM] ) . ':' . $xDom->x . ' / ' . $xDom->y . '' . $nl;
            echo $rs[CAP_NM] . ':' . $xDom->x . ' / ' . $xDom->y . '' . $nl;
            $sql  = "UPDATE " . TB_AREA_01
                  . " SET "
                  . " X1  = '" . $xDom->x . "',"
                  . " Y1  = '" . $xDom->y . "' "
                  . " WHERE CAP_CD = '" . $rs[CAP_CD] . "' ";
            $db->simpleSQLExecute($sql);

        }
    }
    echo '----------- ----------- ----------- ----- ' . iconv($encoding, 'EUC-KR','시') . ' ------ ----------- ----------- ----------- ' . $nl;

    echo '----------- ----------- ----------- ----- ' . iconv($encoding, 'EUC-KR','!!@!@!완료!!@!@!') . ' ------ ----------- ----------- ----------- ' . $nl;
    $db->release();
}
?>
</td>
</table>