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
/**
 * @author softm
 * 관심기업 / InterestCompany.php
 */
class InterestCompany extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_INTEREST_COMPANY);
			$tbl1->newColumn('COMPANY_NO','번호',1)->setWidth(50);
			$tbl1->newColumn('BIZ_FIELD','업종분야',2)->setType(Column::LISTBOX_TYPE)->setWidth(80);
// 			$tbl1->newColumn('BIZ_CLASSIFIED','업종분류',3)->setType(Column::LISTBOX_TYPE)->setWidth(80);
			$tbl1->newColumn('COMPANY_NM_KR','업체명',4)->setWidth(300)->setCssText("text-align:left;");
			$tbl1->newColumn('REG_DATE','등록일',5)->setWidth(100);
// 			$tbl1->newColumn("<BUTTON type='button'>매칭신청</button>",'수정/삭제'  ,9)->setDbColumn(false)->setWidth(100)->setHtml(true)->setAlias('BTN')->setType(Column::TEXT_TYPE);
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
    		if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
//    		var_dump($argus);
    		$page_tab['js_function' ] = $argus["p_navi_function"];
    		$page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
    		if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];

    		// where 문장생성
    		$make_where = $this->makeWhere($argus);
    		$where = " a.USER_NO = '" . USER_NO . "'";
    		$where .= $make_where?" AND " . $make_where:"";

    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_INTEREST_COMPANY . " a " . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		
    		$query [] = " SELECT ";
    		$query [] = " a.COMPANY_NO         COMPANY_NO        ,";
    		$query [] = " b.COMPANY_TYPE       COMPANY_TYPE      ,"; // 구분
    		$query [] = " b.BIZ_FIELD          BIZ_FIELD         ,"; // 업종분야
    		$query [] = " CASE WHEN b.BIZ_CLASSIFIED = 9 THEN b.BIZ_CLASSIFIED_ETC ELSE b.BIZ_CLASSIFIED END AS BIZ_CLASSIFIED,"; // 업종분류
    		$query [] = " b.COMPANY_NM_KR      COMPANY_NM_KR     ,"; // 업체명
    		$query [] = " DATE_FORMAT(a.REG_DATE,'%Y-%m-%d') REG_DATE"; // 등록일
    		$query [] = " FROM " . TBL_INTEREST_COMPANY . " a";
    		$query [] = " LEFT OUTER JOIN " . TBL_COMPANY . " b ON a.COMPANY_NO = b.COMPANY_NO ";
    		    		
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
        $p_company_no = $argus[p_company_no];
        $p_seq = $argus[p_seq];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " USER_NO,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE";
            $query [] = " FROM " . TBL_INTEREST_COMPANY;
            $query [] = " WHERE ";
            $query [] = " USER_NO = '" . $p_user_no . "' AND ";
            $query [] = " COMPANY_NO = '" . $p_company_no . "' AND ";
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
     * 관심기업 입력
     * @param array $argus
     * @return int
     */
    public function insert($argus) {
        $p_user_no = $argus[p_user_no];
        $p_company_no = $argus[p_company_no];
        $p_seq = $argus[p_seq];
    
        //$cnt = $this->db->getOne("SELECT COUNT(*) + 1 FROM " . TBL_INTEREST_COMPANY ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_INTEREST_COMPANY;
            $query [] = "(";
    		$query [] = " USER_NO,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " REG_DATE";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES ( ";
    		$query [] = " '" . USER_NO . "',";
    		$query [] = " '" . $p_company_no . "',";
            $query [] = " now() ";
            $query [] = " );";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
                $this->appendNode("p_user_no",$argus[user_no]); // insert key value 
                $this->appendNode("p_company_no",$argus[company_no]); // insert key value 
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
        $p_company_no = $argus[p_company_no];
        $p_seq = $argus[p_seq];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_INTEREST_COMPANY;
            $query [] = " SET";
            $query [] = " USER_NO = '" . $argus[user_no] . "',";
            $query [] = " COMPANY_NO = '" . $argus[company_no] . "',";
            $query [] = " SEQ = '" . $argus[seq] . "',";
            $query [] = " REG_DATE = '" . $argus[reg_date] . "',";
            $query [] = " MOD_DATE = '" . $argus[mod_date] . "'";
            //$query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " USER_NO = '" . $p_user_no . "' AND ";
            $query [] = " COMPANY_NO = '" . $p_company_no . "' AND ";
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
        $p_company_no = $argus[p_company_no];
        $p_seq = $argus[p_seq];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
            $query = array();
            $query [] = "DELETE FROM " . TBL_INTEREST_COMPANY;
            $query [] = " WHERE ";
            $query [] = " USER_NO = '" . $p_user_no . "' AND ";
            $query [] = " COMPANY_NO = '" . $p_company_no . "' AND ";
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
        }
        $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_DELETE)); // 성공시 출력 메시지.
        $this->printXML(C_DB_PROCESS_MODE_DELETE);
    }

    
    /**
     * code를 array화한다.
     */
    public function getCodeData() {
       // CODE DATA 정의
		$this->addCodeData("STATE", self::$CODE_STATE_BC);    		
		$this->addCodeData("BIZ_FIELD", self::$CODE_BIZ_FIELD);
		$this->addCodeData("BIZ_CLASSIFIED", self::$CODE_BIZ_CLASSIFIED);
		$this->addCodeData("COMPANY_TYPE", self::$CODE_COMPANY_TYPE);
    }
}
if ( DEBUG ) {
   // # test path : http://local-framework.com/InterestCompany.php
   $test = new InterestCompany();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_INTEREST_COMPANY );
   $test->test($argus);
/*

   // insert 
   $argus[user_no]  = 'data';
   $argus[company_no]  = 'data';
   $argus[seq]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[user_no]  = 'key';
   $argus[company_no]  = 'key';
   $argus[seq]  = 'key';
   // data field 
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[user_no]  = 'key';
   $argus[company_no]  = 'key';
   $argus[seq]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[user_no]  = 'key';
   $argus[company_no]  = 'key';
   $argus[seq]  = 'key';
   $test->select($argus); 

*/
}
?>
