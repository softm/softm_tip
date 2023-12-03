<?
/*
* include 되었는지를 검사
**/
function f_size($size=0) {
	if ( $size >= 1073741824 ) {
		$size = round ( $size / 1073741824,2).' GB';
	} else if ( $size >= 1048576 ) {
		$size = round ( $size / 1048576 ,2).' MB';
	} else if ( $size >= 1024 ) {
		$size = round ( $size / 1024 ,2).' KB';
	} else {
		$size = $size . ' byte';
	}
	return $size;
}

function getFileExtraName($val)
{
	$rtnStr = $val;

	$e  = 0;
	$e = strrpos($rtnStr,".");
	if ( $e > 0 ) {
		$rtnStr = substr( $rtnStr, $e + 1 );
	} else {
		$rtnStr = '';
	}
	return $rtnStr;
}

function getFileName($val)
{
	$rtnStr = $val;

	$e  = 0;
	$e = strrpos($rtnStr,".");
	if ( $e > 0 ) {
		$rtnStr = substr( $rtnStr, 0, $e );
	} else {
		$rtnStr = '';
	}
	return $rtnStr;
}

function getPerms( $in_Perms ) {
	$sP;

	if($in_Perms & 0x1000)	 // FIFO pipe
	 $sP = 'p';
	elseif($in_Perms & 0x2000) // Character special
	 $sP = 'c';
	elseif($in_Perms & 0x4000) // Directory
	 $sP = 'd';
	elseif($in_Perms & 0x6000) // Block special
	 $sP = 'b';
	elseif($in_Perms & 0x8000) // Regular
	 $sP = '&minus;';
	elseif($in_Perms & 0xA000) // Symbolic Link
	 $sP = 'l';
	elseif($in_Perms & 0xC000) // Socket
	 $sP = 's';
	else					   // UNKNOWN
	 $sP = 'u';

	// owner
	$sP .= (($in_Perms & 0x0100) ? 'r' : '&minus;') .
		  (($in_Perms & 0x0080) ? 'w' : '&minus;') .
		  (($in_Perms & 0x0040) ? (($in_Perms & 0x0800) ? 's' : 'x' ) :
								  (($in_Perms & 0x0800) ? 'S' : '&minus;'));

	// group
	$sP .= (($in_Perms & 0x0020) ? 'r' : '&minus;') .
		  (($in_Perms & 0x0010) ? 'w' : '&minus;') .
		  (($in_Perms & 0x0008) ? (($in_Perms & 0x0400) ? 's' : 'x' ) :
								  (($in_Perms & 0x0400) ? 'S' : '&minus;'));

	// world
	$sP .= (($in_Perms & 0x0004) ? 'r' : '&minus;') .
		  (($in_Perms & 0x0002) ? 'w' : '&minus;') .
		  (($in_Perms & 0x0001) ? (($in_Perms & 0x0200) ? 't' : 'x' ) :
								  (($in_Perms & 0x0200) ? 'T' : '&minus;'));
	return $sP;
};

// 파일 삭제
function f_unlink($filename,$wildCard=false) {
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
function f_readFile($filename) {
	if(!file_exists($filename)) return '';

	$f = fopen($filename,"r");
	$str = @fread($f, filesize($filename));
	fclose($f);

	return $str;
}

// 파일 작성
function f_writeFile($filename, $str) {
	$f = fopen($filename,"w");
	$lock=flock($f,2);
	if($lock) {
		fwrite($f,$str);
	}
	flock($f,3);
	fclose($f);
}

// 디렉토리내의 모든 디렉토리 및 파일 삭제
function f_rmDir($path) {
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

// 디렉토리내의 모든 파일 삭제
function f_rmAllFile($path) {
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

function downHeader($file, $REAL_FILE) {
    global $HTTP_USER_AGENT;
    if( eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT) ) {
        if(strstr($HTTP_USER_AGENT, "MSIE 5.5"))
        {
            header("Content-Type: doesn/matter");
            if ( $file )  { header("Content-Length: ".(string)(filesize("$file"))); }
            header("Content-disposition: filename=$REAL_FILE");
            header("Content-Transfer-Encoding: binary");
            header("Pragma: no-cache");
            header("Expires: 0");
        }

        if(strstr($HTTP_USER_AGENT, "MSIE 5.0"))
        {
            header("Content-type: file/unknown");
            if ( $file )  { header("Content-Length: ".(string)(filesize("$file"))); }
            header("Content-Disposition: attachment; filename=$REAL_FILE");
            header("Pragma: no-cache");
            header("Expires: 0");
        }

        if(strstr($HTTP_USER_AGENT, "MSIE 5.1"))
        {
            header("Content-type: file/unknown");
            if ( $file )  { header("Content-Length: ".(string)(filesize("$file"))); }
            header("Content-Disposition: attachment; filename=$REAL_FILE");
            header("Pragma: no-cache");
            header("Expires: 0");
        }

        if(strstr($HTTP_USER_AGENT, "MSIE 6.0"))
        {
            header("Content-type: file/unknown");
            if ( $file )  { header("Content-Length: ".(string)(filesize("$file"))); }
            header("Content-Disposition: attachment; filename=$REAL_FILE");
            header("Content-Transfer-Encoding: binary");
            header("Pragma: no-cache");
            header("Expires: 0");
        }
    } else {
        header("Content-type: file/unknown");
        if ( $file )  { header("Content-Length: ".(string)(filesize("$file"))); }
        header("Content-Disposition: attachment; filename=$REAL_FILE");
        header("Pragma: no-cache");
        header("Expires: 0");
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
?>