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
 * 일본기술자정보 / JpTblEngineer.php
 */
class JpTblEngineer extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_JP_TBL_ENGINEER);
    		$tbl1->newColumn('ENGINEER_NO','기술자번호',1)->setWidth(50)->setEditable(false);
//    		$tbl1->newColumn('NM_HJ','담당자 한자',2)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('NM_JP','담당자 일문',3)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('NM_KR','담당자 한글',4)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('NM_EN','담당자 영문',5)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('TEL','전화번호',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('EMAIL','이메일',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('HP','휴대폰',8)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('FILE_NO1','이력서-첨부파일',9)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('FILE_NO2','각서-첨부파일',10)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('USER_NO','등록자번호',11)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('REG_DATE','등록 일자',12)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('MOD_DATE','수정 일자',13)->setWidth(100)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('USER_NO'   ,'회원명'     ,2)->setEditable(true);
//	        $tbl1->newColumn('USER_LEVEL','레벨'       ,3)->setType(Column::LISTBOX_TYPE)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('REG_DATE'  ,'가입일'     ,5)->setKey(false);
//			$tbl2 = $this->newTable(TBL_COMPANY)->setTransaction(false);
//			$tbl2->newColumn('COMPANY_NO'     ,'기업번호'  ,7)->setWidth(0)->setHide(true)->setAlign('center')->setEditable(false);
			$tbl1->newColumn("<img src='/images/btn_ico_modify.jpg' class=btn_modify><img src='/images/btn_ico_del.jpg' class=btn_delete>",'수정/삭제'  ,9)
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
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_JP_TBL_ENGINEER . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " ENGINEER_NO,";
    		$query [] = " NM_HJ,";
    		$query [] = " NM_JP,";
    		$query [] = " NM_KR,";
    		$query [] = " NM_EN,";
    		$query [] = " TEL,";
    		$query [] = " EMAIL,";
    		$query [] = " HP,";
    		$query [] = " FILE_NO1,";
    		$query [] = " FILE_NO2,";
    		$query [] = " USER_NO,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE";
    		$query [] = " FROM " . TBL_JP_TBL_ENGINEER;

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
        $p_engineer_no = $argus[p_engineer_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " ENGINEER_NO,";
    		$query [] = " NM_HJ,";
    		$query [] = " NM_JP,";
    		$query [] = " NM_KR,";
    		$query [] = " NM_EN,";
    		$query [] = " TEL,";
    		$query [] = " EMAIL,";
    		$query [] = " HP,";
    		$query [] = " FILE_NO1,";
    		$query [] = " FILE_NO2,";
    		$query [] = " USER_NO,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE";
            $query [] = " FROM " . TBL_JP_TBL_ENGINEER;
            $query [] = " WHERE ";
            $query [] = " ENGINEER_NO = '" . $p_engineer_no . "'";
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
        $p_engineer_no = $argus[p_engineer_no];
    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_JP_TBL_ENGINEER ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_JP_TBL_ENGINEER;
            $query [] = "(";
    		$query [] = " NM_HJ,";
    		$query [] = " NM_JP,";
    		$query [] = " NM_KR,";
    		$query [] = " NM_EN,";
    		$query [] = " TEL,";
    		$query [] = " EMAIL,";
    		$query [] = " HP,";
    		$query [] = " FILE_NO1,";
    		$query [] = " FILE_NO2,";
    		$query [] = " USER_NO,";
    		$query [] = " REG_DATE,";
    		$query [] = " MOD_DATE";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[nm_hj] . "',";
    		$query [] = " '" . $argus[nm_jp] . "',";
    		$query [] = " '" . $argus[nm_kr] . "',";
    		$query [] = " '" . $argus[nm_en] . "',";
    		$query [] = " '" . $argus[tel] . "',";
    		$query [] = " '" . $argus[email] . "',";
    		$query [] = " '" . $argus[hp] . "',";
    		$query [] = " '" . $argus[file_no1] . "',";
    		$query [] = " '" . $argus[file_no2] . "',";
    		$query [] = " '" . $argus[user_no] . "',";
    		$query [] = " '" . $argus[reg_date] . "',";
    		$query [] = " '" . $argus[mod_date] . "'";
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
        $p_engineer_no = $argus[p_engineer_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_JP_TBL_ENGINEER;
            $query [] = " SET";
            $query [] = " ENGINEER_NO = '" . $argus[engineer_no] . "',";
            $query [] = " NM_HJ = '" . $argus[nm_hj] . "',";
            $query [] = " NM_JP = '" . $argus[nm_jp] . "',";
            $query [] = " NM_KR = '" . $argus[nm_kr] . "',";
            $query [] = " NM_EN = '" . $argus[nm_en] . "',";
            $query [] = " TEL = '" . $argus[tel] . "',";
            $query [] = " EMAIL = '" . $argus[email] . "',";
            $query [] = " HP = '" . $argus[hp] . "',";
            $query [] = " FILE_NO1 = '" . $argus[file_no1] . "',";
            $query [] = " FILE_NO2 = '" . $argus[file_no2] . "',";
            $query [] = " USER_NO = '" . $argus[user_no] . "',";
            $query [] = " REG_DATE = '" . $argus[reg_date] . "',";
            $query [] = " MOD_DATE = '" . $argus[mod_date] . "'";
            //$query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " ENGINEER_NO = '" . $p_engineer_no . "'";
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
        $p_engineer_no = $argus[p_engineer_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "DELETE FROM " . TBL_JP_TBL_ENGINEER;
            $query [] = " WHERE ";
            $query [] = " ENGINEER_NO = '" . $p_engineer_no . "'";
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
   // # test path : http://local-framework.com/JpTblEngineer.php
   $test = new JpTblEngineer();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_JP_TBL_ENGINEER );
   $test->test($argus);
/*

   // insert 
   $argus[engineer_no]  = 'data';
   $argus[nm_hj]  = 'data';
   $argus[nm_jp]  = 'data';
   $argus[nm_kr]  = 'data';
   $argus[nm_en]  = 'data';
   $argus[tel]  = 'data';
   $argus[email]  = 'data';
   $argus[hp]  = 'data';
   $argus[file_no1]  = 'data';
   $argus[file_no2]  = 'data';
   $argus[user_no]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[engineer_no]  = 'key';
   // data field 
   $argus[nm_hj]  = 'data';
   $argus[nm_jp]  = 'data';
   $argus[nm_kr]  = 'data';
   $argus[nm_en]  = 'data';
   $argus[tel]  = 'data';
   $argus[email]  = 'data';
   $argus[hp]  = 'data';
   $argus[file_no1]  = 'data';
   $argus[file_no2]  = 'data';
   $argus[user_no]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[engineer_no]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[engineer_no]  = 'key';
   $test->select($argus); 

*/
}
?>
