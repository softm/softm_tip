<?

require_once(realpath('./htmldoc.class.php'));

// If this ain't working with your version of php, comment it out and uncomment the lines below it

$pdf_document = new htmldoc("http://127.0.0.1/index.php","header=./.|footer=.A.|tmargin=50");

// $pdf_document = new htmldoc;
// $pdf_document->html2pdf_doc("http://www.google.com/","header=./.|footer=.A.|tmargin=50");


$pdf_document->generate_pdf();
$pdf_document->download_pdf();

?>
