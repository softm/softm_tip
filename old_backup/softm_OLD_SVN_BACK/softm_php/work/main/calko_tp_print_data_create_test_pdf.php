<?
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

require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 054');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

//set some language-dependent strings
$pdf->setLanguageArray($l); 

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);
//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

//set some language-dependent strings
$pdf->setLanguageArray($l); 

// ---------------------------------------------------------

// add a page
$pdf->AddPage();

// set JPEG quality
$pdf->setJPEGQuality(100);

// add a page
$pdf->Image('../img/thyssenkrpp_logo.jpg', 175, 23, 10, 10, '', 'http://calko.tkek.co.kr', '', true, 150);

//phpinfo();
$p_esti_no = '';
$p_esti_no  = $argv[1]?$argv[1]:str_replace('-', '', trim($_GET["p_esti_no"])); // p_esti_no
$p_seq      = $argv[2]?$argv[2]:(int) $_GET["p_seq"]                          ; // p_seq
//echo SERVER_DOMAIN;
$data = file_wget_contents('http://'.SERVER_DOMAIN.'/calko/calko_tp_print_data_create_pdf.php?p_esti_no=' . $p_esti_no . '&p_seq=' . $p_seq, 30, '');
//echo $data ;
//f_writeFile(SERVER_TMP.'/Quotation_'.$p_esti_no.'.html', $data );

$html = <<<EOD
<h1>XHTML Form Example</h1>
<form method="post" action="http://localhost/printvars.php" enctype="multipart/form-data">
<label for="name">name:</label> <input type="text" name="name" value="" size="20" maxlength="30" /><br />
<label for="password">password:</label> <input type="password" name="password" value="" size="20" maxlength="30" /><br /><br />
<label for="infile">file:</label> <input type="file" name="userfile" size="20" /><br /><br />
<input type="checkbox" name="agree" value="1" checked="checked" /> <label for="agree">I agree </label><br /><br />
<input type="radio" name="radioquestion" id="rqa" value="1" /> <label for="rqa">one</label><br />
<input type="radio" name="radioquestion" id="rqb" value="2" checked="checked"/> <label for="rqb">two</label><br />
<input type="radio" name="radioquestion" id="rqc" value="3" /> <label for="rqc">three</label><br /><br />
<label for="selection">select:</label>
<select name="selection" size="0">
    <option value="0">zero</option>
    <option value="1">one</option>
    <option value="2">two</option>
    <option value="3">three</option>
</select><br /><br />
<label for="selection">select:</label>
<select name="multiselection" size="2" multiple="multiple">
    <option value="0">zero</option>
    <option value="1">one</option>
    <option value="2">two</option>
    <option value="3">three</option>
</select><br /><br /><br />
<label for="text">text area:</label><br />
<textarea cols="40" rows="3" name="text">line one
line two</textarea><br />
<br /><br /><br />
<input type="reset" name="reset" value="Reset" />
<input type="submit" name="submit" value="Submit" />
<input type="button" name="print" value="Print" onclick="print()" />
<input type="hidden" name="hiddenfield" value="OK" />
<br />
</form>
EOD;


// output the HTML content
$pdf->writeHTML($data, true, 0, true, true);

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_054.pdf', 'I');

?>