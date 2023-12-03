<?
require_once 'lib/common.lib.inc'; // 공통인클루드.

//var_dump($_SESSIONS);
function getUrlPath ($dir) {
	$endP  = strpos ($dir,'?'    );
	if ( $endP ) {
		$_tmp  = substr ($dir, 0, $endP );
	} else {
		$_tmp = $dir;
	}
	$endP = strrpos($_tmp,'/') + 1;
	$_rtn = substr($dir, 0, $endP);
	return $_rtn;
}

function getReqPageName ($dir='') {
	global $PHP_SELF;
	if ( $dir ) {
		$_tmp = $dir;
	} else {
		$_tmp = $PHP_SELF;
	}
	$endP  = strpos ($_tmp,'?'    );
	if ( $endP ) {
		$_tmp  = substr ($_tmp, 0, $endP );
		$starP = strrpos($_tmp,'/') + 1;
		$_tmp  = substr ($_tmp, $starP);
		$_rtn = substr($_tmp, 0, $endP);
	} else {
            $starP = strrpos($_tmp,'/') + 1;
		$_tmp  = substr ($_tmp, $starP);
		$_rtn = substr($_tmp, 0);
	}
	return $_rtn;
}
// echo SERVICE_DIR;
require_once SERVICE_DIR . '/classes/common/Session.php';
@session_destroy();
$retunPage = '';
$back = Session::getSession('backurl');
if ( !$back ) {
    if ( $_SERVER[HTTP_REFERER]) {
        $retunPage = getUrlPath ($_SERVER[HTTP_REFERER]) . getReqPageName ($_SERVER[HTTP_REFERER]);
//         $retunPage = "/";
    } else {
        $retunPage = "/";
    }
} else {
    $retunPage = $back;
}
// echo $retunPage;
/*
$memInfor = Session::getSession();
//echo 'login_yn : ' . $memInfor['login_yn'];
$backurl = $_GET['backurl'];
echo '$backurl : ' . $backurl . '<BR>';
//if ( $backurl ) Session::setSession('backurl',$backurl);
echo '$backurl : ' . $backurl . '<BR>';

echo '$backurl : ' . $backurl . '<BR>';
echo 'HOME_DIR : ' . HOME_DIR . '<BR>';
echo '$retunPage : ' . $retunPage . '<BR>';
*/
redirect( $retunPage );
?>