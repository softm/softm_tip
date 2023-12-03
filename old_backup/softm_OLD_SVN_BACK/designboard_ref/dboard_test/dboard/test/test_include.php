<?
    include '../common/message.inc'      ; // 에러 페이지 처리
	include '../common/message_table.inc'; // 메시지
    foreach ($_ENV as $key => $value) {
        ECHO $key . ' / ' . $value . '<BR>';
    }
//
//$_SERVER - Server and execution environment information
//$_SESSION - Session variables
//$_ENV - Environment variables
//
/*
Superglobals - Superglobals are built-in variables that are always available in all scopes
$GLOBALS - References all variables available in global scope
$_SERVER - Server and execution environment information
$_GET - HTTP GET variables
$_POST - HTTP POST variables
$_FILES - HTTP File Upload variables
$_REQUEST - HTTP Request variables
$_SESSION - Session variables
$_ENV - Environment variables
$_COOKIE - HTTP Cookies
$php_errormsg - The previous error message
$HTTP_RAW_POST_DATA - Raw POST data
$http_response_header - HTTP response headers
$argc - The number of arguments passed to script
$argv - Array of arguments passed to script
*/
//phpinfo();
?>