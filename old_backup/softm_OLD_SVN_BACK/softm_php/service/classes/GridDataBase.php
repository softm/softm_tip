<?php
require_once SERVICE_DIR .'/lib/var_database.define.inc'     ; // DataBase 변수
require_once SERVICE_DIR .'/classes/Base.php'         				 ; // 기본  클래스
require_once SERVICE_DIR .'/classes/common/GridManager.class.php'    ; // GRID DB Manager
require_once SERVICE_DIR .'/classes/common/Database.class.php'       ; // DB Connection
require_once SERVICE_DIR .'/lib/page_tab.lib.inc'            ; // page navigation

/**
 * @author softm
 * 데이터 베이스 관련 작업 - 기본 클래스
 */
abstract class GridDataBase extends Base
{
	
	/**
	 * @var GridManager
	 */
	public $dbm  ;
	
	/**
	 * @var DataBase
	 */
	public $db  ;
	
	/**
	 * @var Table
	 */
	public $table;

	/**
	 * @var array
	 */
	public $errors = array();
	
    /**
     * @return void
     * 생성자
     */
    public function __construct() {
		global $page_tab;
		parent::__construct();
		$this->dbm = GridManager::getInstance();
		$this->dbm->start();
		$this->db = $this->dbm->getDataBase();
    }
    
    /**
     * @return void
     * 소멸자
     */
    public function __destruct() {
    	parent::__destruct();
    	$this->dbm->end();
    }
    
    /**
     * @return string
     * 조회
     */
   public function get($argus) {
        global $page_tab;
        $p_user_id  = $argus[p_user_id ];
        //var_dump($argus);
        $page_tab['js_function' ] = $argus["p_navi_function"];
        $page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
        if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];

        $query = array();
        $field = array();
        $where = array();
        
        $query[] = "SELECT";
        $columns = $this->table->getColumns();
        
        // Column String Create
        /* @var $column Column */
        foreach ($columns as $k => $column) {
        	if ( $column->getDbColumn() ) {
        		$field[] = $column->getName() . ($column->getAlias()?" " .$column->getAlias():"") ;
        	}
        }
        if ( !empty($field) ) $query[] = join(",\n", $field);
        
        // From WHERE String Create
        $query[] = " FROM " . $this->table->getName();
        
        // where 문장생성
        if ( $this->makeWhere($argus) ) {
        	$query[] = ( " WHERE " . $this->dbm->getWhere() );
        }
		
        $query[] =  ( $this->dbm->getQuerySort()?" ORDER BY ". $this->dbm->getQuerySort():'' );
//        $query[] =  " LIMIT " . ( $page_tab['s'] - 1 ) . ", " . $cur_many;
        $query[] =  " LIMIT " . ( $page_tab['s'] - 1 ) . ", " . $cur_many;

        // 쿼리 적용
        $this->dbm->setQuery(join("\n", $query));
//         ECHO $this->dbm->getQuery();
        
		// row의 갯수를 구합니다.
		$page_tab['tot'] = $this->count();

		// code Array를 구성합니다.
		$this->getCodeData();
		
		//echo C_DB_PROCESS_MODE_SELECT . "<BR>";
        $xmlString = $this->dbm->makeXML(C_DB_PROCESS_MODE_SELECT);

        echo $xmlString;
    }
    
    /**
     * @return string
     * 입력, 수정, 삭제 처리
     */    
    public function save($argus) {
        global $page_tab;
      //$p_user_id  = $argus[p_user_id ];

        $p_mode = $argus["mode"];
        $errors = array();
        $sRtn   = false;
        $columns = $this->table->getColumns();
            // echo "A" . var_dump( $argus[mode] ) . "<BR>";
//         echo sizeof($argus[mode]);
        $size = sizeof($argus[mode]);
//         var_dump($columns);
// 		echo $size;
        if ( $size > 0  ) {
        	$query  = array();
        	logd ( "총 크기 : " . $size . "<BR>" );
        	$insertItemQuery= array();
        	$insertFields= array();
        	for ($i=0;$i<$size;$i++) {
        		logd ("<B> 모드 : " . $argus["mode"][$i] . " </B> ::> ");
        		$mode = $argus["mode"][$i];
        		$set   = "";
        		$where = "";

        		$insertValues= array();
        		$where = "";        		
				/* @var $column Column */
				foreach ($columns as $k => $column) {
					$k = strtolower($k);
					if ( $column->getDbColumn() ) {					
	        			logd ("" . $i . " ==> " . $column->getType() . " : editable : " . $column->getEditable() . "/" . $k . " -> " . $argus[$k][$i] . " | ");
	        			$tableName = $column->getTable()->getName();
	        			$chgVal    = $argus[$k       ][$i];
	        			$chgIsNull = $argus[$k."_n"  ][$i];
	        			$orgVal    = $argus[$k."_o"  ][$i];
	        			$orgIsNull = $argus[$k."_o_n"][$i];
	
	        			if        ( $mode == "I" ) { // 입력
	        				if ( $column->getEditable() && $column->getTransaction() ) {	        					
	        					if ( empty($insertItemQuery) ) $insertFields[] = $k;
	        					$insertValues[] = ($chgIsNull=='1'?'Null':"'".$chgVal."'" );
	        				}
	        			} else if ( $mode == "D" ) { // 삭제
	        				if ( $column->getKey() ) {	        				
		        				$where .= ( !$where?' WHERE ':' AND ' ) . $k . " " . ( !is_null($orgVal)?($orgIsNull == '1'?'is Null':"= '".$orgVal."'" ):
		        						($chgIsNull == '1'?'is Null':"= '".$chgVal."'" ));
	        				}
	        			} else if ( $mode == "U" ) { // 수정
	        				if ( !is_null($orgVal) && $orgVal != $chgVal && $column->getTransaction() ) {
	        					$set .= ($set?",":"") . $k . " " . ($chgIsNull=='1'?'= Null':"= '".$chgVal."'" );
	        				}
	        				if ( $column->getKey() ) {	        				
		        				$where .= ( !$where?' WHERE ':' AND ' ) . $k . " " . ( !is_null($orgVal)?($orgIsNull == '1'?'is Null':"= '".$orgVal."'" ):
		        						($chgIsNull == '1'?'is Null':"= '".$chgVal."'" ));
	        				}
	        			}
					} 
        		}
        		
        		if        ( $mode == "I" ) { // 입력
        			if ( !empty($insertFields) ) $insertItemQuery[] = '( ' . join(',',$insertValues) . ' )';
        		} else if ( $mode == "D" ) { // 삭제
        			if ( $where ) $query[] = 'DELETE FROM ' . $tableName . ' ' . $where . ' LIMIT 1';
        		} else if ( $mode == "U" ) { // 수정
        			if ( $set ) $query[] = 'UPDATE ' . $tableName . ' SET ' . $set . ' ' . $where . ' LIMIT 1' . "";
        		}
        		logd ("<BR>");
        	}
        	if ( !empty($insertItemQuery) ) {
        		$query[] = 'INSERT INTO ' . $tableName . '( ' . join(',',$insertFields) . ') VALUES ' . join(',',$insertItemQuery) ;
        	}
        	
        	logd ("<BR>sql : " . join("<BR><BR>",$query ) . "<BR>");
        	$msg = new Message();        	
        	if ( !empty($query) ) {
        		$this->db->setAutoCommit(false);
        		$sql = $this->dbm->setQuery(join(";\r\n",$query ));
//         		echo !$this->db->exec($sql) ."<BR>";
        		if ($sql && !$this->db->exec($sql)) $errors[] = $this->db->getErrMsg();
//         		var_dump($errors);
        		if ( empty($errors) ) {
         			if ( $this->db->commit() ) {
         				$msg->setCode(C_DB_PROCESS_MODE_SAVE);
         				$msg->setValue($msg->getValue(C_DB_PROCESS_MODE_SAVE));
         				$msg->setObject("return",C_RETURN_CODE_SUCCESS);
         			} else {
         				$this->db->rollback();
         				$errors[] = $this->db->getErrMsg();
         			}
        		} else {
        			$msg->setObject("return",C_RETURN_CODE_FAILURE);
        			$msg->setValue(implode($errors, "', '"));
        		}
        		$msg->setObject("affected_rows",$this->db->getAffectedRows());
        		//var_dump($msg);
        		$this->dbm->setMessage($msg);
        		$xmlString = $this->dbm->makeXML($msg?$msg->getCode():"");
        		echo $xmlString;
        	} else {
        		$msg->setObject("return",C_RETURN_CODE_FAILURE);
        		$msg->setValue("정상적인 접근이 아님");
        	}        	
        }
    }
    
    /**
     * @return string
     * where절을 생성합니다.
     */
    public function makeWhere($argus) {
		if ( REQUEST_TYPE == "json" ) {
	//         var_dump($argus[condition]);
	        if ( isset($argus[condition]) ) {
	        	$cond = $argus[condition];
		        /* @var $v WhereCondition */
	        	foreach ($cond as $k => $v) {
	//  	        	echo $v["where"] . "<BR>";
		        	if ( $v["equal"] ) {
		        		$where[] = $k . " = " . "'" . $v["value"] . "'";
		        	} else if ( $v["like"] ) {
		        		$where[] = $k . " like '" . $v["value"] . "%'";
		        	} else if ( $v["where"] ) {
		        		$where[] = $v["value"];
		        	}
		        }
	        }
        } else if ( REQUEST_TYPE == "post" ) {
	        $size = sizeof($argus[softm_cond]);
	        if ( $size > 0  ) {
	        	logd ( "총 크기 : " . $size . "<BR>" );
	        	for ($i=0;$i<$size;$i++) {
	        		logd ("<B> 모드 : " . $argus["mode"][$i] . " </B> ::> ");
	        		$k      = $argus["softm_cond"][$i];
	        		$equal  = $argus["s_c_e"][$i];
	        		$like   = $argus["s_c_l"][$i];
	        		$where_ = $argus["s_c_w"][$i];
	        		$value  = ($argus["s_c_v"][$i]);
// 	        		$value  = urldecode($argus["s_c_v"][$i]);
	        		if ( get_magic_quotes_gpc() == 1 ) $value = stripcslashes($value);
	        		if ( $equal ) {
	        			$where[] = $k . " = " . "'" . $value . "'";
	        		} else if ( $like ) {
	        			$where[] = $k . " like '" . $value . "%'";
	        		} else if ( $where_ ) {
	        			$where[] = $value;
	        		}
	        	}
	        }
        }
        if ( sizeof($where) > 0 ) {
        	return $this->dbm->setWhere(join(' AND ', $where));
        } else {
        	return "";
        }
    }

    /**
     * @return int
     * 조회 테이블의 Row수를 반환한다.
     */
    public function count() {
    	$query   = array();
    	$query[] = "SELECT";
    	$query[] = " COUNT(*) TOTAL";
    	$query[] = " FROM " . $this->table->getName();
    	if ( $this->dbm->getWhere() ) {
    		$query[] = ( " WHERE " . $this->dbm->getWhere() );
    	}	
    	$tot = $this->db->get(join("\n", $query))->TOTAL;
    	return $tot;
    }
    
    /**
     * code를 array화한다.
     */
    abstract public function getCodeData();
    
}
?>