<?
putenv("NLS_LANG=KOREAN_KOREA.UTF8");
class DataBase {
    private $serverNm = ""; // 데이터 베이스 서버 주소 ( ex : www.mydatabase.com:3306 )
    private $dbNm     = ""; // 데이터 베이스 명
    private $user     = ""; // 데이터 베이스 사용자명
    private $passWord = ""; // 데이터 베이스 비밀번호
    private $driver   = ""; // 데이터 베이스 드라이버 명
    private $connect  = ""; // 데이터 베이스 연결 링크
    private $lastSql   = ""; // 마지막 실행된 sql문장
    private $ociExecuteMode = OCI_COMMIT_ON_SUCCESS; // 실행모드 ( USING ORACLE ) OCI_COMMIT_ON_SUCCESS ( auto commit ) / OCI_DEFAULT ( must commit )

    /**
     * @var boolean
     */
    private $autoCommit = true;

    function getServerNm() { return $this->serverNm ; } // 데이터 베이스 서버주소  반환
    function getDbNm    () { return $this->dbNm     ; } // 데이터 베이스 명        반환
    function getUser    () { return $this->user     ; } // 데이터 베이스 사용자명  반환
    function getPassWord() { return $this->passWord ; } // 데이터 베이스 비밀번호  반환
///opt/tk/core/web/modinstall
    function DataBase ($info=array()) {
        //var_dump($info);
        //echo $info['driver'] . '<BR>';
        $driver = $info['driver']?$info['driver']:(defined('DB_KIND')&&DB_KIND?DB_KIND:'');
        //echo $driver . '<BR>';
        if ( !$driver ) {
            echo ('DB Driver Unspecified');
        } else {
            if ( $driver == 'ORACLE' ) {
                $this->serverNm   = ( !$info['serverNm'] ) ? '//ip:1521/WDNS' : $info['serverNm'];
                $this->dbNm       = ( !$info['dbNm'    ] ) ? 'WDNS'	: $info['dbNm'    ] ;
                $this->user       = ( !$info['user'    ] ) ? 'USERID'	: $info['user'    ] ;
                $this->passWord   = ( !$info['passWord'] ) ? 'USERPASS'	: $info['passWord'] ;
                $this->driver     = ( !$driver           ) ? 'ORACLE'   : $driver           ;
            } else if ( $driver == 'MYSQL' ) {
                $this->serverNm   = ( !$info['serverNm'] ) ? '127.0.0.1': $info['serverNm'] ;
                $this->dbNm       = ( !$info['dbNm'    ] ) ? 'framework'       : $info['dbNm'    ] ;
                $this->user       = ( !$info['user'    ] ) ? 'root'     : $info['user'    ] ;
                $this->passWord   = ( !$info['passWord'] ) ? '1'        : $info['passWord'] ;
                $this->driver     = ( !$driver           ) ? 'MYSQL'    : $driver           ;

//                 $this->serverNm   = ( !$info['serverNm'] ) ? 'localhost': $info['serverNm'] ;
//                 $this->dbNm       = ( !$info['dbNm'    ] ) ? 'kjtnet'   : $info['dbNm'    ] ;
//                 $this->user       = ( !$info['user'    ] ) ? 'kjtnet'   : $info['user'    ] ;
//                 $this->passWord   = ( !$info['passWord'] ) ? 'kjtnet99' : $info['passWord'] ;
//                 $this->driver     = ( !$driver           ) ? 'MYSQL'    : $driver           ;
            }

            //echo "\n" . 'driver : ' . $driver . "\n";
        }
    }
    function getConnect () {
        if     ( $this->driver == "MYSQL"  ) { $this->mysqlConnect (); }
        else if( $this->driver == "ORACLE" ) { $this->oracleConnect(); }
        else {
            echo ('DB Driver Unspecified');
        }
    }

    function release () {
        if      ( $this->driver == "MYSQL"  ) { $this->mysqlDisConnect (); }
        else if ( $this->driver == "ORACLE" ) { $this->oracleDisConnect(); }
    }

    function mysqlConnect() {
        $this->connect=mysql_connect($this->serverNm, $this->user, $this->passWord) or die (mysql_error());
        @mysql_select_db($this->dbNm, $this->connect) or die (mysql_error());
        //서버
        //mysql_query("set character_set_database = utf8;");
        //mysql_query("set names utf8;");

        //mysql_query("set character_set_database = utf8;");
        if ( SERVER_GUBUN == '2' ) { // 운영
            mysql_query("set names utf8;");
        }
        //mysql_query("set names utf8;");
        //mysql_error() . " / " . mysql_errno()
    }

    function mysqlConnect1() {
        $this->connect=@mysql_connect($this->serverNm, $this->user, $this->passWord);
        //or
        if ( $this->connect ) {
        @mysql_select_db($this->dbNm, $this->connect);
        }
    }

    function mysqlConnect2() {
        $this->connect=@mysql_connect($this->serverNm, $this->user, $this->passWord);
        if ( mysql_errno() ) {
            return false;
        } else {
            return true;
        }
    }

    function mysqlDisConnect() {
        @mysql_close($this->connect);
    }

    function oracleConnect  () { // ORACLE   연결
	//echo $this->user . "<br>";
	//echo $this->passWord . "<br>";
	//echo $this->serverNm . "<br>";
        $this->connect=oci_connect($this->user, $this->passWord, $this->serverNm ) or die("Can not connect to DB." );

        $error = oci_error($this->connect);

        if(!$this->connect) {
            $error = @oci_error($this->connect);
        }

        if ($error["code"] != 1403 && $error["code"] != 0) {
            echo ('Connection Error');
            return false;
        } else {
            return true;
        }
    }

    function oracleDisConnect() {
        oci_close($this->connect);
    }

    function getErrNo($stmt=0) {
        $errno = 0;
        if     ( $this->driver == "MYSQL"  ) { $errno = mysql_errno   (); }
        else if( $this->driver == "ORACLE" ) { $errno = Ora_ErrorCode ($stmt); }
        return $errno;
    }

    function getErrMsg($stmt=0) {
        $errmsg = "";
        if     ( $this->driver == "MYSQL"  ) { $errmsg = mysql_error(); }
        else if( $this->driver == "ORACLE" ) { $errmsg = Ora_Error  ($stmt); }
        return $errmsg;
    }
    function getLastSql() {
        return $this->lastSql;
    }

    function getAffectedRows() {
        if ( $this->driver == 'MYSQL' ) {
            return mysql_affected_rows();
        }
    }

    function getNumRows($stmt) {
        if ( $this->driver == 'MYSQL' ) {
            return mysql_num_rows($stmt);
        }
    }

    function getInsertId($field="") {
        if ( $this->driver == 'MYSQL' ) {
            return mysql_insert_id($this->connect);
        } else if ( $this->driver == 'ORACLE' ) {
            //echo "SELECT " .$field .".NEXTVAL FROM DUAL ";
            //echo 'ss: '. ($this->get("SELECT " .$field .".NEXTVAL id FROM DUAL ")->id).'<BR>';
            $r = $this->get("SELECT " .$field .".NEXTVAL id FROM DUAL ");
            //var_dump($r);
            $insertId = $r->ID;
            echo '$insertId : ' . $insertId . "<BR>";
            return $insertId;
        }
    }


    function multiRowSQLQuery($sql, $msg_yn=false, $driver='') {
        $this->lastSql = $sql;
        $driver = ( !$driver ) ? $this->driver: $driver;
        if ( $driver == 'MYSQL' ) {
            $_stmt  = mysql_query ($sql,$this->connect) or ( $rtn = false or ( $msg_yn and die(mysql_error())) );
        } else if ( $driver == 'ORACLE' ) {

            $_stmt = oci_parse($this->connect,$sql);
            if(!$_stmt) {
                $error = @oci_error($_stmt);
            }
            else {
                oci_execute($_stmt,$this->ociExecuteMode);
                $error = @oci_error($_stmt);
            }
            if ($error["code"] != 1403 && $error["code"] != 0) {
                Message("D", $error["code"], $error["message"]);
            }

        }
    //    echo " _stmt: " . $_stmt;
        return $_stmt;
    }

    function multiRowFetch  ($stmt, $mode='', $driver='') {
    	$_result = null;
		if ( $stmt ) {
	        $driver = ( !$driver ) ? $this->driver: $driver;

	        if ( $driver == 'MYSQL' ) {
	            $mode = ( !$mode ) ? MYSQL_ASSOC: $mode;
	            //$_result = mysql_fetch_array($stmt, $mode );
	            $_result = mysql_fetch_object($stmt) ;

	            if ( !$_result ) { mysql_free_result($stmt); }
	        } else if ( $driver == 'ORACLE' ) {
	            $mode = ( !$mode ) ? OCI_ASSOC: $mode;
	            $_result = oci_fetch_object ( $stmt );
	            if ( !$_result ) { oci_free_statement( $stmt ); }
	        }
		}
        return $_result;
    }

    function multiObjectFetch  ($stmt, $mode='', $driver='') {

        $driver = ( !$driver ) ? $this->driver: $driver;

        if ( $driver == 'MYSQL' ) {
            $mode = ( !$mode ) ? MYSQL_ASSOC: $mode;
            //$_result = mysql_fetch_array($stmt, $mode );
            $_result = mysql_fetch_object($stmt);

            if ( !$_result ) { mysql_free_result($stmt); }
        } else if ( $driver == 'ORACLE' ) {
            $mode = ( !$mode ) ? OCI_ASSOC: $mode;
            OCIFetchInto ( $stmt, $_result, $mode );
            if ( !$_result ) { oci_free_statement( $stmt ); }
        }
        return $_result;
    }

    /**
     * @param string $sql
     * @param string $fech_mode [object : stdClass,array : 배열]
     * @param string $mode
     * @param string $driver
     * @return object
     */
    function get($sql, $fech_mode='', $mode='', $driver='') {
        return $this->singleRowSQLQuery($sql,false,$mode,$fech_mode,$driver);
    }

    function singleRowSQLQuery($sql, $msg_yn=false,  $mode='', $fech_mode='',$driver='') {
        $driver = ( !$driver ) ? $this->driver: $driver;
        $this->lastSql = $sql;
        if ( $driver == 'MYSQL' ) {
        	$rtn = true;
            $mode = ( !$mode ) ? MYSQL_ASSOC: $mode;
            $fech_mode = ( !$fech_mode) ? 'object': $fech_mode; // object, array
            //echo '<BR>' . $sql . ' LIMIT 1<BR>';

            try {
            	//$stmt   = mysql_query ($sql . ' LIMIT 1',$this->connect) or ( $rtn = false or ( $msg_yn and die(mysql_error())) );
//				echo $sql;
            	$stmt   = mysql_query($sql . ' LIMIT 1',$this->connect);
            	if ( $rtn ) {
            		if ( $fech_mode == 'object') {
            			$_result = mysql_fetch_object($stmt);
            		} else if ( $fech_mode == 'array') {
            			$_result = mysql_fetch_array($stmt, $mode );
            		}
            	} else {
            		$_result = array();
            	}
            	if ( $this->getErrMsg() )  throw new Exception($this->getErrMsg());
            } catch (Exception $e) {
            	// 	    		echo  $this->db->getErrMsg();
            	// 	    		throw new Exception($e->getMessage());
            	trigger_error($e->getMessage());
            }

        } else if ( $driver == 'ORACLE' ) {

            $mode = ( !$mode ) ? OCI_ASSOC: $mode;

            $stmt = oci_parse($this->connect,$sql);
            if(!$stmt) {
                $error = @oci_error($stmt);
            }
            else {
                @oci_execute($stmt,$this->ociExecuteMode);
                $error = @oci_error($stmt);
            }
            if ($error["code"] != 1403 && $error["code"] != 0) {
                echo($error["message"]);
            }

            $_result = oci_fetch_object ( $stmt );
            oci_free_statement( $stmt );
        }
        return $_result;
    }

    /**
     * 함수명: getOne
     * 설명  : 쿼리를 실행합니다.
     * 예)  simpleSQLQuery("SELECT MAX(필드명) FROM  TABLE명;")
     *   --> 하나의 열과 행을 갖는 자료에 대해서만 사용하였습니다.
     * Argus : sql   : ResultSet을 반환하기위한 SQL문장
     **/
    function getOne($sql,$driver='') {
    	return $this->simpleSQLQuery($sql,$driver);
    }

    /**
    * 함수명: simpleSQLQuery
    * 설명  : 쿼리를 실행합니다.
    * 예)  simpleSQLQuery("SELECT MAX(필드명) FROM  TABLE명;")
    *   --> 하나의 열과 행을 갖는 자료에 대해서만 사용하였습니다.
    * Argus : sql   : ResultSet을 반환하기위한 SQL문장
    **/
    private function simpleSQLQuery($sql,$driver='') {

        $driver = ( !$driver ) ? $this->driver: $driver;
        $this->lastSql = $sql;
    //    $sql  = "select count(id) from VENDOR_AGENT where id = '1' and pw = '1'";
        $driver = ( !$driver ) ? $this->driver: $driver;
        $_result = null;
        if ( $driver == 'MYSQL' ) {
            //$stmt   = mysql_query($sql . ' LIMIT 1',$this->connect) or die(mysql_error());
            try {
	            $stmt   = mysql_query($sql . ' LIMIT 1',$this->connect);
	            if ( $stmt ) {
		            $result = mysql_fetch_array($stmt);
		            mysql_free_result($stmt);
		            $_result = $result[0];
	            }
	            if ( $this->getErrMsg() )  throw new Exception($this->getErrMsg());
	    	} catch (Exception $e) {
// 	    		echo  $this->db->getErrMsg();
// 	    		throw new Exception($e->getMessage());
//	    		trigger_error($e->getMessage());
            }
        } else if ( $driver == 'ORACLE' ) {
            $stmt = oci_parse($this->connect,$sql);
            if(!$stmt) {
                $error = @oci_error($stmt);
            }
            else {
                @oci_execute($stmt,$this->ociExecuteMode);
                $error = @oci_error($stmt);
            }

            if ($error["code"] != 1403 && $error["code"] != 0) {
                echo($error["message"]);
            }

            OCIFetchInto ( $stmt, $result);
            oci_free_statement( $stmt );
            $_result = $result[0];
        }
        return $_result;
    }

    function exec($sql, $msg_yn=false, $driver='') {
        return $this->simpleSQLExecute($sql, $msg_yn, $driver);
    }

    /*
    * 함수명: simpleSQLExecute
    * 설명  : 쿼리를 실행합니다.
    * 예)  simpleSQLExecute("INSERT INTO TABLE.....);
    * Argus : sql   : 실행문 INSERT , UPDATE, DELETE 문장
    **/
    function simpleSQLExecute($sql, $msg_yn=false, $driver='') {
        $driver = ( !$driver ) ? $this->driver: $driver;
        //echo '<BR>driver : ' .$driver ;
        $this->lastSql = $sql;

        $rtn = true;
        $error = array();
        if ( $driver == 'MYSQL' ) {
//         	var_dump($sql);
//         	echo $sql ."<BR><BR>";
        	$sqls = preg_split("/;\r\n/",$sql);
//         	var_dump($sqls);
        	//exit;
        	foreach ($sqls as $idx => $sql) {
//         		echo $sqls[$idx] . "<BR>";
        		$stmt = mysql_query($sqls[$idx],$this->connect) or ( $rtn = false or ( $msg_yn and die(mysql_error())) );
        	}
            //$stmt = mysql_query($sql,$this->connect);
            //$error["code"   ] = mysql_errno($this->connect);
            //$error["message"] = mysql_error($this->connect);
            //echo $rtn;
            return $rtn;
        } else if ( $driver == 'ORACLE' ) {
            $stmt = oci_parse($this->connect,$sql);
            if(!$stmt) {
                $error = @oci_error($stmt);
            } else {
//OCI_COMMIT_ON_SUCCESS
//echo '$this->ociExecuteMode: ' . $this->ociExecuteMode . '<br>';
                @oci_execute($stmt,$this->ociExecuteMode);
                $error = @oci_error($stmt);
            }
            if ($error["code"] != 1403 && $error["code"] != 0) {
                //echo($error["message"]);
            }
            oci_free_statement( $stmt );
        }
        return $error;
    }

    /*
    * 함수명: isTable
    * 설명  : 게시판의 생성유무 검사
    * 예)  istable("테이블명", "데이터베이스명");
    * Argus : $tb_name  : 테이블명
    * Argus : $dbname   : 데이터베이스명
    * Argus : $driver   : 드라이버명
    **/
    function isTable($tbName, $dbName='', $driver='') {

        $dbName = ( !$dbName ) ? $this->dbNm  : $dbName;
        $driver = ( !$driver ) ? $this->driver: $driver;

        $schInfo = explode ('.', $tbName);
        $dbName = ( sizeof($schInfo) == 2 )?$schInfo[0]:$dbName;
        $tbName = ( sizeof($schInfo) == 2 )?$schInfo[1]:$tbName;

      //echo"dbName / driver / tbName : ". $dbName . '/' . $driver . '/' . $tbName . '<BR>';

        if ( $driver == 'MYSQL' ) {
    //      $result = mysql_list_tables($dbname) or Message("D", mysql_errno(), 2, mysql_error());
            $result = mysql_list_tables($dbName);
            $i  =0;
            $cnt=0;
            while ($i < mysql_num_rows($result)) {
    //          echo "$tbName / " . mysql_tablename ($result, $i) . "<BR>";
                if(strtoupper ($tbName)==strtoupper (mysql_tablename ($result, $i))) {
                    $cnt++;
                    break;
                }
               $i++;
            }
        } else if ( $driver == 'ORACLE' ) {
            echo "SELECT COUNT(*) FROM USER_TABLES WHERE TABLE_NAME = '" . $tbName . "'";
            $cnt = $this->simpleSQLQuery("SELECT COUNT(*) FROM USER_TABLES WHERE TABLE_NAME = '" . $tbName . "'");
        }
        return $cnt;
    }

    function mysqlCaseStrByArray($fieldName,$dataArray) {
        //echo 'gettype : ' . gettype($dataArray);
        $case_str = 'CASE ';
        if ( gettype($dataArray) == 'array' ) {
            while (list ($key, $val) = each ($dataArray)) {
                //echo 'key : ' . $key . 'val : ' . $val. '<BR>';
                $case_str .= "WHEN " . $fieldName . "='" . $key. "' THEN '" . $val . "' ";
            }
        } else if ( gettype($dataArray) == 'resource' ) {
            while ( $rs = $this->multiRowFetch  ($dataArray, false, MYSQL_NUM) ) {
                //echo 'key : ' . $rs[0] . 'val : ' . $rs[1] . '<BR>';
                $case_str .= "WHEN " . $fieldName . "='" . $rs[0]. "' THEN '" . $rs[1] . "' ";
            }
        }
        $case_str .= ' END';
        return $case_str;
    }

    function startTransaction() {
        $rtn = true;
        if ( $this->driver == 'MYSQL' ) {
            // 트랙잭션을 시작한다.
            $rtn = @mysql_query("SET AUTOCOMMIT=0", $this->connect);
            if ( $rtn ) {
                $rtn = @mysql_query("BEGIN", $this->connect);
            } else {
                $rtn = false;
            }
            //echo '$starttransaction : ' . $rtn . '<BR>';
        } else if ( $this->driver == 'ORACLE' ) {
            //$stmt = oci_parse($this->connect,"BEGIN");
            //@oci_execute($stmt);
            $this->ociExecuteMode = OCI_DEFAULT; // 실행모드 ( USING ORACLE )
        }
        return $rtn;
    }

    /**
     * @return void
     * 데이터베이스 커밋모드를 설정합니다.
     */
    public function setAutoCommit($autoCommit) {
    	$this->autoCommit = (boolean) $autoCommit;
    	if ( !$this->autoCommit ) $this->startTransaction();
    }

    /**
     * @return boolean
     * 데이터베이스 커밋모드를 반환합니다.
     */
    public function getAutoCommit() {
    	return $this->autoCommit;
    }

    function commit() {
        if ( $this->driver == 'MYSQL' ) {
            $rtn = @mysql_query("COMMIT", $this->connect);
            //echo '$commit : ' . $rtn . '<BR>';
        } else if ( $this->driver == 'ORACLE' ) {
            $rtn = @oci_commit($this->connect);
        }
        return $rtn;
    }

    function rollback() {
        if ( $this->driver == 'MYSQL' ) {
            $rtn = @mysql_query("ROLLBACK", $this->connect);
            //echo '$rollback : ' . $rtn . '<BR>';
        } else if ( $this->driver == 'ORACLE' ) {
            $rtn = @oci_rollback($this->connect);
        }
        return $rtn;
    }

    function insert($t, $s) {
        $sql1 = '';
        $sql2 = '';
        $idx = 0;
        while (list($k, $v) = each($s)) {
            $sql1 .= ($idx>0?', ':'').$k;
            $sql2 .= ($idx>0?', ':'').$v;
            //echo "$k => $v\n";
            $idx++;
        }
        //echo 'INSERT INTO ' . $t . ' (' . $sql1 . ') VALUES ( ' . $sql2 . ')';
        $sql = 'INSERT INTO ' . $t . ' (' . $sql1 . ') VALUES ( ' . $sql2 . ')';
        $this->lastSql = $sql;
        return $this->simpleSQLExecute($sql);
    }

    function update($t, $s,$w) {
        $sql1 = '';
        $sql2 = '';
        $idx = 0;
        while (list($k, $v) = each($s)) {
            $sql1 .= ($idx>0?', ':'').$k . ' = ' . $v;
            //echo "$k => $v\n";
            $idx++;
        }
        //echo ('UPDATE ' . $t . ' SET ' . $sql1 . ($w ? ( ' WHERE ' . $w . '' ):'') );
        $sql = 'UPDATE ' . $t . ' SET ' . $sql1 . ($w ? ( ' WHERE ' . $w . '' ):'');
        $this->lastSql = $sql;
        return $this->simpleSQLExecute($sql);
    }

    function delete($t,$w) {
        return $this->simpleSQLExecute('DELETE FROM ' . $t . ($w ? ( ' WHERE ' . $w . '' ):'') );
    }

    function count($t,$w) {
        return $this->simpleSQLQuery('SELECT COUNT(*) FROM ' . $t . ($w ? ( ' WHERE ' . $w . '' ):'') );
    }

    function quote($value) {
        if (is_string($value)) {
            if ($value === '') {
                return "''";
            }
            return "'" . mysql_escape_string($value) . "'";
        } else if (is_integer($value) || is_float($value)) {
            return (string)$value;
        } else if (is_bool($value)) {
            return $value ? '1' : '0';
        } else if (is_null($value)) {
            return 'NULL';
        } else if (is_array($value) || is_object($value) || is_resource($value)) {
            trigger_error("Invalid datatype passed to DataBase::quote()");
        }
    }

}
?>