<?
/*
* include 되었는지를 검사
**/
class FileUpload {
	var $path = "";   // 파일 실제 경로
	var $name = "";   // 파일 명
	var $ext  = "";   // 파일 확장자
	var $size = "0";   // 파일 크기
	var $tmp  = "";   // 템프 파일 경로
	var $real_nm = "";   // 실제 저장 파일명 ( 날짜 : 년월일 시분초마이크)
	var $item_cnt= 0 ;   // Add된 파일 업로드 객체수
	var $error = array() ;   // 에러여부

	function FileUpload () {
//	  echo 'post_max_size	   : ' . (int) ini_get('post_max_size'	  ) . '<BR>';
//	  echo 'upload_max_filesize : ' . (int) ini_get('upload_max_filesize') . '<BR>';
		return $this;
	}

	/*
	* 함수명: addUploadFile
	* Argus : $upFile   : 업로드 파일
	*	   : $saveDir	  : 저장 디렉토리
	*	   : $saveFileName : 저장 파일명
	*	   : $restricted   : 금지 확장명 ('exe^zip^xx')
	*	   : $limitAmount  : 제한 용량 ( 단위 : MB )
	*	   : 확장명이 없는 파일 금지 --> '^'
	* 설명  : 업로드할 파일을 추가 합니다.
	**/
	function addUploadFile ($upFile, $saveDir, $saveFileName, $restricted, $limitAmount) {
            $this->error[$this->item_cnt]=array();
			if ( $upFile[size] > 0 ) {
				$this->real_nm[$this->item_cnt] = getFileName	 ($saveFileName); // 실제 저장 파일명
				$file = $upFile[name];

//			  echo '<BR>단일 파일 넘어옴...<BR>' ;
//			  echo '<BR>$upFile' . $upFile .'<BR>' ;
//			  echo "<BR>단일 파일 넘어옴... : " . $upFile[name]. "<BR>" ;

				$this->path[$this->item_cnt] = $saveDir					   ; // 저장 경로

                // magic_quotes_gpc Off
                if ( !escapeYN () ) {
                    $this->name[$this->item_cnt] = addslashes(getFileName	 ($file)); // 파일 명
                } else {
                    $this->name[$this->item_cnt] = getFileName	 ($file); // 파일 명
                }

				$this->ext [$this->item_cnt] = getFileExtraName($saveFileName); // 확장 명
				$this->size[$this->item_cnt] = $upFile[size]				  ; // 파일 크기 (byte)
				$this->tmp [$this->item_cnt] = $upFile[tmp_name ]			  ; // 템프 파일 경로

				$megaSize   = (int) $upFile[size] / 1048576;
//			  echo '<font color=red>' . $megaSize . '</font><BR>';
//			  echo '<font color=red>' . $limitAmount . '</font><BR>';

				if ( $megaSize > $limitAmount ) {
                    $this->error[$this->item_cnt][] = "관리자에의해 파일 크기가 제한 되었습니다.";
				    @unlink  ( $this->tmp[$this->item_cnt]);
				}

				if ( $this->restrictedCheck($restricted, $this->ext [$this->item_cnt] ) ) {
					$this->error[$this->item_cnt][] = "업로드 금지된 확장자.";
				    @unlink  ( $this->tmp[$this->item_cnt]);
				}

//			  $this->upLoadInfor($this->item_cnt);

			} else {
				if ( $upFile[error] && $upFile[error] != 4 ) {
//				  echo '$upFile[error] : ' . is_uploaded_file($upFile) . '<BR>';
//				  echo '$upFile[error] : ' . $upFile[error] . '<BR>';
//				  echo '$upFile[size ] : ' . $upFile[size ] . '<BR>';
					$this->error[$this->item_cnt][] = "서버 파일 최대 크기를 초과 하였거나.\\n업로드 설정에 문제가 발생하였습니다.\\n[ 서버 관리자에게 문의하세요. ]";
				}
			}

			$this->item_cnt++; // 추가된 파일 객체 수 증가 (암것도 안들어간 file도 포함됨 )
	}

	/*
	* 함수명: Upload
	* 설명  : 업로드를 실행합니다.
	**/
	function Upload($up=true) {
		for($i=0;$i<$this->item_cnt;$i++) {
			if ( $this->ext[$i] ) {
				$savePath = $this->path[$i] . $this->real_nm[$i].'.'.$this->ext[$i];
			} else {
				$savePath = $this->path[$i] . $this->real_nm[$i];
			}

			$exist = file_exists($savePath);
			if ( $this->size[$i] > 0 && !$exist ) {
                if ( $up ) {
    				@move_uploaded_file	( $this->tmp[$i], $savePath) or $this->error[$i][] = "서버 파일 최대 크기를 초과 하였거나.\\n업로드 설정에 문제가 발생하였습니다.\\n[ 서버 관리자에게 문의하세요. ]";
                } else {
				    @unlink  ( $this->tmp[$i]		   ) or $this->error[$i][] = "템프파일 삭제중 오류가 발생하였습니다.";
                }
/*
				@copy	( $this->tmp[$i], $savePath) or Message ("S", "0021");

*/
			}
		}
//	  echo "<BR>$savePath<BR>";
	}

	/*
	* 함수명: restrictedCheck
	* Argus : $restricted   : 금지 확장명 문자열 ('exe^zip^xx')
	*	   : $ext		  : 검사할 확장명
	* 설명  : 제한된 확장명을 검사합니다.
	**/
	function restrictedCheck($restricted, $ext) {
		$existChk = false;
		if ( $restricted ) {
			$limit = explode("^", $restricted);
			for($i=0;$i<sizeof ($limit);$i++) {
//			  echo ( $i . " "  . $restricted . " " . $limit[$i] . " $ext <BR>");
				if ( $limit[$i] == strtolower( $ext ) ) {  $existChk = true; break; }
			}
		}

		if ( $existChk ) {
//		  echo "선택한 파일은 업로드가 금지 되어 있습니다.";
			return true;
		} else {
//		  echo "선택한 파일은 업로드가 가능 합니다.";
			return false;
		}
	}

	function upLoadInfor($idx) {
		echo " <pre>\n\r";
		echo " 파일 실제 경로								 path	 : " . $this->path	[$idx] . "\n\r";
		echo " 파일 명										name	 : " . $this->name	[$idx] . "\n\r";
		echo " 파일 확장자									ext	  : " . $this->ext	 [$idx] . "\n\r";
		echo " 파일 크기									  size	 : " . $this->size	[$idx] . "\n\r";
		echo " 템프 파일 경로								 tmp	  : " . $this->tmp	 [$idx] . "\n\r";
		echo " 실제 저장 파일명 ( 날짜 : 년월일 시분초마이크) real_nm  : " . $this->real_nm [$idx] . "\n\r";
		echo " Add된 파일 업로드 객체수					   item_cnt : " . $this->item_cnt	   . "\n\r</pre>";
	}
}

/*
* 함수명: FileUpload
* 설명  : FileUpload클래스의 인스턴스를 생성합니다.
**/
function FileUpload () {
	$_upObj = new FileUpload ( );
	return $_upObj; // 파일 업로드 객체 반환
}
?>