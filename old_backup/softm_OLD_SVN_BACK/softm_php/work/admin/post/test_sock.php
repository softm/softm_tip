<?

$rTarget = 'jpdic';
$rDisplay = 10;
$rStart = 1;
$rSort = 'sim';
$query = urldecode("±€Έν");
$query = "±€Έν";
$pquery = "regkey=ec11f8dd4840a7d701235800871923&target=post&query=" . $query;

    $fp = fsockopen ("biz.epost.go.kr", 80, $errno, $errstr, 30);
    if (!$fp) {
        echo "$errstr ($errno)";
    } else {
        fputs($fp, "GET /KpostPortal/openapi?");
        fputs($fp, $pquery);
        fputs($fp, " HTTP/1.1\r\n");
        fputs($fp, "Host: biz.epost.go.kr\r\n");
        fputs($fp, "Connection: Close\r\n\r\n");

        $header = "";
        while (!feof($fp)) {
            $out = fgets ($fp,512);
            if (trim($out) == "") {
                break;
            }
            $header .= $out;
        }

        $body = "";
        while (!feof($fp)) {
            $out = fgets ($fp,512);
            $body .= $out;
        }

        $idx = strpos(strtolower($header), "transfer-encoding: chunked");

        if ($idx > -1) { // chunk data
            $temp = "";
            $offset = 0;
            do {
                $idx1 = strpos($body, "\r\n", $offset);
                $chunkLength = hexdec(substr($body, $offset, $idx1 - $offset));

                if ($chunkLength == 0) {
                    break;
                } else {
                    $temp .= substr($body, $idx1+2, $chunkLength);
                    $offset = $idx1 + $chunkLength + 4;
                }
            } while(true);
            $body = $temp;
        }
        header("content-type: application/xml");
        $encodedquery = urlencode($query);
        $url = "http://biz.epost.go.kr/KpostPortal/openapi?regkey=" . REGKEY . "&target=post&query=".$encodedquery;
        //echo $url;
        $result = simplexml_load_string($url);
            var_dump($result);

        //echo $body;
        fclose ($fp);
    }
?>