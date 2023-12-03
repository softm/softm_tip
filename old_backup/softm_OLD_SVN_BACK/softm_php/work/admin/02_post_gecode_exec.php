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

require_once HOME_DIR . '/inc/lib.inc';
require_once HOME_DIR . '/inc/var.inc';
require_once HOME_DIR . '/inc/var_database.inc';
require_once HOME_DIR . '/inc/DB.php' ;
require_once SERVICE_DIR . '/common/Util.php';
require_once SERVICE_DIR . '/common/Session.php' ; // 변수
$memInfor = Session::getSession();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
if ( $memInfor[admin_yn] == 'N' ) {
    Msg ("U", "", "로그인해주세요.", "", '');
} else {
    $db = new DB();
    $db->getConnect();

    set_time_limit ( 0 );
    $nl = "<BR>\n";
    $util = new Util();
        $sql = " SELECT "
              . " POST_SEQ,"
              . " ZIPCODE ,"
              . " SIDO    ,"
              . " GUGUN   ,"
              . " DONG    ,"
              . " BUNJI   ,"
              . " X1      ,"
              . " Y1      ,"
              . " X2      ,"
              . " Y2       "
              . " FROM " . TB_POST
              . " GROUP BY SIDO";

        $sql = " SELECT "
              . " SIDO"
              . " FROM " . TB_POST
              . " GROUP BY SIDO";
        $stmt = $db->multiRowSQLQuery ($sql);
        echo 'sql : ' . $sql . ' /<BR>';
        echo '----------- ----------- ----------- ----- ' . iconv('UTF-8', 'EUC-KR','시') . ' ------ ----------- ----------- ----------- ' . $nl;
        while ( $rs = $db->multiRowFetch  ($stmt) ) {
            $xDom = $util->getNaverGeocodeToXY(urlencode($rs[SIDO]));
            if ( $xDom->x ) {
                //echo iconv('UTF-8', 'EUC-KR','' . $rs[SIDO] ) . ':' . $xDom->x . ' / ' . $xDom->y . '' . $nl;
                echo $rs[SIDO] . ':' . $xDom->x . ' / ' . $xDom->y . '' . $nl;
                $sql  = "UPDATE " . TB_POST
                      . " SET "
                      . " X1  = '" . $xDom->x . "',"
                      . " Y1  = '" . $xDom->y . "' "
                      . " WHERE SIDO = '" . $rs[SIDO] . "' ";
                $db->simpleSQLExecute($sql);
                //sleep(0.1);
            }
        }
        echo '----------- ----------- ----------- ----- ' . iconv('UTF-8', 'EUC-KR','시') . ' ------ ----------- ----------- ----------- ' . $nl;

        $sql = " SELECT "
              . " SIDO ,"
              . " GUGUN "
              . " FROM " . TB_POST
              . " GROUP BY SIDO, GUGUN";
        $stmt = $db->multiRowSQLQuery ($sql);
        echo '----------- ----------- ----------- ----- ' . iconv('UTF-8', 'EUC-KR','구/군') . ' ------ ----------- ----------- ----------- ' . $nl;
        while ( $rs = $db->multiRowFetch  ($stmt) ) {
            $xDom = $util->getNaverGeocodeToXY(urlencode($rs[SIDO] . ' ' . $rs[GUGUN]));
            if ( $xDom->x ) {
                //echo iconv('UTF-8', 'EUC-KR','' . $rs[SIDO] . ' ' . $rs[GUGUN] ) . ':' . $xDom->x . ' / ' . $xDom->y . '' . $nl;
                echo $rs[SIDO] . ' ' . $rs[GUGUN] . ':' . $xDom->x . ' / ' . $xDom->y . '' . $nl;
                $sql  = "UPDATE " . TB_POST
                      . " SET "
                      . " X1  = '" . $xDom->x . "',"
                      . " Y1  = '" . $xDom->y . "' "
                      . " WHERE SIDO  = '" . $rs[SIDO ] . "' "
                      . " AND   GUGUN = '" . $rs[GUGUN] . "' ";
                $db->simpleSQLExecute($sql);
                //sleep(0.3);
            }
        }
        echo '----------- ----------- ----------- ----- ' . iconv('UTF-8', 'EUC-KR','구/군') . ' ------ ----------- ----------- ----------- ' . $nl;

        $sql = " SELECT "
              . " SIDO ,"
              . " GUGUN,"
              . " DONG  "
              . " FROM " . TB_POST
              . " GROUP BY SIDO, GUGUN, DONG";
        $stmt = $db->multiRowSQLQuery ($sql);
        echo '----------- ----------- ----------- ----- ' . iconv('UTF-8', 'EUC-KR','동') . ' ------ ----------- ----------- ----------- ' . $nl;
        while ( $rs = $db->multiRowFetch  ($stmt) ) {
            $xDom = $util->getNaverGeocodeToXY(urlencode($rs[SIDO] . ' ' . $rs[GUGUN] . ' ' . $rs[DONG]));
            if ( $xDom->x ) {
                //echo iconv('UTF-8', 'EUC-KR','' . $rs[SIDO] . ' ' . $rs[GUGUN] . ' ' . $rs[DONG] ) . ':' . $xDom->x . ' / ' . $xDom->y . '' . $nl;
                echo $rs[SIDO] . ' ' . $rs[GUGUN] . ' ' . $rs[DONG] . ':' . $xDom->x . ' / ' . $xDom->y . '' . $nl;
                $sql  = "UPDATE " . TB_POST
                      . " SET "
                      . " X1  = '" . $xDom->x . "',"
                      . " Y1  = '" . $xDom->y . "' "
                      . " WHERE SIDO  = '" . $rs[SIDO ] . "' "
                      . " AND   GUGUN = '" . $rs[GUGUN] . "' "
                      . " AND   DONG  = '" . $rs[DONG ] . "' ";
                $db->simpleSQLExecute($sql);
                //sleep(0.3);
            }
        }
        echo '----------- ----------- ----------- ----- ' . iconv('UTF-8', 'EUC-KR','동') . ' ------ ----------- ----------- ----------- ' . $nl;
/*
        $sql = " SELECT "
              . " SIDO ,"
              . " GUGUN,"
              . " DONG ,"
              . " BUNJI,"
              . " POST_SEQ   "
              . " FROM " . TB_POST;
        $stmt = $db->multiRowSQLQuery ($sql);
        echo '----------- ----------- ----------- ----- ' . iconv('UTF-8', 'EUC-KR','상세') . ' ------ ----------- ----------- ----------- ' . $nl;
        while ( $rs = $db->multiRowFetch  ($stmt) ) {
            $xDom = $util->getNaverGeocodeToXY($rs[SIDO] . ' ' . $rs[GUGUN] . ' ' . $rs[DONG] . ' ' . $rs[BUNJI]);
            if ( $xDom->x ) {
                echo iconv('UTF-8', 'EUC-KR','' . $rs[SIDO] . ' ' . $rs[GUGUN] . ' ' . $rs[DONG] . ' ' . $rs[BUNJI] ) . ':' . $xDom->x . ' / ' . $xDom->y . '' . $nl;
                $sql  = "UPDATE " . TB_POST
                      . " SET "
                      . " X1  = '" . $xDom->x . "',"
                      . " Y1  = '" . $xDom->y . "' "
                      . " WHERE POST_SEQ   = '" . $rs[POST_SEQ ] . "' ";
                $db->simpleSQLExecute($sql);
                //sleep(0.3);
            }
        }
        echo '----------- ----------- ----------- ----- ' . iconv('UTF-8', 'EUC-KR','상세') . ' ------ ----------- ----------- ----------- ' . $nl;
*/
        echo '----------- ----------- ----------- ----- ' . iconv('UTF-8', 'EUC-KR','!!@!@!완료!!@!@!') . ' ------ ----------- ----------- ----------- ' . $nl;
    $db->release();
}
?>
</td>
</table>