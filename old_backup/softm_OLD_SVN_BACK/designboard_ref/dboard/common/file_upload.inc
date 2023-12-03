<?
/*
* include �Ǿ������� �˻�
**/
if( defined("_dboard_file_upload_included") ) return;
	define ("_dboard_file_upload_included", true);

class FileUpload {
	var $path = "";   // ���� ���� ���
	var $name = "";   // ���� ��
	var $ext  = "";   // ���� Ȯ����
	var $size = "";   // ���� ũ��
	var $tmp  = "";   // ���� ���� ���
	var $real_nm = "";   // ���� ���� ���ϸ� ( ��¥ : ����� �ú��ʸ���ũ)
	var $item_cnt= 0 ;   // Add�� ���� ���ε� ��ü��

	function FileUpload () {
//	  echo 'post_max_size	   : ' . (int) ini_get('post_max_size'	  ) . '<BR>';
//	  echo 'upload_max_filesize : ' . (int) ini_get('upload_max_filesize') . '<BR>';
		return $this;
	}

	/*
	* �Լ���: addUploadFile
	* Argus : $upFile   : ���ε� ����
	*	   : $saveDir	  : ���� ���丮
	*	   : $saveFileName : ���� ���ϸ�
	*	   : $restricted   : ���� Ȯ��� ('exe^zip^xx')
	*	   : $limitAmount  : ���� �뷮 ( ���� : MB )
	*	   : Ȯ����� ���� ���� ���� --> '^'
	* ����  : ���ε��� ������ �߰� �մϴ�.
	**/
	function addUploadFile ($upFile, $saveDir, $saveFileName, $restricted, $limitAmount) {
			if ( $upFile[size] > 0 ) {
				$this->real_nm[$this->item_cnt] = getFileName	 ($saveFileName); // ���� ���� ���ϸ�
				$file = $upFile[name];

//			  echo '<BR>���� ���� �Ѿ��...<BR>' ;
//			  echo '<BR>$upFile' . $upFile .'<BR>' ;
//			  echo "<BR>���� ���� �Ѿ��... : " . $upFile[name]. "<BR>" ;

				$this->path[$this->item_cnt] = $saveDir					   ; // ���� ���
				$this->name[$this->item_cnt] = getFileName	 ($file)		; // ���� ��
				$this->ext [$this->item_cnt] = getFileExtraName($saveFileName); // Ȯ�� ��
				$this->size[$this->item_cnt] = $upFile[size]				  ; // ���� ũ�� (byte)
				$this->tmp [$this->item_cnt] = $upFile[tmp_name ]			 ; // ���� ���� ���

				$megaSize   = (int) $upFile[size] / 1048576;
//			  echo '<font color=red>' . $megaSize . '</font><BR>';
//			  echo '<font color=red>' . $limitAmount . '</font><BR>';

				if ( $megaSize > $limitAmount ) {
					Message ('S', '0050'); // �����ڿ����� ���� ũ�Ⱑ ���� �Ǿ����ϴ�.
				}

				if ( $this->restrictedCheck($restricted, $this->ext [$this->item_cnt] ) ) {
					Message ("S", "0052"); // ���ε� ������ Ȯ����.
				}

//			  $this->upLoadInfor($this->item_cnt);

			} else {
				if ( $upFile[error] && $upFile[error] != 4 ) {
//				  echo '$upFile[error] : ' . is_uploaded_file($upFile) . '<BR>';
//				  echo '$upFile[error] : ' . $upFile[error] . '<BR>';
//				  echo '$upFile[size ] : ' . $upFile[size ] . '<BR>';
					Message ('S', '0021',"", $skinDir);
				}
			}

			$this->item_cnt++; // �߰��� ���� ��ü �� ���� (�ϰ͵� �ȵ� file�� ���Ե� )
	}

	/*
	* �Լ���: Upload
	* ����  : ���ε带 �����մϴ�.
	**/
	function Upload() {
		for($i=0;$i<$this->item_cnt;$i++) {
			if ( $this->ext[$i] ) {
				$savePath = $this->path[$i] . $this->real_nm[$i].'.'.$this->ext[$i];
			} else {
				$savePath = $this->path[$i] . $this->real_nm[$i];
			}

			$exist = file_exists($savePath);
			if ( $this->size[$i] > 0 && !$exist ) {
				@move_uploaded_file	( $this->tmp[$i], $savePath) or Message ("S", "0021");
/*
				@copy	( $this->tmp[$i], $savePath) or Message ("S", "0021");
				@unlink  ( $this->tmp[$i]		   ) or Message ("S", "0022");
*/
			}
		}
//	  echo "<BR>$savePath<BR>";
	}

	/*
	* �Լ���: restrictedCheck
	* Argus : $restricted   : ���� Ȯ��� ���ڿ� ('exe^zip^xx')
	*	   : $ext		  : �˻��� Ȯ���
	* ����  : ���ѵ� Ȯ����� �˻��մϴ�.
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
//		  echo "������ ������ ���ε尡 ���� �Ǿ� �ֽ��ϴ�.";
			return true;
		} else {
//		  echo "������ ������ ���ε尡 ���� �մϴ�.";
			return false;
		}
	}

	function upLoadInfor($idx) {
		echo " <pre>\n\r";
		echo " ���� ���� ���								 path	 : " . $this->path	[$idx] . "\n\r";
		echo " ���� ��										name	 : " . $this->name	[$idx] . "\n\r";
		echo " ���� Ȯ����									ext	  : " . $this->ext	 [$idx] . "\n\r";
		echo " ���� ũ��									  size	 : " . $this->size	[$idx] . "\n\r";
		echo " ���� ���� ���								 tmp	  : " . $this->tmp	 [$idx] . "\n\r";
		echo " ���� ���� ���ϸ� ( ��¥ : ����� �ú��ʸ���ũ) real_nm  : " . $this->real_nm [$idx] . "\n\r";
		echo " Add�� ���� ���ε� ��ü��					   item_cnt : " . $this->item_cnt	   . "\n\r</pre>";
	}
}

/*
* �Լ���: FileUpload
* ����  : FileUploadŬ������ �ν��Ͻ��� �����մϴ�.
**/
function FileUpload () {
	$_upObj = new FileUpload ( );
	return $_upObj; // ���� ���ε� ��ü ��ȯ
}
?>