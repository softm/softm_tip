<?php
define("DEBUG",preg_match("/\/service\/classes/", $_SERVER[PHP_SELF]));
define("TBL_KYH_MEMBER","designboard.kyh_member");
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
 *  / KyhMember.php
 */
class KyhMember extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_KYH_MEMBER);
			$seq = 0;
    		$tbl1->newColumn('NO','no',++$seq)->setWidth(50)->setEditable(false);
    		$tbl1->newColumn('USER_ID','user_id',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('MEMBER_LEVEL','member_level',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('PASSWORD','password',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('NAME','name',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('SEX','sex',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('E_MAIL','e_mail',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('TEL','tel',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('ADDRESS','address',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('POST_NO','post_no',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('MEMBER_ST','member_st',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('NEWS_YN','news_yn',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('REG_DATE','reg_date',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('ACC_DATE','acc_date',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('JUMIN','jumin',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('HOME','home',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('POINT','point',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('USER_ID_OPEN','user_id_open',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('MEMBER_LEVEL_OPEN','member_level_open',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('NAME_OPEN','name_open',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('SEX_OPEN','sex_open',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('E_MAIL_OPEN','e_mail_open',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('HOME_OPEN','home_open',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('TEL_OPEN','tel_open',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('ADDRESS_OPEN','address_open',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('POST_NO_OPEN','post_no_open',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('POINT_OPEN','point_open',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('PICTURE_IMAGE_OPEN','picture_image_open',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('CHARACTER_IMAGE_OPEN','character_image_open',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('BIRTH','birth',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('AGE','age',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('BIRTH_OPEN','birth_open',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('AGE_OPEN','age_open',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('ACCESS','access',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('ACCESS_OPEN','access_open',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('HINT','hint',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('ANSWER','answer',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('NICK_NAME','nick_name',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('NICK_NAME_OPEN','nick_name_open',++$seq)->setWidth(100)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,++$seq)->setAlign('center');
//	        $tbl1->newColumn('USER_NO'   ,'회원명'     ,++$seq)->setEditable(true);
//	        $tbl1->newColumn('USER_LEVEL','레벨'       ,++$seq)->setType(Column::LISTBOX_TYPE)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,++$seq)->setAlign('center');
//	        $tbl1->newColumn('REG_DATE'  ,'가입일'     ,++$seq)->setKey(false);
//			$tbl2 = $this->newTable(TBL_COMPANY)->setTransaction(false);
//			$tbl2->newColumn('COMPANY_NO'     ,'기업번호'  ,7)->setWidth(0)->setHide(true)->setAlign('center')->setEditable(false);
			$tbl1->newColumn("BTN1"     ,'수정'  ,++$seq)->setWidth("100")->setHtml(true)->setSortable(false)->setType(Column::TEXT_TYPE)
			->setValue("<a class='btn_edit btn_modify' >수정</a>");
			$tbl1->newColumn("BTN2"     ,'삭제'  ,++$seq)->setWidth("100")->setHtml(true)->setSortable(false)->setType(Column::TEXT_TYPE)
			->setValue("<a class='btn_edit btn_delete' >삭제</a>");
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
    		if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
//    		var_dump($argus);
    		$page_tab['js_function' ] = $argus["p_navi_function"];
    		$page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
    		if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];

    		// where 문장생성
    		$make_where = $this->makeWhere($argus);
    		$where = $make_where;

    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_KYH_MEMBER . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " NO,";
    		$query [] = " USER_ID,";
    		$query [] = " MEMBER_LEVEL,";
    		$query [] = " PASSWORD,";
    		$query [] = " NAME,";
    		$query [] = " SEX,";
    		$query [] = " E_MAIL,";
    		$query [] = " TEL,";
    		$query [] = " ADDRESS,";
    		$query [] = " POST_NO,";
    		$query [] = " MEMBER_ST,";
    		$query [] = " NEWS_YN,";
    		$query [] = " REG_DATE,";
    		$query [] = " ACC_DATE,";
    		$query [] = " JUMIN,";
    		$query [] = " HOME,";
    		$query [] = " POINT,";
    		$query [] = " USER_ID_OPEN,";
    		$query [] = " MEMBER_LEVEL_OPEN,";
    		$query [] = " NAME_OPEN,";
    		$query [] = " SEX_OPEN,";
    		$query [] = " E_MAIL_OPEN,";
    		$query [] = " HOME_OPEN,";
    		$query [] = " TEL_OPEN,";
    		$query [] = " ADDRESS_OPEN,";
    		$query [] = " POST_NO_OPEN,";
    		$query [] = " POINT_OPEN,";
    		$query [] = " PICTURE_IMAGE_OPEN,";
    		$query [] = " CHARACTER_IMAGE_OPEN,";
    		$query [] = " BIRTH,";
    		$query [] = " AGE,";
    		$query [] = " BIRTH_OPEN,";
    		$query [] = " AGE_OPEN,";
    		$query [] = " ACCESS,";
    		$query [] = " ACCESS_OPEN,";
    		$query [] = " HINT,";
    		$query [] = " ANSWER,";
    		$query [] = " NICK_NAME,";
    		$query [] = " NICK_NAME_OPEN";
    		$query [] = " FROM " . TBL_KYH_MEMBER;

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
        $p_no = $argus[no];
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " NO,";
    		$query [] = " USER_ID,";
    		$query [] = " MEMBER_LEVEL,";
    		$query [] = " PASSWORD,";
    		$query [] = " NAME,";
    		$query [] = " SEX,";
    		$query [] = " E_MAIL,";
    		$query [] = " TEL,";
    		$query [] = " ADDRESS,";
    		$query [] = " POST_NO,";
    		$query [] = " MEMBER_ST,";
    		$query [] = " NEWS_YN,";
    		$query [] = " REG_DATE,";
    		$query [] = " ACC_DATE,";
    		$query [] = " JUMIN,";
    		$query [] = " HOME,";
    		$query [] = " POINT,";
    		$query [] = " USER_ID_OPEN,";
    		$query [] = " MEMBER_LEVEL_OPEN,";
    		$query [] = " NAME_OPEN,";
    		$query [] = " SEX_OPEN,";
    		$query [] = " E_MAIL_OPEN,";
    		$query [] = " HOME_OPEN,";
    		$query [] = " TEL_OPEN,";
    		$query [] = " ADDRESS_OPEN,";
    		$query [] = " POST_NO_OPEN,";
    		$query [] = " POINT_OPEN,";
    		$query [] = " PICTURE_IMAGE_OPEN,";
    		$query [] = " CHARACTER_IMAGE_OPEN,";
    		$query [] = " BIRTH,";
    		$query [] = " AGE,";
    		$query [] = " BIRTH_OPEN,";
    		$query [] = " AGE_OPEN,";
    		$query [] = " ACCESS,";
    		$query [] = " ACCESS_OPEN,";
    		$query [] = " HINT,";
    		$query [] = " ANSWER,";
    		$query [] = " NICK_NAME,";
    		$query [] = " NICK_NAME_OPEN";
            $query [] = " FROM " . TBL_KYH_MEMBER;
            $query [] = " WHERE ";
            $query [] = " NO = '" . $p_no . "'";
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
        $p_no = $argus[no];
    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_KYH_MEMBER ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_KYH_MEMBER;
            $query [] = "(";
    		$query [] = " USER_ID,";
    		$query [] = " MEMBER_LEVEL,";
    		$query [] = " PASSWORD,";
    		$query [] = " NAME,";
    		$query [] = " SEX,";
    		$query [] = " E_MAIL,";
    		$query [] = " TEL,";
    		$query [] = " ADDRESS,";
    		$query [] = " POST_NO,";
    		$query [] = " MEMBER_ST,";
    		$query [] = " NEWS_YN,";
    		$query [] = " REG_DATE,";
    		$query [] = " ACC_DATE,";
    		$query [] = " JUMIN,";
    		$query [] = " HOME,";
    		$query [] = " POINT,";
    		$query [] = " USER_ID_OPEN,";
    		$query [] = " MEMBER_LEVEL_OPEN,";
    		$query [] = " NAME_OPEN,";
    		$query [] = " SEX_OPEN,";
    		$query [] = " E_MAIL_OPEN,";
    		$query [] = " HOME_OPEN,";
    		$query [] = " TEL_OPEN,";
    		$query [] = " ADDRESS_OPEN,";
    		$query [] = " POST_NO_OPEN,";
    		$query [] = " POINT_OPEN,";
    		$query [] = " PICTURE_IMAGE_OPEN,";
    		$query [] = " CHARACTER_IMAGE_OPEN,";
    		$query [] = " BIRTH,";
    		$query [] = " AGE,";
    		$query [] = " BIRTH_OPEN,";
    		$query [] = " AGE_OPEN,";
    		$query [] = " ACCESS,";
    		$query [] = " ACCESS_OPEN,";
    		$query [] = " HINT,";
    		$query [] = " ANSWER,";
    		$query [] = " NICK_NAME,";
    		$query [] = " NICK_NAME_OPEN";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[user_id] . "',";
    		$query [] = " '" . $argus[member_level] . "',";
    		$query [] = " '" . $argus[password] . "',";
    		$query [] = " '" . $argus[name] . "',";
    		$query [] = " '" . $argus[sex] . "',";
    		$query [] = " '" . $argus[e_mail] . "',";
    		$query [] = " '" . $argus[tel] . "',";
    		$query [] = " '" . $argus[address] . "',";
    		$query [] = " '" . $argus[post_no] . "',";
    		$query [] = " '" . $argus[member_st] . "',";
    		$query [] = " '" . $argus[news_yn] . "',";
    		$query [] = " '" . $argus[reg_date] . "',";
    		$query [] = " '" . $argus[acc_date] . "',";
    		$query [] = " '" . $argus[jumin] . "',";
    		$query [] = " '" . $argus[home] . "',";
    		$query [] = " '" . $argus[point] . "',";
    		$query [] = " '" . $argus[user_id_open] . "',";
    		$query [] = " '" . $argus[member_level_open] . "',";
    		$query [] = " '" . $argus[name_open] . "',";
    		$query [] = " '" . $argus[sex_open] . "',";
    		$query [] = " '" . $argus[e_mail_open] . "',";
    		$query [] = " '" . $argus[home_open] . "',";
    		$query [] = " '" . $argus[tel_open] . "',";
    		$query [] = " '" . $argus[address_open] . "',";
    		$query [] = " '" . $argus[post_no_open] . "',";
    		$query [] = " '" . $argus[point_open] . "',";
    		$query [] = " '" . $argus[picture_image_open] . "',";
    		$query [] = " '" . $argus[character_image_open] . "',";
    		$query [] = " '" . $argus[birth] . "',";
    		$query [] = " '" . $argus[age] . "',";
    		$query [] = " '" . $argus[birth_open] . "',";
    		$query [] = " '" . $argus[age_open] . "',";
    		$query [] = " '" . $argus[access] . "',";
    		$query [] = " '" . $argus[access_open] . "',";
    		$query [] = " '" . $argus[hint] . "',";
    		$query [] = " '" . $argus[answer] . "',";
    		$query [] = " '" . $argus[nick_name] . "',";
    		$query [] = " '" . $argus[nick_name_open] . "'";
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
//                else {
//                	$file_no1 = 0;
////                 	echo DATA_DIR . DIRECTORY_SEPARATOR . KyhMember::$SAVE_SUB_DIR;
//                	$uploader  = new FileUpload(true,DATA_DIR . DIRECTORY_SEPARATOR . KyhMember::$SAVE_SUB_DIR); // 업로드 인스턴스 생성
////                 	var_dump($uploader);
//                	$uploader->getItem('file1')->setSaveName("f1_".$no."_");
//                	$uploader->upload(); 
//                	$f1 = $uploader->getItem('file1');
//// 					echo $f1->getErrorCode() . '<BR>';
//                	if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {
//                		$file_no1 = Common::insertFileInfor($this->db, PROC_TYPE_BBSNOTICE, USER_NO, $f1->getName(), $f1->getExt(), $f1->getSize());
//                	}
//                	if ( $file_no1 !=0 ) $updateInfor[] = " FILE_NO1 = '" . $file_no1 . "'";
//                	if ( !empty($updateInfor) ) {
//                		$this->db->setAutoCommit(false);
//                		$this->exec(
//                				"UPDATE " .TBL_TBL_BBS_DATA_NOTICE . " SET"
//                				. join(",\n", $updateInfor)
//                				. " WHERE NO = '" .$no . "'"
//                		);
//                	
//                		$this->db->commit();
//                	}
//                }
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
        $p_no = $argus[no];
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_KYH_MEMBER;
            $query [] = " SET";
            $query [] = " NO = '" . $argus[no] . "',";
            $query [] = " USER_ID = '" . $argus[user_id] . "',";
            $query [] = " MEMBER_LEVEL = '" . $argus[member_level] . "',";
            $query [] = " PASSWORD = '" . $argus[password] . "',";
            $query [] = " NAME = '" . $argus[name] . "',";
            $query [] = " SEX = '" . $argus[sex] . "',";
            $query [] = " E_MAIL = '" . $argus[e_mail] . "',";
            $query [] = " TEL = '" . $argus[tel] . "',";
            $query [] = " ADDRESS = '" . $argus[address] . "',";
            $query [] = " POST_NO = '" . $argus[post_no] . "',";
            $query [] = " MEMBER_ST = '" . $argus[member_st] . "',";
            $query [] = " NEWS_YN = '" . $argus[news_yn] . "',";
            $query [] = " REG_DATE = '" . $argus[reg_date] . "',";
            $query [] = " ACC_DATE = '" . $argus[acc_date] . "',";
            $query [] = " JUMIN = '" . $argus[jumin] . "',";
            $query [] = " HOME = '" . $argus[home] . "',";
            $query [] = " POINT = '" . $argus[point] . "',";
            $query [] = " USER_ID_OPEN = '" . $argus[user_id_open] . "',";
            $query [] = " MEMBER_LEVEL_OPEN = '" . $argus[member_level_open] . "',";
            $query [] = " NAME_OPEN = '" . $argus[name_open] . "',";
            $query [] = " SEX_OPEN = '" . $argus[sex_open] . "',";
            $query [] = " E_MAIL_OPEN = '" . $argus[e_mail_open] . "',";
            $query [] = " HOME_OPEN = '" . $argus[home_open] . "',";
            $query [] = " TEL_OPEN = '" . $argus[tel_open] . "',";
            $query [] = " ADDRESS_OPEN = '" . $argus[address_open] . "',";
            $query [] = " POST_NO_OPEN = '" . $argus[post_no_open] . "',";
            $query [] = " POINT_OPEN = '" . $argus[point_open] . "',";
            $query [] = " PICTURE_IMAGE_OPEN = '" . $argus[picture_image_open] . "',";
            $query [] = " CHARACTER_IMAGE_OPEN = '" . $argus[character_image_open] . "',";
            $query [] = " BIRTH = '" . $argus[birth] . "',";
            $query [] = " AGE = '" . $argus[age] . "',";
            $query [] = " BIRTH_OPEN = '" . $argus[birth_open] . "',";
            $query [] = " AGE_OPEN = '" . $argus[age_open] . "',";
            $query [] = " ACCESS = '" . $argus[access] . "',";
            $query [] = " ACCESS_OPEN = '" . $argus[access_open] . "',";
            $query [] = " HINT = '" . $argus[hint] . "',";
            $query [] = " ANSWER = '" . $argus[answer] . "',";
            $query [] = " NICK_NAME = '" . $argus[nick_name] . "',";
            $query [] = " NICK_NAME_OPEN = '" . $argus[nick_name_open] . "'";
            //$query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " NO = '" . $p_no . "'";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
//                out.print($this->db->getAffectedRows());
//                    $saveDir = DATA_DIR . DIRECTORY_SEPARATOR . KyhMember::$SAVE_SUB_DIR;
//                    $uploader  = new FileUpload(true,$saveDir); // 업로드 인스턴스 생성
//
//                    $f1 = $uploader->getItem('file1')->setSaveName("f1_".$p_no."_");
//                    if ( $argus[file1_delete] == 'Y' ) {
//                        @unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
//                        Common::deleteFileInfor($this->db, $file_no1);
//                        $file_no1 = 0;
//                    }
//                    /* @var BizConsult Table file no 갱신 */
//                    $fileInforUpdate = array();
//                    if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {
//                        if ( !$file_no1 ) {
//                            $file_no1 = Common::insertFileInfor($this->db, $proc_type, USER_NO, $f1->getName(), $f1->getExt(), $f1->getSize());
//                            $fileInforUpdate[] = " FILE_NO1 = '" . $file_no1 . "'";
//                        } else {
//                            @unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
//                            $file_no1 = Common::updateFileInfor($this->db, $file_no1, $f1->getName(), $f1->getExt(), $f1->getSize());
//                        }
//                        $f1->upload();
//                    }
//                    if ( !empty($fileInforUpdate) ) {
//                        $this->exec(
//                                "UPDATE " .TBL_TBL_BBS_DATA_NOTICE . " SET"
//                                . join(",\n", $fileInforUpdate)
//                                . " WHERE NO = '" .$p_no . "'"
//                        );
//                    }
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
     * 저장
     * @param array $argus
     * @return string
     */
    public function save($argus) {
        $p_mode  = $argus['mode'][0];
        $p_no = $argus[no];
//        if ( $p_mode == C_DB_PROCESS_MODE_DELETE ) {
//            // 파일정보
//            $query = array();
//            $query [] = "SELECT ";
//            $query [] = " FILE_NO1 ";
//            $query [] = " FROM ". TBL_KYH_MEMBER;
//            $query [] = " WHERE ";
//            $query [] = " NO = '" . $p_no . "'";
//            $infor = $this->db->get(join(PHP_EOL, $query));
//
//            $file_no1 = $infor->FILE_NO1;
//        }
//        if ( $p_mode == C_DB_PROCESS_MODE_DELETE ) {
//            if (parent::save($argus,false)) {
//                $oldFileInfor = Common::getFileInfor($this->db,array(FILE_NO1=>$file_no1),"FILE_NO,FILE_EXT");
//                $oldFile1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;
//
//                // 파일 삭제.
//                $saveDir = DATA_DIR . DIRECTORY_SEPARATOR . KyhMember::$SAVE_SUB_DIR;
//                @unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
//                Common::deleteFileInfor($this->db, $file_no1);
//                $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
//
//            } else {
//                $this->addErrMessage("저장중 오류발생 : 확인하세요.");
//            }
//            $this->printXML(C_DB_PROCESS_MODE_PROC);
//
//        } else {
            parent::save($argus);
//        }
    } 
//    /**
//     * 저장
//     * @param array $argus
//     * @return string
//     */
//    public function save($argus) {
//    	$p_mode       = $argus['mode'][0];
//        $p_no = $argus[no];
//    	if (parent::save($argus,false)) {
//    		$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
//    	} else {
//    		$this->addErrMessage("저장중 오류가발생하였습니다.");
//    	}
//    	$this->printXML(C_DB_PROCESS_MODE_PROC);
//    }

    
    /**
     * 삭제
     * @param array $argus
     * @return boolean
     */
    public function delete($argus) {
        $p_no = $argus[no];
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            // 파일정보
            $query = array();
            $query [] = "SELECT ";
            $query [] = " FILE_NO1 ";
            $query [] = " FROM ". TBL_KYH_MEMBER;
            $query [] = " WHERE ";
            $query [] = " NO = '" . $p_no . "'";
            $infor = $this->db->get(join(PHP_EOL, $query));

            $file_no1 = $infor->FILE_NO1;
            $query = array();
            $query [] = "DELETE FROM " . TBL_KYH_MEMBER;
            $query [] = " WHERE ";
            $query [] = " NO = '" . $p_no . "'";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
//                out.print($this->db->getAffectedRows());

                // 담당자정보 삭제.
                // if ( !Worker::externalDelete($this->db, array(p_worker_no=>$p_worker_no)) ) throw new Exception($this->db->getErrMsg());

                $oldFileInfor = Common::getFileInfor($this->db,array(FILE_NO1=>$file_no1),"FILE_NO,FILE_EXT");
                $oldFile1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;

                // 파일 삭제.
                $saveDir = DATA_DIR . DIRECTORY_SEPARATOR . KyhMember::$SAVE_SUB_DIR;
                @unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
                Common::deleteFileInfor($this->db, $file_no1);
                if ( !$this->db->commit() ) throw new Exception("삭제처리중 에러가 발생하였습니다.");
            } else {
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
   // # test path : http://local-framework.com/KyhMember.php
   $test = new KyhMember();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_KYH_MEMBER );
   $test->test($argus);
/*

   // insert 
   $argus[no]  = 'data';
   $argus[user_id]  = 'data';
   $argus[member_level]  = 'data';
   $argus[password]  = 'data';
   $argus[name]  = 'data';
   $argus[sex]  = 'data';
   $argus[e_mail]  = 'data';
   $argus[tel]  = 'data';
   $argus[address]  = 'data';
   $argus[post_no]  = 'data';
   $argus[member_st]  = 'data';
   $argus[news_yn]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[acc_date]  = 'data';
   $argus[jumin]  = 'data';
   $argus[home]  = 'data';
   $argus[point]  = 'data';
   $argus[user_id_open]  = 'data';
   $argus[member_level_open]  = 'data';
   $argus[name_open]  = 'data';
   $argus[sex_open]  = 'data';
   $argus[e_mail_open]  = 'data';
   $argus[home_open]  = 'data';
   $argus[tel_open]  = 'data';
   $argus[address_open]  = 'data';
   $argus[post_no_open]  = 'data';
   $argus[point_open]  = 'data';
   $argus[picture_image_open]  = 'data';
   $argus[character_image_open]  = 'data';
   $argus[birth]  = 'data';
   $argus[age]  = 'data';
   $argus[birth_open]  = 'data';
   $argus[age_open]  = 'data';
   $argus[access]  = 'data';
   $argus[access_open]  = 'data';
   $argus[hint]  = 'data';
   $argus[answer]  = 'data';
   $argus[nick_name]  = 'data';
   $argus[nick_name_open]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[no]  = 'key';
   // data field 
   $argus[user_id]  = 'data';
   $argus[member_level]  = 'data';
   $argus[password]  = 'data';
   $argus[name]  = 'data';
   $argus[sex]  = 'data';
   $argus[e_mail]  = 'data';
   $argus[tel]  = 'data';
   $argus[address]  = 'data';
   $argus[post_no]  = 'data';
   $argus[member_st]  = 'data';
   $argus[news_yn]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[acc_date]  = 'data';
   $argus[jumin]  = 'data';
   $argus[home]  = 'data';
   $argus[point]  = 'data';
   $argus[user_id_open]  = 'data';
   $argus[member_level_open]  = 'data';
   $argus[name_open]  = 'data';
   $argus[sex_open]  = 'data';
   $argus[e_mail_open]  = 'data';
   $argus[home_open]  = 'data';
   $argus[tel_open]  = 'data';
   $argus[address_open]  = 'data';
   $argus[post_no_open]  = 'data';
   $argus[point_open]  = 'data';
   $argus[picture_image_open]  = 'data';
   $argus[character_image_open]  = 'data';
   $argus[birth]  = 'data';
   $argus[age]  = 'data';
   $argus[birth_open]  = 'data';
   $argus[age_open]  = 'data';
   $argus[access]  = 'data';
   $argus[access_open]  = 'data';
   $argus[hint]  = 'data';
   $argus[answer]  = 'data';
   $argus[nick_name]  = 'data';
   $argus[nick_name_open]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[no]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[no]  = 'key';
   $test->select($argus); 

*/
}
?>
