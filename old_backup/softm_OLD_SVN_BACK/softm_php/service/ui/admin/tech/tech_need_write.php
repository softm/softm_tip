<form id=wForm name=wForm enctype='application/x-www-form-urlencoded' AUTOCOMPLETE='OFF' method='post' onsubmit='return 실행();'>
<!-- <form id=wForm name=wForm enctype='multipart/form-data' method='post' onsubmit='return 실행();'> -->
<input type='hidden' name='p_consult_no' size=10 value='<?=$p_consult_no?>'/><BR>
<input type='hidden' name='p_proc_type' size=10 value='<?=PROC_TYPE_NC?>'/><BR>

<table border="0" cellpadding="0" cellspacing="0" id="admin" width="100%">
        <tr>
          <td width="150" class="bt" id="t1" colspan="2" >니즈코드</td>
          <td class="bt"><input type='text' name='reg_code' size=14 value='' style='width:530px;border:0px' readonly/></td>
        </tr>
        <tr>
          <td  colspan="2"   id="t1" >노출여부</td>
          <td>
          <input type="radio" name='open_yn' value='Y' />노출
          <input type="radio" name='open_yn' value='N' />  비노출</td>
        </tr>
        <tr>
          <td  colspan="2"   id="t1" >처리상황</td>
          <td>
<?
    unset($creategory_setup);
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'state';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = ""  ;
    $creategory_setup['loop_end_tag'    ] = ""  ;
    $creategory_setup['append_tag'      ] = '';
    $selectInfo = Base::$CODE_STATE_NC;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('SELECT',$selectInfo);
?>
          </td>
        </tr>
        
</table>
<br/><br/>
	
<span class="p14 b bl06">1. 원하는 기술</span><br/><br/>
<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
  <tr>
    <td width="170" class="bt" id="t1"><span id="pt">*</span> 분야</td>
    <td class="bt">
<span id=area_tech_l_cat><select name=s_l_cat><option>1차카테고리</option></select></span>
<span id=area_tech_m_cat><select name=s_m_cat><option>2차카테고리</option></select></span>
<span id=area_tech_s_cat><select name=s_s_cat><option>3차카테고리</option></select></span>    
    </td>
  </tr>
    <tr>
	<td id="t1"><span id="pt">*</span> 기술명</td>
	<td><input type="text" name="tech_nm" style="width:510px" class='required trim focus alert' maxlength=100 minlength=0 message='기술명을 입력해주세요.'/></td>
  </tr>
    <tr>
	<td id="t1"> 기술명(일문)</td>
	<td><input type="text" name="tech_nm_jp" style="width:510px" maxlength=100 minlength=0/></td>
  </tr>
    <tr>
	<td id="t1"><span id="pt">*</span> 기술내용</td>
	<td><input type="text" name="tech_content" style="width:510px" class='required trim focus alert' message='기술내용을 입력해주세요.'/></td>
  </tr>
    <tr>
	<td id="t1"> 기술내용(일문)</td>
	<td><input type="text" name="tech_content_jp" style="width:510px" /></td>
  </tr>
  <tr>
    <td id="t1"><span id="pt">*</span> 기술설명</td>
	<td><textarea name="tech_comment" cols="45" rows="5" style="width:510px" class='required trim focus alert' message='기술설명을 입력해주세요.'/></textarea></td>
  </tr>
  <tr>
    <td id="t1"> 기술설명(일문)</td>
	<td><textarea name="tech_comment_jp" cols="45" rows="5" style="width:510px"/></textarea></td>
  </tr>
  <tr>
    <td id="t1"><span id="pt">*</span> 거래 희망 유형</td>
    <td>
<?
    unset($creategory_setup);
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'trade_hope_type';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='required alert no-input' message='거래 희망 유형을 선택해주세요.'"  ;
    $creategory_setup['loop_end_tag'    ] = ""  ;
    $creategory_setup['append_tag'      ] = '<input type="text" name="trade_hope_type_etc" style="width:120px" disabled/>';
    $selectInfo = Base::$CODE_TECH_TRADE_HOPE_TYPE;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('RADIO',$selectInfo);
?>
  </td>
  </tr>
   <tr>
	<td id="t1"><span id="pt">*</span> 키워드</td>
	<td><input type='text' name='keyword' size=100 value='' style='width:510px' maxlength=100 class='required trim focus alert' message='키워드를 입력해주세요.'/></td>
  </tr>
   <tr>
	<td id="t1"> 키워드(일문)</td>
	<td><input type='text' name='keyword_jp' size=100 value='' style='width:510px' maxlength=100/></td>
  </tr>
</table><br /><br />
<span class="p14 b bl06">2. 담당자 정보</span><br /><br />
<input type='hidden' name='p_worker_no' size=10 value=''/><BR>

<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
  <tr>
	<td width="80" id="t1" class="bt" rowspan="3" >담당자</td>
	<td class="bt" id="t1" width="90"><span id="pt">*</span>한글</td>
	<td class="bt"><input type='text' name='nm_kr' size=50 value='' style='width:510px' class='required trim focus alert' maxlength=50 minlength=0 message='담당자 한글를 입력해주세요.' /></td>
  </tr>
  <tr>
	<td id="t1">영문</td>
	<td><input type='text' name='nm_en' size=50 value='' style='width:510px' maxlength=50 minlength=0/></td>
  </tr>
  <tr>
	<td id="t1">한자</td>
	<td><input type='text' name='nm_hj' size=50 value='' style='width:510px' maxlength=50 /></td>
  </tr>
  <tr>
	<td colspan="2" id="t1"><span id="pt">*</span>부서</td>
	<td><input type="text" name="dept" id="dept" style="width:510px" class='required trim focus alert' maxlength=50 minlength=0 message='부서를 입력해주세요.'/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1"><span id="pt">*</span>직위</td>
	<td><input type="text" name="position" id="position" style="width:510px" class='required trim focus alert' maxlength=50 minlength=0 message='직위를 입력해주세요.'/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1"><span id="pt">*</span>이메일</td>
	<td><input type='text' name='email' size=100 value='' style='width:510px' class='required email trim focus alert' maxlength=100 minlength=0 message='이메일를 입력해주세요.' /></td>
  </tr>
  <tr>
	<td colspan="2" id="t1"><span id="pt">*</span>전화번호</td>
    <td><input type="text" name="tel1" style="width:30px" maxlength="3" class='required number trim focus alert' message='전화번호를 확인해주세요.'/>-<input name="tel2" style="width:35px" maxlength=4 class='required number trim focus alert' message='전화번호를 확인해주세요.'/>-<input type="text" name="tel3" style="width:35px" maxlength=4 class='required number trim focus alert' message='전화번호를 확인해주세요.'/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1"><span id="pt">*</span>휴대폰</td>
    <td><input type="text" name="hp1" style="width:30px" maxlength=3 class='required number trim focus alert' message='휴대폰번호를 확인해주세요.'/>-<input name="hp2" style="width:35px" maxlength=4 class='required number trim focus alert' message='휴대폰번호를 확인해주세요.'/>-<input type="text" name="hp3" style="width:35px" maxlength=4 class='required number trim focus alert' message='휴대폰번호를 확인해주세요.'/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">FAX</td>
    <td><input type="text" name="fax1" style="width:30px" maxlength=3/>-<input name="fax2" style="width:35px" maxlength=4/>-<input type="text" name="fax3" style="width:35px" maxlength=4/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">대응가능외국어</td>
	<td>
<?
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'possible_lang[]';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='no-input'"  ;
    $creategory_setup['loop_end_tag'      ] = "&nbsp;"  ;
    $creategory_setup['append_tag'      ] = '';
    unset(Base::$CODE_POSSIBLE_LANG[KR]);
    $selectInfo = Base::$CODE_POSSIBLE_LANG;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('CHECKBOX',$selectInfo);
?>
    </td>
  </tr>
</table>
<br />
<?
if (!$p_consult_no) {
?>
<div id="form_btn">
	<input type=image src="/images/btn_form_apply.jpg" style="vertical-align:middle" title="신청하기"/>  
</div>
<?
} else {
?>
<div id="form_btn">
<a href="#" title="메일발송"><img src="/images/btn_mail.jpg" /></a>
<input type=image title="정보수정" src="/images/btn_modify.jpg"/>
<a href="#" title="삭제하기" onclick="return 삭제();"><img src="/images/btn_del.jpg" /></a>
<a href="#" title="목록보기" onclick="return 목록();"><img src="/images/btn_list.jpg" /></a>
</div>
<?
}
?>
<br /><br /><br />
</form>