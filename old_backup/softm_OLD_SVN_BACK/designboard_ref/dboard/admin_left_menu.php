<?
    $libDir = $baseDir . "admin/lib/" . $sysInfor['driver'] . '/';
    echo "<iframe name='_dbbackup' src='". $libDir ."admin_db_back_up.php' style='display:none'></iframe>\n";
?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td bgcolor="CCCCCC" height="1"></td>
              </tr>
              <tr>
                <td height="45"><a href="<?=$baseDir?>admin_board.php"><img src="<?=$baseDir?>images/button_01.gif" width="200" height="42" border="0"></a></td>
              </tr>
              <tr>
                <td>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td bgcolor="CCCCCC" height="1"></td>
                    </tr>
                    <tr>
                      <td bgcolor="FFFFFF" height="1"></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td height="45"><a href="<?=$baseDir?>admin_member.php"><img src="<?=$baseDir?>images/button_02.gif" width="200" height="42" border="0"></a></td>
              </tr>

              <tr>
                <td>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td bgcolor="CCCCCC" height="1"></td>
                    </tr>
                    <tr>
                      <td bgcolor="FFFFFF" height="1"></td>
                    </tr>
                  </table>
                </td>
              </tr>

              <tr>
                <td height="45"><a href="<?=$baseDir?>admin_login.php"><img src="<?=$baseDir?>images/button_05.gif" width="200" height="42" border="0"></a></td>
              </tr>
              <tr>
                <td bgcolor="EAE3CF">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td bgcolor="CCCCCC" height="1"></td>
                    </tr>
                    <tr>
                      <td bgcolor="FFFFFF" height="1"></td>
                    </tr>
                  </table>
                </td>
              </tr>

              <tr>
                <td height="45"><a href="<?=$baseDir?>admin_poll.php"><img src="<?=$baseDir?>images/button_03.gif" width="200" height="42" border="0"></a></td>
              </tr>
              <tr>
                <td bgcolor="EAE3CF">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td bgcolor="CCCCCC" height="1"></td>
                    </tr>
                    <tr>
                      <td bgcolor="FFFFFF" height="1"></td>
                    </tr>
                  </table>
                </td>
              </tr>

              <tr>
                <td height="45"><a href="<?=$baseDir?>admin_event.php"><img src="<?=$baseDir?>images/button_04.gif" width="200" height="42" border="0"></a></td>
              </tr>
              <tr>
                <td bgcolor="EAE3CF">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td bgcolor="CCCCCC" height="1"></td>
                    </tr>
                    <tr>
                      <td bgcolor="FFFFFF" height="1"></td>
                    </tr>
                  </table>
                </td>
              </tr>

            </table>

<?
//if ( $branch != 'exec' ) {
 // /skin 디렉토리에서 디렉토리를 구함
	$addonName = "addon";
	$installDir = $baseDir . $addonName;
    if ( is_dir ($installDir) ) {
        $handle = opendir($installDir);
        while ( $dir_info = readdir($handle) ) {
            $scdDir   = $baseDir . $addonName;
            $goalsDir = $scdDir;
            if(!eregi("\.",$dir_info)) {
                $installDir = substr($dir_info,1) . 'Dir';
//              echo $installDir;
                $scdDir   .= '/' . $dir_info . '/';
                $$installDir = $scdDir;
                if ( is_file($$installDir . 'admin_left_menu.php') ) {
                    include $$installDir . 'admin_left_menu.php';
                }
            }
        }
        closedir($handle);
    }
//}
?>