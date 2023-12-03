<?
include 'Info.class.php';
//echo 'test : ' . $v_static . '<BR>';
//echo 'test : ' . Info::$v_static. '<BR>';
$GINFO = Info::getInstance();
echo '$GINFO::$v_static : ' . $GINFO->v_static. '<BR>';
//echo 'test : ' . $LNG['a']. '<BR>';
//whenever you want them//
$app_vars=unserialize(shmop::get_var());

print_r($app_vars);
?>