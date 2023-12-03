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
 * 일본어 사이트 - 일본기술자정보 / JpTblEngineer.php
 */
class JpEngineer extends BaseDataBase
{
	/** @var upload file directory */ public static $SAVE_SUB_DIR = "jp_engineer";
	
    public function __construct() {
    	if ( !ADMIN ) {
    		header('HTTP/1.0 404 Not Found');
    		//echo "관리자가 아닙니다.";
    		die();
    	}    	
        parent::__construct();
        $this->debug = true;
        $this->start();
    }

    public function __destruct() {
    	if ( !ADMIN ) {
    		header('HTTP/1.0 404 Not Found');
    		//echo "관리자가 아닙니다.";
    		die();
    	}    	
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
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
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
