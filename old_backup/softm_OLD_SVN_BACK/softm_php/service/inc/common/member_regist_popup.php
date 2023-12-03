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
require_once SERVICE_DIR . '/inc/inner_header.inc'   ; // header
$is_update = LOGIN;
?>
<script language="Javascript1.2" type="text/javascript" src="<?=HTTP_URL?>/service/js/session.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
$(document).ready(function() {
    if (jQuery.browser.msie) {}
<?
    if ( $is_update ) {
?>
//    	alert(argus.mode);
        call('JSON','front.Member','get',
            {p_user_no:<?=USER_NO?>},
            function(xmlDoc){
                var json  = Util.xml2json(xmlDoc);
                if ( json["return"] == '200' ) { // success
//                	alert(json.message); // success
                	var form = $S('wForm');
					Util.domReady(
						function() {
							Form.bind(json.item,$S('wForm')
                                    ,{
                                        user_email:function(form,vv) {
                                            if ( vv ) {
                                                var vvS = vv.split("@");
                                                form.user_email1.value = vvS[0];
                                                form.user_email2.value = vvS[1];
                                                form.s_email_select.value = vvS[1];
                                            }
                                        },
                                        tel:function(form,vv) {
                                            if ( vv ) {
                                                var vvS = vv.split("-");
                                                form.tel1.value = vvS[0];
                                                form.tel2.value = vvS[1];
                                                form.tel3.value = vvS[2];
                                            }
                                        },
                                        birth:function(form,vv) {
                                            if ( vv ) {
                                                form.birth1.value = vv.substr(0,4);
                                                form.birth2.value = parseInt(vv.substr(4,2),10);
                                                form.birth3.value = parseInt(vv.substr(6,2),10);
                                            }
                                        }
                                    }
                                );
						}
					);
//            	    form['re_passwd'].value = form['passwd'].value;
                } else if (json["return"] == '500') {
                    alert(json.message); // error
                }
            }
        );
<?
    }  else {
?>
<?
    }
?>
});
function 실행() {
    if ( $S('wForm').user_email1.value || $S('wForm').user_email2.value )
    {
        $S('wForm').user_email.value = $S('wForm').user_email1.value + '@' + $S('wForm').user_email2.value;
        addClass($S('wForm').user_email,"required");
        addClass($S('wForm').user_email,"email");
    } else {
        $S('wForm').user_email.value = "";
        removeClass($S('wForm').user_email,"required");
        removeClass($S('wForm').user_email,"email");
    }

    if ( $S('wForm').tel1.value != '' || $S('wForm').tel2.value != '' || $S('wForm').tel3.value != ''  )
    {
        addClass($S('wForm').tel1,"required");
        addClass($S('wForm').tel2,"required");
        addClass($S('wForm').tel3,"required");
    } else {
        removeClass($S('wForm').tel1,"required");
        removeClass($S('wForm').tel2,"required");
        removeClass($S('wForm').tel3,"required");
    }

    if ( $S('wForm').passwd_hint.value )
    {
        addClass($S('wForm').passwd_correct,"required");
    } else {
        removeClass($S('wForm').passwd_correct,"required");
    }
    
    if (
        Form.validate( $S('wForm') ,{
            user_email:function(){Effect.twinkle($S('wForm').user_email1).focus()}
        })
    )
    {

        var b = $("#password_change").is(":checked");
        if ( $("#passwd").attr("disabled") ) {
            if ( $S('wForm').passwd.value != $S('wForm').re_passwd.value ) {
                alert("비밀번호와 비밀번호확인이 다릅니다.");
                Effect.twinkle($S('wForm').passwd);
                return false;
            }
        }
    	var exec = false;
<?
    	if ( !$is_update ) {
?>

        	if ( confirm("가입하시겠습니까?") ) {
            	exec = 중복검사();
        	}
<?
    	} else {
?>
    		if ( $S('wForm').passwd.value.trim() ) {
            	if ( confirm("비밀번호를 수정하시겠습니까?") ) {
                	exec = true;
            	}
    		} else {
            	if ( confirm("수정하시겠습니까?") ) {
                	exec = true;
            	}
    		}
<?
    	}
?>
    	if ( exec ) {
    	    // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
            //  call(requestType,className,method,argus,cb,form)
	        call('JSON','front.Member',"<?=!$is_update?'register':'update'?>",
	        	    Form.json($S("wForm"))
	            ,
	            function(xmlDoc){
	                var json  = Util.xml2json(xmlDoc);
	                if ( json["return"] == '200' ) { // success
	                    alert(json.message); // success
                        self.close();
	                } else if (json["return"] == '500') {
	                    alert(json.message); // error
	                }
	            }
	        );
    	}
    }
    return false;
}

var dupCheck = false;
function 중복검사() {
	if ( !$S('wForm').user_id.value ) return false;
	callJSONSync('front.Member','checkDupId',
	    {
	    	p_user_id:$S('wForm').user_id.value.trim()
	    },
	    function(xmlDoc){
	        var json  = Util.xml2json(xmlDoc);
	        if ( json["return"] == '200' ) { // success
//	            alert(json.message); // success
	            dupCheck = true;
	        } else if (json["return"] == '500') {
	            alert(json.message); // error
	            dupCheck = false;
	        }
	    }
	);
	return dupCheck;
}

function 비밀번호변경() {
    var b = $("#password_change").is(":checked");
        $("#passwd").attr("disabled",!b);
        $("#re_passwd").attr("disabled",!b);

    if (b) {
        $("#passwd").focus();
    } else {
        $("#passwd").val("");
        $("#re_passwd").val("");
    }
}

//-->
</script>
<div class="w_pop">
	<div class="w_pop_wrap">
		<p class="tit">+ <?=!$is_update?"회원가입":"회원수정"?></p>
		<div class="join_tb">
<form name="wForm" id="wForm" method="post" onsubmit="return 실행();">
			<table cellpadding="0" cellspacing="0" summary="">
				<caption>회원가입양식</caption>
				<colgroup>
					<col width="30%" />
					<col width="*" />
				</colgroup>
				<tbody>
<?php
$addProp = !$is_update?"":"readonly onfocus='this.blur();'";
$addStyle= !$is_update?"":"border:0px";
?>
				<tr>
					<th scope="row"><label for="j_id"><span class="ind">아이디</span></label></th>
					<td><input type='text' name='user_id' id='user_id' size=100 style='width:200px;<?=$addStyle?>' <?=$addProp?> value='' class='required trim focus alert' maxlength=100 minlength=0 message='아이디를 입력해주세요.' /></td>
				</tr>
				<tr>
					<th scope="row"><label for="j_pw"><span class="ind">비밀번호</span></label></th>
					<td><input type='password' id='passwd' name='passwd' size=50 style='width:200px' value='' class='required trim focus alert' maxlength=15 minlength=4 message='4~15자  이내로 입력하시기 바랍니다.' <?=$is_update?"disabled":""?>/></td>
				</tr>
				<tr>
					<th scope="row"><label for="j_pwc"><span class="ind">비밀번호확인</span></label></th>
					<td><input type='password' id='re_passwd' name='re_passwd' size=50 style='width:200px' value='' class='required trim focus alert' maxlength=15 minlength=4 message='비밀번호확인을 확인해주세요.' <?=$is_update?"disabled":""?>/>
<?
if ( $is_update ) {
?>
                        비밀 번호 변경 <input type="checkbox" value='Y' id="password_change" name="password_change" onClick='비밀번호변경()'>
<?
}
?>
                    </td>
				</tr>
				<tr>
					<th scope="row"><label for="j_name"><span class="ind">이름</span></label></th>
					<td><input type='text' name='user_name' size=20 style='width:200px' value='' class='required trim focus alert' maxlength=20 minlength=0 message='이름를 입력해주세요.' /></td>
				</tr>
				<tr>
					<th scope="row"><label for="j_birth"><span>생년월일</span></label></th>
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
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="j_email"><span>이메일</span></label></th>
					<td class="is">
						<input type='text' name='user_email1' size=50 style='' value='' class='trim focus alert' maxlength=50 minlength=0 message='이메일을 입력해주세요.' />
						&#64;
						<input type="text" name='user_email2' size=50 style='' value='' class='trim focus alert' maxlength=50 minlength=0 message='이메일을 도메인을 입력해주세요.' />
						<select name="s_email_select" onChange="document.wForm.user_email2.value=this.value">
							<option value="" selected >직접입력</option>
							<option value="chol.com"  >chol.com</option>
							<option value="dreamwiz.com"   >dreamwiz.com</option>
							<option value="empal.com"   >empal.com</option>
							<option value="freechal.com"   >freechal.com</option>
							<option value="gmail.com"   >gmail.com</option>
							<option value="hanafos.com"   >hanafos.com</option>
							<option value="hanmail.net"   >hanmail.net</option>
							<option value="hanmir.com"   >hanmir.com</option>
							<option value="hitel.net"   >hitel.net</option>
							<option value="hotmail.com"   >hotmail.com</option>
							<option value="korea.com"   >korea.com</option>
							<option value="lycos.co.kr"   >lycos.co.kr</option>
							<option value="nate.com"   >nate.com</option>
							<option value="naver.com"   >naver.com</option>
							<option value="netian.com"  >netian.com</option>
							<option value="paran.com"   >paran.com</option>
							<option value="yahoo.com"   >yahoo.com</option>
							<option value="yahoo.co.kr"   >yahoo.co.kr</option>
						</select>
                        <input type='text' name='user_email' size=100 style='display:none' value='' class='trim focus alert' maxlength=50 minlength=0 message='이메일입력을 확인해주세요.' />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="j_tel"><span>전화번호</span></label></th>
					<td class="is">
						<select name="tel1" class='number trim focus alert' message='전화번호를 확인해주세요.' >
							<option value="" selected="selected" >국번</option>
							<option value="010" >010</option>
							<option value="011" >011</option>
							<option value="016" >016</option>
							<option value="017" >017</option>
							<option value="018" >018</option>
							<option value="019" >019</option>
						</select> - 
<input name="tel2" style="width:35px" maxlength=4 class='number trim focus alert' message='전화번호를 확인해주세요.'/>-<input type="text" name="tel3" style="width:35px" maxlength=4 class='number trim focus alert' message='전화번호를 확인해주세요.'/>
					</td>
				</tr>
				<tr>
					<th scope="row" style="border-color:#ccc;"><label for="j_hint"><span>비밀번호힌트</span></label></th>
					<td class="hint">
                          <select name="passwd_hint" class="alert focus" style="width:90%;" message="비밀번호힌트를 입력하세요." onchange="this.form.passwd_correct.value='';">
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

						<input type="text" name="passwd_correct" style="width:90%;" class="alert focus" message="비밀번호답변을 입력하세요.">
					</td>
				</tr>
				</tbody>
			</table>
</form>
		</div>
		<div class="j_send"><a href="#" onclick="return 실행();">저장하기</a></div>
	</div>
</div>

<?
require(SERVICE_DIR . "/inc/inner_footer.inc"); // footer
?>