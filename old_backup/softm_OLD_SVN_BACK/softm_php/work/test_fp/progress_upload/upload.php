<?
include ( './lib.inc'            );
include ( './file.inc'           );
include ( './FileUpload.inc'     ); // ���� ���ε� Ŭ����
include ( './setup.inc'          );
//echo ini_get('upload_tmp_dir');
if ( $OS=='win' ) {
//echo SAVE_DIR . $p_open_index . '_' . $_REQUEST["PHPSESSID"];
    $_ENV[TMPDIR] = 'E:/okmmc_doc/progress_upload/updata/1';
} else {
    $_ENV[TMP] = 'E:/okmmc_doc/progress_upload/updata/1';
}

$upFile  = FileUpload ( ); // ���ε� �ν��Ͻ� ����
$exec = true;

$uploadCnt = sizeof($HTTP_POST_FILES); // ���� ���ε� ����

session_start();
echo $p_open_index;
if ( $uploadCnt > 0 && $p_open_index > 0 ) {
    while (list($k, $v) = each ($_FILES)) {
          //$fext = getFileExtraName($_FILES[$k][name]);
          //$fsize = @filesize($_FILES[$k][tmp_name]);
            $upFile->addUploadFile ($_FILES[$k], SAVE_DIR , $_FILES[$k][name], "inc^php3^php4^php^bat^sh^phtml^shtml^htm^html^asp^", 100);
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
    if ( !$exec ) {
        $errMsg = array_unique ( $errMsg );
        javascriptExec("alert('" . join ( '\n', $errMsg) . "');");
        echo '��������';
    } else {
        echo '��������';
        $upFile->Upload(); // ���ε� ����
    }
}
    javascriptExec("parent._pfu.end()");
ob_end_flush();

/*
$file_temp = $_FILES['file']['tmp_name'];
$file_name = $_FILES['file']['name'];
$file_size = $_FILES['file']['size'];
$updir = "D:/Project/okmmc_doc/fileUpload-debug/updata";
if(!empty($file_name)){
 $filename = sprintf("%s/%s",$updir,$file_name);
 $filename = iconv("UTF-8", "EUC-KR",$filename);  // �ѱ�ó��
 if(!file_exists($filename)) {
  if(move_uploaded_file($file_temp,$filename)){
  } else {
  }
 }
}
fclose($fp);
*/
?>