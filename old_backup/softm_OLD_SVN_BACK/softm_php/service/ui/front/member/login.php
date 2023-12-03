<form id=wForm name=wForm onsubmit='return 실행();'>
<input type='hidden' name='back' value='<?print (BACKURL?BACKURL:'/sub.php?contents=config&load=cfg_index&usemode=index');?>'>
<input id="direct" name="direct" type="hidden" value="" />
<input id="url" name="url" type="hidden" value="/" />
<table cellspacing="0" cellpadding="0" border="0" width="100%">
  <tbody><tr>
    <td><table cellspacing="0" cellpadding="0" border="0" width="450" align="center">
        <tbody>
        <tr>
          <td>
			<div class="login clear">
				<div class="log_box">
					<div>
						<table cellpadding="0" cellspacing="0">
							<colgroup>
								<col width="40%" />
								<col width="*" />
							</colgroup>
							<tbody>
							<tr>
								<th scope="row"><label for="log_id">아이디</label></th>
								<td><input type="text" name="user_id"  value="<?=$_COOKIE["user_id"]?>" class="required trim focus alert" maxlength=100 minlength=0 message="아이디를 입력하세요."/></td>
							</tr>
							<tr>
								<th scope="row"><label for="log_pw">비밀번호</label></th>
								<td><input type="password" name="passwd" maxlength="12" class="required focus" message="비밀번호를 입력하세요."/></td>
							</tbody>
						</table>
					</div>
					<a href="#" class="btn_log" onclick='return 실행();'>로그인</a>
				</div>
				<div class="join">
					<a href="#" class="btn_join" onclick="return 회원정보팝업()">회원가입하기</a><!-- 윈도우팝업연결 사이즈 510*415-->
					<a href="#" class="btn_find" onclick="return 아이디비밀번호찾기팝업()">아이디/비밀번호분실</a><!-- 윈도우팝업연결 사이즈 510*500 -->
				</div>
			</div>
           </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </tbody></table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</tbody></table>

</form>

