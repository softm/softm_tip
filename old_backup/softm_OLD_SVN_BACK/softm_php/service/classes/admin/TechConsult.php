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

/**
 * @author softm
 * 기술니즈신청 & 기술시드매칭신청 / TechConsult.php
 */
class TechConsult extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_TECH_CONSULT);
    		$tbl1->newColumn('CONSULT_NO'     ,'번호',1)->setWidth(80)->setEditable(false);
    		$tbl1->newColumn('CAT_NM'         ,'분야',2)->setWidth(120)->setEditable(false);
    		$tbl1->newColumn('TECH_NM'        ,'기술명',3)->setWidth(300)->setEditable(false)->setCssText("text-align:left");    		
    		$tbl1->newColumn('TRADE_HOPE_TYPE','거래유형',4)->setType(Column::LISTBOX_TYPE)->setEditable(false);
	        $tbl1->newColumn('STATE'          ,'신청상황',5)->setType(Column::LISTBOX_TYPE)->setWidth(100)->setKey(false);
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
		
		$s_tech_nm         = $argus[s_tech_nm        ];
		$s_trade_hope_type = $argus[s_trade_hope_type];
		$s_keyword         = $argus[s_keyword        ];
		
		$this->addCodeData("STATE", self::$CODE_STATE_NC);
		$this->addCodeData("TRADE_HOPE_TYPE", self::$CODE_TECH_TRADE_HOPE_TYPE);
				
//     	$this->getCodeData(); // code xml 생성
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
    		
    		$where = " a.PROC_TYPE  = '" . PROC_TYPE_NC . "'"
	    		. ($s_l_cat          ?" AND a.TECH_L_CAT     = '" . $s_l_cat . "'":"")
	    		. ($s_m_cat          ?" AND a.TECH_M_CAT     = '" . $s_m_cat . "'":"")
	    		. ($s_s_cat          ?" AND a.TECH_S_CAT     = '" . $s_s_cat . "'":"")
	    		. ($s_tech_nm        ?" AND a.TECH_NM     LIKE '" . $s_tech_nm         . "%'":"")
	    		. ($s_trade_hope_type?" AND a.TRADE_HOPE_TYPE= '" . $s_trade_hope_type . "'":"" )
	    		. ($s_keyword        ?" AND a.KEYWORD     LIKE '" . $s_keyword         . "%'":"")
    		;
    		
    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_TECH_CONSULT . " a " . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		$query [] = " SELECT ";
    		$query [] = " a.CONSULT_NO                        CONSULT_NO  ,";
    		$query [] = " b.NM                                CAT_NM      ,"; // 기술분야
    		$query [] = " a.TECH_NM                           TECH_NM     ,"; // 기술명
    		$query [] = " a.TRADE_HOPE_TYPE                   TRADE_HOPE_TYPE,"; // 거래희망유형
    		$query [] = " a.TECH_CONTENT                      TECH_CONTENT,";
    		$query [] = " a.TECH_COMMENT                      TECH_COMMENT,";
    		$query [] = " a.STATE                             STATE       ,";
    		$query [] = " DATE_FORMAT(a.REG_DATE,'%Y-%m-%d')  REG_DATE     ";
    		$query [] = " FROM " . TBL_TECH_CONSULT . " a LEFT OUTER JOIN " . TBL_TECH_CATEGORY . " b";
    		$query [] = " ON CONCAT(a.TECH_L_CAT,IF(a.TECH_M_CAT='','00',a.TECH_M_CAT),IF(a.TECH_S_CAT='','00',a.TECH_S_CAT)) = CONCAT(b.L_CAT,b.M_CAT,b.S_CAT)";
    		
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
    		$query [] = " CONSULT_NO,";
    		$query [] = " REG_CODE,";
    		$query [] = " PROC_TYPE,";
    		$query [] = " TECH_L_CAT,";
    		$query [] = " TECH_M_CAT,";
    		$query [] = " TECH_S_CAT,";
    		$query [] = " TECH_NM,";
    		$query [] = " TECH_NM_JP,";
    		$query [] = " TECH_CONTENT,";
    		$query [] = " TECH_CONTENT_JP,";
    		$query [] = " TECH_COMMENT,";
    		$query [] = " TECH_COMMENT_JP,";
    		$query [] = " KEYWORD,";
    		$query [] = " KEYWORD_JP,";
    		$query [] = " TRADE_HOPE_TYPE,";
    		$query [] = " TRADE_HOPE_TYPE_ETC,";
    		$query [] = " STATE,";
    		$query [] = " OPEN_YN,";
    		$query [] = " WORKER_NO,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " TECH_NO,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE";
            $query [] = " FROM " . TBL_TECH_CONSULT;
            $query [] = " WHERE ";
            $query [] = " CONSULT_NO = '" . $p_consult_no . "'";
            $sql = $this->setQuery(join(PHP_EOL, $query));
            $tech_consult = $this->db->get($sql,"array");
            // 담당자 정보조회
            $worker = Worker::externalGet($this->db, array(p_worker_no=>$tech_consult[WORKER_NO]));
            
            @$this->oneRowToXML(array_merge($worker,$tech_consult),"item","fi");
            
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
        $p_consult_no = $argus[p_consult_no];
        
        $cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED ) ,0) + 1 FROM " . TBL_TECH_CONSULT
        		." WHERE PROC_TYPE = '" . PROC_TYPE_NC . "'"
        		." AND   SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)"
        );
        
        $reg_code =sprintf('%s%s%04d','KN',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !ADMIN ) throw new Exception("권한이 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_TECH_CONSULT;
            $query [] = "(";
    		$query [] = " REG_CODE,";
    		$query [] = " PROC_TYPE,";
    		$query [] = " TECH_L_CAT,";
    		$query [] = " TECH_M_CAT,";
    		$query [] = " TECH_S_CAT,";
    		$query [] = " TECH_NM,";
    		$query [] = " TECH_NM_JP,";
    		$query [] = " TECH_CONTENT,";
    		$query [] = " TECH_CONTENT_JP,";
    		$query [] = " TECH_COMMENT,";
    		$query [] = " TECH_COMMENT_JP,";
    		$query [] = " KEYWORD,";
    		$query [] = " KEYWORD_JP,";
    		$query [] = " TRADE_HOPE_TYPE,";
    		$query [] = " TRADE_HOPE_TYPE_ETC,";
    		$query [] = " STATE,";
    		$query [] = " OPEN_YN,";
//     		$query [] = " WORKER_NO,";
    		$query [] = " COMPANY_NO,";
//     		$query [] = " TECH_NO,";
    		$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $reg_code . "',";
    		$query [] = " '" . PROC_TYPE_NC . "',";
    		$query [] = " '" . $argus[tech_l_cat] . "',";
    		$query [] = " '" . $argus[tech_m_cat] . "',";
    		$query [] = " '" . $argus[tech_s_cat] . "',";
    		$query [] = " '" . $argus[tech_nm] . "',";
    		$query [] = " '" . $argus[tech_nm_jp] . "',";
    		$query [] = " '" . $argus[tech_content] . "',";
    		$query [] = " '" . $argus[tech_content_jp] . "',";
    		$query [] = " '" . $argus[tech_comment] . "',";
    		$query [] = " '" . $argus[tech_comment_jp] . "',";
    		$query [] = " '" . $argus[keyword] . "',";
    		$query [] = " '" . $argus[keyword_jp] . "',";
    		$query [] = " '" . $argus[trade_hope_type] . "',";
    		$query [] = " '" . $argus[trade_hope_type_etc] . "',";
    		$query [] = " '" . STATE_NC_REQUEST . "',";
    		$query [] = " 'N',";
//     		$query [] = " '" . $argus[worker_no] . "',";
    		$query [] = " '" . COMPANY_NO . "',";
//     		$query [] = " '" . $argus[tech_no] . "',";
            $query [] = " now() ";
            $query [] = " );";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
                $consult_no = $this->db->getInsertId(); // insert id 
                $this->appendNode("p_consult_no", $consult_no);
//                out.print($this->db->getAffectedRows());
                // 담당자정보 입력.
                $worker_no = Worker::externalInsert($this->db, $argus);
                if ( $worker_no > 0 ) {
	                $updateInfor = array();
	                $updateInfor[] = " WORKER_NO = '" . $worker_no . "'";
	                $this->exec(
	                		"UPDATE " .TBL_TECH_CONSULT . " SET"
	                		. join(",\n", $updateInfor)
	                		. " WHERE CONSULT_NO = '" .$consult_no . "'"
	                );	                
                } else {
                	throw new Exception("담당자정보 입력처리중 에러가 발생하였습니다.");
                }
                if ( !$this->db->commit() ) throw new Exception("입력처리중 에러가 발생하였습니다.");
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
            if ( !ADMIN ) throw new Exception("권한이 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_TECH_CONSULT;
            $query [] = " SET";
            $query [] = " TECH_L_CAT = '" . $argus[tech_l_cat] . "',";
            $query [] = " TECH_M_CAT = '" . $argus[tech_m_cat] . "',";
            $query [] = " TECH_S_CAT = '" . $argus[tech_s_cat] . "',";
            $query [] = " TECH_NM = '" . $argus[tech_nm] . "',";
            $query [] = " TECH_NM_JP = '" . $argus[tech_nm_jp] . "',";
            $query [] = " TECH_CONTENT = '" . $argus[tech_content] . "',";
            $query [] = " TECH_CONTENT_JP = '" . $argus[tech_content_jp] . "',";
            $query [] = " TECH_COMMENT = '" . $argus[tech_comment] . "',";
            $query [] = " TECH_COMMENT_JP = '" . $argus[tech_comment_jp] . "',";
            $query [] = " KEYWORD = '" . $argus[keyword] . "',";
            $query [] = " KEYWORD_JP = '" . $argus[keyword_jp] . "',";
            $query [] = " TRADE_HOPE_TYPE = '" . $argus[trade_hope_type] . "',";
            $query [] = " TRADE_HOPE_TYPE_ETC = '" . $argus[trade_hope_type_etc] . "',";
            $query [] = " STATE = '" . $argus[state] . "',";
            $query [] = " OPEN_YN = '" . $argus[open_yn] . "',";
//             $query [] = " WORKER_NO = '" . $argus[worker_no] . "',";
//             $query [] = " COMPANY_NO = '" . $argus[company_no] . "',";
//             $query [] = " TECH_NO = '" . $argus[tech_no] . "',";
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
     * 삭제
     * @param array $argus
     * @return boolean
     */
    public function delete($argus) {
        $p_consult_no = $argus[p_consult_no];
    
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
