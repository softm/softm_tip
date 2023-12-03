<?
error_reporting(0);

if ( strpos(strtoupper($_ENV['TERM']), 'XTERM') === false ) {
    //echo 'window';
    require_once 'C:/WEB_APP/doc/inc/calko.lib'   ; // calko.lib
} else {
    //echo 'unix';
    require_once '/usr/local/apache/htdocs/inc/calko.lib'   ; // calko.lib
}

//echo exec('/usr/local/php/bin/php -q C:/WEB_APP/doc/calko/calko_tp_print_data_create.php ');
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
require_once SERVICE_DIR . '/common/lib/file.inc'                      ; // standard lib

require_once("../dompdf/dompdf_config.inc.php");

$html =
  '<html><body>'.
  '<p>Put your html here, or generate it with your favourite '.
  'templating system.</p>'.
  '</body></html>';

//phpinfo();
$p_esti_no = 'XX09100007101';
$p_esti_no  = $argv[1]?$argv[1]:str_replace('-', '', trim($_GET["p_esti_no"])); // p_esti_no
$p_seq      = $argv[2]?$argv[2]:(int) $_GET["p_seq"]                          ; // p_seq
//echo SERVER_DOMAIN;
$data = file_wget_contents('http://'.SERVER_DOMAIN.'/calko/calko_tp_print_data_create_pdf.php?p_esti_no=' . $p_esti_no . '&p_seq=' . $p_seq, 30, '');
//echo $data ;
//f_writeFile(SERVER_TMP.'/Quotation_'.$p_esti_no.'.html', $data );
$html =
  '<html><body>'.
  '<p>Put your html here, or generate it with your favourite '.
  'templating system.</p>'.
  $data.
  '</body></html>';


$dompdf = new DOMPDF();
$dompdf->load_html($data);

//$dompdf->render();
//SERVER_TMP.'/Quotation_'.$p_esti_no.'.html'
//$dompdf->stream('Quotation_'.$p_esti_no.'.pdf');

//This is the part to create a error free PDF
$locale_string = setlocale(LC_ALL, 0);
setlocale(LC_NUMERIC, array('en_US.UTF8', 'en_US.UTF-8', 
             'en_US.8859-1', 'en_US', 'American', 'ENG', 'English'));
$dompdf->render();
setlocale(LC_ALL, $locale_string);
 
$dompdf->stream('Quotation_'.$p_esti_no.'.pdf');


?>