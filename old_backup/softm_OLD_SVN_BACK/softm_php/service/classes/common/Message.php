<?php
/**
 * Message
 * 메시지
 */
 class Message extends stdClass {
	/**
	 * @var
	 * @see var.define.inc에 상수로 정의해야함.
	 * 메시지
	 */
	public static $MESSAGE_STRING = array (
	    "BASIC"=>"완료되었습니다.",			
		"R"=>"조회되었습니다.",
		"I"=>"입력되었습니다.",
		"U"=>"수정되었습니다.",
		"D"=>"삭제되었습니다.",
		"S"=>"저장되었습니다.",
		"LOGIN_SUCCESS"=>"로그인에 성공하였습니다.",
		"LOGIN_NOT_CORRECT"=>"로그인 정보가 정확하지 않습니다.",
		"MEMBER_REG_SUCCESS"=>"가입되었습니다."
	);
		
	/**
	 * @var string CODE_SUCCESS, CODE_FAILURE
	 */
	private $code;

	/**
	 * @var string 메시지 내용
	 */
	private $value;
		
	function setCode ($code ) { $this->code  = $code; }	
	function getCode () { return $this->code;  }	
 	
	function setValue($value) { $this->value = $value; }	
	function getValue($code=null) {
		$rtn = null;
		if ( $code ) {
			$rtn = self::$MESSAGE_STRING[$code];
		} else {
			$rtn = $this->value;
		}
		return $rtn;
	}
	
	/**
	 * @var 
	 */
	private $object = array();
	public function setObject($key, $value) { $this->object[$key] = $value;}
	public function getObject($key=null) { return $key?$this->object[$key]:$this->object; }
	
	public function __construct($code=null,$value=null) {
		$this->code  = $code;
		$this->value = ( $value?$value:self::$MESSAGE_STRING[$code]);
	}
}
?>