<B>database.class.lib test ( oracle & mysql )</B><BR>
<pre>
# mysql table
CREATE TABLE `tbl_test` (
    `k1` INT(11) NOT NULL AUTO_INCREMENT,
    `f1` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `f2` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `f3` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `f4` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `f5` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `f6` DATE NULL DEFAULT NULL,
    PRIMARY KEY (`k1`)
)
COMMENT='test table'
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT

# oracle table
CREATE TABLE tbl_test (
    f1 VARCHAR(255) DEFAULT NULL ,
    f2 VARCHAR(255) DEFAULT NULL ,
    f3 VARCHAR(255) DEFAULT NULL ,
    f4 VARCHAR(255) DEFAULT NULL ,
    f5 VARCHAR(255) DEFAULT NULL ,
    f6 DATE DEFAULT NULL
)
</pre>
<!--------- test_mysql_oracle.php --------->
<?
/*
$conn = OCILogon("EHANDAX", "EHANDAX", '//58.120.227.201:1521/WDNS');

$query = 'select table_name from user_tables';

$stid = OCIParse($conn, $query);
OCIExecute($stid, OCI_DEFAULT);
 while ($succ = OCIFetchInto($stid, $row)) {
    foreach ($row as $item) {
      echo $item." ";
    }
    echo "<br>\n";
 }

 OCILogoff($conn);

*/
putenv("NLS_LANG=KOREAN_KOREA.UTF8");
define('DB_KIND','ORACLE'); // db kind
require_once 'service/common/lib/database.class.lib';
$info['driver'] = 'ORACLE';
/*
CREATE TABLE tbl_test (
    f1 VARCHAR(255) DEFAULT NULL ,
    f2 VARCHAR(255) DEFAULT NULL ,
    f3 VARCHAR(255) DEFAULT NULL ,
    f4 VARCHAR(255) DEFAULT NULL ,
    f5 VARCHAR(255) DEFAULT NULL ,
    f6 DATE DEFAULT NULL
)
*/
//phpinfo();
$db = new DataBase ($info);
$db->getConnect();
//$db->startTransaction(); // active transaction mode
$rtn = $db->delete("tbl_test", '1=1');
echo ';x';

echo '<BR>------------- ------------- ------------- insert Failure------------- ------------- -------------<BR> ';
$savedata = array();
$savedata[f1] = '테스트.';
$rtn = $db->insert("tbl_test", $savedata);
if ( $rtn['code'] == 0 ) {
    echo 'Success!<BR>';
    $db->commit();
} else {
    echo 'Failure!<BR>';
    var_dump($rtn);
}

echo '<BR>------------- ------------- ------------- insert Success------------- ------------- -------------<BR> ';
$savedata[f1] = "'테스트.'";
$rtn = $db->insert("tbl_test", $savedata);
if ( $rtn['code'] == 0 ) {
    echo '<BR>Success!<BR>';
    $db->commit();
} else {
    echo '<BR>Failure!<BR>';
    var_dump($rtn);
}
echo '<BR>------------- ------------- ------------- select ------------- ------------- -------------<BR> ';
$sql = 'select * from tbl_test';
$stmt = $db->multiRowSQLQuery ($sql);
while ( $rs = $db->multiRowFetch  ($stmt) ) {
    foreach ($rs as $item) {
        echo $item." ";
        echo  iconv("EUC-KR","UTF-8",$item)." ";
    }
    echo "<br>\n";
}
$db->release();
?>