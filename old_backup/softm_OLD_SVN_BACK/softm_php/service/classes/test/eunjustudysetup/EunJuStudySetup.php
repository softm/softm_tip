<?php
define("DEBUG",preg_match("/^\/service\/classes/", $_SERVER[PHP_SELF]));
define("TBL_EUN_JU_STUDY_SETUP","calko.eun_ju_study_setup");
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
 * 은주학교설정정보 / EunJuStudySetup.php
 */
class EunJuStudySetup extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_EUN_JU_STUDY_SETUP);
//    		$tbl1->newColumn('VAL1','중간평가 배부일',0)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('VAL2','중간평가 회수일',0)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('VAL3','기말평가 배부일',0)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('VAL4','기말평가 회수일',0)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('VAL5','재적인원',0)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('AVG1','중간학년평균 - 국어',0)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('AVG2','중간학년평균 - 수학',0)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('AVG3','기말학년평균 - 국어',0)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('AVG4','기말학년평균 - 수학',0)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('USER_NO','사용자번호',1)->setWidth(50)->setEditable(false);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('USER_NO'   ,'회원명'     ,2)->setEditable(true);
//	        $tbl1->newColumn('USER_LEVEL','레벨'       ,3)->setType(Column::LISTBOX_TYPE)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('REG_DATE'  ,'가입일'     ,5)->setKey(false);
//			$tbl2 = $this->newTable(TBL_COMPANY)->setTransaction(false);
//			$tbl2->newColumn('COMPANY_NO'     ,'기업번호'  ,7)->setWidth(0)->setHide(true)->setAlign('center')->setEditable(false);
			$tbl1->newColumn("<img src='/service/images/btn_ico_modify.jpg' class=btn_modify><img src='/service/images/btn_ico_del.jpg' class=btn_delete>",'수정/삭제'  ,2)
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
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_EUN_JU_STUDY_SETUP . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " VAL1,";
    		$query [] = " VAL2,";
    		$query [] = " VAL3,";
    		$query [] = " VAL4,";
    		$query [] = " VAL5,";
    		$query [] = " AVG1,";
    		$query [] = " AVG2,";
    		$query [] = " AVG3,";
    		$query [] = " AVG4,";
    		$query [] = " USER_NO";
    		$query [] = " FROM " . TBL_EUN_JU_STUDY_SETUP;

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
        $p_user_no = $argus[p_user_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " VAL1,";
    		$query [] = " VAL2,";
    		$query [] = " VAL3,";
    		$query [] = " VAL4,";
    		$query [] = " VAL5,";
    		$query [] = " AVG1,";
    		$query [] = " AVG2,";
    		$query [] = " AVG3,";
    		$query [] = " AVG4,";
    		$query [] = " USER_NO";
            $query [] = " FROM " . TBL_EUN_JU_STUDY_SETUP;
            $query [] = " WHERE ";
            $query [] = " USER_NO = '" . $p_user_no . "'";
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
        $p_user_no = $argus[p_user_no];
    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_EUN_JU_STUDY_SETUP ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_EUN_JU_STUDY_SETUP;
            $query [] = "(";
    		$query [] = " VAL1,";
    		$query [] = " VAL2,";
    		$query [] = " VAL3,";
    		$query [] = " VAL4,";
    		$query [] = " VAL5,";
    		$query [] = " AVG1,";
    		$query [] = " AVG2,";
    		$query [] = " AVG3,";
    		$query [] = " AVG4,";
    		$query [] = " USER_NO";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[val1] . "',";
    		$query [] = " '" . $argus[val2] . "',";
    		$query [] = " '" . $argus[val3] . "',";
    		$query [] = " '" . $argus[val4] . "',";
    		$query [] = " '" . $argus[val5] . "',";
    		$query [] = " '" . $argus[avg1] . "',";
    		$query [] = " '" . $argus[avg2] . "',";
    		$query [] = " '" . $argus[avg3] . "',";
    		$query [] = " '" . $argus[avg4] . "',";
    		$query [] = " '" . $argus[user_no] . "'";
            //$query [] = " now() ";
            $query [] = " );";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
                $this->appendNode("p_user_no",$argus[user_no]); // insert key value 
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
        $p_user_no = $argus[p_user_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_EUN_JU_STUDY_SETUP;
            $query [] = " SET";
            $query [] = " VAL1 = '" . $argus[val1] . "',";
            $query [] = " VAL2 = '" . $argus[val2] . "',";
            $query [] = " VAL3 = '" . $argus[val3] . "',";
            $query [] = " VAL4 = '" . $argus[val4] . "',";
            $query [] = " VAL5 = '" . $argus[val5] . "',";
            $query [] = " AVG1 = '" . $argus[avg1] . "',";
            $query [] = " AVG2 = '" . $argus[avg2] . "',";
            $query [] = " AVG3 = '" . $argus[avg3] . "',";
            $query [] = " AVG4 = '" . $argus[avg4] . "',";
            $query [] = " USER_NO = '" . $argus[user_no] . "'";
            //$query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " USER_NO = '" . $p_user_no . "'";
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
        $p_user_no = $argus[p_user_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "DELETE FROM " . TBL_EUN_JU_STUDY_SETUP;
            $query [] = " WHERE ";
            $query [] = " USER_NO = '" . $p_user_no . "'";
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
   // # test path : http://local-framework.com/EunJuStudySetup.php
   $test = new EunJuStudySetup();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_EUN_JU_STUDY_SETUP );
   $test->test($argus);
/*

   // insert 
   $argus[val1]  = 'data';
   $argus[val2]  = 'data';
   $argus[val3]  = 'data';
   $argus[val4]  = 'data';
   $argus[val5]  = 'data';
   $argus[avg1]  = 'data';
   $argus[avg2]  = 'data';
   $argus[avg3]  = 'data';
   $argus[avg4]  = 'data';
   $argus[user_no]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[user_no]  = 'key';
   // data field 
   $argus[val1]  = 'data';
   $argus[val2]  = 'data';
   $argus[val3]  = 'data';
   $argus[val4]  = 'data';
   $argus[val5]  = 'data';
   $argus[avg1]  = 'data';
   $argus[avg2]  = 'data';
   $argus[avg3]  = 'data';
   $argus[avg4]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[user_no]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[user_no]  = 'key';
   $test->select($argus); 

*/
}
?>
