<?php
class Table {
	
	/**
	 * @var GridManager, BaseDataBase
	 */
	private $dbm;

	/**
	 * @var Column
	 */
	private $columns;
	
	private $name;
	private $type;
	private $transaction;
	
	const TABLE_TYPE      = "T" ; // TABLE
	const VIEW_TYPE       = "V" ; // VIEW
	const INLINEVIEW_TYPE = "IV"; // INLINE VIEW

	/**
	 * @param string $name
	 * @param GridManager $dbm
	 */
	function Table($name,&$dbm=null) {
		$this->name = $name;
		$this->dbm  = $dbm;
		$this->transaction= true;
	}

	/**
	 * Table명을 반환함
	 * @return string
	 */
	public function getName()      {
		return $this->name;
	}

	/**
	 * Table명을 할당
	 * @param string $name
	 * @return string
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param $name string 컬럼명
	 * @param $title string 헤더 타이틀
	 * @param $index int 위치
	 * @return Column
	 */
	public function newColumn($name,$title,$index=null) {
		$rtn = $this->dbm->setColumn($name,new Column($name,$title,$this),$index);
		$this->columns[$rtn->getName()] = &$rtn; 
		return $rtn;
	}

	/**
	 * @param $column Column 컬럼명
	 * @param $index int 위치
	 * @return Column
	 */
	public function addColumn($column,$index=null) {
		$rtn = null;
		$column->setTable($this);
		if (!$index) {
			$index = 0;			
			if ( isset($this->columns) ) {
				foreach($this->columns as $key => $value) {
					$index++;
				}
			}
		}
		$column->setIndex($index);
		$rtn = $this->columns[$column->getName()] = &$column;
		return $rtn;
	}
	
	/**
	 * @param $name string 컬럼명
	 * @param $title string 헤더 타이틀
	 * @param $index int 위치
	 * @return Column
	 */
	public function removeColumn($name) {
 		unset($this->columns[$name]);
 		$this->dbm->removeColumn($name);
	}
	
	/**
	 * @param $name string 컬럼명
	 * @return Column
	 */
	public function getColumn($name) {
// 		return $this->dbm->getColumn($name);
		return $this->columns[$name];
	}


	/**
	 * @return array Column 
	 * 컬럼 배열을 반환
	 */
	public function getColumns() {
		return (array)$this->columns;
	}
	
// 	/**
// 	 * @return Column array
// 	 * 컬럼 배열을 반환
// 	 */
// 	public function getDbmColumns() {
// 		$columns = $this->dbm->getColumns();
// 		$rtn = array();
// 		foreach ( $columns as $v ) {
// 			//print_r($v->getTable());	
// 			if ( $v->getTable() === $this ) $rtn[$v->getName()] = $v;  
// 		}		
// 		return $rtn;
// 	}
	
	/**
	 * @return GridManager
	 */
	public function getDbm() {
		return $this->dbm;
	}
	
	/**
	 * @param GridManager $dbm
	 * @return GridManager
	 */
	public function setDbm($dbm) {
		$this->dbm = $dbm;
		return $this->dbm; 
	}
	
	/**
	 * Table Type을 설정합니다.
	 * @param string type
	 * @return Table
	 */
	public function setType($type) {
		if ( $type != Table::TABLE_TYPE && $type != Table::VIEW_TYPE && $type != Table::INLINEVIEW_TYPE ) trigger_error("테이블 타입이 올바르지 않습니다.", E_USER_ERROR);
		$this->type = $type;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * Table명을 반환함
	 * @return string
	 */
	public function loadAllField($width=0)      {
		$idx=0;
		$stmt = $this->dbm->getDataBase()->multiRowSQLQuery (" desc " . $this->getName());
		while ( $rs = $this->dbm->getDataBase()->multiRowFetch  ($stmt) ) {
// 			echo "rs->Field : " . $rs->Field . "<BR>";
        	$col1 = $this->newColumn($rs->Field,$rs->Field    ,$idx++)
        	->setEditable(true)
        	->setWidth($width)
        	->setAlign("center");
		}		
	}
	
	public function getTransaction()  {
		return $this->transaction;
	}
		
	public function setTransaction($transaction)  {
		$this->transaction = $transaction;
		return $this;
	}
}
?>