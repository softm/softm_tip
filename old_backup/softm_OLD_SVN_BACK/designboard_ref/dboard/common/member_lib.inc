<?
/*
* include 되었는지를 검사
**/
if( defined("_dmember_lib_included") ) return;
    define ("_dmember_lib_included", true);

$_dmember_ver         = 'dmember 1.00';
$_dmember_ver_str     = '1.00';
$_dmember_start_date  = '2004.09.04';
$_dmember_update_date = '2004.09.04';

// 테이블 정보 설정
$tb_member              = "kyh_member";
$tb_member_kind         = "kyh_member_kind";
$tb_member_config       = "kyh_member_config";
$tb_login_abstract      = "kyh_login_abstract";
$tb_dic_member_statistic= "kyh_dic_member_statistic";

$tb_post                = "kyh_post";
?>