<?
$send_data = array();
$send_data['base_dir'                   ] = $sysInfor["base_dir"  ]     ;
$send_data['SERVER_NAME'                ] = $_SERVER["SERVER_NAME"]     ;
// echo json_encode($send_data);
//var_dump(json_encode($send_data));

//>>>>>>>>>>>>>>>>>>> JSON형태로 text로 전송하여 저장한다.
$url  = "http://".DBOARD_DOMAIN."/DBD/rest/get_my_site_info.php";
//$cType = "text/plain";
//echo urlencode(json_encode($send_data));
$json_str = get_url_fsockopen( $url,"v=".urlencode(json_encode($send_data)),$cType );
$v = urldecode($json_str);
if ( get_magic_quotes_gpc() == 1 ) $v = stripcslashes($v);
//$v=trim(preg_replace('/.+?({.+}).+/','$1',$v));
//$v = str_replace("\\", "", $v);
//$v= str_replace('\\\'', "'", $v);
// $v='{"aaa":11}';
// echo  "<textarea>".$v. "</textarea>";
$info_json = json_decode($v);
// var_dump($info_json);
/** @var 사이트 패치버전 */
define("PATCH_VERSION",$info_json->VERSION);
/** @var 사이트 마이그레이션버전*/
define("MIG_VERSION"  ,$info_json->MIG_VERSION);

// echo 'PATCH_VERSION : ' . $info_json->VERSION;
// echo 'MIG_VERSION : ' . MIG_VERSION;
//{"base_dir":"/dboard/","php_uname":"Windows NT SOFTM-PC 6.1 build 7601","php_sapi_name":"apache2handler","apache_get_version":"Apache","PHP_VERSION":"5.2.0","mysql_client_api_version":"5.0.22","SERVER_NAME":"local-dboard.com","SERVER_PORT":"80","SERVER_ADDR":"127.0.0.1","DBOARD_VERSION":"3.454"}
// var_dump(SITE_INFO);
// ECHO $info_json['VERSION'];
// var_dump(SITE_INFO);
//$SITE_INFO = json_decode($info_json['LAST_INFO_JSON']);
//ECHO $SITE_INFO->DBOARD_VERSION;
?>