<?php
define("DEBUG",preg_match("/^\/service\/classes/", $_SERVER[PHP_SELF]));
define("TBL_TBL_CALKO_HEADER","calko.tbl_calko_header");
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
 * Characteristic - Header / CalkoHeader.php
 */
class CalkoHeader extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_TBL_CALKO_HEADER);
    		$tbl1->newColumn('ESTI_NO','....',1)->setWidth(50)->setEditable(false);
//    		$tbl1->newColumn('QUOTATION_DATE','QUOTATION_DATE',1)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('EXPECTED_DELIVERY_DATE','EXPECTED_DELIVERY_DATE',1)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('SALES_IN_CHARGE','SALES_IN_CHARGE',1)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('NAME_OF_CLIENT','NAME_OF_CLIENT',1)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('PROJECT_NAME','PROJECT_NAME',1)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('COUNTRY_CODE','....',1)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('DESTINATION','DESTINATION',1)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('SOLD_TO_PARTY','SOLD_TO_PARTY',1)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('STATE','사용상태 : 0:초기, 1:CRC요청, 2:CRC수신, 3:저장, 8:TP전송, P:Processing, S:TP성공완료, E:TP에러완료',1)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('REG_DATE','....',1)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('REG_USER_ID','........',2)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('REG_USER_EMAIL','........',3)->setWidth(100)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('USER_NO'   ,'회원명'     ,2)->setEditable(true);
//	        $tbl1->newColumn('USER_LEVEL','레벨'       ,3)->setType(Column::LISTBOX_TYPE)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('REG_DATE'  ,'가입일'     ,5)->setKey(false);
//			$tbl2 = $this->newTable(TBL_COMPANY)->setTransaction(false);
//			$tbl2->newColumn('COMPANY_NO'     ,'기업번호'  ,7)->setWidth(0)->setHide(true)->setAlign('center')->setEditable(false);
			$tbl1->newColumn("<img src='/service/images/btn_ico_modify.jpg' class=btn_modify><img src='/service/images/btn_ico_del.jpg' class=btn_delete>",'수정/삭제'  ,4)
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
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_TBL_CALKO_HEADER . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " ESTI_NO,";
    		$query [] = " QUOTATION_DATE,";
    		$query [] = " EXPECTED_DELIVERY_DATE,";
    		$query [] = " SALES_IN_CHARGE,";
    		$query [] = " NAME_OF_CLIENT,";
    		$query [] = " PROJECT_NAME,";
    		$query [] = " COUNTRY_CODE,";
    		$query [] = " DESTINATION,";
    		$query [] = " SOLD_TO_PARTY,";
    		$query [] = " STATE,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " REG_USER_ID,";
    		$query [] = " REG_USER_EMAIL";
    		$query [] = " FROM " . TBL_TBL_CALKO_HEADER;

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
        $p_esti_no = $argus[p_esti_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " ESTI_NO,";
    		$query [] = " QUOTATION_DATE,";
    		$query [] = " EXPECTED_DELIVERY_DATE,";
    		$query [] = " SALES_IN_CHARGE,";
    		$query [] = " NAME_OF_CLIENT,";
    		$query [] = " PROJECT_NAME,";
    		$query [] = " COUNTRY_CODE,";
    		$query [] = " DESTINATION,";
    		$query [] = " SOLD_TO_PARTY,";
    		$query [] = " STATE,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " REG_USER_ID,";
    		$query [] = " REG_USER_EMAIL";
            $query [] = " FROM " . TBL_TBL_CALKO_HEADER;
            $query [] = " WHERE ";
            $query [] = " ESTI_NO = '" . $p_esti_no . "'";
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
        $p_esti_no = $argus[p_esti_no];
    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_TBL_CALKO_HEADER ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_TBL_CALKO_HEADER;
            $query [] = "(";
    		$query [] = " ESTI_NO,";
    		$query [] = " QUOTATION_DATE,";
    		$query [] = " EXPECTED_DELIVERY_DATE,";
    		$query [] = " SALES_IN_CHARGE,";
    		$query [] = " NAME_OF_CLIENT,";
    		$query [] = " PROJECT_NAME,";
    		$query [] = " COUNTRY_CODE,";
    		$query [] = " DESTINATION,";
    		$query [] = " SOLD_TO_PARTY,";
    		$query [] = " STATE,";
    		$query [] = " REG_DATE,";
    		$query [] = " REG_USER_ID,";
    		$query [] = " REG_USER_EMAIL";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[esti_no] . "',";
    		$query [] = " '" . $argus[quotation_date] . "',";
    		$query [] = " '" . $argus[expected_delivery_date] . "',";
    		$query [] = " '" . $argus[sales_in_charge] . "',";
    		$query [] = " '" . $argus[name_of_client] . "',";
    		$query [] = " '" . $argus[project_name] . "',";
    		$query [] = " '" . $argus[country_code] . "',";
    		$query [] = " '" . $argus[destination] . "',";
    		$query [] = " '" . $argus[sold_to_party] . "',";
    		$query [] = " '" . $argus[state] . "',";
    		$query [] = " '" . $argus[reg_date] . "',";
    		$query [] = " '" . $argus[reg_user_id] . "',";
    		$query [] = " '" . $argus[reg_user_email] . "'";
            //$query [] = " now() ";
            $query [] = " );";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
                $this->appendNode("p_esti_no",$argus[esti_no]); // insert key value 
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
        $p_esti_no = $argus[p_esti_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_TBL_CALKO_HEADER;
            $query [] = " SET";
            $query [] = " ESTI_NO = '" . $argus[esti_no] . "',";
            $query [] = " QUOTATION_DATE = '" . $argus[quotation_date] . "',";
            $query [] = " EXPECTED_DELIVERY_DATE = '" . $argus[expected_delivery_date] . "',";
            $query [] = " SALES_IN_CHARGE = '" . $argus[sales_in_charge] . "',";
            $query [] = " NAME_OF_CLIENT = '" . $argus[name_of_client] . "',";
            $query [] = " PROJECT_NAME = '" . $argus[project_name] . "',";
            $query [] = " COUNTRY_CODE = '" . $argus[country_code] . "',";
            $query [] = " DESTINATION = '" . $argus[destination] . "',";
            $query [] = " SOLD_TO_PARTY = '" . $argus[sold_to_party] . "',";
            $query [] = " STATE = '" . $argus[state] . "',";
            $query [] = " REG_DATE = '" . $argus[reg_date] . "',";
            $query [] = " REG_USER_ID = '" . $argus[reg_user_id] . "',";
            $query [] = " REG_USER_EMAIL = '" . $argus[reg_user_email] . "'";
            //$query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " ESTI_NO = '" . $p_esti_no . "'";
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
        $p_esti_no = $argus[p_esti_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "DELETE FROM " . TBL_TBL_CALKO_HEADER;
            $query [] = " WHERE ";
            $query [] = " ESTI_NO = '" . $p_esti_no . "'";
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
   // # test path : http://local-framework.com/CalkoHeader.php
   $test = new CalkoHeader();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_TBL_CALKO_HEADER );
   $test->test($argus);
/*

   // insert 
   $argus[esti_no]  = 'data';
   $argus[quotation_date]  = 'data';
   $argus[expected_delivery_date]  = 'data';
   $argus[sales_in_charge]  = 'data';
   $argus[name_of_client]  = 'data';
   $argus[project_name]  = 'data';
   $argus[country_code]  = 'data';
   $argus[destination]  = 'data';
   $argus[sold_to_party]  = 'data';
   $argus[state]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[reg_user_id]  = 'data';
   $argus[reg_user_email]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[esti_no]  = 'key';
   // data field 
   $argus[quotation_date]  = 'data';
   $argus[expected_delivery_date]  = 'data';
   $argus[sales_in_charge]  = 'data';
   $argus[name_of_client]  = 'data';
   $argus[project_name]  = 'data';
   $argus[country_code]  = 'data';
   $argus[destination]  = 'data';
   $argus[sold_to_party]  = 'data';
   $argus[state]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[reg_user_id]  = 'data';
   $argus[reg_user_email]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[esti_no]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[esti_no]  = 'key';
   $test->select($argus); 

*/
}
?>
