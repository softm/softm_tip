<?php
require_once SERVICE_DIR . '/lib/var_database.define.inc' ; // 변수

class Util
{
    function Util() {
        // Define the methodTable for this class in the constructor
        $this->methodTable = array(
            "getList" => array(
                "description" => "Return a list of data",
                "access" => "remote",
                "returns" => "string",
                "roles" => "admin"
            )
        );
    }
    
    /**
     * @param string $email
     * @return number
     */
    static function isEmail($email) {
    	return preg_match('|^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$|i', $email);
    }
    
    
    static function escapeYN () {
        return ini_get('magic_quotes_gpc');
    }

    static function removeFormatYearToSec($datestr) {
        if ( $datestr ) $datestr = substr($datestr,0,4) . substr($datestr,5,2) . substr($datestr,8,2) . substr($datestr,11,2) . substr($datestr,14,2) . substr($datestr,17,2);
        return $datestr;
    }

    /**
    * 함수명: getYearToSecondStr
    * 설명  : 현재 년+월+일+시+분+초 값을
              문자열 형태로 붙여서 반환합니다.
    **/
    static function getYearToSecondStr() {
        $t_time = date("YmdHis");
        return $t_time;
    }

    /**
     * 함수명: getYearToSecondStr
     * 설명  : 현재 년-월-일 시:분:초 ( 
     문자열 형태로 붙여서 반환합니다.
     **/
    static function getTodayString() {
    	$t_time = date("Y-m-d H:i:s");
    	return $t_time;
    }
    
    /*
    * 함수명: getDateAdd
    * 설명  : 날짜에 특정 필드를 더한 String을 반환
    * Argus : $dStr : 날짜 ( 2003-04-02-12-10-45 )
    *       : $field          : "YEAR"  ,"MONTH" ,"DAY"  ,"HOUR"  ,"MINUTE","SECOND"
    *       : $addVal         : 더하거나 뺄값.
    **/
    static function getDateAdd ($dStr, $field='', $addVal='' ) {
        $_rtn = '';
        $year    =  (int) substr ($dStr, 0 , 4 );
        $month   =  (int) substr ($dStr, 5 , 2 );
        $day     =  (int) substr ($dStr, 8 , 2 );
        $hour    =  (int) substr ($dStr, 14, 2 );
        $minute  =  (int) substr ($dStr, 17, 2 );
        $second  =  (int) substr ($dStr, 20, 2 );

        if      ( $field == "YEAR"   ) { $year   += $addVal; }
        else if ( $field == "MONTH"  ) { $month  += $addVal; }
        else if ( $field == "DAY"    ) { $day    += $addVal; }
        $_rtn = date ( "Y-m-d H:i:s" , mktime ( $hour, $minute, $second, $month, $day, $year ) );
        return $_rtn;
    }
    
    static function writeFile($filename, $str) {
    	$f = fopen($filename,"w");
    	$lock=flock($f,2);
    	if($lock) {
    		fwrite($f,$str);
    	}
    	flock($f,3);
    	fclose($f);
    }
    
    static function writeUTF8File($filename,$content) {
    	$f=fopen($filename,"w");
    	# Now UTF-8 - Add byte order mark
    	fwrite($f, pack("CCC",0xef,0xbb,0xbf));
    	fwrite($f,$content);
    	fclose($f);
    }

    /**
     * 파일 삭제 ( 와일드 카드 가능 ) 
     * @param string $filename
     * @param string $wildCard
     * @return unknown
     * 
     */
    static function unlinkFile($filename,$wildCard=false) {
    	$exec = false;
    	$del_info = '';
    	if ( $wildCard ) {
    		$d = dirname ($filename);
    		$f = basename($filename);
    		$fInfo = split('.', $f);
    		if ( sizeof($fInfo) > 1 ) {
    			$exec = true;
    		}
    		$del_info = $d . '/' . $f;
//     		echo $del_info;
    	} else {
    		$filename = str_replace("*", "", $filename);
    		$filename = str_replace("?", "", $filename);
    		$del_info = $filename;
    		$exec = true;
    	}
    	//echo '$del_info : ' . $del_info . '<BR>';
    	if ( $exec ) {
    		foreach (GLOB($del_info) AS $df) {
    			//echo "$filename :: " . FILESIZE($df) . "<BR>\n";
    			@chmod($df,0777);
    			$handle = @unlink($df);
    		}
    	}
    	return $handle;
    }
    
    // 파일 읽음
    static function readFile($filename) {
    	if(!file_exists($filename)) return '';
    
    	$f = fopen($filename,"r");
    	$str = @fread($f, filesize($filename));
    	fclose($f);
    
    	return $str;
    }
    
    // 디렉토리내의 모든 디렉토리 및 파일 삭제
    static function rmDir($path) {
    	$directory = dir($path);
    	while($entry = $directory->read()) {
    		if ($entry != "." && $entry != "..") {
    			if (Is_Dir($path."/".$entry)) {
    				f_rmDir($path."/".$entry);
    			} else {
    				@UnLink ($path."/".$entry);
    			}
    		}
    	}
    	$directory->close();
    	@RmDir($path);
    }
    
    /**
     * 디렉토리내의 모든 파일 삭제
     * @param string $path
     */
    static function rmAllFile($path) {
    	$directory = dir($path);
    	while($entry = $directory->read()) {
    		if ($entry != "." && $entry != "..") {
    			if (Is_Dir($path."/".$entry)) {
    				f_rmDir($path."/".$entry);
    			} else {
    				@UnLink ($path."/".$entry);
    			}
    		}
    	}
    	$directory->close();
    }

    
    /**
     * 파일명과 확장자를 붙여 온전한 파일명을 반환한다.
     * @param string $fileName
     * @param string $fileExt
     * @return string
     */
    static function mergeFileName($fileName,$fileExt){
    	return $fileName . ( $fileExt?"." .$fileExt:"");
    }
        
    //GD 로 파일 줄이기
    static function imgSizeChange($file,$save_filename, $save_path, $max_width, $max_height) {
        // $file 은 실제 이미지파일
        // $save_filename은 저장할 파일명
        // $save_path 은 저장할 파일경로
        // $max_width 는 저장할 파일의 가로최대크기
        // $max_height 는 저장할 파일의 세로최대크기
        if (eregi("jpg", $file) || eregi("gif", $file) || eregi("jpeg", $file) || eregi("png", $file)) {
            $img_info = getimagesize($file);
            if ($img_info[2] == 2) {
            $src_img = imagecreatefromjpeg($file);
            } else {
            return false;
            }

            $img_width = $img_info[0];
            $img_height = $img_info[1];

            if ($img_width <= $max_width) {
            $max_width = $img_width;
            $max_height = $img_height;
            }

            if ($img_width > $max_width) {
            $max_height = ceil(($max_width / $img_width) * $img_height);
            }

            $dst_img = imagecreatetruecolor($max_width, $max_height);
            imagecolorallocate($dst_img, 255, 255, 255);
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $max_width, $max_height, imagesx($src_img), imagesy($src_img));

            imageinterlace($dst_img);
            if (ereg("gif", $file))
            imagegif($dst_img, $save_path.$save_filename);
            else
            imagejpeg($dst_img, $save_path.$save_filename);

            imagedestroy($dst_img);
            imagedestroy($src_img);
        }
    }

    function file_wget_contents($url, $timeout=30, $option='') {
    	if($option) $option = ' ' . $option;
    	if ( strpos(strtoupper($_ENV['TERM']), 'XTERM') === false ) {
    		$fuid = $_ENV['TEMP'] . '\wget_tmp_' . md5($_SERVER['REMOTE_ADDR'] . microtime() . $url);
    		$cmd = 'C:\WEB_APP\util\wget "' . $url . '" -O "' . $fuid . '" --read-timeout=' . $timeout . $option;
    	} else {
    		$fuid = '/tmp/wget_tmp_' . md5($_SERVER['REMOTE_ADDR'] . microtime() . $url);
    		$cmd = 'wget "' . $url . '" -O "' . $fuid . '" --read-timeout=' . $timeout . $option;
    	}
    	//echo $cmd;
    	`$cmd`;
    	//exec($cmd);
    
    	$data = file_get_contents($fuid);
    	//exec("rm -rf $fuid");
    	`rm -rf $fuid`;
    	return $data;
    }
        
    /**
     * @param string $url
     * @param string $data
     * @param string $cType
     * @return string
     */
    static function get_url_fsockopen( $url,$data,$cType ) {
        $URL_parsed = parse_url($url);
        //$URL_parsed = parse_url("http://tkeapxidev.lm-erp.tkeasia.com:50000/rep/start/webstart_installation.jsp");
        //$rbyte = 512;
        $rbyte = 4096;
        $host = $URL_parsed["host"];
        $port = $URL_parsed["port"];
        if ($port==0) $port = 80;

        $path = $URL_parsed["path"];

        if ($URL_parsed["query"]) $path .= '?';
        $fp = fsockopen($host, $port, $errno, $errstr, 30);
        if (!$fp) {
            return "$errstr ($errno)<br>\\n";
        } else {
            fputs($fp, (!$data?'GET':'POST') . " $path" . $URL_parsed["query"] ." HTTP/1.0\r\n");
            //fputs($fp, "Accept-Language: ko\r\n");
            fputs($fp, "Host: $host\r\n");
            $cType = !$cType?"application/x-www-form-urlencoded;":$cType;
            fputs($fp, "Content-type: " . $cType . "\r\n");
            fputs($fp, "Content-length: ".strlen($data)."\r\n");
            fputs($fp, "\n");
            //fputs($fp, "Connection: close\r\n\r\n");
            fputs($fp, $data . "\r\n\r\n");

            $header = '';
            while (!feof($fp)) {
                $out = fgets ($fp,$rbyte);
                if (trim($out) == '') {
                    break;
                }
                $header .= $out;
            }

            $body = '';
            while (!feof($fp)) {
                $out = fgets ($fp,$rbyte);
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
            //header("Content-Type: text/xml; charset=utf-8");
            fclose ($fp);
            return $body;
    /**/
        }
    }

    static function returnMacAddress() {
        // This code is under the GNU Public Licence
        // Written by michael_stankiewicz {don't spam} at yahoo {no spam} dot com
        // Tested only on linux, please report bugs

        // WARNING: the commands 'which' and 'arp' should be executable
        // by the apache user; on most linux boxes the default configuration
        // should work fine

        // Get the arp executable path
        $location = `which arp`;
        // Execute the arp command and store the output in $arpTable
        $arpTable = `$location`;
        // Split the output so every line is an entry of the $arpSplitted array
        $arpSplitted = split("\n",$arpTable);
        // Get the remote ip address (the ip address of the client, the browser)
        $remoteIp = $GLOBALS['REMOTE_ADDR'];
        // Cicle the array to find the match with the remote ip address
        foreach ($arpSplitted as $value) {
        // Split every arp line, this is done in case the format of the arp
        // command output is a bit different than expected
        $valueSplitted = split(" ",$value);
        foreach ($valueSplitted as $spLine) {
        if (preg_match("/$remoteIp/",$spLine)) {
        $ipFound = true;
        }
        // The ip address has been found, now rescan all the string
        // to get the mac address
        if ($ipFound) {
        // Rescan all the string, in case the mac address, in the string
        // returned by arp, comes before the ip address
        // (you know, Murphy's laws)
        reset($valueSplitted);
        foreach ($valueSplitted as $spLine) {
        if (preg_match("/[0-9a-f][0-9a-f][:-]".
        "[0-9a-f][0-9a-f][:-]".
        "[0-9a-f][0-9a-f][:-]".
        "[0-9a-f][0-9a-f][:-]".
        "[0-9a-f][0-9a-f][:-]".
        "[0-9a-f][0-9a-f]/i",$spLine)) {
        return $spLine;
        }
        }
        }
        $ipFound = false;
        }
        }
        return false;
    }
    
    static function downHeader($file, $REAL_FILE) {
    	global $HTTP_USER_AGENT;
    	if( eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT) ) {
    		if(strstr($HTTP_USER_AGENT, "MSIE 5.5"))
    		{
    			header("Content-Type: doesn/matter");
    			if ( $file )  {
    				header("Content-Length: ".(string)(filesize("$file")));
    			}
    			header("Content-disposition: filename=$REAL_FILE");
    			header("Content-Transfer-Encoding: binary");
    			header("Pragma: no-cache");
    			header("Expires: 0");
    		}
    
    		if(strstr($HTTP_USER_AGENT, "MSIE 5.0"))
    		{
    			header("Content-type: file/unknown");
    			if ( $file )  {
    				header("Content-Length: ".(string)(filesize("$file")));
    			}
    			header("Content-Disposition: attachment; filename=$REAL_FILE");
    			header("Pragma: no-cache");
    			header("Expires: 0");
    		}
    
    		if(strstr($HTTP_USER_AGENT, "MSIE 5.1"))
    		{
    			header("Content-type: file/unknown");
    			if ( $file )  {
    				header("Content-Length: ".(string)(filesize("$file")));
    			}
    			header("Content-Disposition: attachment; filename=$REAL_FILE");
    			header("Pragma: no-cache");
    			header("Expires: 0");
    		}
    
    		if(strstr($HTTP_USER_AGENT, "MSIE 6.0"))
    		{
    			header("Content-type: file/unknown");
    			if ( $file )  {
    				header("Content-Length: ".(string)(filesize("$file")));
    			}
    			header("Content-Disposition: attachment; filename=$REAL_FILE");
    			header("Content-Transfer-Encoding: binary");
    			header("Pragma: no-cache");
    			header("Expires: 0");
    		}
    	} else {
    		header("Content-type: file/unknown");
    		if ( $file )  {
    			header("Content-Length: ".(string)(filesize("$file")));
    		}
    		header("Content-Disposition: attachment; filename=$REAL_FILE");
    		header("Pragma: no-cache");
    		header("Expires: 0");
    	}
    }
    /**
    * 함수명: list
    * 조회
    **/
    static function getPost($argus) {
        $s_search = $argus[s_search];
      //echo '$s_search : ' . $s_search . '<br>';
      //echo 'SITE : ' . SERVICE. '<br>';
      //include UI_DIR . '/Common_list.php';

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

           // $xw->startDocument('1.0','UTF-8');
            //$xw->startDocument('1.0','euc-kr');
            $xw->startElement('post');
                $xw->startElement('itemlist');
                //echo 'val : ' . mb_strlen ($query,'EUC-KR') . ' / ' . $val;

                //$myFilter = new InputFilter();
                //$s_search = $myFilter->safeSQL($s_search, $connection);
                $s_search = str_replace('%','', $s_search);

                //echo mb_strlen ($s_search,'UTF-8');
                if ( mb_strlen ($s_search,'UTF-8') >= 2 ) {

                    $s_search = mysql_real_escape_string($s_search);

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
                       //. " WHERE DONG LIKE '%" . iconv('EUC-KR', 'UTF-8', $s_search) . "%'"
                         . " WHERE DONG LIKE '%" . $s_search . "%'";
                       //. " LIMIT 10";
                    //echo 'sql : ' . $sql;
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
    }
    
    /**
    * 함수명: list
    * 조회
    **/
    static function getPostOpenAPI($argus) {
        $s_search = $argus[s_search];

        define('REGKEY', 'ec11f8dd4840a7d701235800871923');

        session_cache_limiter('none');
        $host = 'http://' . getenv('HTTP_HOST');

        if ($host != substr(getenv('HTTP_REFERER'), 0, strlen($host))){
            header("HTTP/4.0 404 Not Found");
        } else {
            header("content-type: application/xml");
            //header("content-type: text/xml");
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");

            //echo $s_search;
            if ( mb_strlen ($s_search,'UTF-8') >= 2 ) {
                $encodedquery = urlencode($s_search);
                $url = "http://biz.epost.go.kr/KpostPortal/openapi?regkey=" . REGKEY . "&target=post&query=".$s_search;
                $xml = get_url_fsockopen($url);
            }
            echo iconv("EUC-KR", "UTF-8", $xml);
        }
    }

    /**
    * 함수명: list
    * 조회
    **/
    static function getNaverGeocode($argus) {
        $s_search = $argus[s_search];

        define('REGKEY', 'ec11f8dd4840a7d701235800871923');

        session_cache_limiter('none');
        $host = 'http://' . getenv('HTTP_HOST');

        if ($host != substr(getenv('HTTP_REFERER'), 0, strlen($host))){
            header("HTTP/4.0 404 Not Found");
        } else {
            header("content-type: application/xml");
            //header("content-type: text/xml");
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");

            //echo $s_search;
            if ( mb_strlen ($s_search,'UTF-8') >= 2 ) {
                $encodedquery = urlencode($s_search);
                $url = "http://map.naver.com/api/geocode.php?key=" + REGKEY + "&query=" . $s_search;
                $xml = get_url_fsockopen($url);
            }
            echo iconv("EUC-KR", "UTF-8", $xml);
        }
    }

    /**
    * 함수명: list
    * 조회
    **/
    static function getNaverGeocodeToXY($s_search) {
        //echo '$s_search : ' . $s_search ;
        define('REGKEY', '01ec9fd3b19628ee1ee18575f849f99b');

        session_cache_limiter('none');
        $host = 'http://' . getenv('HTTP_HOST');

        //if ($host != substr(getenv('HTTP_REFERER'), 0, strlen($host))){
        //    header("HTTP/4.0 404 Not Found");
        //} else {
        //    header("content-type: text/html");
        //    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        //    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        //    header("Cache-Control: no-store, no-cache, must-revalidate");
        //    header("Cache-Control: post-check=0, pre-check=0", false);
        //    header("Pragma: no-cache");

            $s_search = iconv("UTF-8", "EUC-KR", $s_search);

            //echo $s_search;
            //if ( mb_strlen ($s_search,'UTF-8') >= 2 ) {
                //$s_search = urldecode($s_search);
                $url = "http://map.naver.com/api/geocode.php?key=" . REGKEY . "&query=" . $s_search ;
                //echo $url;
                $xml = get_url_fsockopen($url,null,null);
            //}
            //$xml = iconv("EUC-KR", "UTF-8", $xml);
            $xDom = simplexml_load_string($xml);
            $p = new Geocode($xDom->item[0]->point->x,$xDom->item[0]->point->y);
            return $p;
        //}
    }

    /**
    * 함수명: createGory
    * 설명  : 카테고리명을 tagName 태그를 이용해 화면에 출력합니다.
    *         예)  createGory ('S',SELECT);   //SELECT Box 조회
    *              createGory ('R',RADIO );   //RADIO  Box 조회
      $tagName : 'SELECT'      >> SELECT Box
               : 'RADIO'       >> RADIO  Box
               : 'CHECKBOX'    >> CHECK  Box
    **/
    static function createGory ($tagName='SELECT', $creategory, $proc='1') {
        $creategory_setup = $creategory[setup];
        unset( $creategory[setup] );

        $tagName    = strtoupper($tagName);
        $_prop_name = $creategory_setup['prop_name'];
        if ( !$_prop_name ) $_prop_name = 'division';

        if ( is_array($creategory) ) {
            //ksort ( $creategory );
            reset ( $creategory );
            //ksort ( $creategory['name'] );
            //reset ( $creategory['name'] );
        }
        $_rtn  = '';
        $_rtn .= $creategory_setup['start_tag'];
        if ( $tagName == 'SELECT' || $tagName == 'IBT:SELECT' || !$tagName ) {
            //if ( $creategory_setup['item_align'] == 'right' ) $item_align = "style='direction:rtl'";
            //else $item_align = "style='direction:ltr'";

            if ( $tagName == 'SELECT' ) {
                $optName = 'OPTION';
            } else if ( $tagName == 'IBT:SELECT' ) {
                $tagName = 'ibt:SELECT';
                $optName = 'ibt:OPTION';
            }

            $_rtn  = '<' . $tagName . ( $tagName == 'SELECT'? ( " id='" . $_prop_name . "' "):'' ) ." name='" . $_prop_name . "' " . $creategory_setup['properties'] . ' ' . $creategory_setup['script'] . ' ' . $item_align . '>' . "\r\n";

            if ( $creategory_setup['title'] ) $_rtn .= '<' . $optName . " value='" . $creategory_setup['title_value'] . "'>" . $creategory_setup['title'] . '</' . $optName . '>';
            if ( $creategory_setup['insert_tag'] ) $_rtn .= $creategory_setup['insert_tag'];
            if ( is_array($creategory) ) {
                while (list ($key, $val) = each ($creategory)) {
                    if ( $creategory_setup['select'] != '' && $creategory_setup['select'] == $key ) { $checked = 'selected'; } else { $checked = ''; }
                    if ( $proc == '1' ) {
                        if ( $checked ) { $_rtn .= $creategory_setup['active_start_tag'  ]; }
                        $_rtn .= '<' . $optName . " value='".$key."' $checked>".$val . '</' . $optName . '>';
                        if ( $checked ) { $_rtn .= $creategory_setup['active_end_tag'    ]; }
                    } else if ( $proc == '2' ) {
                        if ( !$checked ) {
                            if ( $checked ) { $_rtn .= $creategory_setup['active_start_tag'  ]; }
                            $_rtn .= '<' . $optName . " value='".$key."' $checked>".$val . '</' . $optName . '>';
                            if ( $checked ) { $_rtn .= $creategory_setup['active_end_tag'    ]; }
                        }
                    }
                }
            }
            if ( $creategory_setup['append_tag'] ) $_rtn .= $creategory_setup['append_tag'];

            $_rtn .= "\r\n" . '</' . $tagName . '>';
            //echo "<textarea>$_rtn</textarea>";
        } else if ( $tagName == 'RADIO' ) {
            if ( is_array($creategory) ) {
            if ( $creategory_setup['insert_tag'] ) $_rtn .= $creategory_setup['insert_tag'];
                while (list ($key, $val) = each ($creategory)) {
                    $_rtn .= $creategory_setup['loop_start_tag'];
                    $checked = '';
                    if ( $creategory_setup['select'] != '' && $creategory_setup['select'] == $key ) { $checked = 'checked'; } else { $checked = ''; }

                    if ( $creategory_setup['item_align'] == 'right' ) {
                        if ( $checked ) { $_rtn .= $creategory_setup['active_start_tag'  ]; }
                        $_rtn .= "\n" . $val . "<input type='radio' name='$_prop_name' value='". $key ."' $checked " . $creategory_setup['properties'] . " " . $creategory_setup['script'] . ">";
                        if ( $checked ) { $_rtn .= $creategory_setup['active_end_tag'    ]; }
                    } else {
                        if ( $checked ) { $_rtn .= $creategory_setup['active_start_tag'  ]; }
                        $_rtn .= "\n<input type='radio' name='$_prop_name' value='". $key ."' $checked " . $creategory_setup['properties'] . " " . $creategory_setup['script'] . ">" . $val;
                        if ( $checked ) { $_rtn .= $creategory_setup['active_end_tag'    ]; }
                    }
                    $_rtn .= $creategory_setup['loop_end_tag'];
                }
                if ( $creategory_setup['append_tag'] ) $_rtn .= $creategory_setup['append_tag'];
            }
        } else if ( $tagName == 'CHECKBOX' ) {
            if ( is_array($creategory) ) {
                if ( $creategory_setup['insert_tag'] ) $_rtn .= $creategory_setup['insert_tag'];
                while (list ($key, $val) = each ($creategory)) {
                    $_rtn .= $creategory_setup['loop_start_tag'];
                    $checked = '';
                    if ( is_array($creategory_setup['select']) ) {
                        $chkSize = sizeof($creategory_setup['select']);
                        //echo '배열 : ' .  $chkSize;
                        for ($i=0;$i<$chkSize;$i++) {
                            if ( $creategory_setup['select'][$i] != '' && $creategory_setup['select'][$i] == $key ) {
                                $checked = 'checked';
                                break;
                            } else {
                                $checked = '';
                            }
                        }
                    } else {
                        if ( $creategory_setup['select'] != '' && $creategory_setup['select'] == $key ) { $checked = 'checked'; } else { $checked = ''; }
                    }

                    if ( $creategory_setup['item_align'] == 'right' ) {
                        if ( $checked ) { $_rtn .= $creategory_setup['active_start_tag'  ]; }
                        $_rtn .= "\n" . $val . "<input type='checkbox' name='$_prop_name' value='". $key ."' $checked $event_script " . $creategory_setup['properties'] . " " . $creategory_setup['script'] . ">";
                        if ( $checked ) { $_rtn .= $creategory_setup['active_end_tag'    ]; }
                    } else {
                        if ( $checked ) { $_rtn .= $creategory_setup['active_start_tag'  ]; }
                        $_rtn .= "\n<input type='checkbox' name='$_prop_name' value='". $key ."' $checked $event_script " . $creategory_setup['properties'] . " " . $creategory_setup['script'] . ">" . $val;
                        if ( $checked ) { $_rtn .= $creategory_setup['active_end_tag'    ]; }
                    }

                    $_rtn .= $creategory_setup['loop_end_tag'];
                }
                if ( $creategory_setup['append_tag'] ) $_rtn .= $creategory_setup['append_tag'];
            }
        } else {
            if ( is_array($creategory) ) {
                if ( $creategory_setup['insert_tag'] ) $_rtn .= $creategory_setup['insert_tag'];
                while (list ($key, $val) = each ($creategory)) {
                    $_rtn .= $creategory_setup['loop_start_tag'];
                    $checked = '';
                    if ( $creategory_setup['select'] != '' && $creategory_setup['select'] == $key ) { $checked = 'checked'; } else { $checked = ''; }

                    if ( $checked ) { $_rtn .= $creategory_setup['active_start_tag'  ]; }
                    $_rtn .= "\n<$tagName name='$_prop_name' value='". $key ."' " . $creategory_setup['properties'] . " " . $creategory_setup['script'] . ">";
                    $_rtn .= $val;
                    $_rtn .= "\n</" . $tagName . ">";
                    if ( $checked ) { $_rtn .= $creategory_setup['active_end_tag'    ]; }

                    $_rtn .= $creategory_setup['loop_end_tag'];
                }
                if ( $creategory_setup['append_tag'] ) $_rtn .= $creategory_setup['append_tag'];
            }
        }
        $_rtn .= $creategory_setup['end_tag'];
        $creategory_setup='';
        return $_rtn;
    }

    /**
    * 함수명: arrangeFormElement
    * 설명  : 열거형 폼 엘리먼트 만들기
    * 예)  arrangeFormElement("테이블명", "데이터베이스명");
    * Argus : $type  : select, radio, checkbox
    *       : $name  : 이름
    *       : $frm   : 시작값
    *       : $to    : 종료값
    *       : $script: 스크립트
    *       : $inc   : 증가값
    *       : $sel   : 선택값 ( 2001, checkbox : '2001,2002' )
    *       : $title : 타이틀
    *       : $nextStr : 뒷쪽에 추가될 문자열
    *       : $preStr  : 앞쪽에 추가될 문자열
    * 예제
    *   Util::arrangeFormElement ('select','test', 2000,2010,"", 1, '2001', '제목', '년');
    *   Util::arrangeFormElement ('radio','test', 2000,2010,"", 1, '2001', '제목', '년');
    *   Util::arrangeFormElement ('checkbox','test', 2000,2010,"", 1, '2001', '제목', '년');
    **/
    static function arrangeFormElement ($type, $name, $frm=0, $to=0, $script='', $inc=1, $sel='', $title='', $nextStr='', $preStr='') {
        if ( strtoupper ( $type ) == 'SELECT' || strtoupper ( $type ) == 'IBT:SELECT' ) {
            return Util::listBoxElement ($type,$name, $frm, $to, $script, $inc, $sel, $title, $nextStr, $preStr);
        } else if ( strtoupper ( $type ) == 'RADIO' ) {
            return Util::radioBoxElement ($name, $frm, $to, $script, $inc, $sel, $title, $nextStr, $preStr);
        } else if ( strtoupper ( $type ) == 'CHECKBOX' ) {
            return Util::checkBoxElement ($name, $frm, $to, $script, $inc, $sel, $title, $nextStr, $preStr);
        }
    }

    static function listBoxElement ($type,$name, $frm=0, $to=0, $script='', $inc=1, $sel='', $title, $nextStr='', $preStr='') {
        $inc =  abs ($inc);

        $tagName = strtoupper($type);
        $optName = '';

        if ( $tagName == 'SELECT' ) {
            $optName = 'OPTION';
        } else if ( $tagName == 'IBT:SELECT' ) {
            $tagName = 'ibt:SELECT';
            $optName = 'ibt:OPTION';
        }

        $_rtn = "<$tagName name='$name' $script>\n";
        if ( $title ) $_rtn .= "<$optName value=''>" . $title . "</$optName>\n";
        if ( $frm > $to ) {
            for ( $i=$frm; $i>=$to; $i-=$inc ) {
                if ( (string)$i == (string)$sel ) $selected = 'selected';
                else                              $selected = '';
                $_rtn .= "<$optName value='$i' $selected>" . $preStr . $i . $nextStr . "</$optName>\n";
            }
        } else {
            for ( $i=$frm; $i<=$to; $i+=$inc ) {
                if ( (string)$i == (string)$sel ) $selected = 'selected';
                else                              $selected = '';
                $_rtn .= "<$optName value='$i' $selected>" . $preStr . $i . $nextStr . "</$optName>\n";
            }
        }
        $_rtn .= "</$tagName>\n";
        return $_rtn;
    }

    static function radioBoxElement ($name, $frm=0, $to=0, $script='', $inc=1, $sel='', $title='', $nextStr='', $preStr='') {
        $inc =  abs ($inc);
        $_rtn = "";
        if ( $title ) $_rtn .= $title;
        if ( $frm > $to ) {
            for ( $i=$frm; $i>=$to; $i-=$inc ) {
                if ( (string)$i == (string)$sel ) $checked = 'checked';
                else                              $checked = '';
                $_rtn .= "<input type='radio' name='$name' value='$i' $script $checked>" . $preStr . $i . $nextStr . "\n";
            }
        } else {
            for ( $i=$frm; $i<=$to; $i+=$inc ) {
                if ( (string)$i == (string)$sel ) $checked = 'checked';
                else                              $checked = '';
                $_rtn .= "<input type='radio' name='$name' value='$i' $script $checked>" . $preStr . $i . $nextStr . "\n";
            }
        }
        return $_rtn;
    }

    static function checkBoxElement ($name, $frm=0, $to=0, $script='', $inc=1, $sel='', $title='', $nextStr='', $preStr='') {
        $inc =  abs ($inc);
        $_rtn = "";
        if ( $title ) $_rtn .= $title;
        if ( $frm > $to ) {
            for ( $i=$frm; $i>=$to; $i-=$inc ) {
    //            echo " $sel / $i <BR>";
                if ( strpos ( ' ' . $sel, '' . $i ) == true) { $checked = 'checked';}
                else $checked = '';
                $_rtn .= "<input type='checkbox' name='$name' value='$i' $script $checked>" . $preStr . $i . $nextStr . "\n";
            }
        } else {
            for ( $i=$frm; $i<=$to; $i+=$inc ) {
                if ( strpos ( ' ' . $sel, '' . $i ) == true) { $checked = 'checked';}
                else $checked = '';
                $_rtn .= "<input type='checkbox' name='$name' value='$i' $script $checked>" . $preStr . $i . $nextStr . "\n";
            }
        }
        return $_rtn;
    }
}

class Geocode
{
    var $x = 0;
    var $y = 0;
    function Geocode($x,$y) {
        $this->x = $x;
        $this->y = $y;
    }
}
//CommonService::getList($s_user_id);
//echo 'ss';
?>