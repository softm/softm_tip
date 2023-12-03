<?php
define("DEBUG",preg_match("/^\/service\/classes/", $_SERVER[PHP_SELF]));
define("TBL_TBL_POST","calko.tbl_post");
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
 * 우편번호 / Post.php
 */
class Post extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_TBL_POST);
    		$tbl1->newColumn('POST_SEQ','?고렪?쒖꽌',1)->setWidth(50)->setEditable(false);
    		$tbl1->newColumn('ZIPCODE','?고렪踰덊샇',2)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('SIDO','?쒕룄',3)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('GUGUN','援ш뎔',4)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('DONG','?',5)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('BUNJI','踰덉?',5)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('X1','x1醫뚰몴',5)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('Y1','y1醫뚰몴',5)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('X2','x2醫뚰몴',5)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('Y2','y2醫뚰몴',5)->setWidth(100)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('USER_NO'   ,'회원명'     ,2)->setEditable(true);
//	        $tbl1->newColumn('USER_LEVEL','레벨'       ,3)->setType(Column::LISTBOX_TYPE)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('REG_DATE'  ,'가입일'     ,5)->setKey(false);
//			$tbl2 = $this->newTable(TBL_COMPANY)->setTransaction(false);
//			$tbl2->newColumn('COMPANY_NO'     ,'기업번호'  ,7)->setWidth(0)->setHide(true)->setAlign('center')->setEditable(false);
			$tbl1->newColumn("<img src='/service/images/btn_ico_modify.jpg' class=btn_modify><img src='/service/images/btn_ico_del.jpg' class=btn_delete>",'수정/삭제'  ,6)
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
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_TBL_POST . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " POST_SEQ,";
    		$query [] = " ZIPCODE,";
    		$query [] = " SIDO,";
    		$query [] = " GUGUN,";
    		$query [] = " DONG,";
    		$query [] = " BUNJI,";
    		$query [] = " X1,";
    		$query [] = " Y1,";
    		$query [] = " X2,";
    		$query [] = " Y2";
    		$query [] = " FROM " . TBL_TBL_POST;

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
        $p_post_seq = $argus[p_post_seq];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " POST_SEQ,";
    		$query [] = " ZIPCODE,";
    		$query [] = " SIDO,";
    		$query [] = " GUGUN,";
    		$query [] = " DONG,";
    		$query [] = " BUNJI,";
    		$query [] = " X1,";
    		$query [] = " Y1,";
    		$query [] = " X2,";
    		$query [] = " Y2";
            $query [] = " FROM " . TBL_TBL_POST;
            $query [] = " WHERE ";
            $query [] = " POST_SEQ = '" . $p_post_seq . "'";
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
        $p_post_seq = $argus[p_post_seq];
    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_TBL_POST ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_TBL_POST;
            $query [] = "(";
    		$query [] = " ZIPCODE,";
    		$query [] = " SIDO,";
    		$query [] = " GUGUN,";
    		$query [] = " DONG,";
    		$query [] = " BUNJI,";
    		$query [] = " X1,";
    		$query [] = " Y1,";
    		$query [] = " X2,";
    		$query [] = " Y2";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[zipcode] . "',";
    		$query [] = " '" . $argus[sido] . "',";
    		$query [] = " '" . $argus[gugun] . "',";
    		$query [] = " '" . $argus[dong] . "',";
    		$query [] = " '" . $argus[bunji] . "',";
    		$query [] = " '" . $argus[x1] . "',";
    		$query [] = " '" . $argus[y1] . "',";
    		$query [] = " '" . $argus[x2] . "',";
    		$query [] = " '" . $argus[y2] . "'";
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
        $p_post_seq = $argus[p_post_seq];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_TBL_POST;
            $query [] = " SET";
            $query [] = " POST_SEQ = '" . $argus[post_seq] . "',";
            $query [] = " ZIPCODE = '" . $argus[zipcode] . "',";
            $query [] = " SIDO = '" . $argus[sido] . "',";
            $query [] = " GUGUN = '" . $argus[gugun] . "',";
            $query [] = " DONG = '" . $argus[dong] . "',";
            $query [] = " BUNJI = '" . $argus[bunji] . "',";
            $query [] = " X1 = '" . $argus[x1] . "',";
            $query [] = " Y1 = '" . $argus[y1] . "',";
            $query [] = " X2 = '" . $argus[x2] . "',";
            $query [] = " Y2 = '" . $argus[y2] . "'";
            //$query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
            $query [] = " POST_SEQ = '" . $p_post_seq . "'";
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
        $p_post_seq = $argus[p_post_seq];
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "DELETE FROM " . TBL_TBL_POST;
            $query [] = " WHERE ";
            $query [] = " POST_SEQ = '" . $p_post_seq . "'";
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
   // # test path : http://local-framework.com/Post.php
   $test = new Post();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_TBL_POST );
   $test->test($argus);
/*

   // insert 
   $argus[post_seq]  = 'data';
   $argus[zipcode]  = 'data';
   $argus[sido]  = 'data';
   $argus[gugun]  = 'data';
   $argus[dong]  = 'data';
   $argus[bunji]  = 'data';
   $argus[x1]  = 'data';
   $argus[y1]  = 'data';
   $argus[x2]  = 'data';
   $argus[y2]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 
   $argus[post_seq]  = 'key';
   // data field 
   $argus[zipcode]  = 'data';
   $argus[sido]  = 'data';
   $argus[gugun]  = 'data';
   $argus[dong]  = 'data';
   $argus[bunji]  = 'data';
   $argus[x1]  = 'data';
   $argus[y1]  = 'data';
   $argus[x2]  = 'data';
   $argus[y2]  = 'data';
   out.print($test->update($argus)); 

   // delete
   $argus[post_seq]  = 'key';
   out.print($test->delete($argus)); 

   select
   $argus[post_seq]  = 'key';
   $test->select($argus); 

*/
}
?>
