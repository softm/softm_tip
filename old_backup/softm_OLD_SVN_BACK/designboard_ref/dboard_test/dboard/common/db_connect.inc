<?
/*
* include �Ǿ������� �˻�
**/
if( defined("_dboard_db_connec_included") ) return;
    define ("_dboard_db_connec_included", true);

class DBConnection {
    var $serverNm = ""; // ������ ���̽� ���� �ּ� ( ex : www.mydatabase.com:3306 )
    var $dbNm     = ""; // ������ ���̽� ��
    var $user     = ""; // ������ ���̽� ����ڸ�
    var $passWord = ""; // ������ ���̽� ��й�ȣ
    var $dirverNm = ""; // ������ ���̽� ����̹� ��
    var $connect  = ""; // ������ ���̽� ���� ��ũ

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

    function oracleConnect  () {;} // ORACLE   ����
    function informixConnect() {;} // INFORMIX ����
    function mssqlConnect   () {;} // MSSQL    ����

    function getServerNm() { return $this->serverNm ; } // ������ ���̽� �����ּ�  ��ȯ
    function getDbNm    () { return $this->dbNm     ; } // ������ ���̽� ��        ��ȯ
    function getUser    () { return $this->user     ; } // ������ ���̽� ����ڸ�  ��ȯ
    function getPassWord() { return $this->passWord ; } // ������ ���̽� ��й�ȣ  ��ȯ
    function getConnect () { return $this->connect  ; } // ������ ���̽� ���� ��ũ ��ȯ
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
        MessageExit("P", "0001"); // ����̹����� �������� ����
    }
    /* ���� ��ü�� ���� ������ ���� */
    $_db->getConnect ();
    return $_db; // DBConnection ��ȯ
}

function closeDBConnection ($driver="") {
    global $db, $sysInfor, $isconnected;
    if ( !$driver ) { $driver = $sysInfor["driver"]; }
    if ( $driver == "MYSQL" && $db ) { $db->mysqlDisConnect($db->connect); }
    $db='';
    unset($db);
}
?>