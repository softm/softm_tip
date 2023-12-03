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
 * 비지니스 상담정보 & 매칭정보 / BizConsult.php
 */
class BizConsult extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_BIZ_CONSULT);
    		$tbl1->newColumn('CONSULT_NO','상담번호',1)->setWidth(50)->setEditable(false);
    		$tbl1->newColumn('REG_CODE','비즈니스코드',2)->setWidth(50)->setEditable(true);
    		$tbl1->newColumn('PROC_TYPE','처리형태',3)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('COMPANY_NO','기업번호',4)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('CONSULT_COMPANY_NO','컨선팅할 기업번호 : 상담은 NULL , 매칭 NOT NULL',5)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('STATE','처리상황 : 접수 / 수정요청중 /접수대기 / JK-BiC등록대기 / JK-BiC등록완료',6)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('CONSULT_ITEM','비즈니스 상담 안건',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('CONSULT_ITEM_JP','비즈니스 상담 안건 일어',8)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('HOPE_BIZ_TYPE','희망 비즈니스 형태',9)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('HOPE_BIZ','희망 비즈니스 내용 요약',10)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('HOPE_BIZ_JP','희망 비즈니스 내용 요약 일어',11)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('HOPE_TRADE_TYPE','거래 희망 일본 기업 유형',12)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('HOPE_TRADE_TYPE_JP','거래 희망 일본 기업 유형 일어',13)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('OPEN_LIMIT','일본 내 자료 공개 기한: ○  1년 이하   ○  3년 이하  ○  5년 이하   ○ 무기한',14)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('ETC_QUESTION','기타 의견 및 문의사항 ',15)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('ETC_QUESTION_JP','기타 의견 및 문의사항 일어',16)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('FILE_NO1','제품사진',17)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('FILE_NO2','제품소개서',18)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('FILE_NO3','기타',19)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('WORKER_NO','담당자번호',20)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('ACTION_PLAN','대응 방안 ',21)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('OPEN_YN','노출여부',22)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('REG_DATE','등록 일자',23)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('MOD_DATE','수정 일자',24)->setWidth(100)->setEditable(true);
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
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_BIZ_CONSULT . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " CONSULT_NO,";
    		$query [] = " REG_CODE,";
    		$query [] = " PROC_TYPE,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " CONSULT_COMPANY_NO,";
    		$query [] = " STATE,";
    		$query [] = " CONSULT_ITEM,";
    		$query [] = " CONSULT_ITEM_JP,";
    		$query [] = " HOPE_BIZ_TYPE,";
    		$query [] = " HOPE_BIZ,";
    		$query [] = " HOPE_BIZ_JP,";
    		$query [] = " HOPE_TRADE_TYPE,";
    		$query [] = " HOPE_TRADE_TYPE_JP,";
    		$query [] = " OPEN_LIMIT,";
    		$query [] = " ETC_QUESTION,";
    		$query [] = " ETC_QUESTION_JP,";
    		$query [] = " FILE_NO1,";
    		$query [] = " FILE_NO2,";
    		$query [] = " FILE_NO3,";
    		$query [] = " WORKER_NO,";
    		$query [] = " ACTION_PLAN,";
    		$query [] = " OPEN_YN,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE";
    		$query [] = " FROM " . TBL_BIZ_CONSULT;

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
        $p_consult_no = $argus[p_consult_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " CONSULT_NO,";
    		$query [] = " REG_CODE,";
    		$query [] = " PROC_TYPE,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " CONSULT_COMPANY_NO,";
    		$query [] = " STATE,";
    		$query [] = " CONSULT_ITEM,";
    		$query [] = " CONSULT_ITEM_JP,";
    		$query [] = " HOPE_BIZ_TYPE,";
    		$query [] = " HOPE_BIZ,";
    		$query [] = " HOPE_BIZ_JP,";
    		$query [] = " HOPE_TRADE_TYPE,";
    		$query [] = " HOPE_TRADE_TYPE_JP,";
    		$query [] = " OPEN_LIMIT,";
    		$query [] = " ETC_QUESTION,";
    		$query [] = " ETC_QUESTION_JP,";
    		$query [] = " FILE_NO1,";
    		$query [] = " FILE_NO2,";
    		$query [] = " FILE_NO3,";
    		$query [] = " WORKER_NO,";
    		$query [] = " ACTION_PLAN,";
    		$query [] = " OPEN_YN,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE";
            $query [] = " FROM " . TBL_BIZ_CONSULT;
            $query [] = " WHERE ";
            $query [] = " CONSULT_NO = '" . $p_consult_no . "'";
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
        $p_consult_no = $argus[p_consult_no];
    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_BIZ_CONSULT ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_BIZ_CONSULT;
            $query [] = "(";
    		$query [] = " REG_CODE,";
    		$query [] = " PROC_TYPE,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " CONSULT_COMPANY_NO,";
    		$query [] = " STATE,";
    		$query [] = " CONSULT_ITEM,";
    		$query [] = " CONSULT_ITEM_JP,";
    		$query [] = " HOPE_BIZ_TYPE,";
    		$query [] = " HOPE_BIZ,";
    		$query [] = " HOPE_BIZ_JP,";
    		$query [] = " HOPE_TRADE_TYPE,";
    		$query [] = " HOPE_TRADE_TYPE_JP,";
    		$query [] = " OPEN_LIMIT,";
    		$query [] = " ETC_QUESTION,";
    		$query [] = " ETC_QUESTION_JP,";
    		$query [] = " FILE_NO1,";
    		$query [] = " FILE_NO2,";
    		$query [] = " FILE_NO3,";
    		$query [] = " WORKER_NO,";
    		$query [] = " ACTION_PLAN,";
    		$query [] = " OPEN_YN,";
    		$query [] = " REG_DATE,";
    		$query [] = " MOD_DATE";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[reg_code] . "',";
    		$query [] = " '" . $argus[proc_type] . "',";
    		$query [] = " '" . $argus[company_no] . "',";
    		$query [] = " '" . $argus[consult_company_no] . "',";
    		$query [] = " '" . $argus[state] . "',";
    		$query [] = " '" . $argus[consult_item] . "',";
    		$query [] = " '" . $argus[consult_item_jp] . "',";
    		$query [] = " '" . $argus[hope_biz_type] . "',";
    		$query [] = " '" . $argus[hope_biz] . "',";
    		$query [] = " '" . $argus[hope_biz_jp] . "',";
    		$query [] = " '" . $argus[hope_trade_type] . "',";
    		$query [] = " '" . $argus[hope_trade_type_jp] . "',";
    		$query [] = " '" . $argus[open_limit] . "',";
    		$query [] = " '" . $argus[etc_question] . "',";
    		$query [] = " '" . $argus[etc_question_jp] . "',";
    		$query [] = " '" . $argus[file_no1] . "',";
    		$query [] = " '" . $argus[file_no2] . "',";
    		$query [] = " '" . $argus[file_no3] . "',";
    		$query [] = " '" . $argus[worker_no] . "',";
    		$query [] = " '" . $argus[action_plan] . "',";
    		$query [] = " '" . $argus[open_yn] . "',";
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
        $p_consult_no = $argus[p_consult_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_BIZ_CONSULT;
            $query [] = " SET";
            $query [] = " CONSULT_NO = '" . $argus[consult_no] . "',";
            $query [] = " REG_CODE = '" . $argus[reg_code] . "',";
            $query [] = " PROC_TYPE = '" . $argus[proc_type] . "',";
            $query [] = " COMPANY_NO = '" . $argus[company_no] . "',";
            $query [] = " CONSULT_COMPANY_NO = '" . $argus[consult_company_no] . "',";
            $query [] = " STATE = '" . $argus[state] . "',";
            $query [] = " CONSULT_ITEM = '" . $argus[consult_item] . "',";
            $query [] = " CONSULT_ITEM_JP = '" . $argus[consult_item_jp] . "',";
            $query [] = " HOPE_BIZ_TYPE = '" . $argus[hope_biz_type] . "',";
            $query [] = " HOPE_BIZ = '" . $argus[hope_biz] . "',";
            $query [] = " HOPE_BIZ_JP = '" . $argus[hope_biz_jp] . "',";
            $query [] = " HOPE_TRADE_TYPE = '" . $argus[hope_trade_type] . "',";
            $query [] = " HOPE_TRADE_TYPE_JP = '" . $argus[hope_trade_type_jp] . "',";
            $query [] = " OPEN_LIMIT = '" . $argus[open_limit] . "',";
            $query [] = " ETC_QUESTION = '" . $argus[etc_question] . "',";
            $query [] = " ETC_QUESTION_JP = '" . $argus[etc_question_jp] . "',";
            $query [] = " FILE_NO1 = '" . $argus[file_no1] . "',";
            $query [] = " FILE_NO2 = '" . $argus[file_no2] . "',";
            $query [] = " FILE_NO3 = '" . $argus[file_no3] . "',";
            $query [] = " WORKER_NO = '" . $argus[worker_no] . "',";
            $query [] = " ACTION_PLAN = '" . $argus[action_plan] . "',";
            $query [] = " OPEN_YN = '" . $argus[open_yn] . "',";
            $query [] = " REG_DATE = '" . $argus[reg_date] . "',";
            $query [] = " MOD_DATE = '" . $argus[mod_date] . "'";
            //$query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " CONSULT_NO = '" . $p_consult_no . "'";
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
        $p_consult_no = $argus[p_consult_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "DELETE FROM " . TBL_BIZ_CONSULT;
            $query [] = " WHERE ";
            $query [] = " CONSULT_NO = '" . $p_consult_no . "'";
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
   // # test path : http://local-framework.com/BizConsult.php
   $test = new BizConsult();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_BIZ_CONSULT );
   $test->test($argus);
/*

   // insert 
   $argus[consult_no]  = 'data';
   $argus[reg_code]  = 'data';
   $argus[proc_type]  = 'data';
   $argus[company_no]  = 'data';
   $argus[consult_company_no]  = 'data';
   $argus[state]  = 'data';
   $argus[consult_item]  = 'data';
   $argus[consult_item_jp]  = 'data';
   $argus[hope_biz_type]  = 'data';
   $argus[hope_biz]  = 'data';
   $argus[hope_biz_jp]  = 'data';
   $argus[hope_trade_type]  = 'data';
   $argus[hope_trade_type_jp]  = 'data';
   $argus[open_limit]  = 'data';
   $argus[etc_question]  = 'data';
   $argus[etc_question_jp]  = 'data';
   $argus[file_no1]  = 'data';
   $argus[file_no2]  = 'data';
   $argus[file_no3]  = 'data';
   $argus[worker_no]  = 'data';
   $argus[action_plan]  = 'data';
   $argus[open_yn]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[consult_no]  = 'key';
   // data field 
   $argus[reg_code]  = 'data';
   $argus[proc_type]  = 'data';
   $argus[company_no]  = 'data';
   $argus[consult_company_no]  = 'data';
   $argus[state]  = 'data';
   $argus[consult_item]  = 'data';
   $argus[consult_item_jp]  = 'data';
   $argus[hope_biz_type]  = 'data';
   $argus[hope_biz]  = 'data';
   $argus[hope_biz_jp]  = 'data';
   $argus[hope_trade_type]  = 'data';
   $argus[hope_trade_type_jp]  = 'data';
   $argus[open_limit]  = 'data';
   $argus[etc_question]  = 'data';
   $argus[etc_question_jp]  = 'data';
   $argus[file_no1]  = 'data';
   $argus[file_no2]  = 'data';
   $argus[file_no3]  = 'data';
   $argus[worker_no]  = 'data';
   $argus[action_plan]  = 'data';
   $argus[open_yn]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[consult_no]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[consult_no]  = 'key';
   $test->select($argus); 

*/
}
?>
