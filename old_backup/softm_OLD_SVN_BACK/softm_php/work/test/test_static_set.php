<?
include 'Info.class.php';
//static $v_static = 'xxxxxxxxxxxxxx';
$GINFO = Info::getInstance();
//$LNG['a'] = 'abce';
//whenever you change vars//
$app_vars=array('animal'=>'yak','colour'=>'grey','demeanour'=>'unhappy');//etc//
shmop::set_var(serialize($app_vars));
?>