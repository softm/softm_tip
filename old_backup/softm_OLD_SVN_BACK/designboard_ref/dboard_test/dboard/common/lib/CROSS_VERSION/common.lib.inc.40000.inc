<?
/*
* �Լ���: simpleSQLExecute
* ����  : ������ �����մϴ�.
* ��)  simpleSQLExecute("INSERT INTO TABLE.....);
* Argus : sql   : ���๮ INSERT , UPDATE, DELETE ����
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