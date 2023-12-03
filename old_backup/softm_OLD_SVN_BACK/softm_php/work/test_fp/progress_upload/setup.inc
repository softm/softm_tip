<?
$p_open_index = $_GET['p_open_index']!=''?$_GET['p_open_index']:$_POST['p_open_index'];
$upload_tmp = !ini_get('upload_tmp_dir')?$_ENV["TEMP"]:ini_get('upload_tmp_dir');
$OS = (strstr($_ENV["OS"],"Windows_NT"))?"win":"unix";

define ("SAVE_DIR" , "E:/okmmc_doc/progress_upload/updata/" );
//define ("TMP_DIR" , $upload_tmp . '/' . md5($p_open_index.$_REQUEST["PHPSESSID"]) );
define ("TMP_DIR" , ( $OS=='win' )?$_ENV[TMPDIR]:$_ENV[TMP]);

//echo 'set : ' . ini_set ( 'upload_tmp_dir', TMP_DIR);
//if ( ini_set ( 'upload_tmp_dir', TMP_DIR) ) {
//    echo  'success';
//} else {
//    echo  'fail : ' . TMP_DIR;
//}
?>