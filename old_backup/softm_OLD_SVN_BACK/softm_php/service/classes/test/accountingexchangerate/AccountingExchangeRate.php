<?php
define("DEBUG",preg_match("/^\/service\/classes/", $_SERVER[PHP_SELF]));
define("TBL_TBL_ACCOUNTING_EXCHANGE_RATE","calko.tbl_accounting_exchange_rate");
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
 * 회계년도별 환율정보 / AccountingExchangeRate.php
 */
class AccountingExchangeRate extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_TBL_ACCOUNTING_EXCHANGE_RATE);
    		$tbl1->newColumn('ACCOUNTING_NO','회계연도-번호',1)->setWidth(50)->setEditable(false);
    		$tbl1->newColumn('COUNTRY_CODE','국가코드',2)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('CLASS_NAME','코드 해당값(클래스명)',3)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('ACCOUNTING_YEAR','회계연도',4)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('MARGIN_RATE','Margin (%)',4)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('MARKUP_RATE','Markup (%)',4)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('SGNA_RATE','SG&A (%)',4)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('EXCHANGE_RATE','환율',4)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('USE_YN','사용유무',4)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('REG_DATE','등록일자',4)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('MOD_DATE','수정일자',4)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('REG_USER_ID','작성사용자아이디',5)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('MOD_USER_ID','수정사용자아이디',5)->setWidth(100)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('USER_NO'   ,'회원명'     ,2)->setEditable(true);
//	        $tbl1->newColumn('USER_LEVEL','레벨'       ,3)->setType(Column::LISTBOX_TYPE)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('REG_DATE'  ,'가입일'     ,5)->setKey(false);
//			$tbl2 = $this->newTable(TBL_COMPANY)->setTransaction(false);
//			$tbl2->newColumn('COMPANY_NO'     ,'기업번호'  ,7)->setWidth(0)->setHide(true)->setAlign('center')->setEditable(false);
			$tbl1->newColumn("<img src='/service/images/btn_ico_modify.jpg' class=btn_modify><img src='/service/images/btn_ico_del.jpg' class=btn_delete>",'수정/삭제'  ,6)
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
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_TBL_ACCOUNTING_EXCHANGE_RATE . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " ACCOUNTING_NO,";
    		$query [] = " COUNTRY_CODE,";
    		$query [] = " CLASS_NAME,";
    		$query [] = " ACCOUNTING_YEAR,";
    		$query [] = " MARGIN_RATE,";
    		$query [] = " MARKUP_RATE,";
    		$query [] = " SGNA_RATE,";
    		$query [] = " EXCHANGE_RATE,";
    		$query [] = " USE_YN,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE,";
    		$query [] = " REG_USER_ID,";
    		$query [] = " MOD_USER_ID";
    		$query [] = " FROM " . TBL_TBL_ACCOUNTING_EXCHANGE_RATE;

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
        $p_accounting_no = $argus[p_accounting_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " ACCOUNTING_NO,";
    		$query [] = " COUNTRY_CODE,";
    		$query [] = " CLASS_NAME,";
    		$query [] = " ACCOUNTING_YEAR,";
    		$query [] = " MARGIN_RATE,";
    		$query [] = " MARKUP_RATE,";
    		$query [] = " SGNA_RATE,";
    		$query [] = " EXCHANGE_RATE,";
    		$query [] = " USE_YN,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE,";
    		$query [] = " REG_USER_ID,";
    		$query [] = " MOD_USER_ID";
            $query [] = " FROM " . TBL_TBL_ACCOUNTING_EXCHANGE_RATE;
            $query [] = " WHERE ";
            $query [] = " ACCOUNTING_NO = '" . $p_accounting_no . "'";
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
        $p_accounting_no = $argus[p_accounting_no];
    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_TBL_ACCOUNTING_EXCHANGE_RATE ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_TBL_ACCOUNTING_EXCHANGE_RATE;
            $query [] = "(";
    		$query [] = " COUNTRY_CODE,";
    		$query [] = " CLASS_NAME,";
    		$query [] = " ACCOUNTING_YEAR,";
    		$query [] = " MARGIN_RATE,";
    		$query [] = " MARKUP_RATE,";
    		$query [] = " SGNA_RATE,";
    		$query [] = " EXCHANGE_RATE,";
    		$query [] = " USE_YN,";
    		$query [] = " REG_DATE,";
    		$query [] = " MOD_DATE,";
    		$query [] = " REG_USER_ID,";
    		$query [] = " MOD_USER_ID";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[country_code] . "',";
    		$query [] = " '" . $argus[class_name] . "',";
    		$query [] = " '" . $argus[accounting_year] . "',";
    		$query [] = " '" . $argus[margin_rate] . "',";
    		$query [] = " '" . $argus[markup_rate] . "',";
    		$query [] = " '" . $argus[sgna_rate] . "',";
    		$query [] = " '" . $argus[exchange_rate] . "',";
    		$query [] = " '" . $argus[use_yn] . "',";
    		$query [] = " '" . $argus[reg_date] . "',";
    		$query [] = " '" . $argus[mod_date] . "',";
    		$query [] = " '" . $argus[reg_user_id] . "',";
    		$query [] = " '" . $argus[mod_user_id] . "'";
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
        $p_accounting_no = $argus[p_accounting_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_TBL_ACCOUNTING_EXCHANGE_RATE;
            $query [] = " SET";
            $query [] = " ACCOUNTING_NO = '" . $argus[accounting_no] . "',";
            $query [] = " COUNTRY_CODE = '" . $argus[country_code] . "',";
            $query [] = " CLASS_NAME = '" . $argus[class_name] . "',";
            $query [] = " ACCOUNTING_YEAR = '" . $argus[accounting_year] . "',";
            $query [] = " MARGIN_RATE = '" . $argus[margin_rate] . "',";
            $query [] = " MARKUP_RATE = '" . $argus[markup_rate] . "',";
            $query [] = " SGNA_RATE = '" . $argus[sgna_rate] . "',";
            $query [] = " EXCHANGE_RATE = '" . $argus[exchange_rate] . "',";
            $query [] = " USE_YN = '" . $argus[use_yn] . "',";
            $query [] = " REG_DATE = '" . $argus[reg_date] . "',";
            $query [] = " MOD_DATE = '" . $argus[mod_date] . "',";
            $query [] = " REG_USER_ID = '" . $argus[reg_user_id] . "',";
            $query [] = " MOD_USER_ID = '" . $argus[mod_user_id] . "'";
            //$query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " ACCOUNTING_NO = '" . $p_accounting_no . "'";
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
        $p_accounting_no = $argus[p_accounting_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "DELETE FROM " . TBL_TBL_ACCOUNTING_EXCHANGE_RATE;
            $query [] = " WHERE ";
            $query [] = " ACCOUNTING_NO = '" . $p_accounting_no . "'";
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
   // # test path : http://local-framework.com/AccountingExchangeRate.php
   $test = new AccountingExchangeRate();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_TBL_ACCOUNTING_EXCHANGE_RATE );
   $test->test($argus);
/*

   // insert 
   $argus[accounting_no]  = 'data';
   $argus[country_code]  = 'data';
   $argus[class_name]  = 'data';
   $argus[accounting_year]  = 'data';
   $argus[margin_rate]  = 'data';
   $argus[markup_rate]  = 'data';
   $argus[sgna_rate]  = 'data';
   $argus[exchange_rate]  = 'data';
   $argus[use_yn]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   $argus[reg_user_id]  = 'data';
   $argus[mod_user_id]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[accounting_no]  = 'key';
   // data field 
   $argus[country_code]  = 'data';
   $argus[class_name]  = 'data';
   $argus[accounting_year]  = 'data';
   $argus[margin_rate]  = 'data';
   $argus[markup_rate]  = 'data';
   $argus[sgna_rate]  = 'data';
   $argus[exchange_rate]  = 'data';
   $argus[use_yn]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   $argus[reg_user_id]  = 'data';
   $argus[mod_user_id]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[accounting_no]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[accounting_no]  = 'key';
   $test->select($argus); 

*/
}
?>
