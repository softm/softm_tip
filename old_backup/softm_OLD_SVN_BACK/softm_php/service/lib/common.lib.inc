<?
//define('HOME_DIR'   ,'C:/Project/framework'); // HOME_DIR
define ("HOME_DIR" , realpath(dirname(dirname(dirname(__FILE__)))) );
//define('HOME_DIR'   ,'D:/Project/12.03_FrameWork/source'); // HOME_DIR
/**
 * @var PHP 버전
 */
if (!defined('PHP_VERSION_ID')) {
	$version = explode('.', PHP_VERSION);
	define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}

if (PHP_VERSION_ID < 50207) {
	define('PHP_MAJOR_VERSION',   $version[0]);
	define('PHP_MINOR_VERSION',   $version[1]);
	define('PHP_RELEASE_VERSION', $version[2]);
}

require_once HOME_DIR .'/service/lib/var.define.inc' ; // 변수
/*
session_save_path(HOME_DIR . '/data/session'); // 설치후
session_set_cookie_params(0, '/');
session_cache_limiter('nocache, must_revalidate');
session_cache_limiter('');
session_start();
*/
//ini_set("display_errors",0);
if(!empty($HTTP_SERVER_VARS)) $_SERVER = $HTTP_SERVER_VARS;

$session_domain = $_SERVER[HTTP_HOST];
$session_domain = str_replace("www.","",$session_domain);
$session_domain = "." . $session_domain;

ini_set("session.cookie_lifetime", "0");
ini_set("session.cache_limiter", "nocache, must-revalidate");
ini_set("session.cookie_domain", $session_domain);
session_start();

date_default_timezone_set("Asia/Seoul");

if (!function_exists('json_encode')) {
    require_once 'JSON/JSON.php';
    function json_encode($arg)
    {
            global $services_json;
            if (!isset($services_json)) {
                    $services_json = new Services_JSON();
            }
            return $services_json->encode($arg);
    }
}

if( !function_exists('json_decode') ) {
    require_once 'JSON/JSON.php';
    function json_decode($data, $bool) {
        if ($bool) {
            $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
        } else {
            $json = new Services_JSON();
        }
        return( $json->decode($data) );
    }
}

function logd($v) {
// 	echo $v;
}
function logv($v) {
	var_dump($v);
}

function logr($v) {
	print_r($v);
}

/*
 * 함수명: redirect
* 설명  : 페이지 이동
* 예)  redirectPage("http://www.yahoo.com");
* Argus : url : 주소
**/
function redirect($url,$replace=false) {
	if ( $url ) {
		if ( strtolower($url) == "back" ) {
			echo("<SCRIPT LANGAUGE='javascript'>history.back();</SCRIPT>");
		}
		else {
			if ( !$replace ) {
				echo "\n<meta http-equiv=\"refresh\" content=\"0; url=$url\">";
			} else {
				echo("<SCRIPT LANGAUGE='javascript'>document.location.replace('".$url."');</SCRIPT>");
			}
		}
	}
}
/**
 * @param Column $a
 * @param Column $b
 * @return number
 */
function columnSort($a, $b) {
	$aIdx = $a->getHide()?10000:$a->getIndex();
	$bIdx = $b->getHide()?10000:$b->getIndex();
	if ($aIdx == $bIdx) {
		return 0;
	}
	// 					echo $a->getName() . " / " . $b->getName() . " | " . $a->getHide() . " / " . $b->getHide() . "\n";
	return ($aIdx < $bIdx ) ? -1 : 1;
}
/**
 $browser = getBrowserType($_SERVER["HTTP_USER_AGENT"]);
 define ('BROWSER', $browser[Name]);
 */
function getBrowserType($log) {
	$log = strtolower($log);
	$list	= array(
			"Name"	=>	"unknown",
			"Version"	=>	"0.0.0",
			"Agent"	=>	"unknown"
	);

	$list['Agent']	= $log;

	$browsers = array(
			"firefox", "msie", "opera", "chrome", "safari",
			"mozilla", "seamonkey",    "konqueror", "netscape",
			"gecko", "navigator", "mosaic", "lynx", "amaya",
			"omniweb", "avant", "camino", "flock", "aol"
	);

	foreach($browsers as $browser)
	{
		if (preg_match("#($browser)[/ ]?([0-9.]*)#", $log, $match))
		{
			$list['Name']	 = $match[1] ;
			$list['Version']	= $match[2] ;
			break;
		}
	}
	return $list;
}
$browser = getBrowserType($_SERVER["HTTP_USER_AGENT"]);
define ('BROWSER', $browser[Name]);
?>