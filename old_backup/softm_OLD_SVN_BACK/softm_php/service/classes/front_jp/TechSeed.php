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
     * 입력
     * @param array $argus
     * @return int
     */
    public function insert($argus) {
        $p_tech_no = $argus[p_tech_no];
    
        $cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_TECH_SEED
        		. " WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        
        $reg_code =sprintf('%s%s%04d','JS',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
//             if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_TECH_SEED;
            $query [] = "(";
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
//             $query [] = " FILE_NO1,";
            $query [] = " OPEN_YN,";
            $query [] = " REG_DATE,";
            $query [] = " USER_NO";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $reg_code     . "',";
            $query [] = " '" . $argus[tech_l_cat] . "',";
            $query [] = " '" . $argus[tech_m_cat] . "',";
            $query [] = " '" . $argus[tech_s_cat] . "',";
            $query [] = " '" . $argus[organ] . "',";
            $query [] = " '" . $argus[url] . "',";
            $query [] = " '" . $argus[tech_nm] . "',";
            $query [] = " '" . $argus[tech_nm_jp] . "',";
            $query [] = " '" . $argus[license_number] . "',";
            $query [] = " '" . $argus[purpose] . "',";
            $query [] = " '" . $argus[purpose_jp] . "',";
            $query [] = " '" . $argus[outline] . "',";
            $query [] = " '" . $argus[outline_jp] . "',";
            $query [] = " '" . $argus[feature] . "',";
            $query [] = " '" . $argus[feature_jp] . "',";
            $query [] = " '" . $argus[keyword] . "',";
            $query [] = " '" . $argus[keyword_jp] . "',";
//             $query [] = " '" . $argus[file_no1] . "',";
            $query [] = " '" . $argus[open_yn] . "',";
            $query [] = " now(),";
            $query [] = " '" . USER_NO . "'";
            $query [] = " );";
                        
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
                $tech_no = $this->db->getInsertId(); // insert id 
                $this->appendNode("insert_id", $tech_no);
//                out.print($this->db->getAffectedRows());
                if ( !$this->db->commit() ) throw new Exception("입력처리중 에러가 발생하였습니다.");
				else {
					$argus[p_proc_type] = PROC_TYPE_SR;
					// 담당자정보 입력.
					$worker_no = Worker::externalInsert($this->db, $argus);
// 					echo $worker_no;
					$this->appendNode("insert_worker_no", $worker_no);
					
					$updateInfor = array();
					$updateInfor[] = " WORKER_NO = '" . $worker_no . "'";
										
					$file_no1 = 0;
					$file_no2 = 0;
					$file_no3 = 0;
					
					$uploader  = new FileUpload(true,DATA_DIR . DIRECTORY_SEPARATOR . TechSeed::$SAVE_SUB_DIR); // 업로드 인스턴스 생성
					$uploader->getItem('file1')->setSaveName("f1_".$tech_no."_");
					$uploader->upload();
					
					$f1 = $uploader->getItem('file1');
					if ( $f1->getErrorCode() == UPLOAD_ERR_OK ) {
						$file_no1 = Common::insertFileInfor($this->db, PROC_TYPE_SR, USER_NO, $tech_no, $f1->getName(), $f1->getExt(), $f1->getSize());
					}
					
					if ( $file_no1 !=0 ) $fileInforUpdate[] = " FILE_NO1 = '" . $file_no1 . "'";
					if ( !empty($updateInfor) ) {
						$this->db->setAutoCommit(false);
					
						$this->exec(
								"UPDATE " .TBL_TECH_SEED . " SET"
								. join(",\n", $updateInfor)
								. " WHERE TECH_NO = '" .$tech_no . "'"
						);
						$this->db->commit();
					}					
				}
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
