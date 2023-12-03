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
    if ( $_SESSION["upfile"] ) {
        //if ((int)$_SESSION["upfile"]['open_index']>0) {
        if ($p_open_index > 0) {
            //echo $p_open_index . '<BR>';
            //$fSize=filesize($_SESSION["upfile"]['tmp_name'][$p_open_index]);
            //setCookie("ZUfileSize",'¹Ùº¸ ' . $_SESSION["upfile"]['name'][$p_open_index] . ' / ' . 
            //     $fSize . ' / ' . 
            //     $_SESSION["upfile"]['tmp_name'][$p_open_index] . ' / ',0,"");*/
            header("Expires:Mon,26 Jul 1997 05:00:00 GMT");
            header("Last-Modified:".gmdate("D,d M Y H:i:s")."GMT");
            header("Cache-Control:no-cache,must-revalidate");
            header("Content-Type: image/gif");
            setCookie("ZUfileSize",$_SESSION["upfile"]['name'][$p_open_index] . '||' . $_SESSION["t"],0,"/");
            //echo 's : ' . $_SESSION["upfile"]['name'][$p_open_index] . ' / ' . 
            //$fSize . ' / ' . 
            //$_SESSION["upfile"]['tmp_name'][$p_open_index] . ' / ';
        }
    }

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