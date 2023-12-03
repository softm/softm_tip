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
			$tbl1->newColumn('COMPANY_NM_KR','기업명',2)->setWidth(200)->setAlign("left");
			$tbl1->newColumn('CEO_NM_KR'    ,'대표자명',3);
			$tbl1->newColumn('REG_DATE'     ,'등록일',4)->setWidth(150)->setKey(false);			
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
    		if ( !ADMIN ) throw new Exception("권한이 없습니다.");
    		//    		var_dump($argus);
    		$page_tab['js_function' ] = $argus["p_navi_function"];
    		$page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
    		if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];
    
    		// where 문장생성
    		$make_where = $this->makeWhere($argus);
    		// 			echo     	$make_where;
    		$where = " COUNTRY_TYPE = '" . COUNTRY_TYPE_KR . "'"
    		. ($argus["p_company_type"  ]?" AND COMPANY_TYPE   = '" . $argus["p_company_type"  ] . "'":"")
    		. ($argus["s_biz_field"     ]?" AND BIZ_FIELD      = '" . $argus["s_biz_field"     ] . "'":"")
    		. ($argus["s_biz_classified"]?" AND BIZ_CLASSIFIED = '" . $argus["s_biz_classified"] . "'":"")
    		. ($argus["s_biz_type"      ]?" AND BIZ_TYPE       = '" . $argus["s_biz_type"      ] . "'":"")
    		;
    
    		$where .= $make_where?" AND " . $make_where:"";
    
    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_COMPANY . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());
    		$query = array();
    
    		$query [] = " SELECT ";
    		$query [] = " COMPANY_NO,"; // 기업번호
    		$query [] = " COUNTRY_TYPE,"; // 국가
    		$query [] = " COMPANY_TYPE,"; // 기업형태
    		$query [] = " COMPANY_NM_KR,"; // 업체명
    		$query [] = " BIZ_FIELD    ,"; // 업종분야
    		$query [] = " CASE WHEN BIZ_CLASSIFIED = 9 THEN BIZ_CLASSIFIED_ETC ELSE BIZ_CLASSIFIED END AS BIZ_CLASSIFIED, "; // 업종분류
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE"; // 등록일
    		$query [] = " FROM " . TBL_COMPANY;
    
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
     * 조회-그리드
     * @param array $argus
     * @return DOMDocument
     */
    public function selectJp($argus) {
    	global $page_tab;
    	//     $this->testJsCall($argus);
    	//    	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
    	$this->getCodeData();
    	$this->startXML();
    	$this->setType(BaseDataBase::GRID_TYPE);
    	try {
    		if ( !ADMIN ) throw new Exception("권한이 없습니다.");
    		//    		var_dump($argus);
    		$page_tab['js_function' ] = $argus["p_navi_function"];
    		$page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
    		if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];
    
    		// where 문장생성
    		$make_where = $this->makeWhere($argus);
    		// 			echo     	$make_where;
    		$where = " COUNTRY_TYPE = '" . COUNTRY_TYPE_JP . "'"
//     			   . ($argus["p_company_type"  ]?" AND a.COMPANY_TYPE   = '" . $argus["p_company_type"  ] . "'":"")
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
    		$query [] = " a.CEO_NM_KR     CEO_NM_KR    ,"; // 대표자명
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
     * 아이디 중복검사.
     **/
    public function checkDupId($argus) {
//     	sleep(3);
    	$p_user_id      = $argus[p_user_id ];
    	$this->testJsCall($argus);
    	try {
    		if ( !Util::isEmail($p_user_id) ) throw new Exception("아이디는 이메일 형식이어야합니다.");
    		$query = array();
    		$query[] = " SELECT ";
    		$query[] = " COUNT(*) ";
    		$query[] = " FROM " . TBL_MEMBER                    ;
    		$query[] = " WHERE USER_EMAIL = '" . ($p_user_id) . "'";
    
    		$count = $this->db->getOne (join("\n", $query));
    
    		$this->setQuery(join("\n", $query));
    		if ( $count == 0 ) {
    			$this->addMessage("사용할 수 있는 아이디입니다.");    			
    		} else {
    			throw new Exception("이미 사용중인 아이디입니다.");
    		}
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	print $this->makeXML(C_DB_PROCESS_MODE_PROC);
    }    
    
    /**
     * 기업회원가입.
    **/
    function insert($argus) {
    	$user_no = $argus[p_user_no]?$argus[p_user_no]:0;
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

		$this->startXML(); // xml start node
		try {
			if ( !ADMIN ) throw new Exception("권한이 없습니다.");			
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
			$query[]  = " '" . $user_no                   . "',";
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
			$query[]  = " '" . $argus[tel               ] . "',";
			$query[]  = " '" . $argus[fax               ] . "',";
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
				
				// USER 등급 업데이트
				$this->exec(
					"UPDATE " .TBL_MEMBER . " SET"
					. " USER_LEVEL = '" . MEMBER_TYPE_BIZ . "' "
					. " WHERE USER_NO = '" . $user_no . "'"
				);
								
				$file_no1 = 0;
				$file_no2 = 0;
				$file_no3 = 0;
				if ( $this->db->commit() ) {
					// session 생성
// 					Session::setSession("user_level", MEMBER_TYPE_BIZ);
// 					Session::setSession("company_no", $company_no    );
					
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
						$file_no1 = Common::insertFileInfor($this->db, PROC_TYPE_CM, $user_no, $company_no, $f1->getName(), $f1->getExt(), $f1->getSize());
					}
					
					if ( $f2->getErrorCode() == UPLOAD_ERR_OK ) {
						$file_no2 = Common::insertFileInfor($this->db, PROC_TYPE_CM, $user_no, $company_no, $f2->getName(), $f2->getExt(), $f2->getSize());
					}
					
					if ( $f3->getErrorCode() == UPLOAD_ERR_OK ) {
						$file_no3 = Common::insertFileInfor($this->db, PROC_TYPE_CM, $user_no, $company_no, $f3->getName(), $f3->getExt(), $f3->getSize());
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
    	$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
    	$this->printXML(C_DB_PROCESS_MODE_INSERT);
    }
 
    /**
     * 기업회원수정
     * @param array $argus
     */
    function update(array $argus) {
//     	var_dump($argus);
    	$p_company_no = $argus[p_company_no ];
    	$company_code = $argus[company_code1] . $argus[company_code2] . $argus[company_code3];

    	$this->testJsCall($argus);

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
    		if ( !ADMIN ) throw new Exception("권한이 없습니다.");
    		// 파일정보
    		$fInfor = $this->db->get(
    				"SELECT "
    				. "FILE_NO1, "
    				. "FILE_NO2, "
    				. "FILE_NO3  "
    				. " FROM ". TBL_COMPANY
    				. " WHERE COMPANY_NO = '" . $p_company_no . "'"
    		);
    		$file_no1 = $fInfor->FILE_NO1;
    		$file_no2 = $fInfor->FILE_NO2;
    		$file_no3 = $fInfor->FILE_NO3;
    		
//     							echo '$oldFileInfor ' . $fInfor['FILE_NO1']->FILE_EXT;
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
    		$query[]  = " BIZ_NAME_JP         = '" . $argus[biz_name_jp       ] . "',";
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
    		$query[]  = " WHERE COMPANY_NO = '" . $p_company_no . "'";

    		// 	echo join("<BR>", $query);
    		$this->setQuery(join("\n", $query));
    		$this->db->setAutoCommit(false);
    		if ( $this->exec($this->getQuery()) ) {
                unset($query);
                $query_sub = array();
    			for ( $k = 0;$k<sizeof($argus[product]);$k++){
	    			$subdata  = "("
                                . " '" . $p_company_no . "',"
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
    				
    				$f1 = $uploader->getItem('file1')->setSaveName("f1_".$p_company_no."_");
    				$f2 = $uploader->getItem('file2')->setSaveName("f2_".$p_company_no."_");
    				$f3 = $uploader->getItem('file3')->setSaveName("f3_".$p_company_no."_");
    		
//     									echo $f1->getErrorCode() . ' / '   . $f1->getError() . '<BR>';
    				// 					echo $f2->getErrorCode() . '<BR>';
    				// 					echo $f3->getErrorCode() . '<BR>';
    				if ( $argus[file1_delete] == 'Y' ) {
    					@unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_company_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
    					Common::deleteFileInfor($this->db, $file_no1);
    					$file_no1 = 0;
    				} 
    				if ( $file_no2 && $argus[file2_delete] == 'Y' ) {
    					@unlink($saveDir.DIRECTORY_SEPARATOR."f2_".$p_company_no."_".( $oldFile2Ext?"." .$oldFile2Ext:"") );
    					Common::deleteFileInfor($this->db, $file_no2);
    					$file_no2 = 0;
    				}
    				if ( $file_no3 && $argus[file3_delete] == 'Y' ) {
    					@unlink($saveDir.DIRECTORY_SEPARATOR."f3_".$p_company_no."_".( $oldFile3Ext?"." .$oldFile3Ext:"") );
    					Common::deleteFileInfor($this->db, $file_no3);
    					$file_no3 = 0;
    				}
    				
    				/* @var Company Table file no 갱신 */
    				$fileInforUpdate = array();
    				
    				if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {
						if ( !$file_no1 ) {
							$file_no1 = Common::insertFileInfor($this->db, PROC_TYPE_CM, USER_NO, $p_company_no, $f1->getName(), $f1->getExt(), $f1->getSize());
							$fileInforUpdate[] = " FILE_NO1 = '" . $file_no1 . "'";							
						} else {
							@unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_company_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
							$file_no1 = Common::updateFileInfor($this->db, $file_no1, $f1->getName(), $f1->getExt(), $f1->getSize());
						}
    					$f1->upload();
					}

					if ( $f2->getErrorCode() == UPLOAD_ERR_OK ) {
						if ( !$file_no2 ) {
							$file_no2 = Common::insertFileInfor($this->db, PROC_TYPE_CM, USER_NO, $p_company_no, $f2->getName(), $f2->getExt(), $f2->getSize());
							$fileInforUpdate[] = " FILE_NO2 = '" . $file_no2 . "'";
						} else {
							@unlink($saveDir.DIRECTORY_SEPARATOR."f2_".$p_company_no."_".( $oldFile2Ext?"." .$oldFile2Ext:""));
							$file_no2 = Common::updateFileInfor($this->db, $file_no2, $f2->getName(), $f2->getExt(), $f2->getSize());
						}
						$f2->upload();
					}

					if ( $f3->getErrorCode() == UPLOAD_ERR_OK ) {
						if ( !$file_no3 ) {
							$file_no3 = Common::insertFileInfor($this->db, PROC_TYPE_CM, USER_NO, $p_company_no, $f3->getName(), $f3->getExt(), $f3->getSize());
							$fileInforUpdate[] = " FILE_NO3 = '" . $file_no3 . "'";
						} else {
							@unlink($saveDir.DIRECTORY_SEPARATOR."f3_".$p_company_no."_".( $oldFile3Ext?"." .$oldFile3Ext:""));
							$file_no3 = Common::updateFileInfor($this->db, $file_no3, $f3->getName(), $f3->getExt(), $f3->getSize());
						}
						$f3->upload();
					}
					
    				if ( !empty($fileInforUpdate) ) {
    					$this->exec(
    							"UPDATE " .TBL_COMPANY . " SET"
    							. join(",\n", $fileInforUpdate)
    							. " WHERE COMPANY_NO = '" .$p_company_no . "'"
    					);
    				}
    				$this->db->commit();
    			}
    		}
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	
    	$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
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
    		if ( !ADMIN ) throw new Exception("권한이 없습니다."); 
    		
    		$query = array();
    		$query[] = "SELECT";
    		$query[]  = " COMPANY_NO          ,";
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
    		$query[]  = " JP_TRADE_YN         ,";
    		$query[]  = " ETC_TRADE_YN        ,";
    		$query[]  = " INTERNAL_CUSTOMER   ,";
    		$query[]  = " EXTERNAL_CUSTOMER   ,";
    		$query[]  = " FILE_NO1            ,";
    		$query[]  = " FILE_NO2            ,";
    		$query[]  = " FILE_NO3             ";
    		$query[] = " FROM " . TBL_COMPANY;
    		$query[] = " WHERE COMPANY_NO = '" . $p_company_no . "'" ;

    		$this->makeItemXML(join("\n", $query),"item","fi");
    		
			$fInfor = $this->db->get(
			        "SELECT "
			        . "FILE_NO1, "
			        . "FILE_NO2, "
			        . "FILE_NO3  "
			        . " FROM ". TBL_COMPANY 
			        . " WHERE COMPANY_NO = '" . $p_company_no . "'"
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
//     		echo $file1Name;
//     		echo $file2Name;
//     		echo $file3Name;
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
    		$query[] = " WHERE COMPANY_NO = '" . $p_company_no . "'" ;
    		$this->makeItemXML(join("\n", $query),"item1","fi1");
    		
    		$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
	
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->printXML(C_DB_PROCESS_MODE_SELECT);
    }
    
    /**
     * 삭제
     * @param array $argus
     * @return boolean
     */
    public function delete($argus) {

    	//     	$this->testJsCall($argus);
    	$this->startXML();
    	try {
    		if ( !ADMIN ) throw new Exception("권한이 없습니다.");    		
    		$db->setAutoCommit(false);    		
    		if ( !Company::batchDelete($this->db,$argus,1) ) throw new Exception("삭제처리중 에러가 발생하였습니다.");
    		if ( !$this->db->commit() ) throw new Exception("삭제처리중 에러가 발생하였습니다.");
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_DELETE)); // 성공시 출력 메시지.
    	$this->printXML(C_DB_PROCESS_MODE_DELETE);    		
    }

    /**
     * 기업정보 삭제시 일괄 삭제.
     * @param Database $db
     * @param array $argus
     * @param string $gubun [ 1:기업정보 삭제시,2:회원정보 삭제시 ]
	 * @return boolean
     */
    public static function batchDelete($db,$argus,$gubun) {
    	try {
    		if ( !ADMIN ) throw new Exception("권한이 없습니다.");
    		if ( $gubun == 1 ) $db->exec("UPDATE " . TBL_MEMBER            . " SET USER_LEVEL = " . MEMBER_TYPE_STD . " WHERE USER_NO    = '" . $argus[p_user_no   ] . "'");
	    	$db->exec("DELETE FROM " . TBL_COMPANY           . " WHERE COMPANY_NO = '" . $argus[p_company_no] . "'");
	    	$db->exec("DELETE FROM " . TBL_COMPANY_PRODUCT   . " WHERE COMPANY_NO = '" . $argus[p_company_no] . "'");
	    	$db->exec("DELETE FROM " . TBL_BIZ_CONSULT       . " WHERE COMPANY_NO = '" . $argus[p_company_no] . "'");
	    	$db->exec("DELETE FROM " . TBL_INTEREST_ENGINEER . " WHERE USER_NO    = '" . $argus[p_user_no   ] . "'");
	    	$db->exec("DELETE FROM " . TBL_ENGINEER_CONSULT  . " WHERE COMPANY_NO = '" . $argus[p_company_no] . "'");
	    	$db->exec("DELETE FROM " . TBL_TECH_CONSULT      . " WHERE COMPANY_NO = '" . $argus[p_company_no] . "'");
	    	$db->exec("DELETE FROM " . TBL_WORKER            . " WHERE COMPANY_NO = '" . $argus[p_company_no] . "'");
	    	$db->exec("DELETE FROM " . TBL_FILE              . " WHERE COMPANY_NO = '" . $argus[p_company_no] . "'");
	    	Util::unlinkFile(DATA_DIR . DIRECTORY_SEPARATOR . Company::$SAVE_SUB_DIR . DIRECTORY_SEPARATOR . "*_" . $argus[p_company_no] . "_.*",true);
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    		return false;
    	}
    	return true;
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
    		if ( !ADMIN ) throw new Exception("권한이 없습니다.");
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
     * 일본기업회원수정
     * @param array $argus
     */
    function updateJp(array $argus) {
    	//     	var_dump($argus);
    	$user_no = USER_NO;
    	$p_company_no = $argus[p_company_no ];
    	$company_code = $argus[company_code1] . $argus[company_code2] . $argus[company_code3];
    
    	$this->testJsCall($argus);
    
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

    	$tel  = $argus[tel               ];
    	$fax  = $argus[fax               ];
    	
    	$this->startXML(); // xml start node
    
    	try {
    		if ( !ADMIN ) throw new Exception("권한이 없습니다.");
    		// 파일정보
    		$infor = $this->db->get(
    				"SELECT "
    				. "FILE_NO1, "
    				. "FILE_NO2, "
    				. "FILE_NO3  "
    				. " FROM ". TBL_COMPANY
    				. " WHERE COMPANY_NO = '" . $p_company_no . "'"
    		);
    		$file_no1 = $infor->FILE_NO1;
    		$file_no2 = $infor->FILE_NO2;
    		$file_no3 = $infor->FILE_NO3;
    		
    		$oldFileInfor = Common::getFileInfor($this->db,array(FILE_NO1=>$file_no1,FILE_NO2=>$file_no2,FILE_NO3=>$file_no3) ,"FILE_NO,FILE_EXT");
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
    		$query[]  = " BIZ_NAME_JP         = '" . $argus[biz_name_jp       ] . "',";
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
    		$query[]  = " COMPANY_INTRO_JP    = '" . $argus[company_intro_jp  ] . "',";
    		$query[]  = " JP_TRADE_YN         = '" . $argus[jp_trade_yn       ] . "',";
    		$query[]  = " ETC_TRADE_YN        = '" . $argus[etc_trade_yn      ] . "',";
    		$query[]  = " INTERNAL_CUSTOMER   = '" . $argus[internal_customer ] . "',";
    		$query[]  = " INTERNAL_CUSTOMER_JP= '" . $argus[internal_customer_jp ] . "',";
    		$query[]  = " EXTERNAL_CUSTOMER   = '" . $argus[external_customer ] . "',";
    		$query[]  = " EXTERNAL_CUSTOMER_JP= '" . $argus[external_customer_jp ] . "',";
    
    		if ( $argus[file1_delete] == 'Y' ) $query[]  = " FILE_NO1   = NULL,";
    		if ( $argus[file2_delete] == 'Y' ) $query[]  = " FILE_NO2   = NULL,";
    		if ( $argus[file3_delete] == 'Y' ) $query[]  = " FILE_NO3   = NULL,";
    
    		$query[]  = " MOD_DATE            = now() ";
    		$query[]  = " WHERE COMPANY_NO = '" . $p_company_no . "'";
    
//     			echo join("\n", $query);
    		$this->setQuery(join("\n", $query));
    		$this->db->setAutoCommit(false);
    		if ( $this->exec($this->getQuery()) ) {
    			unset($query);
    			$query_sub = array();
    			for ( $k = 0;$k<sizeof($argus[product]);$k++){
    				$subdata  = "("
    				. " '" . $p_company_no . "',"
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
    		
    			/* */
    			$saveDir = DATA_DIR . DIRECTORY_SEPARATOR . Company::$SAVE_SUB_DIR;
    			$uploader  = new FileUpload(true,$saveDir); // 업로드 인스턴스 생성
    		
    			$f1 = $uploader->getItem('file1')->setSaveName("f1_".$p_company_no."_");
    			$f2 = $uploader->getItem('file2')->setSaveName("f2_".$p_company_no."_");
    			$f3 = $uploader->getItem('file3')->setSaveName("f3_".$p_company_no."_");
    		
    			//                                      echo $f1->getErrorCode() . ' / '   . $f1->getError() . '<BR>';
    			//                  echo $f2->getErrorCode() . '<BR>';
    			//                  echo $f3->getErrorCode() . '<BR>';
    			if ( $argus[file1_delete] == 'Y' ) {
    				@unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_company_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
    				Common::deleteFileInfor($this->db, $file_no1);
    				$file_no1 = 0;
    			}
    			if ( $file_no2 && $argus[file2_delete] == 'Y' ) {
    				@unlink($saveDir.DIRECTORY_SEPARATOR."f2_".$p_company_no."_".( $oldFile2Ext?"." .$oldFile2Ext:"") );
    				Common::deleteFileInfor($this->db, $file_no2);
    				$file_no2 = 0;
    			}
    			if ( $file_no3 && $argus[file3_delete] == 'Y' ) {
    				@unlink($saveDir.DIRECTORY_SEPARATOR."f3_".$p_company_no."_".( $oldFile3Ext?"." .$oldFile3Ext:"") );
    				Common::deleteFileInfor($this->db, $file_no3);
    				$file_no3 = 0;
    			}
    		
    			/* @var Company Table file no 갱신 */
    			$fileInforUpdate = array();
    		
    			if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {
    				if ( !$file_no1 ) {
    					$file_no1 = Common::insertFileInfor($this->db, PROC_TYPE_CM, $user_no, $p_company_no, $f1->getName(), $f1->getExt(), $f1->getSize());
    					$fileInforUpdate[] = " FILE_NO1 = '" . $file_no1 . "'";
    				} else {
    					@unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_company_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
    					$file_no1 = Common::updateFileInfor($this->db, $file_no1, $f1->getName(), $f1->getExt(), $f1->getSize());
    				}
    				$f1->upload();
    			}
    		
    			if ( $f2->getErrorCode() == UPLOAD_ERR_OK ) {
    				if ( !$file_no2 ) {
    					$file_no2 = Common::insertFileInfor($this->db, PROC_TYPE_CM, $user_no, $p_company_no, $f2->getName(), $f2->getExt(), $f2->getSize());
    					$fileInforUpdate[] = " FILE_NO2 = '" . $file_no2 . "'";
    				} else {
    					@unlink($saveDir.DIRECTORY_SEPARATOR."f2_".$p_company_no."_".( $oldFile2Ext?"." .$oldFile2Ext:""));
    					$file_no2 = Common::updateFileInfor($this->db, $file_no2, $f2->getName(), $f2->getExt(), $f2->getSize());
    				}
    				$f2->upload();
    			}
    		
    			if ( $f3->getErrorCode() == UPLOAD_ERR_OK ) {
    				if ( !$file_no3 ) {
    					$file_no3 = Common::insertFileInfor($this->db, PROC_TYPE_CM, $user_no, $p_company_no, $f3->getName(), $f3->getExt(), $f3->getSize());
    					$fileInforUpdate[] = " FILE_NO3 = '" . $file_no3 . "'";
    				} else {
    					@unlink($saveDir.DIRECTORY_SEPARATOR."f3_".$p_company_no."_".( $oldFile3Ext?"." .$oldFile3Ext:""));
    					$file_no3 = Common::updateFileInfor($this->db, $file_no3, $f3->getName(), $f3->getExt(), $f3->getSize());
    				}
    				$f3->upload();
    			}
    		
    			if ( !empty($fileInforUpdate) ) {
    				$this->exec(
    						"UPDATE " .TBL_COMPANY . " SET"
    						. join(",\n", $fileInforUpdate)
    						. " WHERE COMPANY_NO = '" .$p_company_no . "'"
    				);
    			}
    		
// 상담정보
    			$infor = $this->db->get(
    					"SELECT "
    					. "CONSULT_NO, "
    					. "WORKER_NO, "
    					. "FILE_NO1, "
    					. "FILE_NO2, "
    					. "FILE_NO3  "
    					. " FROM ". TBL_BIZ_CONSULT
    					. " WHERE COMPANY_NO = '" . $p_company_no . "'"
    					. " AND   PROC_TYPE = '" . PROC_TYPE_BC_JP . "'"
    			);
    			$file_no4 = $infor->FILE_NO1;
    			$file_no5 = $infor->FILE_NO2;
    			$file_no6 = $infor->FILE_NO3;
    			
    			// 키값 얻기.
    			$p_consult_no= $infor->CONSULT_NO;    			
    			$p_worker_no= $infor->WORKER_NO;
    			$argus[p_worker_no] = $p_worker_no;
    		
    			$oldFileInfor = Common::getFileInfor($this->db,array(FILE_NO1=>$file_no4,FILE_NO2=>$file_no5,FILE_NO3=>$file_no6) ,"FILE_NO,FILE_EXT");
    			$oldFile4Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;
    			$oldFile5Ext = $oldFileInfor['FILE_NO2']->FILE_EXT;
    			$oldFile6Ext = $oldFileInfor['FILE_NO3']->FILE_EXT;
    		
    			$query = array();
    			$query [] = "UPDATE " . TBL_BIZ_CONSULT;
    			$query [] = " SET";
    			$query [] = " CONSULT_ITEM = '" . $argus[consult_item] . "',";
    			$query [] = " CONSULT_ITEM_JP = '" . $argus[consult_item_jp] . "',";
    			$query [] = " HOPE_BIZ_TYPE = '" . $argus[hope_biz_type] . "',";
    			$query [] = " HOPE_BIZ = '" . $argus[hope_biz] . "',";
    			$query [] = " HOPE_BIZ_JP = '" . $argus[hope_biz_jp] . "',";
    			$query [] = " HOPE_TRADE_TYPE = '" . $argus[hope_trade_type] . "',";
    			$query [] = " HOPE_TRADE_TYPE_JP = '" . $argus[hope_trade_type_jp] . "',";
    			$query [] = " OPEN_LIMIT = '" . $argus[open_limit] . "',";
    			$query [] = " ETC_QUESTION = '" . $argus[etc_question] . "',";
    			$query [] = " ETC_QUESTION_JP = '" . $argus[etc_question_jp] . "',";
    			if ( $argus[file1_delete] == 'Y' ) $query[]  = " FILE_NO1   = NULL,";
    			if ( $argus[file2_delete] == 'Y' ) $query[]  = " FILE_NO2   = NULL,";
    			if ( $argus[file3_delete] == 'Y' ) $query[]  = " FILE_NO3   = NULL,";
    			//             $query [] = " WORKER_NO = '" . $argus[worker_no] . "',";
    			$query [] = " ACTION_PLAN = '" . $argus[action_plan] . "',";
    			$query [] = " OPEN_YN     = '" . $argus[open_yn] . "',";
    			$query [] = " STATE = '" . $argus[state] . "',";
    			$query [] = " MOD_DATE = now()";
    			$query [] = " WHERE ";
    			$query [] = " CONSULT_NO = '" . $p_consult_no . "'";
    			$this->setQuery(join(PHP_EOL, $query));
    			//            out.print($this->getQuery());
    			if ( $this->db->exec($this->getQuery()) ) {
    				//                out.print($this->db->getAffectedRows());
    				// 담당자정보 수정.
    				//                  var_dump($argus);
    				if ( !Worker::externalUpdate($this->db, $argus) ) throw new Exception($this->db->getErrMsg());
    		
    				/* */
    				$saveDir = DATA_DIR . DIRECTORY_SEPARATOR . BizConsult::$SAVE_SUB_DIR;
    				$uploader  = new FileUpload(true,$saveDir); // 업로드 인스턴스 생성
    		
    				$f4 = $uploader->getItem('file4')->setSaveName("f4_".$p_consult_no."_");
    				$f5 = $uploader->getItem('file5')->setSaveName("f5_".$p_consult_no."_");
    				$f6 = $uploader->getItem('file6')->setSaveName("f6_".$p_consult_no."_");
    				//                                      echo $f4->getErrorCode() . ' / '   . $f4->getError() . '<BR>';
    				//                  echo $f5->getErrorCode() . '<BR>';
    				//                  echo $f6->getErrorCode() . '<BR>';
    				if ( $argus[file4_delete] == 'Y' ) {
    					@unlink($saveDir.DIRECTORY_SEPARATOR."f4_".$p_consult_no."_".( $oldFile4Ext?"." .$oldFile4Ext:"") );
    					Common::deleteFileInfor($this->db, $file_no4);
    					$file_no4 = 0;
    				}
    				if ( $file_no5 && $argus[file5_delete] == 'Y' ) {
    					@unlink($saveDir.DIRECTORY_SEPARATOR."f5_".$p_consult_no."_".( $oldFile5Ext?"." .$oldFile5Ext:"") );
    					Common::deleteFileInfor($this->db, $file_no5);
    					$file_no5 = 0;
    				}
    				if ( $file_no6 && $argus[file6_delete] == 'Y' ) {
    					@unlink($saveDir.DIRECTORY_SEPARATOR."f6_".$p_consult_no."_".( $oldFile6Ext?"." .$oldFile6Ext:"") );
    					Common::deleteFileInfor($this->db, $file_no6);
    					$file_no6 = 0;
    				}
    		
    				/* @var BizConsult Table file no 갱신 */
    				$fileInforUpdate = array();
    		
    				if ( $f4->getErrorCode() == UPLOAD_ERR_OK ) {
    					if ( !$file_no4 ) {
    						$file_no4 = Common::insertFileInfor($this->db, PROC_TYPE_BC_JP, $user_no, $p_company_no, $f4->getName(), $f4->getExt(), $f4->getSize());
    						$fileInforUpdate[] = " FILE_NO1 = '" . $file_no4 . "'";
    					} else {
    						@unlink($saveDir.DIRECTORY_SEPARATOR."f4_".$p_consult_no."_".( $oldFile4Ext?"." .$oldFile4Ext:"") );
    						$file_no4 = Common::updateFileInfor($this->db, $file_no4, $f4->getName(), $f4->getExt(), $f4->getSize());
    					}
    					$f4->upload();
    				}
    		
    				if ( $f5->getErrorCode() == UPLOAD_ERR_OK ) {
    					if ( !$file_no5 ) {
    						$file_no5 = Common::insertFileInfor($this->db, PROC_TYPE_BC_JP, $user_no, $p_company_no, $f5->getName(), $f5->getExt(), $f5->getSize());
    						$fileInforUpdate[] = " FILE_NO2 = '" . $file_no5 . "'";
    					} else {
    						@unlink($saveDir.DIRECTORY_SEPARATOR."f5_".$p_consult_no."_".( $oldFile5Ext?"." .$oldFile5Ext:""));
    						$file_no5 = Common::updateFileInfor($this->db, $file_no5, $f5->getName(), $f5->getExt(), $f5->getSize());
    					}
    					$f5->upload();
    				}
    		
    				if ( $f6->getErrorCode() == UPLOAD_ERR_OK ) {
    					if ( !$file_no6 ) {
    						$file_no6 = Common::insertFileInfor($this->db, PROC_TYPE_BC_JP, $user_no, $p_company_no, $f6->getName(), $f6->getExt(), $f6->getSize());
    						$fileInforUpdate[] = " FILE_NO3 = '" . $file_no6 . "'";
    					} else {
    						@unlink($saveDir.DIRECTORY_SEPARATOR."f6_".$p_consult_no."_".( $oldFile6Ext?"." .$oldFile6Ext:""));
    						$file_no6 = Common::updateFileInfor($this->db, $file_no6, $f6->getName(), $f6->getExt(), $f6->getSize());
    					}
    					$f6->upload();
    				}
    		
    				if ( !empty($fileInforUpdate) ) {
    					$this->exec(
    							"UPDATE " .TBL_BIZ_CONSULT . " SET"
    							. join(",\n", $fileInforUpdate)
    							. " WHERE CONSULT_NO = '" .$p_consult_no . "'"
    					);
    				}
    		
    			} else {
    				throw new Exception("상담정보 수정처리중 에러가 발생하였습니다.");
    			}
    			if ( !$this->db->commit() ) throw new Exception("입력처리중 에러가 발생하였습니다.");
    		} else {
    			throw new Exception("기업정보 수정처리중 에러가 발생하였습니다.");
    		}
    		
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    
    	$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
    	$this->printXML(C_DB_PROCESS_MODE_UPDATE);
    }    

    /**
     * 삭제
     * @param array $argus
     * @return boolean
     */
    public function deleteJp($argus) {
    	$p_company_no = $argus[p_company_no ];
    	//     	$this->testJsCall($argus);
    	$this->startXML();
    	try {
    		if ( !ADMIN ) throw new Exception("권한이 없습니다.");    		
    		$this->db->setAutoCommit(false);
    		$infor = $this->db->get(
    				"SELECT "
    				. "CONSULT_NO, "
    				. "WORKER_NO, "
    				. "FILE_NO1, "
    				. "FILE_NO2, "
    				. "FILE_NO3  "
    				. " FROM ". TBL_BIZ_CONSULT
    				. " WHERE COMPANY_NO = '" . $p_company_no . "'"
    				. " AND   PROC_TYPE = '" . PROC_TYPE_BC_JP . "'"
    		);
    		$file_no4 = $infor->FILE_NO1;
    		$file_no5 = $infor->FILE_NO2;
    		$file_no6 = $infor->FILE_NO3;
    		
    		// 키값 얻기.
    		$p_consult_no = $infor->CONSULT_NO;
    		$p_worker_no  = $infor->WORKER_NO;
    		
    		$this->db->exec("DELETE FROM " . TBL_COMPANY           . " WHERE COMPANY_NO = '" . $p_company_no . "'");
    		$this->db->exec("DELETE FROM " . TBL_COMPANY_PRODUCT   . " WHERE COMPANY_NO = '" . $p_company_no . "'");
    		// 담당자정보 삭제.
    		if ( !Worker::externalDelete($this->db, array(p_worker_no=>$p_worker_no)) ) throw new Exception($this->db->getErrMsg());
    		// 상담정보 삭제.
    		if ( !BizConsult::externalDelete($this->db, array(p_consult_no=>$p_consult_no)) ) throw new Exception($this->db->getErrMsg());
    		
    		Common::deleteFileInfor($this->db, $file_no4);
    		Common::deleteFileInfor($this->db, $file_no5);
    		Common::deleteFileInfor($this->db, $file_no6);
    		
    		if ( !$this->db->commit() ) throw new Exception("삭제처리중 에러가 발생하였습니다.");
    		
    		Util::unlinkFile(DATA_DIR . DIRECTORY_SEPARATOR . Company::$SAVE_SUB_DIR . DIRECTORY_SEPARATOR . "f*_" . $p_company_no . "_.*",true);
    		Util::unlinkFile(DATA_DIR . DIRECTORY_SEPARATOR . BizConsult::$SAVE_SUB_DIR . DIRECTORY_SEPARATOR . "f*_" . $p_consult_no . "_.*",true);
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_DELETE)); // 성공시 출력 메시지.
    	$this->printXML(C_DB_PROCESS_MODE_DELETE);
    }
        
    /**
     * 일본 기업정보 조회
     * @param array $argus
     */
    function getJp(array $argus) {
    	$p_company_no = $argus[p_company_no ];
    	$this->testJsCall($argus);
    	$this->startXML();
    	try {
    		if ( !ADMIN ) throw new Exception("권한이 없습니다.");
    
    		$query = array();
    		$query[] = "SELECT";
    		$query[]  = " COMPANY_NO          ,";
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
    		$query[]  = " FILE_NO1            ,";
    		$query[]  = " FILE_NO2            ,";
    		$query[]  = " FILE_NO3             ";
    		$query[] = " FROM " . TBL_COMPANY;
    		$query[] = " WHERE COMPANY_NO = '" . $p_company_no . "'" ;
    		$company = $this->db->get(join("\n", $query),"array");
    		$this->oneRowToXML($company,"item","fi");
    
    		$file_no1 = $company[FILE_NO1];
    		$file_no2 = $company[FILE_NO2];
    		$file_no3 = $company[FILE_NO3];
    
    		// 			var_dump($fInfor);
    		// 			echo '$file_no1 : ' . $file_no1 ;
    		// 			echo '$oldFileInfor ' . $oldFileInfor['FILE_NO1']->FILE_EXT;
    		$fInfor = array ( FILE_NO1=>$file_no1,FILE_NO2=>$file_no2,FILE_NO3=>$file_no3 );
    		
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
    		//     		echo $file1Name;
    		//     		echo $file2Name;
    		//     		echo $file3Name;
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
    		$query[] = " WHERE COMPANY_NO = '" . $p_company_no . "'" ;
    		$this->makeItemXML(join("\n", $query),"item1","fi1");
    
    		$query = array();
    		$query [] = "SELECT ";
    		$query [] = " CONSULT_NO        ,";
    		$query [] = " REG_CODE          BIZ_REG_CODE,";
    		$query [] = " PROC_TYPE         ,";
    		$query [] = " COMPANY_NO        ,";
    		$query [] = " CONSULT_COMPANY_NO,";
    		$query [] = " STATE             ,";
    		$query [] = " CONSULT_ITEM      ,";
    		$query [] = " CONSULT_ITEM_JP   ,";
    		$query [] = " HOPE_BIZ_TYPE     ,";
    		$query [] = " HOPE_BIZ          ,";
    		$query [] = " HOPE_BIZ_JP       ,";
    		$query [] = " HOPE_TRADE_TYPE   ,";
    		$query [] = " HOPE_TRADE_TYPE_JP,";
    		$query [] = " OPEN_LIMIT        ,";
    		$query [] = " ETC_QUESTION      ,";
    		$query [] = " ETC_QUESTION_JP   ,";
    		$query [] = " FILE_NO1          ,";
    		$query [] = " FILE_NO2          ,";
    		$query [] = " FILE_NO3          ,";
    		$query [] = " WORKER_NO         ,";
    		$query [] = " ACTION_PLAN       ,";
    		$query [] = " OPEN_YN           ,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE";
    		$query [] = " FROM " . TBL_BIZ_CONSULT;
    		$query [] = " WHERE COMPANY_NO = '" . $p_company_no . "'";
    		$this->setQuery(join(PHP_EOL, $query));
    		
    		$sql = join(PHP_EOL, $query);
    		$colsult = $this->db->get($sql,"array");
    		//             $colsult[ETC_QUESTION] = $colsult[WORKER_NO] . " / " . $colsult[ETC_QUESTION];
    		
    		$file_no4 = $colsult[FILE_NO1];
    		$file_no5 = $colsult[FILE_NO2];
    		$file_no6 = $colsult[FILE_NO3];
    		$fInfor = array ( FILE_NO1=>$file_no4,FILE_NO2=>$file_no5,FILE_NO3=>$file_no6 );
    		
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
    		
    		$this->appendNode('filename4', $file1Name);
    		$this->appendNode('filename5', $file2Name);
    		$this->appendNode('filename6', $file3Name);
    		
    		$this->appendNode('fileext4', $file1Ext);
    		$this->appendNode('fileext5', $file2Ext);
    		$this->appendNode('fileext6', $file3Ext);
    		
    		$this->appendNode('fileno4', $file_no4);
    		$this->appendNode('fileno5', $file_no5);
    		$this->appendNode('fileno6', $file_no6);
    		
    		$worker = Worker::externalGet($this->db, array(p_worker_no=>$colsult[WORKER_NO]));
    		$this->oneRowToXML(array_merge($worker,$colsult),"item2","fi2");
    		
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