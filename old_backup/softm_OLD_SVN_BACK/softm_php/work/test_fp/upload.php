<?
include ( './lib.inc'            );
include ( './file.inc'           );
include ( './FileUpload.inc'     ); // 파일 업로드 클래스
include ( './setup.inc'          );
//echo ini_get('upload_tmp_dir');
$upFile  = FileUpload ( ); // 업로드 인스턴스 생성
$exec = true;
$chk = false;

$uploadCnt = sizeof($HTTP_POST_FILES); // 파일 업로드 갯수

session_start();
if ( $uploadCnt > 0 ) {
    while (list($k, $v) = each ($_FILES)) {
        //$fext = getFileExtraName($_FILES[$k][name]);
        if ( $_FILES[$k][tmp_name] ) {
            $fsize = @filesize($_FILES[$k][tmp_name]);
            //$tmp_name = $_FILES[$k][tmp_name];
            //$name = $_FILES[$k][name];
            //echo $k . ' / ' . $fsize;
            $upFile->addUploadFile ($_FILES[$k], SAVE_DIR , $_FILES[$k][name], "inc^php3^php4^php^bat^sh^phtml^shtml^htm^html^asp^", 100);
            $chk = true;
        }
    }
    $errMsg = array();
    for ( $i=0; $i<$uploadCnt ; $i++ ) {
        if ( sizeof($upFile->error[$i]) > 0 ) {
            for ( $j=0; $j<sizeof($upFile->error[$i]); $j++ ) {
                $errMsg[] = $upFile->error[$i][$j];
            }
            $exec= false;
        }
    }
    if ( $chk ) {
        if ( !$exec ) {
            $errMsg = array_unique ( $errMsg );
            javascriptExec("alert('" . join ( '\n', $errMsg) . "');");
            javascriptExec("parent._pfu.sync(-1)");
        } else {
            javascriptExec("parent._pfu.sync('" . $fsize . "')");
            $upFile->Upload(); // 업로드 시작
            //echo $tmp_name;
            //echo SAVE_DIR . $name;
        }
    } else {
        echo '파일이 없습니다.';
    }
} else {
    echo '파일이 없습니다.';
}

/*
$file_temp = $_FILES['file']['tmp_name'];
$file_name = $_FILES['file']['name'];
$file_size = $_FILES['file']['size'];
$updir = "D:/Project/okmmc_doc/fileUpload-debug/updata";
if(!empty($file_name)){
 $filename = sprintf("%s/%s",$updir,$file_name);
 $filename = iconv("UTF-8", "EUC-KR",$filename);  // 한글처리
 if(!file_exists($filename)) {
  if(move_uploaded_file($file_temp,$filename)){
  } else {
  }
 }
}
fclose($fp);
*/
?>