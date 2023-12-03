<?
@header ("P3P : CP=\"ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC\"");

/*
* include �Ǿ������� �˻�
**/
if( defined("_dlib_included") ) return;
    define ("_dlib_included", true);

$_dboard_ver         = 'dboard 3.44';
$_dboard_ver_str     = '3.44';
$_dboard_start_date  = '2003.08.26';
$_dboard_update_date = '2013.06.26';
$_dparam = false;

//error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE ( Notice�� ������ ��翡���� �������ض�~ )
@extract($HTTP_ENV_VARS   ); // ȯ�� ����
@extract($HTTP_GET_VARS   ); // Get  ����� Parameter ��
@extract($HTTP_POST_VARS  ); // Post ����� Parameter ��
@extract($HTTP_SERVER_VARS); // Server ����

/*
* �Լ���: _head
* ����  : ��� �κ� ���
* Argus : title  : document.title���� �����մϴ�.
*       : script : onLoad �̺�Ʈ�� ����� �ڹٽ�ũ��
**/
function _head ($title="",$script="") {
    global $baseDir;
    global $_dboard_ver, $_dboard_start_date, $_dboard_update_date;
    global $_dboard_header;
    global $_sessionStart;
    if ( !$_dboard_header ) {
        $_sessionStart = getMicroSecond();
	header("Content-type: text/html; charset=euc-kr");
        if ( strpos($exec, "_exec") === false ) {
            include $baseDir . "copyright.txt";
        }
	if ( $script ) $script = "onload='$script'";
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
</head>

<?
        $_dboard_header = true;
    }
}

/*
* �Լ���: footer
* ����  : �ϴ� �κ� ���
**/
function footer () {
    global $_sessionStart, $_sessionEnd, $table_width, $skin_copy_right;
    $_sessionEnd = getMicroSecond();
echo("
</body>
</html>
");
   logs ( "<!--\n���� �ð� : " . $_sessionStart . "\n", true);
   logs ( "\n���� �ð� : " . $_sessionEnd   . "\n", true);
   logs ( "\n���� �ð� : " . sprintf("%0.3f",getMicroSecond()-$_sessionStart) . "\n-->", true);
}

/*
* �Լ���: footer
* ����  : �ϴ� �κ� ���
**/
function _footer () {
echo("
</html>
");
}

/*
* �Լ���: _css
* ����  : style sheet
* Argus : dir : css ��θ�.
**/
function _css($dir='') {
    echo ( "<link rel=stylesheet href='" . $dir . "style.css' type='text/css'>\n" );
}

/*
* �Լ���: baseDir
* ������ ����� ��� ��θ� ���մϴ�.
**/
function baseDir () {
    global  $PHP_SELF;
    $_rtn = $PHP_SELF;
    // ���� ���� ��� ����

    $endP = strrpos($_rtn,'/') + 1;

    $_rtn = substr($_rtn, 0, $endP);

    return $_rtn;
}

/*
* �Լ���: setUpDir
* ��ġ ���丮�� ���մϴ�.
**/
function setUpDir () {
    global $HTTP_SERVER_VARS;
    // (_ _);
    // $_rtn = $HTTP_SERVER_VARS["SCRIPT_FILENAME"];
    $_rtn = $_SERVER["PATH_TRANSLATED"];
    $_rtn = str_replace("\\","/",$_rtn);
    $_rtn = str_replace("//","/",$_rtn);
    $endP = strrpos($_rtn,'/') + 1;
    $_rtn = substr($_rtn, 0, $endP);
    // echo '<font color="red">' . $_rtn . '</font><BR>';
    // echo phpinfo();
    return $_rtn;
}

function getUrlPath ($dir) {
    $endP  = strpos ($dir,'?'    );
    if ( $endP ) {
        $_tmp  = substr ($dir, 0, $endP );
    } else {
        $_tmp = $dir;
    }
    $endP = strrpos($_tmp,'/') + 1;
    $_rtn = substr($dir, 0, $endP);
    return $_rtn;
}

function getReqPageName ($dir='') {
    global $PHP_SELF;
    if ( $dir ) {
        $_tmp = $dir;
    } else {
        $_tmp = $PHP_SELF;
    }
    $endP  = strpos ($_tmp,'?'    );
    if ( $endP ) {
        $_tmp  = substr ($_tmp, 0, $endP );
        $starP = strrpos($_tmp,'/') + 1;
        $_tmp  = substr ($_tmp, $starP);
        $_rtn = substr($_tmp, 0, $endP);
    } else {
        $starP = strrpos($_tmp,'/') + 1;
        $_tmp  = substr ($_tmp, $starP);
        $_rtn = substr($_tmp, 0);
    }
    return $_rtn;

}

/*
* �Լ���: getUrlParamValue
* ����  : url�� ���Ե� �Ķ���Ͱ��� �����մϴ�.
* ��)  getUrlParamValue('http://localhost/dboard/dboard.php?id=defornet&exec=login', 'id')
* Argus : url   : html �ּ�
* Argus : nm    : url���� ���Ե� Parameter �̸�
**/
function getUrlParamValue($url, $nm) {
    $s   = strpos ($url,'&' . $nm . '=');
    if (!$s) {
        $s   = strpos ($url,'?' . $nm . '=');
    }
    $url = substr ($url,$s + 1 );
    $e   = strpos ($url,'&');

// echo '<BR>'.$nm . ' : s '  . $s . '<BR>';
// echo '<BR>'.$nm . ' : e '  . $e . '<BR>';

    if ( $s ) {
        if ( $e > 0 ) {
            $url = substr ($url,0,$e);
            $val = explode ('=',$url);
        } else {
            $val = explode ('=',$url);
        }
    }
    return $val[1];
}

/*
* �Լ���: redirectPage
* ����  : ������ �̵�
* ��)  redirectPage("http://www.yahoo.com");
* Argus : url : �ּ�
**/
function redirectPage($url) {
    if ( $url ) {
        if ( strtolower($url) == "back" ) {
            echo("<SCRIPT LANGAUGE='javascript'>history.back();</SCRIPT>");
        }
        else {
    		echo "\n<meta http-equiv=\"refresh\" content=\"0; url=$url\">";
        }
    }
}

/*
* �Լ���: formMove
* $params�� �Ѿ�� �Ķ���͸� ���� hidden������ ������ action�������� �����մϴ�.
* Argus : $formNm : �� �̸�
* Argus : $action : ������ URL
* Argus : $params : �Ķ����(�迭����)
**/
function formMove($formNm,$action, $params)
{
        if ( is_array ( $params ) ) {
            $key_name  = array_keys  ($params);
            $key_value = array_values($params);
        }
        $size = count($params);
        echo("<FORM method='post' name='$formNm' action='$action'>");
        for($i = 0 ;$i < $size;$i++) {
            echo("    <INPUT type='hidden' name='$key_name[$i]' value='$key_value[$i]'>");
        }
        echo "</FORM>";

        echo("\n<SCRIPT LANGUAGE='JavaScript'>\n<!--\n" ."document.".$formNm.".submit();\n//-->\n</SCRIPT>");
}

// from_path������ $to_path�� ��� ���
function relativeDir($from_path, $to_path) {
	$from_path = strtolower ($from_path);
	$to_path = strtolower ($to_path);

    $frm_su = substr_count($from_path, '/' );
    $to_su  = substr_count($to_path  , '/' );

    $max_su = 0;
    if      ( $frm_su > $to_su  ) $max_su = $frm_su;
    else if ( $to_su  > $frm_su ) $max_su = $to_su ;
    else $max_su = $to_su;
    $depth  = $to_su - $frm_su;
    $relDir ='';
    $f_pos=$pre_f_pos=0;
    $t_pos=$pre_t_pos=0;

    for ( $i=0; $i<=$max_su; $i++) {
        $f_pos = strpos ( $from_path, '/', $f_pos );
        $t_pos = strpos ( $to_path  , '/', $t_pos );

        if  ( substr ( $from_path, 0, $f_pos ) != substr ( $to_path, 0, $t_pos ) ) break;
        $frm_su--;
        $to_su--;
        $f_pos = $f_pos + 1;
        $t_pos = $t_pos + 1;
        $pre_f_pos = $f_pos;
        $pre_t_pos = $t_pos;
    }

    $from_path = substr ( $from_path, $pre_f_pos );
    $to_path   = substr ( $to_path  , $pre_t_pos );

    if ( $from_path != $to_path ) {
        for ( $i=0;$i<$to_su;$i++ ) $relDir .= '../';
        $relDir .= $from_path;
    } else {
            $relDir .= '';
    }
    return $relDir;
}

$setDir="";
$pwd   ="";
$config = file_exists( $baseDir . 'config.php' );
if ( $config ) {
    $sysInfor = getDsysInfor($baseDir); // config.php�κ��� �ý��� ���� �б�
}

/*
* �Լ���: getSysInfor
* Argus : baseDir  : ��� ���丮
* ����  : �ý��� ȯ�� ������ �о� �ɴϴ�.
**/
function getDsysInfor($baseDir) {
    global $config;
    global $DOCUMENT_ROOT;
    if ( $config ) {
        $f=@file($baseDir . "config.php");
        if (!$f) {
            include ("message.inc");
            head    (); // Header ���
            Message ('U', '0006',"" ); // ��ġ�� �Ϸ� ���� �ʾҽ��ϴ�.
            footer  ()               ; // Footer ���
        } else {
            $_sys_infor["driver"    ] = trim(str_replace("\n","",$f[1]));
            $_sys_infor["host_nm"   ] = trim(str_replace("\n","",$f[2]));
            $_sys_infor["db_nm"     ] = trim(str_replace("\n","",$f[3]));
            $_sys_infor["id"        ] = trim(str_replace("\n","",$f[4]));
            $_sys_infor["password"  ] = trim(str_replace("\n","",$f[5]));
            $_sys_infor["base_dir"  ] = trim(str_replace("\n","",$f[6]));
            $_sys_infor["setup_dir" ] = trim(str_replace("\n","",$f[7]));
            $_sys_infor["login_skin"] = trim(str_replace("\n","",$f[8]));
        }
    } else {
        logs ( $_sys_infor["base_dir"] . "<BR>", true );
    }
    return $_sys_infor;
}

if ( !ereg( '/setup.php$', $PHP_SELF) && $config ) {
// !ereg( '(/setup)+(.)*(.php)$', $PHP_SELF) && !ereg( '(admin.php)$', $PHP_SELF)
    session_save_path($baseDir . "data/session");
    session_set_cookie_params(0, '/');
    @session_cache_limiter('nocache, must_revalidate');
//  session_cache_limiter('nocache, must_revalidate'); // ĳ�� ���� ���ƶ�
    @session_cache_limiter('');

//  ĳ�� Ŭ���� Ÿ�� ����
//  session_cache_limiter('private');
//  $cache_limiter = session_cache_limiter();
//  session_cache_expire (10);
    @session_start();
}

// setup.php���� ����
/*
* �Լ���: unWritableDirError
* ����  : ���丮�� ���� ���¸� �˻��ؼ� �޽����� ����մϴ�.
**/
function unWritableDirError () {
    global $baseDir, $errMsgTable;
    $errNo = "";
    if      ( !is_writeable($baseDir . "data"        ) ) $errNo = "0007";
    else if ( !is_writeable($baseDir . "data/file"   ) ) $errNo = "0008";
    else if ( !is_writeable($baseDir . "data/poll"   ) ) $errNo = "0009";
    else if ( !is_writeable($baseDir . "data/session") ) $errNo = "0010";
    else if ( !is_writeable($baseDir . "data/html"   ) ) $errNo = "0011";
    else if ( !is_writeable($baseDir . "data/member" ) ||
              !is_writeable($baseDir . "data/member/character" ) ||
              !is_writeable($baseDir . "data/member/picture" ) ) $errNo = "0015";
    else if ( !is_writeable($baseDir . "files"       ) ) $errNo = "0016";

    if ( $errNo ) {
        $errMsg = $errMsgTable["U".$errNo];
        $err = new Message ("U", $errNo,$errMsg,"");
        include "message.php";
        return false;
    } else {
        return true;
    }
}

/*
* �Լ���: head
* ����  : ��� �κ� ���
* Argus : title  : document.title���� �����մϴ�.
*       : script : onLoad�̺�Ʈ�� ����� �ڹٽ�ũ��.
**/
function head ($title="",$script="") {
    global $_sessionStart;
    global $baseDir;
    global $exec   ;
    global $_dboard_ver, $_dboard_start_date, $_dboard_update_date;
    global $_dboard_header;

    if ( !$_dboard_header ) {
	$_sessionStart = getMicroSecond();
	header("Content-type: text/html; charset=euc-kr");
        if ( strpos($exec, "_exec") === false ) {
            include $baseDir . "copyright.txt";
        }
echo( "
<html>
<head>
<title>$title</title>
<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'>
");

echo("
</head>
<body text='#000000' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' onLoad='$script'>
");
        $_dboard_header = true;
    }
}

function singleRowSQLQuery($sql) {
    global $sysInfor, $db;
    if ( $sysInfor["driver"] == 'MYSQL' ) {
        $stmt   = mysql_query ($sql,$db->connect) or Message("D", mysql_errno(), mysql_error());
        $_result = mysql_fetch_array($stmt, MYSQL_ASSOC );
        mysql_free_result($stmt);
    }
    return $_result;
}

function multiRowSQLQuery($sql) {
    global $sysInfor, $db;
    if ( $sysInfor["driver"] == 'MYSQL' ) {
        $_stmt   = mysql_query ($sql,$db->connect) or Message("D", mysql_errno(), mysql_error());
    }
    return $_stmt;
}

function multiRowFetch  ($stmt) {
    global $sysInfor, $db;
    if ( $sysInfor["driver"] == 'MYSQL' ) {
        $_result = mysql_fetch_array($stmt, MYSQL_ASSOC );
        if ( !$_result ) { mysql_free_result($stmt); }
    }
    return $_result;
}
function getSQLErrorNo() {
    global $sysInfor;
    if ( $sysInfor["driver"] == 'MYSQL' ) {
        return mysql_errno();
    }
}

function getSQLError() {
    global $sysInfor;
    if ( $sysInfor["driver"] == 'MYSQL' ) {
        return mysql_error();
    }
}

function getAffectedRows() {
    global $sysInfor;
    if ( $sysInfor["driver"] == 'MYSQL' ) {
        return mysql_affected_rows();
    }
}


function getNumRows($stmt) {
    global $sysInfor;
    if ( $sysInfor["driver"] == 'MYSQL' ) {
        return mysql_num_rows($stmt);
    }
}


function getInsertId() {
    global $sysInfor;
    if ( $sysInfor["driver"] == 'MYSQL' ) {
        return mysql_insert_id();
    }
}

/*
* �Լ���: simpleSQLQuery
* ����  : ������ �����մϴ�.
* ��)  simpleSQLQuery("SELECT MAX(�ʵ��) FROM  TABLE��;")
*   --> �ϳ��� ���� ���� ���� �ڷῡ ���ؼ��� ����Ͽ����ϴ�.
* Argus : sql   : ResultSet�� ��ȯ�ϱ����� SQL����
**/
function simpleSQLQuery($sql,$driver='') {
    global $sysInfor, $db;
    $driver = ( !$driver ) ? $sysInfor["driver"]: $driver;
    if ( $driver == 'MYSQL' ) {
        $stmt   = mysql_query($sql,$db->connect) or Message("D", mysql_errno(), mysql_error());
        $result = mysql_fetch_array($stmt);
        mysql_free_result($stmt);
        $_result = $result[0];
    }
    return $_result;
}

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
    //echo $sql . "<BR>";
        //mysql_query("set utf8 collate utf8_general_ci;",$db->connect);
        //mysql_query("set euckr;");
        $stmt   = mysql_query($sql,$db->connect) or Message("D", mysql_errno(), mysql_error());
    }
    return true;
}

/*
* �Լ���: isTable
* ����  : �Խ����� �������� �˻�
* ��)  istable("���̺���", "�����ͺ��̽���");
* Argus : $tb_name  : ���̺���
* Argus : $dbname   : �����ͺ��̽���
* Argus : $driver   : ����̹���
**/
function isTable($tbName, $dbName='', $driver='') {
    global $sysInfor;
    $dbName = ( !$dbName ) ? $sysInfor["db_nm"] : $dbName;
    $driver = ( !$driver ) ? $sysInfor["driver"]: $driver;
//  echo"Ž11". $sysInfor["driver"] . '/' . $sysInfor["db_nm"];
    if ( $driver == 'MYSQL' ) {
//      $result = mysql_list_tables($dbname) or Message("D", mysql_errno(), 2, mysql_error());
        $result = mysql_list_tables($dbName);
        $i  =0;
        $cnt=0;
        while ($i < mysql_num_rows($result)) {
//          echo "$tbName / " . mysql_tablename ($result, $i) . "<BR>";
            if($tbName==mysql_tablename ($result, $i)) {
                $cnt++;
                break;
            }
           $i++;
        }
    }
    return $cnt;
}


/*
* �Լ���: getYearToMicro
* ����  : ���� ��+��+��+��+��+��+����ũ���� ����
          ���ڿ� ���·� �ٿ��� ��ȯ�մϴ�.
**/
function getYearToMicro() {
    $t_time = date("Y").date("m").date("d").date("H").date("i").date("s");
//    return $t_time.substr(getMicroTime(),2);
    $t_time = substr($t_time . getMicroTime(), 0, 18);
    return $t_time;
}
/*
* �Լ���: getYearToSecond
* ����  : ���� ��+��+��+��+��+�� ����
          ���ڿ� ���·� �ٿ��� ��ȯ�մϴ�.
**/
function getYearToSecond() {
    $t_time = date("Y").date("m").date("d").date("H").date("i").date("s");
    return $t_time;
}

/*
* �Լ���: getYearToDay
* ����  : ���� ��+��+����
          ���ڿ� ���·� �ٿ��� ��ȯ�մϴ�.
**/
function getYearToDay() {
    $t_time = date("Y").date("m").date("d");
    return $t_time;
}

/*
* �Լ���: getDateAdd
* ����  : ��¥�� Ư�� �ʵ带 ���� String�� ��ȯ
* Argus : $datetimestamps : ��¥ ( 20030402121045 )
*       : $field          : "YEAR"  ,"MONTH" ,"DAY"  ,"HOUR"  ,"MINUTE","SECOND"
*       : $addVal         : ���ϰų� ����.
**/
function getDateAdd ($datetimestamps, $field='', $addVal='' ) {
    $_rtn = '';
    $year    =  (int) substr ($datetimestamps, 0 , 4 );
    $month   =  (int) substr ($datetimestamps, 4 , 2 );
    $day     =  (int) substr ($datetimestamps, 6 , 2 );
    $hour    =  (int) substr ($datetimestamps, 8 , 2 );
    $minute  =  (int) substr ($datetimestamps, 10, 2 );
    $second  =  (int) substr ($datetimestamps, 12, 2 );
    if      ( $field == "YEAR"   ) { $year   += $addVal; }
    else if ( $field == "MONTH"  ) { $month  += $addVal; }
    else if ( $field == "DAY"    ) { $day    += $addVal; }
    else if ( $field == "HOUR"   ) { $hour   += $addVal; }
    else if ( $field == "MINUTE" ) { $minute += $addVal; }
    else if ( $field == "SECOND" ) { $second += $addVal; }
    $_rtn = date ( "YmdHis" , mktime ( $hour, $minute, $second, $month, $day, $year ) );
    return $_rtn;
}

/*
* �Լ���: getMicroTime
* ����  : �Խù� �ð� �Է��� ���� ����ũ�� Ÿ�� ����
**/
function getMicroTime () {
    $microtimestmp = explode(" ",microtime());
    $microtimestmp = substr($microtimestmp[0],2);
    return $microtimestmp;
}

/*
* �Լ���: getMicroSecond
* ����  : ����ũ�� Ÿ�� ����
**/
function getMicroSecond () {
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}

/*
* �Լ���: printExeTime
* ����  : �ð��� ���� ���մϴ�.
**/
function printExeTime($startTime, $endTime) {
   $exe = $endTime - $startTime;
   logs ( "\n���� �ð� : " . $startTime . "\n", true);
   logs ( "\n���� �ð� : " . $endTime   . "\n", true);
   logs ( "\n���� �ð� : " . sprintf("%0.3f",$exe) . "\n", true);
}

/*
* �Լ���: messageBox
* �ڹ� ��ũ�� Alert���ڸ� ����մϴ�.
* Argus : msg   : ��� �޽���
**/
function messageBox($msg) {
   $msg = ereg_replace("~n","\\n",$msg);
   echo("<SCRIPT LANGUAGE='javascript'> alert('$msg');</SCRIPT>");
}

function display($httpVal) {
echo "
    <TABLE>
    <TR>
        <TD> ������ </TD>
        <TD> ��     </TD>
    </TR>";
        while (list ($key, $val) = each ($httpVal) ){
    echo ( "
    <TR>
        <TD> $key </TD>
        <TD> $val </TD>
    </TR>
    ");
        }
echo "
    </TABLE>
";
}
/*
* �Լ���: getMemInfor
* �������� ���� ȸ�� ������ �о� �ɴϴ�.
**/
function getMemInfor() {
    global $HTTP_SESSION_VARS;
    $_infor = $HTTP_SESSION_VARS["_s_memInfor"];
    if ( !$_infor['user_id'] ) {
        $_infor['login_yn'    ] = 'N';  // �α��ο���
        $_infor['admin_yn'    ] = 'N';  // ������ ����
        $_infor['user_id'     ] = '' ;  // ���̵�
        $_infor['member_level'] = '0';  // ȸ�� ����
        $_infor['name'        ] = '' ;  // �̸�
        $_infor['e_mail'      ] = '' ;  // E-mail
        $_infor['home'        ] = '' ;  // Home
        $_infor['member_st'   ] = '' ;  // ȸ�� ����
        $_infor['reg_date'    ] = '' ;  // ���� ����
        $_infor['news_yn'     ] = '' ;  // ���� ���� ���� ����
        $_infor['point'       ] = 0  ;  // ����Ʈ
    } else {
//        echo '���� : ' . $_infor['user_id'];
    }
    return $_infor;
}

function getMemFormSetup($memberLevel) {
    global $tb_member_config;
    $data = singleRowSQLQuery("select * from $tb_member_config where member_level = $memberLevel");

    if ( $data ) {
        $_mem_form = $data;
/*
        $_mem_form['member_level'] = $data ['member_level'];
        $_mem_form['agreement'   ] = $data ['agreement'   ];
        $_mem_form['agreement_content'] = $data ['agreement_content'];
        $_mem_form['name'        ] = $data ['name'        ];
        $_mem_form['sex'         ] = $data ['sex'         ];
        $_mem_form['e_mail'      ] = $data ['e_mail'      ];
        $_mem_form['home'        ] = $data ['home'        ];
        $_mem_form['birth'       ] = $data ['birth'       ];
        $_mem_form['age'         ] = $data ['age'         ];
        $_mem_form['jumin'       ] = $data ['jumin'       ];
        $_mem_form['tel'         ] = $data ['tel'         ];
        $_mem_form['address'     ] = $data ['address'     ];
        $_mem_form['news_yn'     ] = $data ['news_yn'     ];
        $_mem_form['news_point'     ] = $data ['news_point'     ];
        $_mem_form['point_yn'       ] = $data ['point_yn'       ];
        $_mem_form['point'          ] = $data ['point'          ];
        $_mem_form['hint'           ] = $data ['hint'           ];
        $_mem_form['picture_image'  ] = $data ['picture_image'  ];
        $_mem_form['character_image'] = $data ['character_image'];*/
    }
    return $_mem_form;
}

function strTranslate($s) {
        if ( !$s ) return '';
        $buf = '';
        $len = sizeof($s);
        for ( $i=0; $i < $len; $i++) {
//          if      ( $s[$i] == '&' ) $buf .= '&amp;'   ;
            if      ( $s[$i] == '<' ) $buf .= '&lt;'    ;
            else if ( $s[$i] == '>' ) $buf .= '&gt;'    ;
            else if ( $s[$i] == '\"') $buf .= '&quot;'  ;
            else if ( $s[$i] == '"' ) $buf .= '&quot;'  ;
            else if ( $s[$i] == '\'') $buf .= '&#039;'  ;
//          else if ( $s[$i] == ' ' ) $buf .= '&nbsp;'  ;
//          else if ( $s[$i] == '\n') $buf .= '"\n<BR>' ;
            else $buf .= $s[$i];
        }

        return $buf;
}

function logs ($str,$display=FALSE) {
    if ( $display ) {
        echo $str;
    }
}
function escapeYN () {
    return ini_get('magic_quotes_gpc');
}

function downHeader($file, $REAL_FILE) {
    global $HTTP_USER_AGENT;
    if( eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT) ) {
        if(strstr($HTTP_USER_AGENT, "MSIE 5.5"))
        {
            header("Content-Type: doesn/matter");
            if ( $file )  { header("Content-Length: ".(string)(filesize("$file"))); }
            header("Content-disposition: filename=$REAL_FILE");
            header("Content-Transfer-Encoding: binary");
            header("Pragma: no-cache");
            header("Expires: 0");
        }

        if(strstr($HTTP_USER_AGENT, "MSIE 5.0"))
        {
            header("Content-type: file/unknown");
            if ( $file )  { header("Content-Length: ".(string)(filesize("$file"))); }
            header("Content-Disposition: attachment; filename=$REAL_FILE");
            header("Pragma: no-cache");
            header("Expires: 0");
        }

        if(strstr($HTTP_USER_AGENT, "MSIE 5.1"))
        {
            header("Content-type: file/unknown");
            if ( $file )  { header("Content-Length: ".(string)(filesize("$file"))); }
            header("Content-Disposition: attachment; filename=$REAL_FILE");
            header("Pragma: no-cache");
            header("Expires: 0");
        }

        if(strstr($HTTP_USER_AGENT, "MSIE 6.0"))
        {
            header("Content-type: file/unknown");
            if ( $file )  { header("Content-Length: ".(string)(filesize("$file"))); }
            header("Content-Disposition: attachment; filename=$REAL_FILE");
            header("Content-Transfer-Encoding: binary");
            header("Pragma: no-cache");
            header("Expires: 0");
        }
    } else {
        header("Content-type: file/unknown");
        if ( $file )  { header("Content-Length: ".(string)(filesize("$file"))); }
        header("Content-Disposition: attachment; filename=$REAL_FILE");
        header("Pragma: no-cache");
        header("Expires: 0");
    }
}

// �����ƴ��� �߰����ֽ� �κ� [ 2004.01.05 / 18:30:26 ]
function firstWriteUserId($id, $g_no) {
    $sql = "select user_id, title, no, g_no from kyh_bbs_data" . "_" . $id . " where no = '$g_no'";
    $_result = singleRowSQLQuery($sql);
    return $_result[user_id]; // ���� ��б� �ۼ����� ���̵� ��ȯ�մϴ�.
}

// �ȳ��̴� �߰����ֽ� �κ�   [ 2004.02.26 / 16:42:00] (��Ŭ�� ����)
function onclub_inst($clubname="", $nickname="", $width="", $height="")
{
	global $package, $HTTP_COOKIE_VARS;
	global $show_admin_yn_s, $show_admin_yn_e, $hide_admin_yn_s, $hide_admin_yn_e;
	global $baseDir, $memInfor, $_dboard_ver_str, $popup_mode, $login_yes, $logout_yes, $self_yn, $succ_url;
	global $id, $exec, $poll_id, $poll_exec, $a_params;

    global $onclub_customer, $onclub_auto_customer;

    if(!$clubname) $clubname = onclub_clubname_inst();

	if(!$nickname && !$member[name] && $onclub_auto_customer) {
		$ttt = "";
		srand(time());

		for($i = 0; $i < 6; $i++) {
			$var = rand(0,9);
			$ttt .= $var;
		}
		$nickname = $onclub_customer . $ttt;

	} else if(!$nickname && $memInfor[name]){
		$nickname = $memInfor[name];
	}

	if(!$width || intval($width) == 0) $width = $onclub_width;
	if(!$height || intval($height) == 0) $height = $onclub_height;

	$onclub = "<iframe frameborder=0 width=".$width." height=".$height." src=\"http://sitebiz.co.kr/onclub/index.php?clubname=".$clubname."&nickname=".$nickname."\"></iframe>";

	return $onclub;
}
// �ȳ��� �߰� [ 2004.02.26 / 16:42:00] (��Ŭ�� ����)
function onclub_clubname_inst()
{
	if($HTTP_HOST) {
		$onclub_clubname = $HTTP_HOST;
		return $onclub_clubname;
	}
	if($HOST) {
		$onclub_clubname = $HOST;
		return $onclub_clubname;
	}
	if($_SERVER["HTTP_HOST"]) {
		$onclub_clubname = $_SERVER["HTTP_HOST"];
		return $onclub_clubname;
	}
	if($HTTP_SERVER_VARS['HTTP_HOST']) {
		$onclub_clubname = $HTTP_SERVER_VARS['HTTP_HOST'];
		return $onclub_clubname;
	}
	if($_SERVER["SERVER_NAME"]) {
		$onclub_clubname = $_SERVER["SERVER_NAME"];
		return $onclub_clubname;
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////

/*
* �Լ���: parametersForm
* ����  : action �ּҷ� get,post �Ķ���͸� POSt���·� ����
* Argus : action : �̵� ������ �ּ�.
**/
function parametersForm($action) {
    global $HTTP_GET_VARS, $HTTP_POST_VARS;
    reset ($HTTP_GET_VARS );
    reset ($HTTP_POST_VARS);
    $paramVal  = array_merge ($HTTP_GET_VARS, $HTTP_POST_VARS);
    $key_name  = array_keys  ($paramVal);
    $key_value = array_values($paramVal);
    echo("<FORM method='post' name='parametersForm' action='". $action ."'>");
    for($i = 0 ;$i <count($paramVal);$i++) {
        echo("    <INPUT type='text' name='$key_name[$i]' value='$key_value[$i]'>");
    }
    echo "</FORM>";

    echo("<SCRIPT language='JavaScript'>document.parametersForm.submit();</SCRIPT>");
}

/*
* �Լ���: _javascript
* ����  : �ڹٽ�ũ��Ʈ ��Ŭ���
* Argus : val : js ���ϸ�.
**/
function _javascript($val) {
    global $baseDir;
    echo ( "<SCRIPT LANGUAGE='javascript' src='" . $baseDir . "common/js/" . $val . ".js'></SCRIPT>\n" );
}

/*
* �Լ���: curString
* ����  : �ѱ�/���� ���ڿ��� ���� ���̸�ŭ �ڸ��ϴ�.
* Argus : $str    : ���ڿ�
*       : $len    : �ڸ� ����
*       : $addSTr : �ڸ� ���ڿ� ���Ŀ� �ٿ��� ����
**/
function curString($str, $len, $addStr="...")
{
    if(strlen($str)>$len)
    {
        for($i=0; $i<$len; $i++) if(ord($str[$i])>127) $i++;
        $str=substr($str,0,$i);
        $str = $str.$addStr;
    }
    return $str;
}

// seed with microseconds
function make_seed() {
    list($usec, $sec) = explode(' ', microtime());
    return (float) $sec + ((float) $usec * 100000);
}
/*
* �Լ���: autoLink
* ����  : str���� �����ϴ� URL, mail�ּҿ� �ڵ����� ��ũ�� ����ϴ�
* Argus : str : ���ڿ�
**/
function autoLink ($str) {
//  $pattern_http = "http://([0-9a-zA-Z./@~?&=_]+)";
//  $str          = ereg_replace($pattern_http, "<a href=\"\\0\">http://\\0</a>",$str);
    $pattern_http = "[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]";
    $str          = ereg_replace($pattern_http,"<a href=\"\\0\" target='_new'>\\0</a>", $str    );

    $pattern_email= "([_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*)@([0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*)";
    $str          = ereg_replace($pattern_email, "<a href=\"mailto:\\1@\\3\">\\1@\\3</a>", $str );
    return $str;
}

/*
* �Լ���: printMemberIcon
* ����  : ȸ�� ������ ���
* Argus : memberLevel : ȸ�� ����
* Argus : user_id     : ȸ�� ���̵�
* Argus : displayYN   : ǥ�� ���� 'Y','N'
**/
function printMemberIcon($memberLevel, $user_id, $displayYN) {
    global $baseDir, $grantCharStr;
    $grantChr  = $grantCharStr[$memberLevel];
    $character = '';    // ȸ�� ������
    if ( $displayYN == 'A' ) { $displayYN = '1'; $grantChr = '1'; } // ����ҽ����� ȸ�� ������ ����� ���������
    if ( $displayYN == '1' && $grantChr == '1' ) { // ȸ�� �̹��� �������ְ�.

        if ( is_file($baseDir . 'data/member/character/' . $user_id . '_c.gif') ) {
            $character = "<img src='" . $baseDir . 'data/member/character/' . $user_id . '_c.gif' . "' align='absmiddle' border='0'>";
        }
    }
    return $character;
}


function setSessionMemberValue ($key,$val) {
    global $HTTP_SESSION_VARS, $memInfor;
    $_s_memInfor = $HTTP_SESSION_VARS["_s_memInfor"];
    $_s_memInfor[$key] = $val;
    $_SESSION['_s_memInfor'] = $_s_memInfor;  // 4.10 ���� ó��.
    @session_register("_s_memInfor");
}

function appendParam (&$q_str,$name,$val) {
    if ( $val != '' ) {
        $sep = ( $q_str == '' ) ? '?': '&';
//      $q_str = ereg_replace('(\?|&)'. $name . "=([^&]*)","\\1" . $name. "=" . $val, $q_str);
        if ( ereg ("(\?|&)$name=([^&]*)", $q_str) ) $q_str = ereg_replace("(\?|&)$name=([^&]*)","\\1$name=$val", $q_str);
        else $q_str .= "$sep$name=$val";
    }
}

/*
* �Լ���: createGory
* ����  : ī�װ������� tagName �±׸� �̿��� ȭ�鿡 ����մϴ�.
*         ��)  createGory ('S',SELECT);   //SELECT Box ��ȸ
*              createGory ('R',RADIO );   //RADIO  Box ��ȸ
  $tagName : 'SELECT'      >> SELECT Box
           : 'RADIO'       >> RADIO  Box
           : 'CHECKBOX'    >> CHECK  Box
**/
function createGory ($tagName='SELECT', $creategory, $proc='1') {
    global $creategory_setup;

    $tagName    = strtoupper($tagName);
    $_prop_name = $creategory_setup['prop_name'];
    if ( !$_prop_name ) $_prop_name = 'division';

    if ( is_array($creategory) ) {
        ksort ( $creategory['name'] );
        reset ( $creategory['name'] );
    }
    $_rtn  = '';
    $_rtn .= $creategory_setup['start_tag'];
    if ( $tagName == 'SELECT' || !$tagName ) {
        if ( $creategory_setup['item_align'] == 'right' ) $item_align = "style='direction:rtl'";
        else $item_align = "style='direction:ltr'";

        $_rtn  = "\n<select name='$_prop_name' " . $creategory_setup['properties'] . ' ' . $creategory_setup['script'] . " $item_align>";

        if ( $creategory_setup['title'] ) $_rtn .= "<option value=''>" . $creategory_setup['title'] . "</option>";
        if ( $creategory_setup['insert_tag'] ) $_rtn .= $creategory_setup['insert_tag'];
        if ( is_array($creategory) ) {
            while (list ($key, $val) = each ($creategory['name'])) {
                if ( $creategory_setup['select'] == $key ) { $checked = 'selected'; } else { $checked = ''; }
                if ( $proc == '1' ) {
                    if ( $checked ) { $_rtn .= $creategory_setup['active_start_tag'  ]; }
                    $_rtn .= "<option value='".$key."' $checked>".$val ."</option>";
                    if ( $checked ) { $_rtn .= $creategory_setup['active_end_tag'    ]; }
                } else if ( $proc == '2' ) {
                    if ( !$checked ) {
                        if ( $checked ) { $_rtn .= $creategory_setup['active_start_tag'  ]; }
                        $_rtn .= "<option value='".$key."' $checked>".$val ."</option>";
                        if ( $checked ) { $_rtn .= $creategory_setup['active_end_tag'    ]; }
                    }
                }
            }
        }
        if ( $creategory_setup['append_tag'] ) $_rtn .= $creategory_setup['append_tag'];

        $_rtn .= "</select>\n";
    } else if ( $tagName == 'RADIO' ) {
        if ( is_array($creategory) ) {
        if ( $creategory_setup['insert_tag'] ) $_rtn .= $creategory_setup['insert_tag'];
            while (list ($key, $val) = each ($creategory['name'])) {
                $_rtn .= $creategory_setup['loop_start_tag'];
                $checked = '';
                if ( $creategory_setup['select'] == $key ) { $checked = 'checked'; } else { $checked = ''; }

                if ( $creategory_setup['item_align'] == 'right' ) {
                    if ( $checked ) { $_rtn .= $creategory_setup['active_start_tag'  ]; }
                    $_rtn .= "\n" . $val . "<input type='radio' name='$_prop_name' value='". $key ."' $checked " . $creategory_setup['properties'] . " " . $creategory_setup['script'] . ">";
                    if ( $checked ) { $_rtn .= $creategory_setup['active_end_tag'    ]; }
                } else {
                    if ( $checked ) { $_rtn .= $creategory_setup['active_start_tag'  ]; }
                    $_rtn .= "\n<input type='radio' name='$_prop_name' value='". $key ."' $checked " . $creategory_setup['properties'] . " " . $creategory_setup['script'] . ">" . $val;
                    if ( $checked ) { $_rtn .= $creategory_setup['active_end_tag'    ]; }
                }
                $_rtn .= $creategory_setup['loop_end_tag'];
            }
            if ( $creategory_setup['append_tag'] ) $_rtn .= $creategory_setup['append_tag'];
        }
    } else if ( $tagName == 'CHECKBOX' ) {
        if ( is_array($creategory) ) {
            if ( $creategory_setup['insert_tag'] ) $_rtn .= $creategory_setup['insert_tag'];
            while (list ($key, $val) = each ($creategory['name'])) {
                $_rtn .= $creategory_setup['loop_start_tag'];
                $checked = '';
                echo "key : " . $key;
                if ( $creategory_setup['select'] == $key ) { $checked = 'checked'; } else { $checked = ''; }

                if ( $creategory_setup['item_align'] == 'right' ) {
                    if ( $checked ) { $_rtn .= $creategory_setup['active_start_tag'  ]; }
                    $_rtn .= "\n" . $val . "<input type='checkbox' name='$_prop_name' value='". $key ."' $checked $event_script " . $creategory_setup['properties'] . " " . $creategory_setup['script'] . ">";
                    if ( $checked ) { $_rtn .= $creategory_setup['active_end_tag'    ]; }
                } else {
                    if ( $checked ) { $_rtn .= $creategory_setup['active_start_tag'  ]; }
                    $_rtn .= "\n<input type='checkbox' name='$_prop_name' value='". $key ."' $checked $event_script " . $creategory_setup['properties'] . " " . $creategory_setup['script'] . ">" . $val;
                    if ( $checked ) { $_rtn .= $creategory_setup['active_end_tag'    ]; }
                }
                $_rtn .= $creategory_setup['loop_end_tag'];
            }
            if ( $creategory_setup['append_tag'] ) $_rtn .= $creategory_setup['append_tag'];
        }
    } else {
        if ( is_array($creategory) ) {
            if ( $creategory_setup['insert_tag'] ) $_rtn .= $creategory_setup['insert_tag'];
            while (list ($key, $val) = each ($creategory['name'])) {
                $_rtn .= $creategory_setup['loop_start_tag'];
                $checked = '';
                if ( $creategory_setup['select'] == $key ) { $checked = 'checked'; } else { $checked = ''; }

                if ( $checked ) { $_rtn .= $creategory_setup['active_start_tag'  ]; }
                $_rtn .= "\n<$tagName name='$_prop_name' value='". $key ."' " . $creategory_setup['properties'] . " " . $creategory_setup['script'] . ">";
                $_rtn .= $val;
                $_rtn .= "\n</" . $tagName . ">";
                if ( $checked ) { $_rtn .= $creategory_setup['active_end_tag'    ]; }

                $_rtn .= $creategory_setup['loop_end_tag'];
            }
            if ( $creategory_setup['append_tag'] ) $_rtn .= $creategory_setup['append_tag'];
        }
    }
    $_rtn .= $creategory_setup['end_tag'];
    $creategory_setup='';
    return $_rtn;
}

/*
* �Լ���: arrangeFormElement
* ����  : ������ �� ������Ʈ �����
* ��)  arrangeFormElement("���̺���", "�����ͺ��̽���");
* Argus : $type  : select, radio, checkbox
*       : $name  : �̸�
*       : $frm   : ���۰�
*       : $to    : ���ᰪ
*       : $script: ��ũ��Ʈ
*       : $inc   : ������
*       : $sel   : ���ð� ( 2001, checkbox : '2001,2002' )
*       : $title : Ÿ��Ʋ
*       : $nextStr : ���ʿ� �߰��� ���ڿ�
*       : $preStr  : ���ʿ� �߰��� ���ڿ�
* ����
*   arrangeFormElement ('select','test', 2000,2010,"", 1, '2001', '����', '��');
*   arrangeFormElement ('radio','test', 2000,2010,"", 1, '2001', '����', '��');
*   arrangeFormElement ('checkbox','test', 2000,2010,"", 1, '2001', '����', '��');
**/
function arrangeFormElement ($type, $name, $frm=0, $to=0, $script='', $inc=1, $sel='', $title='', $nextStr='', $preStr='') {
    if ( strtoupper ( $type ) == 'SELECT' ) {
        return listBoxElement ($name, $frm, $to, $script, $inc, $sel, $title, $nextStr, $preStr);
    } else if ( strtoupper ( $type ) == 'RADIO' ) {
        return radioBoxElement ($name, $frm, $to, $script, $inc, $sel, $title, $nextStr, $preStr);
    } else if ( strtoupper ( $type ) == 'CHECKBOX' ) {
        return checkBoxElement ($name, $frm, $to, $script, $inc, $sel, $title, $nextStr, $preStr);
    }
}

function listBoxElement ($name, $frm=0, $to=0, $script='', $inc=1, $sel='', $title, $nextStr='', $preStr='') {
    $inc =  abs ($inc);
    $_rtn = "<select name='$name' $script>\n";
    if ( $title ) $_rtn .= "<option value=''>" . $title . "</option>\n";
    if ( $frm > $to ) {
        for ( $i=$frm; $i>=$to; $i-=$inc ) {
            if ( $i == $sel ) $selected = 'selected';
            else              $selected = '';
            $_rtn .= "<option value='$i' $selected>" . $preStr . $i . $nextStr . "</option>\n";
        }
    } else {
        for ( $i=$frm; $i<=$to; $i+=$inc ) {
            if ( $i == $sel ) $selected = 'selected';
            else              $selected = '';
            $_rtn .= "<option value='$i' $selected>" . $preStr . $i . $nextStr . "</option>\n";
        }
    }
    $_rtn .= "</select>\n";
    return $_rtn;
}

function radioBoxElement ($name, $frm=0, $to=0, $script='', $inc=1, $sel='', $title='', $nextStr='', $preStr='') {
    $inc =  abs ($inc);
    $_rtn = "";
    if ( $title ) $_rtn .= $title;
    if ( $frm > $to ) {
        for ( $i=$frm; $i>=$to; $i-=$inc ) {
            if ( $i == $sel ) $checked = 'checked';
            else              $checked = '';
            $_rtn .= "<input type='radio' name='$name' value='$i' $script $checked>" . $preStr . $i . $nextStr . "\n";
        }
    } else {
        for ( $i=$frm; $i<=$to; $i+=$inc ) {
            if ( $i == $sel ) $checked = 'checked';
            else              $checked = '';
            $_rtn .= "<input type='radio' name='$name' value='$i' $script $checked>" . $preStr . $i . $nextStr . "\n";
        }
    }
    return $_rtn;
}

function checkBoxElement ($name, $frm=0, $to=0, $script='', $inc=1, $sel='', $title='', $nextStr='', $preStr='') {
    $inc =  abs ($inc);
    $_rtn = "";
    if ( $title ) $_rtn .= $title;
    if ( $frm > $to ) {
        for ( $i=$frm; $i>=$to; $i-=$inc ) {
//            echo " $sel / $i <BR>";
            if ( strpos ( ' ' . $sel, '' . $i ) == true) { $checked = 'checked';}
            else $checked = '';
            $_rtn .= "<input type='checkbox' name='$name' value='$i' $script $checked>" . $preStr . $i . $nextStr . "\n";
        }
    } else {
        for ( $i=$frm; $i<=$to; $i+=$inc ) {
            if ( strpos ( ' ' . $sel, '' . $i ) == true) { $checked = 'checked';}
            else $checked = '';
            $_rtn .= "<input type='checkbox' name='$name' value='$i' $script $checked>" . $preStr . $i . $nextStr . "\n";
        }
    }
    return $_rtn;
}
?>