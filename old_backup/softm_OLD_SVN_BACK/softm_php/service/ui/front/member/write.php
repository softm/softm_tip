<?php
// echo $mode;
$addProp = $mode=='reg'?"":"readonly onfocus='this.blur();'";
$addStyle= $mode=='reg'?"":"border:0px";
?>
<form id=wForm name=wForm onsubmit='return <?=$mode=='reg'?"실행":"실행"?>();' AUTOCOMPLETE="OFF">
<table border="0" width="700" bgcolor="#e5e5e5" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td valign="top"><table cellspacing="1" width="700" cellpadding="3" border="0">
      <tr height='30'>
        <td width="22%" height="20" align="left" bgcolor='#F2F2F2'>* 아이디</td>
        <td align="left" bgcolor='#FFFFFF'>
 		  <input type='text' name='user_id' size=100 style='width:200px;<?=$addStyle?>' <?=$addProp?> value='' class='required trim focus alert' maxlength=100 minlength=0 message='아이디를 입력해주세요.' />        
		</td>
        </tr>
      <tr height='30'>
        <td width="22%" height="20" align="left" bgcolor='#F2F2F2'>* 이메일</td>
        <td align="left" bgcolor='#FFFFFF'>
 		  <input type='text' name='user_email' size=100 style='width:200px;' value='' class='required trim focus alert email' maxlength=100 minlength=0 message='이메일을 입력해주세요.' />        
<?php
if ($mode=='reg') {
?>
        <br>주로 사용하시는 이메일로 가입해 주시기 바랍니다.
<?
}
?>
		</td>
        </tr>
      <tr height='30'>
        <td height="9" align="left" bgcolor='#F2F2F2'>* 비밀번호</td>
        <td height="-2" align="left" bgcolor='#FFFFFF'><p><span class="bt">
       <input type='password' name='passwd' size=50 style='width:200px' value='' class='required trim focus alert' maxlength=15 minlength=4 message='4~15자  이내로 입력하시기 바랍니다.' />
        </span>4~15자  이내로 입력하시기 바랍니다.</p></td>
        </tr>
      <tr height='30'>
        <td height="10" align="left" bgcolor='#F2F2F2'>* 비밀번호 확인</td>
        <td height="-1" align="left" bgcolor='#FFFFFF'><span class="bt">
          <input type='password' name='re_passwd' size=50 style='width:200px' value='' class='required trim focus alert' maxlength=15 minlength=4 message='비밀번호확인을 확인해주세요.' />
        </span>비밀번호를  한번 더 입력해 주시기 바랍니다.&#13;</td>
      </tr>
      <tr height='30'>
        <td height="20" align="left" bgcolor='#F2F2F2'>* 이름</td>
        <td height="-1" align="left" bgcolor='#FFFFFF'><span class="bt">
		<input type='text' name='user_name' size=20 style='width:200px' value='' class='required trim focus alert' maxlength=20 minlength=0 message='이름를 입력해주세요.' />
        </span></td>
      </tr>
      
      <tr height='30'>
        <td height="19" align="left" bgcolor='#F2F2F2'>* 비밀번호힌트</td>
        <td height="19" align="left" bgcolor='#FFFFFF'><span class="bt">
       	<input type='text' name='passwd_hint' size=100 style='width:200px' value='' class='required trim focus alert' maxlength=100 message="비밀번호힌트를 입력해주세요."/>
        </span>비밀번호를  잊으셨을 경우 본인 확인을 위한 힌트입니다.&#13;</td>
      </tr>
      <tr height='30'>
        <td height="20" align="left" bgcolor='#F2F2F2'>* 비밀번호정답</td>
        <td height="20" align="left" bgcolor='#FFFFFF'><span class="bt">
       	  <input type='text' name='passwd_correct' size=100 style='width:200px' value='' class='required trim focus alert' maxlength=100 message="비밀번호정답을 입력해주세요."/>
        </span>비밀번호 힌트에 대한 정답을 입력해주세요.</td>
      </tr>
    </table></td>
  </tr>
</table>
<div id="form_btn">
<?php
if (!LOGIN) { // 회원가입
?>
<input type=image src="/images/btn_join2.jpg">
<?
} else {
?>
    <input type=image src="/images/btn_modify.jpg" title="회원정보수정">&nbsp;
	<?
	if ( USER_LEVEL == MEMBER_TYPE_STD ) { 
	?>
	<!--  <input value="기업회원가입" type="button" onclick="document.location.href='<?=MYPAGE_URL?>&mode=company_write';"/> -->
	<input value="기업회원가입" type="button" onclick="document.location.href='/sub.php?flashmenu=11902';"/>
	<?
	} 
	?>
<?php 
}
?>

</div>
</form>
