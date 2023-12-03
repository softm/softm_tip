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
/**
 * @author softm
 * 기업정보 / Company.php
 */
class Company extends BaseDataBase
{
	/** @var upload file directory */ public static $SAVE_SUB_DIR = "company";
	
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
        	$tbl1 = $this->newTable(TBL_COMPANY);
        	$tbl1->newColumn('COMPANY_NO','번호',1)->setWidth(100)->setAlign("center");
        	$tbl1->newColumn('COUNTRY_TYPE','국가',2)->setHide();
//         	$tbl1->newColumn('COMPANY_TYPE','기업형태',3)->setHide();
//         	$tbl1->newColumn('COMPANY_TYPE','기업형태',3)->setType(Column::LISTBOX_TYPE)->setEditable(false);
        	$tbl1->newColumn('BIZ_FIELD','업종분야',4)->setWidth(130)->setType(Column::LISTBOX_TYPE)->setEditable(false);
//         	$tbl1->newColumn('BIZ_CLASSIFIED','업종분류',5)->setWidth(130)->setType(Column::LISTBOX_TYPE)->setEditable(false);
        	$tbl1->newColumn('COMPANY_NM_KR','업체명',6)->setWidth(300)->setCssText("text-align:left;padding-left:5px;");
        	$tbl1->newColumn('REG_DATE','등록일',7)->setKey(false); 
        }
        
    }

    public function __destruct() {
        parent::__destruct();
        $this->end();
    }
   
    /**
     * 기업회원가입.
    **/
    function insert($argus) {
    	$company_code = $argus[company_code1] . $argus[company_code2] . $argus[company_code3];
    	
    	$this->testJsCall($argus);
    	$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED ) ,0) + 1 FROM " . TBL_COMPANY
    			." WHERE COUNTRY_TYPE = '" . COUNTRY_TYPE_KR . "'"
    			." AND   SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)"
    	);
    	//             	echo $cnt . "<BR>";
    	$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);    
    	
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
		
		$tel = $argus[tel1] . '-' . $argus[tel2] . '-' . $argus[tel3];
		$fax = $argus[fax1] . '-' . $argus[fax2] . '-' . $argus[fax3];
		
		$this->startXML(); // xml start node
		try {
			if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");			
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
			$query[]  = " JP_TRADE_YN         ,";
			$query[]  = " ETC_TRADE_YN        ,";
			$query[]  = " INTERNAL_CUSTOMER   ,";
			$query[]  = " EXTERNAL_CUSTOMER   ,";
// 			$query[]  = " FILE_NO1            ,";
// 			$query[]  = " FILE_NO2            ,";
// 			$query[]  = " FILE_NO3            ,";
			$query[]  = " REG_DATE             ";
// 			$query[]  = " MOD_DATE             ";
			$query[]  = " ) ";
			$query[]  = " VALUES ( ";
// 			$query[]  = " '" . $argus[company_no        ] . "',";
			$query[]  = " '" . USER_NO                    . "',";
			$query[]  = " '" . $reg_code          	      . "',";
			$query[]  = " '" . $argus[country_type      ] . "',";
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
			$query[]  = " '" . $establish_date            . "',";
			$query[]  = " '" . $argus[zip_code          ] . "',";
			$query[]  = " '" . $argus[addr_kr           ] . "',";
			$query[]  = " '" . $argus[addr_en           ] . "',";
			$query[]  = " '" . $argus[addr_hj           ] . "',";
			$query[]  = " '" . $argus[addr_jp           ] . "',";
			$query[]  = " '" . $worker_cnt         		  . "',";
			$query[]  = " '" . $tel                       . "',";
			$query[]  = " '" . $fax                       . "',";
			$query[]  = " '" . $argus[homepage          ] . "',";
			$query[]  = " '" . $capital                   . "',";
			$query[]  = " '" . $sales                     . "',";
			$query[]  = " '" . $expect_sales              . "',";
			$query[]  = " '" . $ordinary_income           . "',";
			$query[]  = " '" . $argus[main_product      ] . "',";
			$query[]  = " '" . $argus[company_intro     ] . "',";
			$query[]  = " '" . $argus[jp_trade_yn       ] . "',";
			$query[]  = " '" . $argus[etc_trade_yn      ] . "',";
			$query[]  = " '" . $argus[internal_customer ] . "',";
			$query[]  = " '" . $argus[external_customer ] . "',";
// 			$query[]  = " '" . $argus[file_no1          ] . "',";
// 			$query[]  = " '" . $argus[file_no2          ] . "',";
// 			$query[]  = " '" . $argus[file_no3          ] . "',";
			$query[]  = " now()";
// 			$query[]  = " '" . $argus[mod_date          ] . "' ";
			$query[]  = " ) ";
			
// 	echo join("<BR>", $query);
    		$this->setQuery(join("\n", $query));
    		$this->db->setAutoCommit(false);
			if ( $this->exec($this->getQuery()) ) {
				$company_no = $this->db->getInsertId();
				unset($query);
				
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
				
				// USER 등급 업데이트
				$this->exec(
					"UPDATE " .TBL_MEMBER . " SET"
					. " USER_LEVEL = '" . MEMBER_TYPE_BIZ . "' "
					. " WHERE USER_NO = '" . USER_NO . "'"
				);
								
				$file_no1 = 0;
				$file_no2 = 0;
				$file_no3 = 0;
				if ( $this->db->commit() ) {
					// session 생성
					Session::setSession("user_level", MEMBER_TYPE_BIZ);
					Session::setSession("company_no", $company_no    );
					
					$uploader  = new FileUpload(true,DATA_DIR . DIRECTORY_SEPARATOR . Company::$SAVE_SUB_DIR); // 업로드 인스턴스 생성
					$uploader->getItem('file1')->setSaveName("f1_".$company_no."_");
					$uploader->getItem('file2')->setSaveName("f2_".$company_no."_");
					$uploader->getItem('file3')->setSaveName("f3_".$company_no."_");
					$uploader->upload();
					
					$f1 = $uploader->getItem('file1');
					$f2 = $uploader->getItem('file2');
					$f3 = $uploader->getItem('file3');
// 					echo $f1->getErrorCode() . '<BR>';
// 					echo $f2->getErrorCode() . '<BR>';
// 					echo $f3->getErrorCode() . '<BR>';

					if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) { 
						$file_no1 = Common::insertFileInfor($this->db, PROC_TYPE_CM, USER_NO, $company_no, $f1->getName(), $f1->getExt(), $f1->getSize());
					}
					
					if ( $f2->getErrorCode() == UPLOAD_ERR_OK ) {
						$file_no2 = Common::insertFileInfor($this->db, PROC_TYPE_CM, USER_NO, $company_no, $f2->getName(), $f2->getExt(), $f2->getSize());
					}
					
					if ( $f3->getErrorCode() == UPLOAD_ERR_OK ) {
						$file_no3 = Common::insertFileInfor($this->db, PROC_TYPE_CM, USER_NO, $company_no, $f3->getName(), $f3->getExt(), $f3->getSize());
					}
					$fileInforUpdate = array();
					if ( $file_no1 !=0 ) $fileInforUpdate[] = " FILE_NO1 = '" . $file_no1 . "'";
					if ( $file_no2 !=0 ) $fileInforUpdate[] = " FILE_NO2 = '" . $file_no2 . "'";
					if ( $file_no3 !=0 ) $fileInforUpdate[] = " FILE_NO3 = '" . $file_no3 . "'";
					if ( !empty($fileInforUpdate) ) {
						$this->db->setAutoCommit(false);
						
						$this->exec(
						"UPDATE " .TBL_COMPANY . " SET"	
				       . join(",\n", $fileInforUpdate)				
					   . " WHERE COMPANY_NO = '" .$company_no . "'"						
						);
						
						$this->db->commit();						
					}
				}
    		}
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
//     	print $this->makeXML(C_DB_PROCESS_MODE_PROC);	
    	$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_INSERT)); // 성공시 출력 메시지.
    	$this->printXML(C_DB_PROCESS_MODE_INSERT);
    }
 

    /**
     * 기업회원수정
     * @param array $argus
     */
    function update(array $argus) {
//     	var_dump($argus);
    	$company_code = $argus[company_code1] . $argus[company_code2] . $argus[company_code3];

    	$this->testJsCall($argus);
    	//$cnt = $this->db->getOne("SELECT COUNT(*) + 1 FROM " . TBL_COMPANY ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
    	//     	echo $cnt . '<BR>';

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
    	
    	$tel = $argus[tel1] . '-' . $argus[tel2] . '-' . $argus[tel3];
    	$fax = $argus[fax1] . '-' . $argus[fax2] . '-' . $argus[fax3];
//     	echo $argus[tel1];
    	$this->startXML(); // xml start node
    	
    	try {
    		if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");    		
    		// 파일정보
    		$fInfor = $this->db->get(
    				"SELECT "
    				. "FILE_NO1, "
    				. "FILE_NO2, "
    				. "FILE_NO3  "
    				. " FROM ". TBL_COMPANY
    				. " WHERE COMPANY_NO = '" . COMPANY_NO . "'"
    		);
    		$file_no1 = $fInfor->FILE_NO1;
    		$file_no2 = $fInfor->FILE_NO2;
    		$file_no3 = $fInfor->FILE_NO3;
    		// 					echo '$oldFileInfor ' . $oldFileInfor['FILE_NO1']->FILE_EXT;
    		$oldFileInfor = Common::getFileInfor($this->db,$fInfor,"FILE_NO,FILE_EXT");
    		$oldFile1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;
    		$oldFile2Ext = $oldFileInfor['FILE_NO2']->FILE_EXT;
    		$oldFile3Ext = $oldFileInfor['FILE_NO3']->FILE_EXT;
    			
    		$query[]  = " UPDATE " . TBL_COMPANY;
    		$query[]  = " SET ";
//    		$query[]  = " USER_NO             = '" . USER_NO                    . "',";
//    		$query[]  = " REG_CODE            = '" . $reg_code                  . "',"; // KC20120305 0001
//    		$query[]  = " COUNTRY_TYPE        = '" . $argus[country_type      ] . "',";
    		$query[]  = " COMPANY_CODE        = '" . $company_code              . "',";
    		$query[]  = " COMPANY_TYPE        = '" . $argus[company_type      ] . "',";
    		$query[]  = " COMPANY_NM_KR       = '" . $argus[company_nm_kr     ] . "',";
    		$query[]  = " COMPANY_NM_EN       = '" . $argus[company_nm_en     ] . "',";
    		$query[]  = " COMPANY_NM_HJ       = '" . $argus[company_nm_hj     ] . "',";
    		$query[]  = " COMPANY_NM_JP       = '" . $argus[company_nm_jp     ] . "',";
    		$query[]  = " CEO_NM_KR           = '" . $argus[ceo_nm_kr         ] . "',";
    		$query[]  = " CEO_NM_EN           = '" . $argus[ceo_nm_en         ] . "',";
    		$query[]  = " CEO_NM_HJ           = '" . $argus[ceo_nm_hj         ] . "',";
    		$query[]  = " CEO_NM_JP           = '" . $argus[ceo_nm_jp         ] . "',";
    		$query[]  = " BIZ_FIELD           = '" . $argus[biz_field         ] . "',";
    		$query[]  = " BIZ_CLASSIFIED      = '" . $biz_classified            . "',";
    		$query[]  = " BIZ_CLASSIFIED_ETC  = '" . $argus[biz_classified_etc] . "',";
    		$query[]  = " BIZ_NAME            = '" . $argus[biz_name          ] . "',";
    		$query[]  = " ESTABLISH_DATE      = '" . $establish_date            . "',";
    		$query[]  = " ZIP_CODE            = '" . $argus[zip_code          ] . "',";
    		$query[]  = " ADDR_KR             = '" . $argus[addr_kr           ] . "',";
    		$query[]  = " ADDR_EN             = '" . $argus[addr_en           ] . "',";
    		$query[]  = " ADDR_HJ             = '" . $argus[addr_hj           ] . "',";
    		$query[]  = " ADDR_JP             = '" . $argus[addr_jp           ] . "',";
    		$query[]  = " WORKER_CNT          = '" . $worker_cnt                . "',";
    		$query[]  = " TEL                 = '" . $tel                       . "',";
    		$query[]  = " FAX                 = '" . $fax                       . "',";
    		$query[]  = " HOMEPAGE            = '" . $argus[homepage          ] . "',";
    		$query[]  = " CAPITAL             = '" . $capital                   . "',";
    		$query[]  = " SALES               = '" . $sales                     . "',";
    		$query[]  = " EXPECT_SALES        = '" . $expect_sales              . "',";
    		$query[]  = " ORDINARY_INCOME     = '" . $ordinary_income           . "',";
    		$query[]  = " MAIN_PRODUCT        = '" . $argus[main_product      ] . "',";
    		$query[]  = " COMPANY_INTRO       = '" . $argus[company_intro     ] . "',";
    		$query[]  = " JP_TRADE_YN         = '" . $argus[jp_trade_yn       ] . "',";
    		$query[]  = " ETC_TRADE_YN        = '" . $argus[etc_trade_yn      ] . "',";
    		$query[]  = " INTERNAL_CUSTOMER   = '" . $argus[internal_customer ] . "',";
    		$query[]  = " EXTERNAL_CUSTOMER   = '" . $argus[external_customer ] . "',";
    		
    		if ( $argus[file1_delete] == 'Y' ) $query[]  = " FILE_NO1   = NULL,";
    		if ( $argus[file2_delete] == 'Y' ) $query[]  = " FILE_NO2   = NULL,";
    		if ( $argus[file3_delete] == 'Y' ) $query[]  = " FILE_NO3   = NULL,";
    		    		
    		$query[]  = " MOD_DATE            = now() ";
    		$query[]  = " WHERE COMPANY_NO = '" . COMPANY_NO . "'";

    		// 	echo join("<BR>", $query);
    		$this->setQuery(join("\n", $query));
    		$this->db->setAutoCommit(false);
    		if ( $this->exec($this->getQuery()) ) {
                unset($query);
                $query_sub = array();
    			for ( $k = 0;$k<sizeof($argus[product]);$k++){
	    			$subdata  = "("
                                . " '" . COMPANY_NO . "',"
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

    			if ( $this->db->commit() ) {
//     				Session::setSession("user_level", MEMBER_TYPE_BIZ);
//     				Session::setSession("company_no", $company_no    );
    				$this->db->setAutoCommit(false);
/* */
    				$saveDir = DATA_DIR . DIRECTORY_SEPARATOR . Company::$SAVE_SUB_DIR;				
    				$uploader  = new FileUpload(true,$saveDir); // 업로드 인스턴스 생성
    				
    				$f1 = $uploader->getItem('file1')->setSaveName("f1_".COMPANY_NO."_");
    				$f2 = $uploader->getItem('file2')->setSaveName("f2_".COMPANY_NO."_");
    				$f3 = $uploader->getItem('file3')->setSaveName("f3_".COMPANY_NO."_");
    		
//     									echo $f1->getErrorCode() . ' / '   . $f1->getError() . '<BR>';
    				// 					echo $f2->getErrorCode() . '<BR>';
    				// 					echo $f3->getErrorCode() . '<BR>';
    				if ( $argus[file1_delete] == 'Y' ) {
    					@unlink($saveDir.DIRECTORY_SEPARATOR."f1_".COMPANY_NO."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
    					Common::deleteFileInfor($this->db, $file_no1);
    					$file_no1 = 0;
    				} 
    				if ( $file_no2 && $argus[file2_delete] == 'Y' ) {
    					@unlink($saveDir.DIRECTORY_SEPARATOR."f2_".COMPANY_NO."_".( $oldFile2Ext?"." .$oldFile2Ext:"") );
    					Common::deleteFileInfor($this->db, $file_no2);
    					$file_no2 = 0;
    				}
    				if ( $file_no3 && $argus[file3_delete] == 'Y' ) {
    					@unlink($saveDir.DIRECTORY_SEPARATOR."f3_".COMPANY_NO."_".( $oldFile3Ext?"." .$oldFile3Ext:"") );
    					Common::deleteFileInfor($this->db, $file_no3);
    					$file_no3 = 0;
    				}
    				
    				/* @var Company Table file no 갱신 */
    				$fileInforUpdate = array();
    				
    				if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {
						if ( !$file_no1 ) {
							$file_no1 = Common::insertFileInfor($this->db, PROC_TYPE_CM, USER_NO, COMPANY_NO, $f1->getName(), $f1->getExt(), $f1->getSize());
							$fileInforUpdate[] = " FILE_NO1 = '" . $file_no1 . "'";							
						} else {
							@unlink($saveDir.DIRECTORY_SEPARATOR."f1_".COMPANY_NO."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
							$file_no1 = Common::updateFileInfor($this->db, $file_no1, $f1->getName(), $f1->getExt(), $f1->getSize());
						}
    					$f1->upload();
					}

					if ( $f2->getErrorCode() == UPLOAD_ERR_OK ) {
						if ( !$file_no2 ) {
							$file_no2 = Common::insertFileInfor($this->db, PROC_TYPE_CM, USER_NO, COMPANY_NO, $f2->getName(), $f2->getExt(), $f2->getSize());
							$fileInforUpdate[] = " FILE_NO2 = '" . $file_no2 . "'";
						} else {
							@unlink($saveDir.DIRECTORY_SEPARATOR."f2_".COMPANY_NO."_".( $oldFile2Ext?"." .$oldFile2Ext:""));
							$file_no2 = Common::updateFileInfor($this->db, $file_no2, $f2->getName(), $f2->getExt(), $f2->getSize());
						}
						$f2->upload();
					}

					if ( $f3->getErrorCode() == UPLOAD_ERR_OK ) {
						if ( !$file_no3 ) {
							$file_no3 = Common::insertFileInfor($this->db, PROC_TYPE_CM, USER_NO, COMPANY_NO, $f3->getName(), $f3->getExt(), $f3->getSize());
							$fileInforUpdate[] = " FILE_NO3 = '" . $file_no3 . "'";
						} else {
							@unlink($saveDir.DIRECTORY_SEPARATOR."f3_".COMPANY_NO."_".( $oldFile3Ext?"." .$oldFile3Ext:""));
							$file_no3 = Common::updateFileInfor($this->db, $file_no3, $f3->getName(), $f3->getExt(), $f3->getSize());
						}
						$f3->upload();
					}
					
    				if ( !empty($fileInforUpdate) ) {
    					$this->exec(
    							"UPDATE " .TBL_COMPANY . " SET"
    							. join(",\n", $fileInforUpdate)
    							. " WHERE COMPANY_NO = '" .COMPANY_NO . "'"
    					);
    				}
    				$this->db->commit();
    			}
    		}
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	
    	$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_UPDATE)); // 성공시 출력 메시지.
    	$this->printXML(C_DB_PROCESS_MODE_UPDATE);
    }
    
    /**
     * 기업정보 조회
     * @param array $argus
     */
    function get(array $argus) {
    	$p_company_no = $argus[p_company_no ];
    	$this->testJsCall($argus);
    	$this->startXML();
    	try {
    		if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다."); 
    		
    		$query = array();
    		$query[] = "SELECT";
    		$query[]  = " USER_NO             ,";
    		$query[]  = " REG_CODE            ,";
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
    		$query[]  = " JP_TRADE_YN         ,";
    		$query[]  = " ETC_TRADE_YN        ,";
    		$query[]  = " INTERNAL_CUSTOMER   ,";
    		$query[]  = " EXTERNAL_CUSTOMER   ,";
    		$query[]  = " FILE_NO1            ,";
    		$query[]  = " FILE_NO2            ,";
    		$query[]  = " FILE_NO3             ";
    		$query[] = " FROM " . TBL_COMPANY;
    		$query[] = " WHERE COMPANY_NO = '" . COMPANY_NO . "'" ;

    		$this->makeItemXML(join("\n", $query),"item","fi");
    		
			$fInfor = $this->db->get(
			        "SELECT "
			        . "FILE_NO1, "
			        . "FILE_NO2, "
			        . "FILE_NO3  "
			        . " FROM ". TBL_COMPANY 
			        . " WHERE COMPANY_NO = '" . COMPANY_NO . "'"
			);
			$file_no1 = $fInfor->FILE_NO1;
			$file_no2 = $fInfor->FILE_NO2;
			$file_no3 = $fInfor->FILE_NO3;
			
// 			var_dump($fInfor);
// 			echo '$file_no1 : ' . $file_no1 ;
// 			echo '$oldFileInfor ' . $oldFileInfor['FILE_NO1']->FILE_EXT;
			
			$oldFileInfor = Common::getFileInfor($this->db,$fInfor,"FILE_NO,FILE_NAME,FILE_EXT,FILE_SIZE");
			$oldFile1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;
			$oldFile2Ext = $oldFileInfor['FILE_NO2']->FILE_EXT;
			$oldFile3Ext = $oldFileInfor['FILE_NO3']->FILE_EXT;
     				
    		$file1Name = $oldFileInfor['FILE_NO1']->FILE_NAME;
    		$file2Name = $oldFileInfor['FILE_NO2']->FILE_NAME;
    		$file3Name = $oldFileInfor['FILE_NO3']->FILE_NAME;
    		
    		$file1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;
    		$file2Ext = $oldFileInfor['FILE_NO2']->FILE_EXT;
    		$file3Ext = $oldFileInfor['FILE_NO3']->FILE_EXT;
    		
    		$this->appendNode('filename1', $file1Name);
    		$this->appendNode('filename2', $file2Name);
    		$this->appendNode('filename3', $file3Name);

    		$this->appendNode('fileext1', $file1Ext);
    		$this->appendNode('fileext2', $file2Ext);
    		$this->appendNode('fileext3', $file3Ext);

    		$this->appendNode('fileno1', $file_no1);
    		$this->appendNode('fileno2', $file_no2);
    		$this->appendNode('fileno3', $file_no3);
    		
    		//     		echo '$File1Name : ' . $File1Name;
    		// 기업정보 생산제품.
    		$query = array();
    		$query[] = "SELECT";
    		$query[]  = " COMPANY_NO ,";
    		$query[]  = " SEQ        ,";
    		$query[]  = " PRODUCT_KR ,";
    		$query[]  = " PRODUCT_EN ,";
    		$query[]  = " PRODUCT_JP  ";
    		$query[] = " FROM " . TBL_COMPANY_PRODUCT;
    		$query[] = " WHERE COMPANY_NO = '" . COMPANY_NO . "'" ;
    		$this->makeItemXML(join("\n", $query),"item1","fi1");
    		
    		$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
	
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->printXML(C_DB_PROCESS_MODE_SELECT);
    }

     /**
     * 조회-그리드
     * @param array $argus
     * @return DOMDocument
     */
    public function select($argus) {
    	global $page_tab;
    	//     $this->testJsCall($argus);
    	//    	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
    	$this->getCodeData();    	
    	$this->startXML();
    	$this->setType(BaseDataBase::GRID_TYPE);
    	try {
//     		if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
    		//    		var_dump($argus);
    		$page_tab['js_function' ] = $argus["p_navi_function"];
    		$page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
    		if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];
    
    		// where 문장생성
    		$make_where = $this->makeWhere($argus);
// 			echo     	$make_where;	    		
    		$where = " COUNTRY_TYPE = '" . COUNTRY_TYPE_JP . "'"
    		       . " AND OPEN_YN = 'Y'"
    			   . ($argus["p_company_type"  ]?" AND a.COMPANY_TYPE   = '" . $argus["p_company_type"  ] . "'":"")
    			   . ($argus["s_biz_field"     ]?" AND a.BIZ_FIELD      = '" . $argus["s_biz_field"     ] . "'":"")
    			   . ($argus["s_biz_classified"]?" AND a.BIZ_CLASSIFIED LIKE '%" . $argus["s_biz_classified"] . "%'":"")
    			   . ($argus["s_hope_biz_type" ]?" AND b.HOPE_BIZ_TYPE  = '" . $argus["s_hope_biz_type" ] . "'":"")
    		;
    		
			$where .= $make_where?" AND " . $make_where:"";
			
    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_COMPANY . " a JOIN " . TBL_BIZ_CONSULT . " b "
    				 							  . " ON a.COMPANY_NO = b.COMPANY_NO "
    				                              . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());    		
    		$query = array();
    
    		$query [] = " SELECT ";
    		$query [] = " a.COMPANY_NO    COMPANY_NO   ,"; // 기업번호
    		$query [] = " a.COUNTRY_TYPE  COUNTRY_TYPE ,"; // 국가
    		$query [] = " a.COMPANY_TYPE  COMPANY_TYPE ,"; // 기업형태
    		$query [] = " a.COMPANY_NM_KR COMPANY_NM_KR,"; // 업체명 
    		$query [] = " a.BIZ_FIELD     BIZ_FIELD    ,"; // 업종분야
    		$query [] = " CASE WHEN a.BIZ_CLASSIFIED = 9 THEN a.BIZ_CLASSIFIED_ETC ELSE a.BIZ_CLASSIFIED END AS BIZ_CLASSIFIED, "; // 업종분류
    		$query [] = " DATE_FORMAT(a.REG_DATE,'%Y-%m-%d %H:%i') REG_DATE"; // 등록일
    		$query [] = " FROM " . TBL_COMPANY . " a JOIN " . TBL_BIZ_CONSULT . " b "  ;
    		$query [] = " ON a.COMPANY_NO = b.COMPANY_NO "  ;
    		
    		// where 문장생성
    		if ( $where ) $query[] = ( " WHERE " . $where );
    		
    		$query[] =  ( $this->getQuerySort()?" ORDER BY ". $this->getQuerySort():'' );
    		$query[] =  " LIMIT " . ( $page_tab['s'] - 1 ) . ", " . $cur_many;
    
    		$this->setQuery(join(PHP_EOL, $query));
    		//         out.print($this->getQuery());
    		
    		$this->makeItemXML($this->getQuery(),"item","fieldinfo");
    		//         out.print($this->db->getAffectedRows());
    		$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->printXML(C_DB_PROCESS_MODE_SELECT);
    }
   
    /**
     * code를 array화한다.
     */
    public function getCodeData() {
    	// CODE DATA 정의
    	$this->addCodeData("BIZ_FIELD", self::$CODE_BIZ_FIELD);
    	$this->addCodeData("BIZ_CLASSIFIED", self::$CODE_BIZ_CLASSIFIED);
    	$this->addCodeData("COMPANY_TYPE", self::$CODE_COMPANY_TYPE);
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