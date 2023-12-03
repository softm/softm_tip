<?
include ( '../common/lib.inc'       ); // 파일 시스템 관련
include ( '../common/db_connect.inc'); // Data Base 연결 클래스
include ( '../common/file.inc'      ); // 파일 시스템 관련

// 데이터베이스에 접속합니다.
//$db = initDBConnection ();

//if ( $package == 'board' ) {
//    $sql = "select base_path from $tb_bbs_abstract where no = '$no'";
//    $row = singleRowSQLQuery($sql);
//} else if ( $package == 'poll' ) {
//    $sql = "select base_path from $tb_poll_master where no = '$no'";
//    $row = singleRowSQLQuery($sql);
//} else {

//}
// echo '하하핳. :' . $base_path;

//echo 'no : ' . $row['no'];
//if ( !$rootdir ) { $rootdir = substr ( $sysInfor['setup_dir'], 0, strlen( $sysInfor['setup_dir'] ) -1 ); }
//if ( !$rootdir ) { $rootdir = '/home/hosting_users/designfor'; }
$reselect_yn = 'N';
$setup_dir = $sysInfor['setup_dir'];
if ( !$rootdir ) { $rootdir = $DOCUMENT_ROOT; }
if ( !$rootdir ) { $rootdir = $DOCUMENT_ROOT; }
if ( substr($rootdir,strlen( $rootdir )-1) == '/' ) $rootdir = substr($rootdir,0,strlen( $rootdir )-1);

if ( !$curdir ) {
//  $base_path = $row['base_path'];
    if ( $base_path ) {
        $reselect_yn = 'Y';
        if ( strpos($base_path, $rootdir) == 0 ) {
            $base_relative_dir  = substr( $base_path, strlen($rootdir) );
        }
        $curdir = '.' . $base_relative_dir;
        if ( $curdir != '.' ) {
            $reselect_dir = basename($curdir);
            $curdir       = dirname ($curdir);
//            echo '여기 타눈중 : ' .  $curdir   . '<BR>';
//            echo '여기 타눈중 : ' .  $reselect_dir. '<BR>';
        }
    } else {
        $curdir = '.' . substr ( $sysInfor['base_dir'], 0, strlen( $sysInfor['base_dir'] ) -1 );
    }
} else {
    $reselect_yn = 'N';
}

//if ( !$curdir ) { $curdir = '.'; }
// $setup   = new SetUp ($rootdir, $curdir,'1111100100', "white", "black", "#000099", "white");
$setup   = new SetUp ($rootdir, $curdir,'1100100101000', "white", "black", "#000099", "white");
if ( $setup->display_delete_folder ) {
// parent.FrameResize ( '570', 100, 'explorer');
    echo "<BODY onLoad=\"parent.menuInitial ();\" leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>\n";
} else {
    echo "<BODY leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>\n";
}
echo "<link rel=stylesheet href='../style.css' type='text/css'>\n";
$explorer = Explorer ($setup, 1, 'Y');

function numCodeToStr ($data, $cipher) {
    $zeroStr = "";
    for( $i=0; $i<$cipher-strlen($data); $i++){
        $zeroStr .= "0";
    }
    $data = $zeroStr . $data;
    return $data;
}

class SetUp {
    var $rootdir         = ''; // 루트 디렉토리
    var $curdir          = ''; // 현재 디렉토리
    var $parentdir       = ''; // 상위 디렉토리
    var $display_file           = 0; // 0  파일명
    var $display_type           = 0; // 1  종류
    var $display_size           = 0; // 2  크기
    var $display_grant          = 0; // 3  파일 권한            fileperms ($path): -- 파일의 권한을 가져옵니다 drwxrwxrwx                   
    var $display_update_time    = 0; // 4  수정시간             filemtime ($path): -- 파일이 수정된 시간을 가져옵니다              2003.07.10 06:14:52   
    var $display_access_time    = 0; // 5  접근 시간            fileatime ($path): -- 최근에 파일에 접근한 시간을 가져옴 2003.08.03 12:00:00
    var $display_inode_time     = 0; // 6  아이노드 변경 시간   filectime ($path): -- 파일의 아이노드 변경시간을 가져옵니다        2003.07.10 06:16:25
    var $display_total_disk_size= 0; // 7  총   용량            disk_free_space ($path): 361.5 MB                                           
    var $display_free_disk_size = 0; // 8  남은 용량            disk_total_space ($path): 1 GB 
    var $display_path           = 0; // 9  경로명
    var $display_add_forder     = 0; // 10 폴더 생성
    var $display_re_name        = 0; // 11 이름 변경
    var $display_delete_folder  = 0; // 12 삭제 기능

    var $backColor       = '';  // 배경색
    var $foreColor       = '';  // 전경색
    var $activeBackColor = '';  // 선택된 파일에대한 배경색
    var $activeForeColor = '';  // 선택된 파일에대한 전경색

    function SetUp ($rootdir, $curdir, $display, $backColor, $foreColor, $activeBackColor, $activeForeColor) {
        $rootdir  = str_replace("\\","/",$rootdir);
        $rootdir  = str_replace("//","/",$rootdir);
        $this->rootdir         = $rootdir        ;
        $this->curdir          = $curdir         ;
        $this->display_file            = $display[0 ];
        $this->display_type            = $display[1 ];
        $this->display_size            = $display[2 ];
        $this->display_grant           = $display[3 ];
        $this->display_update_time     = $display[4 ];
        $this->display_access_time     = $display[5 ];
        $this->display_inode_time      = $display[6 ];
        $this->display_total_disk_size = $display[7 ];
        $this->display_free_disk_size  = $display[8 ];
        $this->display_path            = $display[9 ];
        $this->display_add_forder      = $display[10];
        $this->display_re_name         = $display[11];
        $this->display_delete_folder   = $display[12];

        $this->backColor       = $backColor      ;
        $this->foreColor       = $foreColor      ;
        $this->activeBackColor = $activeBackColor;
        $this->activeForeColor = $activeForeColor;
    }
}

// 탐색기 클래스
class Explorer {
    var $setup         ;
    var $mode    = 0   ;// mode : 0 ::> 모든     탐색
                        //        1 ::> 디렉토리 탐색
                        //        2 ::> 폴더     탐색
    var $parentdir     ;// 상위 디렉토리 정보
    var $pathinfor     ;// 현재 선택된 디렉토리
    var $fileDown= 'N' ;// 파일 다운로드 실행 여부
    var $itemCnt = 0   ;// 파일 갯수

    function Explorer ($setup, $mode, $fileDown) {
        $this->setup    = $setup    ;
        $this->mode     = $mode     ;
        $this->fileDown = $fileDown ;
        $this->printDirectory ();
    }

    function printDirectory () {
        $setup = $this->setup;
        $this->parentdir = dirname ( $setup->curdir );
        if ( basename ($setup->curdir) == '.' ) {
            $this->pathinfor = $setup->rootdir;
        } else {
            // echo '하핳.' .basename ($setup->curdir) ;
            // echo '하핳.' .dirname ($setup->curdir) ;
            $this->pathinfor = $setup->rootdir .  substr( $setup->curdir, 1 );
        }
        $this->prtinHeader();
        if ($dir = opendir($setup->rootdir . '/'. $setup->curdir)) {
            //@chdir($this->rootdir . '/'. $this->curdir);
            while ( ($file = @readdir($dir) ) !== false) {
                clearstatcache();
                if ( $file == '.' ) {
                    $filePath = $setup->curdir;
                } else if ( $file == '..' ) {
                    $filePath = dirname ($setup->curdir);
                } else {
                    $filePath = $setup->curdir . '/' . $file;
                }

                $path       = $setup->rootdir . '/'. $filePath;

                $type       = ''; // 파일 형태 : 디렉토리, 파일
                if ( filetype ($path) == 'dir' ) {
                    $type = 'dir' ;
                } else {
                    $type = 'file';
                }

                $execute = 0;

                if ( $this->mode == 0 || ( $this->mode == 1 && $type == 'dir' ) || ( $this->mode == 2 && $type == 'file' ) ) {
                    $execute = 1;
                }

                if ( $execute ) {

                    $this->itemCnt++;
                    $id         = 'f' . numCodeToStr ( $this->itemCnt, 5 );

                    $ext        = ''; // 파일 확장자
                    $type_name  = ''; // 파일 형태에대한 보여질 명칭
                    $dblClick   = ''; // 더블 클릭 이벤트시 동작 스크립

                    if ( $type == 'dir' ) {
                        $ext        = ''                ;
                        if ( $file == '.' ) {
                            $type_name  = "현재 디렉 토리"       ;
                        } else if ( $file == '..' ) {
                            $type_name  = "상위 디렉 토리"       ;
                        } else {
                            $type_name  = "디렉 토리"       ;
                        }
                        $icon_name  = '../images/icon_folder.gif' ;
                        $dblClick   = 'onDblClick="changeDir(\''.$id.'\');"';
                    } else {
                        $ext = getFileExtraName($filePath);
                        $type_name  = "파일( $ext )"    ;
                        if ( $ext == 'gif' || $ext == 'jpg' || $ext == 'bmp' ) {
                            $icon_name = '../images/icon_file_img.gif';
                        } else if ( $ext == 'avi' || $ext == 'wma' || $ext == 'asf' ) {
                            $icon_name = '../images/icon_file_movie.gif';
                        } else if ( $ext == 'txt' || $ext == 'doc' || $ext == 'hwp' || $ext == 'dir' ) {
                            $icon_name = '../images/icon_file_doc.gif';
                        } else {
                            $icon_name = '../images/icon_file_doc.gif';
                        }

                        if ( $this->fileDown == 'Y' ) {
                            $dblClick   = 'onDblClick="downLoad(\''.$id.'\');"';
                        } else {
                            $dblClick   = '""';
                        }
                    }
                    $click      = 'onmousedown=\'selectedItem ("'.$id.'","'.$type.'");\'';
                    echo ("<tr bgcolor='#FFFFFF'> \n");
                    echo ("<td style='cursor:hand' $click $dblClick>&nbsp;\n");
                    echo "<img src='". $icon_name ."' width='16' height='14' align='texttop' border='0'> ";
                    echo "<a href='#' onClick='return false;' id='". $id ."' style='cursor:hand;background-color:".$setup->backColor.";color:" . $setup->foreColor . "' >" . $file . "</a>\n";
                    echo ("</td>\n");
                    $f_size = filesize ($path);
                    if ( $f_size == 0 ) { $f_size = ''; }
                    else { 
                        if ( $f_size >= 1024 ) {
                            $f_size = number_format (round ( $f_size / 1024 ,2) ).' KB';
                        } else {
                            $f_size = number_format($f_size) . ' byte';
                        }
                    }
                    if ( $setup->display_type            ) { echo '<td align="center" onClick="clearItem ();">'. $type_name     .'</td>'; }
                    if ( $setup->display_size            ) { echo '<td align="right"  onClick="clearItem ();">'. $f_size        .'&nbsp;</td>'; }
                    if ( $setup->display_grant           ) { echo '<td align="center" onClick="clearItem ();">'. getPerms ( fileperms ( $path ) )       .'</td>'; }
                    if ( $setup->display_update_time     ) { echo '<td align="center" onClick="clearItem ();">'. date('Y.m.d h:i:s',filemtime ( $path )).'</td>'; }
                    if ( $setup->display_access_time     ) { echo '<td align="center" onClick="clearItem ();">'. date('Y.m.d h:i:s',fileatime ( $path )).'</td>'; }
                    if ( $setup->display_inode_time      ) { echo '<td align="center" onClick="clearItem ();">'. date('Y.m.d h:i:s',filectime ( $path )).'</td>'; }
                    echo (' </tr>');
                }
            }
            closedir($dir);
        $this->prtinFooter();
        }
    }

    // 탐색기 헤더 출력
    function prtinHeader() {
        $setup = $this->setup;
        echo ('<table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="DADADA" class="text_02">');
        echo ("<form name='explorerForm' method='POST'>");
        echo ("<input type='hidden' name='curdir'       value='". $setup->curdir ."'>");
        echo ("<input type='hidden' name='rootdir'      value='". $setup->rootdir."'>");
        echo ("<input type='hidden' name='action_type'  value=''>");
        echo ("<input type='hidden' name='selectdir'  value=''>");
        if ( $setup->display_path || $setup->display_add_forder ) { 
            echo ('<tr bgcolor="F7F7F7"><td colspan="10" align="left">');
            echo ('<table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="DADADA" class="text_02">');
                echo ('<tr bgcolor="F7F7F7">');
            if ( $setup->display_path ) { 
                echo ('<td align="center" width="80"><B>파일경로</B></td>');
                echo ('<td>');
                echo ('<input name="path_infor" id="path_infor" type="text" style="width:100%" value="' . $this->pathinfor . '" readonly>');
                echo ('</td>');
            }
            if ( $setup->display_add_forder ) { 
                echo ('<td align="center" width="70"><B>폴더생성</B></td>');
                echo ('<td width="150">');
                echo ('<INPUT name="folder_name" type="text" maxlength="255" size="15">&nbsp;');
                echo ('<a href="#" onClick="addFolder();return false;"><img src="../images/button_bplus.gif" border="0" align="top"></a>');
                echo ('</td>');
            }
                echo ('</tr>');
            echo ('</table>');
            echo ('</td></tr>');
        }
        echo ('<tr bgcolor="F7F7F7">');
        if ( $setup->display_file            ) { echo "<td align='center' height='20'><b>파일명            </b></td>\n"; }
        if ( $setup->display_type            ) { echo "<td width='100' align='center'><b>종류              </b></td>\n"; }
        if ( $setup->display_size            ) { echo "<td             align='center'><b>크기              </b></td>\n"; }
        if ( $setup->display_grant           ) { echo "<td             align='center'><b>파일 권한         </b></td>\n"; }
        if ( $setup->display_update_time     ) { echo "<td width='150' align='center'><b>수정시간          </b></td>\n"; }
        if ( $setup->display_access_time     ) { echo "<td             align='center'><b>접근 시간         </b></td>\n"; }
        if ( $setup->display_inode_time      ) { echo "<td             align='center'><b>아이노드 변경 시간</b></td>\n"; }
        echo (' </tr>');
    }
    // 탐색기 풋터 출력
    function prtinFooter() {
        echo ('</form>');
        echo ('</table>');
    }
}

function Explorer ($setup, $mode=0, $fileDown='Y') {
    $explorer = new Explorer ($setup, $mode, $fileDown);
    return $explorer;
}

$path = $rootdir . '/'. $curdir;
//$path = "$DOCUMENT_ROOT";
/*
echo 'dirname  ($path): ' . dirname ($path) . '<BR>';
echo 'basename ($path): ' . basename($path) . '<BR>';
echo 'disk_free_space  ($path): ' . f_size( disk_free_space ($path) ) . '<BR>';
echo 'disk_total_space ($path): ' . f_size( disk_total_space($path) ) . '<BR>';
echo 'diskfreespace    ($path): ' . f_size( diskfreespace   ($path) ) . '<BR>';
echo 'file_exists      ($path): ' . file_exists ( $path ) . '<BR>';

echo 'fileatime ($path): -- 최근에 파일에 접근한 시간을 가져옴      ' . date('Y.m.d h:i:s',fileatime ( $path )) . '<BR>';
echo 'filectime ($path): -- 파일의 아이노드 변경시간을 가져옵니다   ' . date('Y.m.d h:i:s',filectime ( $path )) . '<BR>';
echo 'filegroup ($path): -- 파일의 그룹을 가져옵니다                ' . filegroup ( $path ) . '<BR>';
echo 'fileinode ($path): -- 파일의 아이노드를 가져옵니다            ' . fileinode ( $path ) . '<BR>';
echo 'filemtime ($path): -- 파일이 수정된 시간을 가져옵니다         ' . date('Y.m.d h:i:s',filemtime ( $path )) . '<BR>';
echo 'fileowner ($path): -- 파일의 소유자를 가져옵니다              ' . fileowner ( $path ) . '<BR>';
echo 'fileperms ($path): -- 파일의 권한을 가져옵니다                ' . getPerms ( fileperms ( $path ) ). '<BR>';
echo 'filesize  ($path): -- 파일의 크기를 가져옵니다                ' . filesize  ( $path ) . '<BR>';

echo 'is_dir          ($path) -- filename 이 디렉토리인지 아닌지 이야기하기               : ' . is_dir          ( $path ) . '<BR>';
//echo 'is_executable   ($path) -- filename이 실행가능한 것인지 아닌지 이야기하기           : ' . is_executable   ( $path ) . '<BR>';
echo 'is_file         ($path) --  filename이 보통 파일인지 아닌지 이야기하기              : ' . is_file         ( $path ) . '<BR>';
echo 'is_link         ($path) --  filename이 심볼릭 링크인지 아닌지 이야기하기            : ' . is_link         ( $path ) . '<BR>';
echo 'is_readable     ($path) --  filename이 읽기 가능한 것인지 아닌지 이야기하기         : ' . is_readable     ( $path ) . '<BR>';
echo 'is_uploaded_file($path) -- file이 HTTP POST를 통해 업로드된 것인지 아닌지 이야기하기: ' . is_uploaded_file( $path ) . '<BR>';
echo 'is_writable     ($path) -- filename이 쓰기가능한 것인지 아닌지 이야기하기           : ' . is_writable     ( $path ) . '<BR>';
echo 'is_writeable    ($path) -- Tells whether the filename is writable                   : ' . is_writeable    ( $path ) . '<BR>';
//echo 'linkinfo        ($path) -- 링크 정보 가져오기                                       : ' . linkinfo        ( $path ) . '<BR>';
echo 'lstat           ($path) -- 파일이나 심볼릭 링크에 관한 정보를 제공                  : ' . lstat           ( $path ) . '<BR>';
echo 'realpath        ($path) -- 표준화된 절대 경로명을 반환합니다                        : ' . realpath        ( $path ) . '<BR>';
*/
?>
<iframe name='explorer_download' id='explorer_download' style='display:none'></iframe></iframe>

<?
echo "   <SCRIPT LANGUAGE='JavaScript'>\n";
echo "   <!--\n";
echo "   var curdir          = \"" . $setup->curdir          . "\";\n";
echo "   var rootdir         = \"" . $setup->rootdir         . "\";\n";
echo "   var backColor       = \"" . $setup->backColor       . "\";\n";
echo "   var foreColor       = \"" . $setup->foreColor       . "\";\n";
echo "   var activeBackColor = \"" . $setup->activeBackColor . "\";\n";
echo "   var activeForeColor = \"" . $setup->activeForeColor . "\";\n";
echo "   var parentdir       = \"" . $explorer->parentdir    . "\";\n";
echo "   var itemCnt         = \"" . $explorer->itemCnt      . "\";\n";
echo "   var pathinfor       = \"" . $explorer->pathinfor    . "\";\n";
echo "   var reselect_yn     = \"" . $reselect_yn            . "\";\n";
echo "   var reselect_dir    = \"" . $reselect_dir           . "\";\n";

echo "   var selectdir       = \"\";\n";

echo "   //-->\n";
echo "   </SCRIPT>\n";
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
    var selectID = '' ;
    var selectYN = 'N';
    self.name = 'explorer_main';
    // browser Check
    var is             = null;
    function browserCheck() {
        this.ie  = ( document.all     ) ? 1 : 0;
        this.ns  = document.getElementById && !document.all ? 1 : 0;
    }
    // Browser  체크
    is = new browserCheck();

    function getObject( objStr, tier ) {
        var docStr = "";
        var obj    = null;
        if ( typeof(tier) == "string" ) {
            docStr = tier + "." + "document";
        } else {
            docStr = "document";
        }

        if (is.ie) {
            /* IE */
            obj = eval( docStr + ".all['" + objStr + "']");
        } else if ( is.ns ) {
            /* NS */
            obj = eval( docStr + ".getElementById('" + objStr + "');");

        }
        return obj;
    }

    function objectBackColor ( id, color, tier ) {
        var obj = null;
        if ( typeof(id) == 'object' ) {
            obj = id;
        } else {
            obj = getObject(id, tier);
        }
        if ( obj != null && typeof(obj) == 'object' ) { 
            obj.style.backgroundColor = color;
        }
    }

    function objectColor( id, color, tier ) {
        var obj = null;
        if ( typeof(id) == 'object' ) {
            obj = id;
        } else {
            obj = getObject(id, tier);
        }
        if ( obj != null && typeof(obj) == 'object' ) { 
            obj.style.color = color;
        }
    }

    function selectedItem (s_id, type) {

        var obj = getObject(s_id);

        var file = null;
        if ( is.ie ) file = obj.innerText;
        else         file = obj.text;

        if ( type == 'dir' ) {
            if ( file == '.' ) {
                selectdir = curdir;
            } else if ( file == '..' ) {
                selectdir = '';
            } else {
                selectdir = curdir + '/' + file;
            }
        } else {
            selectdir = curdir + '/' + file;
        }

        document.explorerForm.selectdir.value = selectdir;
        var pathObj = getObject("path_infor");
        if ( typeof(pathObj) == 'object' ) {
            if ( file == '.' || file == '..' ) {
                pathObj.value = pathinfor;
            } else {
                pathObj.value = pathinfor + '/' + file;
            }
        }
//        alert ( pathObj.value  );
        selectedItemColor (s_id);

        selectID = s_id;
        parent.abstractSource();
    }

    function selectedItemColor (s_id) {
        objectColor     ( s_id    , activeForeColor );
        objectBackColor ( s_id    , activeBackColor );
        if ( selectID != s_id ) {
            objectColor     ( selectID, foreColor );
            objectBackColor ( selectID, backColor );
        }
    }

    function clearItem () {
        objectColor     ( selectID, foreColor );
        objectBackColor ( selectID, backColor );
        document.explorerForm.selectdir.value = '';
    }

    function changeDir (s_id) {
        var obj = getObject(s_id);

        var file = null;
        if ( is.ie ) file = obj.innerText;
        else         file = obj.text;

        var filePath; 
        if ( file == '.' ) {
            filePath = curdir;
        } else if ( file == '..' ) {
            filePath = parentdir;
        } else {
            filePath = curdir + '/' + file;
        }
        document.explorerForm.action = '';
        document.explorerForm.target = 'explorer_main';
        document.explorerForm.curdir.value = filePath;
        document.explorerForm.submit();
    }

    function downLoad (s_id) {
        var obj = getObject(s_id);
        var file = null;
        if ( is.ie ) file = obj.innerText;
        else         file = obj.text;
        var filePath = curdir + '/' + file;

        document.explorerForm.action_type.value = 'download';
        document.explorerForm.curdir.value = filePath;
        document.explorerForm.action = 'admin_board_explorer_download.php';
        document.explorerForm.target = 'explorer_download';
        document.explorerForm.submit();
    }

    function addFolder() {
        if ( selectdir == '' ) { selectdir = curdir; }
        document.explorerForm.action_type.value = 'add_folder';
        document.explorerForm.action = 'admin_board_explorer_download.php';
        document.explorerForm.target = 'explorer_download';
        document.explorerForm.submit();
    }

    function deleteFolder() {
        document.explorerForm.action_type.value = 'delete_folder';
        document.explorerForm.action = 'admin_board_explorer_download.php';
        document.explorerForm.target = 'explorer_download';
        document.explorerForm.submit();
    }

//  setInterval ("checkDeamon()", 2000);
//-->
</SCRIPT>
</BODY>

<?
//    closeDBConnection (); // 데이터베이스 연결 설정 해제
?>