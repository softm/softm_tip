<?
/*
* 함수명: simpleSQLExecute
* 설명  : 쿼리를 실행합니다.
* 예)  simpleSQLExecute("INSERT INTO TABLE.....);
* Argus : sql   : 실행문 INSERT , UPDATE, DELETE 문장
**/
function simpleSQLExecute($sql, $driver='') {
    global $sysInfor, $db;
    $driver = ( !$driver ) ? $sysInfor["driver"]: $driver;
    if ( $driver == 'MYSQL' ) {
		try {
			$stmt   = mysql_query($sql,$db->connect);
			if ( mysql_errno() )
				MessageExit("D", mysql_errno(), mysql_error());
		} catch(Exception $e) {
			MessageExit("D", mysql_errno(), mysql_error());
		}
    }
    return true;
}
?>