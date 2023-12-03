<?php
require_once 'Table.php'          ; // Table.php
require_once 'Row.php'            ; // Row.php
require_once 'Column.php'         ; // Column.php
require_once 'WhereCondition.php' ; // WhereCondition.php

/**
* GridManager
* GRID 관련 데이터베이스 관리를 위한 Utility
*/
class GridManager {
	private static $instance;
	private static $conn;

	/** @var XML 문서의 버전은 1.0, 인코딩 방식은 UTF-8을 사용*/ private $dom;
	
	/** @var xml의 최상위 노드 */ private $results;
	
	/**
	 * @var DataBase
	 */
	private $db;

	/**
	 * @var array Table 
	 */
	private $tables = array();

	/**
	 * @return array Column
	 */
	private $columns = array();

	/**
	 * @var string
	 */
	private $query  ;

	/**
	 * @var string
	 */
	private $where ;

	/**
	 * @var string
	 * 메시지
	 */
	protected  $message ;
	
	/**
	 * @var array
	 */
	private $code_data = array();

	/**
	 * Return the Request object
	 *
	 * @return GridManager
	 */
	public static function getInstance() {
		if (!isset(self::$instance)) {
			$className = __CLASS__;
			//logp( 'Creating new instance. [' .  __CLASS__ . ']');
			self::$instance = new $className;
		}
		return self::$instance;
	}

	/**
	 * GridManager를 시작 ( db connect )
	 * @return void
	 */
	public function start() {
		if (!isset(self::$conn)) {
			define('DB_KIND','MYSQL'); // db kind
			$this->db   = new DataBase ();
			self::$conn = $this->db->getConnect();
			$this->db->exec("set names utf8;");
			//$this->db->exec("set names euc-kr;");
			//$this->db->exec("SET character_set_results = 'utf-8', character_set_client = 'utf-8', character_set_connection = 'utf-8', character_set_database = 'utf-8', character_set_server = 'utf-8'");
			//phpinfo();
		} else {
		}
	}

	/**
	 * GridManager를 종료합니다.
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
	 * Query Sort String 반환
	 * @return mixed
	 */
	public function getQuerySort() {
		$orderStr = array();
// 		var_dump($_POST);
// 		global $_POST;
		for( $i=0;$i<sizeof($_POST['sort_f']);$i++) {
			if      ($_POST['sort_d'][$i]=='▲') $dir = 'ASC' ;
			else if ($_POST['sort_d'][$i]=='▼') $dir = 'DESC';
			if ( $dir ) $orderStr[] = $_POST['sort_f'][$i] . ' ' . $dir;
		}
		return ( sizeof($orderStr)>0? join($orderStr,','):'' );		
	}

	
	/**
	 * 메시지를 설정합니다.
	 * @param $msg Message 
	 * @return void
	 */
	public function setMessage($msg) {
		$this->message = $msg;
	}

	/**
	 * 메시지를 반환합니다.
	 * @return Message
	 */
	public function getMessage() {
		return $this->message;
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
	 * @param $key string
	 * @param $value string
	 * @param $appendRoot DOM
	 * @return DOMElement
	 */
	private function createNode($key,$value=NULL,DOMNode $appendRoot=NULL) {
		$root = $this->dom;
		$rtn = $root->createElement($key);
		if( $value ) $rtn->appendChild($root->createCDATASection($value) );
		if ( $appendRoot instanceof DOMNode ) $appendRoot->appendChild($rtn);
		return $rtn;
	}
	/**
	 * @param string $name
	 * @param string $value
	 */
	public function appendNode($name,$value) {
		$newNode = $this->createNode($name, $value, $this->resluts);
		$this->results->appendChild($newNode);
	}
		
	/**
	 * 실행결과 xml을 반환합니다.
	 * @param string $mode 
	 * @return string xmlString
	 */
	public function makeXML($mode) {
		global $page_tab;
		header("Content-Type: text/xml; charset=UTF-8");
		header('Cache-Control: no-cache');
		header('Cache-Control: no-store' , false);
		//echo '$mode:' . $mode;
		$this->dom = new DOMDocument('1.0', 'UTF-8');
		// response 항목 생성
		$this->results   = $this->createNode('results',NULL,$this->dom);

			
// 		$programid = $this->createNode('programid',$_SERVER[PHP_SELF]    ,$resluts);

		$this->appendNode('sql',$this->getQuery());
		$this->appendNode('date',date('Y/m/d h:i:s A'));
		$this->appendNode('method',str_replace('/', '.', CLASS_POS)  . '.'. CLASS_NAME . '.' . METHOD);		
		if ( $this->code_data ) {
			$code = $this->createNode("code",NULL,$this->dom);
			foreach ($this->code_data as $k => $data) {
				$sub_data = $data;
				foreach ($sub_data as $sub_key => $v) {
					$code_data = $this->createNode(strtolower($k),$v);
					$code_data->setAttribute("id", $sub_key);
					$code->appendChild($code_data);
				}
			}
			$this->results->appendChild($code);
		}
		//echo $mode . "<br>";
// 		echo 'C_DB_PROCESS_MODE_UPDATE : ' . C_DB_PROCESS_MODE_UPDATE;
		switch ($mode) {
			case C_DB_PROCESS_MODE_SELECT:
				$fieldinfo = $this->createNode('fieldinfo',NULL,$this->dom);
				
// 				/**
// 				 * @param Column $a
// 				 * @param Column $b
// 				 * @return number
// 				 */
// 				function cmp($a, $b) {
// 					if ($a->getIndex() == $b->getIndex()) {
// 						return 0;
// 					}
// // 					echo $a->getName() . " / " . $b->getName() . " | " . $a->getHide() . " / " . $b->getHide() . "\n";
// 					return ($a->getIndex() < $b->getIndex() && !$a->getHide() ) ? -1 : 1;
// 				}
				uasort ($this->columns, "columnSort");
				
				$idx = 0;
				/* @var $v Column */
				foreach ( $this->columns as $v ) {
					$v->setIndex($idx++);					
					//echo $v->getIndex() . "<BR>";
// 					echo $v->getColName() . "<BR>";
					$fitem = $this->createNode(strtolower($v->getColName()));
					$fitem->setAttribute("title", $v->getTitle());
					$fitem->setAttribute("editable", $v->getEditable());
					$fitem->setAttribute("type", $v->getType());
					$fitem->setAttribute("index", $v->getIndex());
					$fitem->setAttribute("html", $v->getHtml());
					$fitem->setAttribute("hide", $v->getHide());
										
					if ( (string)$v->getWidth()   != "") $fitem->setAttribute("width", $v->getWidth());					
					if ( (string)$v->getAlign()   != "") $fitem->setAttribute("align", $v->getAlign());					
					if ( (string)$v->getCssText() != "") $fitem->setAttribute("cssText", $v->getCssText());					
					$fieldinfo->appendChild($fitem);
				}
				
				//<fieldinfo><COUNTRY_CODE name='COUNTRY_CODE' title='국가코드' updatable='' width='65' type='TEXT' index='0' updateType='M' />
				
				$this->results->appendChild($fieldinfo);
				$stmt = $this->db->multiRowSQLQuery ($this->getQuery());
				try {
					$row_count = @$this->db->getNumRows($stmt);
				} catch (Exception $e) { }
// 				echo $this->getQuery() . "<BR>";
// 				echo $this->db->getErrMsg() . "<BR>";
				while ( $rs = $this->db->multiRowFetch  ($stmt) ) {
					$item = $this->createNode("item");
					foreach ( $this->columns as $v ) {
						$k = $v->getColName();
						//echo "rs : " . $k;
						$uItem = $this->createNode(strtolower($k));
						if ( $v->getDbColumn() ) {
							$uItem->setAttribute("isnull", (is_null($rs->$k)?'1':'0'));
							$value = $this->createNode("value",$rs->$k);
						} else {
							$uItem->setAttribute("isnull", '0');
							$value = $this->createNode("value",$v->getName());
						}
						$uItem->appendChild($value);
						$item->appendChild($uItem);
					}
					$this->results->appendChild($item);
				}
				$pagenavi = $this->createNode("pagenavi",NULL,$results);
				$this->createNode("html"     ,pageTab($page_tab)    ,$pagenavi);
				$this->createNode("how_many" ,$page_tab["how_many" ],$pagenavi);
				$this->createNode("more_many",$page_tab["more_many"],$pagenavi);
				$this->createNode("page_many",$page_tab["more_many"],$pagenavi);
				$this->createNode("total"    ,$page_tab["tot"      ],$pagenavi);
				$this->createNode("position" ,$page_tab["s"        ],$pagenavi);
				
				$msg = new Message();
				$msg->setCode(C_DB_PROCESS_MODE_SELECT);
				$msg->setValue($msg->getValue(C_DB_PROCESS_MODE_SELECT));
				if ( $this->db->getErrMsg() ) $errors[] = $this->db->getErrMsg();
				if ( empty($errors) ) {
					$msg->setObject("return",C_RETURN_CODE_SUCCESS);
				} else {
					$msg->setObject("return",C_RETURN_CODE_FAILURE);
					$msg->setValue(implode($errors, "', '"));
				}
				$msg->setObject("row_count",$row_count);
				$this->setMessage($msg);			
				
				break;

			case C_DB_PROCESS_MODE_UPDATE:

				break;
			default:
			break;
		}
		
		$modeO= $this->createNode('mode',$mode,$resluts);
		$this->results->appendChild($modeO);
		
		$msg = $this->getMessage();
		
		if ( $msg ) {
			$obj = $msg->getObject();
			if ( $obj ) {
// 				var_dump($obj);
				foreach($obj as $key => $value) {
// 					echo '$value : ' . $value . '<BR>';
					$set = $this->createNode($key,$value,$resluts);
					$this->results->appendChild($set);
				}
			}
			$message= $this->createNode('message',$msg->getValue(),$resluts);
			$this->results->appendChild($message);
		}	
		$rtn = $this->dom->saveXML();
// 		echo $rtn . "<br>";
		return $rtn;
	}
}
?>
<?
function toResultXML($o) {
header("Content-Type: text/xml; charset=UTF-8");
header('Cache-Control: no-cache');
header('Cache-Control: no-store' , false);
print '<?xml version="1.0" encoding="UTF-8"?>';
print '<result>';
/**/
print '<programid><![CDATA['. $_SERVER[PHP_SELF] . ']]></programid>';
print '<sql><![CDATA['.$o[sql]. ']]></sql>';
print '<date>' . date('Y/m/d h:i:s A') . '</date>';
print '<status>';
print("<code>" . $o[code] . "</code>\n");
print("<mode>" . $o[p_mode]."</mode>\n");
print("<message><![CDATA[".$o[message]."]]></message>\n");
print '</status>';
print '</result>';
}
//------------------------------------------
// This function returns the necessary
// size to show some string in display
// For example:
// $a = strlen_layout("WWW"); // 49
// $a = strlen_layout("..."); // 16
// $a = strlen_layout("Hello World"); // 99
//------------------------------------------
function strlen_pixels($text) {
	/*
	 Pixels utilized by each char (Verdana, 10px, non-bold)
	04: j
	05: I\il,-./:; <espace>
	06: J[]f()
	07: t
	08: _rz*
	09: ?csvxy
	10: Saeko0123456789$
	11: FKLPTXYZbdghnpqu
	12: AÇBCERV
	13: <=DGHNOQU^+
	14: w
	15: m
	16: @MW
	*/

	// CREATING ARRAY $ps ('pixel size')
	// Note 1: each key of array $ps is the ascii code of the char.
	// Note 2: using $ps as GLOBAL can be a good idea, increase speed
	// keys:    ascii-code
	// values:  pixel size

	// $t: array of arrays, temporary
	$t[] = array_combine(array(106), array_fill(0, 1, 4));

	$t[] = array_combine(array(73,92,105,108,44), array_fill(0, 5, 5));
	$t[] = array_combine(array(45,46,47,58,59,32), array_fill(0, 6, 5));
	$t[] = array_combine(array(74,91,93,102,40,41), array_fill(0, 6, 6));
	$t[] = array_combine(array(116), array_fill(0, 1, 7));
	$t[] = array_combine(array(95,114,122,42), array_fill(0, 4, 8));
	$t[] = array_combine(array(63,99,115,118,120,121), array_fill(0, 6, 9));
	$t[] = array_combine(array(83,97,101,107), array_fill(0, 4, 10));
	$t[] = array_combine(array(111,48,49,50), array_fill(0, 4, 10));
	$t[] = array_combine(array(51,52,53,54,55,56,57,36), array_fill(0, 8, 10));
	$t[] = array_combine(array(70,75,76,80), array_fill(0, 4, 11));
	$t[] = array_combine(array(84,88,89,90,98), array_fill(0, 5, 11));
	$t[] = array_combine(array(100,103,104), array_fill(0, 3, 11));
	$t[] = array_combine(array(110,112,113,117), array_fill(0, 4, 11));
	$t[] = array_combine(array(65,195,135,66), array_fill(0, 4, 12));
	$t[] = array_combine(array(67,69,82,86), array_fill(0, 4, 12));
	$t[] = array_combine(array(78,79,81,85,94,43), array_fill(0, 6, 13));
	$t[] = array_combine(array(60,61,68,71,72), array_fill(0, 5, 13));
	$t[] = array_combine(array(119), array_fill(0, 1, 14));
	$t[] = array_combine(array(109), array_fill(0, 1, 15));
	$t[] = array_combine(array(64,77,87), array_fill(0, 3, 16));

	// merge all temp arrays into $ps
	$ps = array();
	foreach($t as $sub) $ps = $ps + $sub;

	// USING ARRAY $ps
	$total = 1;
	for($i=0; $i<strlen($text); $i++) {
		$temp = $ps[ord($text[$i])];
		if (!$temp) $temp = 10.5; // default size for 10px
		$total += $temp;
	}
	return $total;
}
?>