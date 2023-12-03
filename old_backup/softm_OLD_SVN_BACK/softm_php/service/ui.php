<?
//error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE ( Notice는 제외한 모든에러를 리포팅해라~ )
// @extract($HTTP_ENV_VARS   ); // 환경 변수
@extract($HTTP_GET_VARS     ); // Get  방식의 Parameter 값
@extract($HTTP_POST_VARS    ); // Post 방식의 Parameter 값
@extract($_GET              ); // Get  방식의 Parameter 값
@extract($_POST             ); // Post 방식의 Parameter 값
// @extract($HTTP_SERVER_VARS); // Server 변수

require_once 'lib/common.lib.inc'               ; // 라이브러리
require_once SERVICE_DIR . '/lib/var.define.inc'        ; // 변수
include_once SERVICE_DIR . '/classes/Base.php'          ; // 기본클래스
require_once SERVICE_DIR . '/classes/common/Session.php'; // 세션
include_once SERVICE_DIR . '/classes/common/Util.php'   ; // 유틸리티

if ($_GET['p_hash'] != md5('rlawlgns' . date ("Y-m-d")) ) exit;
$_i = null;
$_l = 0;
// sleep(1);
define("UI_DIR"     , $_REQUEST['p_dir'] );
define("UI_NAME"    , $_REQUEST['p_prg'] );
//ECHO('UI_DIR:' . UI_DIR   .'<BR>' );
//ECHO('UI_NAME:' . UI_NAME .'<BR>' );
if ( UI_DIR && UI_NAME ) {
    if ( file_exists(SERVICE_DIR . '/ui/' . UI_DIR . '/' . strtolower(UI_NAME) . '.php') ) {
        //echo SERVICE_DIR . '/ui/' . UI_DIR . '/' . strtolower(UI_NAME) . '.php';
        include_once SERVICE_DIR . '/ui/' . UI_DIR . '/' . strtolower(UI_NAME) . '.php';
    } else {
        echo "ui.php [ 적용할 ui가 없습니다. "
           . "\n" . SERVICE_DIR . '/ui/' . UI_DIR . '/' . strtolower(UI_NAME) . '.php'
           . " ]";
        //trigger_error("Call to undefined Class {" . SERVICE_DIR . '/ui/' . UI_DIR . '/' . strtolower(UI_NAME) . '.php' . "}", E_USER_ERROR);
    }
} else {
    if ( UI_DIR ) {
        //trigger_error("Undefined UI_DIR : ".UI_DIR, E_USER_ERROR);
    } else if ( UI_NAME ) {
        //trigger_error("Undefined UI_NAME : ".UI_NAME, E_USER_ERROR);
    } else {
        //trigger_error("Call to undefined Method ({".UI_DIR."} instance)->{".UI_NAME."}", E_USER_ERROR);
    }
}
/*
http://phunctional.dahlia.kr/wiki/CookBook/MoreDynamicObject

http://www.eguru.co.kr/entry/%EB%8C%80%EB%8B%A8%ED%95%9C-php-%EB%8F%99%EC%A0%81-%ED%95%A8%EC%88%98-%EC%A0%91%EA%B7%BC-%EB%B0%A9%EB%B2%95%EC%9D%B4%EB%9E%80%EB%8B%A4

http://cafe.naver.com/mobilenjoy.cafe?iframe_url=/ArticleRead.nhn%3Farticleid=2488
php를 이용한 wsdl soap ?? 정보조사 요구
*/
?>
