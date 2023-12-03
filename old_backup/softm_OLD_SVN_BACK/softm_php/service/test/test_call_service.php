<?
define ('HOME_DIR'   , realpath(dirname(dirname(__FILE__))) );
define ('SERVICE_DIR', realpath(dirname(__FILE__))          );

//error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE ( Notice는 제외한 모든에러를 리포팅해라~ )
@extract($HTTP_ENV_VARS   ); // 환경 변수
@extract($HTTP_GET_VARS   ); // Get  방식의 Parameter 값
@extract($HTTP_POST_VARS  ); // Post 방식의 Parameter 값
@extract($HTTP_SERVER_VARS); // Server 변수

if ($p_hash != md5('xltpszmfnvm' . date ("Y-m-d")) ) exit;
$_i = null;
$_l = 0;
//var_dump( $GLOBALS['HTTP_RAW_POST_DATA'] );

require_once SERVICE_DIR . '/common/lib/lib.inc' ; // 라이브러리
require_once SERVICE_DIR . '/common/lib/var.inc' ; // 변수

$v = $HTTP_GET_VARS;
$_cInfo= null;
//echo '$v : ' . $v;
//print_r($HTTP_GET_VARS);

foreach ($HTTP_GET_VARS as $key => $value) {
    //echo "Key: $key; Value: $value<br>\n";
    if ( $key != "p_classname" && $key != "p_method" ) {
        $v[argus][$key] = urldecode($value);
    }
    if ( $key == "p_classname" || $key == "p_method" ) {
        $_cInfo= explode ('.', $p_classname);
    }
}
//print_r($v[argus]);
if ( $v ) {
    define ('SERVICE', $v[service]);

    $_l = sizeof($_cInfo);
    if ( $_l > 1 ) {
        //echo '$v[className]) : ' . $v[className] . '<BR>';
        //echo '$v[argus]) : ' . $v[argus] . ' 크기 : ' . sizeof( $v[argus] ) . '<BR>';
        define("METHOD"     , $p_method);
        define("CLASS_POS"  , join('/',array_slice($_cInfo, 0, -1)));
        define("CLASS_NAME" , $_cInfo[$_l-1]  );
        define("UI_DIR"     , SERVICE_DIR . '/ui/' . CLASS_POS . '/' . strtolower(CLASS_NAME));

        //echo 'UI_DIR : ' . UI_DIR . '<BR>';
        //echo 'CLASS_POS : ' . CLASS_POS . '<BR>';
        //echo 'CLASS_NAME : '.  CLASS_NAME . '<br>';

        include_once SERVICE_DIR . '/' . CLASS_POS . '/' . CLASS_NAME . '.php';
        //echo SERVICE_DIR . '/' . CLASS_POS . '/' . CLASS_NAME . '.php';

        $_class  = CLASS_NAME;
        if ( class_exists(CLASS_NAME) ) {
            $_method = METHOD;
            $_i = new $_class();
            if(method_exists($_i, METHOD)) {
                //if ( is_array($v[argus]) ) {
                //    call_user_method_array (METHOD,$_i,$v[argus]);
                //} else {
                //    call_user_method (METHOD,$_i,$v[argus]);
                //}
                call_user_method (METHOD,$_i,$v[argus]);
            } else {
                trigger_error("Call to undefined Method ({$_class} instance)->{$_method}", E_USER_ERROR);
            }
        } else {
            trigger_error("Call to undefined Class {$_class}", E_USER_ERROR);
        }
    }
} else {
    trigger_error("Call to undefined Method ({$_class} instance)->{$_method}", E_USER_ERROR);
}
/*
http://phunctional.dahlia.kr/wiki/CookBook/MoreDynamicObject

http://www.eguru.co.kr/entry/%EB%8C%80%EB%8B%A8%ED%95%9C-php-%EB%8F%99%EC%A0%81-%ED%95%A8%EC%88%98-%EC%A0%91%EA%B7%BC-%EB%B0%A9%EB%B2%95%EC%9D%B4%EB%9E%80%EB%8B%A4

http://cafe.naver.com/mobilenjoy.cafe?iframe_url=/ArticleRead.nhn%3Farticleid=2488
php를 이용한 wsdl soap ?? 정보조사 요구
*/
?>
