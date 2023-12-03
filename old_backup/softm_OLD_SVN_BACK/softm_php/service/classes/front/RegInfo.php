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
 * 등록정보 / RegInfo.php
 */
class RegInfo extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_REG_INFO);
			$seq = 0;
    		$tbl1->newColumn('REG_NO','등록번호',++$seq)->setWidth(50 )->setEditable(false)->setHide(true);
// 대공종코드
// 대공종명
// 공정항목코드
// 공정항목명
// 공정항목내역코드
// 공정항목내역명
// 공종항목내역 Detail
// 규격
// 단위
// 재료비
// 노무비
// 경비
// 합계
// 등록정보
// 삭제

//업체명 	주소 	전화번호 	세부정보 	최종수정일
    		$tbl1->newColumn('COMPANY_NM'   ,'업체명'               ,++$seq)->setWidth("15%");
    		$tbl1->newColumn('COMPANY_ADDR' ,'주소'                 ,++$seq)->setWidth("55%")->setAlign("left");
    		$tbl1->newColumn('COMPANY_TEL'  ,'전화번호'             ,++$seq)->setWidth("15%");
 			$tbl1->newColumn("BTN1"     ,'세부정보'  ,++$seq)->setWidth("15%")->setHtml(true)->setSortable(false)->setType(Column::TEXT_TYPE)
 			->setValue("<a class='btn_navy' >가격정보</a>");
    		$tbl1->newColumn('MOD_DATE'     ,'최종수정일'           ,++$seq)->setWidth("15%");
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
//    		if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
//    		var_dump($argus);
    		$page_tab['js_function' ] = $argus["p_navi_function"];
    		$page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
    		if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];

    		// where 문장생성
    		$make_where = $this->makeWhere($argus);
    		$where = $make_where;
//            $where = " 1 = 1 ";
    		$where .= " a.STATE = '" . STATE_REGINFO_APPROVAL . "'";
//            $where .= " AND a.PROC_CD = '" . $argus[p_proc_cd] . "'";
//            $where .= " AND a.PROC_IT_CD = '" . $argus[p_proc_it_cd] . "'";
            $where .= " AND a.PROC_BD_CD    = '" . $argus[p_proc_bd_cd] . "'";
            if ( $argus[p_area] )
                $where .= " AND a.COMPANY_AREA  = '" . $argus[p_area]       . "'";

    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_REG_INFO . " a " . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = "    a.REG_NO           REG_NO          ";
    		$query [] = "  , a.PROC_CD          PROC_CD         ";
    		$query [] = "  , a.PROC_IT_CD       PROC_IT_CD      ";
    		$query [] = "  , a.PROC_BD_CD       PROC_BD_CD      ";
//    		$query [] = "  , a.PROC_IT_NM       PROC_IT_NM      ";
//    		$query [] = "  , a.PROC_BD_NM       PROC_BD_NM      ";
//    		$query [] = "  , a.PROC_DT_NM       PROC_DT_NM      ";
    		$query [] = "  , a.STD              STD             ";
    		$query [] = "  , a.UNIT             UNIT            ";
    		$query [] = "  , a.M_AMT            M_AMT           ";
    		$query [] = "  , a.L_AMT            L_AMT           ";
    		$query [] = "  , a.E_AMT            E_AMT           ";
    		$query [] = "  , a.COMPANY_NM       COMPANY_NM      ";
    		$query [] = "  , a.COMPANY_TEL      COMPANY_TEL     ";
    		$query [] = "  , a.COMPANY_AREA     COMPANY_AREA    ";
    		$query [] = "  , a.COMPANY_ADDR     COMPANY_ADDR    ";
    		$query [] = "  , a.COMPANY_HOMEPAGE COMPANY_HOMEPAGE";
    		$query [] = "  , a.M_AMT + a.L_AMT + a.E_AMT T_AMT  ";
    		$query [] = "  , b.PROC_NM          PROC_NM         ";
    		$query [] = "  , a.STATE            STATE           ";
    		$query [] = "  , DATE_FORMAT(a.MOD_DATE,'%Y-%m-%d') MOD_DATE";
    		$query [] = "  , c.PROC_IT_NM       PROC_IT_NM      ";
    		$query [] = "  , d.PROC_BD_NM       PROC_BD_NM      ";
    		$query [] = "  , d.PROC_DT_NM       PROC_DT_NM      ";

    		//$query [] = "  , c.PROC_IT_NM       PROC_IT_NM    ";
    		$query [] = " FROM " . TBL_REG_INFO . " a";
    		$query [] = " LEFT JOIN " . TBL_PROC_CD      . " b";
    		$query [] = "   ON a.PROC_CD = b.PROC_CD ";
    		$query [] = " LEFT JOIN " . TBL_PROC_IT_CD      . " c";
    		$query [] = "   ON a.PROC_IT_CD = c.PROC_IT_CD ";
    		$query [] = " LEFT JOIN " . TBL_PROC_BD_CD      . " d";
    		$query [] = "   ON a.PROC_BD_CD = d.PROC_BD_CD ";
            
    		// where 문장생성
    		if ( $where ) $query[] = ( " WHERE " . $where );

    		$query[] =  ( $this->getQuerySort()?" ORDER BY ". $this->getQuerySort():' ORDER BY REG_NO DESC' );
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
     * 최근 작성중인 질문 조회
     * @param array $argus
     * @return DOMDocument
     */
    public function recentGet($argus) {
    	// 정보
    	$infor = $this->db->get(
    			"SELECT "
    			. " MAX(REG_NO) REG_NO"
    			. " FROM ". TBL_REG_INFO
    			. " WHERE USER_NO = '" . USER_NO . "'"
    			. "   AND STATE <> '" . STATE_REGINFO_APPROVAL . "'"
    	);
    	$p_reg_no = $infor?$infor->REG_NO:"";
    	
   		$this->modifyGet(array_merge($argus,array("p_reg_no"=>$p_reg_no)));
    }
    
    /**
     * 조회
     * @param array $argus
     * @return DOMDocument
     */
    public function modifyGet($argus) {
    	//$p_user_id   = $argus[user_email  ];
    	$p_reg_no = $argus[p_reg_no];
    
    	$this->testJsCall($argus);
    	$this->startHeader();
    	try {
    		//            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
    		$query = array();
    		$query [] = "SELECT ";
    		$query [] = "    a.REG_NO           REG_NO          ";
    		$query [] = "  , a.PROC_CD          PROC_CD         ";
    		$query [] = "  , a.PROC_IT_CD       PROC_IT_CD      ";
    		$query [] = "  , a.PROC_BD_CD       PROC_BD_CD      ";
    		$query [] = "  , a.PROC_IT_NM       PROC_IT_NM      ";
    		$query [] = "  , a.PROC_BD_NM       PROC_BD_NM      ";
    		$query [] = "  , a.PROC_DT_NM       PROC_DT_NM      ";
    		$query [] = "  , a.STD              STD             ";
    		$query [] = "  , a.UNIT             UNIT            ";
    		$query [] = "  , a.M_AMT            M_AMT           ";
    		$query [] = "  , a.L_AMT            L_AMT           ";
    		$query [] = "  , a.E_AMT            E_AMT           ";
    		$query [] = "  , a.COMPANY_NM       COMPANY_NM      ";
    		$query [] = "  , a.COMPANY_TEL      COMPANY_TEL     ";
    		$query [] = "  , a.COMPANY_AREA     COMPANY_AREA    ";
    		$query [] = "  , a.COMPANY_ADDR     COMPANY_ADDR    ";
    		$query [] = "  , a.COMPANY_HOMEPAGE COMPANY_HOMEPAGE";
    		$query [] = "  , a.M_AMT + a.L_AMT + a.E_AMT T_AMT  ";
    		$query [] = "  , b.PROC_NM          PROC_NM         ";
    		$query [] = "  , a.STATE            STATE           ";
    		$query [] = "  , DATE_FORMAT(a.REG_DATE,'%Y-%m-%d') REG_DATE";
    		$query [] = "  , DATE_FORMAT(a.MOD_DATE,'%Y-%m-%d') MOD_DATE";
    		//$query [] = "  , c.PROC_IT_NM       PROC_IT_NM    ";
    		$query [] = " FROM " . TBL_REG_INFO . " a";
    		$query [] = " LEFT JOIN " . TBL_PROC_CD      . " b";
    		$query [] = "   ON a.PROC_CD = b.PROC_CD ";
    		$query [] = " LEFT JOIN " . TBL_PROC_IT_CD      . " c";
    		$query [] = "   ON a.PROC_IT_CD = c.PROC_IT_CD ";
    		$query [] = " LEFT JOIN " . TBL_PROC_BD_CD      . " d";
    		$query [] = "   ON a.PROC_BD_CD = d.PROC_BD_CD ";
    
    		$query [] = " WHERE ";
    		$query [] = " a.REG_NO = '" . $p_reg_no . "'";
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
     * 조회
     * @param array $argus
     * @return DOMDocument
     */
    public function get($argus) {
        //$p_user_id   = $argus[user_email  ];
        $p_reg_no = $argus[p_reg_no];
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
//            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = "    a.REG_NO           REG_NO          ";
    		$query [] = "  , a.PROC_CD          PROC_CD         ";
    		$query [] = "  , a.PROC_IT_CD       PROC_IT_CD      ";
    		$query [] = "  , a.PROC_BD_CD       PROC_BD_CD      ";
//    		$query [] = "  , a.PROC_IT_NM       PROC_IT_NM      ";
//    		$query [] = "  , a.PROC_BD_NM       PROC_BD_NM      ";
//    		$query [] = "  , a.PROC_DT_NM       PROC_DT_NM      ";
    		$query [] = "  , a.STD              STD             ";
    		$query [] = "  , a.UNIT             UNIT            ";
    		$query [] = "  , a.M_AMT            M_AMT           ";
    		$query [] = "  , a.L_AMT            L_AMT           ";
    		$query [] = "  , a.E_AMT            E_AMT           ";
    		$query [] = "  , a.COMPANY_NM       COMPANY_NM      ";
    		$query [] = "  , a.COMPANY_TEL      COMPANY_TEL     ";
    		$query [] = "  , a.COMPANY_AREA     COMPANY_AREA    ";
    		$query [] = "  , a.COMPANY_ADDR     COMPANY_ADDR    ";
    		$query [] = "  , a.COMPANY_HOMEPAGE COMPANY_HOMEPAGE";
    		$query [] = "  , a.M_AMT + a.L_AMT + a.E_AMT T_AMT  ";
    		$query [] = "  , b.PROC_NM          PROC_NM         ";
    		$query [] = "  , a.STATE            STATE           ";
    		$query [] = "  , a.ETC              ETC             ";
    		$query [] = "  , DATE_FORMAT(a.REG_DATE,'%Y-%m-%d') REG_DATE";
    		$query [] = "  , DATE_FORMAT(a.MOD_DATE,'%Y-%m-%d') MOD_DATE";
    		$query [] = "  , c.PROC_IT_NM       PROC_IT_NM      ";
    		$query [] = "  , d.PROC_BD_NM       PROC_BD_NM      ";
    		$query [] = "  , d.PROC_DT_NM       PROC_DT_NM      ";

    		//$query [] = "  , c.PROC_IT_NM       PROC_IT_NM    ";
    		$query [] = " FROM " . TBL_REG_INFO . " a";
    		$query [] = " LEFT JOIN " . TBL_PROC_CD      . " b";
    		$query [] = "   ON a.PROC_CD = b.PROC_CD ";
    		$query [] = " LEFT JOIN " . TBL_PROC_IT_CD      . " c";
    		$query [] = "   ON a.PROC_IT_CD = c.PROC_IT_CD ";
    		$query [] = " LEFT JOIN " . TBL_PROC_BD_CD      . " d";
    		$query [] = "   ON a.PROC_BD_CD = d.PROC_BD_CD ";

            $query [] = " WHERE ";
            $query [] = " a.REG_NO = '" . $p_reg_no . "'";
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
        $p_reg_no = $argus[p_reg_no];
    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_REG_INFO ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_REG_INFO;
            $query [] = "(";
    		$query [] = " PROC_CD,";
    		$query [] = " PROC_IT_CD,";
    		$query [] = " PROC_BD_CD,";
    		$query [] = " PROC_IT_NM,";
    		$query [] = " PROC_BD_NM,";
    		$query [] = " PROC_DT_NM,";
    		$query [] = " STD,";
    		$query [] = " UNIT,";
    		$query [] = " M_AMT,";
    		$query [] = " L_AMT,";
    		$query [] = " E_AMT,";
    		$query [] = " COMPANY_NM,";
    		$query [] = " COMPANY_TEL,";
    		$query [] = " COMPANY_AREA,";
    		$query [] = " COMPANY_ADDR,";
    		$query [] = " COMPANY_HOMEPAGE,";
    		$query [] = " STATE,";
    		$query [] = " USER_NO,";
    		$query [] = " REG_DATE,";
    		$query [] = " MOD_DATE";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[p_proc_cd] . "',";
    		$query [] = " '" . $argus[p_proc_it_cd] . "',";
    		$query [] = " '" . $argus[p_proc_bd_cd] . "',";
    		$query [] = " '" . $argus[proc_it_nm] . "',";
    		$query [] = " '" . $argus[proc_bd_nm] . "',";
    		$query [] = " '" . $argus[proc_dt_nm] . "',";
    		$query [] = " '" . $argus[std] . "',";
    		$query [] = " '" . $argus[unit] . "',";
    		$query [] = " '" . $argus[m_amt] . "',";
    		$query [] = " '" . $argus[l_amt] . "',";
    		$query [] = " '" . $argus[e_amt] . "',";
    		$query [] = " '" . $argus[company_nm] . "',";
    		$query [] = " '" . $argus[company_tel] . "',";
    		$query [] = " '" . $argus[company_area] . "',";
    		$query [] = " '" . $argus[company_addr] . "',";
    		$query [] = " '" . $argus[company_homepage] . "',";
    		$query [] = " '" . STATE_REGINFO_START . "',";
    		$query [] = " '" . USER_NO . "',";
    		$query [] = " now(),";
    		$query [] = " now()";
//    		$query [] = " '" . $argus[mod_date] . "'";
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
        $p_reg_no = $argus[p_reg_no];
        if ( $argus[company_tel1] && $argus[company_tel2] && $argus[company_tel3]) {
        	$company_tel = $argus[company_tel1     ]."-".$argus[company_tel2     ]."-".$argus[company_tel3     ];
        }
        $this->testJsCall($argus);
        $this->startHeader();
        try {
//            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_REG_INFO;
            $query [] = " SET";
            $query [] = " PROC_CD = '" . $argus[p_proc_cd] . "',";
            $query [] = " PROC_IT_CD = '" . $argus[p_proc_it_cd] . "',";
            $query [] = " PROC_BD_CD = '" . $argus[p_proc_bd_cd] . "',";
            $query [] = " PROC_IT_NM = '" . $argus[proc_it_nm] . "',";
            $query [] = " PROC_BD_NM = '" . $argus[proc_bd_nm] . "',";
            $query [] = " PROC_DT_NM = '" . $argus[proc_dt_nm] . "',";
            $query [] = " STD = '" . $argus[std] . "',";
            $query [] = " UNIT = '" . $argus[unit] . "',";
            $query [] = " M_AMT = '" . $argus[m_amt] . "',";
            $query [] = " L_AMT = '" . $argus[l_amt] . "',";
            $query [] = " E_AMT = '" . $argus[e_amt] . "',";
            $query [] = " COMPANY_NM = '" . $argus[company_nm] . "',";
            $query [] = " COMPANY_TEL = '" . $company_tel . "',";
            $query [] = " COMPANY_AREA = '" . $argus[company_area] . "',";
            $query [] = " COMPANY_ADDR = '" . $argus[company_addr] . "',";
            $query [] = " COMPANY_HOMEPAGE = '" . $argus[company_homepage] . "',";
//             $query [] = " STATE = '" . $argus[state] . "',";
            $query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " REG_NO = '" . $p_reg_no . "'";
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
        $p_reg_no = $argus[p_reg_no];
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
//            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "DELETE FROM " . TBL_REG_INFO;
            $query [] = " WHERE ";
            $query [] = " REG_NO = '" . $p_reg_no . "'";
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
         $this->addCodeData("COMPANY_AREA"  , self::$CODE_AREA);
         $this->addCodeData("STATE"         , self::$CODE_STATE_REGINFO);
//         $this->addCodeData("SEX"       , self::$CODE_SEX       );
//         $this->addCodeData("STATE"     , self::$CODE_USER_STATE);
//         $this->addCodeData("EMAIL_YN"  , self::$CODE_YN    );
    }
}
if ( DEBUG ) {
   // # test path : http://local-mj.com/RegInfo.php
   $test = new RegInfo();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_REG_INFO );
   $test->test($argus);
/*

   // insert 
   $argus[reg_no]  = 'data';
   $argus[proc_cd]  = 'data';
   $argus[proc_it_cd]  = 'data';
   $argus[proc_bd_cd]  = 'data';
   $argus[proc_bd_nm]  = 'data';
   $argus[proc_dt_nm]  = 'data';
   $argus[std]  = 'data';
   $argus[unit]  = 'data';
   $argus[m_amt]  = 'data';
   $argus[l_amt]  = 'data';
   $argus[e_amt]  = 'data';
   $argus[company_nm]  = 'data';
   $argus[company_tel]  = 'data';
   $argus[company_area]  = 'data';
   $argus[company_addr]  = 'data';
   $argus[company_homepage]  = 'data';
   $argus[state]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[reg_no]  = 'key';
   // data field 
   $argus[proc_cd]  = 'data';
   $argus[proc_it_cd]  = 'data';
   $argus[proc_bd_cd]  = 'data';
   $argus[proc_bd_nm]  = 'data';
   $argus[proc_dt_nm]  = 'data';
   $argus[std]  = 'data';
   $argus[unit]  = 'data';
   $argus[m_amt]  = 'data';
   $argus[l_amt]  = 'data';
   $argus[e_amt]  = 'data';
   $argus[company_nm]  = 'data';
   $argus[company_tel]  = 'data';
   $argus[company_area]  = 'data';
   $argus[company_addr]  = 'data';
   $argus[company_homepage]  = 'data';
   $argus[state]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[reg_no]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[reg_no]  = 'key';
   $test->select($argus); 

*/
}
?>
