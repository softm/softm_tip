<form id=wForm name=wForm onsubmit='return 가입하기();' AUTOCOMPLETE="OFF">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="reg_box">
    <tr>
        <td>PareLink메인로고<BR>Connect
your parenting network<BR>
        </td>
        <td>
        <table>
        <tr>
            <td>PareLink에서<BR>나와 같은 고민을 하는 부모를 만나세요</td>
        </tr>
        <tr>
            <td><input size="40" id='user_name' name='user_name' type="text" <?=BROWSER=="msie"?"value='이름'":""?> backvalue="이름" class="backvalue" placeholder="이름"/></td>
        </tr>
        <tr>
            <td><input size="40" id='user_id' name='user_id' type="text" <?=BROWSER=="msie"?"value='이메일'":""?> backvalue="이메일" class="backvalue" placeholder="이메일"/></td>
        </tr>
        <tr>
            <td><input size="40" maxlength="25" id='passwd' name='passwd' type="password" <?=BROWSER=="msie"?"value=''":""?> backvalue="비밀번호" class="backvalue" placeholder="비밀번호"/></td>
        </tr>
        <tr>
            <td><input value="가입하기" type="submit"/></td>
        </tr>

        </table>
        </td>
    </tr>
    </table>
</form>