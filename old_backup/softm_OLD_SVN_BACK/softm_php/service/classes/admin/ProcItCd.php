<?php
define("DEBUG",preg_match("/\/service\/classes/", $_SERVER[PHP_SELF]));
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
 * 공정항목코드 / ProcItCd.php
 */
class ProcItCd extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_PROC_IT_CD);
			$seq = 0;
			
			// 대공정코드
			// 대공정명
			// 공정항목코드
			// 공정항목명
			// 등록정보
			// 삭제
			$tbl1->newColumn('PROC_IT_CD_NO','공정항목코드번호',++$seq)->setHide(true);			
    		$tbl1->newColumn('PROC_CD','대공정코드',++$seq)->setWidth(170)->setEditable(false)->setKey(false);
    		$tbl1->newColumn('PROC_NM','대공정명',++$seq)->setWidth(230)->setAlign("left")->setEditable(false)->setKey(false);
    		$tbl1->newColumn('PROC_IT_CD','공정항목코드',++$seq)->setWidth(250)->setEditable(true)->setKey(false);
    		$tbl1->newColumn('PROC_IT_NM','공정항목코드명',++$seq)->setWidth(400)->setAlign("left")->setEditable(true)->setKey(false);
 			$tbl1->newColumn("btn_reg_cnt"     ,'등록정보'  ,++$seq)->setWidth(120)->setHtml(true)->setSortable(false)->setType(Column::TEXT_TYPE)
 			->setValue("<a class='btn_reg_cnt' >보기</a>");

    		    		
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,++$seq)->setAlign('center');
//	        $tbl1->newColumn('USER_NO'   ,'회원명'     ,++$seq)->setEditable(true);
//	        $tbl1->newColumn('USER_LEVEL','레벨'       ,++$seq)->setType(Column::LISTBOX_TYPE)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,++$seq)->setAlign('center');
//	        $tbl1->newColumn('REG_DATE'  ,'가입일'     ,++$seq)->setKey(false);
//			$tbl2 = $this->newTable(TBL_COMPANY)->setTransaction(false);
//			$tbl2->newColumn('COMPANY_NO'     ,'기업번호'  ,7)->setWidth(0)->setHide(true)->setAlign('center')->setEditable(false);
// 			$tbl1->newColumn("<a class='btn_edit btn_modify' >수정</a>",'수정'  ,++$seq)->setDbColumn(false)->setWidth(100)->setHtml(true)->setAlias('BTN1')->setType(Column::TEXT_TYPE);
 			$tbl1->newColumn("BTN2"     ,'삭제'  ,++$seq)->setWidth(120)->setHtml(true)->setSortable(false)->setType(Column::TEXT_TYPE)
 			->setValue("<a class='btn_edit btn_delete' >삭제</a>");

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
       $this->startHeader();
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
    	$this->startHeader();
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
    		if ( $argus[p_proc_cd] ) {
    			$where .= " AND a.PROC_CD = '" . $argus[p_proc_cd] . "'";
    		}
    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_PROC_IT_CD . " a " . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		// 대공정코드
    		// 대공정명
    		// 공정항목코드
    		// 공정항목명
    		// 등록정보
    		// 삭제
    		$query [] = " SELECT ";
    		$query [] = "    a.PROC_IT_CD_NO    PROC_IT_CD_NO ";
    		$query [] = "  , a.PROC_CD    PROC_CD   ";
    		$query [] = "  , b.PROC_NM    PROC_NM   ";
    		$query [] = "  , a.PROC_IT_CD PROC_IT_CD";
    		$query [] = "  , a.PROC_IT_NM PROC_IT_NM";
    		$query [] = " FROM " . TBL_PROC_IT_CD   . " a";
    		$query [] = " LEFT JOIN " . TBL_PROC_CD      . " b";
    		$query [] = "   ON a.PROC_CD = b.PROC_CD ";

    		// where 문장생성
    		if ( $where ) $query[] = ( " WHERE " . $where );

    		$query[] =  ( $this->getQuerySort()?" ORDER BY ". $this->getQuerySort():' ORDER BY a.PROC_IT_CD_NO ASC' );
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
        $p_proc_it_cd_no = $argus[p_proc_it_cd_no];
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " PROC_IT_CD_NO,";
    		$query [] = " PROC_IT_CD,";
    		$query [] = " PROC_IT_NM,";
    		$query [] = " PROC_CD";
            $query [] = " FROM " . TBL_PROC_IT_CD;
            $query [] = " WHERE ";
            $query [] = " PROC_IT_CD_NO = '" . $p_proc_it_cd_no . "'";
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
        $p_proc_it_cd_no = $argus[p_proc_it_cd_no];
    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_PROC_IT_CD ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_PROC_IT_CD;
            $query [] = "(";
    		$query [] = " PROC_IT_CD,";
    		$query [] = " PROC_IT_NM,";
    		$query [] = " PROC_CD";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[proc_it_cd] . "',";
    		$query [] = " '" . $argus[proc_it_nm] . "',";
    		$query [] = " '" . $argus[p_proc_cd] . "'";
            //$query [] = " now() ";
            $query [] = " );";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
                $insert_id = $this->db->getInsertId(); // insert id 
                $this->appendNode("insert_id", $insert_id);
                $this->exec(" UPDATE " . TBL_PROC_IT_CD
                		  . " SET PROC_IT_CD = '" . $insert_id . "'"
                		  . " WHERE PROC_IT_CD_NO = '" . $insert_id . "'"  
                );
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
    	$p_proc_it_cd_no = $argus[p_proc_it_cd_no];
    
    	$this->testJsCall($argus);
    	$this->startHeader();
    	try {
    		if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
    		$query = array();
    		$query [] = "UPDATE " . TBL_PROC_IT_CD;
    		$query [] = " SET";
    		$query [] = " PROC_IT_CD_NO = '" . $argus[proc_it_cd_no] . "',";
    		$query [] = " PROC_IT_CD = '" . $argus[proc_it_cd] . "',";
    		$query [] = " PROC_IT_NM = '" . $argus[proc_it_nm] . "',";
    		$query [] = " PROC_CD = '" . $argus[proc_cd] . "'";
    		//$query [] = " MOD_DATE = now()";
    		$query [] = " WHERE ";
    		$query [] = " PROC_IT_CD_NO = '" . $p_proc_it_cd_no . "'";
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
    	$p_proc_it_cd_no = $argus[p_proc_it_cd_no];
    
    	$this->testJsCall($argus);
    	$this->startHeader();
    	try {
    		if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
    		$query = array();
    		$query [] = "DELETE FROM " . TBL_PROC_IT_CD;
    		$query [] = " WHERE ";
    		$query [] = " PROC_IT_CD_NO = '" . $p_proc_it_cd_no . "'";
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
     * 저장
     * @param array $argus
     * @return string
     */
    public function save($argus) {
    	$p_mode       = $argus['mode'][0];
    	$p_user_no    = $argus[user_no_o][0];
    	$p_company_no = $argus[company_no_o][0];
    	if (parent::save($argus,false)) {
    		$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
    	} else {
    		$this->addErrMessage("공정항목코드를 확인하세요.");
    	}
    	$this->printXML(C_DB_PROCESS_MODE_PROC);
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
   // # test path : http://local-mj.com/ProcItCd.php
   $test = new ProcItCd();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_PROC_IT_CD );
   $test->test($argus);
/*

   // insert 
   $argus[proc_it_cd]  = 'data';
   $argus[proc_it_nm]  = 'data';
   $argus[proc_cd]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[proc_it_cd]  = 'key';
   // data field 
   $argus[proc_it_nm]  = 'data';
   $argus[proc_cd]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[proc_it_cd]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[proc_it_cd]  = 'key';
   $test->select($argus); 

*/
}
?>
