<?php
class Column {

	/**
	 * @var Table
	 */
	private $table;
	private $name;
	private $bindName;
	private $alias;
	private $title;
	private $index;
	private $editable;
	private $type;
	private $width;
	private $align;
	private $cssText;
	private $html;
	private $sortable;
	private $hide;
	private $transaction;
	private $dbColumn;
	private $key;
	private $dataType;
	private $value;	

	private static $sIndex =0;
	/**
	 * @var COLUM의 표현형태 - TEXT
	 */
	const TEXT_TYPE    = "TEXT"     ; // TEXT
	/**
	 * @var COLUM의 표현형태 - CHECKBOX
	 */
	const CHECKBOX_TYPE= "CHECKBOX" ; // CHECKBOX
	/**
	 * @var COLUM의 표현형태 - RADIO
	 */
	const RADIO_TYPE   = "RADIO"    ; // RADIO
	/**
	 * @var COLUM의 표현형태 - LISTBOX (SELECT)
	 */
	const LISTBOX_TYPE = "SELECT"   ; // SELECT

	public function getColName    ()  {
		return $this->getAlias()?$this->getAlias():$this->getName();
// 		return $this->getName();
	}

	public function getName    ()  {
		return $this->name;
	}

	public function getAlias    ()  {
		return $this->alias    ;
	}
	
	public function getBindName   () {
		return $this->bindName;
	}

	public function getTitle   ()  {
		return $this->title   ;
	}

	public function getIndex   ()  {
		return $this->index   ;
	}
	public function getEditable()  {
		return $this->editable;
	}
	public function getType    ()  {
		return $this->type    ;
	}
	public function getWidth   ()  {
		return $this->width   ;
	}
	public function getAlign   ()  {
		return $this->align;
	}
	public function getCssText   () {
		return $this->cssText;
	}
	public function getHtml   () {
		return $this->html;
	}
	public function getSortable() {
		return $this->sortable;
	}
	public function getHide() {
		return $this->hide;
	}
	public function getTable   ()  {
		return $this->table   ;
	}
	public function getTransaction()  {
		return $this->transaction;
	}
	public function getDbColumn()  {
		return $this->dbColumn;
	}
	public function getKey()  {
		return $this->key;
	}
	public function getDataType()  {
		return $this->dataType;
	}
	public function getValue()  {
		return $this->value;
	}
	
	public function setName    ($name    ) {
		$this->name  = $name ;
		return $this;
	}

	public function setAlias   ($alias   ) {
// 		$this->getTable()->newColumn($alias, $this->getTitle());
		$this->alias  = $alias;
		return $this;
	}
	
	public function setBindName   ($bindName) {
		$this->bindName = $bindName;
		return $this;
	}
	
	public function setTitle   ($title   ) {
		$this->title = $title;
		return $this;
	}
	public function setIndex   ($index   ) {
		$this->index = $index;
		return $this;
	}
	public function setEditable($editable) {
		$this->editable= $editable;
		return $this;
	}
	public function setType    ($type    ) {
		if ( $type != Column::TEXT_TYPE && $type != Column::CHECKBOX_TYPE && $type != Column::RADIO_TYPE  && $type != Column::LISTBOX_TYPE ) trigger_error("컬럼 타입이 올바르지 않습니다.", E_USER_ERROR);
		$this->type    = $type;
		return $this;
	}
	public function setWidth   ($width   ) {
		$this->width   = $width;
		return $this;
	}
	public function setAlign   ($align   ) {
		$this->align   = $align;
		return $this;
	}
	public function setCssText   ($cssText   ) {
		$this->cssText   = $cssText;
		return $this;
	}
	/**
	 * @param bool $html
	 * @return Column
	 */
	public function setHtml		($html=true ) {
		$this->html = $html;
		return $this;
	}
	/**
	 * @param bool $sortable
	 * @return Column
	 */
	public function setSortable($sortable=true ) {
		$this->sortable = $sortable;
		return $this;
	}
	/**
	 * @param bool $hide
	 * @return Column
	 */
	public function setHide		($hide=true) {
		$this->hide = $hide;
		return $this;
	}
	public function setTable   ($table)  {
		$this->table = $table;
	}
	public function setTransaction($transaction)  {
		$this->transaction = $transaction;
		return $this;
	}
	public function setDbColumn($dbColumn)  {
		$this->dbColumn = $dbColumn;
		return $this;
	}
	/**
	 * where 절에 조건절로 셋팅여부.
	 * @param boolean $key
	 * @return Column
	 */
	public function setKey($key)  {
		$this->key = $key;
		return $this;
	}
	
	public function setDataType($dataType)  {
		$this->dataType = $dataType;
		return $this;
	}
	
	public function setValue($value)  {
		$this->value = $value;
		$this->setKey(false);
		return $this;
	}
	
	/**
	 * @param string $name
	 * @param string $title
	 * @param Table &$table
	 */
	public function __construct($name,$title,&$table=null) {
		//if ( !$name || !$title ) trigger_error("Column 정보가 정확하지 않습니다.", E_USER_ERROR);
		if ( !$name ) trigger_error("Column 정보가 정확하지 않습니다.", E_USER_ERROR);
		$this->name     = $name ;
		$this->bindName = null;
		$this->title    = $title?$title:$name;
		$this->index    = $index;
		$this->editable = false ;
		$this->type     = Column::TEXT_TYPE;
		$this->table    = $table;
		$this->html     = false;
		$this->hide     = false;
		$this->transaction = true;
		$this->dbColumn = true;
		$this->key 		= true;
		$this->sortable = true;
		
		$this->dataType = "string"; // strting, number, currency
	}
}
?>