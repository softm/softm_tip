<?php
require_once SERVICE_DIR .'/lib/var_database.define.inc'     ; // DataBase 변수
require_once SERVICE_DIR .'/classes/common/NodeData.php'     ; // NodeData
require_once SERVICE_DIR .'/classes/Base.php'         				 ; // 기본  클래스
require_once SERVICE_DIR .'/classes/common/Database.class.php'       ; // DB Connection
require_once SERVICE_DIR .'/lib/page_tab.lib.inc'            ; // page navigation

require_once 'common/Table.php'          ; // Table.php
require_once 'common/Row.php'            ; // Row.php
require_once 'common/Column.php'         ; // Column.php
function strtolower2($v) {
	return $v;
}
/**
 * @author softm
 * 데이터 베이스 관련 작업 - 기본 클래스
 */
//abstract class BaseDataBase extends Base
class BaseDataBase extends Base
{
	private static $instance;
	private static $conn;

	/** @var Data 구조 DOMDocument XML 문서의 버전은 1.0, 인코딩 방식은 UTF-8을 사용 */ private $dom;
	/** @var Data 구조 Array */ private $data;

	/** @var xml의 최상위 노드 */ private $results;

	/** @var boolean 디버깅 */ protected $debug = false;

	/** @var DataBase */ public $db  ;

	/** @var TableName */ public $tableName;

	/** @var string 쿼리 */ private $query  ;

	/** @var string where절 */ private $where ;

	/** @var boolean 에러여부 */ protected $error = false;

	/** @var array */ private $code_data = array();

	/** @var array */ private $messages = array();

	/** @var Message 메시지 클래스 */ protected  $message ;

	/** @var string 형태 : grid, select */ private $type;

	/** @var array Table */ private $tables = array();
	/** @var array Column */	private $columns = array();

	/**
	 * @param $name string
	 * @return BaseDataBase
	 */
	public function setType($type) {
		$this->type = $type;
		return $this;
	}

	/**
	 * @param $name string
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * table을 추가합니다.
	 * @param string $name
	 * @return Table
	 */
	public function newTable($name) {
		$rtn = new Table($name,$this);
		$this->tables[] = $rtn;
		return $rtn;
	}

	/**
	 * table을 추가합니다.
	 * @param Table $table
	 * @return Table
	 */
	public function addTable($table) {
		$table->setDbm($this);
		$this->tables[] = $table;
		$columns = $table->getColumns();
		$this->columns = array_merge($this->columns,$columns);
		// 		var_dump($this->columns);
		return $table;
	}

	/**
	 * 테이블정보 반환
	 * @return array Table
	 */
	public function getTables() {
		return (array)$this->tables;
	}

	/**
	 * 테이블정보 반환
	 * @return $rtn Table
	 */
	public function getTable($key) {
		$rtn = null;
		/* @var $table Table */
		foreach($this->tables as $idx => $table) {
// 			echo $table->getName();
			if ( $key == $table->getName() ) {
				$rtn = $table;
				break;
			}
		}
		return $rtn;
	}

	/**
	 * @param $name string
	 * @param $column Column
	 * @param $index int
	 * @return Column
	 */
	public function setColumn($name, $column,$index = null ) {
		if ( !$column ) trigger_error("Column Class 정보가 정확하지 않습니다.", E_USER_ERROR);
		if (!$index) {
			$index = 0;
			if ( isset($this->columns) ) {
				foreach($this->columns as $key => $value) {
					$index++;
				}
			}
		}
		//logp("name : " . $name . " index is " . $idx);
		$column->setIndex($index);
		$this->columns[$name] = $column;
		return $this->columns[$name];
	}

	/**
	 * 컬럼정보 반환
	 * @param $name string
	 * @return Column
	 */
	public function getColumn($name) {
		return $this->columns[$name];
	}
	/**
	 * 컬럼정보 반환
	 * @param $name string
	 * @return Column
	 */
	public function removeColumn($name) {
		unset($this->columns[$name]);
	}

	/**
	 * 컬럼정보 반환
	 * @return array Column
	 */
	public function getColumns() {
		return (array)$this->columns;
	}

	/**
	 * Query Sort String 반환
	 * @return mixed
	 */
	public function getQuerySort() {
		$orderStr = array();
// 				var_dump($_POST);
		// 		global $_POST;
		for( $i=0;$i<sizeof($_POST['sort_f']);$i++) {
			if      ($_POST['sort_d'][$i]=='▲') $dir = 'ASC' ;
			else if ($_POST['sort_d'][$i]=='▼') $dir = 'DESC';
            $sf = $_POST['sort_f'][$i];
            $c = $this->getColumn($sf);
            $sf = $c && $c->getBindName()?$c->getBindName():$sf;
			if ( $dir ) $orderStr[] = $sf . ' ' . $dir;
		}
		return ( sizeof($orderStr)>0? join($orderStr,','):'' );
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
		} else if ( REQUEST_TYPE == "post" || REQUEST_TYPE == "FORM" ) {
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
			return $this->setWhere(join(' AND ', $where));
		} else {
			return "";
		}
	}


	/**
	 * @param Table $table
	 * @param array $argus
	 * @return string
	 * 입력, 수정, 삭제 처리
	 */
	public function makeSaveQuery($table,$argus) {
		//$p_user_id  = $argus[p_user_id ];

		$p_mode = $argus["mode"];
		$errors = array();
		$columns = $table->getColumns();
		if ( $table->getTransaction() ) {
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
					$execCheck = false;
					$insertValues= array();
					$where = "";
					/* @var $column Column */
					foreach ($columns as $k => $column) {
						$k = strtolower2($k);
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
				return $this->setQuery(join(";".PHP_EOL,$query ));
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
	/////////////////////////////// grid 작업 /////////////////////

	/**
	 * @var DataBase 데이터의형태
	 */
	const SELECT_TYPE    = "SELECT";
	/**
	 * @var DataBase 데이터의형태
	 */
	const GRID_TYPE    = "GRID";

    /**
     * @return void
     * 생성자
     */
    public function __construct($db=null) {
    	$this->message = new Message();
    	$this->type = BaseDataBase::SELECT_TYPE;
    }

//     //defult constructor
//     public function __construct() {
//     	$num = func_num_args();
//     	$args = func_get_args();
//     	switch($num){
//     		case 0:
//     			$this->__call('__construct0', null);
//     			break;
//     		case 1:
//     			$this->__call('__construct1', $args);
//     			break;
//     		default:
//     			throw new Exception();
//     	}
//     	$this->message = new Message();
//     }

    /**
     * @return void
     * 소멸자
     */
    public function __destruct() {
    	parent::__destruct();
    }

//     public function __call($name, $arguments)
//     {
//     	$_i = $this;
//     	$f = $name."Exec";
//     	$_i->$f($arguments);
//     }

    /**
     * DB를 시작 ( db connect )
     * @return void
     */
    public function start() {
    	define('DB_KIND','MYSQL'); // db kind
    	$this->db = new DataBase ();
    	$this->db->getConnect();
    	$this->db->exec("set names utf8;");

   		//$this->db->exec("set names euc-kr;");
   		//$this->db->exec("SET character_set_results = 'utf-8', character_set_client = 'utf-8', character_set_connection = 'utf-8', character_set_database = 'utf-8', character_set_server = 'utf-8'");
  		//phpinfo();
    }

    /**
     * DB 를 종료합니다.
     */
    public function end() {
    	$this->db->release();
    }

    /**
     * @return DataBase
     */
    public function getDataBase() {
    	return $this->db;
    }
    /**
     * Where set table name ( 임시용도 )
     * @param string $tableName
     * @return mixed
     */
    public function setTableName($tableName) {
    	$this->tableName = $tableName;
    	return $this->tableName;
    }

    /**
     * @return string $tableName
     */
    public function getTableName() {
    	return $this->tableName;
    }

    /**
     * debug 모드를 설정합니다.
     * @param string $debug
     * @return boolean
     */
    public function setDebug($debug) {
    	$this->debug = $debug;
    	return $this->debug;
    }

    /**
     * debug 모드를 반환합니다.
     * @return boolean
     */
    public function getDebug() {
    	return $this->debug;
    }

    /**
     * Query String 할당
     * @param string $query
     * @return mixed
     */
    public function setQuery($query) {
    	$this->query = $query;
    	return $this->query;
    }

    /**
     * Where String 반환
     * @return mixed
     */
    public function getWhere() {
    	return $this->where;
    }
    /**
     * Where String 할당
     * @param string $where
     * @return mixed
     */
    public function setWhere($where) {
    	$this->where = $where;
    	return $this->where;
    }

    /**
     * Query String 반환
     * @return mixed
     */
    public function getQuery() {
    	return $this->query;
    }

    /**
     * 결과 데이터(xml&json) 반환시 이용하는 code형태의 Array를 push
     * @param string $key
     * @param array $data
     * @return void
     */
    public function addCodeData($key,$data) {
    	$this->code_data[$key] = $data;
    }

    /**
     * @return void
     * 성공 : 메시지를 추가합니다.
     */
    public function addMessage($value) {
    	if ( !$this->error ) {
    		$this->messages[] = $value;
    	}
    }

    /**
     * @return void
     * 실패 : 메시지를 추가합니다.
     */
    public function addErrMessage($value) {
    	$this->messages[] = $value;
    	$this->error = true;
    }

    /**
     * @param $key string
     * @param $value string
     * @param $appendRoot DOM
     * @return DOMElement
     */
//     private function createNode($key,$value=NULL,DOMNode &$appendRoot=NULL) {
    private function createNode($key,$value=NULL,&$appendRoot=NULL) {
    	if ( RESPONSE_TYPE == DATA_TYPE_XML ) {
    		$root = $this->dom;
    	} else if ( RESPONSE_TYPE == DATA_TYPE_JSON ) {
//     		$rtn = array($key=>null);
    		$root = $this->dom;
    	}
    	$rtn = $root->createElement($key);
    	if( isset($value) ) $rtn->appendChild($root->createCDATASection($value) );
    	if ( RESPONSE_TYPE == DATA_TYPE_XML ) {
    		if ( $appendRoot instanceof DOMNode ) $appendRoot->appendChild($rtn);
    	} else if ( RESPONSE_TYPE == DATA_TYPE_JSON ) {
//     		var_dump($appendRoot);
    		if ( $appendRoot instanceof NodeData ) $appendRoot->appendChild($rtn);
    	}
//     	var_dump($this->dom);
    	return $rtn;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function appendNode($name,$value) {
    	if ( RESPONSE_TYPE == DATA_TYPE_XML ) {
    		$newNode = $this->createNode($name, $value, $this->resluts);
    		$this->results->appendChild($newNode);
    	} else if ( RESPONSE_TYPE == DATA_TYPE_JSON ) {
    		$newNode = $this->createNode($name, $value, $this->resluts);
    		$this->results->appendChild($newNode);
    	}
    }

    /**
     * 실행결과 xml을 반환합니다.
     * @param string $mode
     */
    public function startHeader() {
    	global $page_tab;
		if ( RESPONSE_TYPE == DATA_TYPE_XML ) {
			header("Content-Type: text/xml; charset=UTF-8");
	    	$this->dom = new DOMDocument('1.0', 'UTF-8');
		} else if ( RESPONSE_TYPE == DATA_TYPE_JSON ) {
    		header('Content-Type: application/json');
    		$this->dom = new NodeData();
		} else {
			header("Content-Type: text/plain; charset=UTF-8");
		}

    	header('Cache-Control: no-cache');
    	header('Cache-Control: no-store' , false);
// 	    echo 'RESPONSE_TYPE :' . RESPONSE_TYPE;

    	// response 항목 생성
    	$this->results   = $this->createNode('results',NULL,$this->dom);
    	$this->appendNode('method',str_replace('/', '.', CLASS_POS)  . '.'. CLASS_NAME . '.' . METHOD);
    	$this->appendNode('start_date',date('Y/m/d h:i:s A'));

    	if ( $this->code_data ) {
    		$code = $this->createNode("code",NULL,$this->dom);
    		foreach ($this->code_data as $k => $data) {
    			$sub_data = $data;
    			foreach ($sub_data as $sub_key => $v) {
//     				if ( RESPONSE_TYPE == DATA_TYPE_XML ) {
	    				$code_data = $this->createNode(strtolower2($k),$v);
	    				$code_data->setAttribute("id", $sub_key);
	    				$code->appendChild($code_data);
//     				} else if ( RESPONSE_TYPE == DATA_TYPE_JSON ) {
//     				}
    			}
    		}
//     		if ( RESPONSE_TYPE == DATA_TYPE_XML ) {
    			$this->results->appendChild($code);
//     		} else if ( RESPONSE_TYPE == DATA_TYPE_JSON ) {

//     		}
    	}
    }
    private $sqlExecCount = 0;

    /**
     * @param string $sql
     * @param boolean $msg_yn
     * @param string $driver
     * @return boolean
     */
    function exec($sql, $msg_yn=false, $driver='') {
    	$this->appendNode('sql_' . ++$this->sqlExecCount , $sql);
    	return $this->db->exec($sql, $msg_yn, $driver);
    }

    /**
     * 실행결과 xml을 반환합니다.
     * @param string $mode
     */
    public function makeItemXML($sql,$itemName="item",$fieldInforName="fieldinfo") {
    	global $page_tab;
		$fieldinfo = $this->createNode($fieldInforName,NULL,$this->dom);
		$this->appendNode('sql_' . $itemName , $sql);

		try {
			$stmt = $this->db->multiRowSQLQuery ($sql);
			if ( $this->db->getErrMsg() ) $this->addErrMessage($this->db->getErrMsg());
			$loopCount=0;

		    uasort ($this->columns, 'columnSort');

		    if ( $this->getType() == BaseDataBase::GRID_TYPE ) {
		    	$idx = 0;
			    /* @var $v Column */
			    foreach ( $this->columns as $v ) {
// 			    	echo $v->getIndex() . "<BR>";
// 					echo $v->getColName() . "<BR>";
			    	$v->setIndex($idx++);
			    	$fitem = $this->createNode(strtolower2($v->getName()));
// 			    	if ( RESPONSE_TYPE == DATA_TYPE_XML ) {
				    	$fitem->setAttribute("title", $v->getTitle());
				    	$fitem->setAttribute("editable", $v->getEditable());
				    	$fitem->setAttribute("type", $v->getType());
				    	$fitem->setAttribute("index", $v->getIndex());
				    	$fitem->setAttribute("html", $v->getHtml());
				    	$fitem->setAttribute("sortable", $v->getSortable());
				    	$fitem->setAttribute("hide", $v->getHide());
				    	$fitem->setAttribute("datatype", $v->getDataType());

				    	if ( (string)$v->getWidth()   != "") $fitem->setAttribute("width", $v->getWidth());
				    	if ( (string)$v->getAlign()   != "") $fitem->setAttribute("align", $v->getAlign());
				    	if ( (string)$v->getCssText() != "") $fitem->setAttribute("cssText", $v->getCssText());
				    	$fieldinfo->appendChild($fitem);
// 			    	} else if ( RESPONSE_TYPE == DATA_TYPE_JSON ) {
// 			    		$fitem["title"] = $v->getTitle();
// 			    		$fitem["editable"] = $v->getEditable();
// 			    		$fitem["type"] = $v->getType();
// 			    		$fitem["index"] = $v->getIndex();
// 			    		$fitem["html"] = $v->getHtml();
// 			    		$fitem["hide"] = $v->getHide();
// 			    		if ( (string)$v->getWidth()   != "") $fitem["width"  ] = $v->getWidth();
// 			    		if ( (string)$v->getAlign()   != "") $fitem["align"  ] = $v->getAlign();
// 			    		if ( (string)$v->getCssText() != "") $fitem["cssText"] = $v->getCssText();
// 			    		$fieldinfo[] = $fitem;
// 			    	}
			    }

// 			    var_dump($this->results);
				if ( $page_tab ) {
				    $pagenavi = $this->createNode("pagenavi",NULL,$this->results);
				    $this->createNode("html"     ,pageTab($page_tab)    ,$pagenavi);
				    $this->createNode("how_many" ,$page_tab["how_many" ],$pagenavi);
				    $this->createNode("more_many",$page_tab["more_many"],$pagenavi);
				    $this->createNode("page_many",$page_tab["more_many"],$pagenavi);
				    $this->createNode("total"    ,$page_tab["tot"      ],$pagenavi);
				    $this->createNode("position" ,$page_tab["s"        ],$pagenavi);
	// 			    echo var_dump($pagenavi);
				}
		    }
		    while ( $rs = $this->db->multiRowFetch  ($stmt) ) {
		    	//                  var_dump($rs);
		    	$item = $this->createNode($itemName);
		    	$item1 = $this->createNode($itemName);
//     		echo 'make $this->type : ' .  $this->type . PHP_EOL;
		    	if ( $this->getType() == BaseDataBase::SELECT_TYPE ) {
			    	foreach ( $rs as $k => $v ) {
			    		if ( $loopCount == 0 ) {
		    				//echo $v->getIndex() . "<BR>";
		    				$fitem = $this->createNode(strtolower2($k));
		    				$fitem->setAttribute("title", strtolower2($k));
		    				$fieldinfo->appendChild($fitem);
			    		}
			    		//echo "rs : " . $k;
// 			    		$uItem = $this->createNode(strtolower2($k));
// 			    		$uItem->setAttribute("isnull", (is_null($rs->$k)?'1':'0'));
// 			    		//var_dump($rs);
// 			    		$value = $this->createNode("value",$rs->$k);
// 			    		$uItem->appendChild($value);
// 			    		$item->appendChild($uItem);

			    		$uItem = $this->createNode(strtolower2($k),is_null($rs->$k)?"":$rs->$k);
			    		$item->appendChild($uItem);
			    	}
			    	$loopCount++;
			    } else if ( $this->getType() == BaseDataBase::GRID_TYPE ) {
			    	foreach ( $this->columns as $v ) {
			    		$k = $v->getName();
			    		//echo "rs : " . $k;
			    		$uItem = $this->createNode(strtolower2($k));
// 			    		var_dump($rs);
			    		if ( !$v->getValue() ) {
				    		if ( $v->getDbColumn() ) {
				    			$dk = $v->getBindName()?$v->getBindName():$k;
	// 			    		echo "rs : " . $dk;
				    			$uItem->setAttribute("isnull", (is_null($rs->$dk)?'1':'0'));
				    			$value = $this->createNode("value",$rs->$dk);
				    		} else {
				    			$uItem->setAttribute("isnull", '0');
				    			$value = $this->createNode("value",$v->getName());
				    		}
			    		} else {
			    			$uItem->setAttribute("isnull", '0');
			    			$value = $this->createNode("value",$v->getValue());
			    		}
			    		$uItem->appendChild($value);
			    		$item->appendChild($uItem);
			    	}
			    }
		    	$this->results->appendChild($item);
		    }

		    $this->results->appendChild($fieldinfo);

		    $this->appendNode('row_count_' . $itemName , @$this->db->getNumRows($stmt)); // row count
		    $this->appendNode('affected_rows_' . $itemName , @$this->db->getAffectedRows()); // affected row count
		} catch (Exception $e) {
			$this->addErrMessage($e->getMessage());
		}
    }

    /**
     *
     * array를 xml을 반환합니다.
     * @param array $data
     * @param string $itemName
     * @param string $fieldInforName
     */
    public function oneRowToXML($data,$itemName="item",$fieldInforName="fieldinfo") {
    	global $page_tab;
    	$fieldinfo = $this->createNode($fieldInforName,NULL,$this->dom);
    	$dataType = "array";
//     	echo  ( $data instanceof stdClass );
    	if ( $data instanceof stdClass ) $dataType = "object";
    	try {
    		$item = $this->createNode($itemName);
    		foreach ( $data as $k => $v ) {
    			$fitem = $this->createNode(strtolower2($k));
    			$fitem->setAttribute("title", strtolower2($k));
    			$fieldinfo->appendChild($fitem);

    			$value = $dataType=="object"?$data->$k:$data[$k];

    			$uItem = $this->createNode(strtolower2($k),is_null($value)?"":$value);
    			$item->appendChild($uItem);
    		}
    		$this->results->appendChild($item);
    		$this->results->appendChild($fieldinfo);
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    }

    /**
     * 실행결과 xml을 반환합니다.
     * @param string $mode
     * @return string xmlString
     */
    public function printXML($mode) {
    	$this->appendNode('end_date',date('Y/m/d h:i:s A'));
    	$this->appendNode('last_sql',$this->db->getLastSql());

    	$this->message->setValue(implode($this->messages, "', '"));
	    if ( !$this->error ) {
	    	//$msg->setCode(C_DB_PROCESS_MODE_SAVE);
	    	$this->message->setObject("return",C_RETURN_CODE_SUCCESS);
	    } else {
	    	$this->message->setObject("return",C_RETURN_CODE_FAILURE);
	    }

	    $this->appendNode('mode', $mode); // mode

	    $obj = $this->message->getObject();
	    if ( $obj ) {
	    	// 				var_dump($obj);
	    	foreach($obj as $key => $value) {
	    		// 					echo '$key : ' . $value . '<BR>';
	    		$this->appendNode($key, $value);
	    	}
	    }

	    $this->appendNode('message', $this->message->getValue()); // message

	    if ( RESPONSE_TYPE == DATA_TYPE_JSON ) {
// 		    $json = json_encode(new SimpleXMLElement($this->dom->saveXML(), LIBXML_NOCDATA));
// 		    $json = json_encode(new SimpleXMLElement($this->dom->saveXML(), LIBXML_DTDVALID));
// var_dump($this->dom);
		    $json = json_encode($this->dom);
		    print $json;
	    } else if ( RESPONSE_TYPE == DATA_TYPE_XML ) {
	    	print $this->dom->saveXML();
	    }
    }

    /**
     * 저장 -  type이 grid 경우 공통 저장 처리.
     * @param array $argus
     * @param array $print :  false 인경우 직접 처리..
     *    	if (parent::save($argus,false)) {
     *    		$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
     *    	} else {
     *    		$this->addMessage("공정항목코드를 확인하세요.");
     *    	}
     *    	$this->printXML(C_DB_PROCESS_MODE_PROC);
     * @return string
     */
    public function save($argus,$print=true) {
    	// 	var_dump($argus);
    	$this->startHeader();
    	try {
    		// 	   	if ( !LOGIN ) throw new Exception("로그인정보가 없습니다.");
    		//     		echo $this->getTable(TBL_MEMBER)->getName();
    		//     		var_dump($this);
    		$tables = $this->getTables();
    		/* @var $table Table */
    		foreach($tables as $idx => $table) {
//     			    						echo $table->getName();
    			$sql = $this->makeSaveQuery($table,$argus);
    			if ( $sql ) {
    				$this->db->setAutoCommit(false);
    				$sql = $this->setQuery($sql);

    				if ( $this->exec($this->getQuery()) ) {
    					// 				out.print($this->db->getAffectedRows());
    					if ( !$this->db->commit() ) {
    						// 					throw new Exception($this->db->getErrMsg());
    						$this->error = true;
    						throw new Exception("에러가 발생하였습니다.".PHP_EOL."(" . $this->db->getErrMsg() .")");
    					}
    				} else {
    					// 				throw new Exception($this->db->getErrMsg());
    					$this->error = true;
    					throw new Exception("에러가 발생하였습니다.".PHP_EOL ."(" . $this->db->getErrMsg() .")");
    				}
    			}
    		}
    	} catch (Exception $e) {
    		$this->error = true;
    		if ( $print ) {
    			$this->addErrMessage($e->getMessage());
    		}
    	}

    	if ( $print ) {
    		$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SAVE)); // 성공시 출력 메시지.
    		$this->printXML(C_DB_PROCESS_MODE_PROC);
    	} else {
    		return !$this->error;
    	}
    }

    public function testJsCall($argus) {

    }
}
?>