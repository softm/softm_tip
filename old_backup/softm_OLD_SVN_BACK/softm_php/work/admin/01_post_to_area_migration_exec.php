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
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
//$memInfor = getMemInfor();
define('DB_KIND','MYSQL'); // db kind
$db = new Database();
$db->getConnect();
/*
select * from hd_area_01;
select * from hd_area_02;
select * from hd_area_03;
select * from hd_area_04;

delete from hd_area_01;delete from hd_area_02;delete from hd_area_03;delete from hd_area_04;

*/
/*
delete from hd_post;

delete from hd_area_01;
delete from hd_area_02;
delete from hd_area_03;
delete from hd_area_04;

drop table hd_area_01;
drop table hd_area_02;
drop table hd_area_03;
drop table hd_area_04;

select * from hd_area_01;
select * from hd_area_02;
select * from hd_area_03;
select * from hd_area_04;

delete from hd_area_01;delete from hd_area_02;delete from hd_area_03;delete from hd_area_04;

*/

//if ( $memInfor['login_yn'] == 'N' ) {
//    Msg ("U", "", "로그인해주세요.", "", '');
//} else {
    set_time_limit ( 0 );
    $util = new Util();

        $sql1 = " SELECT distinct SIDO from " . TB_POST. " order by substring(ZIPCODE,1,1)";
        $post1_key = 1;
        $post2_key = 1;
        $post3_key = 1;
        $post4_key = 1;
        $stmt1 = $db->multiRowSQLQuery ($sql1);
        while ( $rs1 = $db->multiRowFetch  ($stmt1) ) {
//          simpleSQLExecute($sql);
            echo $post1_key . '. 도시 : ' . $rs1[SIDO] . '<BR>';
            $sql  = "INSERT INTO " . TB_AREA_01 . " (CAP_CD,CAP_NM)  VALUES ('" . sprintf("%02d", $post1_key) . "', '" . $rs1[SIDO] . "')";
            $db->simpleSQLExecute($sql);

            $sql2 = " SELECT distinct GUGUN from " . TB_POST. " where SIDO = '" . $rs1[SIDO] . "' order by GUGUN";

            $stmt2 = $db->multiRowSQLQuery ($sql2);
            echo '&nbsp;&nbsp;&nbsp;&nbsp;시군구 <BR>';
            $post2_key = 1;
            while ( $rs2 = $db->multiRowFetch  ($stmt2) ) {
                echo '&nbsp;&nbsp;&nbsp;&nbsp;' . $post2_key . '. : ' . $rs2[GUGUN] . '<BR>';

                $sql  = "INSERT INTO " . TB_AREA_02 . " (CAP_CD,LCAP_CD,CAP_NM,LCAP_NM)  VALUES ('" . sprintf("%02d", $post1_key) . "', '" . sprintf("%03d", $post2_key) . "', '" . $rs1[SIDO] . "', '" . $rs2[GUGUN] . "')";
//echo 'sql : ' . $sql . ' /<BR>';
                $db->simpleSQLExecute($sql);
//echo 'sql : ' . $sql . ' /<BR>';
//exit;
                $sql3 = " SELECT distinct CONCAT(DONG,' ',RI) DONG from " . TB_POST. " where SIDO = '" . $rs1[SIDO] . "' and GUGUN = '" . $rs2[GUGUN] . "' order by DONG";
                $stmt3 = $db->multiRowSQLQuery ($sql3);
                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;읍면동<BR>';
                $post3_key = 1;
                while ( $rs3 = $db->multiRowFetch  ($stmt3) ) {
                    $sql  = "INSERT INTO " . TB_AREA_03 . " (CAP_CD  ,LCAP_CD ,DONG_CD , CAP_NM, LCAP_NM, DONG_NM) "
                          . " VALUES ("
                          . "'" . sprintf("%02d", $post1_key) . "', '" . sprintf("%03d", $post2_key) . "',  '" . sprintf("%03d", $post3_key) . "', '" . $rs1[SIDO] . "', '" . $rs2[GUGUN] . "', '" . $rs3[DONG] . "')";

                    $db->simpleSQLExecute($sql);
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $post3_key . '. : ' . $rs3[DONG] . '<BR>';

                    $sql4 = " SELECT BUNJI, APT_NAME, ZIPCODE from " . TB_POST. " where SIDO = '" . $rs1[SIDO] . "' and GUGUN = '" . $rs2[GUGUN] . "' and DONG = '" . $rs3[DONG] . "' order by dong";
                    $stmt4 = $db->multiRowSQLQuery ($sql4);
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;세부주소 <BR>';
                    $post4_key=1;
                    while ( $rs4 = $db->multiRowFetch  ($stmt4) ) {
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $post4_key . '. : ' . $rs3[DONG] . $rs4[BUNJI] . $rs4[APT_NAME] .'<BR>';
                        $sql  = "INSERT INTO " . TB_AREA_04;
                        $sql .= " ( ";
                        $sql .= " CAP_CD    ,LCAP_CD    ,DONG_CD    ,DONG_SEQ,";
                        $sql .= " CAP_NM    ,LCAP_NM    ,DONG_NM    ,";
                        $sql .= " BUNJI     ,APT_NAME   ,POST_NO     ";
                        $sql .= " ) ";
                        $sql .= " VALUES ";
                        $sql .= " (";
                        $sql .= " '" . sprintf("%02d", $post1_key) . "', '" . sprintf("%03d", $post2_key) . "', '" . sprintf("%03d", $post3_key) . "', '" . sprintf("%04d", $post4_key) . "',";
                        $sql .= " '" . $rs1[SIDO    ] . "', '" . $rs2[GUGUN      ] . "', '" . $rs3[DONG   ] . "',";
                        $sql .= " '" . $rs4[BUNJI] . "', '" . $rs4[APT_NAME] . "', '" . substr($rs4[ZIPCODE],0,3) . substr($rs4[ZIPCODE],4,3) . "'";
                        $sql .= " )";

                        $db->simpleSQLExecute($sql);
                        $post4_key++; // 키값4
                    }
                    $post3_key++; // 키값3
                }
                $post2_key++; // 키값2
            }
            $post1_key++; // 키값1
        }
echo 'post4_key : ' . $post4_key;
/*
01  서울
02  강원
03  충남
04  충북
05  대전
06  인천
07  경기
08  전남
09  전북
10  광주
11  제주
12  부산
13  울산
14  경남
15  경북
16  대구
*/
//    $sql  = "INSERT INTO $tb_post_02 (CAP_CD     ,LCAP_CD     ,LCAP_NM) SELECT distinct '01', substring(zipcode,1,3), gugun from post where SIDO = '서울' order by zipcode";
//    simpleSQLExecute($sql);

    // echo ' exec: ' . $exec . '<BR>';
$db->release();
//}
?>
</td>
</table>