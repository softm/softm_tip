<?php
define("DEBUG",ereg("^/service/classes", $_SERVER[PHP_SELF]));
if ( DEBUG ) {
	require_once '../../lib/common.lib.inc' ; // 라이브러리
	require_once SERVICE_DIR . '/classes/common/Session.php'          ; // 세션	
}
require_once SERVICE_DIR . '/classes/BaseDataBase.php'; // 기본 DataBase 클래스
require_once SERVICE_DIR . '/classes/common/Util.php'; // Util클래스
require_once SERVICE_DIR . '/classes/common/Common.php'; // Common클래스
require_once SERVICE_DIR . '/classes/common/FileUpload.php'; // 파일업로드클래스
require_once SERVICE_DIR . '/classes/base/Worker.php'; // 담당자 클래스
require_once SERVICE_DIR . '/classes/admin/BizConsult.php'; // 담당자 클래스

/**
 * @author softm
 * 기업정보 / Company.php
 */
class Company extends BaseDataBase
{
	/** @var upload file directory */ public static $SAVE_SUB_DIR = "company";
	public $argus_db = false;
	//defult constructor
// 	public function __construct() {
// 	    $num = func_num_args();
// 	    $args = func_get_args();
// 	    switch($num){
// 	        case 0:
// 	            $this->__call('__construct0', null);
// 	            break;
// 	        case 1:
// 	            $this->__call('__construct1', $args);
// 	            break;
// 	        default:
// 	            throw new Exception();
// 	    }
// 	}
    
	public function __construct() {
		parent::__construct();
		$this->debug = true;
		$this->start();
		if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_COMPANY);
			$tbl1->newColumn('COMPANY_NO','번호',1)->setAlign("center");
			$tbl1->newColumn('COUNTRY_TYPE','국가',2)->setHide();
			//         	$tbl1->newColumn('COMPANY_TYPE','기업형태',3)->setHide();
			$tbl1->newColumn('COMPANY_TYPE','기업형태',3)->setType(Column::LISTBOX_TYPE)->setEditable(true);
			$tbl1->newColumn('BIZ_FIELD','업종분야',4)->setType(Column::LISTBOX_TYPE)->setEditable(true);
			$tbl1->newColumn('BIZ_CLASSIFIED','업종분류',5)->setType(Column::LISTBOX_TYPE)->setEditable(true);
			$tbl1->newColumn('COMPANY_NM_KR','기업명',6)->setCssText("text-align:left;padding-left:5px;text-decoration:underline");
			$tbl1->newColumn('REG_DATE','등록일',7)->setKey(false);
		} else if ( METHOD == "selectJp" ) {
			$tbl1 = $this->newTable(TBL_COMPANY);			
			$tbl1->newColumn('COMPANY_NO'   ,'번호',1)->setAlign("center");
			$tbl1->newColumn('COMPANY_NM_KR','기업명',2)->setWidth(400)->setAlign("left");
			$tbl1->newColumn('CEO_NM_KR'    ,'대표자명',3);
			$tbl1->newColumn('REG_DATE'     ,'등록일',4)->setKey(false);			
		}
	}
	
// 	public function __construct1($db) {
// 		if ( !ADMIN ) {
// 			header('HTTP/1.0 404 Not Found');
// 			//echo "관리자가 아닙니다.";
// 			die();
// 		}
// 		parent::__construct();
// 		$this->debug = true;
// 		$this->db = $db;
// 		$this->argus_db = true;
// 	}
	
// 	private function __call($name, $arg){
// 		return call_user_func_array(array($this, $name), $arg);
// 	}
	
    public function __destruct() {
        parent::__destruct();
        if ( !$this->argus_db ) $this->end();
    }
    
    /**
     * 일본기업회원가입.
     **/
    function insertJp($argus) {
    	$user_no = USER_NO;
    	$company_code = $argus[company_code1] . $argus[company_code2] . $argus[company_code3];
    
    	$this->testJsCall($argus);
    	$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED ) ,0) + 1 FROM " . TBL_COMPANY 
    			." WHERE COUNTRY_TYPE = '" . COUNTRY_TYPE_JP . "'" 
    			." AND   SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" 
    	);
    	//             	echo $cnt . "<BR>";
    	$reg_code =sprintf('%s%s%04d','JC',date("Ymd"),$cnt);
    
    	$biz_classified  = join(",",$argus[biz_classified]);
    	if ( !$argus[establish_date1] || !$argus[establish_date2] || !$argus[establish_date3] ) {
    		$establish_date = '0000-00-00';
    	} else {
    		$establish_date = $argus[establish_date1] . '-' . $argus[establish_date2] . '-' . $argus[establish_date3];
    	}
    	$worker_cnt = !$argus[worker_cnt]?'0':$argus[worker_cnt];
    	$capital    = !$argus[capital   ]?'0':$argus[capital   ];
    	$sales      = !$argus[sales     ]?'0':$argus[sales     ];
    	$expect_sales= !$argus[expect_sales]?'0':$argus[expect_sales];
    	$ordinary_income= !$argus[ordinary_income   ]?'0':$argus[ordinary_income];
    
    	$this->startXML(); // xml start node
    	try {
    		$query[]  = " INSERT INTO " . TBL_COMPANY;
    		$query[]  = " ( ";
    		// 			$query[]  = " COMPANY_NO          ,";
    		$query[]  = " USER_NO             ,";
    		$query[]  = " REG_CODE            ,"; // KC20120305 0001
    		$query[]  = " COUNTRY_TYPE        ,";
    		$query[]  = " COMPANY_CODE        ,";
    		$query[]  = " COMPANY_TYPE        ,";
    		$query[]  = " COMPANY_NM_KR       ,";
    		$query[]  = " COMPANY_NM_EN       ,";
    		$query[]  = " COMPANY_NM_HJ       ,";
    		$query[]  = " COMPANY_NM_JP       ,";
    		$query[]  = " CEO_NM_KR           ,";
    		$query[]  = " CEO_NM_EN           ,";
    		$query[]  = " CEO_NM_HJ           ,";
    		$query[]  = " CEO_NM_JP           ,";
    		$query[]  = " BIZ_FIELD           ,";
    		$query[]  = " BIZ_CLASSIFIED      ,";
    		$query[]  = " BIZ_CLASSIFIED_ETC  ,";
    		$query[]  = " BIZ_NAME            ,";
    		$query[]  = " BIZ_NAME_JP         ,";
    		$query[]  = " ESTABLISH_DATE      ,";
    		$query[]  = " ZIP_CODE            ,";
    		$query[]  = " ADDR_KR             ,";
    		$query[]  = " ADDR_EN             ,";
    		$query[]  = " ADDR_HJ             ,";
    		$query[]  = " ADDR_JP             ,";
    		$query[]  = " WORKER_CNT          ,";
    		$query[]  = " TEL                 ,";
    		$query[]  = " FAX                 ,";
    		$query[]  = " HOMEPAGE            ,";
    		$query[]  = " CAPITAL             ,";
    		$query[]  = " SALES               ,";
    		$query[]  = " EXPECT_SALES        ,";
    		$query[]  = " ORDINARY_INCOME     ,";
    		$query[]  = " MAIN_PRODUCT        ,";
    		$query[]  = " COMPANY_INTRO       ,";
    		$query[]  = " COMPANY_INTRO_JP    ,";
    		$query[]  = " JP_TRADE_YN         ,";
    		$query[]  = " ETC_TRADE_YN        ,";
    		$query[]  = " INTERNAL_CUSTOMER   ,";
    		$query[]  = " INTERNAL_CUSTOMER_JP,";   		
    		$query[]  = " EXTERNAL_CUSTOMER   ,";
    		$query[]  = " EXTERNAL_CUSTOMER_JP,";
    		$query[]  = " REG_DATE             ";
    		$query[]  = " ) ";
    		$query[]  = " VALUES ( ";
    		$query[]  = " '" . $user_no                   . "',";
    		$query[]  = " '" . $reg_code          	      . "',";
    		$query[]  = " '" . COUNTRY_TYPE_JP            . "',";
    		$query[]  = " '" . $company_code			  . "',";
    		$query[]  = " '" . $argus[company_type      ] . "',";
    		$query[]  = " '" . $argus[company_nm_kr     ] . "',";
    		$query[]  = " '" . $argus[company_nm_en     ] . "',";
    		$query[]  = " '" . $argus[company_nm_hj     ] . "',";
    		$query[]  = " '" . $argus[company_nm_jp     ] . "',";
    		$query[]  = " '" . $argus[ceo_nm_kr         ] . "',";
    		$query[]  = " '" . $argus[ceo_nm_en         ] . "',";
    		$query[]  = " '" . $argus[ceo_nm_hj         ] . "',";
    		$query[]  = " '" . $argus[ceo_nm_jp         ] . "',";
    		$query[]  = " '" . $argus[biz_field         ] . "',";
    		$query[]  = " '" . $biz_classified            . "',";
    		$query[]  = " '" . $argus[biz_classified_etc] . "',";
    		$query[]  = " '" . $argus[biz_name          ] . "',";
    		$query[]  = " '" . $argus[biz_name_jp       ] . "',";
    		$query[]  = " '" . $establish_date            . "',";
    		$query[]  = " '" . $argus[zip_code          ] . "',";
    		$query[]  = " '" . $argus[addr_kr           ] . "',";
    		$query[]  = " '" . $argus[addr_en           ] . "',";
    		$query[]  = " '" . $argus[addr_hj           ] . "',";
    		$query[]  = " '" . $argus[addr_jp           ] . "',";
    		$query[]  = " '" . $worker_cnt         		  . "',";
    		$query[]  = " '" . $argus[tel               ] . "',";
    		$query[]  = " '" . $argus[fax               ] . "',";
    		$query[]  = " '" . $argus[homepage          ] . "',";
    		$query[]  = " '" . $capital                   . "',";
    		$query[]  = " '" . $sales                     . "',";
    		$query[]  = " '" . $expect_sales              . "',";
    		$query[]  = " '" . $ordinary_income           . "',";
    		$query[]  = " '" . $argus[main_product      ] . "',";
    		$query[]  = " '" . $argus[company_intro     ] . "',";
    		$query[]  = " '" . $argus[company_intro_jp  ] . "',";
    		$query[]  = " '" . $argus[jp_trade_yn       ] . "',";
    		$query[]  = " '" . $argus[etc_trade_yn      ] . "',";
    		$query[]  = " '" . $argus[internal_customer ] . "',";
    		$query[]  = " '" . $argus[internal_customer_jp ] . "',";
    		$query[]  = " '" . $argus[external_customer ] . "',";
    		$query[]  = " '" . $argus[external_customer_jp ] . "',";
    		$query[]  = " now()";
    		$query[]  = " ) ";
    		
    		// 	echo join("<BR>", $query);
    		$this->setQuery(join("\n", $query));
    		$this->db->setAutoCommit(false);
    		if ( $this->exec($this->getQuery()) ) {
    			$company_no = $this->db->getInsertId();
    			unset($query);
    		
    			$this->appendNode('insert_id', $company_no); // row count
    		
    			$query_sub = array();
    			for ( $k = 0;$k<sizeof($argus[product]);$k++){
    				$subdata  = "("
    				. " '" . $company_no . "',"
    				. " '" . ($k+1) . "',"
    				. " '" . $argus[product_kr][$k] . "',"
    				. " '" . $argus[product_en][$k] . "',"
    				. " '" . $argus[product_jp][$k] . "' "
    				." ) ";
    				$query_sub[] = $subdata;
    			}
    			$query[]  = " REPLACE INTO " . TBL_COMPANY_PRODUCT;
    			$query[]  = " (";
    			$query[]  = " COMPANY_NO ,";
    			$query[]  = " SEQ        ,";
    			$query[]  = " PRODUCT_KR ,";
    			$query[]  = " PRODUCT_EN ,";
    			$query[]  = " PRODUCT_JP  ";
    			$query[]  = " ) VALUES ";
    			if ( !empty($query_sub) ) {
    				$query[]  = join(",\n", $query_sub);
    				$this->exec(join("\n", $query));
    			}
    		
    			$file_no1 = 0;
    			$file_no2 = 0;
    			$file_no3 = 0;
    		
    			$uploader  = new FileUpload(true,DATA_DIR . DIRECTORY_SEPARATOR . Company::$SAVE_SUB_DIR); // 업로드 인스턴스 생성
    			$uploader->getItem('file1')->setSaveName("f1_".$company_no."_")->upload();
    			$uploader->getItem('file2')->setSaveName("f2_".$company_no."_")->upload();
    			$uploader->getItem('file3')->setSaveName("f3_".$company_no."_")->upload();
    		
    			$f1 = $uploader->getItem('file1');
    			$f2 = $uploader->getItem('file2');
    			$f3 = $uploader->getItem('file3');
    			// 					echo $f1->getErrorCode() . '<BR>';
    			// 					echo $f2->getErrorCode() . '<BR>';
    			// 					echo $f3->getErrorCode() . '<BR>';
    		
    			if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {
    				$file_no1 = Common::insertFileInfor($this->db, PROC_TYPE_CM_JP, $user_no, $company_no, $f1->getName(), $f1->getExt(), $f1->getSize());
    			}
    		
    			if ( $f2->getErrorCode() == UPLOAD_ERR_OK ) {
    				$file_no2 = Common::insertFileInfor($this->db, PROC_TYPE_CM_JP, $user_no, $company_no, $f2->getName(), $f2->getExt(), $f2->getSize());
    			}
    		
    			if ( $f3->getErrorCode() == UPLOAD_ERR_OK ) {
    				$file_no3 = Common::insertFileInfor($this->db, PROC_TYPE_CM_JP, $user_no, $company_no, $f3->getName(), $f3->getExt(), $f3->getSize());
    			}
    			$fileInforUpdate = array();
    			if ( $file_no1 !=0 ) $fileInforUpdate[] = " FILE_NO1 = '" . $file_no1 . "'";
    			if ( $file_no2 !=0 ) $fileInforUpdate[] = " FILE_NO2 = '" . $file_no2 . "'";
    			if ( $file_no3 !=0 ) $fileInforUpdate[] = " FILE_NO3 = '" . $file_no3 . "'";
    			if ( !empty($fileInforUpdate) ) {
    				$this->exec(
    						"UPDATE " .TBL_COMPANY . " SET"
    						. join(",\n", $fileInforUpdate)
    						. " WHERE COMPANY_NO = '" .$company_no . "'"
    				);
    			}
    		
    			$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED ) ,0) + 1 FROM " . TBL_BIZ_CONSULT
    					." WHERE PROC_TYPE = '" . PROC_TYPE_BC_JP . "'"
    					." AND   SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)"
    			);
    			$reg_code =sprintf('%s%s%04d','JB',date("Ymd"),$cnt);
    			
// 상담정보    		
    			$query = array();
    			$query [] = "INSERT INTO " . TBL_BIZ_CONSULT;
    			$query [] = "(";
    			$query [] = " REG_CODE,";
    			$query [] = " PROC_TYPE,";
    			$query [] = " COMPANY_NO,";
    			$query [] = " CONSULT_COMPANY_NO,";
    			$query [] = " STATE,";
    			$query [] = " CONSULT_ITEM,";
    			$query [] = " CONSULT_ITEM_JP,";
    			$query [] = " HOPE_BIZ_TYPE,";
    			$query [] = " HOPE_BIZ,";
    			$query [] = " HOPE_BIZ_JP,";
    			$query [] = " HOPE_TRADE_TYPE,";
    			$query [] = " HOPE_TRADE_TYPE_JP,";
    			$query [] = " OPEN_LIMIT,";
    			$query [] = " ETC_QUESTION,";
    			$query [] = " ETC_QUESTION_JP,";
    			$query [] = " ACTION_PLAN,";
    			$query [] = " OPEN_YN,";
    			$query [] = " REG_DATE";
    			$query [] = " ) VALUES (";
    			$query [] = " '" . $reg_code    . "',";
    			$query [] = " '" . PROC_TYPE_BC_JP . "',";
    			$query [] = " '" . $company_no   . "',";
    			$query [] = " '0',";
    			$query [] = " '" . STATE_JP_BC_REG  . "',";
    			$query [] = " '" . $argus[consult_item] . "',";
    			$query [] = " '" . $argus[consult_item_jp] . "',";
    			$query [] = " '" . $argus[hope_biz_type] . "',";
    			$query [] = " '" . $argus[hope_biz] . "',";
    			$query [] = " '" . $argus[hope_biz_jp] . "',";
    			$query [] = " '" . $argus[hope_trade_type] . "',";
    			$query [] = " '" . $argus[hope_trade_type_jp] . "',";
    			$query [] = " '" . $argus[open_limit] . "',";
    			$query [] = " '" . $argus[etc_question] . "',";
    			$query [] = " '" . $argus[etc_question_jp] . "',";
    			$query [] = " '" . $argus[action_plan] . "',";
    			$query [] = " 'N',";
    			$query [] = " now()";
    			$query [] = " );";
    			$this->setQuery(join(PHP_EOL, $query));
    			//            out.print($this->getQuery());
    			if ( $this->db->exec($this->getQuery()) ) {
    				$consult_no = $this->db->getInsertId(); // insert id
    				$this->appendNode("insert_id", $consult_no);
    				//                out.print($this->db->getAffectedRows());
    				// 담당자정보 입력.
    				$worker_no = Worker::externalInsert($this->db, $argus);
    				// 					echo $worker_no;
    				$this->appendNode("insert_worker_no", $worker_no);
    		
    				$updateInfor = array();
    				$updateInfor[] = " WORKER_NO = '" . $worker_no . "'";
    		
    				$file_no4 = 0;
    				$file_no5 = 0;
    				$file_no6 = 0;
//     				                	echo DATA_DIR . DIRECTORY_SEPARATOR . BizConsult::$SAVE_SUB_DIR;
//     				                	throw new Exception("상담정보 입력처리중 에러가 발생하였습니다.");
    				$uploader2  = new FileUpload(true,DATA_DIR . DIRECTORY_SEPARATOR . BizConsult::$SAVE_SUB_DIR); // 업로드 인스턴스 생성
    				//                 	var_dump($uploader);
//     				echo '$uploader2->getSaveDir() : ' . $uploader2->getSaveDir();
    				$uploader2->getItem('file4')->setSaveName("f4_".$consult_no."_")->upload();
    				$uploader2->getItem('file5')->setSaveName("f5_".$consult_no."_")->upload();
    				$uploader2->getItem('file6')->setSaveName("f6_".$consult_no."_")->upload();
    		
    				$f4 = $uploader2->getItem('file4');
    				$f5 = $uploader2->getItem('file5');
    				$f6 = $uploader2->getItem('file6');
    				// 					echo $f4->getErrorCode() . '<BR>';
    				// 					echo $f5->getErrorCode() . '<BR>';
    				// 					echo $f6->getErrorCode() . '<BR>';
    		
    				if ( $f4->getErrorCode() == UPLOAD_ERR_OK ) {
    					$file_no4 = Common::insertFileInfor($this->db, PROC_TYPE_BC_JP, $user_no, $company_no, $f4->getName(), $f4->getExt(), $f4->getSize());
    				}
    		
    				if ( $f5->getErrorCode() == UPLOAD_ERR_OK ) {
    					$file_no5 = Common::insertFileInfor($this->db, PROC_TYPE_BC_JP, $user_no, $company_no, $f5->getName(), $f5->getExt(), $f5->getSize());
    				}
    		
    				if ( $f6->getErrorCode() == UPLOAD_ERR_OK ) {
    					$file_no6 = Common::insertFileInfor($this->db, PROC_TYPE_BC_JP, $user_no, $company_no, $f6->getName(), $f6->getExt(), $f6->getSize());
    				}
    		
    				if ( $file_no4 !=0 ) $updateInfor[] = " FILE_NO1 = '" . $file_no4 . "'";
    				if ( $file_no5 !=0 ) $updateInfor[] = " FILE_NO2 = '" . $file_no5 . "'";
    				if ( $file_no6 !=0 ) $updateInfor[] = " FILE_NO3 = '" . $file_no6 . "'";
    				if ( !empty($updateInfor) ) {
    					$this->exec(
    							"UPDATE " .TBL_BIZ_CONSULT . " SET"
    							. join(",\n", $updateInfor)
    							. " WHERE CONSULT_NO = '" .$consult_no . "'"
    					);
    		
    				}
    			} else {
    				throw new Exception("상담정보 입력처리중 에러가 발생하였습니다.");
    			}
    			if ( !$this->db->commit() ) throw new Exception("입력처리중 에러가 발생하였습니다.");
    		} else {
    			throw new Exception("기업정보 입력처리중 에러가 발생하였습니다.");
    		}
    	} catch (Exception $e) {
    		$this->db->rollback();
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
    	$this->printXML(C_DB_PROCESS_MODE_INSERT);
    }    

    /**
     * code를 array화한다.
     */
    public function getCodeData() {
    	// CODE DATA 정의
    	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
//     	$this->addCodeData("SEX"       , self::$CODE_SEX       );
//     	$this->addCodeData("STATE"     , self::$CODE_USER_STATE);
//     	$this->addCodeData("EMAIL_YN"  , self::$CODE_YN    );
    }          
}
if ( DEBUG ) {
	$test = new Company();
		
	/* test */
	$argus = array();
	/* register */
// 	$argus[user_name ] = "테스트";
// 	$argus[user_email] = "test01";
// 	$argus[user_level] = "1";
// 	$argus[passwd    ] = "1";
// 	$argus[state     ] = "U";
// 	$test->setTableName(TBL_COMPANY);
// 	$test->insert($argus);

	/* dupcheck */
// 	$argus[p_user_id] = "admin";
// 	$test->checkDupId($argus);

	/* get */
// 	$argus[p_user_no] = "19";
// 	$test->get($argus);

	/* update */
// 	$argus[user_no  	 ] = "19";
// 	$argus[user_name	 ] = "김개똥";
// 	$argus[passwd   	 ] = "1";
// 	$argus[passwd_hint	 ] = "passwd_hint 1";
// 	$argus[passwd_correct] = "passwd_correct 1";
// 	$test->update($argus);
}
?>