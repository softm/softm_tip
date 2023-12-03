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
    		$tbl1->newColumn('CONSULT_ITEM','상담안건',2)->setCssText("text-align:left;padding-left:10px");
    		$tbl1->newColumn('NM_KR','담당자',3)->setWidth(100);
    		$tbl1->newColumn('TEL','연락처',4)->setWidth(100);
    		$tbl1->newColumn('REG_DATE','등록일',5)->setWidth(100);
    		$tbl1->newColumn('STATE','처리상황',6)->setType(Column::LISTBOX_TYPE)->setWidth(80);
    		$tbl1->newColumn('COMPANY_NO','기업번호',7)->setHide();
    		$tbl1->newColumn('CONSULT_COMPANY_NO','상담기업번호',8)->setHide();
        } else if ( METHOD == "select2" ) {
        	$tbl1 = $this->newTable(TBL_BIZ_CONSULT);
        	$tbl1->newColumn('COMPANY_TYPE','구분',1)->setType(Column::LISTBOX_TYPE)->setWidth(80);
        	$tbl1->newColumn('BIZ_FIELD','업종분야',2)->setType(Column::LISTBOX_TYPE)->setWidth(80);
//         	$tbl1->newColumn('BIZ_CLASSIFIED','업종분류',3)->setType(Column::LISTBOX_TYPE)->setWidth(80);
        	$tbl1->newColumn('COMPANY_NM_KR','업체명',4)->setWidth(100)->setCssText("text-align:left");
        	$tbl1->newColumn('REG_DATE','등록일',5)->setWidth(100);
        	$tbl1->newColumn('STATE','처리상황',6)->setType(Column::LISTBOX_TYPE)->setWidth(80);
        	
        	$tbl1->newColumn('CONSULT_NO','번호',7)->setHide();        	
        	$tbl1->newColumn('COMPANY_NO','기업번호',8)->setHide();
        	$tbl1->newColumn('CONSULT_COMPANY_NO','상담기업번호',9)->setHide();
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
    		if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
//    		var_dump($argus);
    		$page_tab['js_function' ] = $argus["p_navi_function"];
    		$page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
    		if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];

    		// where 문장생성
    		$make_where = $this->makeWhere($argus);
    		
			// 조회 조건    		
    		$s_company_type = $argus[s_company_type ];
    		$s_biz_field    = $argus[s_biz_field    ];
    		$s_company_nm_kr= $argus[s_company_nm_kr];
    		
    		$where  = " a.COMPANY_NO = '" . COMPANY_NO . "'";
    		$where .= " AND a.PROC_TYPE = " . PROC_TYPE_BM;
    		$where .= $s_company_type ?" AND  b.COMPANY_TYPE = '" . $s_company_type . "'":"";
    		$where .= $s_biz_field    ?" AND  b.BIZ_FIELD    = '" . $s_biz_field . "'":"";
    		$where .= $s_company_nm_kr?" AND  b.COMPANY_NM_KR LIKE '" . $s_company_nm_kr . "%'":"";
    		
    		if ( $make_where ) $where .= " AND ".$make_where;
    		
    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " 
    				. TBL_BIZ_CONSULT . " a "
    			    . " LEFT OUTER JOIN " . TBL_COMPANY . " b ON a.CONSULT_COMPANY_NO = b.COMPANY_NO "
    				. ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();

    		$query [] = " SELECT ";
    		$query [] = " a.CONSULT_NO         CONSULT_NO        ,"; // 번호
    		$query [] = " a.COMPANY_NO         COMPANY_NO        ,";
    		$query [] = " a.CONSULT_COMPANY_NO CONSULT_COMPANY_NO,";
    		$query [] = " b.COMPANY_TYPE       COMPANY_TYPE      ,"; // 구분
    		$query [] = " b.BIZ_FIELD          BIZ_FIELD         ,"; // 업종분야
    		$query [] = " CASE WHEN b.BIZ_CLASSIFIED = 9 THEN b.BIZ_CLASSIFIED_ETC ELSE b.BIZ_CLASSIFIED END AS BIZ_CLASSIFIED,"; // 업종분류
    		$query [] = " b.COMPANY_NM_KR      COMPANY_NM_KR     ,"; // 업체명
    		$query [] = " DATE_FORMAT(a.REG_DATE,'%Y-%m-%d') REG_DATE,"; // 등록일
    		$query [] = " a.STATE        STATE       ,"; // 처리상황
    		$query [] = " a.WORKER_NO    WORKER_NO    ";
    		$query [] = " FROM " . TBL_BIZ_CONSULT . " a";
    		$query [] = " LEFT OUTER JOIN " . TBL_COMPANY . " b ON a.CONSULT_COMPANY_NO = b.COMPANY_NO ";

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
    	if ( USER_LEVEL < MEMBER_TYPE_BIZ ) {
// 			redirect("/sub.php?flashmenu=11912");
// 			header("Location: /sub.php?flashmenu=11912");
//     		header("Location: http://google.com");
//     		header("Location: /sub.php?flashmenu=11912");
//     		exit;
    	}    
//     	header('HTTP/1.0 404 Not Found');
//     	header("Location: /sub.php?flashmenu=11912");
    	//echo "관리자가 아닙니다.";
//     	die();
    	
    	global $page_tab;
    	//     $this->testJsCall($argus);
    	//    	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
    	$this->getCodeData(); // code xml 생성
    	$this->startXML();
    	$this->setType(BaseDataBase::GRID_TYPE);
    	try {
    		if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
    		
    		//    		var_dump($argus);
    		$page_tab['js_function' ] = $argus["p_navi_function"];
    		$page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
    		if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];
    
    		// where 문장생성
    		$make_where = $this->makeWhere($argus);
    
    		// 조회 조건
    		$s_state        = $argus[s_state       ];
    		$s_woker_nm     = $argus[s_woker_nm    ];
    		$s_frm_reg_date = $argus[s_frm_reg_date];
    		$s_to_reg_date  = $argus[s_to_reg_date ];
    
    		$where  = " a.COMPANY_NO = '" . COMPANY_NO . "'";
    		$where .= " AND a.PROC_TYPE = " . PROC_TYPE_BC;
    		$where .= " AND a.REG_DATE BETWEEN '" . $s_frm_reg_date . "' AND '" . $s_to_reg_date . " 23:59:59'";
    		$where .= $s_state?" AND  a.STATE = '" . $s_state . "'":"";
    		$where .= $s_woker_nm?" AND  b.NM_KR LIKE '" . $s_woker_nm . "%'":"";
    
    		if ( $make_where ) $where .= " AND ".$make_where;
    		
    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM "
    				. TBL_BIZ_CONSULT . " a "
    				. " LEFT OUTER JOIN " . TBL_WORKER . " b ON a.WORKER_NO = b.WORKER_NO "
    				. ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());
    
    		$query = array();
    
    		$query [] = " SELECT ";
    		$query [] = " a.CONSULT_NO         CONSULT_NO        ,"; // 번호
    		$query [] = " a.COMPANY_NO         COMPANY_NO        ,";
    		$query [] = " a.CONSULT_COMPANY_NO CONSULT_COMPANY_NO,";
    		$query [] = " a.CONSULT_ITEM       CONSULT_ITEM      ,"; // 상담안건
    		$query [] = " b.NM_KR              NM_KR             ,"; // 담당자
    		$query [] = " b.TEL                TEL               ,"; // 연락처
    		$query [] = " DATE_FORMAT(a.REG_DATE,'%Y-%m-%d') REG_DATE,"; // 등록일
    		$query [] = " a.STATE        STATE       ,"; // 처리상황
    		$query [] = " a.WORKER_NO    WORKER_NO    ";
    		$query [] = " FROM " . TBL_BIZ_CONSULT . " a";
    		$query [] = " LEFT OUTER JOIN " . TBL_WORKER . " b ON a.WORKER_NO = b.WORKER_NO ";
    
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
            if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " CONSULT_NO,";
    		$query [] = " REG_CODE,";
    		$query [] = " PROC_TYPE,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " CONSULT_COMPANY_NO,";
    		$query [] = " STATE,";
    		$query [] = " CONSULT_ITEM,";
    		$query [] = " HOPE_BIZ_TYPE,";
    		$query [] = " HOPE_BIZ,";
    		$query [] = " HOPE_TRADE_TYPE,";
    		$query [] = " OPEN_LIMIT,";
    		$query [] = " ETC_QUESTION,";
    		$query [] = " FILE_NO1,";
    		$query [] = " FILE_NO2,";
    		$query [] = " FILE_NO3,";
    		$query [] = " WORKER_NO,";
    		$query [] = " ACTION_PLAN,";
    		$query [] = " OPEN_YN,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE";
            $query [] = " FROM " . TBL_BIZ_CONSULT;
            $query [] = " WHERE COMPANY_NO = '" . COMPANY_NO    . "'";
            $query [] = " AND   CONSULT_NO = '" . $p_consult_no . "'";
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
                   
    		$worker = Worker::externalGet($this->db, array(p_worker_no=>$colsult[WORKER_NO]));
    		$this->oneRowToXML(array_merge($worker,$colsult),"item","fi");
    		    		
            $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
        } catch (Exception $e) {
            $this->addErrMessage($e->getMessage());
        }
        $this->printXML(C_DB_PROCESS_MODE_SELECT);
    }
    
    
    /**
     * 일본기업 상담정보 조회
     * @param array $argus
     * @return DOMDocument
     */
    public function getJp($argus) {
        //$p_user_id   = $argus[user_email  ];
        $p_company_no = $argus[p_company_no];
//         $p_consult_no = $argus[p_consult_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
            if ( USER_LEVEL < MEMBER_TYPE_BIZ ) throw new Exception("기업회원만 이용할 수 있습니다.");
            
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " CONSULT_NO,";
    		$query [] = " REG_CODE,";
    		$query [] = " PROC_TYPE,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " CONSULT_COMPANY_NO,";
    		$query [] = " STATE,";
    		$query [] = " CONSULT_ITEM,";
    		$query [] = " HOPE_BIZ_TYPE,";
    		$query [] = " HOPE_BIZ,";
    		$query [] = " HOPE_TRADE_TYPE,";
    		$query [] = " OPEN_LIMIT,";
    		$query [] = " ETC_QUESTION,";
    		$query [] = " FILE_NO1,";
    		$query [] = " FILE_NO2,";
    		$query [] = " FILE_NO3,";
    		$query [] = " WORKER_NO,";
    		$query [] = " ACTION_PLAN,";
    		$query [] = " OPEN_YN,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE";
            $query [] = " FROM " . TBL_BIZ_CONSULT;
            $query [] = " WHERE COMPANY_NO = '" . $p_company_no . "'";
            $query [] = " AND   PROC_TYPE = '" . PROC_TYPE_BC_JP . "'";
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
                   
    		$worker = Worker::externalGet($this->db, array(p_worker_no=>$colsult[WORKER_NO]));
    		$this->oneRowToXML(array_merge($worker,$colsult),"item","fi");
    		    		
            $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
        } catch (Exception $e) {
            $this->addErrMessage($e->getMessage());
        }
        $this->printXML(C_DB_PROCESS_MODE_SELECT);
    }
    
    
    
   /**
     * 입력
     * @param array $argus
     * @return int
     */
    public function insert($argus) {
        $p_proc_type = $argus[p_proc_type];
    
        $cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED ) ,0) + 1 FROM " . TBL_BIZ_CONSULT
        		." WHERE PROC_TYPE IN('" . PROC_TYPE_BC . "','" . PROC_TYPE_BM . "')"
        		." AND   SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)"
        );
        $reg_code =sprintf('%s%s%04d','KB',date("Ymd"),$cnt);
                        
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
            $state = null;
            if ( $p_proc_type == PROC_TYPE_BC  ) { // 상담
            	$state = STATE_BC_START;
            	$p_consult_company_no = "0";            	
            } else if ( $p_proc_type == PROC_TYPE_BM  ) { // 매칭
            	$state = STATE_BM_REQUEST;
            	$p_consult_company_no = $argus[p_consult_company_no];
            }
            
			if ( !$state )  throw new Exception("상담정보에 문제가 있어 등록할 수 없습니다.");
			
            $query = array();
            $query [] = "INSERT INTO " . TBL_BIZ_CONSULT;
            $query [] = "(";
    		$query [] = " REG_CODE,";
    		$query [] = " PROC_TYPE,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " CONSULT_COMPANY_NO,";
    		$query [] = " STATE,";
    		$query [] = " CONSULT_ITEM,";
    		$query [] = " HOPE_BIZ_TYPE,";
    		$query [] = " HOPE_BIZ,";
    		$query [] = " HOPE_TRADE_TYPE,";
    		$query [] = " OPEN_LIMIT,";
    		$query [] = " ETC_QUESTION,";
//     		$query [] = " FILE_NO1,";
//     		$query [] = " FILE_NO2,";
//     		$query [] = " FILE_NO3,";
//     		$query [] = " WORKER_NO,";
    		$query [] = " ACTION_PLAN,";
    		$query [] = " OPEN_YN,";
    		$query [] = " REG_DATE";
//     		$query [] = " MOD_DATE";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $reg_code    . "',";
    		$query [] = " '" . $p_proc_type . "',";
    		$query [] = " '" . COMPANY_NO   . "',";
    		$query [] = " '" . $p_consult_company_no   . "',";
    		$query [] = " '" . $state       . "',";
    		$query [] = " '" . $argus[consult_item] . "',";
    		$query [] = " '" . $argus[hope_biz_type] . "',";
    		$query [] = " '" . $argus[hope_biz] . "',";
    		$query [] = " '" . $argus[hope_trade_type] . "',";
    		$query [] = " '" . $argus[open_limit] . "',";
    		$query [] = " '" . $argus[etc_question] . "',";
//     		$query [] = " '" . $argus[file_no1] . "',";
//     		$query [] = " '" . $argus[file_no2] . "',";
//     		$query [] = " '" . $argus[file_no3] . "',";
//     		$query [] = " '" . $argus[worker_no] . "',";
    		$query [] = " '" . $argus[action_plan] . "',";
    		$query [] = " 'N',";
    		$query [] = " now()";
//     		$query [] = " '" . $argus[mod_date] . "'";
            //$query [] = " now() ";
            $query [] = " );";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
                $consult_no = $this->db->getInsertId(); // insert id 
                $this->appendNode("insert_id", $consult_no);
//                out.print($this->db->getAffectedRows());
                if ( !$this->db->commit() ) throw new Exception("입력처리중 에러가 발생하였습니다.");
                else {
                	// 담당자정보 입력.
                	$worker_no = Worker::externalInsert($this->db, $argus);
// 					echo $worker_no; 
                	$this->appendNode("insert_worker_no", $worker_no);
                	                	
                	$updateInfor = array();
                	$updateInfor[] = " WORKER_NO = '" . $worker_no . "'";

                	$file_no1 = 0;
                	$file_no2 = 0;
                	$file_no3 = 0;
//                 	echo DATA_DIR . DIRECTORY_SEPARATOR . BizConsult::$SAVE_SUB_DIR;
                	$uploader  = new FileUpload(true,DATA_DIR . DIRECTORY_SEPARATOR . BizConsult::$SAVE_SUB_DIR); // 업로드 인스턴스 생성
//                 	var_dump($uploader);
                	$uploader->getItem('file1')->setSaveName("f1_".$consult_no."_");
                	$uploader->getItem('file2')->setSaveName("f2_".$consult_no."_");
                	$uploader->getItem('file3')->setSaveName("f3_".$consult_no."_");
                	$uploader->upload(); 

                	$f1 = $uploader->getItem('file1');
                	$f2 = $uploader->getItem('file2');
                	$f3 = $uploader->getItem('file3');
                	// 					echo $f1->getErrorCode() . '<BR>';
                	// 					echo $f2->getErrorCode() . '<BR>';
                	// 					echo $f3->getErrorCode() . '<BR>';
                	
                	if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {
                		$file_no1 = Common::insertFileInfor($this->db, $p_proc_type, USER_NO, COMPANY_NO, $f1->getName(), $f1->getExt(), $f1->getSize());
                	}
                	
                	if ( $f2->getErrorCode() == UPLOAD_ERR_OK ) {
                		$file_no2 = Common::insertFileInfor($this->db, $p_proc_type, USER_NO, COMPANY_NO, $f2->getName(), $f2->getExt(), $f2->getSize());
                	}
                	
                	if ( $f3->getErrorCode() == UPLOAD_ERR_OK ) {
                		$file_no3 = Common::insertFileInfor($this->db, $p_proc_type, USER_NO, COMPANY_NO, $f3->getName(), $f3->getExt(), $f3->getSize());
                	}

                	if ( $file_no1 !=0 ) $updateInfor[] = " FILE_NO1 = '" . $file_no1 . "'";
                	if ( $file_no2 !=0 ) $updateInfor[] = " FILE_NO2 = '" . $file_no2 . "'";
                	if ( $file_no3 !=0 ) $updateInfor[] = " FILE_NO3 = '" . $file_no3 . "'";
                	if ( !empty($updateInfor) ) {
                		$this->db->setAutoCommit(false);
                		$this->exec(
                				"UPDATE " .TBL_BIZ_CONSULT . " SET"
                				. join(",\n", $updateInfor)
                				. " WHERE CONSULT_NO = '" .$consult_no . "'"
                		);
                	
                		$this->db->commit();
                	}
                }
            } else {
//                out.print($this->db->getErrMsg());
                throw new Exception($this->db->getErrMsg());
//               throw new Exception("입력처리중 에러가 발생하였습니다.");
            }
        } catch (Exception $e) {
            $this->addErrMessage($e->getMessage());
            $this->db->rollback();            
        }
        $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_INSERT)); // 성공시 출력 메시지.
        $this->printXML(C_DB_PROCESS_MODE_INSERT);
    }
    
    
    /**
     * 수정
     * @param array $argus
     * @return boolean
     */
    public function update($argus) {
        $p_consult_no = $argus[p_consult_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
            // 상담정보
            $infor = $this->db->get(
            		"SELECT "
            		. "WORKER_NO, "
            		. "PROC_TYPE, "
            		. "FILE_NO1, "
            		. "FILE_NO2, "
            		. "FILE_NO3  "
            		. " FROM ". TBL_BIZ_CONSULT
            		. " WHERE COMPANY_NO = '" . COMPANY_NO . "'"
            		. " AND   CONSULT_NO = '" . $p_consult_no . "'"
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
            $query [] = " HOPE_BIZ_TYPE = '" . $argus[hope_biz_type] . "',";
            $query [] = " HOPE_BIZ = '" . $argus[hope_biz] . "',";
            $query [] = " HOPE_TRADE_TYPE = '" . $argus[hope_trade_type] . "',";
            $query [] = " OPEN_LIMIT = '" . $argus[open_limit] . "',";
            $query [] = " ETC_QUESTION = '" . $argus[etc_question] . "',";
    		if ( $argus[file1_delete] == 'Y' ) $query[]  = " FILE_NO1   = NULL,";
    		if ( $argus[file2_delete] == 'Y' ) $query[]  = " FILE_NO2   = NULL,";
    		if ( $argus[file3_delete] == 'Y' ) $query[]  = " FILE_NO3   = NULL,";
//             $query [] = " WORKER_NO = '" . $argus[worker_no] . "',";
    		if ( $proc_type == PROC_TYPE_BM ) {
            	$query [] = " ACTION_PLAN = '" . $argus[action_plan] . "',";
    		}
            $query [] = " MOD_DATE = now()";
            $query [] = " WHERE COMPANY_NO = '" . COMPANY_NO    . "'";
            $query [] = " AND   CONSULT_NO = '" . $p_consult_no . "'";
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
                			$file_no1 = Common::insertFileInfor($this->db, $proc_type, USER_NO, COMPANY_NO, $f1->getName(), $f1->getExt(), $f1->getSize());
                			$fileInforUpdate[] = " FILE_NO1 = '" . $file_no1 . "'";
                		} else {
                			@unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_consult_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
                			$file_no1 = Common::updateFileInfor($this->db, $file_no1, $f1->getName(), $f1->getExt(), $f1->getSize());
                		}
                		$f1->upload();
                	}
                	
                	if ( $f2->getErrorCode() == UPLOAD_ERR_OK ) {
                		if ( !$file_no2 ) {
                			$file_no2 = Common::insertFileInfor($this->db, $proc_type, USER_NO, COMPANY_NO, $f2->getName(), $f2->getExt(), $f2->getSize());
                			$fileInforUpdate[] = " FILE_NO2 = '" . $file_no2 . "'";
                		} else {
                			@unlink($saveDir.DIRECTORY_SEPARATOR."f2_".$p_consult_no."_".( $oldFile2Ext?"." .$oldFile2Ext:""));
                			$file_no2 = Common::updateFileInfor($this->db, $file_no2, $f2->getName(), $f2->getExt(), $f2->getSize());
                		}
                		$f2->upload();
                	}
                	
                	if ( $f3->getErrorCode() == UPLOAD_ERR_OK ) {
                		if ( !$file_no3 ) {
                			$file_no3 = Common::insertFileInfor($this->db, $proc_type, USER_NO, COMPANY_NO, $f3->getName(), $f3->getExt(), $f3->getSize());
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
                				. " WHERE COMPANY_NO = '" .COMPANY_NO    . "'"
                				. " AND   CONSULT_NO = '" .$p_consult_no . "'"
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
            if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
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
            		. " WHERE COMPANY_NO = '" . COMPANY_NO    . "'"
            		. " AND   CONSULT_NO = '" . $p_consult_no . "'"
            );
            $state    = $infor->STATE;
            $file_no1 = $infor->FILE_NO1;
            $file_no2 = $infor->FILE_NO2;
            $file_no3 = $infor->FILE_NO3;
            $p_worker_no= $infor->WORKER_NO; // worker
            $proc_type = $infor->PROC_TYPE;
                        
            $query = array();
            $query [] = "DELETE FROM " . TBL_BIZ_CONSULT;
            $query [] = " WHERE COMPANY_NO = '" . COMPANY_NO    . "'";
            $query [] = " AND   CONSULT_NO = '" . $p_consult_no . "'";
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
