<?
include ( './lib.inc'            );
include ( './file.inc'           );
include ( './FileUpload.inc'     ); // ���� ���ε� Ŭ����
include ( './setup.inc'          );
//echo ini_get('upload_tmp_dir');
$upFile  = FileUpload ( ); // ���ε� �ν��Ͻ� ����
$exec = true;
$chk = false;

$uploadCnt = sizeof($HTTP_POST_FILES); // ���� ���ε� ����

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
            $upFile->Upload(); // ���ε� ����
            //echo $tmp_name;
            //echo SAVE_DIR . $name;
        }
    } else {
        echo '������ �����ϴ�.';
    }
} else {
    echo '������ �����ϴ�.';
}

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