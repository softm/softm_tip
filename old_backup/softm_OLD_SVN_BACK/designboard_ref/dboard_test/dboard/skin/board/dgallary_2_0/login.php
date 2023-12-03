  <table width="300" border="0" cellspacing="0" cellpadding="0" class="text_01" align='center'>
<form action="<?=$baseDir?>login_ok.php" method='POST' onSubmit='return loginFormSubmit(this);'>
    <tr> 
      <td bgcolor="F2F2F2" height="5"></td>
      <td bgcolor="F2F2F2" height="5"></td>
      <td bgcolor="F2F2F2" height="5"></td>
    </tr>
    <tr> 
      <td colspan="3" align="right" height="20"></td>
    </tr>
    <tr align="center"> 
      <td colspan="3" height="30"> 
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                <tr> 
                  <td align="right"><img src="<?=$skinDir?>images/login_id.gif" width="13" height="11"></td>
                  <td width="5">&nbsp;</td>
                  <td align="right"> 
                    <input type="text" name="user_id" class="textarea_01">
                  </td>
                </tr>
                <tr> 
                  <td colspan="3" height="4"></td>
                </tr>
                <tr> 
                  <td align="right"><img src="<?=$skinDir?>images/login_pass.gif" width="49" height="11"></td>
                  <td>&nbsp;</td>
                  <td align="right"> 
                    <input type="password" name="password" class="textarea_01">
                  </td>
                </tr>
              </table>
            </td>
            <td width="5"></td>
            <td><input type='image' src="<?=$skinDir?>images/button_login.gif" width="56" height="45"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td colspan="3" height="20"></td>
    </tr>
    <tr> 
      <td background="<?=$skinDir?>images/bg_view_top.gif" height="3"></td>
      <td background="<?=$skinDir?>images/bg_view_top.gif" height="3"></td>
      <td background="<?=$skinDir?>images/bg_view_top.gif" height="3"></td>
    </tr>
  </table>
  <br>
  <table width="300" border="0" cellspacing="0" cellpadding="0" align='center'>
    <tr> 
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif">&nbsp;</td>
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif" width="68">
      <a href='javascript:history.back();'><img src="<?=$skinDir?>images/button_back.gif" width="68" height="40" border='0'></a></td>
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif" width="118"><?=$a_member_infor_search?><img src="<?=$skinDir?>images/button_find_pass.gif" width="118" height="40" border='0'></a></td>
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif" width="58" ><?=$a_member_register    ?><img src="<?=$skinDir?>images/button_join.gif" width="58" height="40" border='0'      ></a></td>
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif">&nbsp;</td>
    </tr>
</form>
  </table>
