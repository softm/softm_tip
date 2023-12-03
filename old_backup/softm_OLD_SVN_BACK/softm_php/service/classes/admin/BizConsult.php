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

/**
 * @author softm
 * 비지니스 상담정보 & 매칭정보 / BizConsult.php
 */
class BizConsult extends BaseDataBase
{
	/** @var upload file directory */ public static $SAVE_SUB_DIR = "biz";
	
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_BIZ_CONSULT);
    		$tbl1->newColumn('CONSULT_NO','번호',1)->setWidth(50);
    		$tbl1->newColumn('CONSULT_ITEM','제목',2)->setCssText("text-align:left;padding-left:10px");
    		$tbl1->newColumn('COMPANY_NM_KR','기업명',3)->setWidth(100);
    		$tbl1->newColumn('USER_NAME','등록자',4)->setWidth(100);
    		$tbl1->newColumn('REG_DATE','등록일',5)->setWidth(100);
    		$tbl1->newColumn('STATE','처리상황',6)->setType(Column::LISTBOX_TYPE)->setWidth(80);
    		$tbl1->newColumn('COMPANY_NO','기업번호',7)->setWidth(0)->setHide();
    		$tbl1->newColumn('CONSULT_COMPANY_NO','상담기업번호',8)->setWidth(0)->setHide();
    		
        } else if ( METHOD == "select2" ) {
        	
        	$query [] = " a.CONSULT_ITEM       CONSULT_ITEM      ,"; // 비즈니스안건
        	$query [] = " b.COMPANY_NM_KR      KR_COMPANY_NM_KR  ,"; // 기업명 일본기업
        	$query [] = " c.COMPANY_NM_KR      JP_COMPANY_NM_KR  ,"; // 기업명 한국기업
        	$query [] = " c.USER_NAME          USER_NAME         ,"; // 등록자
        	$query [] = " DATE_FORMAT(a.REG_DATE,'%Y-%m-%d') REG_DATE,"; // 등록일
        	$query [] = " a.STATE        STATE                    "; // 처리상황
        	        	
        	$tbl1 = $this->newTable(TBL_BIZ_CONSULT);
        	$tbl1->newColumn('CONSULT_NO','번호',1)->setWidth(50);
        	$tbl1->newColumn('CONSULT_ITEM','비즈니스안건',2)->setCssText("text-align:left;padding-left:10px");
        	$tbl1->newColumn('KR_COMPANY_NM_KR','한국기업명',3)->setWidth(150);
        	$tbl1->newColumn('JP_COMPANY_NM_KR','일본기업명',3)->setWidth(150);
        	$tbl1->newColumn('STATE','처리상황',6)->setType(Column::LISTBOX_TYPE)->setWidth(80);
        	$tbl1->newColumn('COMPANY_NO','기업번호',7)->setWidth(0)->setHide();
        	$tbl1->newColumn('CONSULT_COMPANY_NO','상담기업번호',8)->setWidth(0)->setHide();
        }
    }

    public function __destruct() {
        parent::__destruct();
        $this->end();
    }
    
    /**
     * test
     * @param array $argus
     */
    function test(array $argus) {
//       $p_user_id   = $argus[user_email  ];
    
       $this->testJsCall($argus);
       $this->startXML();
       try {

       } catch (Exception $e) {
           $this->addErrMessage($e->getMessage());
       }
       $this->printXML(C_DB_PROCESS_MODE_PROC);
    }
    
    /**
     * 조회-그리드
     * 비지니스 상담.
     * @param array $argus
     * @return DOMDocument
     */
    public function select2($argus) {
    	global $page_tab;
    	//     $this->testJsCall($argus);
    	//    	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
    	$this->getCodeData(); // code xml 생성
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
    
    		// 조회 조건
    		$s_biz_field     = $argus[s_biz_field      ];
    		$s_biz_classified= $argus[s_biz_classified ];
    		$s_state         = $argus[s_state          ];
    		$s_keyword       = $argus[s_keyword        ];
    
    		$where .= " a.PROC_TYPE = " . PROC_TYPE_BM;
    		$where .= $s_biz_field     ?" AND  b.BIZ_FIELD      = '" . $s_biz_field      . "'":"";
    		$where .= $s_biz_classified?" AND  b.BIZ_CLASSIFIED = '" . $s_biz_classified . "'":"";
    		$where .= $s_state         ?" AND  a.STATE          = '" . $s_state          . "'":"";
    		$where .= $s_keyword       ?" AND  a.CONSULT_ITEM LIKE '" . $s_keyword . "%'":"";
    		
    		if ( $make_where ) $where .= " AND ".$make_where;
    		
    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM "
    				. TBL_BIZ_CONSULT . " a "
 					. " LEFT OUTER JOIN " . TBL_COMPANY . " b ON a.COMPANY_NO = b.COMPANY_NO "    				
    				. ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());
    
    		$query = array();
    
    		$query [] = " SELECT ";
    		$query [] = " a.CONSULT_NO         CONSULT_NO        ,"; // 번호
    		$query [] = " a.COMPANY_NO         COMPANY_NO        ,";
    		$query [] = " a.CONSULT_COMPANY_NO CONSULT_COMPANY_NO,";
    		$query [] = " a.CONSULT_ITEM       CONSULT_ITEM      ,"; // 비즈니스안건
    		$query [] = " b.COMPANY_NM_KR      JP_COMPANY_NM_KR  ,"; // 기업명 일본기업
    		$query [] = " c.COMPANY_NM_KR      KR_COMPANY_NM_KR  ,"; // 기업명 한국기업
    		$query [] = " DATE_FORMAT(a.REG_DATE,'%Y-%m-%d') REG_DATE,"; // 등록일
    		$query [] = " a.STATE        STATE                    "; // 처리상황
    		$query [] = " FROM " . TBL_BIZ_CONSULT . " a";
    		$query [] = " LEFT OUTER JOIN " . TBL_COMPANY . " b ON a.COMPANY_NO = b.COMPANY_NO ";
    		$query [] = " LEFT OUTER JOIN " . TBL_COMPANY . " c ON a.CONSULT_COMPANY_NO = c.COMPANY_NO    ";
    		
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
     * 비지니스 상담.
     * @param array $argus
     * @return DOMDocument
     */
    public function select($argus) {
    	global $page_tab;
    	//     $this->testJsCall($argus);
    	//    	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
    	$this->getCodeData(); // code xml 생성
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
    
    		// 조회 조건
    		$s_biz_field     = $argus[s_biz_field      ];
    		$s_biz_classified= $argus[s_biz_classified ];
    		$s_state         = $argus[s_state          ];
    		$s_keyword       = $argus[s_keyword        ];
    
    		$where .= " a.PROC_TYPE = " . PROC_TYPE_BC;
    		$where .= $s_biz_field     ?" AND  b.BIZ_FIELD      = '" . $s_biz_field      . "'":"";
    		$where .= $s_biz_classified?" AND  b.BIZ_CLASSIFIED = '" . $s_biz_classified . "'":"";
    		$where .= $s_state         ?" AND  a.STATE          = '" . $s_state          . "'":"";
    		$where .= $s_keyword       ?" AND  a.CONSULT_ITEM LIKE '" . $s_keyword . "%'":"";
    		
    		if ( $make_where ) $where .= " AND ".$make_where;
    		
    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM "
    				. TBL_BIZ_CONSULT . " a "
 					. " LEFT OUTER JOIN " . TBL_COMPANY . " b ON a.COMPANY_NO = b.COMPANY_NO "    				
    				. ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());
    
    		$query = array();
    
    		$query [] = " SELECT ";
    		$query [] = " a.CONSULT_NO         CONSULT_NO        ,"; // 번호
    		$query [] = " a.COMPANY_NO         COMPANY_NO        ,";
    		$query [] = " a.CONSULT_COMPANY_NO CONSULT_COMPANY_NO,";
    		$query [] = " a.CONSULT_ITEM       CONSULT_ITEM      ,"; // 비즈니스안건
    		$query [] = " b.COMPANY_NM_KR      COMPANY_NM_KR     ,"; // 기업명
    		$query [] = " c.USER_NAME          USER_NAME         ,"; // 등록자
    		$query [] = " DATE_FORMAT(a.REG_DATE,'%Y-%m-%d') REG_DATE,"; // 등록일
    		$query [] = " a.STATE        STATE                    "; // 처리상황
    		$query [] = " FROM " . TBL_BIZ_CONSULT . " a";
    		$query [] = " LEFT OUTER JOIN " . TBL_COMPANY . " b ON a.COMPANY_NO = b.COMPANY_NO ";
    		$query [] = " LEFT OUTER JOIN " . TBL_MEMBER  . " c ON b.USER_NO    = c.USER_NO    ";
    		
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
     * 조회
     * @param array $argus
     * @return DOMDocument
     */
    public function get($argus) {
        //$p_user_id   = $argus[user_email  ];
        $p_consult_no = $argus[p_consult_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !ADMIN ) throw new Exception("권한이 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " a.CONSULT_NO                              CONSULT_NO          ,";
    		$query [] = " a.REG_CODE                                REG_CODE            ,";
    		$query [] = " a.PROC_TYPE                               PROC_TYPE           ,";
    		$query [] = " a.COMPANY_NO                              P_COMPANY_NO        ,";
    		$query [] = " a.CONSULT_COMPANY_NO                      CONSULT_COMPANY_NO  ,";
    		$query [] = " a.STATE                                   STATE               ,";
    		$query [] = " a.CONSULT_ITEM                            CONSULT_ITEM        ,";
    		$query [] = " a.CONSULT_ITEM_JP                         CONSULT_ITEM_JP     ,";
    		$query [] = " a.HOPE_BIZ_TYPE                           HOPE_BIZ_TYPE       ,";
    		$query [] = " a.HOPE_BIZ                                HOPE_BIZ            ,";
    		$query [] = " a.HOPE_BIZ_JP                             HOPE_BIZ_JP         ,";
    		$query [] = " a.HOPE_TRADE_TYPE                         HOPE_TRADE_TYPE     ,";
    		$query [] = " a.HOPE_TRADE_TYPE_JP                      HOPE_TRADE_TYPE_JP  ,";
    		$query [] = " a.OPEN_LIMIT                              OPEN_LIMIT          ,";
    		$query [] = " a.ETC_QUESTION                            ETC_QUESTION        ,";
    		$query [] = " a.ETC_QUESTION_JP                         ETC_QUESTION_JP     ,";
    		$query [] = " a.FILE_NO1                                FILE_NO1            ,";
    		$query [] = " a.FILE_NO2                                FILE_NO2            ,";
    		$query [] = " a.FILE_NO3                                FILE_NO3            ,";
    		$query [] = " a.WORKER_NO                               WORKER_NO           ,";
    		$query [] = " a.ACTION_PLAN                             ACTION_PLAN         ,";
    		$query [] = " a.OPEN_YN                                 OPEN_YN             ,";
    		$query [] = " DATE_FORMAT(a.REG_DATE,'%Y-%m-%d %H:%i')  REG_DATE            ,";
    		$query [] = " DATE_FORMAT(a.MOD_DATE,'%Y-%m-%d %H:%i')  MOD_DATE            ,";
    		$query [] = " b.USER_NO                                 P_USER_NO           ,";    		
    		$query [] = " b.REG_CODE                                COMPANY_REG_CODE    ,";
    		$query [] = " b.COMPANY_NM_KR                           COMPANY_NM_KR       ,";
    		$query [] = " b.COMPANY_NM_JP                           COMPANY_NM_JP       ,";
    		$query [] = " b.TEL                                     COMPANY_TEL         ,";
    		$query [] = " b.ADDR_KR                                 COMPANY_ADDR_KR     ,";
    		$query [] = " b.ADDR_JP                                 COMPANY_ADDR_JP     ";
            $query [] = " FROM " . TBL_BIZ_CONSULT . " a";
            $query [] = " LEFT JOIN " . TBL_COMPANY . " b ON a.COMPANY_NO = b.COMPANY_NO ";
            $query [] = " WHERE ";
            $query [] = " a.CONSULT_NO = '" . $p_consult_no . "'";
            $this->setQuery(join(PHP_EOL, $query));
            
            $sql = join(PHP_EOL, $query);
            $colsult = $this->db->get($sql,"array");
//             $colsult[ETC_QUESTION] = $colsult[WORKER_NO] . " / " . $colsult[ETC_QUESTION];

            $file_no1 = $colsult[FILE_NO1];
            $file_no2 = $colsult[FILE_NO2];
            $file_no3 = $colsult[FILE_NO3];
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
            
            $this->appendNode('filename1', $file1Name);
            $this->appendNode('filename2', $file2Name);
            $this->appendNode('filename3', $file3Name);
            
            $this->appendNode('fileext1', $file1Ext);
            $this->appendNode('fileext2', $file2Ext);
            $this->appendNode('fileext3', $file3Ext);
            
            $this->appendNode('fileno1', $file_no1);
            $this->appendNode('fileno2', $file_no2);
            $this->appendNode('fileno3', $file_no3);
            
			// 담당자 정보조회
    		$worker = Worker::externalGet($this->db, array(p_worker_no=>$colsult[WORKER_NO]));
    		$this->oneRowToXML(array_merge($worker,$colsult),"item","fi");
    		    		
            $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
        } catch (Exception $e) {
            $this->addErrMessage($e->getMessage());
        }
        $this->printXML(C_DB_PROCESS_MODE_SELECT);
    }

    /**
     * 수정
     * @param array $argus
     * @return boolean
     */
    public function update($argus) {
        $p_consult_no = $argus[p_consult_no];
        $p_company_no = $argus[p_company_no];
        $p_user_no    = $argus[p_user_no   ];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !ADMIN ) throw new Exception("권한이 없습니다.");
            // 상담정보
            $infor = $this->db->get(
            		"SELECT "
            		. "WORKER_NO, "
            		. "PROC_TYPE, "
            		. "FILE_NO1, "
            		. "FILE_NO2, "
            		. "FILE_NO3  "
            		. " FROM ". TBL_BIZ_CONSULT
            		. " WHERE CONSULT_NO = '" . $p_consult_no . "'"
            );
            $file_no1 = $infor->FILE_NO1;
            $file_no2 = $infor->FILE_NO2;
            $file_no3 = $infor->FILE_NO3;
            $p_worker_no= $infor->WORKER_NO;
            $proc_type = $infor->PROC_TYPE;
            
            $argus[p_worker_no] = $p_worker_no;
            
            $oldFileInfor = Common::getFileInfor($this->db,array(FILE_NO1=>$file_no1,FILE_NO2=>$file_no2,FILE_NO3=>$file_no3) ,"FILE_NO,FILE_EXT");
            $oldFile1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;
            $oldFile2Ext = $oldFileInfor['FILE_NO2']->FILE_EXT;
            $oldFile3Ext = $oldFileInfor['FILE_NO3']->FILE_EXT;
                        
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
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
//                out.print($this->db->getAffectedRows());
                if ( $this->db->commit() ) {
                	$this->db->setAutoCommit(false);
                	// 담당자정보 수정.
//                 	var_dump($argus);
                	if ( !Worker::externalUpdate($this->db, $argus) ) throw new Exception($this->db->getErrMsg());
                	                	
                	/* */
                	$saveDir = DATA_DIR . DIRECTORY_SEPARATOR . BizConsult::$SAVE_SUB_DIR;
                	$uploader  = new FileUpload(true,$saveDir); // 업로드 인스턴스 생성
                	
                	$f1 = $uploader->getItem('file1')->setSaveName("f1_".$p_consult_no."_");
                	$f2 = $uploader->getItem('file2')->setSaveName("f2_".$p_consult_no."_");
                	$f3 = $uploader->getItem('file3')->setSaveName("f3_".$p_consult_no."_");
                	//     									echo $f1->getErrorCode() . ' / '   . $f1->getError() . '<BR>';
                	// 					echo $f2->getErrorCode() . '<BR>';
                	// 					echo $f3->getErrorCode() . '<BR>';
                	if ( $argus[file1_delete] == 'Y' ) {
                		@unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_consult_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
                		Common::deleteFileInfor($this->db, $file_no1);
                		$file_no1 = 0;
                	}
                	if ( $file_no2 && $argus[file2_delete] == 'Y' ) {
                		@unlink($saveDir.DIRECTORY_SEPARATOR."f2_".$p_consult_no."_".( $oldFile2Ext?"." .$oldFile2Ext:"") );
                		Common::deleteFileInfor($this->db, $file_no2);
                		$file_no2 = 0;
                	}
                	if ( $file_no3 && $argus[file3_delete] == 'Y' ) {
                		@unlink($saveDir.DIRECTORY_SEPARATOR."f3_".$p_consult_no."_".( $oldFile3Ext?"." .$oldFile3Ext:"") );
                		Common::deleteFileInfor($this->db, $file_no3);
                		$file_no3 = 0;
                	}
                	
                	/* @var BizConsult Table file no 갱신 */
                	$fileInforUpdate = array();
                	
                	if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {
                		if ( !$file_no1 ) {
                			$file_no1 = Common::insertFileInfor($this->db, $proc_type, $p_user_no, $p_company_no, $f1->getName(), $f1->getExt(), $f1->getSize());
                			$fileInforUpdate[] = " FILE_NO1 = '" . $file_no1 . "'";
                		} else {
                			@unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_consult_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
                			$file_no1 = Common::updateFileInfor($this->db, $file_no1, $f1->getName(), $f1->getExt(), $f1->getSize());
                		}
                		$f1->upload();
                	}
                	
                	if ( $f2->getErrorCode() == UPLOAD_ERR_OK ) {
                		if ( !$file_no2 ) {
                			$file_no2 = Common::insertFileInfor($this->db, $proc_type, $p_user_no, $p_company_no, $f2->getName(), $f2->getExt(), $f2->getSize());
                			$fileInforUpdate[] = " FILE_NO2 = '" . $file_no2 . "'";
                		} else {
                			@unlink($saveDir.DIRECTORY_SEPARATOR."f2_".$p_consult_no."_".( $oldFile2Ext?"." .$oldFile2Ext:""));
                			$file_no2 = Common::updateFileInfor($this->db, $file_no2, $f2->getName(), $f2->getExt(), $f2->getSize());
                		}
                		$f2->upload();
                	}
                	
                	if ( $f3->getErrorCode() == UPLOAD_ERR_OK ) {
                		if ( !$file_no3 ) {
                			$file_no3 = Common::insertFileInfor($this->db, $proc_type, $p_user_no, $p_company_no, $f3->getName(), $f3->getExt(), $f3->getSize());
                			$fileInforUpdate[] = " FILE_NO3 = '" . $file_no3 . "'";
                		} else {
                			@unlink($saveDir.DIRECTORY_SEPARATOR."f3_".$p_consult_no."_".( $oldFile3Ext?"." .$oldFile3Ext:""));
                			$file_no3 = Common::updateFileInfor($this->db, $file_no3, $f3->getName(), $f3->getExt(), $f3->getSize());
                		}
                		$f3->upload();
                	}
                	
                	if ( !empty($fileInforUpdate) ) {
                		$this->exec(
                				"UPDATE " .TBL_BIZ_CONSULT . " SET"
                				. join(",\n", $fileInforUpdate)
                				. " WHERE CONSULT_NO = '" .$p_consult_no . "'"
                		);
                	}
                	
                	$this->db->commit();                	
                } else {
                	throw new Exception("수정처리중 에러가 발생하였습니다.");
                }
            } else {
//                out.print($this->db->getErrMsg());
                throw new Exception($this->db->getErrMsg());
//               throw new Exception("수정처리중 에러가 발생하였습니다.");
            }
        } catch (Exception $e) {
            $this->addErrMessage($e->getMessage());
            $this->db->rollback();            
        }
        $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_UPDATE)); // 성공시 출력 메시지.
        $this->printXML(C_DB_PROCESS_MODE_UPDATE);
    }

    
    /**
     * 상담정보 삭제
     * @param array $argus
     * @return boolean
     */
    public function delete($argus) {
        $p_consult_no = $argus[p_consult_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !ADMIN ) throw new Exception("권한이 없습니다.");
            // 상담정보
            $infor = $this->db->get(
            		"SELECT "
            		. "STATE, "
            		. "WORKER_NO, "
            		. "PROC_TYPE, "
            		. "FILE_NO1, "
            		. "FILE_NO2, "
            		. "FILE_NO3  "
            		. " FROM ". TBL_BIZ_CONSULT
            		. " WHERE CONSULT_NO = '" . $p_consult_no . "'"
            );
            $state    = $infor->STATE;
            $file_no1 = $infor->FILE_NO1;
            $file_no2 = $infor->FILE_NO2;
            $file_no3 = $infor->FILE_NO3;
            $p_worker_no= $infor->WORKER_NO; // worker
            $proc_type = $infor->PROC_TYPE;
                        
            $query = array();
            $query [] = "DELETE FROM " . TBL_BIZ_CONSULT;
            $query [] = " WHERE ";
            $query [] = " CONSULT_NO = '" . $p_consult_no . "'";
            $this->setQuery(join(PHP_EOL, $query));
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
            	//                out.print($this->db->getAffectedRows());
            	if ( $proc_type == PROC_TYPE_BC  ) { // 상담
            		if ( $state == STATE_BC_UPDATE_REQUEST ) throw new Exception("상담이 수정요청중에있어 삭제할 수 없습니다.");
            	} else if ( $proc_type == PROC_TYPE_BM  ) { // 매칭
            		if ( $state == STATE_BM_UPDATE_REQUEST ) throw new Exception("매칭이 수정요청중에있어 삭제할 수 없습니다.");
            	}            	
			    
			    // 담당자정보 삭제.
			    if ( !Worker::externalDelete($this->db, array(p_worker_no=>$p_worker_no)) ) throw new Exception($this->db->getErrMsg());
			    
			    $oldFileInfor = Common::getFileInfor($this->db,array(FILE_NO1=>$file_no1,FILE_NO2=>$file_no2,FILE_NO3=>$file_no3),"FILE_NO,FILE_EXT");
			    $oldFile1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;
			    $oldFile2Ext = $oldFileInfor['FILE_NO2']->FILE_EXT;
			    $oldFile3Ext = $oldFileInfor['FILE_NO3']->FILE_EXT;
			    
			    // 파일 삭제.			    
			    $saveDir = DATA_DIR . DIRECTORY_SEPARATOR . BizConsult::$SAVE_SUB_DIR;
			    @unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_consult_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
			    Common::deleteFileInfor($this->db, $file_no1);
			    @unlink($saveDir.DIRECTORY_SEPARATOR."f2_".$p_consult_no."_".( $oldFile2Ext?"." .$oldFile2Ext:"") );
			    Common::deleteFileInfor($this->db, $file_no2);
			    @unlink($saveDir.DIRECTORY_SEPARATOR."f3_".$p_consult_no."_".( $oldFile3Ext?"." .$oldFile3Ext:"") );
			    Common::deleteFileInfor($this->db, $file_no3);
			    
                if ( !$this->db->commit() ) throw new Exception("삭제처리중 에러가 발생하였습니다.");
            } else {
            	throw new Exception($this->db->getErrMsg());
            	//               throw new Exception("삭제처리중 에러가 발생하였습니다.");
            }
        } catch (Exception $e) {
            $this->addErrMessage($e->getMessage());
            $this->db->rollback();
        }
        $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_DELETE)); // 성공시 출력 메시지.
        $this->printXML(C_DB_PROCESS_MODE_DELETE);
    }

    /**
     * 컨설팅 정보 삭제.(외부클래스)
     * @param Database $db
     * @param array $argus
     * @return boolean
     */
    public static function externalDelete($db,$argus) {
        $p_consult_no = $argus[p_consult_no];
    	$rtn = true;
    	try {
    		if ( !ADMIN ) throw new Exception("권한이 없습니다.");
    
    		$query = array();
    		$query [] = "DELETE FROM " . TBL_BIZ_CONSULT;
    		$query [] = " WHERE ";
    		$query [] = " CONSULT_NO = '" . $p_consult_no . "'";
    		$sql = join(PHP_EOL, $query);
    		//     		var_dump($db);
    		if ( $db->exec($sql) ) {
    		} else {
    			//                out.print($this->db->getErrMsg());
    			throw new Exception($db->getErrMsg());
    		}
    
    	} catch (Exception $e) {
    		$rtn = false;
    	}
    	return  $rtn;
    }
        
    /**
     * code를 array화한다.
     */
    public function getCodeData() {
       	// CODE DATA 정의
    	if ( METHOD == "select" ) { // 비지니스 상담       	
			$this->addCodeData("STATE", self::$CODE_STATE_BC);
    	} else if ( METHOD == "select2" ) { // 비지니스 매칭
    		$this->addCodeData("STATE", self::$CODE_STATE_BC);    		
    		$this->addCodeData("BIZ_FIELD", self::$CODE_BIZ_FIELD);
    		$this->addCodeData("BIZ_CLASSIFIED", self::$CODE_BIZ_CLASSIFIED);
    		$this->addCodeData("COMPANY_TYPE", self::$CODE_COMPANY_TYPE);
    	}    		
    }
}
if ( DEBUG ) {
   // # test path : http://local-framework.com/BizConsult.php
   $test = new BizConsult();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_BIZ_CONSULT );
   $test->test($argus);
/*

   // insert 
   $argus[consult_no]  = 'data';
   $argus[reg_code]  = 'data';
   $argus[proc_type]  = 'data';
   $argus[company_no]  = 'data';
   $argus[consult_company_no]  = 'data';
   $argus[state]  = 'data';
   $argus[consult_item]  = 'data';
   $argus[hope_biz_type]  = 'data';
   $argus[hope_biz]  = 'data';
   $argus[hope_trade_type]  = 'data';
   $argus[open_limit]  = 'data';
   $argus[etc_question]  = 'data';
   $argus[file_no1]  = 'data';
   $argus[file_no2]  = 'data';
   $argus[file_no3]  = 'data';
   $argus[worker_no]  = 'data';
   $argus[action_plan]  = 'data';
   $argus[open_yn]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[consult_no]  = 'key';
   // data field 
   $argus[reg_code]  = 'data';
   $argus[proc_type]  = 'data';
   $argus[company_no]  = 'data';
   $argus[consult_company_no]  = 'data';
   $argus[state]  = 'data';
   $argus[consult_item]  = 'data';
   $argus[hope_biz_type]  = 'data';
   $argus[hope_biz]  = 'data';
   $argus[hope_trade_type]  = 'data';
   $argus[open_limit]  = 'data';
   $argus[etc_question]  = 'data';
   $argus[file_no1]  = 'data';
   $argus[file_no2]  = 'data';
   $argus[file_no3]  = 'data';
   $argus[worker_no]  = 'data';
   $argus[action_plan]  = 'data';
   $argus[open_yn]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[consult_no]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[consult_no]  = 'key';
   $test->select($argus); 

*/
}
?>
