<?
/*
* include 되었는지를 검사
**/
if( defined("_dboard_file_included") ) return;
	define ("_dboard_file_included", true);

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
function f_unlink($filename) {
	@chmod($filename,0777);
	$handle = @unlink($filename);
	if(@file_exists($filename)) {
		@chmod($filename,0775);
		$handle=@unlink($filename);
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
?>