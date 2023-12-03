<?php
define("DEBUG",preg_match("/^\/service\/classes/", $_SERVER[PHP_SELF]));
if ( !defined("BROWSER") ) { // common.lib에 BROWSER define 되어있음.
//if ( DEBUG ) {
	require_once '../../lib/common.lib.inc' ; // 라이브러리
	require_once SERVICE_DIR . '/classes/common/Session.php'          ; // 세션	
}
require_once SERVICE_DIR . '/classes/BaseDataBase.php'; // 기본 DataBase 클래스
require_once SERVICE_DIR . '/classes/common/Util.php'; // Util클래스

class Common extends BaseDataBase
{
	public function __construct() {
		parent::__construct();
		$this->debug = true;
	}

	public function __destruct() {
		parent::__destruct();
	}
	
    function Common() {
        // Define the methodTable for this class in the constructor
        $this->methodTable = array(
            "getList" => array(
                "description" => "Return a list of data",
                "access" => "remote",
                "returns" => "string",
                "roles" => "admin"
            )
        );
    }

    /**
     * 대공정정보 조회
     * @param array $argus
     * @return DOMDocument
     */
    public function getProcInfo($argus) {
        $p_proc_cd = $argus[p_proc_cd];
    	global $page_tab;
    	//     $this->testJsCall($argus);
    	//    	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
    	$this->start();    	
    	$this->startHeader();
    	$this->setType(BaseDataBase::SELECT_TYPE);
    	try {
//    		if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
    
    		$query = array();
    
    		$query [] = " SELECT ";
    		$query [] = "   PROC_CD";
    		$query [] = " , PROC_NM";
    		$query [] = " FROM " . TBL_PROC_CD;
    		$query [] = " WHERE PROC_CD = '" . $p_proc_cd. "'";
    		$this->setQuery(join(PHP_EOL, $query));
    		//         out.print($this->getQuery());
    		$this->makeItemXML($this->getQuery(),"item");
    		//         out.print($this->db->getAffectedRows());
    		$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->printXML(C_DB_PROCESS_MODE_SELECT);
    	$this->end();    	
    }

    /**
     * 대공정코드 조회
     * @param array $argus
     * @return DOMDocument
     */
    public function getProcegory($argus) {
    	global $page_tab;
    	//     $this->testJsCall($argus);
    	//    	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
    	$this->start();    	
    	$this->startHeader();
    	$this->setType(BaseDataBase::SELECT_TYPE);
    	try {
//     		if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
    
    		$query = array();
    
    		$query [] = " SELECT ";
    		$query [] = "   PROC_CD";
    		$query [] = " , PROC_NM";
    		$query [] = " FROM " . TBL_PROC_CD;
    
    		// where 문장생성
    		if ( $where ) $query[] = ( " WHERE " . $where );
    
    		$query[] =  ( " ORDER BY PROC_CD ASC" );
    
    		$this->setQuery(join(PHP_EOL, $query));
    		//         out.print($this->getQuery());
    
    		$this->makeItemXML($this->getQuery(),"item");
    		//         out.print($this->db->getAffectedRows());
    		$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->printXML(C_DB_PROCESS_MODE_SELECT);
    	$this->end();    	
    }
    /**
     * 공정항목코드 조회
     * @param array $argus
     * @return DOMDocument
     */
    public function getProcItCdegory($argus) {
    	global $page_tab;
    	//     $this->testJsCall($argus);
    	//    	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
    	$this->start();    	
    	$this->startHeader();
    	$this->setType(BaseDataBase::SELECT_TYPE);
    	try {
//     		if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
    
    		$query = array();
    		$query [] = " SELECT ";
    		$query [] = "   PROC_IT_CD_NO";
    		$query [] = " , PROC_IT_CD   ";
    		$query [] = " , PROC_IT_NM   ";
    		$query [] = " , PROC_CD      ";
    		$query [] = " FROM " . TBL_PROC_IT_CD;
            $where = " PROC_CD = '" .$argus['proc_cd']. "'";
    		// where 문장생성
    		if ( $where ) $query[] = ( " WHERE " . $where );
    
    		$query[] =  ( " ORDER BY PROC_IT_CD ASC" );
    
    		$this->setQuery(join(PHP_EOL, $query));
    		//         out.print($this->getQuery());
    
    		$this->makeItemXML($this->getQuery(),"item");
    		//         out.print($this->db->getAffectedRows());
    		$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->printXML(C_DB_PROCESS_MODE_SELECT);
    	$this->end();    	
    }

    /**
     * 공정항목내역코드 조회
     * @param array $argus
     * @return DOMDocument
     */

    public function getProcBdCdegory($argus) {
    	global $page_tab;
    	//     $this->testJsCall($argus);
    	//    	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
    	$this->start();    	
    	$this->startHeader();
    	$this->setType(BaseDataBase::SELECT_TYPE);
    	try {
    		if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
    
    		$query = array();
    		$query [] = " SELECT ";
    		$query [] = "   PROC_BD_CD_NO";
    		$query [] = " , PROC_BD_CD   ";
    		$query [] = " , PROC_BD_NM   ";
    		$query [] = " , PROC_DT_NM   ";
    		$query [] = " , PROC_CD      ";
    		$query [] = " , PROC_IT_CD   ";
    		$query [] = " , STD          ";
    		$query [] = " , UNIT         ";
    		$query [] = " , M_AMT        ";
    		$query [] = " , L_AMT        ";
    		$query [] = " , E_AMT        ";
    		$query [] = " FROM " . TBL_PROC_BD_CD;
            $where = " 1 = 1";
            if ( $argus['proc_cd'] ) {
                $where .= " AND PROC_CD    = '" .$argus['proc_cd']   . "'";
            } 
            if ( $argus['proc_it_cd'] ) {
                $where .= " AND PROC_IT_CD = '" .$argus['proc_it_cd']. "'";
            }
            if ( !$argus['proc_cd'] && !$argus['proc_it_cd'] ) {
                $where .= " AND PROC_CD    = ''";
            }
    		// where 문장생성
    		if ( $where ) $query[] = ( " WHERE " . $where );
    
    		$query[] =  ( " ORDER BY PROC_BD_CD_NO ASC" );
    
    		$this->setQuery(join(PHP_EOL, $query));
    		//         out.print($this->getQuery());
    
    		$this->makeItemXML($this->getQuery(),"item");
    		//         out.print($this->db->getAffectedRows());
    		$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->printXML(C_DB_PROCESS_MODE_SELECT);
    	$this->end();    	
    }
        
	/**
	 * @param DataBase $db
	 * @param int $procType
	 * @param int $userNo
	 * @param int $companyNo
	 * @param string $fileName
	 * @param string $fileExt
	 * @param int $fileSize
	 * @return int $file_no
	 */
	static function insertFileInfor($db,$procType, $userNo, $fileName, $fileExt,$fileSize) {
	    $query  = array();
	    $query[]  = " INSERT INTO " . TBL_FILE;
	    $query[]  = " ( ";
	    $query[]  = " PROC_TYPE ,";
	    $query[]  = " USER_NO   ,";
	    $query[]  = " FILE_NAME ,";
	    $query[]  = " FILE_EXT  ,";
	    $query[]  = " FILE_SIZE ,";
	    $query[]  = " REG_DATE   ";
	//          $query[]  = " MOD_DATE  ";
	    $query[]  = " ) ";
	    $query[]  = " VALUES ( ";
	    $query[]  = " '" . $procType    . "',";
	    $query[]  = " '" . $userNo      . "',";
	    $query[]  = " '" . $fileName    . "',";
	    $query[]  = " '" . $fileExt     . "',";
	    $query[]  = " '" . $fileSize    . "',";
	    $query[]  = " now() ";
	    $query[]  = " ) ";
	    $db->exec(join("\n", $query));
// 	    echo join("\n", $query);
	    $file_no = $db->getInsertId();
	    return $file_no;
	}

	
	/**
	 * @param DataBase $db
	 * @param int $procType
	 * @param int $userNo
	 * @param int $companyNo
	 * @param string $fileName
	 * @param string $fileExt
	 * @param int $fileSize
	 * @return int $file_no
	 */
	static function updateFileInfor($db, $fileNo, $fileName, $fileExt, $fileSize) {
		$query  = array();
		$query[]  = " UPDATE " . TBL_FILE;
		$query[]  = " SET ";
// 		$query[]  = " PROC_TYPE = '" . $procType    . "',";
// 		$query[]  = " USER_NO   = '" . $userNo      . "',";
// 		$query[]  = " COMPANY_NO= '" . $companyNo   . "',";
		$query[]  = " FILE_NAME = '" . $fileName    . "',";
		$query[]  = " FILE_EXT  = '" . $fileExt     . "',";
		$query[]  = " FILE_SIZE = '" . $fileSize    . "',";
		$query[]  = " MOD_DATE  = now()";
		$query[]  = " WHERE FILE_NO = '" . $fileNo . "'";
		$db->exec(join("\n", $query));
		return $file_no;
	}

	/**
	 * @param DataBase $db
	 * @param int $procType
	 * @param int $userNo
	 * @param int $companyNo
	 * @param string $fileName
	 * @param string $fileExt
	 * @param int $fileSize
	 * @return int $file_no
	 */
	static function increaseFileDownHit($db, $fileNo) {
		$query  = array();
		$query[]  = " UPDATE " . TBL_FILE;
		$query[]  = " SET ";
		$query[]  = "   DOWN_HIT = DOWN_HIT + 1";
		$query[]  = " , MOD_DATE  = now()";
		$query[]  = " WHERE FILE_NO = '" . $fileNo . "'";
		$db->exec(join("\n", $query));
		return $file_no;
	}
	
	/**
	 * @param DataBase $db
	 * @param int $fileNo
	 */
	static function deleteFileInfor($db, $fileNo) {
		$query  = array();
		$query[]  = " DELETE FROM " . TBL_FILE;
		$query[]  = " WHERE FILE_NO = '" . $fileNo . "'";
// 		echo join("\n",$query );
		$db->exec(join("\n", $query));
	}

	/**
	 * @param DataBase $db
	 * @param array $fileInfor [fileno=>value,...] 
	 * @param string $fields
	 * @return array $return
	 */
	static function getFileInfor($db,$fileInfor,$fields="*") {
		$return = array();
		if ( !empty($fileInfor) ) {
			$query  = array();			
			foreach ( $fileInfor as $k => $v ) {
				if ( $v ) {
					$query[] = "SELECT '" . $k . "' AS FILE_KEY, " . $fields . " FROM " . TBL_FILE
					          ." WHERE FILE_NO = '" . $v. "'";
				}
			}
// 	 		echo join(" UNION ",$query );
			$stmt = $db->multiRowSQLQuery (join(" UNION ",$query ));
			while ( $rs = $db->multiRowFetch  ($stmt) ) {
				$return[$rs->FILE_KEY] = $rs;
			}
		}         
		return $return;
	}	
    
	/**
	 * 업로드파일을 다운로드합니다.
	 * @param array $argus
	 * @return int
	 */
	public function fileDownload($argus) {
	    $p_file_no   = $argus[p_file_no];
	    $p_file_nm   = $argus[p_file_nm];
	    $p_sub_dir   = $argus[p_sub_dir];
	    try {
	    	$this->start();
	
 	        if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
        
	        $query = array();
	        $query [] = "SELECT ";
	        $query [] = " FILE_NO,";
	        $query [] = " PROC_TYPE,";
	        $query [] = " USER_NO,";
	        $query [] = " FILE_NAME,";
	        $query [] = " FILE_EXT,";
	        $query [] = " FILE_SIZE,";
	        $query [] = " REG_DATE,";
	        $query [] = " MOD_DATE";
	        $query [] = " FROM " . TBL_FILE;
	        $query [] = " WHERE ";
	        $query [] = " FILE_NO = '" . $p_file_no . "'";
// 	        if ( !ADMIN ) $query [] = " AND USER_NO = '" . USER_NO . "'";
	        $this->setQuery(join("\n", $query));
	        $fileInfor = $this->db->get($this->getQuery());
// 	        echo $this->getQuery();
	        $fName = $fileInfor->FILE_NAME;
	        $fExt  = $fileInfor->FILE_EXT;
	        
	        $fName=str_replace(" ","_",$fName);
	        $fName=str_replace("%20","_",$fName);
	        	        
			$fileName = Util::mergeFileName($fName, $fExt);
			$saveDir = DATA_DIR . DIRECTORY_SEPARATOR . $p_sub_dir;
			$file = Util::mergeFileName($saveDir . DIRECTORY_SEPARATOR . $p_file_nm,$fExt);
// 			echo $saveDir . DIRECTORY_SEPARATOR . $p_file_nm . "." . $fExt.'<Br>';
// 			echo $p_file_nm . "<br>";
// 			echo $fExt. "<br>";
//  			echo $saveDir . "<br>";
//  			echo $file . "<br>";
			if ( @is_file($file) ) {
				$fileName=iconv("UTF-8","EUC-KR",$fileName);				
				Util::downHeader($file, urldecode($fileName));
				$fp = fopen($file, "r");
				if (!fpassthru($fp)) fclose($fp);
				flush();
			}
// 	        	out.print($this->db->getErrMsg());

	    } catch (Exception $e) {
	    }
	    
	    $this->end();
	}
	
	/**
	 * GRID 조회데이터의 xls,Doc 다운로드 
	 * @param array $argus
	 * @return int
	 */
	public function saveDownload($argus) {
	    $p_file_nm   = $argus[p_file_nm];
	    $p_data      = $argus[p_data   ];
	    
	    try {
 	        if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
	        
	        $fName=str_replace(" ","_",$p_file_nm);
	        $fName=str_replace("%20","_",$p_file_nm);
	        $fName=iconv("UTF-8","EUC-KR",$fName);
// 			Util::downHeader("", urldecode($fName));
			
			header('Content-type: application/ms-excel;charset=KSC5601');
			header('Content-Disposition: attachment; filename='.$fName);
// 			$p_data = iconv("UTF-8","EUC-KR",$p_data);
			ob_start();
			print
			'<head>' .
			'<META HTTP-EQUIVE="CONTENT-TYPE" CONTENT="TEXT/HTML; CHARSET=UTF-8">  ' .
			'<body>' .
			 stripslashes($p_data ) .			
			'</body>' .
			'</html>';
			ob_end_flush();
	    } catch (Exception $e) {
	    }
	    
	}
	

	/**
	 * 기술분류 대중소 코드 ( SELECT BOX 구성에 이용됨 )
	 * @param array $argus
	 * @return string JSON string
	 */
	public function getTechCategory($argus) {
		$s_gubun = $argus[s_gubun];
		$s_l_cat = $argus[s_l_cat];
		$s_m_cat = $argus[s_m_cat];
		$s_s_cat = $argus[s_s_cat];
		$s_lang = !$argus[s_lang]?"KR":$argus[s_lang]; // KR,JP
		
		$catInfor = array();		
		try {
			$this->start();
	
// 			if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
			$query = array();
	
			$query [] = " SELECT ";
			$query [] = " L_CAT,";
			$query [] = " M_CAT,";
			$query [] = " S_CAT,";
			if      ( $s_lang == "KR" ) $query [] = " NM";
			else if ( $s_lang == "JP" ) $query [] = " NM_JP AS NM";
			$query [] = " FROM " . TBL_TECH_CATEGORY;
			// 대분류 $s_m_cat = 00 && $p_s_cat = 00
			// 중분류 $s_l_cat = "43" && $s_m_cat <> "00" && $s_s_cat = 00
			// 소분류 $s_l_cat = "43" && $s_m_cat = "48" && $s_s_cat <> 00
	
			if ( $s_gubun == "L" ) { // 대분류
				$query [] = " WHERE M_CAT = '00'";
				$query [] = " AND   S_CAT = '00'";
			} else if ( $s_gubun == "M" ) { // 중분류
				$query [] = " WHERE L_CAT = '" . $s_l_cat . "'";
				$query [] = " AND   M_CAT <> '00'";
				$query [] = " AND   S_CAT = '00'";
			} else if ( $s_gubun == "S" ) { // 소분류
				$query [] = " WHERE L_CAT = '" . $s_l_cat . "'";
				$query [] = " AND   M_CAT = '" . $s_m_cat . "'";
				$query [] = " AND   S_CAT <> '00'";
			}
			$this->setQuery(join("\n", $query));			
// echo $this->getQuery();
			$stmt = $this->db->multiRowSQLQuery ($this->getQuery());
			while ( $rs = $this->db->multiRowFetch  ($stmt) ) {
// 				echo $rs->L_CAT;
				if ( $s_gubun == "L" ) { // 대분류				
					$catInfor[] = "\"" . $rs->L_CAT ."\":\"" . $rs->NM . "\"";
				} else if ( $s_gubun == "M" ) { // 중분류
					$catInfor[] = "\"" . $rs->M_CAT ."\":\"" . $rs->NM . "\"";					
				} else if ( $s_gubun == "S" ) { // 소분류
					$catInfor[] = "\"" . $rs->S_CAT ."\":\"" . $rs->NM . "\"";					
				}
			}
			
    	} catch (Exception $e) {
    	}
		$this->end();
		echo  "{" . join(",",$catInfor) ."}";
	}
	
	/**
	 * 우편번호 검색
	 * @param array $argus
	 * @return string JSON string
	 */
	public function getZipCodeSearch($argus) {
		$s_search = $argus[s_search];
		$catInfor = array();
		try {
			$this->start();
	
// 			if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
			if ( $s_search ) {
				$query = array();
				
				$query [] = " SELECT ";
				$query [] = " ZIPCODE,";
				$query [] = " AREA1,";
				$query [] = " AREA2,";
				$query [] = " AREA3,";
				$query [] = " AREA4";
				$query [] = " FROM " . TBL_POST;
				$query [] = " WHERE AREA3 LIKE '" . $s_search . "%'";
				$this->setQuery(join("\n", $query));
// 				echo $this->getQuery();
				$stmt = $this->db->multiRowSQLQuery ($this->getQuery());
				while ( $rs = $this->db->multiRowFetch  ($stmt) ) {
					$catInfor[] = "{" . "\"ZIPCODE\":\"" . $rs->ZIPCODE . "\","
					. "\"AREA1\":\"" . $rs->AREA1 . "\","
					. "\"AREA2\":\"" . $rs->AREA2 . "\","
					. "\"AREA3\":\"" . $rs->AREA3 . "\","
					. "\"AREA4\":\"" . $rs->AREA4 . "\""
					. "}"
					;
				}
			}
		} catch (Exception $e) {
		}
		$this->end();
		echo  "[" . join(",",$catInfor) ."]";
	}	
	
	/**
	 * 우편번호 검색
	 * @param array $argus
	 * @return string "1" or "0"
	 */
	public function sendMailForAdmin($argus) {
		require_once SERVICE_DIR . '/lib/mail.lib.inc';
		
		$to       = $argus[to      ];
		$toname   = $argus[toname  ];
		$from     = $argus[from    ];
		$fromname = $argus[fromname];
		$subject  = $argus[subject ];
		$message  = $argus[message ];
		try {
 			//if ( !ADMIN ) throw new Exception("어드민이 아닙니다.");
			if ( $subject ) {
				$sendMailItem = new sendMailItem("localhost",25,
				                                 $to, $toname,
				                                 $from,$fromname,
				                                 $subject,"text/html",
				                                 $message,
				                                 $fInfo
				                                );
				$sendMailItem->gubun = 'PHP';
				$sendmail_flag = sendMail($sendMailItem);
				if ($sendmail_flag) {
					print "1";
				} else {
					print "0";
				}				
			}
		} catch (Exception $e) {
			print "0";
		}
	}
	
	/**
	 * 아이디 찾기
	 * @param array $argus
	 * @return string "1" or "0"
	 */
	public function findId($argus) {
		require_once SERVICE_DIR . '/lib/mail.lib.inc';
	
		$user_name = $argus[user_name ];
		$tel       = $argus[tel       ];
		$birth     = $argus[birth1   ]."".  sprintf("%02d", $argus[birth2     ])."".sprintf("%02d", $argus[birth3     ]);
// 		echo $tel;
		$this->start();
		try {
			$info = $this->db->get("SELECT USER_ID, USER_EMAIL, PASSWD FROM " . TBL_MEMBER
					. " WHERE USER_NAME  = '" . $user_name . "'"
					. " AND   TEL   = '" . $tel   . "'"
					. " AND   BIRTH = '" . $birth . "'"
			);
			//if ( !ADMIN ) throw new Exception("어드민이 아닙니다.");
			//  			var_dump('$info :' . $info);
// 			echo $this->db->getLastSql();
			if ( $info->USER_ID ) {
				print $info->USER_ID;
			} else {
				print "0";
			}
		} catch (Exception $e) {
			print "0";
		}
		$this->end();
	}
	
	/**
	 * 아이디비밀번호 찾기
	 * @param array $argus
	 * @return string "1" or "0"
	 */
	public function findPassSendMail($argus) {
		require_once SERVICE_DIR . '/lib/mail.lib.inc';
		
		$user_id       = $argus[user_id        ];
		$passwd_hint   = $argus[passwd_hint    ];
		$passwd_correct= $argus[passwd_correct ];
		
		$this->start();		
		try {
			$info = $this->db->get("SELECT USER_ID, USER_EMAIL, PASSWD FROM " . TBL_MEMBER 
					          . " WHERE USER_ID  = '" . $user_id . "'"
					          . " AND   PASSWD_HINT    = '" . $passwd_hint . "'"
					          . " AND   PASSWD_CORRECT = '" . $passwd_correct . "'"
			);
 			//if ( !ADMIN ) throw new Exception("어드민이 아닙니다.");
//  			var_dump('$info :' . $info);
			if ( $info->USER_ID ) {

				$message =  "아이디   : " . $info->USER_ID . "\n"
				         .  "비밀번호 : " . $info->PASSWD
				;

				$sendMailItem = new sendMailItem("localhost",25,
				                                 $to, $toname,
				                                 "관리자","softmnet@gmail.com",
				                                 "[kjtnet] " . $toname . " 회원님의 아이디/비밀번호","text/html",
												 $message,
				                                 $fInfo
				                                );
				$sendMailItem->gubun = 'PHP';
				$sendmail_flag = sendMail($sendMailItem);
				if ($sendmail_flag) {
					print "1";
				} else {
					print "-1";
				}				
			} else {
				print "0";			
			}
		} catch (Exception $e) {
			print "0";
		}
		$this->end();		
	}

	

	/**
	 * set session
	 * @param array $argus
	 * @return DOMDocument
	 */
	public function setSession($argus) {
		global $page_tab;
		//     $this->testJsCall($argus);
		//    	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
		Session::setSession($argus[k], $argus[v]);
		$this->start();
		$this->startHeader();
		try {
// 			if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
			$this->appendNode('rtn2', 222);	
			$this->appendNode($argus[k],$argus[v]);	
			$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
		} catch (Exception $e) {
			$this->addErrMessage($e->getMessage());
		}
		$this->printXML(C_DB_PROCESS_MODE_SELECT);
		$this->end();
	}	
}
?>