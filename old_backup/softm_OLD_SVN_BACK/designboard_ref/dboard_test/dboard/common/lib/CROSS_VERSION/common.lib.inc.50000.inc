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