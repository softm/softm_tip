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
 * 담당자정보 / Worker.php
 */
class Worker extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_WORKER);
    		$tbl1->newColumn('WORKER_NO','담당자번호',1)->setWidth(50)->setEditable(false);
    		$tbl1->newColumn('PROC_TYPE','PROC_TYPE',2)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('NM_KR','담당자 한글',3)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('NM_EN','담당자 영문',4)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('NM_HJ','담당자 한자',5)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('NM_JP','담당자 일문',6)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('EMAIL','이메일',7)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('TEL','전화번호',8)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('HP','휴대폰',9)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('FAX','팩스',10)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('POSSIBLE_LANG','대응 가능 외국어 : JP: 일본어 EN: 영어   NO : 없음  콤마로 연결해서 저장',11)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('DEPT','부서',12)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('POSITION','직위',13)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('DEPT_JP','부서 일문',14)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('POSITION_JP','직위 일문',15)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('COMPANY_NO','기업번호',16)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('REG_DATE','등록 일자',17)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('MOD_DATE','수정 일자',18)->setWidth(100)->setEditable(true);
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
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_WORKER . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " WORKER_NO,";
    		$query [] = " PROC_TYPE,";
    		$query [] = " NM_KR,";
    		$query [] = " NM_EN,";
    		$query [] = " NM_HJ,";
    		$query [] = " NM_JP,";
    		$query [] = " EMAIL,";
    		$query [] = " TEL,";
    		$query [] = " HP,";
    		$query [] = " FAX,";
    		$query [] = " POSSIBLE_LANG,";
    		$query [] = " DEPT,";
    		$query [] = " POSITION,";
    		$query [] = " DEPT_JP,";
    		$query [] = " POSITION_JP,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE";
    		$query [] = " FROM " . TBL_WORKER;

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
        $p_worker_no = $argus[p_worker_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " WORKER_NO,";
    		$query [] = " PROC_TYPE,";
    		$query [] = " NM_KR,";
    		$query [] = " NM_EN,";
    		$query [] = " NM_HJ,";
    		$query [] = " NM_JP,";
    		$query [] = " EMAIL,";
    		$query [] = " TEL,";
    		$query [] = " HP,";
    		$query [] = " FAX,";
    		$query [] = " POSSIBLE_LANG,";
    		$query [] = " DEPT,";
    		$query [] = " POSITION,";
    		$query [] = " DEPT_JP,";
    		$query [] = " POSITION_JP,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE";
            $query [] = " FROM " . TBL_WORKER;
            $query [] = " WHERE ";
            $query [] = " WORKER_NO = '" . $p_worker_no . "'";
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
     * 조회(외부클래스).
     * @param Database $db
     * @param array $argus
     * @return array
     */
    public static function externalGet($db,$argus) {
    	//$p_user_id   = $argus[user_email  ];
    	$p_worker_no = $argus[p_worker_no];
    	$rtn = array();
    	try {
    		if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
    		if ( !$p_worker_no ) throw new Exception("담당자 없습니다.");
    		$query = array();
    		$query [] = "SELECT ";
    		$query [] = " WORKER_NO ,";
    		$query [] = " WORKER_NO AS P_WORKER_NO,";
    		$query [] = " PROC_TYPE,";
    		$query [] = " NM_KR,";
    		$query [] = " NM_EN,";
    		$query [] = " NM_HJ,";
    		$query [] = " NM_JP,";
    		$query [] = " EMAIL,";
    		$query [] = " TEL,";
    		$query [] = " HP,";
    		$query [] = " FAX,";
    		$query [] = " POSSIBLE_LANG,";
    		$query [] = " DEPT,";
    		$query [] = " POSITION,";
    		$query [] = " DEPT_JP,";
    		$query [] = " POSITION_JP,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE";
    		$query [] = " FROM " . TBL_WORKER;
    		$query [] = " WHERE ";
    		$query [] = " WORKER_NO = '" . $p_worker_no . "'";
    		$sql = join(PHP_EOL, $query);
    		$rtn = $db->get($sql,"array");
    		if ( empty($rtn) ) $rtn = array();
    	} catch (Exception $e) {
    		return $rtn;
    	}
		return $rtn;
    }
        
    /**
     * 담당자정보 입력.(외부클래스)
     * @param Database $db
     * @param array $argus
     * @return int
     */
    public static function externalInsert($db,$argus) {
    	try {
    		if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
    		
    		$possible_lang = is_array($argus[possible_lang])?join(",",$argus[possible_lang]):'';
    		
            $tel = ( $argus[tel_sep_none] != 'Y' )?$argus[tel1] . '-' . $argus[tel2] . '-' . $argus[tel3]:( $argus[worker_tel]?$argus[worker_tel]:$argus[tel]);
    		$hp  = ( $argus[tel_sep_none] != 'Y' )?$argus[hp1 ] . '-' . $argus[hp2 ] . '-' . $argus[hp3 ]:( $argus[worker_hp ]?$argus[worker_hp ]:$argus[hp ]);
    		$fax = ( $argus[tel_sep_none] != 'Y' )?$argus[fax1] . '-' . $argus[fax2] . '-' . $argus[fax3]:( $argus[worker_fax]?$argus[worker_fax]:$argus[fax]);
    		    		    		
    		$query [] = "INSERT INTO " . TBL_WORKER;
    		$query [] = "(";
    		$query [] = " PROC_TYPE,";
    		$query [] = " NM_KR,";
    		$query [] = " NM_EN,";
    		$query [] = " NM_HJ,";
    		$query [] = " NM_JP,";
    		$query [] = " EMAIL,";
    		$query [] = " TEL,";
    		$query [] = " HP,";
    		$query [] = " FAX,";
    		$query [] = " POSSIBLE_LANG,";
    		$query [] = " DEPT,";
    		$query [] = " POSITION,";
    		$query [] = " DEPT_JP,";
    		$query [] = " POSITION_JP,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " REG_DATE ";
//     		$query [] = " MOD_DATE";
    		//$query [] = " REG_DATE ";
    		$query [] = " ) VALUES (";
    		$query [] = " '" . $argus[p_proc_type] . "',";
    		$query [] = " '" . $argus[nm_kr] . "',";
    		$query [] = " '" . $argus[nm_en] . "',";
    		$query [] = " '" . $argus[nm_hj] . "',";
    		$query [] = " '" . $argus[nm_jp] . "',";
    		$query [] = " '" . $argus[email] . "',";
    		$query [] = " '" . $tel . "',";
    		$query [] = " '" . $hp  . "',";
    		$query [] = " '" . $fax . "',";
    		$query [] = " '" . $possible_lang . "',";
    		$query [] = " '" . $argus[dept] . "',";
    		$query [] = " '" . $argus[position] . "',";
    		$query [] = " '" . $argus[dept_jp] . "',";
    		$query [] = " '" . $argus[position_jp] . "',";
    		$query [] = " '" . COMPANY_NO . "',";
    		$query [] = " now()";
//     		$query [] = " '" . $argus[mod_date] . "'";
    		//$query [] = " now() ";
    		$query [] = " );";
    		$sql = join(PHP_EOL, $query);
// 			echo ($sql);
    		$insert_id = 0;
    		if ( $db->exec($sql) ) {
    			$insert_id = $db->getInsertId(); // insert id
    		} else {
    			//                out.print($this->db->getErrMsg());
    			throw new Exception($db->getErrMsg());
    		}
    	} catch (Exception $e) {
//     		echo $e->getMessage();    		
    		$insert_id = 0;
    	}
    	return  $insert_id;
    }

    /**
     * 담당자정보 수정.(외부클래스)
     * @param Database $db
     * @param array $argus
     * @return boolean
     */
    public static function externalUpdate($db,$argus) {
    	$p_worker_no = $argus[p_worker_no];
    	$rtn = true;
    	try {
    		if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
    		if ( !$p_worker_no ) throw new Exception("수정을 위한 정보가 불충분합니다.");
    		$possible_lang = is_array($argus[possible_lang])?join(",",$argus[possible_lang]):'';
    		
            $tel = ( $argus[tel_sep_none] != 'Y' )?$argus[tel1] . '-' . $argus[tel2] . '-' . $argus[tel3]:( $argus[worker_tel]?$argus[worker_tel]:$argus[tel]);
    		$hp  = ( $argus[tel_sep_none] != 'Y' )?$argus[hp1 ] . '-' . $argus[hp2 ] . '-' . $argus[hp3 ]:( $argus[worker_hp ]?$argus[worker_hp ]:$argus[hp ]);
    		$fax = ( $argus[tel_sep_none] != 'Y' )?$argus[fax1] . '-' . $argus[fax2] . '-' . $argus[fax3]:( $argus[worker_fax]?$argus[worker_fax]:$argus[fax]);
    		    		
    		$query = array();
    		$query [] = "UPDATE " . TBL_WORKER;
    		$query [] = " SET";
    		$query [] = " NM_KR = '" . $argus[nm_kr] . "',";
    		$query [] = " NM_EN = '" . $argus[nm_en] . "',";
    		$query [] = " NM_HJ = '" . $argus[nm_hj] . "',";
			if ( $argus[update_jp] == "Y" || $argus[nm_jp] ) $query [] = " NM_JP = '" . $argus[nm_jp] . "',";
    		$query [] = " EMAIL = '" . $argus[email] . "',";
    		$query [] = " TEL = '" . $tel . "',";
    		$query [] = " HP = '" . $hp . "',";
    		$query [] = " FAX = '" . $fax . "',";
    		$query [] = " POSSIBLE_LANG = '" . $possible_lang . "',";
    		$query [] = " DEPT = '" . $argus[dept] . "',";
    		$query [] = " POSITION = '" . $argus[position] . "',";
    		if ( $argus[update_jp] == "Y" ) $query [] = " DEPT_JP = '" . $argus[dept_jp] . "',";
    		if ( $argus[update_jp] == "Y" ) $query [] = " POSITION_JP = '" . $argus[position_jp] . "',";
    		$query [] = " MOD_DATE = now()";
    		$query [] = " WHERE ";
    		$query [] = " WORKER_NO = '" . $p_worker_no . "'";
    		$sql = join(PHP_EOL, $query); 
//     		var_dump($db);
    		if ( $db->exec($sql) ) {
    		} else {
    			//                out.print($this->db->getErrMsg());
    			throw new Exception($db->getErrMsg());
    		}
    		    		
    	} catch (Exception $e) {
    		$rtn = false;    		
    	}
    	return  $rtn;    	
    }
    /**
     * 담당자정보 삭제.(외부클래스)
     * @param Database $db
     * @param array $argus
     * @return boolean
     */
    public static function externalDelete($db,$argus) {
    	$p_worker_no = $argus[p_worker_no];
    	$rtn = true;
    	try {
    		if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
    		
    		$query = array();
    		$query [] = "DELETE FROM " . TBL_WORKER;
    		$query [] = " WHERE ";
    		$query [] = " WORKER_NO = '" . $p_worker_no . "'";
    		$sql = join(PHP_EOL, $query); 
//     		var_dump($db);
    		if ( $db->exec($sql) ) {
    		} else {
    			//                out.print($this->db->getErrMsg());
    			throw new Exception($db->getErrMsg());
    		}
    		    		
    	} catch (Exception $e) {
    		$rtn = false;    		
    	}
    	return  $rtn;    	
    }
        
    /**
     * 입력
     * @param array $argus
     * @return int
     */
    public function insert($argus) {
        $p_worker_no = $argus[p_worker_no];
    
        //$cnt = $this->db->getOne("SELECT COUNT(*) + 1 FROM " . TBL_WORKER ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_WORKER;
            $query [] = "(";
    		$query [] = " PROC_TYPE,";
    		$query [] = " NM_KR,";
    		$query [] = " NM_EN,";
    		$query [] = " NM_HJ,";
    		$query [] = " NM_JP,";
    		$query [] = " EMAIL,";
    		$query [] = " TEL,";
    		$query [] = " HP,";
    		$query [] = " FAX,";
    		$query [] = " POSSIBLE_LANG,";
    		$query [] = " DEPT,";
    		$query [] = " POSITION,";
    		$query [] = " DEPT_JP,";
    		$query [] = " POSITION_JP,";
    		$query [] = " COMPANY_NO,";
    		$query [] = " REG_DATE,";
    		$query [] = " MOD_DATE";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[proc_type] . "',";
    		$query [] = " '" . $argus[nm_kr] . "',";
    		$query [] = " '" . $argus[nm_en] . "',";
    		$query [] = " '" . $argus[nm_hj] . "',";
    		$query [] = " '" . $argus[nm_jp] . "',";
    		$query [] = " '" . $argus[email] . "',";
    		$query [] = " '" . $argus[tel] . "',";
    		$query [] = " '" . $argus[hp] . "',";
    		$query [] = " '" . $argus[fax] . "',";
    		$query [] = " '" . $argus[possible_lang] . "',";
    		$query [] = " '" . $argus[dept] . "',";
    		$query [] = " '" . $argus[position] . "',";
    		$query [] = " '" . $argus[dept_jp] . "',";
    		$query [] = " '" . $argus[position_jp] . "',";
    		$query [] = " '" . $argus[company_no] . "',";
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
        $p_worker_no = $argus[p_worker_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_WORKER;
            $query [] = " SET";
            $query [] = " WORKER_NO = '" . $argus[worker_no] . "',";
            $query [] = " PROC_TYPE = '" . $argus[proc_type] . "',";
            $query [] = " NM_KR = '" . $argus[nm_kr] . "',";
            $query [] = " NM_EN = '" . $argus[nm_en] . "',";
            $query [] = " NM_HJ = '" . $argus[nm_hj] . "',";
            $query [] = " NM_JP = '" . $argus[nm_jp] . "',";
            $query [] = " EMAIL = '" . $argus[email] . "',";
            $query [] = " TEL = '" . $argus[tel] . "',";
            $query [] = " HP = '" . $argus[hp] . "',";
            $query [] = " FAX = '" . $argus[fax] . "',";
            $query [] = " POSSIBLE_LANG = '" . $argus[possible_lang] . "',";
            $query [] = " DEPT = '" . $argus[dept] . "',";
            $query [] = " POSITION = '" . $argus[position] . "',";
            $query [] = " DEPT_JP = '" . $argus[dept_jp] . "',";
            $query [] = " POSITION_JP = '" . $argus[position_jp] . "',";
            $query [] = " COMPANY_NO = '" . $argus[company_no] . "',";
            $query [] = " REG_DATE = '" . $argus[reg_date] . "',";
            $query [] = " MOD_DATE = '" . $argus[mod_date] . "'";
            //$query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " WORKER_NO = '" . $p_worker_no . "'";
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
        $p_worker_no = $argus[p_worker_no];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "DELETE FROM " . TBL_WORKER;
            $query [] = " WHERE ";
            $query [] = " WORKER_NO = '" . $p_worker_no . "'";
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
//         $this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
//         $this->addCodeData("SEX"       , self::$CODE_SEX       );
//         $this->addCodeData("STATE"     , self::$CODE_USER_STATE);
//         $this->addCodeData("EMAIL_YN"  , self::$CODE_YN    );
    }
}
if ( DEBUG ) {
   // # test path : http://local-framework.com/Worker.php
   $test = new Worker();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_WORKER );
   $test->test($argus);
/*

   // insert 
   $argus[worker_no]  = 'data';
   $argus[proc_type]  = 'data';
   $argus[nm_kr]  = 'data';
   $argus[nm_en]  = 'data';
   $argus[nm_hj]  = 'data';
   $argus[nm_jp]  = 'data';
   $argus[email]  = 'data';
   $argus[tel]  = 'data';
   $argus[hp]  = 'data';
   $argus[fax]  = 'data';
   $argus[possible_lang]  = 'data';
   $argus[dept]  = 'data';
   $argus[position]  = 'data';
   $argus[dept_jp]  = 'data';
   $argus[position_jp]  = 'data';
   $argus[company_no]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[worker_no]  = 'key';
   // data field 
   $argus[proc_type]  = 'data';
   $argus[nm_kr]  = 'data';
   $argus[nm_en]  = 'data';
   $argus[nm_hj]  = 'data';
   $argus[nm_jp]  = 'data';
   $argus[email]  = 'data';
   $argus[tel]  = 'data';
   $argus[hp]  = 'data';
   $argus[fax]  = 'data';
   $argus[possible_lang]  = 'data';
   $argus[dept]  = 'data';
   $argus[position]  = 'data';
   $argus[dept_jp]  = 'data';
   $argus[position_jp]  = 'data';
   $argus[company_no]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[worker_no]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[worker_no]  = 'key';
   $test->select($argus); 

*/
}
?>
