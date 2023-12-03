<?
/*
 Filename        : /member_findid_popup.php
 Fuction         : 아이디비밀번호 찾기
 Comment         :
 시작 일자       : 2012-05-20,
 수정 일자       : 2010-05-20, v1.0 first
 작 성 자        : 김지훈
 수 정 자        :
 @version        : 1.0
*/
?>
<?
require_once '../../lib/common.lib.inc';
require_once SERVICE_DIR . '/classes/common/Session.php';
require_once SERVICE_DIR . '/classes/common/Util.php';
$memInfor = Session::getSession();
$mode = !$_GET["mode"]?"login":$_GET["mode"];
require_once SERVICE_DIR . '/inc/inner_header.inc'   ; // header
?>
<script language="Javascript1.2" type="text/javascript" src="<?=SERVICE_URL?>/js/session.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function 아이디찾기실행() {
    var invalidCb = {
            //cap_nm:function(){ Effect.twinkle(f.cap_nm);}
    };

    if ( Form.validate( document.wForm1,invalidCb ) )
    {
		callJSONSyncToText('common.Common','findId',
            {
				user_name :document.wForm1.user_name.value,
				tel  	  :document.wForm1.tel1.value + "-" + document.wForm1.tel2.value + "-" + document.wForm1.tel3.value, 
				birth1    :document.wForm1.birth1.value,
				birth2    :document.wForm1.birth2.value,
				birth3    :document.wForm1.birth3.value
            },
            function (v) {
                if( v == "0" ) {
                    alert("일치하는 정보가 존재하지 않습니다.");
                } else {
                    alert("당신의 아이디는 '" + v + "' 입니다.");
                }
            }
        );
    }
    return false;
}

function 비밀번호찾기실행() {
    var invalidCb = {
            //cap_nm:function(){ Effect.twinkle(f.cap_nm);}
    };

    if ( Form.validate( document.wForm2,invalidCb ) )
    {
		callJSONSyncToText('common.Common','findPassSendMail',
            {
				user_id :document.wForm2.user_id.value,
				passwd_hint :document.wForm2.passwd_hint.value,
				passwd_correct :document.wForm2.passwd_correct.value
            },
            function (v) {
				if( v == "1" ) {
                    alert("가입시 등록된 메일로 정보가 발송되었습니다.");
                    self.close();
                } else if( v == "0" ) {
                    alert("가입된 메일정보가 없습니다.");
                } else {
                    alert("메일서버 오류 관리자에게 문의하세요.");
                }
            }
        );
    }
    return false;
}
//-->
</script>
<div class="w_pop">
	<div class="w_pop_wrap">
		<p class="tit">+ 아이디 / 비밀번호찾기</p>
		<p class="tit_find">아이디찾기</p>
		<div class="join_tb">
<form name="wForm1" method="post" onsubmit="return 아이디찾기실행();">		
			<table cellpadding="0" cellspacing="0" summary="">
				<caption>아이디찾기</caption>
				<colgroup>
					<col width="30%" />
					<col width="*" />
				</colgroup>
				<tbody>
				<tr>
					<th scope="row"><label for="user_name"><span class="ind">이름</span></label></th>
					<td><input type="text" name="user_name" style="width:200px" class="required alert focus" message="이름을 입력해주세요."/></td>
				</tr>
				<tr>
					<th scope="row"><label for="fi_phone"><span class="ind">휴대폰번호</span></label></th>
					<td class="is">
						<input type="text" name="tel1" style="width:30px" maxlength="3" class='required number trim focus alert' message='전화번호를 확인해주세요.'/>-<input name="tel2" style="width:35px" maxlength=4 class='required number trim focus alert' message='전화번호를 확인해주세요.'/>-<input type="text" name="tel3" style="width:35px" maxlength=4 class='required number trim focus alert' message='전화번호를 확인해주세요.'/>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="fi_birth"><span class="ind">생년월일</span></label></th>
					<td>
					
<?php
print Util::listBoxElement ("SELECT","birth1", 1900, date("Y"), '',1,date("Y")-20,'');
?>
						년
<?php
print Util::listBoxElement ("SELECT","birth2", 1, 12, '',1,'','');
?>
						월
<?php
print Util::listBoxElement ("SELECT","birth3", 1, 31, '',1,'','');
?>
						일
					</td>
				</tr>
				</tbody>
			</table>
</form>			
		</div>
		
		<div class="j_send"><a href="#" onclick="return 아이디찾기실행();">찾기</a></div>
		
		<p class="tit_find">비밀번호찾기</p>
		<div class="join_tb">
<form name="wForm2" method="post" onsubmit="return 비밀번호찾기실행();">
			<table cellpadding="0" cellspacing="0" summary="">
				<caption>아이디찾기</caption>
				<colgroup>
					<col width="30%" />
					<col width="*" />
				</colgroup>
				<tbody>
				<tr>
					<th scope="row"><label for="user_id"><span class="ind">아이디</span></label></th>
					<td><input type="text"  name="user_id" style="width:200px" class="required alert focus" message="아이디를 입력하세요."/>
					</td>
				</tr>
				<tr>
					<th scope="row" style="border-color:#ccc;"><label for="fp_hint"><span class="ind">비밀번호힌트</span></label></th>
					<td class="hint">
                          <select name="passwd_hint" class="required alert focus" style="width:90%;" message="비밀번호힌트를 입력하세요.">
                            <option value="">선택하십시오.</option>
                            <option value="1">자신의 인생 좌우명은?</option>
                            <option value="2">초등학교 때 기억에 남는 짝꿍 이름은?</option>
                            <option value="3">유년시절 가장 생각나는 친구 이름은?</option>
                            <option value="4">가장 기억에 남는 선생님 성함은?</option>
                            <option value="5">친구들에게 공개하지 않은 어릴 적 별명이 있다면?</option>
                            <option value="6">추억하고 싶은 날짜가 있다면?(예:1994/04/20)</option>
                            <option value="7">다시 태어나면 되고 싶은 것은?</option>
                            <option value="8">가장 감명깊게 본 영화는?</option>
                            <option value="9">읽은 책 중에서 좋아하는 구절이 있다면?</option>
                            <option value="10">기억에 남는 추억의 장소는?</option>
                            <option value="11">인상 깊게 읽은 책 이름은?</option>
                            <option value="12">자신의 보물 제1호는?</option>
                            <option value="13">받았던 선물 중 기억에 남는 독특한 선물은?</option>
                            <option value="14">자신이 두번째로 존경하는 인물은?</option>
                            <option value="15">아버지의 성함은?</option>
                            <option value="16">어머니의 성함은?</option>
                            <option value="17">가장 여행하고 싶은 나라는?</option>
                          </select>

						<input type="text" name="passwd_correct" style="width:90%;" class="required alert focus" message="비밀번호답변을 입력하세요.">
					</td>
				</tr>
				</tbody>
			</table>
</form>			
		</div>
		<div class="j_send"><a href="#" onclick="return 비밀번호찾기실행();">찾기</a>
		 <!--  
		 <a href="#" onclick="self.close();"><img src="<?=HTTP_URL?>images/common/btn_clo.png" alt="창닫기" /></a>
		 -->
		 </div>
	</div>
</div>


<?
require(SERVICE_DIR . "/inc/inner_footer.inc"); // footer
?>