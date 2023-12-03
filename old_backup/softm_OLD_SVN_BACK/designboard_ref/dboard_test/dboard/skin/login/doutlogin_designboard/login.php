            <table width="200" border="0" cellspacing="0" cellpadding="0" height="116" background="<?=$loginSkinDir?>images/bg_main10.gif">
              <tr> 
<form action="<?=$baseDir?>login_ok.php" method='POST' onSubmit='return loginFormSubmit(this);'>
                <td height="22"></td>
              </tr>
              <tr> 
                <td valign="top"> 
                  <table width="201" border="0" cellspacing="0" cellpadding="2">
                  <colgroup>
                  <col width="100"/>
                  <col/>
                  </colgroup>
                    <tr> 
                      <td align="right"> <img src="<?=$loginSkinDir?>images/id.gif" width="14" height="12">
<input type="text" name="user_id" size="14" class="textarea_02" value='<?=$user_id?>' tabindex=1 style="width:75%">
                      </td>
                      <td rowspan=2 width="15">
                      <input type='image' src="<?=$loginSkinDir?>images/button_login.gif" width="41" height="41" align='absmiddle'  tabindex=3>
                      </td>
                    </tr>
                    <tr> 
                      <td align="right"> <img src="<?=$loginSkinDir?>images/pass.gif" width="25" height="12">
<input type="password" name="password" size="14" class="textarea_02"  tabindex=2 style="width:75%">
                      </td>
                    </tr>
                    <tr> 
                      <td align="right" colspan="2">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td align="right"> 
                              <input type="checkbox" name="save_id" value="Y">  <!-- 자동 로그인 -->
                            </td>
                            <td align="right" background="<?=$loginSkinDir?>images/a_login.gif" width="90">&nbsp; 
                            </td>
                            <td width="10"></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr> 
                <td height="15" valign="top"> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="15" height="1"></td>
                      <td background="<?=$loginSkinDir?>images/dot_01.gif" height="1"><img src="<?=$loginSkinDir?>images/timg.gif" width="1" height="1"></td>
                      <td width="15" height="1"></td>
                    </tr>
                  </table>
                </td>
</form>
              </tr>
            </table>
