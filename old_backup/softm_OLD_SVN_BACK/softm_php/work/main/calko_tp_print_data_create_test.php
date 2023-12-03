<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</HEAD>

<BODY>
<?
if ( strpos(strtoupper($_ENV['TERM']), 'XTERM') === false ) {
    //echo 'window';
    require_once 'C:/WEB_APP/doc/inc/calko.lib'   ; // calko.lib
} else {
    //echo 'unix';
    require_once '/usr/local/apache/htdocs/inc/calko.lib'   ; // calko.lib
}

if ( SERVER_GUBUN == '1' ) {
    define ("HOME_DIR" , 'C:/WEB_APP/doc/' );
    define ('SERVICE'  , 'CALKO' );
    define ('BASE_DIR' , '..' );
    define ('SERVICE_DIR', 'C:/WEB_APP/doc/service');
} else {
    define ("HOME_DIR" , '/usr/local/apache/htdocs' );
    define ('SERVICE'  , 'CALKO' );
    define ('BASE_DIR' , '..' );
    define ('SERVICE_DIR', '/usr/local/apache/htdocs/service');
}

require_once SERVICE_DIR . '/common/lib/file.inc'                      ; // file lib

$p_esti_no = '';
$p_esti_no  = $argv[1]?$argv[1]:str_replace('-', '', trim($_GET["p_esti_no"])); // p_esti_no
$p_seq      = $argv[2]?$argv[2]:(int) $_GET["p_seq"]                          ; // p_seq
//echo SERVER_DOMAIN;
$data = file_wget_contents('http://'.SERVER_DOMAIN.'/calko/calko_tp_print_data_create.php?p_esti_no=' . $p_esti_no . '&p_seq=' . $p_seq, 30, '');
echo $data ;
f_writeFile(SERVER_TMP.'/Quotation_'.$p_esti_no.'.html', $data );

?>
</BODY>
</HTML>
