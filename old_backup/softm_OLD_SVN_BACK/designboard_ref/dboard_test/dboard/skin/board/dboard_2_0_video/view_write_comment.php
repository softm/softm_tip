  <table width="<?=$table_width?>" border="0" cellspacing="0" cellpadding="0" class="text_01" align='center'>
<form onSubmit='return writeCommentData(this);' name='writeForm' method='post'>
<!-- 삭제하면 안되요.. -->
  <input type="hidden" name="no" value='<?=$no?>'>
    <tr> 
      <td colspan="2" height="10"></td>
    </tr>
    <tr> 
      <td> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
          <tr>
<?=$hide_name_s?>
            <td width="150">
              이름 
              <input type="text" name="name" class="textarea_01" size="15" value='<?=$name?>'>
            </td>
<?=$hide_name_e?>
<?=$hide_password_s?>
            <td>
              비밀번호 
              <input type="password" name="password" class="textarea_01" size="15">
            </td>
<?=$hide_password_e?>
          </tr>
        </table>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="2" height="10"></td>
    </tr>
    <tr> 
      <td> 
        <textarea name="memo" class="textarea_01" style="width:100%; height:60px"></textarea>
      </td>
      <td align="right" width="70"> 
        <input type="image" border="0" name="imageField3" src="<?=$skinDir?>images/button_cwrite.gif" width="60" height="60" align="middle">
      </td>
    </tr>
</form>
  </table>