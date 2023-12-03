<?
define ('HOME_DIR'   , realpath(dirname(dirname(__FILE__))) );

require_once HOME_DIR . '/inc/var.inc'      ; // 변수
require_once HOME_DIR . '/inc/session.inc'  ; // 세션
require_once HOME_DIR . '/inc/DB.php'       ; // DB

session_cache_limiter('none');
//$host = 'http://' . getenv('HTTP_HOST');
//$host = 'http://gears.kr';
//echo $HTTP_REFERER;
//if ($host != substr(getenv('HTTP_REFERER'), 0, strlen($host))){
//    header("HTTP/4.0 404 Not Found");
//} else {
    header("content-type: application/xml");
    //header("content-type: text/xml");
    //header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    //header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    //header("Cache-Control: no-store, no-cache, must-revalidate");
    //header("Cache-Control: post-check=0, pre-check=0", false);
    //header("Pragma: no-cache");

    $db = new DB();
    $db->getConnect();

    $xw = new xmlWriter();

    $xw->openMemory();

    //$xw->startDocument('1.0','UTF-8');
    $xw->startDocument('1.0','euc-kr');
    $xw->startElement('post');
        $xw->startElement('itemlist');
        //echo 'val : ' . mb_strlen ($query,'EUC-KR') . ' / ' . $val;

        if ( mb_strlen ($query,'EUC-KR') >= 3 ) {
            $sql = "SELECT "
                 . " ZIPCODE,"
                 . " SIDO   ,"
                 . " GUGUN  ,"
                 . " DONG   ,"
                 . " BUNJI  ,"
                 . " X1     ,"
                 . " Y1     ,"
                 . " X2     ,"
                 . " Y2      "
                 . " FROM " . TB_POST
                 . " WHERE DONG LIKE '%" . iconv('EUC-KR', 'UTF-8', $query ) . "%'";
                 //. " LIMIT 50";
            //echo 'val : ' . $sql . ' / ' . $sql;
            $stmt = $db->multiRowSQLQuery($sql);
            while ( $rs = $db->multiRowFetch  ($stmt) ) {
                $xw->startElement('item');
                    $xw->writeElement('address', $rs[SIDO] . ' ' . $rs[GUGUN] . ' ' . $rs[DONG] . ' ' . $rs[BUNJI]);
                    $xw->writeElement('postcd',$rs[ZIPCODE]);
                $xw->endElement();
            }
        }
        $xw->endElement();
    $xw->endElement();
    $xw->endDtd();
    print $xw->outputMemory(true);

    $db->release();
//}
?>