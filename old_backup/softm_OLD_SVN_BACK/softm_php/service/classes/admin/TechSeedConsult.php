<?php
define("DEBUG",ereg("^/service/classes", $_SERVER[PHP_SELF]));
if ( DEBUG ) {
	require_once '../../lib/common.lib.inc' ; // 라이브러리
	require_once SERVICE_DIR . '/classes/common/Session.php'          ; // 세션 
}
require_once SERVICE_DIR . '/classes/BaseDataBase.php'; // 기본 DataBase 클래스
require_once SERVICE_DIR . '/classes/common/Util.php'; // Util클래스
require_once SERVICE_DIR . '/classes/common/Common.php'; // Common클래스
//require_once SERVICE_DIR . '/classes/common/FileUpload.php'; // 파일업로드클래스
require_once SERVICE_DIR . '/classes/base/Worker.php'; // 담당자 클래스
require_once SERVICE_DIR . '/classes/front/TechSeed.php'; // 기술시드 클래스

/**
 * @author softm
 * 기술시디매칭신청 / TechSeedConsult.php
 */
class TechSeedConsult extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_TECH_CONSULT);
    		$tbl1->newColumn('CONSULT_NO'    ,'번호',1)->setWidth(60)->setEditable(false);
    		$tbl1->newColumn('CAT_NM'        ,'기술분야',2)->setWidth(120)->setEditable(false);
    		$tbl1->newColumn('TECH_NM'       ,'기술명'  ,3)->setWidth(200)->setEditable(false)->setCssText("text-align:left");    		
    		$tbl1->newColumn('LICENSE_NUMBER','특허번호',4)->setWidth(120)->setEditable(false)->setCssText("text-align:left");    		
    		$tbl1->newColumn('ORGAN'         ,'기관명'  ,5)->setWidth(120)->setEditable(false);
	        $tbl1->newColumn('STATE'         ,'처리상황',6)->setType(Column::LISTBOX_TYPE)->setWidth(100)->setKey(false);
	        $tbl1->newColumn('TECH_NO'       ,'기술번호',7)->setHide()->setWidth(0);
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
     * @param array $argus
     * @return DOMDocument
     */
    public function select($argus) {
    	global $page_tab;
    	
		$s_l_cat          = $argus[s_l_cat];
		$s_m_cat          = $argus[s_m_cat];
		$s_s_cat          = $argus[s_s_cat];
		
		$s_tech_nm        = $argus[s_tech_nm       ];
		$s_license_number = $argus[s_license_number];
		$s_organ          = $argus[s_organ         ];
		$s_keyword        = $argus[s_keyword       ];
		
    	//$this->getCodeData(); // code xml 생성
    	$this->addCodeData("STATE", self::$CODE_STATE_SM);
    	    	
    	$this->startXML();
    	$this->setType(BaseDataBase::GRID_TYPE);
    	try {
    		if ( !ADMIN ) throw new Exception("권한이 없습니다.");
//    		var_dump($argus);
    		$page_tab['js_function' ] = $argus["p_navi_function"];
    		$page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
    		if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];

    		// where 문장생성
//     		$make_where = $this->makeWhere($argus);
//     		$where = $make_where;
    		$where = " a.PROC_TYPE  = '" . PROC_TYPE_SM . "'"
    		       . ($s_l_cat         ?" AND b.TECH_L_CAT     = '" . $s_l_cat . "'":"")
    		       . ($s_m_cat         ?" AND b.TECH_M_CAT     = '" . $s_m_cat . "'":"")
    		       . ($s_s_cat         ?" AND b.TECH_S_CAT     = '" . $s_s_cat . "'":"")
    		       . ($s_tech_nm       ?" AND b.TECH_NM        LIKE '" . $s_tech_nm        . "%'":"")
    		       . ($s_license_number?" AND b.LICENSE_NUMBER LIKE '" . $s_license_number . "%'":"")
    		       . ($s_organ         ?" AND b.ORGAN          LIKE '" . $s_organ          . "%'":"")
    		       . ($s_keyword       ?" AND b.KEYWORD        LIKE '" . $s_keyword        . "%'":"") 		       
    		;
    		
    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_TECH_CONSULT . " a "
    				. " LEFT OUTER JOIN " . TBL_TECH_SEED . " b ON a.TECH_NO = b.TECH_NO " 
    				. ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		
    		$query [] = " SELECT ";
    		$query [] = " a.CONSULT_NO                        CONSULT_NO  ,";    		
    		$query [] = " b.TECH_NO                           TECH_NO     ,";
    		$query [] = " c.NM                                CAT_NM      ,"; // 기술분야
    		$query [] = " b.ORGAN                             ORGAN       ,"; // 기관명
    		$query [] = " b.TECH_NM                           TECH_NM     ,"; // 기술명
    		$query [] = " b.LICENSE_NUMBER                    LICENSE_NUMBER,"; // 특허번호
    		$query [] = " a.STATE                             STATE        ";
    		$query [] = " FROM " . TBL_TECH_CONSULT . " a ";
    		$query [] = " LEFT OUTER JOIN " . TBL_TECH_SEED . " b ON a.TECH_NO = b.TECH_NO";
    		$query [] = " LEFT OUTER JOIN " . TBL_TECH_CATEGORY . " c";
    		$query [] = " ON CONCAT(b.TECH_L_CAT,IF(b.TECH_M_CAT='','00',b.TECH_M_CAT),IF(b.TECH_S_CAT='','00',b.TECH_S_CAT)) = CONCAT(c.L_CAT,c.M_CAT,c.S_CAT)";
    		
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
    		$query [] = " a.CONSULT_NO   CONSULT_NO,";
    		$query [] = " a.REG_CODE     REG_CODE  ,";
    		$query [] = " a.PROC_TYPE    PROC_TYPE ,";
    		$query [] = " a.STATE        STATE     ,";
    		$query [] = " a.WORKER_NO    WORKER_NO ,";
    		$query [] = " a.COMPANY_NO   COMPANY_NO,";
    		$query [] = " a.TECH_NO      TECH_NO   ,";
    		$query [] = " b.REG_CODE     COMPANY_REG_CODE";
            $query [] = " FROM " . TBL_TECH_CONSULT . " a ";
            $query [] = " LEFT OUTER JOIN " . TBL_COMPANY . " b ON a.COMPANY_NO = b.COMPANY_NO ";
            $query [] = " WHERE ";
            $query [] = " CONSULT_NO = '" . $p_consult_no . "'";
            
            $sql = $this->setQuery(join(PHP_EOL, $query));
            $tech_consult = $this->db->get($sql,"array");
            
            // 담당자 정보조회
            $worker = Worker::externalGet($this->db, array(p_worker_no=>$tech_consult[WORKER_NO]));

            // 기술시드 정보조회
            $techSeed = TechSeed::externalGet($this->db, array(p_tech_no=>$tech_consult[TECH_NO]));
                        
            @$this->oneRowToXML(array_merge($worker,$tech_consult),"item","fi");
            
            @$this->oneRowToXML($techSeed,"seed_item","seed_fi");
                        
            $fInfor = $this->db->get(
            		"SELECT "
            		. "FILE_NO1  "
            		. " FROM ". TBL_TECH_SEED
            		. " WHERE TECH_NO = '" . $tech_consult[TECH_NO] . "'"
            );
            $file_no1 = $fInfor->FILE_NO1;
            
            $oldFileInfor = Common::getFileInfor($this->db,$fInfor,"FILE_NO,FILE_NAME,FILE_EXT,FILE_SIZE");
            $oldFile1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;
            $file1Name = $oldFileInfor['FILE_NO1']->FILE_NAME;
            $file1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;
            
            $this->appendNode('filename1', $file1Name);
            $this->appendNode('fileext1', $file1Ext);
            $this->appendNode('fileno1', $file_no1);
            
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
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !ADMIN ) throw new Exception("권한이 없습니다.");
            $query = array();
            $query = array();
            $query [] = "UPDATE " . TBL_TECH_CONSULT;
            $query [] = " SET";
            $query [] = " OPEN_YN = '" . $argus[open_yn] . "',";
            $query [] = " STATE   = '" . $argus[state  ] . "',";
            $query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " CONSULT_NO = '" . $p_consult_no . "'";
            $this->setQuery(join(PHP_EOL, $query));
            //            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
            	// 담당자정보 수정.
            	if ( !Worker::externalUpdate($this->db, $argus) ) throw new Exception("담당자정보 수정처리에 문제가 발생하였습니다.");
            	if ( !$this->db->commit() ) throw new Exception("수정처리중 에러가 발생하였습니다.");
            }            
        } catch (Exception $e) {
            $this->addErrMessage($e->getMessage());
            $this->db->rollback();
        }
        $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_UPDATE)); // 성공시 출력 메시지.
        $this->printXML(C_DB_PROCESS_MODE_UPDATE);
    }

    /**
     * 삭제
     * @param array $argus
     * @return boolean
     */
    public function delete($argus) {
        $p_consult_no = $argus[p_consult_no];
        $p_worker_no  = $argus[p_worker_no ];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !ADMIN ) throw new Exception("권한이 없습니다.");
            $query = array();
            $query [] = "DELETE FROM " . TBL_TECH_CONSULT;
            $query [] = " WHERE ";
            $query [] = " CONSULT_NO = '" . $p_consult_no . "'";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
//                out.print($this->db->getAffectedRows());
            	// 담당자정보 삭제.
            	if ( !Worker::externalDelete($this->db, array(p_worker_no=>$p_worker_no)) ) throw new Exception($this->db->getErrMsg());
            	
                if ( !$this->db->commit() ) throw new Exception("삭제처리중 에러가 발생하였습니다.");
            } else {
//                out.print($this->db->getErrMsg());
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
//         $this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
//         $this->addCodeData("SEX"       , self::$CODE_SEX       );
//         $this->addCodeData("STATE"     , self::$CODE_USER_STATE);
//         $this->addCodeData("EMAIL_YN"  , self::$CODE_YN    );
    }
}
if ( DEBUG ) {
   // # test path : http://local-framework.com/TechConsult.php
   $test = new TechConsult();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_TECH_CONSULT );
   $test->test($argus);
/*

   // insert 
   $argus[consult_no]  = 'data';
   $argus[reg_code]  = 'data';
   $argus[proc_type]  = 'data';
   $argus[tech_l_cat]  = 'data';
   $argus[tech_m_cat]  = 'data';
   $argus[tech_s_cat]  = 'data';
   $argus[tech_nm]  = 'data';
   $argus[tech_nm_jp]  = 'data';
   $argus[tech_content]  = 'data';
   $argus[tech_content_jp]  = 'data';
   $argus[tech_comment]  = 'data';
   $argus[tech_comment_jp]  = 'data';
   $argus[keyword]  = 'data';
   $argus[keyword_jp]  = 'data';
   $argus[trade_hope_type]  = 'data';
   $argus[trade_hope_type_etc]  = 'data';
   $argus[state]  = 'data';
   $argus[worker_no]  = 'data';
   $argus[company_no]  = 'data';
   $argus[tech_no]  = 'data';
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
   $argus[tech_l_cat]  = 'data';
   $argus[tech_m_cat]  = 'data';
   $argus[tech_s_cat]  = 'data';
   $argus[tech_nm]  = 'data';
   $argus[tech_nm_jp]  = 'data';
   $argus[tech_content]  = 'data';
   $argus[tech_content_jp]  = 'data';
   $argus[tech_comment]  = 'data';
   $argus[tech_comment_jp]  = 'data';
   $argus[keyword]  = 'data';
   $argus[keyword_jp]  = 'data';
   $argus[trade_hope_type]  = 'data';
   $argus[trade_hope_type_etc]  = 'data';
   $argus[state]  = 'data';
   $argus[worker_no]  = 'data';
   $argus[company_no]  = 'data';
   $argus[tech_no]  = 'data';
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
