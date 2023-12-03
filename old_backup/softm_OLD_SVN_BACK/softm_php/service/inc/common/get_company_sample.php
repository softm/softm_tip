<?
/*
 Filename        : /index.php
 Fuction         : 인덱스
 Comment         :
 시작 일자       : 2009-12-26,
 수정 일자       : 2010-01-26, v1.0 first
 작 성 자        : 김지훈
 수 정 자        :
 @version        : 1.0
*/
?>
<?
require_once '../../lib/common.lib.inc';
require_once SERVICE_DIR . '/classes/common/Session.php';
require_once SERVICE_DIR . '/classes/common/Database.class.php';
require_once SERVICE_DIR . '/classes/common/Common.php';
$memInfor = Session::getSession();
//echo 'login_yn : ' . $memInfor['login_yn'];
$mode = !$_GET["mode"]?"login":$_GET["mode"];
// echo "mode : " .$mode;
$db = new DataBase();
$db->getConnect();
$p_company_no = 1;
$company = Common::getCompany($db,array(p_company_no=>$p_company_no));
echo $company;
$db->release();
?>
