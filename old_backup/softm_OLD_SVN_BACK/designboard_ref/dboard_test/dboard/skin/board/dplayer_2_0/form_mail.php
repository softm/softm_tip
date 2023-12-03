<form onSubmit='return sendMail(this);' name='writeForm' method='POST' action=''>
    <table width="500" border="0" cellspacing="0" cellpadding="0">
      <tr> 
        <td width="17" height="17"><img src="<?=$baseDir?>images/join_01.gif" width="17" height="17"></td>
        <td background="<?=$baseDir?>images/join_bg01.gif"></td>
        <td width="17" height="17"><img src="<?=$baseDir?>images/join_02.gif" width="17" height="17"></td>
      </tr>
      <tr> 
        <td background="<?=$baseDir?>images/join_bg02.gif"></td>
        <td> 
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td class="text_01" height="10"></td>
            </tr>
            <tr> 
              <td class="text_01"><b>폼메일 발송 </b>: <font color='BF0909'><?=$to_name?> </font>
                회원님께 메일을 발송합니다.</td>
            </tr>
          </table>
          <br>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td bgcolor="efefef" height="1"></td>
            </tr>
          </table>
          <br>
          <table width="100%" border="0" cellspacing="0" cellpadding="5" style="table-layout:fixed">
          <thead>
          <colgroup>
          <col width="80"/>
          <col width=""/>
          </colgroup>
          </thead>
            <tr bgcolor="fafafa"> 
              <td colspan="2" align="right" height="1" background="<?=$baseDir?>images/bg2.gif" class="bg_line2"></td>
            </tr>
            <tr bgcolor="fafafa"> 
              <td width="150" align="right" class="text_01"><b>받는사람</b></td>
              <td class='text_01'>
              <?=$character?>
              <?=$to_name?> [<?=$to_mail?>]
              </td>
            </tr>
            <tr bgcolor="fafafa"> 
              <td colspan="2" align="right" height="1" background="<?=$baseDir?>images/bg2.gif" class="bg_line2"></td>
            </tr>
            <tr bgcolor="fafafa"> 
              <td align="right" class="text_01"><b>이메일</b></td>
              <td> 
                  <input type="text" name="from_mail" size="49" value="<?=$from_mail?>">
              </td>
            </tr>
            <tr> 
              <td colspan="2" height="1" bgcolor="fafafa" background="<?=$baseDir?>images/bg2.gif" class="bg_line2"></td>
            </tr>
            <tr bgcolor="fafafa"> 
              <td align="right" class="text_01"><b>이름</b></td>
              <td> 
                  <input type="text" name="from_name" size="49" value="<?=$from_name?>">
              </td>
            </tr>
            <tr bgcolor="fafafa"> 
              <td align="right" colspan="2" height="1" background="<?=$baseDir?>images/bg2.gif" class="bg_line2"></td>
            </tr>
            <tr bgcolor="fafafa"> 
              <td align="right" class="text_01"><b>제목</b></td>
              <td> 
                  <input type="text" name="title" size="49" value="">
              </td>
            </tr>
            <tr bgcolor="fafafa"> 
              <td align="right" colspan="2" height="1" background="<?=$baseDir?>images/bg2.gif" class="bg_line2"></td>
            </tr>
            <tr bgcolor="fafafa"> 
              <td align="right" class="text_01"><b>내 용</b></td>
              <td> 
                <textarea name="content" rows="15" style='width:100%'></textarea>
              </td>
            </tr>
            <tr bgcolor="fafafa"> 
              <td align="right" colspan="2" height="1" background="<?=$baseDir?>images/bg2.gif" class="bg_line2"></td>
            </tr>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td height="10"></td>
            </tr>
            <tr> 
              <td align="right">
                <input type='image' src="<?=$baseDir?>images/button_email.gif" width="79" height="30" align="absmiddle"> 
                <a href='#' onClick='self.close();'>
                  <img src="<?=$baseDir?>images/button_close.gif" width="66" height="30" align="absmiddle" border='0'> 
                </a>
              </td>
            </tr>
          </table>
        </td>
        <td background="<?=$baseDir?>images/join_bg03.gif"></td>
      </tr>
      <tr> 
        <td width="17" height="17"><img src="<?=$baseDir?>images/join_03.gif" width="17" height="17"></td>
        <td background="<?=$baseDir?>images/join_bg04.gif" height="17"></td>
        <td width="17" height="17"><img src="<?=$baseDir?>images/join_04.gif" width="17" height="17"></td>
      </tr>
    </table>
</form>
