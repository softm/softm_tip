<?
//error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE ( Notice는 제외한 모든에러를 리포팅해라~ )
// @extract($HTTP_ENV_VARS   ); // 환경 변수
// @extract($HTTP_GET_VARS   ); // Get  방식의 Parameter 값
// @extract($HTTP_POST_VARS  ); // Post 방식의 Parameter 값
// @extract($HTTP_SERVER_VARS); // Server 변수

require_once './lib/common.lib.inc' ; // 라이브러리
require_once SERVICE_DIR . '/classes/common/Session.php'          ; // 세션

if ($_POST['p_hash'] != md5('rlawlgns' . date ("Y-m-d")) ) exit;
$_i = null;
$_l = 0;
$v = null;
//echo urldecode($GLOBALS['HTTP_RAW_POST_DATA']);
//$v = json_decode(urldecode($GLOBALS['HTTP_RAW_POST_DATA']), true);
define("SOFTM", "MADE");
/**
 * 요청형태
 * @var string => json, post, form, form.file
 */
define("REQUEST_TYPE", strtolower($_POST[req_type]));
/**
 * 반환형태
 * @var string => json, xml, text
 */
define("RESPONSE_TYPE", strtolower($_POST[res_type]));
// echo 'REQUEST_TYPE : ' . REQUEST_TYPE . '<BR>';
if ( REQUEST_TYPE == "json" ) {
    $v = $_POST['softm_json_data'];
    if ( get_magic_quotes_gpc() == 1 ) $v = stripcslashes($v);
    $v = urldecode($v);
    //$v = rawurldecode($v);

    //$v %0A 값이 있을경우문제가됨 .
    $v = str_replace("\r\n" , "\n"  , $v);
    $v = str_replace("\r"   , "\n"  , $v);
    $v = str_replace("\n"   , "\\n" , $v);
//    echo "<TEXTAREA>" . $v . "</TEXTAREA>";
    $v = json_decode($v, true);
//    var_dump($v);
} else if ( REQUEST_TYPE == "post" || REQUEST_TYPE == "form"  || REQUEST_TYPE == "form.file" ) {
	$v = $_POST;
}
/*
$v = urldecode($_POST['softm_json_data']);
echo ($v) . "<BR><BR>";
$v = htmlspecialchars($v);
echo ($v) . "<BR><BR>";

*/
//print_r($GLOBALS);
//print ($_POST[request_type] );
//print_r($v);
$_cInfo= explode ('.', $v[className]);

if ( $v ) {
    $_l = sizeof($_cInfo);
    if ( $_l > 0 ) {
        //echo '$v[className]) : ' . $v[className] . '<BR>';
        //echo '$v[argus]) : ' . $v[argus] . ' 크기 : ' . sizeof( $v[argus] ) . '<BR>';
        define("METHOD"     , $v[method]);
        define("CLASS_POS"  , join('/',array_slice($_cInfo, 0, -1)));
        define("CLASS_NAME" , $_cInfo[$_l-1]  );
        define("UI_DIR"     , SERVICE_DIR . '/ui/' . CLASS_POS . '/' . strtolower(CLASS_NAME));

//         echo 'UI_DIR : ' . UI_DIR . '<BR>';
//         echo 'CLASS_POS : ' . CLASS_POS . '<BR>';
//         echo 'CLASS_NAME : '.  CLASS_NAME . '<br>';
		try {
			include_once SERVICE_DIR . '/classes/' . CLASS_POS . '/' . CLASS_NAME . '.php';
			//          echo SERVICE_DIR . '/classes/' . CLASS_POS . '/' . CLASS_NAME . '.php';
			$_class  = CLASS_NAME;
			if ( class_exists(CLASS_NAME) ) {
				// require_once SERVICE_DIR . '/common/Session.php' ; // 변수

				$_method = METHOD;
				$_i = new $_class();
				if(method_exists($_i, METHOD)) {
					//if ( is_array($v[argus]) ) {
					//    call_user_method_array (METHOD,$_i,$v[argus]);
					//} else {
					//    call_user_method (METHOD,$_i,$v[argus]);
					//}
					// call_user_method (METHOD,$_i,REQUEST_TYPE=="post"?$_POST:$v[argus]);
					// 				foreach ($v[argus] as $k => $vv) {
					// 					//$v[argus][$k] = str_replace ( "%0A" , chr(10), $v);
					// 					echo $k . " / " . $vv . "<BR>";
					// 				}
					// echo $v[argus];
					if( method_exists($_i, "setDebug") && $_class != "Test" ) $_i->setDebug(false);
					$_i->$_method(REQUEST_TYPE=="json"?$v[argus]:$_POST);

				} else {
					echo $_method;
					trigger_error("Call to undefined Method ({$_class} instance)->{$_method}", E_USER_ERROR);
				}
			} else {
				trigger_error("Call to undefined Class {$_class}", E_USER_ERROR);
			}
		} catch (Exception $e) {
			echo "error : " + $e->getMessage() + " /<BR>error code : " + $e->getCode() + " /<BR>line : " + $e->getLine();
		}
    }
} else {
	trigger_error("Call to undefined Method ({" . $v[className] . "} instance)->{" . $v[method] . "}" . print_r($v) , E_USER_ERROR);
}
/*
http://phunctional.dahlia.kr/wiki/CookBook/MoreDynamicObject

http://www.eguru.co.kr/entry/%EB%8C%80%EB%8B%A8%ED%95%9C-php-%EB%8F%99%EC%A0%81-%ED%95%A8%EC%88%98-%EC%A0%91%EA%B7%BC-%EB%B0%A9%EB%B2%95%EC%9D%B4%EB%9E%80%EB%8B%A4

http://cafe.naver.com/mobilenjoy.cafe?iframe_url=/ArticleRead.nhn%3Farticleid=2488
php를 이용한 wsdl soap ?? 정보조사 요구
*/
?>
