<?

define ("HOME_DIR" , realpath(dirname(__FILE__)) );
define ('SERVICE'  , 'CALKO' );
define ('BASE_DIR' , '..' );
define ('SERVICE_DIR', './service');
//echo mysql_real_escape_string("'xx'x'\"");

require_once './inc/calko.lib'   ; // calko.lib

require_once SERVICE_DIR . '/common/lib/lib.inc'                      ; // standard lib
require_once SERVICE_DIR . '/common/lib/DB.php'                       ; // DB
require_once SERVICE_DIR . '/common/lib/class.inputfilter_clean.php'  ; // 필터
require_once SERVICE_DIR . '/common/lib/form.inc'                     ; // form
require_once SERVICE_DIR . '/common/Session.php';
$savedata['passwd'] ='1abcd';
$errors = array();
if ( !Session::validatePassword($savedata['passwd'], 1, 20) ) $errors[] = xlate('비밀번호는 영숫자만 이용가능합니다.');
echo join(',',$errors);
?>