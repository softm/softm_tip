<?
define ("SOFTM_UPLOAD_ERR_LIMIT_SIZE"   , 100 );
define ("SOFTM_UPLOAD_ERR_RESTRICT_EXT" , 101 );

//require_once SERVICE_DIR . '/lib/common.lib.inc';
//require_once SERVICE_DIR . '/lib/file.lib.inc'      ; // 문자열 필터

/*
* include 되었는지를 검사
**/
class FileUploadInfor {
    /**
     * @var 업로드 파일 (php)
     */
    private $phpFile      ; // php file
    /**
     * @var 저장 경로
     */
    private $saveDir      ; // 저장 경로
    /**
     * @var 저장 파일명
     */
    private $saveName     ; // 저장 파일명
    /**
     * @var 금칙 확장자 array
     */
    private $allowExt     ; // 허가 확장자
    /**
     * @var 제한 크기
     */
    private $limitSize    ; // 제한 크기

    /**
     * @var 업로드시 파일명
     */
    private $name         ; // 업로드시 파일명
    /**
     * @var 확장자
     */
    private $ext          ; // 확장자
    /**
     * @var 크기
     */
    private $size         ; // 크기
    /**
     * @var 템프 파일 경로 ( upload )
     */
    private $tmpName      ; // 템프 파일 경로 ( upload )
    /**
     * @var The mime type of the file
     */
    private $type         ; // The mime type of the file, if the browser provided this information. An example would be "image/gif". This mime type is however not checked on the PHP side and therefore don't take its value for granted.
    /**
     * @var string error
     * message
     */
    private $error        ;
    /**
     * @var string
     * error code
     */
    private $errorCode    ;
    /**
     * @return void
     * 생성자
     */
     //,$size,$tmp,$limitSize
     public function __construct($phpFile, $saveDir, $saveName="", $allowExt="", $limitSize = 0 ) {
        //if ( !$name || !$title ) trigger_error("Table Class 정보가 정확하지 않습니다.", E_USER_ERROR);
        $this->phpFile    = $phpFile  ;  // PHP 파일객체
        $this->saveDir    = $saveDir  ;  // 저장 경로

        //$saveName
        if ( !$saveName ) $saveName = $phpFile[name];
        $this->saveName   = $saveName ;  // 업로드 파일명
        $this->allowExt   = $allowExt ;  // 허가된 확장자
        $this->limitSize  = $limitSize;
        $this->errors = array();
    }
    public $encrypt_name = false;

    public function setEncriptFileName()  { $this->encrypt_name = true; }
    public function getEncriptFileName()  { return $this->encrypt_name; }

    /**
     * @return phpFile
     * 업로드 파일 (php)
     */
    public function getPhpFile  ()  { return $this->phpFile  ; }
    /**
     * @return saveDir
     * 저장 경로
     */
    public function getSaveDir  ()  { return $this->saveDir  ; }
    /**
     * @return saveName
     * 저장 파일명
     */
    public function getSaveName ()  { return $this->saveName ; }
    /**
     * @return string 'jpg^gif^png^bmp'
     */
    public function getAllowExt ()  {
        return $this->allowExt;
    }
    /**
     * @return limitSize
     */
    public function getLimitSize()  { return $this->limitSize; }
    /**
     * @return name
     * 업로드시 파일명
     */
    public function getName     ()  { return $this->name     ; }
    /**
     * @return ext
     * 확장자
     */
    public function getExt      ()  { return $this->ext      ; }
    /**
     * @return size
     * 크기
     */
    public function getSize     ()  { return $this->size     ; }
    /**
     * @return tmpName
     * 템프 파일 경로 ( upload )
     */
    public function getTmpName  ()  { return $this->tmpName  ; }
    /**
     * @return type
     * The mime type of the file
     */
    public function getType     ()  { return $this->type     ; }
    /**
     * @return error
     * 에러
     */
    public function getError    ()  { return $this->error   ; }
    /**
     * @return errorCode
     * error code
     */
    public function getErrorCode()  { return $this->errorCode; }

    /**
     * @param string $phpFile
     * @return FileUploadInfor
     * 업로드 파일 (php) 설정
     */
    public function setPhpFile  ($phpFile  ) { $this->phpFile    = $phpFile   ; return $this; }
    /**
     * @param string $saveDir
     * @return FileUploadInfor
     * 저장 경로 설정
     */
    public function setSaveDir  ($saveDir  ) { $this->saveDir    = $saveDir   ; return $this; }
    /**
     * @param string $saveName
     * @return FileUploadInfor
     * 저장 파일명 설정
     */
    public function setSaveName ($saveName ) { $this->saveName   = $saveName  ; return $this; }
    /**
     * @param $allowExt 'jpg^gif^png^bmp'
     * @return FileUploadInfor
     * 허가 확장자 설정 ( 배열 )
     */
    public function setAllowExt ($allowExt ) {
        $this->allowExt   = $allowExt  ; return $this;
    }
    /**
     * @param string $limitSize
     * @return FileUploadInfor
     */
    public function setLimitSize($limitSize) { $this->limitSize  = $limitSize ; return $this; }
    /**
     * @param string $name
     * @return FileUploadInfor
     * 업로드 파일명 설정
     */
    public function setName     ($name     ) { $this->name       = $name      ; return $this; }
    /**
     * @param string $ext
     * @return FileUploadInfor
     * 확장자 설정
     */
    public function setExt      ($ext      ) { $this->ext        = $ext       ; return $this; }
    /**
     * @param string $size
     * @return FileUploadInfor
     * 파일크기 설정
     */
    public function setSize     ($size     ) { $this->size       = $size      ; return $this; }
    /**
     * @param string $tmpName
     * @return FileUploadInfor
     * 템프 파일 경로 ( upload )
     */
    public function setTmpName  ($tmpName  ) { $this->tmpName    = $tmpName   ; return $this; }
    /**
     * @param string $type
     * @return FileUploadInfor
     * The mime type of the file
     */
    public function setType     ($type     ) { $this->type       = $type      ; return $this; }

    /**
     * @param string $msg
     * @return FileUploadInfor
     * set error
     */
    public function setError    ($msg      ) { $this->error      = $msg       ; return $this; }

    /**
     * @param string $code
     * @return FileUploadInfor
     * set error code
     */
    public function setErrorCode ($code      ) { $this->errorCode= $code       ; return $this; }

    /**
     * 허가된 확장자인지 검사합니다.
     **/
    function alloWUploadFileCheck() {
        $allow = false;
//      echo '$this->getAllowExt() : ' . $this->getAllowExt() . "<BR>";
        if ( $this->getErrorCode() != UPLOAD_ERR_NO_FILE ) {
            if ( $this->getAllowExt() ) {
                $allowInfor = explode("^", $this->getAllowExt());
                $size  = sizeof ($allowInfor);
                // echo 'allow ext $size : ' . $size . "<BR>";
                for($i=0;$i<$size;$i++) {
                    if ( $allowInfor[$i] == strtolower( $this->getExt() ) ) {
                        $allow = true; break;
                    }
                }
            } else {
                $allow = true;
            }
        } else {
            $allow = true;
        }
        return $allow;
    }

    /**
     * Set the file name
     *
     * This function takes a filename/path as input and looks for the
     * existence of a file with the same name. If found, it will append a
     * number to the end of the filename to avoid overwriting a pre-existing file.
     *
     */
    public function reGenFileName()
    {
        $chkFileName = $this->getSaveName() . ( $this->getExt()?".".$this->getExt():"" );
        $new_filename = '';
        if ( !file_exists($this->getSaveDir(). DIRECTORY_SEPARATOR .$chkFileName))
        {
            $new_filename = $chkFileName;
        } else {
            for ($i = 1; $i < 100; $i++)
            {
                $chkFileName = $this->getSaveName() . $i . ( $this->getExt()?".".$this->getExt():"" );
                if ( ! file_exists($this->getSaveDir() . DIRECTORY_SEPARATOR .$chkFileName))
                {

                    $v = explode (".", $chkFileName);
                    $this->setSaveName($v[0]);
                    break;
                }
            }
        }
    }
    /**
     * 함수명: Upload
     * 설명  : 업로드를 실행합니다.
     **/
    public function upload() {
        try {
            if ( $this->getErrorCode() == 0 ) {
                $megaSize   = (int) $this->getSize() / 1048576;

                if ( $this->getLimitSize()!= 0 && $megaSize > $this->getLimitSize() ) {
                    throw new Exception("관리자에의해 파일 크기가 제한 되었습니다.", SOFTM_UPLOAD_ERR_LIMIT_SIZE);
                    @unlink  ( $this->getTmpName());
                }

                if ( !$this->alloWUploadFileCheck() ) {
                    throw new Exception("업로드 금지된 확장자가 금지된 확장자입니다.", SOFTM_UPLOAD_ERR_RESTRICT_EXT);
                    @unlink  ( $this->getTmpName());
                }

                $this->reGenFileName();

                $savePath = $this->getSaveDir() . DIRECTORY_SEPARATOR . $this->getSaveName() .($this->getExt()?'.'.$this->getExt():'');
//                 echo '<br>reGenFileName() : ' . $this->getSaveName() . "<BR>";
//                 echo '<br>$savePath() : ' . $savePath . "\n";
                move_uploaded_file  ( $this->getTmpName(), $savePath);
                $phpFile = $this->getPhpFile();

                $this->setErrorCode($phpFile[error]);
                if ( $phpFile[error] > 0 ) {
                    throw new Exception($this->getSystemErrorMessage($phpFile[error]), $phpFile[error]);
                }
            }
        } catch (Exception $e) {
            //echo $e->getMessage();
            $this->setError($e->getMessage());
        }
        if ( $this->getError() ) {
            return false;
        } else return true;
    }

    /**
     * @param $error_code
     * @return upload 에러에대한 메시지 반환
     */
    public function getSystemErrorMessage($error_code) {
        switch ($error_code) {
            case UPLOAD_ERR_INI_SIZE:
                return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
            case UPLOAD_ERR_FORM_SIZE:
                return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
            case UPLOAD_ERR_PARTIAL:
                return 'The uploaded file was only partially uploaded';
            case UPLOAD_ERR_NO_FILE:
                return 'No file was uploaded';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing a temporary folder';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk';
            case UPLOAD_ERR_EXTENSION:
                return 'File upload stopped by extension';
            default:
                return 'Unknown upload error';
        }
    }

    /**
     * @param $size
     * @return 파일사이즈.
     */
    function getSizeDisplay() {
        $sizeStr = "";
        $size = $this->getSize();
        if ( $size >= 1073741824 ) {
            $sizeStr = round ( $size / 1073741824,2).' GB';
        } else if ( $size >= 1048576 ) {
            $sizeStr = round ( $size / 1048576 ,2).' MB';
        } else if ( $size >= 1024 ) {
            $sizeStr = round ( $size / 1024 ,2).' KB';
        } else {
            $sizeStr = $size . ' byte';
        }
        return $sizeStr;
    }
}

class FileUpload {
    private $items = array();
    private $autoAdd = false;
    /**
     * @var 파일명 중복시 새로운 파일명생성 여부
     */
    private $regenFileName; // 허가 확장자
    /**
     * @var 금칙 확장자 array
     */
    private $allowExt     ; // 허가 확장자
    /**
     * @var 제한 크기
     */
    private $limitSize    ; // 제한 크기

    /**
     * @return string 'jpg^gif^png^bmp'
     */
    public function getAllowExt ()  {
        return $this->allowExt;
    }
    /**
     * @return limitSize
     */
    public function getLimitSize()  {
    	return $this->limitSize;
    }
    /**
     * @param $allowExt 'jpg^gif^png^bmp'
     * @return FileUploadInfor
     * 허가 확장자 설정 ( 배열 )
     */
    public function setAllowExt ($allowExt ) {
        $this->allowExt   = $allowExt  ; return $this;
    }
    /**
     * @param string $limitSize
     * @return FileUploadInfor
     */
    public function setLimitSize($limitSize) { $this->limitSize  = $limitSize ; return $this; }

    /**
     * @var 저장 경로
     */
    private $saveDir      ; // 저장 경로
    /**
     * @return saveDir
     * 저장 경로
     */
    public function getSaveDir  ()  {
        return $this->saveDir  ;
    }
    /**
     * @param string $saveDir
     * @return FileUpload
     * 저장 경로 설정
     */
    public function setSaveDir  ($saveDir  ) {
        $this->saveDir    = $saveDir   ; return $this;
    }
    /**
     * @param string $autoAdd
     * @return FileUpload
     * 자동으로 _FILES를 로드합니다.
     */
    public function setAutoAdd  ($autoAdd  ) {
        $this->autoAdd    = $autoAdd   ;
        //var_dump($_FILES);
        if ( $this->autoAdd ) {
            foreach($_FILES as $key => $value) {
                $_FILES[$key][key] = $key;
                //echo $this->getSaveDir() . "\n";
                $file1=$this->add($_FILES[$key],$this->getSaveDir(), "", $this->getAllowExt(), $this->getLimitSize());
            }
        }
        return $this;
    }
    /**
     * @return void
     * 생성자
     */
     public function __construct($autoAdd=false,$saveDir="") {
        //    echo 'post_max_size      : ' . (int) ini_get('post_max_size'    ) . '<BR>';
        //    echo 'upload_max_filesize : ' . (int) ini_get('upload_max_filesize') . '<BR>';
        $this->saveDir=$saveDir;
        $this->setAutoAdd  ($autoAdd  );
     }

    /**
     * @return void
     * 소멸자
     */
    public function __destruct() {

    }

    /**
     * @return FileUploadInfor
     * 파일 업로드 아이템배열을 반환합니다.
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * @return FileUploadInfor
     * 파일 업로드 아이템을 반환합니다.
     */
    public function getItem($key) {
        return $this->items[$key];
    }

    /**
     * @return int
     * 파일 업로드 아이템의 갯수를 반환합니다.
     */
    public function count() {
        return sizeof($this->items);
    }


    /**
     * @param $phpFile 업로드 파일
     * @param $saveDir 저장 디렉토리
     * @param $saveName 저장 파일명
     * @param $allowExt // 허가된 확장자 ('exe^zip^xx')
     * @param $limitAmount 제한 용량 ( 단위 : MB )
     * @return FileUploadInfor
     * 설명  : 업로드할 파일을 추가 합니다.
     */
    public function add($phpFile, $saveDir, $saveName="", $allowExt="", $limitSize=0) {
        $this->allowExt   = $allowExt ;  // 허가된 확장자
        //echo( 'add - key value : ' . $phpFile[key]) . "<BR>";
        $fui = new FileUploadInfor($phpFile, $saveDir );
        try {
            $fileName = $saveName?$saveName:$phpFile['name'];
            $fui->setSaveDir    ($saveDir   );
            $fui->setAllowExt   ($allowExt  );
            $fui->setLimitSize  ($limitSize );
            $fui->setSaveName($this->getFileNameOnly($fileName));
//             echo '$fui->getSaveName() : ' . $fui->getSaveName() . "<BR>";
//             echo '$phpFile[name] : ' . $phpFile['name'] . "<BR>";
//             echo '$fileName : ' . $fileName . "<BR>";
//             echo '$saveName : ' . $saveName . "<BR>";

            $fui->setName   ($phpFile['name'    ]); // The original name of the file on the client machine.
            $fui->setExt    ($this->getFileExtraName($fileName));
            $fui->setType   ($phpFile['type'    ]); // The mime type of the file, if the browser provided this information. An example would be "image/gif". This mime type is however not checked on the PHP side and therefore don't take its value for granted.
            $fui->setSize   ($phpFile['size'    ]); // The size, in bytes, of the uploaded file.
            $fui->setTmpName($phpFile['tmp_name']); // The temporary filename of the file in which the uploaded file was stored on the server

            $fui->setSaveName(iconv('UTF-8', 'EUC-KR', $fui->getSaveName()));

            $fui->setErrorCode($phpFile[error]);
            if ( $fui->getSize() > 0 ) {
                // magic_quotes_gpc Off
                if ( get_magic_quotes_gpc() != 1 ) {
                    $fui->setName(addslashes($this->getFileNameOnly($fui->getName())));
                } else {
                    $fui->setName($this->getFileNameOnly($fui->getName()));
                }
            } else {
                if ( $phpFile[error] > 0 ) {
                    throw new Exception($fui->getSystemErrorMessage($phpFile[error]), $phpFile[error]);
                }
            }
//             echo ' $phpFile[error] : ' . $phpFile[error] . '<BR>';
        } catch (Exception $e) {
            $fui->setError($e->getMessage());
        }
//         echo $phpFile[key];
        $this->items[$phpFile[key]] = $fui;
        return $fui;
    }

    /**
    * 함수명: Upload ( 전체 )
    * 설명  : 업로드를 실행합니다.
    **/
    public function upload() {
        foreach($this->getItems() as $key => $fui) {
            $fui->upload();
        }
    }


    /**
    * 설명  : 에러를 반환합니다(전체)
    **/
    public function getError    ()  {
        $allErrors = array();
        foreach($this->getItems() as $key => $value) {
//      for( $i=0; $i<$size; $i++ ) {
            $fui = $value;
            if ( $fui->getError() ) $allErrors[] = $fui->getError();
        }
        return join(",", $allErrors);
    }

    /**
     * @param $val
     * @return 파일 확장자를 반환합니다.
     */
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

    /**
     * @param $val
     * @return 파일명에서 확장자를제외한 파일이름을 반환합니다.
     */
    function getFileNameOnly($val)
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

    /**
     * @param unknown_type $idx
     */
    function upLoadInfor($idx) {
        echo " <pre>\n\r";
        echo " 파일 실제 경로 path   : " . $this->path[$idx] . "\n\r";
        echo " 파일 명  name : " . $this->name[$idx] . "\n\r";
        echo " 파일 확장자  ext : " . $this->ext[$idx] . "\n\r";
        echo " 파일 크기    size : " . $this->size[$idx] . "\n\r";
        echo " 템프 파일 경로   tmp : " . $this->tmp[$idx] . "\n\r";
        echo " 실제 저장 파일명 ( 날짜 : 년월일 시분초마이크) real_nm  : " . $this->real_nm [$idx] . "\n\r";
        echo " Add된 파일 업로드 객체수 item_cnt : " . $this->item_cnt . "\n\r</pre>";
    }
}
?>