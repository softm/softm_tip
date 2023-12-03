<?
/*****************************************************************/
/* include 되었는지를 검사                                      */
/*****************************************************************/
if( defined("_dboard_member_included") ) return;
	define ("_dboard_member_included", true);

// 회원 클래스
class Member {
	var $userId     ;
	var $memberLevel;
	var $name       ;
	var $eMail      ;
	var $memberst   ;
	var $regDate    ;
	var $newsyn     ;
	var $password   ;
	var $jumin1     ;
	var $jumin2     ;
	var $tel1       ;
	var $tel2       ;
	var $tel3       ;
	var $address1   ;
	var $address2   ;
	var $postNo     ;


	// D : 데이터 베이스 관련 Error;
	// I : 게시판 관련 에러;
	function Member ($userId, $memberLevel, $name,$eMail,$memberst,$regDate,$newsyn) {
		$this->userId       = $userId       ;
		$this->memberLevel  = $memberLevel  ;
		$this->name         = $name         ;
		$this->eMail        = $eMail        ;
		$this->memberst     = $memberst     ;
		$this->regDate      = $regDate      ;
		$this->newsyn       = $newsyn       ;
	}

	function getUserId      () { return $this->userId       ; }
	function getMemberLevel () { return $this->memberLevel  ; }
	function getName        () { return $this->name         ; }
	function getEMail       () { return $this->eMail        ; }
	function getMemberst    () { return $this->memberst     ; }
	function getRegDate     () { return $this->regDate      ; }
	function getNewsyn      () { return $this->newsyn       ; }
	function getPassword    () { return $this->password     ; }
	function getJumin1      () { return $this->jumin1       ; }
	function getJumin2      () { return $this->jumin2       ; }
	function getTel1        () { return $this->tel1         ; }
	function getTel2        () { return $this->tel2         ; }
	function getTel3        () { return $this->tel3         ; }
	function getAddress1    () { return $this->address1     ; }
	function getAddress2    () { return $this->address2     ; }
	function getPostNo      () { return $this->postNo       ; }
}

/*****************************************************************/
/* 함수명: Member                                               */
/* Argus : errType   : D : 데이터 베이스, 
/*****************************************************************/
function Member ($userId, $memberLevel, $name='',$eMail='',$memberst='',$regDate='',$newsyn='',$password='',$jumin1='',$jumin2='',$tel1='',$tel2='',$tel3='',$address1='',$address2='',$postNo='') {
	$memInfor = new Member ($userId, $memberLevel, $name,$eMail,$memberst,$regDate,$newsyn);
	return $memInfor;
}
?>