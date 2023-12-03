<?
define ("ALLOW_UPLOAD_IMAGE_EXT", "jpg^gif^png^bmp"          );
define ("HOME_DIR"   , realpath((dirname(dirname(__FILE__)))) );
define ("DATA_DIR"   , HOME_DIR . "\data" );
define ('SERVICE_DIR', '../service');
require_once '../service/classes/common/FileUpload.php'       ; // 파일 업로드 클래스
require_once '../service/classes/common/InputFilter.php'      ; // 문자열 필터
/*
if ( ( !$file1Nm  ) )
{
    echo 'ERROR|파일등록은 ' . str_replace('^',',',ALLOW_UPLOAD_IMAGE_EXT) . ' 만 등록 가능합니다.';
} else {
*/
// set_time_limit ( 5 );
/**/
echo DATA_DIR;
    $uploader  = new FileUpload(); // 업로드 인스턴스 생성
    $uploader->setSaveDir(DATA_DIR . "\\test");
    $uploader->setAllowExt(ALLOW_UPLOAD_IMAGE_EXT);
    $uploader->setLimitSize(1);
    $uploader->setAutoAdd(true);
    echo '$uploader->getItem("test_file")->getError() :' . $uploader->getItem("test_file")->getError() . '<BR>';
    if ( $uploader->upload() ) {
        echo "업로드 성공";
    } else {
        echo '$uploader->getError:' . $uploader->getError() . '<BR>';
    }

/*
     $uploader  = new FileUpload(); // 업로드 인스턴스 생성
     $file1=$uploader->add($_FILES['test_file'],DATA_DIR . "\\test" );
     $file1->setAllowExt(ALLOW_UPLOAD_IMAGE_EXT);

//     $file1=$uploader->add($_FILES['test_file1'],DATA_DIR . "\\test" );
//     $file1->setAllowExt(ALLOW_UPLOAD_IMAGE_EXT);
//     echo '$file1->getError:' . $file1->getError() . '<BR>';
//     echo '$file1->getName:' . $file1->getName() . '<BR>';
//     echo '$file1->getErrorCode:' . $file1->getErrorCode() . '<BR>';
//     //UPLOAD_ERR_OK
// //     if ( UPLOAD_ERR_NO_FILE != $file1->getErrorCode() && $file1->getErrorCode() ) {

// //     }
     if ( !$uploader->upload() ) {
     	echo '$uploader->getError:' . $uploader->getError() . '<BR>';
     }
//     echo '$file1->getSizeDisplay() : ' . $file1->getSizeDisplay() . "<BR>";
//     echo '$file1->getAllowExt() : ' . $file1->getAllowExt() . "<BR>";

*/

//}
?>