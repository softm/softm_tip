<form id=wForm name=wForm enctype='multipart/form-data' AUTOCOMPLETE='OFF' method='post' onsubmit='return 실행();'>
<input type=hidden name=country_type value="KR">
<!-- <form id=wForm name=wForm enctype='multipart/form-data' method='post' onsubmit='return 파일업로드();'> -->
<!-- <input name='MAX_FILE_SIZE1' type='hidden' value='3' /> -->
<!-- <input type='submit' value='전송'><BR> -->
<!-- <input name='test1' type='text' value='test1'><BR> -->
<!-- <input type='file' name='test_file' id='test_file' style='width:450px'/><BR> -->
<input type='hidden' name='p_consult_no' size=10 value='<?=$p_consult_no?>' style='width:25px'/>
<input type='hidden' name='p_proc_type' size=1 value='<?=$p_proc_type?>' style='width:112px'/>
<input type='hidden' name='p_consult_company_no' size=1 value='<?=$p_consult_company_no?>' style='width:112px'/>
<input type='hidden' name='p_worker_no' size=1 value='' style='width:112px'/>

<span class="p14 b bl06">1. 비즈니스상담신청</span><br/><br/>
<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
  <tr>
   <td width="150" class="bt" id="t1"><span id="pt">*</span> 비즈니스  상담안건</td>
   <td class="bt">
    <input type='text' name='consult_item' size=100 value='' style='width:510px' class='required trim focus alert' maxlength=100 minlength=0 message='비지니스 상담 안건을 입력해주세요.' /><br/><span class="p11 gray09">예)금형부품, 자동자기계 설비부품의 가공 및 수출</span>
    </td>
  </tr>
  <tr>
	<td width="170"  id="t1"><span id="pt">*</span> 희망비즈니스형태</td>
	<td><p>
<?
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'hope_biz_type';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='required trim focus alert' message='희망 비즈니스 형태를 입력해주세요.' class='no-input'"  ;
    $creategory_setup['loop_end_tag'    ] = "&nbsp;"  ;
    $selectInfo = Base::$CODE_BIZ_TYPE;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('RADIO',$selectInfo);
?><BR><span class="p11 gray09">상담안건에 대해서 원하는 비즈니스 형태를 체크(수출을 원할시에 수출에 체크)<br />
		* 중복 불가능하며 복수 일시 비즈니스 상담 안건을 추가하세요.</span>

    </td>
  </tr>
  <tr>
	<td width="170" id="t1"><span id="pt">*</span> 희망비즈니스내용요약</td>
	<td><textarea name="hope_biz" id="hope_biz" cols="45" rows="5" style="width:510px" class='required trim focus alert' message='희망비즈니스내용요약을 입력해주세요.'/></textarea></td>
  </tr>
  <tr>
	<td width="170" id="t1">거래 희망 일본 기업유형</td>
	<td> <input type='text' name='hope_trade_type' size=100 value='' style='width:510px' maxlength=100 /><br /><span class="p11 gray09">대기업, 중소기업</span>	
	</td>
  </tr>
  <tr>
	<td width="170" id="t1"><span id="pt">*</span> 일본 내 자료 공개 기한</td>
	<td>
<?
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'open_limit';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='required trim focus alert' message='공개 기한을 선택해주세요.' class='no-input'"  ;
    $creategory_setup['loop_end_tag'      ] = "&nbsp;"  ;
    $selectInfo = Base::$CODE_DATA_OPEN_LIMIT;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('RADIO',$selectInfo);
?><br /><span class="p11 gray09">* 귀사의 기업 정보가 일본(<a href="www.jk-bic.jp" target="_blank">www.jk-bic.jp</a>)에 공개되는 기간입니다.</span>
    </td>
  </tr>
  <tr>
	<td width="170" id="t1">기타 의견 및 문의사항</td>
	<td> <textarea name="etc_question" id="etc_question" cols="45" rows="5" style="width:510px"/></textarea></td>
  </tr>
  <tr>
	<td width="170" id="t1">제품사진</td>
	<td><input type="file" name="file1"/>&nbsp;<SPAN id=file1_infor></SPAN></td>
  </tr>
  <tr>
	<td width="170" id="t1">제품소개서</td>
	<td><input type="file" name="file2"/>&nbsp;<SPAN id=file2_infor></SPAN></td>
  </tr> 
  <tr>
	<td width="170" id="t1">기타</td>
	<td><input type="file" name="file3"/>&nbsp;<SPAN id=file3_infor></SPAN></td>
  </tr>
    
</table></td>
</tr>
</table><br/><br />

<span class="p14 b bl06">2. 담당자 정보</span><br /><br />
<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
  <tr>
	<td width="80" id="t1" class="bt" rowspan="3" >담당자</td>
	<td class="bt" id="t1" width="90"><span id="pt">*</span> 한글</td>
	<td class="bt"><input type='text' name='nm_kr' size=50 value='' style='width:150px' class='required trim focus alert' maxlength=50 minlength=0 message='담당자 한글를 입력해주세요.' /></td>
 	<td width="300" rowspan="3" class="bt" style="border-left:1px solid #ddd;"><span class="p11 gray09">한글 및 영문은 필수 입력사항임<br />
    '한자 이름'이 없으실 경우 '없음'이라고 기재 해 주시기 바랍니다.</span></td>
	
  </tr>
  <tr>
	<td id="t1"><span id="pt">*</span> 영문</td>
	<td><input type='text' name='nm_en' size=50 value='' style='width:150px' class='required trim focus alert' maxlength=50 minlength=0 message='담당자 영문를 입력해주세요.' /></td>
  </tr>
  <tr>
	<td id="t1">한자</td>
	<td><input type='text' name='nm_hj' size=50 value='' style='width:150px' maxlength=50 /></td>
  </tr>
  <tr>
	<td colspan="2" id="t1"><span id="pt">*</span> 부서</td>
	<td colspan=2><input type="text" name="dept" id="dept" style="width:510px" class='required trim focus alert' message='부서를 확인해주세요.'/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1"><span id="pt">*</span> 직위</td>
	<td colspan=2><input type="text" name="position" id="position" style="width:510px" class='required trim focus alert' message='직위를 확인해주세요.'/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1"><span id="pt">*</span> 이메일</td>
	<td colspan=2><input type='text' name='email' size=100 value='' style='width:510px' class='required email trim focus alert' maxlength=100 minlength=0 message='이메일를 입력해주세요.' /></td>
  </tr>
  <tr>
	<td colspan="2" id="t1"><span id="pt">*</span> 전화번호</td>
    <td colspan=2><input type="text" name="tel1" style="width:30px" maxlength="3" class='required number trim focus alert' message='전화번호를 확인해주세요.'/>-<input name="tel2" style="width:35px" maxlength=4 class='required number trim focus alert' message='전화번호를 확인해주세요.'/>-<input type="text" name="tel3" style="width:35px" maxlength=4 class='required number trim focus alert' message='전화번호를 확인해주세요.'/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1"><span id="pt">*</span> 휴대폰</td>
    <td colspan=2><input type="text" name="hp1" style="width:30px" maxlength=3 class='required number trim focus alert' message='휴대폰번호를 확인해주세요.'/>-<input name="hp2" style="width:35px" maxlength=4 class='required number trim focus alert' message='휴대폰번호를 확인해주세요.'/>-<input type="text" name="hp3" style="width:35px" maxlength=4 class='required number trim focus alert' message='휴대폰번호를 확인해주세요.'/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">FAX</td>
    <td colspan=2><input type="text" name="fax1" style="width:30px" maxlength=3/>-<input name="fax2" style="width:35px" maxlength=4/>-<input type="text" name="fax3" style="width:35px" maxlength=4/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">대응가능외국어</td>
	<td colspan=2>
<?
	unset(Base::$CODE_POSSIBLE_LANG[KR]);
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'possible_lang[]';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='no-input'"  ;
    $creategory_setup['loop_end_tag'      ] = "&nbsp;"  ;
    $selectInfo = Base::$CODE_POSSIBLE_LANG;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('CHECKBOX',$selectInfo);
?>
    </td>
  </tr>
</table>
<?php 
if ( $p_proc_type == PROC_TYPE_BM ) { 
?>
<br>
<span class="p14 b bl06">3.대응방안</span><br/><br/>
<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
  <tr>
   <td width="700" class="bt"><textarea name="action_plan" cols="45" rows="5" style="width:650px"/></textarea></td>
  </tr>
</table>
<?php 
} 
?>
<div id="form_btn">
<?
if ( !$p_consult_no ) {
?>
    <input type=image src="/images/btn_form_apply.jpg" value="신청하기"/>
<?
} else {
?>
<input type=image src="/images/btn_modify.jpg"/>
<a href="#" title="삭제하기" onclick="return 삭제('<?=$p_consult_no?>')"><img src="/images/btn_del.jpg" /></a>
<a href="#" onclick="mypageList();" title="목록보기" id=btn_list  ><img src="/images/btn_list.jpg" /></a>
<?
}
?>
</div>
</form>