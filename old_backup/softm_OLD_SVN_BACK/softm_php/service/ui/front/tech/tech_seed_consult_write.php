<form id=wForm name=wForm method='post' onsubmit='return 실행();'>
<input type='hidden' name=p_consult_no size=10 value='<?=$p_consult_no?>'/>
<input type='hidden' name='p_tech_no' size=10 value='<?=$p_tech_no?>'/>
<?php
if ( $p_consult_no ) { 
?>
<span class="p14 b bl06">1. 공급가능한 기술</span><br/><br/>
<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
  <tr>
    <td width="170" class="bt" id="t1">기술분야</td>
    <td class="bt">
<span id=area_tech_l_cat>로딩중</span> >>
<span id=area_tech_m_cat>로딩중</span> >>
<span id=area_tech_s_cat>로딩중</span>
    </td>
  </tr>
    <tr>
	<td id="t1">기관명</td>
	<td> <input type='text' readonly name='organ' size=100 value='' style='width:200px;border:0px;color:#555555' /> </td>
  </tr>
    <tr>
	<td id="t1">해당 URL</td>
	<td> <input type='text' readonly name='url' size=255 value='' style='width:200px;border:0px;color:#555555' /></td>
  </tr>
   <tr>
	<td id="t1">기술명</td>
	<td><input type='text' readonly name='tech_nm' size=100 value='' style='width:200px;border:0px;color:#555555'/></td>
  </tr>
  <tr>
    <td id="t1">특허번호</td>
	<td><input type='text' readonly name='license_number' size=100 value='' style='width:250px;border:0px;color:#555555' /></td>
  </tr>
  <tr>
	<td id="t1">목적</td>
	<td><input type='text' readonly name='purpose' size=100 value='' style='width:200px;border:0px;color:#555555' /></td>
  </tr>
  <tr>
       <td id="t1" >개요</td>
        <td> <textarea readonly name="outline" id="outline" cols="45" rows="5" style="width:510px;border:0px;color:#555555"/></textarea></td>
      </tr>
  <tr>
	<td id="t1">특징</td>
	<td> <input type='text' readonly name='feature' size=100 value='' style='width:200px;border:0px;color:#555555' /></td>
  </tr>
  <tr>
	<td id="t1">키워드</td>
	<td> <input type='text' readonly name='keyword' size=100 value='' style='width:200px;border:0px;color:#555555' /></td>
  </tr>
   <tr height='30'>
       <td id="t1">첨부파일</td>
        <td>&nbsp;<SPAN id=file1_infor></SPAN></td>
      </tr>
</table><br /><br />
<?php
} 
?>
<span class="p14 b bl06"><?=(!$p_consult_no?1:2)?>. 기술 매칭신청 담당자 정보</span><br /><br />

<input type='hidden' name='p_worker_no'/>
<input type='hidden' name='tel_sep_none' value="Y"/>
<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="100%">
  <tr>
	<td width="80" id="t1" class="bt" rowspan="4" >담당자</td>
	<td class="bt" id="t1" width="90"><span id="pt">*</span> 한글</td>
	<td class="bt"><input type="text" name="nm_kr" style="width:510px" class='required trim focus alert' maxlength=50 minlength=0 message='담당자 한글을 입력해주세요.' /></td>
  </tr>
  <tr>
	<td id="t1">영문</td>
	<td><input type="text" name="nm_en" style="width:510px" maxlength=50 minlength=0 /></td>
  </tr>
  <tr>
	<td id="t1">한자</td>
	<td><input type="text" name="nm_hj" style="width:510px" maxlength=50 minlength=0 /></td>
  </tr>
   <tr>
	<td id="t1">일문</td>
	<td><input type="text" name="nm_jp" style="width:510px" maxlength=50 minlength=0 /></td>
  </tr>
  <tr>
	<td colspan="2" id="t1"><span id="pt">*</span> 부서</td>
	<td><input type="text" name="dept" id="dept" style="width:510px" class='required trim focus alert' message='부서를 입력해주세요.'/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1"><span id="pt">*</span> 직위</td>
	<td><input type="text" name="position" id="position" style="width:510px" class='required trim focus alert' message='직위를 입력해주세요.'/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1"><span id="pt">*</span> 이메일</td>
	<td><input type='text' name='email' size=100 value='' style='width:510px' class='required email trim focus alert' maxlength=100 minlength=0 message='이메일을 입력해주세요.' /></td>
  </tr>
  <tr>
	<td colspan="2" id="t1"><span id="pt">*</span> 전화번호</td>
	<td><input type="text" name="tel" id="tel" style="width:310px" class='required trim focus alert' message='전화번호를 입력해주세요.'/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1"><span id="pt">*</span> 휴대폰</td>
	<td><input type="text" name="hp" id="hp" style="width:310px" class='required trim focus alert' message='휴대폰을 입력해주세요.'/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">FAX</td>
	<td><input type="text" name="fax" id="fax" style="width:310px"/></td>
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
    unset(Base::$CODE_POSSIBLE_LANG[JP]);
    $selectInfo = Base::$CODE_POSSIBLE_LANG;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('CHECKBOX',$selectInfo);
?>
    </td>
  </tr>
</table>
<div id="form_btn">
	<input type=image src="/images/btn_modify.jpg"/>
	<a href="#" title="삭제하기" onclick="return 삭제();"><img src="/images/btn_del.jpg" /></a>
	<a href="#" title="목록보기" onclick="return 목록();"><img src="/images/btn_list.jpg" /></a>
</div>
</form>