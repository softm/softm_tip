<?php
if ( defined("DEBUG") ) {
	define("DEBUG_INCLUDE",true);
} else {
	define("DEBUG_INCLUDE",false);
}

$pos = strpos($_SERVER[PHP_SELF],"/service/classes" );
define("DEBUG", $pos === false || $pos != 0 ?false:true);

if ( !DEBUG_INCLUDE && DEBUG ) {
	require_once '../../lib/common.lib.inc' ; // 라이브러리
}
require_once SERVICE_DIR . '/classes/BaseDataBase.php'; // 기본 DataBase 클래스

/**
 * @author softm
 * 세션 관련 / Session.php
 */
class Session extends BaseDataBase
{
	public function __construct() {
		parent::__construct();
		$this->debug = true;
	}

	public function __destruct() {
		parent::__destruct();
	}

	/**
	 * 비밀번호 기본 유효성 검사 -- 사용안함.
	 * @param string $password
	 * @param string $min_char
	 * @param string $max_char
	 * @return boolean
	 */
	static function validatePassword($password, $min_char = 1, $max_char = 20)
	{
		// Remove whitespaces from the beginning and end of a string
		$password = trim($password);

		// Accept only letters, numbers and underscore
		$eregi = eregi_replace('([a-zA-Z0-9_]{'.$min_char.','.$max_char.'})','', $password);

		if(empty($eregi)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 로그인 실행
	 * @param array $argus
	 */
	function login($argus) {
		$this->start();

		$p_user_id      = $argus[p_user_id ];
		$p_passwd       = $argus[p_passwd  ];
		$save_user_id   = $argus[save_user_id  ];
		$this->startHeader();
		try {
			//if ( Session::validatePassword($p_passwd) ) {
			//echo '$p_user_id : ' . $p_user_id . '<br>';
			//echo '$p_passwd : ' . $p_passwd . '<br>';
			$query = array();
			$query[] = " SELECT ";
			$query[] = " IFNULL(a.USER_NO,0) USER_NO    ,";
			$query[] = " a.USER_ID           USER_ID    ,";
			$query[] = " a.USER_EMAIL        USER_EMAIL ,";
			$query[] = " a.USER_LEVEL        USER_LEVEL ,";
			$query[] = " a.USER_NAME         USER_NAME  ,";
			$query[] = " a.ACCESS            ACCESS     ,";
			$query[] = " a.STATE             STATE       ";
			$query[] = " FROM " . TBL_MEMBER . " a " ;
			$query[] = " WHERE a.USER_ID    = '" . ($p_user_id) . "'";
			$query[] = " AND   a.PASSWD     = PASSWORD('" . ($p_passwd ) . "')";

// 			$query[] = " LIMIT 1";

			$rs = $this->db->get (join("\n", $query));

			$this->setQuery(join("\n", $query));

			//var_dump($rs);
			if ( !$rs->USER_NO ) {
				throw new Exception($this->message->getValue("LOGIN_NOT_CORRECT"));
			} else {
				if ( $rs->STATE == 'U' ) {
					$_s_memInfor[user_no     ] = $rs->USER_NO     ;
					$_s_memInfor[company_no  ] = $rs->COMPANY_NO  ;
					$_s_memInfor[user_id     ] = $rs->USER_ID     ;
					$_s_memInfor[user_email  ] = $rs->USER_EMAIL  ;
					$_s_memInfor[user_level  ] = $rs->USER_LEVEL  ;
					$_s_memInfor[user_name   ] = $rs->USER_NAME   ;
					$_s_memInfor[state       ] = $rs->STATE       ;
					$_s_memInfor[login       ] = true;
					$_s_memInfor[admin       ] = ($rs->USER_LEVEL == MEMBER_TYPE_ADM ?true:false);

					$_SESSION['_s_memInfor'] = $_s_memInfor;  // 4.10 세션 처리.
					@session_register("_s_memInfor");
					// 게시판관련 세션생성처리
					if (!isset($_SESSION['SESSION_USERID'])) {
                        $SESSION_USERID=$_s_memInfor[user_id     ];
						@session_register('SESSION_USERID');
					}
					if (!isset($_SESSION['SESSION_LEVEL'])) {
                        $SESSION_LEVEL=$_s_memInfor[user_level  ];
						@session_register('SESSION_LEVEL');
					}
					if (!isset($_SESSION['SESSION_NAME'])) {
                        $SESSION_NAME=$_s_memInfor[user_name  ];
						@session_register('SESSION_NAME');
					}
					GLOBAL $HTTP_SESSION_VARS;
					$HTTP_SESSION_VARS[SESSION_USERID] = $_s_memInfor[user_id     ];
					$HTTP_SESSION_VARS[SESSION_LEVEL]  = $rs->USER_LEVEL == MEMBER_TYPE_ADM?0:4;
					$HTTP_SESSION_VARS[SESSION_NAME]   = $_s_memInfor[user_name   ];

					$sql  = "UPDATE " .TBL_MEMBER
					. " SET "
// 					. " ACC_DATE  = substr(now() + 0,1,12) ,"
					. " ACC_DATE  = now() ,"
					. " ACCESS    = ACCESS + 1"
					. " WHERE USER_NO = '" . $rs->USER_NO . "'";

					if ( $this->db->exec($sql) ) {
					  //$this->addMessage("로그인에 성공하였습니다");
						$this->addMessage($this->message->getValue("LOGIN_SUCCESS"));
						if ( $save_user_id == "Y" ) {
							$_COOKIE["user_id"] = $rs->USER_ID;setcookie("user_id", $rs->USER_ID, time()+(3600*24*365),"/");
						}
						else{
							$_COOKIE["user_id"] = ""          ;setcookie("user_id", ""          , time()-36000,"/");
						}
					} else {

					  $this->addMessage("로그인하는중 오류가 발생하였습니다.");
                    }
				} else {
					throw new Exception("Membership is suspended.");
				}
			}
			//} else {
			//   throw new Exception("비밀번호는 영숫자만 사용가능합니다.");
			//}
		} catch (Exception $e) {
			$this->addErrMessage($e->getMessage());
		}
		$this->printXML(C_DB_PROCESS_MODE_PROC);
		$this->end();
	}

	/**
	 * 세션정보 반환
	 * @param string $key
	 * @return array
	 */
	public static function getSession($key='') {
		$_infor = $_SESSION["_s_memInfor"];
		if ( !$key ) {
			if ( !$_infor['user_id'] ) {
				$_infor['user_no'     ] = '0';
				$_infor['company_no'  ] = '0';
				$_infor['user_id'     ] = '' ;
				$_infor['user_email'  ] = '' ;
				$_infor['user_level'  ] = MEMBER_TYPE_NON;
				$_infor['user_name'   ] = '' ;
				$_infor['state'       ] = '' ;
				$_infor['login'       ] = false;  // 로그인여부
				$_infor['admin'       ] = false;  // 관리자여부
			}
			return $_infor;
		} else {
			return $_infor[$key];
		}
	}

	/**
	 * 세션정보 할당
	 * @param string $key
	 * @param string $val
	 */
	public static function setSession($key,$val) {
		$_infor = $_SESSION["_s_memInfor"];
		$_infor[$key] = $val;

		if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0이하
			@session_register("_s_memInfor");
		} else {
			$_SESSION['_s_memInfor'] = $_infor;  // 4.10 세션 처리.
		}
	}
}

$memInfor = Session::getSession();

define("LOGIN"     , $memInfor['login'     ]);
define("ADMIN"     , $memInfor['admin'     ]);
define("USER_LEVEL", $memInfor['user_level']);
define("USER_NAME" , $memInfor['user_name' ]);
define("USER_ID"   , $memInfor['user_id'   ]);
define("USER_EMAIL", $memInfor['user_email']);
define("USER_NO"   , $memInfor['user_no'   ]);
define("COMPANY_NO", $memInfor['company_no']);

if ( $_GET['backurl'] ) Session::setSession('backurl',$_GET['backurl']);
define("BACKURL"   , Session::getSession('backurl'));

if ( !DEBUG_INCLUDE && DEBUG ) {
	/* test */
	$argus = array();
	/* login */
	$argus[p_user_id] = "admin";
	$argus[p_passwd] = "1";
	$argus[save_user_id] = "Y";
	$test = new Session();
	$test->login($argus);
}
?>