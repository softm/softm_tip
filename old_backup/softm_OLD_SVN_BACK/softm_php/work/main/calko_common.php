<?
/*
 Filename       : /calko/calko_common.php
 Fuction        : calko관련 공통 php
 Comment        :
 Make   Date    : 2010-02-08,
 Update Date    : 2010-03-04, v1.0 first
 Writer         : 김지훈
 Updater        :
 @version       : 1.0
*/
?>
<?php
define ("HOME_DIR" , realpath(dirname(dirname(__FILE__))) );
define ('SERVICE'  , 'CALKO' );
define ('BASE_DIR' , '..' );
define ('SERVICE_DIR', '../service');

require_once '../inc/calko.lib'   ; // calko.lib

require_once SERVICE_DIR . '/common/lib/lib.inc'                      ; // standard lib
require_once SERVICE_DIR . '/common/lib/page_tab.lib'                 ; // page navigation
require_once SERVICE_DIR . '/common/lib/DB.php'                       ; // DB
require_once SERVICE_DIR . '/common/lib/class.inputfilter_clean.php'  ; // 필터
require_once SERVICE_DIR . '/common/lib/form.inc'                     ; // form

require_once SERVICE_DIR . '/common/Session.php';
$memInfor = Session::getSession();
$op = strtolower(trim($_REQUEST["op"])) ;
$op = !$op?'default':$op                ;   // Process parameter [display, save]
$db = new DB (); // db instance

if ( $memInfor['login_yn'] != 'Y' ) {
    redirectPage( "/" );
} else {
if ( $op == "get_country_json") { // 국가코드 json
    $db->getConnect();

    $sql = "SELECT \n"
         . "  COUNTRY_CODE      , \n"
         . "  COUNTRY_EN_NAME   , \n"
         . "  COUNTRY_KR_NAME   , \n"
         . "  DESTINATION       , \n"
         . "  SOLD_TO_PARTY       \n"
         . " FROM tbl_calko_country \n"
         . " WHERE SOLD_TO_PARTY <> '' \n"
         . " ORDER BY COUNTRY_EN_NAME, DESTINATION"
    ;
    $country = array();
    $destination = array();
    $stmt = $db->multiRowSQLQuery($sql);

    $tmpStr = '';
    $pre_country_code = '';
    $json = array();
    $iIdx = 0;
    while ($r = $db->multiRowFetch($stmt)) {
        $country_code    = $r->COUNTRY_CODE   ;
        $country_en_code = $r->COUNTRY_EN_NAME;
        $country_kr_code = $r->COUNTRY_KR_NAME;
        $destination     = $r->DESTINATION;
        $sold_to_party   = $r->SOLD_TO_PARTY;
        $countrys[$country_code] = $country_en_code;
        $destinations[$country_code . '-' . $destination .'-' . $sold_to_party] = $destination;

        if ( $tmpStr && $pre_country_code != $r->COUNTRY_CODE ) {
            $tmpStr .= ']' . "\n";
            $json[] = $tmpStr;
            $tmpStr  = '';
            $iIdx = 0;
        }
        if ( $pre_country_code != $r->COUNTRY_CODE ) {
            $tmpStr = $r->COUNTRY_CODE . ':[';
        }
        $pre_country_code    = $r->COUNTRY_CODE   ;

        $tmpStr .= ($iIdx>0?',':'') . '{' . 'country_code:"' . $country_code . '",country_en_code:"' . $country_en_code . '",country_kr_code:"' . $country_kr_code . '",destination:"' . $destination . '",sold_to_party:"' . $sold_to_party . '"}';
        $iIdx++;
        if ( $country_code == 'XX' ) {
            //echo $country_code . '-' . $destination .'-' . $sold_to_party;
            //var_dump ( $destinations[$country_code . '-' . $destination .'-' . $sold_to_party] );
        }
    }

    if ( $tmpStr ) {
        $tmpStr .= ']' . "\n";
        $json[] = $tmpStr;
    }
    print ( 'destGory  = {' . implode ( ',', $json) . '};' );
    $db->release();
} // end if [op=="get_country_json"]
}