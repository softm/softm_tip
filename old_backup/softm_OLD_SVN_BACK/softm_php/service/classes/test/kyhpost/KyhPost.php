<?php
define("DEBUG",preg_match("/\/service\/classes/", $_SERVER[PHP_SELF]));
define("TBL_KYH_POST","designboard.kyh_post");
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
 *  / KyhPost.php
 */
class KyhPost extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_KYH_POST);
			$seq = 0;
    		$tbl1->newColumn('ZIPCODE','zipcode',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('SIDO','sido',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('GUGUN','gugun',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('DONG','dong',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('RI','ri',++$seq)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('BUNJI','bunji',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('ST','st',++$seq)->setWidth(100)->setEditable(true);
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
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_KYH_POST . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " ZIPCODE,";
    		$query [] = " SIDO,";
    		$query [] = " GUGUN,";
    		$query [] = " DONG,";
    		$query [] = " RI,";
    		$query [] = " BUNJI,";
    		$query [] = " ST";
    		$query [] = " FROM " . TBL_KYH_POST;

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

    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " ZIPCODE,";
    		$query [] = " SIDO,";
    		$query [] = " GUGUN,";
    		$query [] = " DONG,";
    		$query [] = " RI,";
    		$query [] = " BUNJI,";
    		$query [] = " ST";
            $query [] = " FROM " . TBL_KYH_POST;
            $query [] = " WHERE ";
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

    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_KYH_POST ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_KYH_POST;
            $query [] = "(";
    		$query [] = " ZIPCODE,";
    		$query [] = " SIDO,";
    		$query [] = " GUGUN,";
    		$query [] = " DONG,";
    		$query [] = " RI,";
    		$query [] = " BUNJI,";
    		$query [] = " ST";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[zipcode] . "',";
    		$query [] = " '" . $argus[sido] . "',";
    		$query [] = " '" . $argus[gugun] . "',";
    		$query [] = " '" . $argus[dong] . "',";
    		$query [] = " '" . $argus[ri] . "',";
    		$query [] = " '" . $argus[bunji] . "',";
    		$query [] = " '" . $argus[st] . "'";
            //$query [] = " now() ";
            $query [] = " );";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
//                out.print($this->db->getAffectedRows());
            if ( !$this->db->commit() ) throw new Exception("입력처리중 에러가 발생하였습니다.");
//                else {
//                	$file_no1 = 0;
////                 	echo DATA_DIR . DIRECTORY_SEPARATOR . KyhPost::$SAVE_SUB_DIR;
//                	$uploader  = new FileUpload(true,DATA_DIR . DIRECTORY_SEPARATOR . KyhPost::$SAVE_SUB_DIR); // 업로드 인스턴스 생성
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

    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_KYH_POST;
            $query [] = " SET";
            $query [] = " ZIPCODE = '" . $argus[zipcode] . "',";
            $query [] = " SIDO = '" . $argus[sido] . "',";
            $query [] = " GUGUN = '" . $argus[gugun] . "',";
            $query [] = " DONG = '" . $argus[dong] . "',";
            $query [] = " RI = '" . $argus[ri] . "',";
            $query [] = " BUNJI = '" . $argus[bunji] . "',";
            $query [] = " ST = '" . $argus[st] . "'";
            //$query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
//                out.print($this->db->getAffectedRows());
//                    $saveDir = DATA_DIR . DIRECTORY_SEPARATOR . KyhPost::$SAVE_SUB_DIR;
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

//        if ( $p_mode == C_DB_PROCESS_MODE_DELETE ) {
//            // 파일정보
//            $query = array();
//            $query [] = "SELECT ";
//            $query [] = " FILE_NO1 ";
//            $query [] = " FROM ". TBL_KYH_POST;
//            $query [] = " WHERE ";
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
//                $saveDir = DATA_DIR . DIRECTORY_SEPARATOR . KyhPost::$SAVE_SUB_DIR;
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
//
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

    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            // 파일정보
            $query = array();
            $query [] = "SELECT ";
            $query [] = " FILE_NO1 ";
            $query [] = " FROM ". TBL_KYH_POST;
            $query [] = " WHERE ";
            $infor = $this->db->get(join(PHP_EOL, $query));

            $file_no1 = $infor->FILE_NO1;
            $query = array();
            $query [] = "DELETE FROM " . TBL_KYH_POST;
            $query [] = " WHERE ";
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
                $saveDir = DATA_DIR . DIRECTORY_SEPARATOR . KyhPost::$SAVE_SUB_DIR;
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
   // # test path : http://local-framework.com/KyhPost.php
   $test = new KyhPost();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_KYH_POST );
   $test->test($argus);
/*

   // insert 
   $argus[zipcode]  = 'data';
   $argus[sido]  = 'data';
   $argus[gugun]  = 'data';
   $argus[dong]  = 'data';
   $argus[ri]  = 'data';
   $argus[bunji]  = 'data';
   $argus[st]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 

   // data field 
   $argus[zipcode]  = 'data';
   $argus[sido]  = 'data';
   $argus[gugun]  = 'data';
   $argus[dong]  = 'data';
   $argus[ri]  = 'data';
   $argus[bunji]  = 'data';
   $argus[st]  = 'data';
   out.print($test->update($argus)); 

   // delete

   out.print($test->delete($argus)); 

   select

   $test->select($argus); 

*/
}
?>
