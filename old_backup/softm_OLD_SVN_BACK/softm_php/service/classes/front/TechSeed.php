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
require_once SERVICE_DIR . '/classes/base/Worker.php'; // 담당자 클래스

/**
 * @author softm
 * 기술시드 / TechSeed.php
 */
class TechSeed extends BaseDataBase
{
	/** @var upload file directory */ public static $SAVE_SUB_DIR = "tech_seed";

    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_TECH_SEED);
    		$tbl1->newColumn('TECH_NO' ,'번호',1)->setWidth(80)->setEditable(false);
    		$tbl1->newColumn('CAT_NM'  ,'분야',2)->setWidth(140)->setEditable(false)->setCssText("text-align:left");
    		$tbl1->newColumn('ORGAN'   ,'기관명',3)->setWidth(150)->setEditable(false)->setCssText("text-align:left");
    		$tbl1->newColumn('TECH_NM' ,'기술명',4)->setWidth(250)->setEditable(false)->setCssText("text-align:left")->setHTML(true);
	        $tbl1->newColumn("FILE_NO1",'첨부파일',5)->setHtml(true)->setCssText("padding-top: 13px;")->setWidth(100);
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
		$s_l_cat          = $argus[s_l_cat];
		$s_m_cat          = $argus[s_m_cat];
		$s_s_cat          = $argus[s_s_cat];

		$s_tech_nm        = $argus[s_tech_nm       ];
		$s_license_number = $argus[s_license_number];
		$s_organ          = $argus[s_organ         ];
		$s_keyword        = $argus[s_keyword       ];

    	$this->getCodeData(); // code xml 생성
    	$this->startXML();
    	$this->setType(BaseDataBase::GRID_TYPE);
    	try {
//     		if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
//    		var_dump($argus);
    		$page_tab['js_function' ] = $argus["p_navi_function"];
    		$page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
    		if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];

    		// where 문장생성
//     		$make_where = $this->makeWhere($argus);
//     		$where = $make_where;
    		$where = " TECH_NO <> 0  "
    		       . ($s_l_cat         ?" AND a.TECH_L_CAT     = '" . $s_l_cat . "'":"")
    		       . ($s_m_cat         ?" AND a.TECH_M_CAT     = '" . $s_m_cat . "'":"")
    		       . ($s_s_cat         ?" AND a.TECH_S_CAT     = '" . $s_s_cat . "'":"")
    		       . ($s_tech_nm       ?" AND a.TECH_NM        LIKE '" . $s_tech_nm        . "%'":"")
    		       . ($s_license_number?" AND a.LICENSE_NUMBER LIKE '" . $s_license_number . "%'":"")
    		       . ($s_organ         ?" AND a.ORGAN          LIKE '" . $s_organ          . "%'":"")
    		       . ($s_keyword       ?" AND a.KEYWORD        LIKE '" . $s_keyword        . "%'":"")
    		;

    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_TECH_SEED . " a" . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();

    		$query [] = " SELECT ";
    		$query [] = " a.TECH_NO                           TECH_NO ,";
    		$query [] = " b.NM                                CAT_NM  ,"; // 기술분야
    		$query [] = " a.ORGAN                             ORGAN   ,";
//     		$query [] = " a.TECH_NM                           TECH_NM ,";
   			$query [] = " CONCAT('<div style=\"width:250px\" class=textOf>',TECH_NM,'</div>')        TECH_NM,";
    		$query [] = " DATE_FORMAT(a.REG_DATE,'%Y-%m-%d')  REG_DATE,";
    		$query [] = " IF(FILE_NO1<>0,CONCAT('<a href=# fileno=',FILE_NO1,'>첨부파일</a>'),'&nbsp;')        FILE_NO1,";
    		$query [] = " a.USER_NO                           USER_NO  ";
    		$query [] = " FROM " . TBL_TECH_SEED . " a LEFT OUTER JOIN " . TBL_TECH_CATEGORY . " b";
    		$query [] = " ON CONCAT(a.TECH_L_CAT,IF(a.TECH_M_CAT='','00',a.TECH_M_CAT),IF(a.TECH_S_CAT='','00',a.TECH_S_CAT)) = CONCAT(b.L_CAT,b.M_CAT,b.S_CAT)";

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
        $p_tech_no = $argus[p_tech_no];

        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
            $query = array();
            $query [] = "SELECT ";
            $query [] = " TECH_NO P_TECH_NO,";
            $query [] = " TECH_NO,";
            $query [] = " REG_CODE,";
            $query [] = " TECH_L_CAT,";
            $query [] = " TECH_M_CAT,";
            $query [] = " TECH_S_CAT,";
            $query [] = " ORGAN,";
            $query [] = " URL,";
            $query [] = " TECH_NM,";
            $query [] = " TECH_NM_JP,";
            $query [] = " LICENSE_NUMBER,";
            $query [] = " PURPOSE,";
            $query [] = " PURPOSE_JP,";
            $query [] = " OUTLINE,";
            $query [] = " OUTLINE_JP,";
            $query [] = " FEATURE,";
            $query [] = " FEATURE_JP,";
            $query [] = " KEYWORD,";
            $query [] = " KEYWORD_JP,";
            $query [] = " FILE_NO1,";
            $query [] = " OPEN_YN,";
            $query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
            $query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE,";
            $query [] = " USER_NO,";
            $query [] = " WORKER_NO";
            $query [] = " FROM " . TBL_TECH_SEED;

            $query [] = " WHERE ";
            $query [] = " TECH_NO = '" . $p_tech_no . "'";
            $this->setQuery(join(PHP_EOL, $query));

            $sql = join(PHP_EOL, $query);
//             $this->appendNode("sql", $sql);
            $tech_seed = $this->db->get($sql,"array");

            $fInfor = $this->db->get(
            		"SELECT "
            		. "FILE_NO1  "
            		. " FROM ". TBL_TECH_SEED
            		. " WHERE TECH_NO = '" . $p_tech_no . "'"
            );
            $file_no1 = $fInfor->FILE_NO1;

            $oldFileInfor = Common::getFileInfor($this->db,$fInfor,"FILE_NO,FILE_NAME,FILE_EXT,FILE_SIZE");
            $oldFile1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;
            $file1Name = $oldFileInfor['FILE_NO1']->FILE_NAME;
            $file1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;

            $this->appendNode('filename1', $file1Name);
            $this->appendNode('fileext1', $file1Ext);
            $this->appendNode('fileno1', $file_no1);

            // 담당자 정보조회
            $worker = Worker::externalGet($this->db, array(p_worker_no=>$tech_seed[WORKER_NO]));

            $this->oneRowToXML(array_merge($worker,$tech_seed),"item","fi");

            $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
        } catch (Exception $e) {
            $this->addErrMessage($e->getMessage());
        }
        $this->printXML(C_DB_PROCESS_MODE_SELECT);
    }

    /**
     * 조회.(외부클래스)
     * @param Database $db
     * @param array $argus
     * @return array
     */
    public static function externalGet($db,$argus) {
    	//$p_user_id   = $argus[user_email  ];
    	$p_tech_no = $argus[p_tech_no];
    	$rtn = array();
    	try {
    		if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
    		if ( !$p_tech_no ) throw new Exception("기술시드정보가 없습니다.");
    		$query = array();
            $query [] = "SELECT ";
            $query [] = " TECH_NO P_TECH_NO,";
            $query [] = " TECH_NO,";
            $query [] = " REG_CODE AS TECH_REG_CODE,";
            $query [] = " TECH_L_CAT,";
            $query [] = " TECH_M_CAT,";
            $query [] = " TECH_S_CAT,";
            $query [] = " ORGAN,";
            $query [] = " URL,";
            $query [] = " TECH_NM,";
            $query [] = " TECH_NM_JP,";
            $query [] = " LICENSE_NUMBER,";
            $query [] = " PURPOSE,";
            $query [] = " PURPOSE_JP,";
            $query [] = " OUTLINE,";
            $query [] = " OUTLINE_JP,";
            $query [] = " FEATURE,";
            $query [] = " FEATURE_JP,";
            $query [] = " KEYWORD,";
            $query [] = " KEYWORD_JP,";
            $query [] = " FILE_NO1,";
            $query [] = " OPEN_YN,";
            $query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
            $query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE,";
            $query [] = " USER_NO,";
            $query [] = " WORKER_NO";
            $query [] = " FROM " . TBL_TECH_SEED;

            $query [] = " WHERE ";
            $query [] = " TECH_NO = '" . $p_tech_no . "'";
    		$sql = join(PHP_EOL, $query);
    		$rtn = $db->get($sql,"array");
    		if ( empty($rtn) ) $rtn = array();
    	} catch (Exception $e) {
    		return $rtn;
    	}
    	return $rtn;
    }

    /**
     * 자료존재여부검사
     * @param array $argus
     * @return DOMDocument
     */
    public function existCheck($argus) {
        //$p_user_id   = $argus[user_email  ];
        $p_tech_no = $argus[p_tech_no];

        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
            $query = array();
            $query [] = "SELECT ";
            $query [] = " COUNT(*) AS COUNT";
            $query [] = " FROM " . TBL_TECH_SEED;
            $query [] = " WHERE ";
            $query [] = " TECH_NO = '" . $p_tech_no . "'";
            $this->setQuery(join(PHP_EOL, $query));

            $sql = join(PHP_EOL, $query);
//             $this->appendNode("sql", $sql);
            $count = $this->db->getOne($sql);
			$this->appendNode("count",$count);
            $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
        } catch (Exception $e) {
            $this->addErrMessage($e->getMessage());
        }
        $this->printXML(C_DB_PROCESS_MODE_SELECT);
    }


//     /**
//      * 입력
//      * @param array $argus
//      * @return int
//      */
//     public function insert($argus) {
//         $p_tech_no = $argus[p_tech_no];

//         $cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED ) ,0) + 1 FROM " . TBL_TECH_SEED ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
// //             	echo $cnt . "<BR>";
//         $reg_code =sprintf('%s%s%04d','JS',date("Ymd"),$cnt);

//         $this->testJsCall($argus);
//         $this->startXML();
//         try {
//             if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
//             $query = array();
//             $query [] = "INSERT INTO " . TBL_TECH_SEED;
//             $query [] = "(";
//             $query [] = " REG_CODE,";
//             $query [] = " TECH_L_CAT,";
//             $query [] = " TECH_M_CAT,";
//             $query [] = " TECH_S_CAT,";
//             $query [] = " ORGAN,";
//             $query [] = " URL,";
//             $query [] = " TECH_NM,";
//             $query [] = " TECH_NM_JP,";
//             $query [] = " LICENSE_NUMBER,";
//             $query [] = " PURPOSE,";
//             $query [] = " PURPOSE_JP,";
//             $query [] = " OUTLINE,";
//             $query [] = " OUTLINE_JP,";
//             $query [] = " FEATURE,";
//             $query [] = " FEATURE_JP,";
//             $query [] = " KEYWORD,";
//             $query [] = " KEYWORD_JP,";
// //             $query [] = " FILE_NO1,";
//             $query [] = " OPEN_YN,";
//             $query [] = " REG_DATE,";
//             $query [] = " USER_NO";
//             $query [] = " ) VALUES (";
//     		$query [] = " '" . $reg_code     . "',";
//             $query [] = " '" . $argus[tech_l_cat] . "',";
//             $query [] = " '" . $argus[tech_m_cat] . "',";
//             $query [] = " '" . $argus[tech_s_cat] . "',";
//             $query [] = " '" . $argus[organ] . "',";
//             $query [] = " '" . $argus[url] . "',";
//             $query [] = " '" . $argus[tech_nm] . "',";
//             $query [] = " '" . $argus[tech_nm_jp] . "',";
//             $query [] = " '" . $argus[license_number] . "',";
//             $query [] = " '" . $argus[purpose] . "',";
//             $query [] = " '" . $argus[purpose_jp] . "',";
//             $query [] = " '" . $argus[outline] . "',";
//             $query [] = " '" . $argus[outline_jp] . "',";
//             $query [] = " '" . $argus[feature] . "',";
//             $query [] = " '" . $argus[feature_jp] . "',";
//             $query [] = " '" . $argus[keyword] . "',";
//             $query [] = " '" . $argus[keyword_jp] . "',";
// //             $query [] = " '" . $argus[file_no1] . "',";
//             $query [] = " '" . $argus[open_yn] . "',";
//             $query [] = " now(),";
//             $query [] = " '" . USER_NO . "'";
//             $query [] = " );";

//             $this->setQuery(join(PHP_EOL, $query));
// //            out.print($this->getQuery());
//             $this->db->setAutoCommit(false);
//             if ( $this->db->exec($this->getQuery()) ) {
//                 $tech_no = $this->db->getInsertId(); // insert id
//                 $this->appendNode("insert_id", $tech_no);
// //                out.print($this->db->getAffectedRows());
//                 if ( !$this->db->commit() ) throw new Exception("입력처리중 에러가 발생하였습니다.");
// 				else {
// 					// 담당자정보 입력.
// 					$worker_no = Worker::externalInsert($this->db, $argus);
// // 					echo $worker_no;
// 					$this->appendNode("insert_worker_no", $worker_no);

// 					$updateInfor = array();
// 					$updateInfor[] = " WORKER_NO = '" . $worker_no . "'";

// 					$file_no1 = 0;
// 					$file_no2 = 0;
// 					$file_no3 = 0;

// 					$uploader  = new FileUpload(true,DATA_DIR . DIRECTORY_SEPARATOR . TechSeed::$SAVE_SUB_DIR); // 업로드 인스턴스 생성
// 					$uploader->getItem('file1')->setSaveName("f1_".$tech_no."_");
// 					$uploader->upload();

// 					$f1 = $uploader->getItem('file1');
// 					if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {
// 						$file_no1 = Common::insertFileInfor($this->db, PROC_TYPE_SR, USER_NO, $tech_no, $f1->getName(), $f1->getExt(), $f1->getSize());
// 					}

// 					if ( $file_no1 !=0 ) $fileInforUpdate[] = " FILE_NO1 = '" . $file_no1 . "'";
// 					if ( !empty($updateInfor) ) {
// 						$this->db->setAutoCommit(false);

// 						$this->exec(
// 								"UPDATE " .TBL_TECH_SEED . " SET"
// 								. join(",\n", $updateInfor)
// 								. " WHERE TECH_NO = '" .$tech_no . "'"
// 						);
// 						$this->db->commit();
// 					}
// 				}
//             } else {
// //                out.print($this->db->getErrMsg());
//                 throw new Exception($this->db->getErrMsg());
// //               throw new Exception("입력처리중 에러가 발생하였습니다.");
//             }
//         } catch (Exception $e) {
//             $this->addErrMessage($e->getMessage());
//             $this->db->rollback();
//         }
//         $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_INSERT)); // 성공시 출력 메시지.
//         $this->printXML(C_DB_PROCESS_MODE_INSERT);
//     }

//     /**
//      * 수정
//      * @param array $argus
//      * @return boolean
//      */
//     public function update($argus) {
//         $p_tech_no = $argus[p_tech_no];

//         $this->testJsCall($argus);
//         $this->startXML();
//         try {
//             if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
//             // 파일정보
//             $fInfor = $this->db->get(
//             		"SELECT "
//             		. "FILE_NO1, "
//             		. "USER_NO   "
//             		. " FROM ". TBL_TECH_SEED
//             		. " WHERE TECH_NO = '" . $p_tech_no . "'"
//             );
//             $file_no1 = $fInfor->FILE_NO1;
//             $user_no  = $fInfor->USER_NO;

//             //     							echo '$oldFileInfor ' . $fInfor['FILE_NO1']->FILE_EXT;
//             $oldFileInfor = Common::getFileInfor($this->db,array(FILE_NO1=>$file_no1),"FILE_NO,FILE_EXT");
//             $oldFile1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;

//             $query = array();
//             $query [] = "UPDATE " . TBL_TECH_SEED;
//             $query [] = " SET";
//             $query [] = " TECH_L_CAT = '" . $argus[tech_l_cat] . "',";
//             $query [] = " TECH_M_CAT = '" . $argus[tech_m_cat] . "',";
//             $query [] = " TECH_S_CAT = '" . $argus[tech_s_cat] . "',";
//             $query [] = " ORGAN = '" . $argus[organ] . "',";
//             $query [] = " URL = '" . $argus[url] . "',";
//             $query [] = " TECH_NM = '" . $argus[tech_nm] . "',";
//             $query [] = " TECH_NM_JP = '" . $argus[tech_nm_jp] . "',";
//             $query [] = " LICENSE_NUMBER = '" . $argus[license_number] . "',";
//             $query [] = " PURPOSE = '" . $argus[purpose] . "',";
//             $query [] = " PURPOSE_JP = '" . $argus[purpose_jp] . "',";
//             $query [] = " OUTLINE = '" . $argus[outline] . "',";
//             $query [] = " OUTLINE_JP = '" . $argus[outline_jp] . "',";
//             $query [] = " FEATURE = '" . $argus[feature] . "',";
//             $query [] = " FEATURE_JP = '" . $argus[feature_jp] . "',";
//             $query [] = " KEYWORD = '" . $argus[keyword] . "',";
//             $query [] = " KEYWORD_JP = '" . $argus[keyword_jp] . "',";
//     		if ( $argus[file1_delete] == 'Y' ) $query[]  = " FILE_NO1   = NULL,";
//             $query [] = " OPEN_YN = '" . $argus[open_yn] . "',";
//             $query [] = " MOD_DATE = now()";
//             $query [] = " WHERE ";
//             $query [] = " TECH_NO = '" . $p_tech_no . "'";
//             $this->setQuery(join(PHP_EOL, $query));
// //            out.print($this->getQuery());
//             $this->db->setAutoCommit(false);
//             if ( $this->db->exec($this->getQuery()) ) {
// //                out.print($this->db->getAffectedRows());
//                 if ( !$this->db->commit() ) throw new Exception("수정처리중 에러가 발생하였습니다.");
//                 else {
//                 	$this->db->setAutoCommit(false);

//                 	// 담당자정보 수정.
//                 	if ( !Worker::externalUpdate($this->db, $argus) ) throw new Exception("담당자정보가 정확하지 않습니다.");

//                 	$saveDir = DATA_DIR . DIRECTORY_SEPARATOR . TechSeed::$SAVE_SUB_DIR;
//                 	$uploader  = new FileUpload(true,$saveDir); // 업로드 인스턴스 생성

//                 	$f1 = $uploader->getItem('file1')->setSaveName("f1_".$p_tech_no."_");

//                 	if ( $argus[file1_delete] == 'Y' ) {
//                 		@unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_tech_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
//                 		Common::deleteFileInfor($this->db, $file_no1);
//                 		$file_no1 = 0;
//                 	}

//                 	$fileInforUpdate = array();

//                 	if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {
//                 		if ( !$file_no1 ) {
//                 			$file_no1 = Common::insertFileInfor($this->db, PROC_TYPE_SR, $user_no, $p_tech_no, $f1->getName(), $f1->getExt(), $f1->getSize());
//                 			$fileInforUpdate[] = " FILE_NO1 = '" . $file_no1 . "'";
//                 		} else {
//                 			@unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_tech_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
//                 			$file_no1 = Common::updateFileInfor($this->db, $file_no1, $f1->getName(), $f1->getExt(), $f1->getSize());
//                 		}
//                 		$f1->upload();
//                 	}

//                 	if ( !empty($fileInforUpdate) ) {
//                 		$this->exec(
//                 				"UPDATE " .TBL_TECH_SEED . " SET"
//                 				. join(",\n", $fileInforUpdate)
//                 				. " WHERE TECH_NO = '" .$p_tech_no . "'"
//                 		);
//                 	}
//                 	$this->db->commit();
//                 }
//             } else {
// //                out.print($this->db->getErrMsg());
//                 throw new Exception($this->db->getErrMsg());
// //               throw new Exception("수정처리중 에러가 발생하였습니다.");
//             }
//         } catch (Exception $e) {
//             $this->addErrMessage($e->getMessage());
//             $this->db->rollback();
//         }
//         $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_UPDATE)); // 성공시 출력 메시지.
//         $this->printXML(C_DB_PROCESS_MODE_UPDATE);
//     }


//     /**
//      * 삭제
//      * @param array $argus
//      * @return boolean
//      */
//     public function delete($argus) {
//         $p_tech_no = $argus[p_tech_no];

//         $this->testJsCall($argus);
//         $this->startXML();
//         try {
//             if ( !LOGIN ) throw new Exception("로그인후 이용할 수 있습니다.");
//             $query = array();
//             $query [] = "DELETE FROM " . TBL_TECH_SEED;
//             $query [] = " WHERE ";
//             $query [] = " TECH_NO = '" . $p_tech_no . "'";
//             $this->setQuery(join(PHP_EOL, $query));
// //            out.print($this->getQuery());
//             $this->db->setAutoCommit(false);
//             if ( $this->db->exec($this->getQuery()) ) {
// //                out.print($this->db->getAffectedRows());
//                 // 담당자정보 삭제.
//                 if ( !Worker::externalDelete($this->db, $argus) ) throw new Exception("담당자정보가 정확하지 않습니다.");
//                 if ( !$this->db->commit() ) throw new Exception("삭제처리중 에러가 발생하였습니다.");
//                 else {
//                 	Util::unlinkFile(DATA_DIR . DIRECTORY_SEPARATOR . TechSeed::$SAVE_SUB_DIR . DIRECTORY_SEPARATOR . "f1_" . $p_tech_no . "_.*",true);
//                 }
//             } else {
// //                out.print($this->db->getErrMsg());
//                 throw new Exception($this->db->getErrMsg());
// //               throw new Exception("삭제처리중 에러가 발생하였습니다.");
//             }
//         } catch (Exception $e) {
//             $this->addErrMessage($e->getMessage());
//             $this->db->rollback();
//         }
//         $this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_DELETE)); // 성공시 출력 메시지.
//         $this->printXML(C_DB_PROCESS_MODE_DELETE);
//     }


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
   // # test path : http://local-framework.com/TechSeed.php
   $test = new TechSeed();
   $argus = array();

   // test
   $argus[user_email] = "test01";
   $test->setTableName(TBL_TECH_SEED );
   $test->test($argus);
/*

   // insert
   $argus[tech_no]  = 'data';
   $argus[reg_code]  = 'data';
   $argus[tech_sn_field]  = 'data';
   $argus[university]  = 'data';
   $argus[url]  = 'data';
   $argus[nm]  = 'data';
   $argus[nm_jp]  = 'data';
   $argus[license_number]  = 'data';
   $argus[purpose]  = 'data';
   $argus[purpose_jp]  = 'data';
   $argus[outline]  = 'data';
   $argus[outline_jp]  = 'data';
   $argus[feature]  = 'data';
   $argus[feature_jp]  = 'data';
   $argus[keyword]  = 'data';
   $argus[keyword_jp]  = 'data';
   $argus[file_no1]  = 'data';
   $argus[open_yn]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   $argus[user_no]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update
   // key field
   $argus[tech_no]  = 'key';
   // data field
   $argus[reg_code]  = 'data';
   $argus[tech_sn_field]  = 'data';
   $argus[university]  = 'data';
   $argus[url]  = 'data';
   $argus[nm]  = 'data';
   $argus[nm_jp]  = 'data';
   $argus[license_number]  = 'data';
   $argus[purpose]  = 'data';
   $argus[purpose_jp]  = 'data';
   $argus[outline]  = 'data';
   $argus[outline_jp]  = 'data';
   $argus[feature]  = 'data';
   $argus[feature_jp]  = 'data';
   $argus[keyword]  = 'data';
   $argus[keyword_jp]  = 'data';
   $argus[file_no1]  = 'data';
   $argus[open_yn]  = 'data';
   $argus[reg_date]  = 'data';
   $argus[mod_date]  = 'data';
   $argus[user_no]  = 'data';
   out.print($test->update($argus));

   // delete
   $argus[tech_no]  = 'key';
   out.print($test->delete($argus));

   select
   $argus[tech_no]  = 'key';
   $test->select($argus);

*/
}
?>
