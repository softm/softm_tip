<?php
define("DEBUG",preg_match("/^\/service\/classes/", $_SERVER[PHP_SELF]));
if ( DEBUG ) {
   require_once '../../lib/common.lib.inc' ; // 라이브러리
   require_once SERVICE_DIR . '/classes/common/Session.php'          ; // 세션 
}
require_once SERVICE_DIR . '/classes/BaseDataBase.php'; // 기본 DataBase 클래스
require_once SERVICE_DIR . '/classes/common/Util.php'; // Util클래스
require_once SERVICE_DIR . '/classes/common/Common.php'; // Common클래스
require_once SERVICE_DIR . '/classes/common/FileUpload.php'; // 파일업로드클래스
require_once 'lib/page_tab.lib.inc'            ; // page navigation
/**
 * @author softm
 * 비지니스상담/매칭 / Biz.php
 */
class Sample2 extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        
        $tbl1 = $this->newTable(TBL_MEMBER);
        $tbl1->newColumn('USER_NO'     ,'번호'  ,1)->setWidth(100)->setAlign("center")->setEditable(false);
        $tbl1->newColumn('USER_EMAIL'  ,'아이디',2)->setWidth(100)->setAlign("center")->setEditable(true);
        $tbl1->newColumn('USER_NAME'   ,'이름'  ,3)->setWidth(100)->setAlign("center")->setEditable(true);
        $tbl1->newColumn('USER_LEVEL'  ,'레벨'  ,4)->setWidth(100)->setEditable(true)->setType(Column::LISTBOX_TYPE);
        $tbl1->newColumn('PASSWD'      ,'비밀번호',4)->setWidth(100)->setEditable(true);
        $tbl1->newColumn('STATE'       ,'상태',1)->setWidth(100)->setEditable(true);
        
        $tbl2 = $this->newTable(TBL_COMPANY)->setTransaction(false);
        $tbl2->newColumn('COMPANY_NO'     ,'기업번호'  ,1)->setWidth(100)->setAlign("center")->setEditable(false);
        $tbl2->newColumn('COMPANY_NM_KR'  ,'기업명'    ,5)->setWidth(100)->setAlign("center")->setEditable(true);
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
       $p_user_id   = $argus[user_email  ];
    
       $this->testJsCall($argus);
       $this->startXML();
       try {

       } catch (Exception $e) {
           $this->addErrMessage($e->getMessage());
       }
       $this->printXML(C_DB_PROCESS_MODE_PROC);
    }
    
/**
 * 조회
 * @param array $argus
 * @return DOMDocument
 */
public function select($argus) {
	global $page_tab;	
//     $this->testJsCall($argus);
	$this->getCodeData();
    $this->startXML();
    $this->setType(BaseDataBase::GRID_TYPE);    
    try {
//         if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
        //var_dump($argus);
        $page_tab['js_function' ] = $argus["p_navi_function"];
        $page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
        if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];
        
        // where 문장생성
        $where = $this->makeWhere($argus);

        // row 갯수
        $page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_MEMBER . ( $where ? " WHERE " . $where:"" ) );
        
        $query = array();
        $query [] = " SELECT                            ";
        $query [] = "  a.USER_NO          USER_NO      ,";
        $query [] = "  a.USER_EMAIL       USER_EMAIL   ,";
        $query [] = "  a.USER_NAME        USER_NAME    ,";
        $query [] = "  a.USER_LEVEL       USER_LEVEL   ,";
        $query [] = "  a.STATE            STATE        ,";
        $query [] = "  b.COMPANY_NO       COMPANY_NO   ,";
        $query [] = "  b.COMPANY_NM_KR    COMPANY_NM_KR ";
        $query [] = " FROM TBL_MEMBER a LEFT OUTER JOIN tbl_company b ";
        $query [] = " ON a.USER_NO = b.USER_NO       ";
        
        // where 문장생성
		if ( $where ) $query[] = ( " WHERE " . $this->getWhere() );
		        
        $query[] =  ( $this->getQuerySort()?" ORDER BY ". $this->getQuerySort():'' );
        $query[] =  " LIMIT " . ( $page_tab['s'] - 1 ) . ", " . $cur_many;
        
        $this->setQuery(join("\n", $query));
//         out.print($this->getQuery());

// 		var_dump($this->getColumns());
		
        $this->makeItemXML($this->getQuery(),"item","fieldinfo");
//         out.print($this->db->getAffectedRows());        
        $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
    } catch (Exception $e) {
        $this->addErrMessage($e->getMessage());
    }
    $this->printXML(C_DB_PROCESS_MODE_PROC);
}

/**
 * 저장
 * @param array $argus
 * @return int
 */
public function save($argus) {
// 	var_dump($argus);
	$this->startXML();
	try {
// 	   	if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
	   	
	   	$table = $this->getTable(TBL_MEMBER);	   	
	   	$sql = $this->makeSaveQuery($table,$argus);
	   	if ( $sql ) {
		   	$this->db->setAutoCommit(false);
		   	$sql = $this->setQuery($sql);
		   	
			if ( $this->exec($this->getQuery()) ) {
// 				out.print($this->db->getAffectedRows());
				if ( !$this->db->commit() ) {
// 					throw new Exception($this->db->getErrMsg());
					throw new Exception("수정처리중 에러가 발생하였습니다.\n(" . $this->db->getErrMsg() .")");					
				}
			} else {
// 				throw new Exception($this->db->getErrMsg());
					throw new Exception("수정처리중 에러가 발생하였습니다.\n(" . $this->db->getErrMsg() .")");
			}
		}
		
		$table = $this->getTable(TBL_COMPANY);
		$sql = $this->makeSaveQuery($table,$argus);
		if ( $sql ) {
			$this->db->setAutoCommit(false);
			$sql = $this->setQuery($sql);
		
			if ( $this->exec($this->getQuery()) ) {
				// 				out.print($this->db->getAffectedRows());
				if ( !$this->db->commit() ) {
					// 					throw new Exception($this->db->getErrMsg());
					throw new Exception("수정처리중 에러가 발생하였습니다.\n(" . $this->db->getErrMsg() .")");
				}
			} else {
				// 				throw new Exception($this->db->getErrMsg());
				throw new Exception("수정처리중 에러가 발생하였습니다.\n(" . $this->db->getErrMsg() .")");
			}
		}		
	} catch (Exception $e) {
	   $this->addErrMessage($e->getMessage());
	}
	$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
	$this->printXML(C_DB_PROCESS_MODE_PROC);
}

/**
 * 입력
 * @param array $argus
 * @return int
 */
public function insert($argus) {
    $file_no1   = 0;
    $file_no2   = 0;
    $file_no3   = 0;
	
    $cnt = $this->db->getOne("SELECT COUNT(*) + 1 FROM " . TBL_BIZ_CONSULT ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
    //     	echo $cnt . "<BR>";
    $reg_code =sprintf('%s%s%04d','KB', date("Ymd"), $cnt);
    
    $this->testJsCall($argus);
    //$this->startXML();
    //try {
        if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
        $query = array();
        $query [] = "INSERT INTO " . TBL_BIZ_CONSULT;
        $query [] = "(";
//         $query [] = " CONSULT_NO,";
        $query [] = " REG_CODE,";
        $query [] = " PROC_TYPE,";
        $query [] = " COMPANY_NO,";
        $query [] = " STATE,";
        $query [] = " CONSULT_ITEM,";
        $query [] = " HOPE_BIZ_TYPE,";
        $query [] = " HOPE_BIZ,";
        $query [] = " HOPE_TRADE_TYPE,";
        $query [] = " OPEN_LIMIT,"; // DATA_OPEN_LIMIT1
        $query [] = " ETC_QUESTION,";
        $query [] = " FILE_NO1,";
        $query [] = " FILE_NO2,";
        $query [] = " FILE_NO3,";
        $query [] = " WORKER_NO,";
        $query [] = " ACTION_PLAN,";
        $query [] = " OPEN_YN,";
        $query [] = " REG_DATE ";
//         $query [] = " MOD_DATE";
        //$query [] = " REG_DATE ";
        $query [] = " ) VALUES (";
//         $query [] = " '" . $argus[consult_no] . "',";
        $query [] = " '" . $reg_code  . "',"; 
        $query [] = " '" . PROC_TYPE_BC . "',";  
//         $query [] = " '" . $COMPANY_NO . "',";
        $query [] = " '" . $argus[company_no] . "',";
        $query [] = " '" . STATE_BC_START . "',";
        $query [] = " '" . $argus[consult_item] . "',";
        $query [] = " '" . $argus[hope_biz_type] . "',";
        $query [] = " '" . $argus[hope_biz] . "',";
        $query [] = " '" . $argus[hope_trade_type] . "',";
        $query [] = " '" . $argus[open_limit] . "',";
        $query [] = " '" . $argus[etc_question] . "',";
        $query [] = " '" . $file_no1 . "',";
        $query [] = " '" . $file_no2 . "',";
        $query [] = " '" . $file_no3 . "',";
        $query [] = " '" . $argus[worker_no] . "',";
        $query [] = " '" . $argus[action_plan] . "',";
        $query [] = " '" . YN_N . "',";
        $query [] = " now() ";
//         $query [] = " '" . $argus[mod_date] . "'";
        $query [] = " );";
        $this->setQuery(join("\n", $query));
//         out.print($this->getQuery());
        $this->db->setAutoCommit(false);
        if ( $this->db->exec($this->getQuery()) ) {
//         	out.print($this->db->getAffectedRows());        	
        	$insert_id = $this->db->getInsertId();
            if ( $this->db->commit() ) return $insert_id;
            else return 0;
        } else {
//         	out.print($this->db->getErrMsg());
            return 0;
        //    throw new Exception("입력처리중 에러가 발생하였습니다.");
        }
    //} catch (Exception $e) {
    //    $this->addErrMessage($e->getMessage());
    //}
    //$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
    //$this->printXML(C_DB_PROCESS_MODE_PROC);
}

    
/**
 * 수정
 * @param array $argus
 * @return boolean
 */
public function update($argus) {
    $file_no1   = 0;
    $file_no2   = 0;
    $file_no3   = 0;
    
    $this->testJsCall($argus);
    //$this->startXML();
    //try {
    //    if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
        $query = array();
        $query [] = "UPDATE " . TBL_BIZ_CONSULT;
        $query [] = " SET";
//         $query [] = " CONSULT_NO = '" . $argus[consult_no] . "',";
//         $query [] = " REG_CODE = '" . $argus[reg_code] . "',";
//         $query [] = " PROC_TYPE = '" . $argus[proc_type] . "',";
//         $query [] = " COMPANY_NO = '" . $argus[company_no] . "',";
//         $query [] = " STATE = '" . $argus[state] . "',";
        $query [] = " CONSULT_ITEM = '" . $argus[consult_item] . "',";
        $query [] = " HOPE_BIZ_TYPE = '" . $argus[hope_biz_type] . "',";
        $query [] = " HOPE_BIZ = '" . $argus[hope_biz] . "',";
        $query [] = " HOPE_TRADE_TYPE = '" . $argus[hope_trade_type] . "',";
        $query [] = " OPEN_LIMIT = '" . $argus[open_limit] . "',";
        $query [] = " ETC_QUESTION = '" . $argus[etc_question] . "',";
        $query [] = " FILE_NO1 = '" . $file_no1 . "',";
        $query [] = " FILE_NO2 = '" . $file_no2 . "',";
        $query [] = " FILE_NO3 = '" . $file_no3 . "',";
        $query [] = " WORKER_NO = '" . $argus[worker_no] . "',";
        $query [] = " ACTION_PLAN = '" . $argus[action_plan] . "',";
        $query [] = " OPEN_YN = '" . $argus[open_yn] . "',";
//         $query [] = " REG_DATE = '" . $argus[reg_date] . "',";
        $query [] = " MOD_DATE = now()";
        $query [] = " WHERE ";
        $query [] = " CONSULT_NO = '" . $argus[consult_no] . "'";
        $this->setQuery(join("\n", $query));
//                 out.print($this->getQuery());        
        $this->db->setAutoCommit(false);
        if ( $this->db->exec($this->getQuery()) ) {
//         	out.print($this->db->getAffectedRows());        	
            if ( $this->db->commit() ) return true;
            else return false;
        } else {
//         	out.print($this->db->getErrMsg());        	
            return false;
        //    throw new Exception("수정처리중 에러가 발생하였습니다.");
        }
    //} catch (Exception $e) {
    //    $this->addErrMessage($e->getMessage());
    //}
    //$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
    //$this->printXML(C_DB_PROCESS_MODE_PROC);
}

    
/**
 * 삭제
 * @param array $argus
 * @return boolean
 */
public function delete($argus) {
    $p_user_id   = $argus[user_email  ];

    $this->testJsCall($argus);
    //$this->startXML();
    //try {
    //    if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
        $query = array();
        $query [] = "DELETE FROM " . TBL_BIZ_CONSULT;
        $query [] = " WHERE ";
        $query [] = "     CONSULT_NO = '" . $argus[consult_no] . "'";
        $query [] = " AND COMPANY_NO = '" . $argus[company_no] . "'";
        $this->setQuery(join("\n", $query));
//                 out.print($this->getQuery());     
        $this->db->setAutoCommit(false);
        if ( $this->db->exec($this->getQuery()) ) {
//         	out.print($this->db->getAffectedRows());        	
            if ( $this->db->commit() ) return true;
            else return false;
        } else {
//         	out.print($this->db->getErrMsg());        	
            return false;
        //    throw new Exception("삭제처리중 에러가 발생하였습니다.");
        }
    //} catch (Exception $e) {
    //    $this->addErrMessage($e->getMessage());
    //}
    //$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
    //$this->printXML(C_DB_PROCESS_MODE_PROC);
}

    
    /**
     * code를 array화한다.
     */
    public function getCodeData() {
       // CODE DATA 정의
        $this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
//         $this->addCodeData("SEX"       , self::$CODE_SEX       );
//         $this->addCodeData("STATE"     , self::$CODE_USER_STATE);
//         $this->addCodeData("EMAIL_YN"  , self::$CODE_YN    );
    }
}
if ( DEBUG ) {
   $test = new Sample2();
       
   /* test */
   $argus = array();
   $argus[user_email] = "test01";
   $test->setTableName(TBL_BIZ_CONSULT );
   $test->select($argus);
}
?>