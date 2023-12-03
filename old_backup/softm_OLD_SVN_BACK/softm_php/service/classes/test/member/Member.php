<?php
define("DEBUG",preg_match("/^\/service\/classes/", $_SERVER[PHP_SELF]));
define("TBL_TBL_MEMBER","calko.tbl_member");
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
 * 회원정보 / Member.php
 */
class Member extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_TBL_MEMBER);
    		$tbl1->newColumn('USER_NO','?뚯썝踰덊샇',1)->setWidth(50)->setEditable(false);
    		$tbl1->newColumn('USER_ID','?꾩씠?',2)->setWidth(50)->setEditable(true);
    		$tbl1->newColumn('USER_LEVEL','?뚯썝 ?덈꺼 0 : 鍮꾪쉶?? 1 : ?쇰컲?뚯썝, 2: 以묎컻?뚯썝 , 9 : 愿?━?',3)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('PASSWD','鍮꾨?踰덊샇',4)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('USER_NAME','?대쫫',5)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('NICK_NAME','蹂꾨챸',5)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('COMPANY_NAME','遺?룞?곗뾽泥대챸',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('COUNTRY_CODE','국가코드',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('SEX','?깅퀎',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('E_MAIL','E-mail',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('JUMIN_NO','二쇰?踰덊샇',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('COMPANY_NO','?ъ뾽?먮쾲?',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('TEL1','?몃뱶?',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('TEL2','?꾪솕1',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('TEL3','?꾪솕2',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('TEL4','?꾪솕3',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('ADDRESS1','二쇱냼',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('ADDRESS2','?섎㉧吏?二쇱냼',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('POST_NO','?고렪踰덊샇',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('EMAIL_YN','?대찓???섏떊 ?щ?',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('ACCESS','?묒냽 ?잛닔',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('REG_DATE','媛?엯 ?쇱옄',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('ACC_DATE','理쒓렐 ?묎렐?',6)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('STATE','?뚯썝 ?곹깭',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('AGREEMENT','agreement',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('AGREEMENT_DATE','agreement_date',7)->setWidth(100)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('USER_NO'   ,'회원명'     ,2)->setEditable(true);
//	        $tbl1->newColumn('USER_LEVEL','레벨'       ,3)->setType(Column::LISTBOX_TYPE)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('REG_DATE'  ,'가입일'     ,5)->setKey(false);
//			$tbl2 = $this->newTable(TBL_COMPANY)->setTransaction(false);
//			$tbl2->newColumn('COMPANY_NO'     ,'기업번호'  ,7)->setWidth(0)->setHide(true)->setAlign('center')->setEditable(false);
			$tbl1->newColumn("<img src='/service/images/btn_ico_modify.jpg' class=btn_modify><img src='/service/images/btn_ico_del.jpg' class=btn_delete>",'수정/삭제'  ,8)
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
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_TBL_MEMBER . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " USER_NO,";
    		$query [] = " USER_ID,";
    		$query [] = " USER_LEVEL,";
    		$query [] = " PASSWD,";
    		$query [] = " USER_NAME,";
    		$query [] = " NICK_NAME,";
    		$query [] = " COMPANY_NAME,";
    		$query [] = " COUNTRY_CODE,";
    		$query [] = " SEX,";
    		$query [] = " E_MAIL,";
    		$query [] = " JUMIN_NO,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " TEL1,";
    		$query [] = " TEL2,";
    		$query [] = " TEL3,";
    		$query [] = " TEL4,";
    		$query [] = " ADDRESS1,";
    		$query [] = " ADDRESS2,";
    		$query [] = " POST_NO,";
    		$query [] = " EMAIL_YN,";
    		$query [] = " ACCESS,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(ACC_DATE,'%Y-%m-%d %H:%i') ACC_DATE,";
    		$query [] = " STATE,";
    		$query [] = " AGREEMENT,";
    		$query [] = " DATE_FORMAT(AGREEMENT_DATE,'%Y-%m-%d %H:%i') AGREEMENT_DATE";
    		$query [] = " FROM " . TBL_TBL_MEMBER;

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
    		$query [] = " USER_NO,";
    		$query [] = " USER_ID,";
    		$query [] = " USER_LEVEL,";
    		$query [] = " PASSWD,";
    		$query [] = " USER_NAME,";
    		$query [] = " NICK_NAME,";
    		$query [] = " COMPANY_NAME,";
    		$query [] = " COUNTRY_CODE,";
    		$query [] = " SEX,";
    		$query [] = " E_MAIL,";
    		$query [] = " JUMIN_NO,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " TEL1,";
    		$query [] = " TEL2,";
    		$query [] = " TEL3,";
    		$query [] = " TEL4,";
    		$query [] = " ADDRESS1,";
    		$query [] = " ADDRESS2,";
    		$query [] = " POST_NO,";
    		$query [] = " EMAIL_YN,";
    		$query [] = " ACCESS,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(ACC_DATE,'%Y-%m-%d %H:%i') ACC_DATE,";
    		$query [] = " STATE,";
    		$query [] = " AGREEMENT,";
    		$query [] = " DATE_FORMAT(AGREEMENT_DATE,'%Y-%m-%d %H:%i') AGREEMENT_DATE";
            $query [] = " FROM " . TBL_TBL_MEMBER;
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
    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_TBL_MEMBER ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_TBL_MEMBER;
            $query [] = "(";
    		$query [] = " USER_ID,";
    		$query [] = " USER_LEVEL,";
    		$query [] = " PASSWD,";
    		$query [] = " USER_NAME,";
    		$query [] = " NICK_NAME,";
    		$query [] = " COMPANY_NAME,";
    		$query [] = " COUNTRY_CODE,";
    		$query [] = " SEX,";
    		$query [] = " E_MAIL,";
    		$query [] = " JUMIN_NO,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " TEL1,";
    		$query [] = " TEL2,";
    		$query [] = " TEL3,";
    		$query [] = " TEL4,";
    		$query [] = " ADDRESS1,";
    		$query [] = " ADDRESS2,";
    		$query [] = " POST_NO,";
    		$query [] = " EMAIL_YN,";
    		$query [] = " ACCESS,";
    		$query [] = " REG_DATE,";
    		$query [] = " ACC_DATE,";
    		$query [] = " STATE,";
    		$query [] = " AGREEMENT,";
    		$query [] = " AGREEMENT_DATE";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[user_id] . "',";
    		$query [] = " '" . $argus[user_level] . "',";
    		$query [] = " '" . $argus[passwd] . "',";
    		$query [] = " '" . $argus[user_name] . "',";
    		$query [] = " '" . $argus[nick_name] . "',";
    		$query [] = " '" . $argus[company_name] . "',";
    		$query [] = " '" . $argus[country_code] . "',";
    		$query [] = " '" . $argus[sex] . "',";
    		$query [] = " '" . $argus[e_mail] . "',";
    		$query [] = " '" . $argus[jumin_no] . "',";
    		$query [] = " '" . $argus[company_no] . "',";
    		$query [] = " '" . $argus[tel1] . "',";
    		$query [] = " '" . $argus[tel2] . "',";
    		$query [] = " '" . $argus[tel3] . "',";
    		$query [] = " '" . $argus[tel4] . "',";
    		$query [] = " '" . $argus[address1] . "',";
    		$query [] = " '" . $argus[address2] . "',";
    		$query [] = " '" . $argus[post_no] . "',";
    		$query [] = " '" . $argus[email_yn] . "',";
    		$query [] = " '" . $argus[access] . "',";
    		$query [] = " '" . $argus[reg_date] . "',";
    		$query [] = " '" . $argus[acc_date] . "',";
    		$query [] = " '" . $argus[state] . "',";
    		$query [] = " '" . $argus[agreement] . "',";
    		$query [] = " '" . $argus[agreement_date] . "'";
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
        $p_user_no = $argus[p_user_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_TBL_MEMBER;
            $query [] = " SET";
            $query [] = " USER_NO = '" . $argus[user_no] . "',";
            $query [] = " USER_ID = '" . $argus[user_id] . "',";
            $query [] = " USER_LEVEL = '" . $argus[user_level] . "',";
            $query [] = " PASSWD = '" . $argus[passwd] . "',";
            $query [] = " USER_NAME = '" . $argus[user_name] . "',";
            $query [] = " NICK_NAME = '" . $argus[nick_name] . "',";
            $query [] = " COMPANY_NAME = '" . $argus[company_name] . "',";
            $query [] = " COUNTRY_CODE = '" . $argus[country_code] . "',";
            $query [] = " SEX = '" . $argus[sex] . "',";
            $query [] = " E_MAIL = '" . $argus[e_mail] . "',";
            $query [] = " JUMIN_NO = '" . $argus[jumin_no] . "',";
            $query [] = " COMPANY_NO = '" . $argus[company_no] . "',";
            $query [] = " TEL1 = '" . $argus[tel1] . "',";
            $query [] = " TEL2 = '" . $argus[tel2] . "',";
            $query [] = " TEL3 = '" . $argus[tel3] . "',";
            $query [] = " TEL4 = '" . $argus[tel4] . "',";
            $query [] = " ADDRESS1 = '" . $argus[address1] . "',";
            $query [] = " ADDRESS2 = '" . $argus[address2] . "',";
            $query [] = " POST_NO = '" . $argus[post_no] . "',";
            $query [] = " EMAIL_YN = '" . $argus[email_yn] . "',";
            $query [] = " ACCESS = '" . $argus[access] . "',";
            $query [] = " REG_DATE = '" . $argus[reg_date] . "',";
            $query [] = " ACC_DATE = '" . $argus[acc_date] . "',";
            $query [] = " STATE = '" . $argus[state] . "',";
            $query [] = " AGREEMENT = '" . $argus[agreement] . "',";
            $query [] = " AGREEMENT_DATE = '" . $argus[agreement_date] . "'";
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
            $query [] = "DELETE FROM " . TBL_TBL_MEMBER;
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
   // # test path : http://local-framework.com/Member.php
   $test = new Member();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_TBL_MEMBER );
   $test->test($argus);
/*

   // insert 
   $argus[user_no]  = 'data';
   $argus[user_id]  = 'data';
   $argus[user_level]  = 'data';
   $argus[passwd]  = 'data';
   $argus[user_name]  = 'data';
   $argus[nick_name]  = 'data';
   $argus[company_name]  = 'data';
   $argus[country_code]  = 'data';
   $argus[sex]  = 'data';
   $argus[e_mail]  = 'data';
   $argus[jumin_no]  = 'data';
   $argus[company_no]  = 'data';
   $argus[tel1]  = 'data';
   $argus[tel2]  = 'data';
   $argus[tel3]  = 'data';
   $argus[tel4]  = 'data';
   $argus[address1]  = 'data';
   $argus[address2]  = 'data';
   $argus[post_no]  = 'data';
   $argus[email_yn]  = 'data';
   $argus[access]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[acc_date]  = 'data';
   $argus[state]  = 'data';
   $argus[agreement]  = 'data';
   $argus[agreement_date]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[user_no]  = 'key';
   // data field 
   $argus[user_id]  = 'data';
   $argus[user_level]  = 'data';
   $argus[passwd]  = 'data';
   $argus[user_name]  = 'data';
   $argus[nick_name]  = 'data';
   $argus[company_name]  = 'data';
   $argus[country_code]  = 'data';
   $argus[sex]  = 'data';
   $argus[e_mail]  = 'data';
   $argus[jumin_no]  = 'data';
   $argus[company_no]  = 'data';
   $argus[tel1]  = 'data';
   $argus[tel2]  = 'data';
   $argus[tel3]  = 'data';
   $argus[tel4]  = 'data';
   $argus[address1]  = 'data';
   $argus[address2]  = 'data';
   $argus[post_no]  = 'data';
   $argus[email_yn]  = 'data';
   $argus[access]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[acc_date]  = 'data';
   $argus[state]  = 'data';
   $argus[agreement]  = 'data';
   $argus[agreement_date]  = 'data';
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
