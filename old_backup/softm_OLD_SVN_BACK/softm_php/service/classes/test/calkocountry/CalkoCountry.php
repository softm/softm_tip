<?php
define("DEBUG",preg_match("/^\/service\/classes/", $_SERVER[PHP_SELF]));
define("TBL_TBL_CALKO_COUNTRY","calko.tbl_calko_country");
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
 * Country Code / CalkoCountry.php
 */
class CalkoCountry extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_TBL_CALKO_COUNTRY);
    		$tbl1->newColumn('COUNTRY_CODE','....',1)->setWidth(50)->setEditable(false);
//    		$tbl1->newColumn('COUNTRY_EN_NAME','.....',1)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('COUNTRY_KR_NAME','.....',1)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('DESTINATION','DESTINATION',2)->setWidth(50)->setEditable(false);
//    		$tbl1->newColumn('SOLD_TO_PARTY','SOLD_TO_PARTY',2)->setWidth(100)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('USER_NO'   ,'회원명'     ,2)->setEditable(true);
//	        $tbl1->newColumn('USER_LEVEL','레벨'       ,3)->setType(Column::LISTBOX_TYPE)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('REG_DATE'  ,'가입일'     ,5)->setKey(false);
//			$tbl2 = $this->newTable(TBL_COMPANY)->setTransaction(false);
//			$tbl2->newColumn('COMPANY_NO'     ,'기업번호'  ,7)->setWidth(0)->setHide(true)->setAlign('center')->setEditable(false);
			$tbl1->newColumn("<img src='/service/images/btn_ico_modify.jpg' class=btn_modify><img src='/service/images/btn_ico_del.jpg' class=btn_delete>",'수정/삭제'  ,3)
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
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_TBL_CALKO_COUNTRY . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " COUNTRY_CODE,";
    		$query [] = " COUNTRY_EN_NAME,";
    		$query [] = " COUNTRY_KR_NAME,";
    		$query [] = " DESTINATION,";
    		$query [] = " SOLD_TO_PARTY";
    		$query [] = " FROM " . TBL_TBL_CALKO_COUNTRY;

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
        $p_country_code = $argus[p_country_code];
        $p_destination = $argus[p_destination];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " COUNTRY_CODE,";
    		$query [] = " COUNTRY_EN_NAME,";
    		$query [] = " COUNTRY_KR_NAME,";
    		$query [] = " DESTINATION,";
    		$query [] = " SOLD_TO_PARTY";
            $query [] = " FROM " . TBL_TBL_CALKO_COUNTRY;
            $query [] = " WHERE ";
            $query [] = " COUNTRY_CODE = '" . $p_country_code . "' AND ";
            $query [] = " DESTINATION = '" . $p_destination . "'";
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
        $p_country_code = $argus[p_country_code];
        $p_destination = $argus[p_destination];
    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_TBL_CALKO_COUNTRY ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_TBL_CALKO_COUNTRY;
            $query [] = "(";
    		$query [] = " COUNTRY_CODE,";
    		$query [] = " COUNTRY_EN_NAME,";
    		$query [] = " COUNTRY_KR_NAME,";
    		$query [] = " DESTINATION,";
    		$query [] = " SOLD_TO_PARTY";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[country_code] . "',";
    		$query [] = " '" . $argus[country_en_name] . "',";
    		$query [] = " '" . $argus[country_kr_name] . "',";
    		$query [] = " '" . $argus[destination] . "',";
    		$query [] = " '" . $argus[sold_to_party] . "'";
            //$query [] = " now() ";
            $query [] = " );";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
                $this->appendNode("p_country_code",$argus[country_code]); // insert key value 
                $this->appendNode("p_destination",$argus[destination]); // insert key value 
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
        $p_country_code = $argus[p_country_code];
        $p_destination = $argus[p_destination];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_TBL_CALKO_COUNTRY;
            $query [] = " SET";
            $query [] = " COUNTRY_CODE = '" . $argus[country_code] . "',";
            $query [] = " COUNTRY_EN_NAME = '" . $argus[country_en_name] . "',";
            $query [] = " COUNTRY_KR_NAME = '" . $argus[country_kr_name] . "',";
            $query [] = " DESTINATION = '" . $argus[destination] . "',";
            $query [] = " SOLD_TO_PARTY = '" . $argus[sold_to_party] . "'";
            //$query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " COUNTRY_CODE = '" . $p_country_code . "' AND ";
            $query [] = " DESTINATION = '" . $p_destination . "'";
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
        $p_country_code = $argus[p_country_code];
        $p_destination = $argus[p_destination];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "DELETE FROM " . TBL_TBL_CALKO_COUNTRY;
            $query [] = " WHERE ";
            $query [] = " COUNTRY_CODE = '" . $p_country_code . "' AND ";
            $query [] = " DESTINATION = '" . $p_destination . "'";
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
   // # test path : http://local-framework.com/CalkoCountry.php
   $test = new CalkoCountry();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_TBL_CALKO_COUNTRY );
   $test->test($argus);
/*

   // insert 
   $argus[country_code]  = 'data';
   $argus[country_en_name]  = 'data';
   $argus[country_kr_name]  = 'data';
   $argus[destination]  = 'data';
   $argus[sold_to_party]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[country_code]  = 'key';
   $argus[destination]  = 'key';
   // data field 
   $argus[country_en_name]  = 'data';
   $argus[country_kr_name]  = 'data';
   $argus[sold_to_party]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[country_code]  = 'key';
   $argus[destination]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[country_code]  = 'key';
   $argus[destination]  = 'key';
   $test->select($argus); 

*/
}
?>
