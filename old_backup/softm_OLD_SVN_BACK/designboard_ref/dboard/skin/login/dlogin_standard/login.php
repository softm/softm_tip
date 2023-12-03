  <table width="350" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr> 
        <td width="17" height="17"><img src="<?=$loginSkinDir?>images/co_01.gif" width="17" height="17"></td>
        <td background="<?=$loginSkinDir?>images/bg01.gif"></td>
        <td width="17" height="17"><img src="<?=$loginSkinDir?>images/co_02.gif" width="17" height="17"></td>
    </tr>
    <tr> 
        <td background="<?=$loginSkinDir?>images/bg02.gif"></td>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                    <td height="20"></td>
                </tr>
                <tr> 
                    <td> 
                        <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr> 
                                <td align="right" class="text_01">아이디</td>
                                <td width="5"></td>
                                <td width="120"> 
                                    <input type="text" name="user_id" class="textarea_01" size="20" tabindex=1 value='<?=$user_id?>'>
                                </td>
                                <td width="5" rowspan="3"></td>
                                <td rowspan="3">
                                <input type='image' src="<?=$loginSkinDir?>images/button_login.gif" width="56" height="45" tabindex=4></td>
                            </tr>
                            <tr> 
                                <td height="2" colspan="3" align="right"></td>
                            </tr>
                            <tr> 
                                <td align="right" class="text_01">비밀번호</td>
                                <td width="5">&nbsp;</td>
                                <td width="120"> 
                                    <input type="password" name="password" class="textarea_01" size="20" tabindex=2>
                                </td>
                            </tr>
                            <tr> 
                                <td align="right" class="text_01">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td width="120" class="text_01"> 
                                    <input type="checkbox" name="save_id" value="Y" tabindex=3>
                                    아이디기억하기 </td>
                                <td></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr> 
                                <td colspan="5" align="right" class="text_01"> 
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr> 
                                            <td height="8"></td>
                                        </tr>
                                        <tr> 
                                            <td height="1" background="<?=$loginSkinDir?>images/dot_01.gif"></td>
                                        </tr>
                                        <tr> 
                                            <td height="8"></td>
                                        </tr>
                                        <tr> 
                                            <td align="center" class="text_01">
                                            <strong><?=$a_member_register?>&bull; 무료회원가입</a> <?=$a_member_infor_search?>&bull; 아이디/비밀번호분실</a></strong></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr> 
                    <td height="10"></td>
                </tr>
            </table>
        </td>
        <td background="<?=$loginSkinDir?>images/bg03.gif"></td>
    </tr>
    <tr> 
        <td width="17" height="17"><img src="<?=$loginSkinDir?>images/co_03.gif" width="17" height="17"></td>
        <td background="<?=$loginSkinDir?>images/bg04.gif" height="17"></td>
        <td width="17" height="17"><img src="<?=$loginSkinDir?>images/co_04.gif" width="17" height="17"></td>
    </tr>

</table>
