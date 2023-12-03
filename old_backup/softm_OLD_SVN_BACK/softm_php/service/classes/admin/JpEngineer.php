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
class JpEngineer extends BaseDataBase
{
	/** @var upload file directory */ public static $SAVE_SUB_DIR = "jp_engineer";
	
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_JP_TBL_ENGINEER);
    		$tbl1->newColumn('ENGINEER_NO','번호'     ,1)->setWidth(80)->setEditable(false);
    		$tbl1->newColumn('NM_KR'      ,'성명'     ,2)->setWidth(200)->setEditable(false);
    		$tbl1->newColumn('TEL'        ,'연락처'   ,3)->setWidth(200)->setEditable(false);
	        $tbl1->newColumn("FILE_NO1"   ,'첨부파일' ,4)->setHtml(true)->setCssText("padding-top: 13px;")->setWidth(100);
	        $tbl1->newColumn('REG_DATE'   ,'등록 일자',5)->setWidth(100)->setEditable(false);	        
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
    		if ( !ADMIN ) throw new Exception("권한이 없습니다.");
//    		var_dump($argus);
    		$page_tab['js_function' ] = $argus["p_navi_function"];
    		$page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
    		if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];

    		// where 문장생성
    		$make_where = $this->makeWhere($argus);
    		$where = $make_where;

    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_JP_ENGINEER . ( $where ? " WHERE " . $where:"" ) );
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
    		$query [] = " IF(FILE_NO1<>0,CONCAT('<a href=# fileno=',FILE_NO1,'>첨부파일</a>'),'&nbsp;')        FILE_NO1,";
    		$query [] = " FILE_NO2,";
    		$query [] = " USER_NO,";
    		$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d %H:%i') REG_DATE,";
    		$query [] = " DATE_FORMAT(MOD_DATE,'%Y-%m-%d %H:%i') MOD_DATE";
    		$query [] = " FROM " . TBL_JP_ENGINEER;

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
            if ( !ADMIN ) throw new Exception("권한이 없습니다.");
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
            $query [] = " FROM " . TBL_JP_ENGINEER;
            $query [] = " WHERE ";
            $query [] = " ENGINEER_NO = '" . $p_engineer_no . "'";
            $this->setQuery(join(PHP_EOL, $query));

            $sql = join(PHP_EOL, $query);
//             $this->appendNode("sql", $sql);            
            $jp_engineer = $this->db->get($sql,"array");
            
            $oldFileInfor = Common::getFileInfor($this->db,array(FILE_NO1=>$jp_engineer[FILE_NO1],FILE_NO2=>$jp_engineer[FILE_NO2]) ,"FILE_NAME,FILE_NO,FILE_EXT");
                        
            $file1Name = $oldFileInfor['FILE_NO1']->FILE_NAME;
            $file1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;
            $file2Name = $oldFileInfor['FILE_NO2']->FILE_NAME;
            $file2Ext = $oldFileInfor['FILE_NO2']->FILE_EXT;
            
            $this->appendNode('filename1', $file1Name);
            $this->appendNode('fileext1', $file1Ext);
            $this->appendNode('fileno1', $jp_engineer[FILE_NO1]);            
            $this->appendNode('filename2', $file2Name);
            $this->appendNode('fileext2', $file2Ext);
            $this->appendNode('fileno2', $jp_engineer[FILE_NO2]);            
    //         	out.print($this->db->getAffectedRows());
    //         	out.print($this->db->getErrMsg());
            $this->oneRowToXML($jp_engineer,"item","fi");
                
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
            if ( !ADMIN ) throw new Exception("권한이 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_JP_ENGINEER;
            $query [] = "(";
    		$query [] = " NM_HJ,";
    		$query [] = " NM_JP,";
    		$query [] = " NM_KR,";
    		$query [] = " NM_EN,";
    		$query [] = " TEL,";
    		$query [] = " EMAIL,";
    		$query [] = " HP,";
//     		$query [] = " FILE_NO1,";
//     		$query [] = " FILE_NO2,";
    		$query [] = " USER_NO,";
    		$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[nm_hj] . "',";
    		$query [] = " '" . $argus[nm_jp] . "',";
    		$query [] = " '" . $argus[nm_kr] . "',";
    		$query [] = " '" . $argus[nm_en] . "',";
    		$query [] = " '" . $argus[tel] . "',";
    		$query [] = " '" . $argus[email] . "',";
    		$query [] = " '" . $argus[hp] . "',";
//     		$query [] = " '" . $argus[file_no1] . "',";
//     		$query [] = " '" . $argus[file_no2] . "',";
    		$query [] = " '" . USER_NO . "',";
            $query [] = " now() ";
            $query [] = " );";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
                $engineer_no = $this->db->getInsertId(); // insert id
                $this->appendNode("p_engineer_no", $engineer_no);

                $file_no1 = 0;
				$file_no2 = 0;

                $uploader  = new FileUpload(true,DATA_DIR . DIRECTORY_SEPARATOR . JpEngineer::$SAVE_SUB_DIR); // 업로드 인스턴스 생성
                $uploader->getItem('file1')->setSaveName("f1_".$engineer_no."_");
                $uploader->getItem('file2')->setSaveName("f2_".$engineer_no."_");
                $uploader->upload();

                $f1 = $uploader->getItem('file1');
                $f2 = $uploader->getItem('file2');
// 					echo $f1->getErrorCode() . '<BR>';
// 					echo $f2->getErrorCode() . '<BR>';
// 					echo $f3->getErrorCode() . '<BR>';

                if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {
                    $file_no1 = Common::insertFileInfor($this->db, PROC_TYPE_CR_JP, USER_NO, COMPANY_NO, $f1->getName(), $f1->getExt(), $f1->getSize());
                }

                if ( $f2->getErrorCode() == UPLOAD_ERR_OK ) {
                    $file_no2 = Common::insertFileInfor($this->db, PROC_TYPE_CR_JP, USER_NO, COMPANY_NO, $f2->getName(), $f2->getExt(), $f2->getSize());
                }
                $fileInforUpdate = array();
                if ( $file_no1 !=0 ) $fileInforUpdate[] = " FILE_NO1 = '" . $file_no1 . "'";
                if ( $file_no2 !=0 ) $fileInforUpdate[] = " FILE_NO2 = '" . $file_no2 . "'";
                if ( !empty($fileInforUpdate) ) {
                    $this->exec(
                    "UPDATE " .TBL_JP_ENGINEER . " SET"
                   . join(",\n", $fileInforUpdate)
                   . " WHERE ENGINEER_NO = '" .$engineer_no . "'"
                    );
                }

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
            if ( !ADMIN ) throw new Exception("권한이 없습니다.");
            
            // 파일정보
            $fInfor = $this->db->get(
            		"SELECT "
            		. "FILE_NO1, "
            		. "FILE_NO2  "
            		. " FROM ". TBL_JP_ENGINEER
            		. " WHERE ENGINEER_NO = '" . $p_engineer_no . "'"
            );
            $file_no1 = $fInfor->FILE_NO1;
            $file_no2 = $fInfor->FILE_NO2;
            
            //     							echo '$oldFileInfor ' . $fInfor['FILE_NO1']->FILE_EXT;
            $oldFileInfor = Common::getFileInfor($this->db,$fInfor,"FILE_NO,FILE_EXT");
            $oldFile1Ext = $oldFileInfor['FILE_NO1']->FILE_EXT;
            $oldFile2Ext = $oldFileInfor['FILE_NO2']->FILE_EXT;
                        
            $query = array();
            $query [] = "UPDATE " . TBL_JP_ENGINEER;
            $query [] = " SET";
            $query [] = " NM_HJ = '" . $argus[nm_hj] . "',";
            $query [] = " NM_JP = '" . $argus[nm_jp] . "',";
            $query [] = " NM_KR = '" . $argus[nm_kr] . "',";
            $query [] = " NM_EN = '" . $argus[nm_en] . "',";
            $query [] = " TEL = '" . $argus[tel] . "',";
            $query [] = " EMAIL = '" . $argus[email] . "',";
            $query [] = " HP = '" . $argus[hp] . "',";
    		if ( $argus[file1_delete] == 'Y' ) $query[]  = " FILE_NO1   = NULL,";
    		if ( $argus[file2_delete] == 'Y' ) $query[]  = " FILE_NO2   = NULL,";
            $query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " ENGINEER_NO = '" . $p_engineer_no . "'";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
            	$saveDir = DATA_DIR . DIRECTORY_SEPARATOR . JpEngineer::$SAVE_SUB_DIR;
            	$uploader  = new FileUpload(true,$saveDir); // 업로드 인스턴스 생성
            	
            	$f1 = $uploader->getItem('file1')->setSaveName("f1_".$p_engineer_no."_");
            	$f2 = $uploader->getItem('file2')->setSaveName("f2_".$p_engineer_no."_");
            	
            	if ( $argus[file1_delete] == 'Y' ) {
            		@unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_engineer_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
            		Common::deleteFileInfor($this->db, $file_no1);
            		$file_no1 = 0;
            	}
            	if ( $file_no2 && $argus[file2_delete] == 'Y' ) {
            		@unlink($saveDir.DIRECTORY_SEPARATOR."f2_".$p_engineer_no."_".( $oldFile2Ext?"." .$oldFile2Ext:"") );
            		Common::deleteFileInfor($this->db, $file_no2);
            		$file_no2 = 0;
            	}
            	
            	/* @var Company Table file no 갱신 */
            	$fileInforUpdate = array();
//             	echo $file_no1;
            	if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {
            		if ( !$file_no1 ) {
            			$file_no1 = Common::insertFileInfor($this->db, PROC_TYPE_CR_JP, USER_NO, COMPANY_NO, $f1->getName(), $f1->getExt(), $f1->getSize());
            			$fileInforUpdate[] = " FILE_NO1 = '" . $file_no1 . "'";
            		} else {
            			@unlink($saveDir.DIRECTORY_SEPARATOR."f1_".$p_engineer_no."_".( $oldFile1Ext?"." .$oldFile1Ext:"") );
            			$file_no1 = Common::updateFileInfor($this->db, $file_no1, $f1->getName(), $f1->getExt(), $f1->getSize());
            		}
            		$f1->upload();
            	}
            	
            	if ( $f2->getErrorCode() == UPLOAD_ERR_OK ) {
            		if ( !$file_no2 ) {
            			$file_no2 = Common::insertFileInfor($this->db, PROC_TYPE_CR_JP, USER_NO, COMPANY_NO, $f2->getName(), $f2->getExt(), $f2->getSize());
            			$fileInforUpdate[] = " FILE_NO2 = '" . $file_no2 . "'";
            		} else {
            			@unlink($saveDir.DIRECTORY_SEPARATOR."f2_".$p_engineer_no."_".( $oldFile2Ext?"." .$oldFile2Ext:""));
            			$file_no2 = Common::updateFileInfor($this->db, $file_no2, $f2->getName(), $f2->getExt(), $f2->getSize());
            		}
            		$f2->upload();
            	}
            	
            	if ( !empty($fileInforUpdate) ) {
            		$this->exec(
	                    "UPDATE " .TBL_JP_ENGINEER . " SET"
	                   . join(",\n", $fileInforUpdate)
	                   . " WHERE ENGINEER_NO = '" .$p_engineer_no . "'"
            		);
            	}            	
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
            if ( !ADMIN ) throw new Exception("권한이 없습니다.");
            $fInfor = $this->db->get(
            		"SELECT "
            		. "ENGINEER_NO, "
            		. "FILE_NO1, "
            		. "FILE_NO2  "
            		. " FROM ". TBL_JP_ENGINEER
            		. " WHERE ENGINEER_NO = '" . $p_engineer_no . "'"
            );
            $engineer_no = $fInfor->ENGINEER_NO;
            $file_no1 = $fInfor->FILE_NO1;
            $file_no2 = $fInfor->FILE_NO2;
                        
            $query = array();
            $query [] = "DELETE FROM " . TBL_JP_ENGINEER;
            $query [] = " WHERE ";
            $query [] = " ENGINEER_NO = '" . $p_engineer_no . "'";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
				Common::deleteFileInfor($this->db, $file_no1);
				Common::deleteFileInfor($this->db, $file_no2);
				
            	Util::unlinkFile(DATA_DIR . DIRECTORY_SEPARATOR . JpEngineer::$SAVE_SUB_DIR . DIRECTORY_SEPARATOR . "f*_" . $engineer_no . "_.*",true);
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
