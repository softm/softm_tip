<?php
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>献给母亲的爱 3Φ 380V 60HZ3Φ 380V 60HZ</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 

</head> 
<body style="font-size: 8pt; font-family:sans-serif ">
＃♧
/*
 * Your dynamically generated output<BR>
 * having reference to external CSS files<BR>
 * and images<BR>
 */
 <BR>
 献给母亲的爱 3Φ 380V 60HZ3Φ 380V 60HZ 김지훈<BR>
<?
echo utf8_decode("献给母亲的爱 3Φ 380V 60HZ3Φ 380V 60HZ 김지훈" );
//echo iconv("UTF-8", "EUC-KR","献给母亲的爱 3Φ 380V 60HZ3Φ 380V 60HZ" . $NL);

?>
</body>
</html>

<?php
$page = ob_get_contents();
ob_end_clean();
 
$filepdf = "test.pdf";
$html = "<html>"
      . "<head>"
      . "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />"
      . "<style type='text/css'>"
      . "    body {"
      . "        font-family: \"Arial\";"
      . "        font-size: 12px;"
      . "    }"
 
      . "    p {"
      . "        width: 512px;"
      . "        border: 1px dotted red;"
      . "    }"
      . "</style>"
      . "<body>"
 
      . "<h2>Text without special characters</h2>"
      . "<p>Nunc ut nibh non nulla vulputate placerat non quis leo. Donec varius, felis vel placerat suscipit, libero eros lacinia nulla, ut interdum magna urna eleifend eros. Duis nec porttitor arcu. Integer vitae est adipiscing nisl mollis gravida. Proin metus lorem, ullamcorper vitae eleifend et, vehicula non elit. Donec dignissim mollis rutrum. Nunc vitae neque non nisl placerat sodales. Etiam accumsan diam id lectus hendrerit iaculis. Cras hendrerit arcu in libero euismod ac viverra ante euismod. Nullam felis tellus, dapibus dictum aliquam nec, posuere ut neque. Fusce nec ipsum velit. Nam quam orci, accumsan in tempus non, bibendum eu diam. Integer nec pulvinar velit. Nunc laoreet diam ante. Ut vitae nisl tortor. Phasellus est sapien, mollis sit amet tincidunt vel, eleifend posuere leo. Aenean nec orci mi. Nam diam tellus, egestas et consectetur vulputate, elementum ac lectus. Duis ac sem at elit facilisis pulvinar.</p>"
 
      . "<h2>Text with special characters</h2>"
      . "<p>Væstibulum vænønåtis erås et velit imperdiæt ut sållicætudin elit ornære. Mæcenæs egåt augue urnø. Aliquam rhoncus viverra blandit. Donæc imperdiet leo porttitor læctus frångilla quis porttitår læctus vestibulum. Vestibulåm pretium ullæmcårper døgnissim. Cras ut ærat non turpås porttitor commodo. Nunc euismod mættis tårtør quis fringilla. Integår viværrå, eros vel ælæmentåm feugiat, tellus mi pållentæsque nøsi, a dictum nibh magna nec ipsum. Morbi mauris dui, consectetur vitae fermentum vel, lacinia condimentum neque. Etiam faucibus, libero et pretium semper, orci justo ornare risus, id scelerisque purus risus eu arcu. In hac håbitæsse platæa dictåmst. Væstibulåm cøndimæntåm, læctus egøt cøndimæntum løbortæs, lacås ipsåm færmentåm auguøe, vitæ pølvinår lacøs dui sed est. Sed et nisl vel mægna laoræt rutråm quis id mægnæ. Donæc vænenåtis vålputæte påsuære. Sed in tøllæs non løråm dægniæsim hændrerit søt amåt in pærås.</p>"
 
      ."</body>"
      ."</html>";

require_once("../dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->load_html($page);
 
//This is the part to create a error free PDF
$locale_string = setlocale(LC_ALL, 0);
setlocale(LC_NUMERIC, array('en_US.UTF8', 'en_US.UTF-8', 
             'en_US.8859-1', 'en_US', 'American', 'ENG', 'English'));
$dompdf->render();
setlocale(LC_ALL, $locale_string);
 
$dompdf->stream($filepdf);
?>

