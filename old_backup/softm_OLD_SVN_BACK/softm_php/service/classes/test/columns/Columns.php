<?php
define("DEBUG",preg_match("/\/service\/classes/", $_SERVER[PHP_SELF]));
define("TBL_COLUMNS","information_schema.COLUMNS");
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
 *  / Columns.php
 */
class Columns extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
        if ( METHOD == "select" || METHOD == "save"  ) {
			$tbl1 = $this->newTable(TBL_COLUMNS);
//    		$tbl1->newColumn('TABLE_CATALOG','table_catalog',0)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('TABLE_SCHEMA','table_schema',1)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('TABLE_NAME','table_name',2)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('COLUMN_NAME','column_name',3)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('ORDINAL_POSITION','ordinal_position',4)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('COLUMN_DEFAULT','column_default',4)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('IS_NULLABLE','is_nullable',5)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('DATA_TYPE','data_type',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('CHARACTER_MAXIMUM_LENGTH','character_maximum_length',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('CHARACTER_OCTET_LENGTH','character_octet_length',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('NUMERIC_PRECISION','numeric_precision',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('NUMERIC_SCALE','numeric_scale',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('CHARACTER_SET_NAME','character_set_name',6)->setWidth(100)->setEditable(true);
//    		$tbl1->newColumn('COLLATION_NAME','collation_name',6)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('COLUMN_TYPE','column_type',7)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('COLUMN_KEY','column_key',8)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('EXTRA','extra',9)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('PRIVILEGES','privileges',10)->setWidth(100)->setEditable(true);
    		$tbl1->newColumn('COLUMN_COMMENT','column_comment',11)->setWidth(100)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('USER_NO'   ,'회원명'     ,2)->setEditable(true);
//	        $tbl1->newColumn('USER_LEVEL','레벨'       ,3)->setType(Column::LISTBOX_TYPE)->setEditable(true);
//	        $tbl1->newColumn('USER_NO'   ,'번호'       ,1)->setAlign('center');
//	        $tbl1->newColumn('REG_DATE'  ,'가입일'     ,5)->setKey(false);
//			$tbl2 = $this->newTable(TBL_COMPANY)->setTransaction(false);
//			$tbl2->newColumn('COMPANY_NO'     ,'기업번호'  ,7)->setWidth(0)->setHide(true)->setAlign('center')->setEditable(false);
			$tbl1->newColumn("<img src='images/btn_ico_modify.jpg' class=btn_modify><img src='images/btn_ico_del.jpg' class=btn_delete>",'수정/삭제'  ,12)
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
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_COLUMNS . ( $where ? " WHERE " . $where:"" ) );
    		if ($this->db->getErrMsg()) throw new Exception($this->db->getErrMsg());

    		$query = array();
    		    		
    		$query [] = " SELECT ";
    		$query [] = " TABLE_CATALOG,";
    		$query [] = " TABLE_SCHEMA,";
    		$query [] = " TABLE_NAME,";
    		$query [] = " COLUMN_NAME,";
    		$query [] = " ORDINAL_POSITION,";
    		$query [] = " COLUMN_DEFAULT,";
    		$query [] = " IS_NULLABLE,";
    		$query [] = " DATA_TYPE,";
    		$query [] = " CHARACTER_MAXIMUM_LENGTH,";
    		$query [] = " CHARACTER_OCTET_LENGTH,";
    		$query [] = " NUMERIC_PRECISION,";
    		$query [] = " NUMERIC_SCALE,";
    		$query [] = " CHARACTER_SET_NAME,";
    		$query [] = " COLLATION_NAME,";
    		$query [] = " COLUMN_TYPE,";
    		$query [] = " COLUMN_KEY,";
    		$query [] = " EXTRA,";
    		$query [] = " PRIVILEGES,";
    		$query [] = " COLUMN_COMMENT";
    		$query [] = " FROM " . TBL_COLUMNS;

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
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "SELECT ";
    		$query [] = " TABLE_CATALOG,";
    		$query [] = " TABLE_SCHEMA,";
    		$query [] = " TABLE_NAME,";
    		$query [] = " COLUMN_NAME,";
    		$query [] = " ORDINAL_POSITION,";
    		$query [] = " COLUMN_DEFAULT,";
    		$query [] = " IS_NULLABLE,";
    		$query [] = " DATA_TYPE,";
    		$query [] = " CHARACTER_MAXIMUM_LENGTH,";
    		$query [] = " CHARACTER_OCTET_LENGTH,";
    		$query [] = " NUMERIC_PRECISION,";
    		$query [] = " NUMERIC_SCALE,";
    		$query [] = " CHARACTER_SET_NAME,";
    		$query [] = " COLLATION_NAME,";
    		$query [] = " COLUMN_TYPE,";
    		$query [] = " COLUMN_KEY,";
    		$query [] = " EXTRA,";
    		$query [] = " PRIVILEGES,";
    		$query [] = " COLUMN_COMMENT";
            $query [] = " FROM " . TBL_COLUMNS;
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

    
        //$cnt = $this->db->getOne("SELECT IFNULL( CAST(substring( MAX(REG_CODE) ,11) AS SIGNED 	) ,0) + 1 FROM " . TBL_COLUMNS ." WHERE SUBSTR(REG_DATE ,1,10) = SUBSTR(NOW() ,1,10)" );
        //     	echo $cnt . "<BR>";
        //$reg_code =sprintf('%s%s%04d','KC',date("Ymd"),$cnt);
    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "INSERT INTO " . TBL_COLUMNS;
            $query [] = "(";
    		$query [] = " TABLE_CATALOG,";
    		$query [] = " TABLE_SCHEMA,";
    		$query [] = " TABLE_NAME,";
    		$query [] = " COLUMN_NAME,";
    		$query [] = " ORDINAL_POSITION,";
    		$query [] = " COLUMN_DEFAULT,";
    		$query [] = " IS_NULLABLE,";
    		$query [] = " DATA_TYPE,";
    		$query [] = " CHARACTER_MAXIMUM_LENGTH,";
    		$query [] = " CHARACTER_OCTET_LENGTH,";
    		$query [] = " NUMERIC_PRECISION,";
    		$query [] = " NUMERIC_SCALE,";
    		$query [] = " CHARACTER_SET_NAME,";
    		$query [] = " COLLATION_NAME,";
    		$query [] = " COLUMN_TYPE,";
    		$query [] = " COLUMN_KEY,";
    		$query [] = " EXTRA,";
    		$query [] = " PRIVILEGES,";
    		$query [] = " COLUMN_COMMENT";
            //$query [] = " REG_DATE ";
            $query [] = " ) VALUES (";
    		$query [] = " '" . $argus[table_catalog] . "',";
    		$query [] = " '" . $argus[table_schema] . "',";
    		$query [] = " '" . $argus[table_name] . "',";
    		$query [] = " '" . $argus[column_name] . "',";
    		$query [] = " '" . $argus[ordinal_position] . "',";
    		$query [] = " '" . $argus[column_default] . "',";
    		$query [] = " '" . $argus[is_nullable] . "',";
    		$query [] = " '" . $argus[data_type] . "',";
    		$query [] = " '" . $argus[character_maximum_length] . "',";
    		$query [] = " '" . $argus[character_octet_length] . "',";
    		$query [] = " '" . $argus[numeric_precision] . "',";
    		$query [] = " '" . $argus[numeric_scale] . "',";
    		$query [] = " '" . $argus[character_set_name] . "',";
    		$query [] = " '" . $argus[collation_name] . "',";
    		$query [] = " '" . $argus[column_type] . "',";
    		$query [] = " '" . $argus[column_key] . "',";
    		$query [] = " '" . $argus[extra] . "',";
    		$query [] = " '" . $argus[privileges] . "',";
    		$query [] = " '" . $argus[column_comment] . "'";
            //$query [] = " now() ";
            $query [] = " );";
            $this->setQuery(join(PHP_EOL, $query));
//            out.print($this->getQuery());
            $this->db->setAutoCommit(false);
            if ( $this->db->exec($this->getQuery()) ) {
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

    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "UPDATE " . TBL_COLUMNS;
            $query [] = " SET";
            $query [] = " TABLE_CATALOG = '" . $argus[table_catalog] . "',";
            $query [] = " TABLE_SCHEMA = '" . $argus[table_schema] . "',";
            $query [] = " TABLE_NAME = '" . $argus[table_name] . "',";
            $query [] = " COLUMN_NAME = '" . $argus[column_name] . "',";
            $query [] = " ORDINAL_POSITION = '" . $argus[ordinal_position] . "',";
            $query [] = " COLUMN_DEFAULT = '" . $argus[column_default] . "',";
            $query [] = " IS_NULLABLE = '" . $argus[is_nullable] . "',";
            $query [] = " DATA_TYPE = '" . $argus[data_type] . "',";
            $query [] = " CHARACTER_MAXIMUM_LENGTH = '" . $argus[character_maximum_length] . "',";
            $query [] = " CHARACTER_OCTET_LENGTH = '" . $argus[character_octet_length] . "',";
            $query [] = " NUMERIC_PRECISION = '" . $argus[numeric_precision] . "',";
            $query [] = " NUMERIC_SCALE = '" . $argus[numeric_scale] . "',";
            $query [] = " CHARACTER_SET_NAME = '" . $argus[character_set_name] . "',";
            $query [] = " COLLATION_NAME = '" . $argus[collation_name] . "',";
            $query [] = " COLUMN_TYPE = '" . $argus[column_type] . "',";
            $query [] = " COLUMN_KEY = '" . $argus[column_key] . "',";
            $query [] = " EXTRA = '" . $argus[extra] . "',";
            $query [] = " PRIVILEGES = '" . $argus[privileges] . "',";
            $query [] = " COLUMN_COMMENT = '" . $argus[column_comment] . "'";
            //$query [] = " MOD_DATE = now()";
            $query [] = " WHERE ";
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

    
        $this->testJsCall($argus);
        $this->startXML();
        try {
            if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
            $query = array();
            $query [] = "DELETE FROM " . TBL_COLUMNS;
            $query [] = " WHERE ";
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
   // # test path : http://local-framework.com/Columns.php
   $test = new Columns();
   $argus = array();

   // test 
   $argus[user_email] = "test01";
   $test->setTableName(TBL_COLUMNS );
   $test->test($argus);
/*

   // insert 
   $argus[table_catalog]  = 'data';
   $argus[table_schema]  = 'data';
   $argus[table_name]  = 'data';
   $argus[column_name]  = 'data';
   $argus[ordinal_position]  = 'data';
   $argus[column_default]  = 'data';
   $argus[is_nullable]  = 'data';
   $argus[data_type]  = 'data';
   $argus[character_maximum_length]  = 'data';
   $argus[character_octet_length]  = 'data';
   $argus[numeric_precision]  = 'data';
   $argus[numeric_scale]  = 'data';
   $argus[character_set_name]  = 'data';
   $argus[collation_name]  = 'data';
   $argus[column_type]  = 'data';
   $argus[column_key]  = 'data';
   $argus[extra]  = 'data';
   $argus[privileges]  = 'data';
   $argus[column_comment]  = 'data';
   $insert_id = $test->insert($argus);
   out.print('$insert_id : ' . $insert_id . '<BR>');

   // update 
   // key field 

   // data field 
   $argus[table_catalog]  = 'data';
   $argus[table_schema]  = 'data';
   $argus[table_name]  = 'data';
   $argus[column_name]  = 'data';
   $argus[ordinal_position]  = 'data';
   $argus[column_default]  = 'data';
   $argus[is_nullable]  = 'data';
   $argus[data_type]  = 'data';
   $argus[character_maximum_length]  = 'data';
   $argus[character_octet_length]  = 'data';
   $argus[numeric_precision]  = 'data';
   $argus[numeric_scale]  = 'data';
   $argus[character_set_name]  = 'data';
   $argus[collation_name]  = 'data';
   $argus[column_type]  = 'data';
   $argus[column_key]  = 'data';
   $argus[extra]  = 'data';
   $argus[privileges]  = 'data';
   $argus[column_comment]  = 'data';
   out.print($test->update($argus)); 

   // delete

   out.print($test->delete($argus)); 

   select

   $test->select($argus); 

*/
}
?>
