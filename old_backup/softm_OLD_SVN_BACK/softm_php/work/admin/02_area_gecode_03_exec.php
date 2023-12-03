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
    $encoding = 'UTF-8'; // 로컬
    $encoding = 'EUC-KR'; // 서버

    $sql = " SELECT "
          . " CAP_CD ,"
          . " LCAP_CD,"
          . " DONG_CD,"
          . " CAP_NM ,"
          . " LCAP_NM,"
          . " DONG_NM,"
          . " X1     ,"
          . " Y1     ,"
          . " X2     ,"
          . " Y2      "
          . " FROM  " . TB_AREA_03 . " ";
    $stmt = $db->multiRowSQLQuery ($sql);
    //echo 'sql : ' . $sql . ' /<BR>';
    echo '----------- ----------- ----------- ----- ' . iconv($encoding, 'EUC-KR','동') . ' ------ ----------- ----------- ----------- ' . $nl;
    while ( $rs = $db->multiRowFetch  ($stmt) ) {
        $xDom = $util->getNaverGeocodeToXY(urlencode($rs[CAP_NM] . ' ' . $rs[LCAP_NM] . ' ' . $rs[DONG_NM]));
        if ( $xDom->x ) {
            //echo iconv($encoding, 'EUC-KR','' . $rs[CAP_NM] . ' ' . $rs[LCAP_NM] . ' ' . $rs[DONG_NM]) . ':' . $xDom->x . ' / ' . $xDom->y . '' . $nl;
            echo $rs[CAP_NM] . ' ' . $rs[LCAP_NM] . ' ' . $rs[DONG_NM] . ':' . $xDom->x . ' / ' . $xDom->y . '' . $nl;
            $sql  = "UPDATE " . TB_AREA_03
                  . " SET "
                  . " X1  = '" . $xDom->x . "',"
                  . " Y1  = '" . $xDom->y . "' "
                  . " WHERE CAP_CD  = '" . $rs[CAP_CD ] . "' "
                  . " AND   LCAP_CD = '" . $rs[LCAP_CD] . "' "
                  . " AND   DONG_CD = '" . $rs[DONG_CD] . "' ";
            $db->simpleSQLExecute($sql);
            $sql  = "UPDATE " . TB_AREA_04
                  . " SET "
                  . " X1  = '" . $xDom->x . "',"
                  . " Y1  = '" . $xDom->y . "' "
                  . " WHERE CAP_CD  = '" . $rs[CAP_CD ] . "' "
                  . " AND   LCAP_CD = '" . $rs[LCAP_CD] . "' "
                  . " AND   DONG_CD = '" . $rs[DONG_CD] . "' ";
            $db->simpleSQLExecute($sql);
            //sleep(0.1);
        }
    }
    echo '----------- ----------- ----------- ----- ' . iconv($encoding, 'EUC-KR','동') . ' ------ ----------- ----------- ----------- ' . $nl;
/**/
/*
    $sql = " SELECT "
          . " CAP_CD  ,"
          . " LCAP_CD ,"
          . " DONG_CD ,"
          . " DONG_SEQ,"
          . " CAP_NM  ,"
          . " LCAP_NM ,"
          . " DONG_NM ,"
          . " BUNJI   ,"
          . " POST_NO ,"
          . " X1      ,"
          . " Y1      ,"
          . " X2      ,"
          . " Y2       "
          . " FROM  " . TB_AREA_04 . " ";
    $stmt = $db->multiRowSQLQuery ($sql);
    //echo 'sql : ' . $sql . ' /<BR>';
    echo '----------- ----------- ----------- ----- ' . iconv('UTF-8', 'EUC-KR','상세') . ' ------ ----------- ----------- ----------- ' . $nl;
    while ( $rs = $db->multiRowFetch  ($stmt) ) {
        $xDom = $util->getNaverGeocodeToXY($rs[CAP_NM] . ' ' . $rs[LCAP_NM] . ' ' . $rs[DONG_NM] . ' ' . $rs[BUNJI]);
        if ( $xDom->x ) {
            echo iconv('UTF-8', 'EUC-KR','' . $rs[CAP_NM] . ' ' . $rs[LCAP_NM] . ' ' . $rs[DONG_NM] . ' ' . $rs[BUNJI]) . ':' . $xDom->x . ' / ' . $xDom->y . '' . $nl;
            $sql  = "UPDATE " . TB_AREA_04
                  . " SET "
                  . " X1  = '" . $xDom->x . "',"
                  . " Y1  = '" . $xDom->y . "' "
                  . " WHERE CAP_CD  = '" . $rs[CAP_CD ] . "' "
                  . " AND   LCAP_CD = '" . $rs[LCAP_CD] . "' "
                  . " AND   DONG_CD = '" . $rs[DONG_CD] . "' "
                  . " AND   DONG_SEQ= '" . $rs[DONG_SEQ] . "' ";
            $db->simpleSQLExecute($sql);
            //sleep(0.1);
        }
    }
    echo '----------- ----------- ----------- ----- ' . iconv($encoding, 'EUC-KR','상세') . ' ------ ----------- ----------- ----------- ' . $nl;
*/

    echo '----------- ----------- ----------- ----- ' . iconv($encoding, 'EUC-KR','!!@!@!완료!!@!@!') . ' ------ ----------- ----------- ----------- ' . $nl;
    $db->release();
}
?>
</td>
</table>