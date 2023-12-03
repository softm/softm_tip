<table width="170" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="17" height="17"><img src="<?=$loginSkinDir?>images/join_01.gif" width="17" height="17"></td>
    <td background="<?=$loginSkinDir?>images/join_bg01.gif">&nbsp;</td>
    <td width="17" height="17"><img src="<?=$loginSkinDir?>images/join_02.gif" width="17" height="17"></td>
  </tr>
  <tr> 
    <td background="<?=$loginSkinDir?>images/join_bg02.gif">&nbsp;</td>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#FFFFFF">
              <tr> 
                <td align="right" class="login_text_01" width="50">아이디</td>
                <td>
                <input type="text" name="user_id" size="12" class="textarea_01" value='<?=$user_id?>' tabindex=1 style="width:65%">
                </td>
              </tr>
              <tr> 
                <td align="right" class="login_text_01">비밀번호</td>
                <td> 
                  <input type="password" name="password" size="12" class="textarea_01"  tabindex=2 style="width:65%">
                </td>
              </tr>
              <tr> 
                <td bgcolor="#FFFFFF" align="right" height="10" colspan="2"> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="login_text_01">
                    <tr> 
                      <td colspan="3" align="right" height="5"></td>
                    </tr>
                    <tr> 
                      <td colspan="3" align="right" height="1" background="<?=$loginSkinDir?>images/bg2.gif" class="bg_line2"></td>
                    </tr>
                    <tr> 
                      <td colspan="3" align="right" height="2"></td>
                    </tr>
                    <tr align="right"> 
                      <td colspan="3" class="login_text_01"> 
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td rowspan="2" align="right"> 
                               <input type="checkbox" name="save_id" value="Y">  <!-- 자동 로그인 -->
                            </td>
                            <td height="2"></td>
                          </tr>
                          <tr> 
                            <td class="login_text_01" height="15" width="55" align="right">아이디저장</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr> 
                      <td align="right" colspan="3" height="2"></td>
                    </tr>
                    <tr> 
                      <td align="right">
                      <input type='image' src="<?=$loginSkinDir?>images/login.gif" align='absmiddle' tabindex=3>
                      </td>
                      <td width="11">&nbsp;</td>
                      <td> 
                        <?=$a_member_register?><img src="<?=$loginSkinDir?>images/join.gif" align='absmiddle' width="61" height="21" border='0'></a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td background="<?=$loginSkinDir?>images/join_bg03.gif">&nbsp;</td>
  </tr>
  <tr> 
    <td width="17" height="17"><img src="<?=$loginSkinDir?>images/join_03.gif" width="17" height="17"></td>
    <td background="<?=$loginSkinDir?>images/join_bg04.gif"></td>
    <td width="17" height="17"><img src="<?=$loginSkinDir?>images/join_04.gif" width="17" height="17"></td>
  </tr>
</table>
