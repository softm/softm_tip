<?php
/**
 * WhereCondition
 * 조건절
 */
class WhereCondition {
	/**
	 * @var boolean
	 * equal비교 true / not true
	 */
	public $equal	;
	/**
	 * @var boolean
     * like비교 true / not true
	 */	
	public $like   ;
	/**
	 * @var boolean
     * where조건식 true / not true
	 */	
	public $where ;
	/**
	 * @var string
     * $equal ,$like == true : 값
     * $where        == true : 조건식이 들어감 ( EX) USER_ID = '1' )
	 */	
	public $value  ;
}
?>