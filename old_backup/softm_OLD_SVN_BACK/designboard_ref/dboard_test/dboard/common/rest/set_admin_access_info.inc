<?
ob_start();
phpinfo(INFO_MODULES);
$info = ob_get_contents();
ob_end_clean();
$infomysql = stristr($info, 'Client API version');
//preg_match('/[1-9].[0-9].[1-9][0-9]/', $infomysql, $match);
preg_match('/(\d+).(\d+).(\d+)/', $infomysql, $match);
$mysql_client_api_version = $match[0];
$send_data = array();
$send_data['base_dir'                   ] = $sysInfor["base_dir"  ]     ;
$send_data['php_uname'                  ] = php_uname       ()          ;
$send_data['php_sapi_name'              ] = php_sapi_name   ()          ;
if ( PHP_VERSION_ID > 40301 ) {
    if ( function_exists ( "apache_get_version" ) ) {
        $send_data['apache_get_version'         ] = apache_get_version ()      ;
    }
}
$send_data['PHP_VERSION'                ] = PHP_VERSION                 ;
$send_data['mysql_client_api_version'   ] = $mysql_client_api_version   ;
$send_data['SERVER_NAME'                ] = $_SERVER["SERVER_NAME"]     ;
$send_data['SERVER_PORT'                ] = $_SERVER["SERVER_PORT"]     ;
$send_data['SERVER_ADDR'                ] = $_SERVER["SERVER_ADDR"]     ;
$send_data['DBOARD_VERSION'             ] = $_dboard_ver_str            ;
// echo json_encode($send_data);
//var_dump(json_encode($send_data));

//>>>>>>>>>>>>>>>>>>> JSON형태로 text로 전송하여 저장한다.
$url  = "http://".DBOARD_DOMAIN."/DBD/rest/set_admin_access_info.php";
$data = "a=a1";
$data.= "&b=b1";
//$cType = "text/plain";
//echo urlencode(json_encode($send_data));
$v = get_url_fsockopen( $url,"v=".urlencode(json_encode($send_data)),$cType );

if ( get_magic_quotes_gpc() == 1 ) $v = stripcslashes($v);
$v = urldecode($v);
$v=trim(preg_replace('/.+?({.+}).+/','$1',$v));
$chk_json = json_decode($v);
?>