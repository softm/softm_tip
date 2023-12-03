<?php
define("DEBUG",ereg("^/service/classes", $_SERVER[PHP_SELF]));
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
 * 관리자 Comment / ConsultAdminComment.php
 */
class ConsultAdminComment extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_CONSULT_ADMIN_COMMENT);
			$tbl1->newColumn('REG_DATE','등록일자',1)->setWidth(150)->setEditable(false)->setKey(false);
			$tbl1->newColumn('ADMIN_COMMENT','커멘트',2)->setWidth(450)->setEditable(false)->setAlign("left")->setKey(false)->setHtml(true);
			$tbl1->newColumn("<img src='/images/btn_ico_del.jpg' class=btn_delete>",'삭제'  ,3)
			->setDbColumn(false)->setWidth(100)->setHtml(true)->setAlias('BTN')->setType(Column::TEXT_TYPE);
			
    		$tbl1->newColumn('PROC_TYPE','처리형태',1)->setWidth(50)->setEditable(false)->setHide();
    		$tbl1->newColumn('CONSULT_NO','상담번호',2)->setWidth(50)->setEditable(false)->setHide();
    		$tbl1->newColumn('SEQ','순번',3)->setWidth(50)->setEditable(false)->setHide();
    		
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
    		$page_tab["how_many" ] = 1000;
    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_CONSULT_ADMIN_COMMENT . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " PROC_TYPE,";
    		$query [] = " CONSULT_NO,";
    		$query [] = " SEQ,";
    		$query [] = " CONCAT('',ADMIN_COMMENT,'') ADMIN_COMMENT,";
//     		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE";
    		$query [] = " FROM " . TBL_CONSULT_ADMIN_COMMENT;

    		// where 문장생성
    		if ( $where ) $query[] = ( " WHERE " . $where );

    		$query[] =  ( $this->getQuerySort()?" ORDER BY ". $this->getQuerySort():' ORDER BY REG_DATE DESC' );
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
        $p_proc_type = $argus[p_proc_type];
        $p_consult_no = $argus[p_consult_no];
        $p_seq = $argus[p_seq];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " PROC_TYPE,";
    		$query [] = " CONSULT_NO,";
    		$query [] = " SEQ,";
    		$query [] = " ADMIN_COMMENT,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE";
            $query [] = " FROM " . TBL_CONSULT_ADMIN_COMMENT;
            $query [] = " WHERE ";
            $query [] = " PROC_TYPE = '" . $p_proc_type . "' AND ";
            $query [] = " CONSULT_NO = '" . $p_consult_no . "' AND ";
            $query [] = " SEQ = '" . $p_seq . "'";
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
        $p_proc_type = $argus[p_proc_type];
        $p_consult_no = $argus[p_consult_no];
        $p_seq = $argus[p_seq];
    
        //$cnt = $this->db->getOne("SELECT COUNT(*) + 1 FROM " . TBL_CONSULT_ADMIN_COMMENT ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
    		if ( !ADMIN ) throw new Exception("관리자가 아닙니다.");  
            $query = array();
            $query [] = "INSERT INTO " . TBL_CONSULT_ADMIN_COMMENT;
            $query [] = "(";
    		$query [] = " PROC_TYPE,";
    		$query [] = " CONSULT_NO,";
    		$query [] = " SEQ,";
    		$query [] = " ADMIN_COMMENT,";
    		$query [] = " REG_DATE";
            $query [] = " ) SELECT ";
    		$query [] = " '" . $p_proc_type . "',";
    		$query [] = " '" . $p_consult_no . "',";
    		$query [] = " IFNULL(MAX(SEQ),0)+1,";
    		$query [] = " '" . $argus[admin_comment] . "',";
    		$query [] = " now()";
            $query [] = " FROM " . TBL_CONSULT_ADMIN_COMMENT;
            $query [] = " WHERE PROC_TYPE = '" . $p_proc_type . "'";
            $query [] = " AND   CONSULT_NO = '" . $p_consult_no . "'";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
                $this->appendNode("p_proc_type",$argus[proc_type]); // insert key value 
                $this->appendNode("p_consult_no",$argus[consult_no]); // insert key value 
                $this->appendNode("p_seq",$argus[seq]); // insert key value 
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
        $p_proc_type = $argus[p_proc_type];
        $p_consult_no = $argus[p_consult_no];
        $p_seq = $argus[p_seq];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
    		if ( !ADMIN ) throw new Exception("관리자가 아닙니다.");  
            $query = array();
            $query [] = "UPDATE " . TBL_CONSULT_ADMIN_COMMENT;
            $query [] = " SET";
            $query [] = " ADMIN_COMMENT = '" . $argus[admin_comment] . "',";
            $query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " PROC_TYPE = '" . $p_proc_type . "' AND ";
            $query [] = " CONSULT_NO = '" . $p_consult_no . "' AND ";
            $query [] = " SEQ = '" . $p_seq . "'";
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
        $p_proc_type = $argus[p_proc_type];
        $p_consult_no = $argus[p_consult_no];
        $p_seq = $argus[p_seq];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
    		if ( !ADMIN ) throw new Exception("관리자가 아닙니다.");  
            $query = array();
            $query [] = "DELETE FROM " . TBL_CONSULT_ADMIN_COMMENT;
            $query [] = " WHERE ";
            $query [] = " PROC_TYPE = '" . $p_proc_type . "' AND ";
            $query [] = " CONSULT_NO = '" . $p_consult_no . "' AND ";
            $query [] = " SEQ = '" . $p_seq . "'";
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
   // # test path : http://local-framework.com/ConsultAdminComment.php
   $test = new ConsultAdminComment();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_CONSULT_ADMIN_COMMENT );
   $test->test($argus);
/*

   // insert 
   $argus[proc_type]  = 'data';
   $argus[consult_no]  = 'data';
   $argus[seq]  = 'data';
   $argus[admin_comment]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[proc_type]  = 'key';
   $argus[consult_no]  = 'key';
   $argus[seq]  = 'key';
   // data field 
   $argus[admin_comment]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[proc_type]  = 'key';
   $argus[consult_no]  = 'key';
   $argus[seq]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[proc_type]  = 'key';
   $argus[consult_no]  = 'key';
   $argus[seq]  = 'key';
   $test->select($argus); 

*/
}
?>
