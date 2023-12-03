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
 * 질문답변 / Qna.php
 */
class Qna extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_QNA);
			$seq = 0;
    		$tbl1->newColumn('QNA_NO','번호',++$seq)->setWidth(50)->setEditable(false);
    		$tbl1->newColumn('QNA_TYPE','문의유형',++$seq)->setWidth(100)->setType(Column::LISTBOX_TYPE)->setKey(false);
    		$tbl1->newColumn('Q_CONTENT','문의내용',++$seq)->setWidth("90%")->setAlign("left")->setKey(false);
//    		$tbl1->newColumn('A_CONTENT','답변내용',++$seq)->setWidth(100);
//    		$tbl1->newColumn('USER_NO','회원번호',++$seq)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('QNA_STATE','답변상태',++$seq)->setWidth(100)->setType(Column::LISTBOX_TYPE)->setKey(false);
    		$tbl1->newColumn('REG_DATE','작성일',++$seq)->setWidth(200)->setKey(false);
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
//    		if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
//    		var_dump($argus);
    		$page_tab['js_function' ] = $argus["p_navi_function"];
    		$page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
    		if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];

    		// where 문장생성
    		$make_where = $this->makeWhere($argus);
    		$where = $make_where;
            $where = " USER_NO = '" . USER_NO . "'";
            if ( $argus[s_qna_type] ) {
                $where .= " AND QNA_TYPE = '" . $argus[s_qna_type] . "'";
            }
            if ( $argus[s_qna_state] ) {
                $where .= " AND QNA_STATE = '" . $argus[s_qna_state] . "'";
            }
            if ( $argus[s_search] ) {
                $where .= " AND Q_CONTENT LIKE '%" . $argus[s_search] . "%'";
                $where .= "  OR A_CONTENT LIKE '%" . $argus[s_search] . "%'";
            }

    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_QNA . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " QNA_NO,";
    		$query [] = " QNA_TYPE,";
    		$query [] = " Q_CONTENT,";
    		$query [] = " A_CONTENT,";
    		$query [] = " USER_NO,";
    		$query [] = " QNA_STATE,";
            $query [] = " DATE_FORMAT(REG_DATE ,'%Y-%m-%d %p %h:%i:%s') REG_DATE     ";
    		$query [] = " FROM " . TBL_QNA;

    		// where 문장생성
    		if ( $where ) $query[] = ( " WHERE " . $where );

    		$query[] =  ( $this->getQuerySort()?" ORDER BY ". $this->getQuerySort():' ORDER BY QNA_NO DESC' );
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
        $p_qna_no = $argus[p_qna_no];
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
//            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " QNA_NO,";
    		$query [] = " QNA_TYPE,";
    		$query [] = " Q_CONTENT,";
    		$query [] = " A_CONTENT,";
    		$query [] = " USER_NO,";
    		$query [] = " QNA_STATE,";
    		$query [] = " REG_DATE";
            $query [] = " FROM " . TBL_QNA;
            $query [] = " WHERE ";
            $query [] = " QNA_NO = '" . $p_qna_no . "'";
            $query [] = " AND USER_NO = '" . USER_NO . "'";
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
        $p_qna_no = $argus[p_qna_no];
    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_QNA ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) {
            	throw new Exception("로그인정보가 없습니다.");
            }
            $query = array();
            $query [] = "INSERT INTO " . TBL_QNA;
            $query [] = "(";
    		$query [] = " QNA_TYPE,";
    		$query [] = " Q_CONTENT,";
    		$query [] = " A_CONTENT,";
    		$query [] = " USER_NO,";
    		$query [] = " QNA_STATE,";
    		$query [] = " REG_DATE";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[qna_type]  . "',";
    		$query [] = " '" . $argus[q_content] . "',";
    		$query [] = " '" . $argus[a_content] . "',";
    		$query [] = " '" . USER_NO           . "',";
    		$query [] = " '".QNA_STATE_Q."',";
            $query [] = " now() ";
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
////                 	echo DATA_DIR . DIRECTORY_SEPARATOR . Qna::$SAVE_SUB_DIR;
//                	$uploader  = new FileUpload(true,DATA_DIR . DIRECTORY_SEPARATOR . Qna::$SAVE_SUB_DIR); // 업로드 인스턴스 생성
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
        $p_qna_no = $argus[qna_no];
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $q_content = $argus[q_content];
            $a_content = $argus[a_content];
            if ( !ini_get('magic_quotes_gpc') ) {
            	$q_content = addslashes($q_content);
            	$a_content = addslashes($a_content);
            } else {
            }
            
            // 정보
            $infor = $this->db->get(
            		"SELECT "
            		. "QNA_STATE  "
            		. " FROM ". TBL_QNA
            		. " WHERE QNA_NO = '" . $p_qna_no . "'"
            );
            $qState = $infor->QNA_STATE;
            if ( $qState == QNA_STATE_A ) {
            	throw new Exception("답변완료된 문의사항은 수정할 수 없습니다.");
            }
            
            $query = array();
            $query [] = "UPDATE " . TBL_QNA;
            $query [] = " SET";
            $query [] = " QNA_NO = '" . $argus[qna_no] . "',";
            $query [] = " QNA_TYPE = '" . $argus[qna_type] . "',";
            if ( $argus[a_content] )
            	$query [] = " QNA_STATE = '" . QNA_STATE_A . "',";
            else
            	$query [] = " QNA_STATE = '" . QNA_STATE_Q . "',";            
            $query [] = " Q_CONTENT = '" . $q_content . "',";
            $query [] = " A_CONTENT = '" . $a_content . "' ";
//            $query [] = " USER_NO = '" . $argus[user_no] . "',";
			
            //$query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " QNA_NO = '" . $p_qna_no . "'";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
//                out.print($this->db->getAffectedRows());
//                    $saveDir = DATA_DIR . DIRECTORY_SEPARATOR . Qna::$SAVE_SUB_DIR;
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
     * 삭제
     * @param array $argus
     * @return boolean
     */
    public function delete($argus) {
        $p_qna_no = $argus[p_qna_no];
    
        $this->testJsCall($argus);
        $this->startHeader();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            // 파일정보
            $query = array();
            $query [] = "SELECT ";
            $query [] = " FILE_NO1 ";
            $query [] = " FROM ". TBL_QNA;
            $query [] = " QNA_NO = '" . $p_qna_no . "'";
            $infor = $this->db->get(join(PHP_EOL, $query));

            $file_no1 = $infor->FILE_NO1;
            $query = array();
            $query [] = "DELETE FROM " . TBL_QNA;
            $query [] = " WHERE ";
            $query [] = " QNA_NO = '" . $p_qna_no . "'";
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
                $saveDir = DATA_DIR . DIRECTORY_SEPARATOR . BbsDataNotice::$SAVE_SUB_DIR;
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
         $this->addCodeData("QNA_TYPE"  , self::$CODE_QNA_TYPE );
         $this->addCodeData("QNA_STATE" , self::$CODE_QNA_STATE);
//         $this->addCodeData("SEX"       , self::$CODE_SEX       );
//         $this->addCodeData("STATE"     , self::$CODE_USER_STATE);
//         $this->addCodeData("EMAIL_YN"  , self::$CODE_YN    );
    }
}
if ( DEBUG ) {
   // # test path : http://local-mj.com/Qna.php
   $test = new Qna();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_QNA );
   $test->test($argus);
/*

   // insert 
   $argus[qna_no]  = 'data';
   $argus[qna_type]  = 'data';
   $argus[q_content]  = 'data';
   $argus[a_content]  = 'data';
   $argus[user_no]  = 'data';
   $argus[qna_state]  = 'data';
   $argus[reg_date]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[qna_no]  = 'key';
   // data field 
   $argus[qna_type]  = 'data';
   $argus[q_content]  = 'data';
   $argus[a_content]  = 'data';
   $argus[user_no]  = 'data';
   $argus[qna_state]  = 'data';
   $argus[reg_date]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[qna_no]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[qna_no]  = 'key';
   $test->select($argus); 

*/
}
?>
