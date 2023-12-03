<?
include ( './setup.inc'          );

session_start();
//echo print_r($_POST);
//echo print_r($_GET);
$mode = $_GET['mode']!=''?$_GET['mode']:$_POST['mode'];
//echo 'mode : ' . $mode;
if ( $mode == 'get_open_index' ) {
    $open_index = (int)$_SESSION["upfile"]['open_index'];
    if ( $_SESSION["upfile"] ) {
        $open_index++;
        $_SESSION["upfile"]['open_index'] = $_SESSION["upfile"]['open_index'] + 1;
    } else {
        $open_index = 1;
        $_SESSION["upfile"]['open_index'] = 1;
    }
    //if ( !ereg( 'check_upload.php', $_SERVER[PHP_SELF]) ) {
        @mkdir($upload_tmp . '/' . $open_index . '_' . $_REQUEST["PHPSESSID"],0707);
        @chmod($upload_tmp . '/' . $open_index . '_' . $_REQUEST["PHPSESSID"],0707);
    if ( $OS=='win' ) {
    //echo SAVE_DIR . $p_open_index . '_' . $_REQUEST["PHPSESSID"];
        $_ENV[TMPDIR] = SAVE_DIR . $open_index . '_' . $_REQUEST["PHPSESSID"];
    } else {
        $_ENV[TMP] = SAVE_DIR . $open_index . '_' . $_REQUEST["PHPSESSID"];
    }
    //}
   echo $_SESSION["upfile"]['open_index'];
} else if ( $mode == 'get_size_info' ) {
    $p_open_index = $_GET['p_open_index']!=''?$_GET['p_open_index']:$_POST['p_open_index'];

    function sort_by_mtime($file1,$file2) {
        $time1 = filemtime($file1);
        $time2 = filemtime($file2);
        if ($time1 == $time2) return 0;
        return ($time1 < $time2) ? 1 : -1;
    }

  //$upload_tmp = !ini_get('upload_tmp_dir')?$_ENV["TEMP"]:ini_get('upload_tmp_dir');
    $tmp_files = @glob(TMP_DIR."/php*",GLOB_NOSORT);
    usort($tmp_files,"sort_by_mtime");

    header("Expires:Mon,26 Jul 1997 05:00:00 GMT");
    header("Last-Modified:".gmdate("D,d M Y H:i:s")."GMT");
    header("Cache-Control:no-cache,must-revalidate");
    header("Content-Type: image/gif");
    echo  'size : ' . sizeof($tmp_files) . '<BR>';
    echo  'tmp_files : ' . $tmp_files[0] . '<BR>';
    echo  'size : ' . @filesize($tmp_files[0]) . '<BR>';
    echo  'p_open_index : ' . $p_open_index . '<BR>';
    echo '$_SESSION[upfile][name][$p_open_index] : ' . $_SESSION["upfile"]['name'][$p_open_index] . ' / ';
}
