<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
<form onSubmit='return askPassword(this);' name='deleteForm' method='POST'>
  <tr>
    <td align="center"> 
      <table width="300" border="0" cellspacing="0" cellpadding="0" class="text_01">
        <tr bgcolor="cccccc"> 
          <td bgcolor="#FFFFFF" align="center"><b><?=$title?></b></td>
        </tr>
        <tr bgcolor="cccccc"> 
          <td bgcolor="#FFFFFF" height="10"></td>
        </tr>
        <tr bgcolor="cccccc"> 
          <td height="2" bgcolor="F5F5F5"></td>
        </tr>
        <tr bgcolor="cccccc"> 
          <td height="1" bgcolor="cccccc"></td>
        </tr>
        <tr> 
          <td align="right" height="20"></td>
        </tr>

        <tr align="center"> 
          <td height="30"> 
<?=$hide_password_s?>            
            <img src="<?=$skinDir?>images/login_pass.gif" width="49" height="11"> 
            <input type="password" name="password" class="textarea_01">
<?=$hide_password_e?>
<input type='image' src="<?=$skinDir?>images/button_ok2.gif" width="41" height="18" align="absmiddle"></td>
        </tr>

        <tr> 
          <td height="20"></td>
        </tr>
        <tr> 
          <td bgcolor="cccccc" height="1"></td>
        </tr>
        <tr> 
          <td bgcolor="F5F5F5" height="2"></td>
        </tr>
      </table>
    </td>
  </tr>
</form>
</table>
