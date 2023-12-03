<?
/*
* include 되었는지를 검사
**/
if( defined("_dboard_db_connec_included") ) return;
    define ("_dboard_db_connec_included", true);

class DBConnection {
    var $serverNm = ""; // 데이터 베이스 서버 주소 ( ex : www.mydatabase.com:3306 )
    var $dbNm     = ""; // 데이터 베이스 명
    var $user     = ""; // 데이터 베이스 사용자명
    var $passWord = ""; // 데이터 베이스 비밀번호
    var $dirverNm = ""; // 데이터 베이스 드라이버 명
    var $connect  = ""; // 데이터 베이스 연결 링크

    function DBConnection($serverNm, $dbNm, $user, $passWord, $dirverNm ) {
        $this->serverNm = $serverNm;
        $this->dbNm     = $dbNm    ;
        $this->user     = $user    ;
        $this->passWord = $passWord;
        $this->dirverNm = $dirverNm;
    }

    function mysqlConnect() {
        $this->connect=@mysql_connect($this->serverNm, $this->user, $this->passWord) or
                       MessageExit("D", mysql_errno(),mysql_error());
        if ( DBOARD_DB_SET_ENCODING ) {
            @mysql_query("set names euckr;",$this->connect);
//        } else {
//            @mysql_query("set names euckr;",$this->connect);
        }
        //simpleSQLExecute("set euckr;");
        @mysql_select_db($this->dbNm, $this->connect) or MessageExit("D", mysql_errno(),mysql_error());
        //mysql_error() . " / " . mysql_errno()
    }

    function mysqlConnect1() {
        $this->connect=@mysql_connect($this->serverNm, $this->user, $this->passWord);
        if ( DBOARD_DB_SET_ENCODING ) {
        	@mysql_query("set names euckr;",$this->connect);
        }
        //simpleSQLExecute("set euckr;");
        //or
        if ( $this->connect ) {
        @mysql_select_db($this->dbNm, $this->connect);
        }
    }

    function mysqlConnect2() {
        $this->connect=@mysql_connect($this->serverNm, $this->user, $this->passWord);
        //simpleSQLExecute("set euckr;");
        if ( mysql_errno() ) {
        	if ( DBOARD_DB_SET_ENCODING ) {
	        	@mysql_query("set names euckr;",$this->connect);
        	}
            return false;
        } else {
            @mysql_query("set names euckr;",$this->connect);
            return true;
        }
    }

    function mysqlDisConnect($connect) {
        @mysql_close($connect);
    }

    function oracleConnect  () {;} // ORACLE   연결
    function informixConnect() {;} // INFORMIX 연결
    function mssqlConnect   () {;} // MSSQL    연결

    function getServerNm() { return $this->serverNm ; } // 데이터 베이스 서버주소  반환
    function getDbNm    () { return $this->dbNm     ; } // 데이터 베이스 명        반환
    function getUser    () { return $this->user     ; } // 데이터 베이스 사용자명  반환
    function getPassWord() { return $this->passWord ; } // 데이터 베이스 비밀번호  반환
    function getConnect () { return $this->connect  ; } // 데이터 베이스 연결 링크 반환
}

function initDBConnection ($serverNm='', $dbNm='', $user='', $passWord='', $driver='' ) {
    global  $sysInfor, $isconnected;
    $serverNm   = ( !$serverNm ) ? $sysInfor["host_nm" ] : $serverNm;
    $dbNm       = ( !$dbNm     ) ? $sysInfor["db_nm"   ] : $dbNm    ;
    $user       = ( !$user     ) ? $sysInfor["id"      ] : $user    ;
    $passWord   = ( !$passWord ) ? $sysInfor["password"] : $passWord;
    $driver     = ( !$driver   ) ? $sysInfor["driver"  ] : $driver  ;
    $_db = new DBConnection($serverNm, $dbNm, $user, $passWord, $driver);
    if ( $driver == "MYSQL" ) { $_db->mysqlConnect(); }
    else {
        MessageExit("P", "0001"); // 드라이버명이 지정되지 않음
    }
    /* 연결 객체를 전역 변수에 저장 */
    $_db->getConnect ();
    return $_db; // DBConnection 반환
}

function closeDBConnection ($driver="") {
    global $db, $sysInfor, $isconnected;
    if ( !$driver ) { $driver = $sysInfor["driver"]; }
    if ( $driver == "MYSQL" && $db ) { $db->mysqlDisConnect($db->connect); }
    $db='';
    unset($db);
}
?>