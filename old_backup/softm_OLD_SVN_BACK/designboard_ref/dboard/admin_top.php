<?
        echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" );
        echo ( "    var driver  = '".$sysInfor['driver']."';\n");
        echo ( "\n</SCRIPT>\n" );
?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="321"><a href="<?=$baseDir?>admin_setup.php"><img src="<?=$baseDir?>images/logo.gif" width="321" height="70" border="0"></a></td>
                <td width="732" valign="bottom" align="right">관리자 아이디 : <b class="text_03"><font color="#990000"><?=$memInfor['user_id']?></font></b> 
                  &nbsp;l&nbsp; <a href="<?=$baseDir?>logout_ok.php?back=admin.php">로그아웃</a> ㅣ 
                  <a href="#" onClick="window.open('<?=$baseDir?>admin/admin_db_converter.php','db_converter','toolbar=no,menubar=no,resizable=yes,scrollbars=no,top=0,left=0,width=900,height=420');">백업자료 복구</a> ㅣ 
                  <a href="<?=$baseDir?>uninstall.php">디자인보드삭제</a>
                  </td>
                <td>&nbsp;</td>
              </tr>
            </table>
          