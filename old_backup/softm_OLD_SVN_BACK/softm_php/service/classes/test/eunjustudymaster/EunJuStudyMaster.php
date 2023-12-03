<?php
define("DEBUG",preg_match("/^\/service\/classes/", $_SERVER[PHP_SELF]));
define("TBL_EUN_JU_STUDY_MASTER","calko.eun_ju_study_master");
if ( DEBUG ) {
   require_once '../../../lib/common.lib.inc' ; // 라이브러리
   require_once SERVICE_DIR . '/classes/common/Session.php'          ; // 세션 
}
require_once SERVICE_DIR . '/classes/BaseDataBase.php'; // 기본 DataBase 클래스
require_once SERVICE_DIR . '/classes/common/Util.php'; // Util클래스
require_once SERVICE_DIR . '/classes/common/Common.php'; // Common클래스
require_once SERVICE_DIR . '/classes/common/FileUpload.php'; // 파일업로드클래스
/**
 * @author softm
 * 은주학교점수정보 / EunJuStudyMaster.php
 */
class EunJuStudyMaster extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_EUN_JU_STUDY_MASTER);
    		$tbl1->newColumn('S_ID','STUDY ID',1)->setWidth(50)->setEditable(false);
    		$tbl1->newColumn('YYYY','년도',2)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('TERM','학기(1,2)',3)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('GUBUN','중간(1)/기말(2)',4)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('HAK','학년',5)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('BAN','반',6)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('NUM','번호',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('MEM_NAME','학생명',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('SEX','남(M)/여(F)',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('RESULT_1','국어점수',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('RESULT_2','수학점수',7)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('REG_DATE','작성일자',8)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('CONTENT','가정통신',8)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('USER_NO','사용자번호',9)->setWidth(100)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('USER_NO'   ,'회원명'     ,2)->setEditable(true);
//	        $tbl1->newColumn('USER_LEVEL','레벨'       ,3)->setType(Column::LISTBOX_TYPE)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('REG_DATE'  ,'가입일'     ,5)->setKey(false);
//			$tbl2 = $this->newTable(TBL_COMPANY)->setTransaction(false);
//			$tbl2->newColumn('COMPANY_NO'     ,'기업번호'  ,7)->setWidth(0)->setHide(true)->setAlign('center')->setEditable(false);
			$tbl1->newColumn("<img src='/service/images/btn_ico_modify.jpg' class=btn_modify><img src='/service/images/btn_ico_del.jpg' class=btn_delete>",'수정/삭제'  ,10)
				 ->setDbColumn(false)->setWidth(100)->setHtml(true)->setAlias('BTN')->setType(Column::TEXT_TYPE);
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
    	//     $this->testJsCall($argus);
//    	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
    	$this->getCodeData(); // code xml 생성
    	$this->startXML();
    	$this->setType(BaseDataBase::GRID_TYPE);
    	try {
    		if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
//    		var_dump($argus);
    		$page_tab['js_function' ] = $argus["p_navi_function"];
    		$page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
    		if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];

    		// where 문장생성
    		$make_where = $this->makeWhere($argus);
    		$where = $make_where;

    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_EUN_JU_STUDY_MASTER . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " S_ID,";
    		$query [] = " YYYY,";
    		$query [] = " TERM,";
    		$query [] = " GUBUN,";
    		$query [] = " HAK,";
    		$query [] = " BAN,";
    		$query [] = " NUM,";
    		$query [] = " MEM_NAME,";
    		$query [] = " SEX,";
    		$query [] = " RESULT_1,";
    		$query [] = " RESULT_2,";
    		$query [] = " REG_DATE,";
    		$query [] = " CONTENT,";
    		$query [] = " USER_NO";
    		$query [] = " FROM " . TBL_EUN_JU_STUDY_MASTER;

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
        $p_s_id = $argus[p_s_id];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " S_ID,";
    		$query [] = " YYYY,";
    		$query [] = " TERM,";
    		$query [] = " GUBUN,";
    		$query [] = " HAK,";
    		$query [] = " BAN,";
    		$query [] = " NUM,";
    		$query [] = " MEM_NAME,";
    		$query [] = " SEX,";
    		$query [] = " RESULT_1,";
    		$query [] = " RESULT_2,";
    		$query [] = " REG_DATE,";
    		$query [] = " CONTENT,";
    		$query [] = " USER_NO";
            $query [] = " FROM " . TBL_EUN_JU_STUDY_MASTER;
            $query [] = " WHERE ";
            $query [] = " S_ID = '" . $p_s_id . "'";
            $this->setQuery(join(PHP_EOL, $query));
    //         out.print($this->getQuery());
            $this->makeItemXML($this->getQuery(),"item","fi");
    //         	out.print($this->db->getAffectedRows());
    //         	out.print($this->db->getErrMsg());
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
        $p_s_id = $argus[p_s_id];
    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_EUN_JU_STUDY_MASTER ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_EUN_JU_STUDY_MASTER;
            $query [] = "(";
    		$query [] = " YYYY,";
    		$query [] = " TERM,";
    		$query [] = " GUBUN,";
    		$query [] = " HAK,";
    		$query [] = " BAN,";
    		$query [] = " NUM,";
    		$query [] = " MEM_NAME,";
    		$query [] = " SEX,";
    		$query [] = " RESULT_1,";
    		$query [] = " RESULT_2,";
    		$query [] = " REG_DATE,";
    		$query [] = " CONTENT,";
    		$query [] = " USER_NO";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[yyyy] . "',";
    		$query [] = " '" . $argus[term] . "',";
    		$query [] = " '" . $argus[gubun] . "',";
    		$query [] = " '" . $argus[hak] . "',";
    		$query [] = " '" . $argus[ban] . "',";
    		$query [] = " '" . $argus[num] . "',";
    		$query [] = " '" . $argus[mem_name] . "',";
    		$query [] = " '" . $argus[sex] . "',";
    		$query [] = " '" . $argus[result_1] . "',";
    		$query [] = " '" . $argus[result_2] . "',";
    		$query [] = " '" . $argus[reg_date] . "',";
    		$query [] = " '" . $argus[content] . "',";
    		$query [] = " '" . $argus[user_no] . "'";
            //$query [] = " now() ";
            $query [] = " );";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
                $insert_id = $this->db->getInsertId(); // insert id 
                $this->appendNode("insert_id", $insert_id);
//                out.print($this->db->getAffectedRows());
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
        $p_s_id = $argus[p_s_id];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_EUN_JU_STUDY_MASTER;
            $query [] = " SET";
            $query [] = " S_ID = '" . $argus[s_id] . "',";
            $query [] = " YYYY = '" . $argus[yyyy] . "',";
            $query [] = " TERM = '" . $argus[term] . "',";
            $query [] = " GUBUN = '" . $argus[gubun] . "',";
            $query [] = " HAK = '" . $argus[hak] . "',";
            $query [] = " BAN = '" . $argus[ban] . "',";
            $query [] = " NUM = '" . $argus[num] . "',";
            $query [] = " MEM_NAME = '" . $argus[mem_name] . "',";
            $query [] = " SEX = '" . $argus[sex] . "',";
            $query [] = " RESULT_1 = '" . $argus[result_1] . "',";
            $query [] = " RESULT_2 = '" . $argus[result_2] . "',";
            $query [] = " REG_DATE = '" . $argus[reg_date] . "',";
            $query [] = " CONTENT = '" . $argus[content] . "',";
            $query [] = " USER_NO = '" . $argus[user_no] . "'";
            //$query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " S_ID = '" . $p_s_id . "'";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
//                out.print($this->db->getAffectedRows());
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
        $p_s_id = $argus[p_s_id];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "DELETE FROM " . TBL_EUN_JU_STUDY_MASTER;
            $query [] = " WHERE ";
            $query [] = " S_ID = '" . $p_s_id . "'";
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
   // # test path : http://local-framework.com/EunJuStudyMaster.php
   $test = new EunJuStudyMaster();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_EUN_JU_STUDY_MASTER );
   $test->test($argus);
/*

   // insert 
   $argus[s_id]  = 'data';
   $argus[yyyy]  = 'data';
   $argus[term]  = 'data';
   $argus[gubun]  = 'data';
   $argus[hak]  = 'data';
   $argus[ban]  = 'data';
   $argus[num]  = 'data';
   $argus[mem_name]  = 'data';
   $argus[sex]  = 'data';
   $argus[result_1]  = 'data';
   $argus[result_2]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[content]  = 'data';
   $argus[user_no]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[s_id]  = 'key';
   // data field 
   $argus[yyyy]  = 'data';
   $argus[term]  = 'data';
   $argus[gubun]  = 'data';
   $argus[hak]  = 'data';
   $argus[ban]  = 'data';
   $argus[num]  = 'data';
   $argus[mem_name]  = 'data';
   $argus[sex]  = 'data';
   $argus[result_1]  = 'data';
   $argus[result_2]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[content]  = 'data';
   $argus[user_no]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[s_id]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[s_id]  = 'key';
   $test->select($argus); 

*/
}
?>
