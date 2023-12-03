<?
session_start();
//echo print_r($_POST);
//echo print_r($_GET);
$mode = $_GET['mode']!=''?$_GET['mode']:$_POST['mode'];
//echo 'mode : ' . $mode;
if ( $mode == 'get_open_index' ) {
    $open_index = (int)$_SESSION["upfile"]['open_index'];
    if ( $_SESSION["upfile"] ) {
        $open_index++;
        $_SESSION["upfile"]['open_index'] = $_SESSION["upfile"]['open_index'] + 1;
    } else {
        $open_index = 1;
        $_SESSION["upfile"]['open_index'] = 1;
    }
   echo $_SESSION["upfile"]['open_index'];
} else if ( $mode == 'get_size_info' ) {
    $p_open_index = $_GET['p_open_index']!=''?$_GET['p_open_index']:$_POST['p_open_index'];

    $OS = (strstr($_SERVER["SERVER_SOFTWARE"],"Win32"))?"win":"unix";
    function sort_by_mtime($file1,$file2) {
        $time1 = filemtime($file1);
        $time2 = filemtime($file2);
        if ($time1 == $time2) return 0;
        return ($time1 < $time2) ? 1 : -1;
    }

    $rescan = 0;
    if(!$_SESSION["upfile"]["tmp_name"]) $rescan = 1;																// 첫번째 스캔
    elseif(!file_exists($_SESSION["upfile"]["tmp_name"])) $rescan = 1;											// 예전의 업로드 기록
    elseif($_SESSION["upfile"]["size"] == filesize($_SESSION["upfile"]["tmp_name"])) $rescan = 1;		// 파일크기가 불변(업로드 완료)
    if($rescan){ 
        $upload_tmp = !ini_get('upload_tmp_dir')?$_ENV["TEMP"]:ini_get('upload_tmp_dir');
        if($OS=="win") $tmp_files = @glob($upload_tmp."/[p][h][p]*",GLOB_NOSORT);
        if($OS=="unix") $tmp_files = @glob("/tmp"."/[p][h][p]*",GLOB_NOSORT);
        if($OS=="unix") usort($tmp_files,"sort_by_mtime");
//echo $upload_tmp."\php*";
        for($i=0;$i<count($tmp_files);$i++) { 
            if($OS=="win"){
                if($_SESSION["upfile"]["tmp_name"]<$tmp_files[$i]){
                    $_SESSION["upfile"]["tmp_name"] = $tmp_files[$i];
                    $_SESSION["upfile"]["size"] = filesize($tmp_files[$i]);
                    break;		
                }
            }
            echo $tmp_files[$i] . ';';

            if($OS=="unix"){
                if($_SESSION["upfile"]["tmp_name"]!=$tmp_files[$i]){
                    $_SESSION["upfile"]["tmp_name"] = $tmp_files[$i];
                    $_SESSION["upfile"]["size"] = filesize($tmp_files[$i]);
                    break;		
                }
            }
        } 
    }else{	
        $_SESSION["upfile"]["size"] = filesize($_SESSION["upfile"]["tmp_name"]);
    }

    setCookie("ZUfileSize",$_SESSION['upfile']["size"],0,"");

    header("Expires:Mon,26 Jul 1997 05:00:00 GMT");
    header("Last-Modified:".gmdate("D,d M Y H:i:s")."GMT");
    header("Cache-Control:no-cache,must-revalidate");
    header("Content-Type: image/gif");

    echo 'file_size  : ' . $_SESSION['upfile']["size"] . '<BR>';
    echo 'upload_tmp : ' . $upload_tmp . '<BR>';
}

exit;
//echo 'i : ' . $i . ' / ' . $_SESSION["upfile"]['name'] . ' / ' . 
if(!$_SESSION["upfile"]["tmp_name"] ||
    !file_exists($_SESSION["upfile"]["tmp_name"]) ||
    time()-filemtime($_SESSION["upfile"]["tmp_name"]) > 5 || 
    $_SESSION["upfile"]["size"] == @filesize($_SESSION["upfile"]["tmp_name"]) ) {

    //$upload_tmp_dir = dirname($_FILES[$k][tmp_name]);
    //echo 'upload_tmp_dir : ' . ini_get('upload_tmp_dir') . '<BR>';
    //echo 'upload_tmp_dir : ' . dirname($_FILES[$k][tmp_name]) . '<BR>';

    $upload_tmp_dir = $_SESSION["upfile"]["upload_tmp_dir"];
    echo 'upload_tmp_dir : ' . $upload_tmp_dir . '<BR>';

    $_SESSION["upfile"]["size"] == @filesize($_SESSION["upfile"]["tmp_name"]); 
	$tmp_files = @glob($upload_tmp_dir."/[p][h][p]*",GLOB_NOSORT);
	//$tmp_files = @glob("/tmp"."/[p][h][p]*",GLOB_NOSORT);
	for($i=0;$i<count($tmp_files);$i++) { 
		if($_SESSION["upfile"]["tmp_name"] != $tmp_files[$i] && time()-filemtime($tmp_files[$i])<5){
			$_SESSION["upfile"]["tmp_name"] = $tmp_files[$i];
			$_SESSION["upfile"]["size"] = @filesize($tmp_files[$i]);
			break;		
		}else{
			$_SESSION["upfile"]["tmp_name"] = null;
			$_SESSION['upfile']["size"] = 0;
		}
	} 

}else{
	$_SESSION["upfile"]["size"] = @filesize($_SESSION["upfile"]["tmp_name"]);
}
setCookie("ZUfileSize",$_SESSION['upfile']["size"],0,"/");

header("Expires:Mon,26 Jul 1997 05:00:00 GMT");
header("Last-Modified:".gmdate("D,d M Y H:i:s")."GMT");
header("Cache-Control:no-cache,must-revalidate");
header("Content-Type: image/gif");

echo $_SESSION["upfile"]["size"];
/*
session_start();
if(!$_SESSION["upfile"]["tmp_name"] || !file_exists($_SESSION["upfile"]["tmp_name"]) || time()-filemtime($_SESSION["upfile"]["tmp_name"])>5 || $_SESSION["upfile"]["size"] == @filesize($_SESSION["upfile"]["tmp_name"])){ 
	$tmp_files = @glob("/tmp"."/[p][h][p]*",GLOB_NOSORT);
	for($i=0;$i<count($tmp_files);$i++) { 
		if($_SESSION["upfile"]["tmp_name"] != $tmp_files[$i] && time()-filemtime($tmp_files[$i])<5){
			$_SESSION["upfile"]["tmp_name"] = $tmp_files[$i];
			$_SESSION["upfile"]["size"] = @filesize($tmp_files[$i]);
			break;		
		}else{
			$_SESSION["upfile"]["tmp_name"] = null;
			$_SESSION['upfile']["size"] = 0;
		}
	} 

}else{
	$_SESSION["upfile"]["size"] = @filesize($_SESSION["upfile"]["tmp_name"]);
}
setCookie("ZUfileSize",$_SESSION['upfile']["size"],0,"/");

header("Expires:Mon,26 Jul 1997 05:00:00 GMT");
header("Last-Modified:".gmdate("D,d M Y H:i:s")."GMT");
header("Cache-Control:no-cache,must-revalidate");
header("Content-Type: image/gif");
*/
?>