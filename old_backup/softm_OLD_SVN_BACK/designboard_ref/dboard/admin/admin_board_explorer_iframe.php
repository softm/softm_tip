<?
include ( '../common/lib.inc'       ); // ���� �ý��� ����
include ( '../common/db_connect.inc'); // Data Base ���� Ŭ����
include ( '../common/file.inc'      ); // ���� �ý��� ����

// �����ͺ��̽��� �����մϴ�.
//$db = initDBConnection ();

//if ( $package == 'board' ) {
//    $sql = "select base_path from $tb_bbs_abstract where no = '$no'";
//    $row = singleRowSQLQuery($sql);
//} else if ( $package == 'poll' ) {
//    $sql = "select base_path from $tb_poll_master where no = '$no'";
//    $row = singleRowSQLQuery($sql);
//} else {

//}
// echo '�����K. :' . $base_path;

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
//            echo '���� Ÿ���� : ' .  $curdir   . '<BR>';
//            echo '���� Ÿ���� : ' .  $reselect_dir. '<BR>';
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
    var $rootdir         = ''; // ��Ʈ ���丮
    var $curdir          = ''; // ���� ���丮
    var $parentdir       = ''; // ���� ���丮
    var $display_file           = 0; // 0  ���ϸ�
    var $display_type           = 0; // 1  ����
    var $display_size           = 0; // 2  ũ��
    var $display_grant          = 0; // 3  ���� ����            fileperms ($path): -- ������ ������ �����ɴϴ� drwxrwxrwx                   
    var $display_update_time    = 0; // 4  �����ð�             filemtime ($path): -- ������ ������ �ð��� �����ɴϴ�              2003.07.10 06:14:52   
    var $display_access_time    = 0; // 5  ���� �ð�            fileatime ($path): -- �ֱٿ� ���Ͽ� ������ �ð��� ������ 2003.08.03 12:00:00
    var $display_inode_time     = 0; // 6  ���̳�� ���� �ð�   filectime ($path): -- ������ ���̳�� ����ð��� �����ɴϴ�        2003.07.10 06:16:25
    var $display_total_disk_size= 0; // 7  ��   �뷮            disk_free_space ($path): 361.5 MB                                           
    var $display_free_disk_size = 0; // 8  ���� �뷮            disk_total_space ($path): 1 GB 
    var $display_path           = 0; // 9  ��θ�
    var $display_add_forder     = 0; // 10 ���� ����
    var $display_re_name        = 0; // 11 �̸� ����
    var $display_delete_folder  = 0; // 12 ���� ���

    var $backColor       = '';  // ����
    var $foreColor       = '';  // �����
    var $activeBackColor = '';  // ���õ� ���Ͽ����� ����
    var $activeForeColor = '';  // ���õ� ���Ͽ����� �����

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

// Ž���� Ŭ����
class Explorer {
    var $setup         ;
    var $mode    = 0   ;// mode : 0 ::> ���     Ž��
                        //        1 ::> ���丮 Ž��
                        //        2 ::> ����     Ž��
    var $parentdir     ;// ���� ���丮 ����
    var $pathinfor     ;// ���� ���õ� ���丮
    var $fileDown= 'N' ;// ���� �ٿ�ε� ���� ����
    var $itemCnt = 0   ;// ���� ����

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
            // echo '���K.' .basename ($setup->curdir) ;
            // echo '���K.' .dirname ($setup->curdir) ;
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

                $type       = ''; // ���� ���� : ���丮, ����
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

                    $ext        = ''; // ���� Ȯ����
                    $type_name  = ''; // ���� ���¿����� ������ ��Ī
                    $dblClick   = ''; // ���� Ŭ�� �̺�Ʈ�� ���� ��ũ��

                    if ( $type == 'dir' ) {
                        $ext        = ''                ;
                        if ( $file == '.' ) {
                            $type_name  = "���� �� �丮"       ;
                        } else if ( $file == '..' ) {
                            $type_name  = "���� �� �丮"       ;
                        } else {
                            $type_name  = "�� �丮"       ;
                        }
                        $icon_name  = '../images/icon_folder.gif' ;
                        $dblClick   = 'onDblClick="changeDir(\''.$id.'\');"';
                    } else {
                        $ext = getFileExtraName($filePath);
                        $type_name  = "����( $ext )"    ;
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

    // Ž���� ��� ���
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
                echo ('<td align="center" width="80"><B>���ϰ��</B></td>');
                echo ('<td>');
                echo ('<input name="path_infor" id="path_infor" type="text" style="width:100%" value="' . $this->pathinfor . '" readonly>');
                echo ('</td>');
            }
            if ( $setup->display_add_forder ) { 
                echo ('<td align="center" width="70"><B>��������</B></td>');
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
        if ( $setup->display_file            ) { echo "<td align='center' height='20'><b>���ϸ�            </b></td>\n"; }
        if ( $setup->display_type            ) { echo "<td width='100' align='center'><b>����              </b></td>\n"; }
        if ( $setup->display_size            ) { echo "<td             align='center'><b>ũ��              </b></td>\n"; }
        if ( $setup->display_grant           ) { echo "<td             align='center'><b>���� ����         </b></td>\n"; }
        if ( $setup->display_update_time     ) { echo "<td width='150' align='center'><b>�����ð�          </b></td>\n"; }
        if ( $setup->display_access_time     ) { echo "<td             align='center'><b>���� �ð�         </b></td>\n"; }
        if ( $setup->display_inode_time      ) { echo "<td             align='center'><b>���̳�� ���� �ð�</b></td>\n"; }
        echo (' </tr>');
    }
    // Ž���� ǲ�� ���
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

echo 'fileatime ($path): -- �ֱٿ� ���Ͽ� ������ �ð��� ������      ' . date('Y.m.d h:i:s',fileatime ( $path )) . '<BR>';
echo 'filectime ($path): -- ������ ���̳�� ����ð��� �����ɴϴ�   ' . date('Y.m.d h:i:s',filectime ( $path )) . '<BR>';
echo 'filegroup ($path): -- ������ �׷��� �����ɴϴ�                ' . filegroup ( $path ) . '<BR>';
echo 'fileinode ($path): -- ������ ���̳�带 �����ɴϴ�            ' . fileinode ( $path ) . '<BR>';
echo 'filemtime ($path): -- ������ ������ �ð��� �����ɴϴ�         ' . date('Y.m.d h:i:s',filemtime ( $path )) . '<BR>';
echo 'fileowner ($path): -- ������ �����ڸ� �����ɴϴ�              ' . fileowner ( $path ) . '<BR>';
echo 'fileperms ($path): -- ������ ������ �����ɴϴ�                ' . getPerms ( fileperms ( $path ) ). '<BR>';
echo 'filesize  ($path): -- ������ ũ�⸦ �����ɴϴ�                ' . filesize  ( $path ) . '<BR>';

echo 'is_dir          ($path) -- filename �� ���丮���� �ƴ��� �̾߱��ϱ�               : ' . is_dir          ( $path ) . '<BR>';
//echo 'is_executable   ($path) -- filename�� ���డ���� ������ �ƴ��� �̾߱��ϱ�           : ' . is_executable   ( $path ) . '<BR>';
echo 'is_file         ($path) --  filename�� ���� �������� �ƴ��� �̾߱��ϱ�              : ' . is_file         ( $path ) . '<BR>';
echo 'is_link         ($path) --  filename�� �ɺ��� ��ũ���� �ƴ��� �̾߱��ϱ�            : ' . is_link         ( $path ) . '<BR>';
echo 'is_readable     ($path) --  filename�� �б� ������ ������ �ƴ��� �̾߱��ϱ�         : ' . is_readable     ( $path ) . '<BR>';
echo 'is_uploaded_file($path) -- file�� HTTP POST�� ���� ���ε�� ������ �ƴ��� �̾߱��ϱ�: ' . is_uploaded_file( $path ) . '<BR>';
echo 'is_writable     ($path) -- filename�� ���Ⱑ���� ������ �ƴ��� �̾߱��ϱ�           : ' . is_writable     ( $path ) . '<BR>';
echo 'is_writeable    ($path) -- Tells whether the filename is writable                   : ' . is_writeable    ( $path ) . '<BR>';
//echo 'linkinfo        ($path) -- ��ũ ���� ��������                                       : ' . linkinfo        ( $path ) . '<BR>';
echo 'lstat           ($path) -- �����̳� �ɺ��� ��ũ�� ���� ������ ����                  : ' . lstat           ( $path ) . '<BR>';
echo 'realpath        ($path) -- ǥ��ȭ�� ���� ��θ��� ��ȯ�մϴ�                        : ' . realpath        ( $path ) . '<BR>';
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
    // Browser  üũ
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
//    closeDBConnection (); // �����ͺ��̽� ���� ���� ����
?>