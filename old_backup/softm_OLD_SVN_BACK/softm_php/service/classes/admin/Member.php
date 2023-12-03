<?php
define("DEBUG",ereg("^/service/classes", $_SERVER[PHP_SELF]));
if ( DEBUG ) {
	require_once '../../lib/common.lib.inc' ; // 라이브러리
	require_once SERVICE_DIR . '/classes/common/Session.php'          ; // 세션	
}
require_once SERVICE_DIR . '/classes/BaseDataBase.php'; // 기본 DataBase 클래스
require_once SERVICE_DIR . '/classes/common/Util.php'; // Util클래스

/**
 * @author softm
 * 회원관련 / Member.php
 */
class Member extends BaseDataBase
{
    public function __construct() {
        parent::__construct();
        $this->debug = true;
        $this->start();
		if ( METHOD == "select" || METHOD == "save"  ) {   
	        $tbl1 = $this->newTable(TBL_MEMBER);
	        $seq = 0;
	        $tbl1->newColumn('USER_NO'   ,'No.'        ,++$seq)->setWidth( 90)->setAlign("center")->setKey(true);
	        $tbl1->newColumn('REG_DATE'  ,'가입일시'   ,++$seq)->setWidth(190)->setAlign("center")->setKey(false);
	        $tbl1->newColumn('USER_LEVEL','권한'       ,++$seq)->setWidth(120)->setType(Column::LISTBOX_TYPE)->setEditable(true);
	        $tbl1->newColumn('USER_ID'   ,'아이디'     ,++$seq)->setWidth(160)->setAlign("center")->setKey(false);
	        $tbl1->newColumn('USER_NAME' ,'이름'       ,++$seq)->setWidth(150)->setEditable(false)->setKey(false);
	        $tbl1->newColumn('BIRTH'     ,'생년월일'   ,++$seq)->setWidth(160)->setAlign("center")->setKey(false);
	        $tbl1->newColumn('USER_EMAIL','이메일'     ,++$seq)->setWidth(160)->setAlign("left")->setKey(false);
	        $tbl1->newColumn('TEL'       ,'전화번호'   ,++$seq)->setWidth(120)->setAlign("center")->setKey(false);
	        
// 	        No. 	가입일시 	권한 	아이디 	비밀번호 	이름 	생년월일 	이메일 	전화번호 	수정 	삭제
 			$tbl1->newColumn("BTN1"     ,'수정'  ,++$seq)->setWidth(60)->setHtml(true)->setSortable(false)->setType(Column::TEXT_TYPE)
 			->setValue("<a class='btn_edit btn_modify' >수정</a>");
 			$tbl1->newColumn("BTN2"     ,'삭제'  ,++$seq)->setWidth(60)->setHtml(true)->setSortable(false)->setType(Column::TEXT_TYPE)
 			->setValue("<a class='btn_edit btn_delete' >삭제</a>");

		}        
    }

    public function __destruct() {
        parent::__destruct();
        $this->end();
    }
    
    /**
     * 조회
     * @param array $argus
     * @return DOMDocument
     */
    public function select($argus) {
    	global $page_tab;
    	//     $this->testJsCall($argus);
    	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
    	$this->startHeader();
    	$this->setType(BaseDataBase::GRID_TYPE);
    	try {
    		if ( !ADMIN ) throw new Exception("권한이 없습니다.");
    		//var_dump($argus);
    		$page_tab['js_function' ] = $argus["p_navi_function"];
    		$page_tab['s'           ] = !$argus["p_navi_start"]?1:(int)$argus["p_navi_start"];
    		if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];
    
    		// where 문장생성
    		$make_where = $this->makeWhere($argus);
    		// 			echo     	$make_where;
    		$where = " 1 = 1";
    		
    		$where .= $make_where?" AND " . $make_where:"";
    		
    		// row 갯수
    		$page_tab['tot'] = $this->db->getOne("SELECT COUNT(*) FROM " . TBL_MEMBER 
							                     . " " . ( $where ? " WHERE " . $where:"" ) 
    											);
//     		echo $this->db->getErrMsg();
//     		echo $page_tab['tot']; 
    		$query = array();
			    		    		
    		$query [] = " SELECT ";
    		$query [] = "    a.USER_NO          USER_NO      ";
    		$query [] = "  , a.USER_ID          USER_ID      ";
    		$query [] = "  , a.USER_EMAIL       USER_EMAIL   ";
    		$query [] = "  , a.USER_NAME        USER_NAME    ";
    		$query [] = "  , a.USER_LEVEL       USER_LEVEL   ";
    		$query [] = "  , DATE_FORMAT(a.REG_DATE ,'%Y-%m-%d %p %h:%i:%s') REG_DATE     ";
    		$query [] = "  , CONCAT(SUBSTR(a.BIRTH,1,4),'년 ',SUBSTR(a.BIRTH,5,2),'월 ',SUBSTR(a.BIRTH,7,2),'일') BIRTH";
    		$query [] = "  , a.TEL TEL";
    		$query [] = " FROM " . TBL_MEMBER . " a  ";

//     		$query [] = " SELECT                            ";
//     		$query [] = "  a.USER_NO          USER_NO      ,";
//     		$query [] = "  a.USER_EMAIL       USER_EMAIL   ,";
//     		$query [] = "  a.USER_NAME        USER_NAME    ,";
//     		$query [] = "  a.USER_LEVEL       USER_LEVEL   ,";
//     		$query [] = "  DATE_FORMAT(a.REG_DATE ,'%Y-%m-%d') REG_DATE    ";
//     		$query [] = " FROM TBL_MEMBER  a";
    
    		// where 문장생성
    		if ( $where ) $query[] = ( " WHERE " . $where );
    
    		$query[] =  ( $this->getQuerySort()?" ORDER BY ". $this->getQuerySort():'' );
    		$query[] =  " LIMIT " . ( $page_tab['s'] - 1 ) . ", " . $cur_many;
    
    		$this->setQuery(join("\n", $query));
    		//         out.print($this->getQuery());
    
    		// 		var_dump($this->getColumns());
    
    		$this->makeItemXML($this->getQuery(),"item","fieldinfo");
    		//         out.print($this->db->getAffectedRows());
    		$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->printXML(C_DB_PROCESS_MODE_SELECT);
    }

    /**
     * 회원가입
     * @param array $argus
     */
    function register($argus) {
    	$p_user_id   = $argus[user_id     ];
    	if ( $argus[user_email1] || $argus[user_email2]  ) {
    		$p_user_email= $argus[user_email1  ].'@'.$argus[user_email2  ];
    	}
    	$p_user_name = $argus[user_name   ];
    	$p_user_level= $argus[user_level  ];
    	$passwd      = $argus[passwd      ];
    	$state       = "U"; // 사용
    	 
    	$passwd_hint   = $argus[passwd_hint   ];
    	$passwd_correct= $argus[passwd_correct];
    	if ( $argus[tel1] && $argus[tel2] && $argus[tel3]) {
    		$tel       = $argus[tel1     ]."-".$argus[tel2     ]."-".$argus[tel3     ];
    	}
    	$birth     = $argus[birth1     ]."".$argus[birth2     ]."".$argus[birth3     ];
    	 
    	$this->testJsCall($argus);
    	$this->startHeader();
    	try {
    		$query  = "INSERT INTO " . TBL_MEMBER
    		. " ( "
    		. " USER_ID       ,"
    		. " USER_EMAIL    ,USER_LEVEL  ,PASSWD      ,"
    		. " USER_NAME   ,"
    		. " PASSWD_HINT , PASSWD_CORRECT,"
    		. " BIRTH , TEL,"
    		. " REG_DATE    ,STATE"
    		. " ) VALUES ("
    		. " '" . strtolower($p_user_id   ) . "',"
    		. " '" . strtolower($p_user_email) . "','" . $p_user_level . "',PASSWORD('" . $passwd . "'),"
    		. " '" . $p_user_name . "',"
    		. " '" . $passwd_hint . "','" . $passwd_correct . "',"
    		. " '" . $birth . "','" . $tel . "',"
    		. " now(), '" . $state . "'"
    		. " )";
    
    		$this->setQuery($query);
    		$this->db->setAutoCommit(false);
    		if ( $this->exec($query) ) {
    			if ( $this->db->commit() ) {
    				$this->addMessage($this->message->getValue("MEMBER_REG_SUCCESS")); // 성공시 출력 메시지.
    			}
    		} else {
    			$this->addMessage("저장중 오류가 발생하였습니다.");
    		}
    
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->printXML(C_DB_PROCESS_MODE_PROC);
    }
    
    /**
     * 회원수정
     * @param array $argus
     */
    function update($argus) {
    	$p_user_level= $argus[user_level  ];
    	    	
    	$p_user_no   = $argus[user_no     ];
    	$p_user_email= $argus[user_email  ];
    	$p_user_name = $argus[user_name   ];
    	$passwd      = $argus[passwd      ];
    	$password_change= $argus[password_change];
    	$passwd_hint   = $argus[passwd_hint   ];
    	$passwd_correct= $argus[passwd_correct];
    	
        if ( $argus[tel1] && $argus[tel2] && $argus[tel3]) {
    		$tel       = $argus[tel1     ]."-".$argus[tel2     ]."-".$argus[tel3     ];
    	}
    	$birth     = $argus[birth1   ]."".  sprintf("%02d", $argus[birth2     ])."".sprintf("%02d", $argus[birth3     ]);
    	
    	$this->testJsCall($argus);
    	$this->startHeader();
    	try {
    		if ( !ADMIN ) throw new Exception("관리자가 아닙니다.");    		
    		$query[] = " UPDATE " .TBL_MEMBER;
    		$query[] = " SET ";
//     		$query[] = " USER_NO       = '" . . "',"
    		$query[] = " USER_EMAIL    = '" . $p_user_email . "',";
    		$query[] = " USER_LEVEL    = '" . $p_user_level . "',";
			if( $password_change =='Y' && trim($passwd) ) { 
    			$query[] = " PASSWD        = PASSWORD('" . $passwd         . "'),";
			}
    		$query[] = " USER_NAME     = '" . $p_user_name    . "',";
    		$query[] = " PASSWD_HINT   = '" . $passwd_hint    . "',";
    		$query[] = " PASSWD_CORRECT= '" . $passwd_correct . "',";
    		$query[] = " TEL   = '" . $tel   . "', ";
    		$query[] = " BIRTH = '" . $birth . "' ";
    		$query[] = " WHERE USER_NO = '" . $p_user_no      . "'";
//     		echo join("\n", $query);
    		$this->setQuery(join("\n", $query));
    		$this->db->setAutoCommit(false);
			if ( $this->exec($this->getQuery()) ) {
				if ( $this->db->commit() ) {
					$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_UPDATE)); // 성공시 출력 메시지.
				}
    		} else {
    			// $this->addMessage("로그인에 성공하였습니다.");
    		}
 
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->printXML(C_DB_PROCESS_MODE_PROC);
    }
    
    /**
     * 회원정보 조회
     * @param array $argus
     */
    function get($argus) {
    	$p_user_no      = $argus[p_user_no ];
    	$this->testJsCall($argus);
    	$this->startHeader();
    	try {
    		if ( !ADMIN ) throw new Exception("관리자가 아닙니다.");    		
//     		echo 'get $this->type : ' .  $this->getType() . "\n";
    		$query = array();
    		$query[] = "SELECT";
    		$query[] = " USER_NO       ,"; // 회원번호
    		$query[] = " USER_ID       ,"; // 아이디
    		$query[] = " USER_EMAIL    ,"; // 이메일
    		$query[] = " USER_LEVEL    ,"; // 회원 레벨 관리자:9 일반:1 기업:2
    		//$query[] = " PASSWD        ,"; // 비밀번호
    		$query[] = " USER_NAME     ,"; // 이름
    		$query[] = " PASSWD_HINT   ,"; // 비밀번호힌트
    		$query[] = " PASSWD_CORRECT,"; // 비밀번호정답
    		$query[] = " BIRTH,"; // 생년월일
    		$query[] = " TEL,"; // 전화번호
    		$query[] = " ACCESS        ,"; // 접속 횟수
    		$query[] = " REG_DATE      ,"; // 가입 일자
    		$query[] = " ACC_DATE      ,"; // 최근 접근일
    		$query[] = " STATE          "; // 회원 상태 : 1/0
    		$query[] = " FROM " . TBL_MEMBER;
    		$query[] = " WHERE USER_NO = '" . $p_user_no . "'" ;
    		$this->setQuery(join("\n", $query));
    		$this->makeItemXML(join("\n", $query),"item","fi");
    		$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_SELECT)); // 성공시 출력 메시지.
	
    	} catch (Exception $e) {
    		$this->addErrMessage($e->getMessage());
    	}
    	$this->printXML(C_DB_PROCESS_MODE_SELECT);
    }
    
    
    /**
     * 저장
     * @param array $argus
     * @return string
     */
    public function save($argus) {
    	$p_mode       = $argus['mode'][0];
    	$p_user_no    = $argus[USER_NO_o][0];

    	if ( $p_mode ==  C_DB_PROCESS_MODE_DELETE ) {
    		$this->testJsCall($argus);
    		$this->startHeader();
    		try {
    			if ( !ADMIN ) throw new Exception("관리자가 아닙니다.");
    			$this->db->setAutoCommit(false);
//     			if ( Company::batchDelete($this->db,array(p_user_no=>$p_user_no,p_company_no=>$p_company_no),2) ) {
	    			$query[] = " DELETE FROM " .TBL_MEMBER;
	    			$query[] = " WHERE USER_NO = '" . $p_user_no      . "'";
	    			//     		echo join("\n", $query);
	    			$this->setQuery(join("\n", $query));
	
	    			if ( $this->exec($this->getQuery()) ) {
	    				if ( $this->db->commit() ) {
	    					$this->addMessage($this->message->getValue(C_DB_PROCESS_MODE_UPDATE)); // 성공시 출력 메시지.
	    				}
	    			} else {
	    				throw new Exception($this->db->getErrMsg());	    				
	    			}
//     			} else {
//     				throw new Exception($this->db->getErrMsg());    			
//     			}    		
    		} catch (Exception $e) {
    			$this->addErrMessage($e->getMessage());
    		}
    		$this->printXML(C_DB_PROCESS_MODE_PROC);
    		    		
    	} else {
			parent::save($argus);
    	}
    }
        
    /**
     * code를 array화한다.
     */
    public function getCodeData() {
    	// CODE DATA 정의
//     	$this->addCodeData("USER_LEVEL", self::$CODE_USER_LEVEL);
//     	$this->addCodeData("SEX"       , self::$CODE_SEX       );
//     	$this->addCodeData("STATE"     , self::$CODE_USER_STATE);
//     	$this->addCodeData("EMAIL_YN"  , self::$CODE_YN    );
    }           
}
if ( DEBUG ) {
	$test = new Member();
		
	/* test */
	$argus = array();
	/* register */
	$argus[user_name ] = "테스트";
	$argus[user_email] = "test01";
	$argus[user_level] = "1";
	$argus[passwd    ] = "1";
	$argus[state     ] = "U";
// 	$test->setTableName(TBL_MEMBER);
	$test->register($argus);

	/* dupcheck */
// 	$argus[p_user_id] = "admin";
// 	$test->checkDupId($argus);

	/* get */
// 	$argus[p_user_no] = "19";
// 	$test->get($argus);

	/* update */
// 	$argus[user_no  	 ] = "19";
// 	$argus[user_name	 ] = "김개똥";
// 	$argus[passwd   	 ] = "1";
// 	$argus[passwd_hint	 ] = "passwd_hint 1";
// 	$argus[passwd_correct] = "passwd_correct 1";
// 	$test->update($argus);
}
?>