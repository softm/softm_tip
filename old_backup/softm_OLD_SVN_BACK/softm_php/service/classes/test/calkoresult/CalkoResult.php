<?php
define("DEBUG",preg_match("/^\/service\/classes/", $_SERVER[PHP_SELF]));
define("TBL_TBL_CALKO_RESULT","calko.tbl_calko_result");
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
 * Characteristic - Detail / CalkoResult.php
 */
class CalkoResult extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_TBL_CALKO_RESULT);
    		$tbl1->newColumn('ESTI_NO','....',1)->setWidth(50)->setEditable(false);
    		$tbl1->newColumn('SEQ','....',2)->setWidth(50)->setEditable(false);
    		$tbl1->newColumn('QTY','..',3)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('CODE','.. (ex:DSA0000)',4)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('VALUE','.. ...(....)',5)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('SPECIFICATION','SPECIFICATION',5)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('STANDARD','..(1), ... (2)',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('PRE_CRC_CODE','.. (ex:DSA0000)',6)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('CATEGORY','Item Category <-- "AGC". ..',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('MAT_NO','Material Number PART CODE [CRC->MATNR]',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('CRC_XML_DATA','XI.. .. CRC XML DATA',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('SAVE_XML_DATA','XML DATA : KEY.VALUE ..',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('SEND_XML_DATA','TP .. XML',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('LOG_XML_DATA','log_xml_data',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('TP_XML_DATA','PDM.. ... TP... ... XML',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('OPT_AMT','.... ..',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('TP_AMT','TP ..',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('CRC_SEND_DATE','CRC....',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('CRC_RECV_DATE','CRC....',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('TP_SEND_DATE','TP....',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('TP_RECV_DATE','TP....',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('SAVE_DATE','....',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('SAP_ESTI_NO','sap_esti_no',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('SEND_MAIL','send_mail',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('SEND_MAIL_DATE','send_mail_date',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('STATE','.... : 0:.., 1:CRC.., 2:CRC.., 3:.., 8:TP.., S:TP...., E:TP....',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('MARGIN_RATE','margin_rate',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('MARKUP_RATE','markup_rate',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('SGNA_RATE','sgna_rate',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('EXCHANGE_RATE','exchange_rate',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('COPY_ESTI_NO','복사견적번호',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('COPY_SEQ','복사견적순번',7)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('REG_DATE','....',7)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('REG_USER_ID','........',8)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('REG_USER_EMAIL','........',9)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('O_SEQ','o_seq',10)->setWidth(100)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('USER_NO'   ,'회원명'     ,2)->setEditable(true);
//	        $tbl1->newColumn('USER_LEVEL','레벨'       ,3)->setType(Column::LISTBOX_TYPE)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('REG_DATE'  ,'가입일'     ,5)->setKey(false);
//			$tbl2 = $this->newTable(TBL_COMPANY)->setTransaction(false);
//			$tbl2->newColumn('COMPANY_NO'     ,'기업번호'  ,7)->setWidth(0)->setHide(true)->setAlign('center')->setEditable(false);
			$tbl1->newColumn("<img src='/service/images/btn_ico_modify.jpg' class=btn_modify><img src='/service/images/btn_ico_del.jpg' class=btn_delete>",'수정/삭제'  ,11)
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
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_TBL_CALKO_RESULT . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " ESTI_NO,";
    		$query [] = " SEQ,";
    		$query [] = " QTY,";
    		$query [] = " CODE,";
    		$query [] = " VALUE,";
    		$query [] = " SPECIFICATION,";
    		$query [] = " STANDARD,";
    		$query [] = " PRE_CRC_CODE,";
    		$query [] = " CATEGORY,";
    		$query [] = " MAT_NO,";
    		$query [] = " CRC_XML_DATA,";
    		$query [] = " SAVE_XML_DATA,";
    		$query [] = " SEND_XML_DATA,";
    		$query [] = " LOG_XML_DATA,";
    		$query [] = " TP_XML_DATA,";
    		$query [] = " OPT_AMT,";
    		$query [] = " TP_AMT,";
    		$query [] = " DATE_FORMAT(CRC_SEND_DATE,'%Y-%m-%d %H:%i') CRC_SEND_DATE,";
    		$query [] = " DATE_FORMAT(CRC_RECV_DATE,'%Y-%m-%d %H:%i') CRC_RECV_DATE,";
    		$query [] = " DATE_FORMAT(TP_SEND_DATE,'%Y-%m-%d %H:%i') TP_SEND_DATE,";
    		$query [] = " DATE_FORMAT(TP_RECV_DATE,'%Y-%m-%d %H:%i') TP_RECV_DATE,";
    		$query [] = " DATE_FORMAT(SAVE_DATE,'%Y-%m-%d %H:%i') SAVE_DATE,";
    		$query [] = " SAP_ESTI_NO,";
    		$query [] = " SEND_MAIL,";
    		$query [] = " DATE_FORMAT(SEND_MAIL_DATE,'%Y-%m-%d %H:%i') SEND_MAIL_DATE,";
    		$query [] = " STATE,";
    		$query [] = " MARGIN_RATE,";
    		$query [] = " MARKUP_RATE,";
    		$query [] = " SGNA_RATE,";
    		$query [] = " EXCHANGE_RATE,";
    		$query [] = " COPY_ESTI_NO,";
    		$query [] = " COPY_SEQ,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " REG_USER_ID,";
    		$query [] = " REG_USER_EMAIL,";
    		$query [] = " O_SEQ";
    		$query [] = " FROM " . TBL_TBL_CALKO_RESULT;

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
        $p_seq = $argus[p_seq];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " ESTI_NO,";
    		$query [] = " SEQ,";
    		$query [] = " QTY,";
    		$query [] = " CODE,";
    		$query [] = " VALUE,";
    		$query [] = " SPECIFICATION,";
    		$query [] = " STANDARD,";
    		$query [] = " PRE_CRC_CODE,";
    		$query [] = " CATEGORY,";
    		$query [] = " MAT_NO,";
    		$query [] = " CRC_XML_DATA,";
    		$query [] = " SAVE_XML_DATA,";
    		$query [] = " SEND_XML_DATA,";
    		$query [] = " LOG_XML_DATA,";
    		$query [] = " TP_XML_DATA,";
    		$query [] = " OPT_AMT,";
    		$query [] = " TP_AMT,";
    		$query [] = " DATE_FORMAT(CRC_SEND_DATE,'%Y-%m-%d %H:%i') CRC_SEND_DATE,";
    		$query [] = " DATE_FORMAT(CRC_RECV_DATE,'%Y-%m-%d %H:%i') CRC_RECV_DATE,";
    		$query [] = " DATE_FORMAT(TP_SEND_DATE,'%Y-%m-%d %H:%i') TP_SEND_DATE,";
    		$query [] = " DATE_FORMAT(TP_RECV_DATE,'%Y-%m-%d %H:%i') TP_RECV_DATE,";
    		$query [] = " DATE_FORMAT(SAVE_DATE,'%Y-%m-%d %H:%i') SAVE_DATE,";
    		$query [] = " SAP_ESTI_NO,";
    		$query [] = " SEND_MAIL,";
    		$query [] = " DATE_FORMAT(SEND_MAIL_DATE,'%Y-%m-%d %H:%i') SEND_MAIL_DATE,";
    		$query [] = " STATE,";
    		$query [] = " MARGIN_RATE,";
    		$query [] = " MARKUP_RATE,";
    		$query [] = " SGNA_RATE,";
    		$query [] = " EXCHANGE_RATE,";
    		$query [] = " COPY_ESTI_NO,";
    		$query [] = " COPY_SEQ,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " REG_USER_ID,";
    		$query [] = " REG_USER_EMAIL,";
    		$query [] = " O_SEQ";
            $query [] = " FROM " . TBL_TBL_CALKO_RESULT;
            $query [] = " WHERE ";
            $query [] = " ESTI_NO = '" . $p_esti_no . "' AND ";
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
        $p_esti_no = $argus[p_esti_no];
        $p_seq = $argus[p_seq];
    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_TBL_CALKO_RESULT ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_TBL_CALKO_RESULT;
            $query [] = "(";
    		$query [] = " ESTI_NO,";
    		$query [] = " SEQ,";
    		$query [] = " QTY,";
    		$query [] = " CODE,";
    		$query [] = " VALUE,";
    		$query [] = " SPECIFICATION,";
    		$query [] = " STANDARD,";
    		$query [] = " PRE_CRC_CODE,";
    		$query [] = " CATEGORY,";
    		$query [] = " MAT_NO,";
    		$query [] = " CRC_XML_DATA,";
    		$query [] = " SAVE_XML_DATA,";
    		$query [] = " SEND_XML_DATA,";
    		$query [] = " LOG_XML_DATA,";
    		$query [] = " TP_XML_DATA,";
    		$query [] = " OPT_AMT,";
    		$query [] = " TP_AMT,";
    		$query [] = " CRC_SEND_DATE,";
    		$query [] = " CRC_RECV_DATE,";
    		$query [] = " TP_SEND_DATE,";
    		$query [] = " TP_RECV_DATE,";
    		$query [] = " SAVE_DATE,";
    		$query [] = " SAP_ESTI_NO,";
    		$query [] = " SEND_MAIL,";
    		$query [] = " SEND_MAIL_DATE,";
    		$query [] = " STATE,";
    		$query [] = " MARGIN_RATE,";
    		$query [] = " MARKUP_RATE,";
    		$query [] = " SGNA_RATE,";
    		$query [] = " EXCHANGE_RATE,";
    		$query [] = " COPY_ESTI_NO,";
    		$query [] = " COPY_SEQ,";
    		$query [] = " REG_DATE,";
    		$query [] = " REG_USER_ID,";
    		$query [] = " REG_USER_EMAIL,";
    		$query [] = " O_SEQ";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[esti_no] . "',";
    		$query [] = " '" . $argus[seq] . "',";
    		$query [] = " '" . $argus[qty] . "',";
    		$query [] = " '" . $argus[code] . "',";
    		$query [] = " '" . $argus[value] . "',";
    		$query [] = " '" . $argus[specification] . "',";
    		$query [] = " '" . $argus[standard] . "',";
    		$query [] = " '" . $argus[pre_crc_code] . "',";
    		$query [] = " '" . $argus[category] . "',";
    		$query [] = " '" . $argus[mat_no] . "',";
    		$query [] = " '" . $argus[crc_xml_data] . "',";
    		$query [] = " '" . $argus[save_xml_data] . "',";
    		$query [] = " '" . $argus[send_xml_data] . "',";
    		$query [] = " '" . $argus[log_xml_data] . "',";
    		$query [] = " '" . $argus[tp_xml_data] . "',";
    		$query [] = " '" . $argus[opt_amt] . "',";
    		$query [] = " '" . $argus[tp_amt] . "',";
    		$query [] = " '" . $argus[crc_send_date] . "',";
    		$query [] = " '" . $argus[crc_recv_date] . "',";
    		$query [] = " '" . $argus[tp_send_date] . "',";
    		$query [] = " '" . $argus[tp_recv_date] . "',";
    		$query [] = " '" . $argus[save_date] . "',";
    		$query [] = " '" . $argus[sap_esti_no] . "',";
    		$query [] = " '" . $argus[send_mail] . "',";
    		$query [] = " '" . $argus[send_mail_date] . "',";
    		$query [] = " '" . $argus[state] . "',";
    		$query [] = " '" . $argus[margin_rate] . "',";
    		$query [] = " '" . $argus[markup_rate] . "',";
    		$query [] = " '" . $argus[sgna_rate] . "',";
    		$query [] = " '" . $argus[exchange_rate] . "',";
    		$query [] = " '" . $argus[copy_esti_no] . "',";
    		$query [] = " '" . $argus[copy_seq] . "',";
    		$query [] = " '" . $argus[reg_date] . "',";
    		$query [] = " '" . $argus[reg_user_id] . "',";
    		$query [] = " '" . $argus[reg_user_email] . "',";
    		$query [] = " '" . $argus[o_seq] . "'";
            //$query [] = " now() ";
            $query [] = " );";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
                $this->appendNode("p_esti_no",$argus[esti_no]); // insert key value 
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
        $p_esti_no = $argus[p_esti_no];
        $p_seq = $argus[p_seq];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_TBL_CALKO_RESULT;
            $query [] = " SET";
            $query [] = " ESTI_NO = '" . $argus[esti_no] . "',";
            $query [] = " SEQ = '" . $argus[seq] . "',";
            $query [] = " QTY = '" . $argus[qty] . "',";
            $query [] = " CODE = '" . $argus[code] . "',";
            $query [] = " VALUE = '" . $argus[value] . "',";
            $query [] = " SPECIFICATION = '" . $argus[specification] . "',";
            $query [] = " STANDARD = '" . $argus[standard] . "',";
            $query [] = " PRE_CRC_CODE = '" . $argus[pre_crc_code] . "',";
            $query [] = " CATEGORY = '" . $argus[category] . "',";
            $query [] = " MAT_NO = '" . $argus[mat_no] . "',";
            $query [] = " CRC_XML_DATA = '" . $argus[crc_xml_data] . "',";
            $query [] = " SAVE_XML_DATA = '" . $argus[save_xml_data] . "',";
            $query [] = " SEND_XML_DATA = '" . $argus[send_xml_data] . "',";
            $query [] = " LOG_XML_DATA = '" . $argus[log_xml_data] . "',";
            $query [] = " TP_XML_DATA = '" . $argus[tp_xml_data] . "',";
            $query [] = " OPT_AMT = '" . $argus[opt_amt] . "',";
            $query [] = " TP_AMT = '" . $argus[tp_amt] . "',";
            $query [] = " CRC_SEND_DATE = '" . $argus[crc_send_date] . "',";
            $query [] = " CRC_RECV_DATE = '" . $argus[crc_recv_date] . "',";
            $query [] = " TP_SEND_DATE = '" . $argus[tp_send_date] . "',";
            $query [] = " TP_RECV_DATE = '" . $argus[tp_recv_date] . "',";
            $query [] = " SAVE_DATE = '" . $argus[save_date] . "',";
            $query [] = " SAP_ESTI_NO = '" . $argus[sap_esti_no] . "',";
            $query [] = " SEND_MAIL = '" . $argus[send_mail] . "',";
            $query [] = " SEND_MAIL_DATE = '" . $argus[send_mail_date] . "',";
            $query [] = " STATE = '" . $argus[state] . "',";
            $query [] = " MARGIN_RATE = '" . $argus[margin_rate] . "',";
            $query [] = " MARKUP_RATE = '" . $argus[markup_rate] . "',";
            $query [] = " SGNA_RATE = '" . $argus[sgna_rate] . "',";
            $query [] = " EXCHANGE_RATE = '" . $argus[exchange_rate] . "',";
            $query [] = " COPY_ESTI_NO = '" . $argus[copy_esti_no] . "',";
            $query [] = " COPY_SEQ = '" . $argus[copy_seq] . "',";
            $query [] = " REG_DATE = '" . $argus[reg_date] . "',";
            $query [] = " REG_USER_ID = '" . $argus[reg_user_id] . "',";
            $query [] = " REG_USER_EMAIL = '" . $argus[reg_user_email] . "',";
            $query [] = " O_SEQ = '" . $argus[o_seq] . "'";
            //$query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " ESTI_NO = '" . $p_esti_no . "' AND ";
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
        $p_esti_no = $argus[p_esti_no];
        $p_seq = $argus[p_seq];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "DELETE FROM " . TBL_TBL_CALKO_RESULT;
            $query [] = " WHERE ";
            $query [] = " ESTI_NO = '" . $p_esti_no . "' AND ";
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
   // # test path : http://local-framework.com/CalkoResult.php
   $test = new CalkoResult();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_TBL_CALKO_RESULT );
   $test->test($argus);
/*

   // insert 
   $argus[esti_no]  = 'data';
   $argus[seq]  = 'data';
   $argus[qty]  = 'data';
   $argus[code]  = 'data';
   $argus[value]  = 'data';
   $argus[specification]  = 'data';
   $argus[standard]  = 'data';
   $argus[pre_crc_code]  = 'data';
   $argus[category]  = 'data';
   $argus[mat_no]  = 'data';
   $argus[crc_xml_data]  = 'data';
   $argus[save_xml_data]  = 'data';
   $argus[send_xml_data]  = 'data';
   $argus[log_xml_data]  = 'data';
   $argus[tp_xml_data]  = 'data';
   $argus[opt_amt]  = 'data';
   $argus[tp_amt]  = 'data';
   $argus[crc_send_date]  = 'data';
   $argus[crc_recv_date]  = 'data';
   $argus[tp_send_date]  = 'data';
   $argus[tp_recv_date]  = 'data';
   $argus[save_date]  = 'data';
   $argus[sap_esti_no]  = 'data';
   $argus[send_mail]  = 'data';
   $argus[send_mail_date]  = 'data';
   $argus[state]  = 'data';
   $argus[margin_rate]  = 'data';
   $argus[markup_rate]  = 'data';
   $argus[sgna_rate]  = 'data';
   $argus[exchange_rate]  = 'data';
   $argus[copy_esti_no]  = 'data';
   $argus[copy_seq]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[reg_user_id]  = 'data';
   $argus[reg_user_email]  = 'data';
   $argus[o_seq]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[esti_no]  = 'key';
   $argus[seq]  = 'key';
   // data field 
   $argus[qty]  = 'data';
   $argus[code]  = 'data';
   $argus[value]  = 'data';
   $argus[specification]  = 'data';
   $argus[standard]  = 'data';
   $argus[pre_crc_code]  = 'data';
   $argus[category]  = 'data';
   $argus[mat_no]  = 'data';
   $argus[crc_xml_data]  = 'data';
   $argus[save_xml_data]  = 'data';
   $argus[send_xml_data]  = 'data';
   $argus[log_xml_data]  = 'data';
   $argus[tp_xml_data]  = 'data';
   $argus[opt_amt]  = 'data';
   $argus[tp_amt]  = 'data';
   $argus[crc_send_date]  = 'data';
   $argus[crc_recv_date]  = 'data';
   $argus[tp_send_date]  = 'data';
   $argus[tp_recv_date]  = 'data';
   $argus[save_date]  = 'data';
   $argus[sap_esti_no]  = 'data';
   $argus[send_mail]  = 'data';
   $argus[send_mail_date]  = 'data';
   $argus[state]  = 'data';
   $argus[margin_rate]  = 'data';
   $argus[markup_rate]  = 'data';
   $argus[sgna_rate]  = 'data';
   $argus[exchange_rate]  = 'data';
   $argus[copy_esti_no]  = 'data';
   $argus[copy_seq]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[reg_user_id]  = 'data';
   $argus[reg_user_email]  = 'data';
   $argus[o_seq]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[esti_no]  = 'key';
   $argus[seq]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[esti_no]  = 'key';
   $argus[seq]  = 'key';
   $test->select($argus); 

*/
}
?>
