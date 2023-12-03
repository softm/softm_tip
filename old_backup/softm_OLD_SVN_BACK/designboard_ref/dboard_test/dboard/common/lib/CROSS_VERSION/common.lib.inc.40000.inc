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
        if (version_compare(PHP_VERSION, '5.0.0', '<')) { // php4
            /*php4*/
            @mysql_query($sql,$db->connect) or MessageExit("D", mysql_errno(), mysql_error());
        } else {
        }
    }
    return true;
}
?>