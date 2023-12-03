<form id=wForm name=wForm enctype='multipart/form-data' AUTOCOMPLETE='OFF' method='post' onsubmit='return 실행();'>
<input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
<input type=hidden name=country_type value="KR">
<!-- <form id=wForm name=wForm enctype='multipart/form-data' method='post' onsubmit='return 파일업로드();'> -->
<!-- <input name='MAX_FILE_SIZE1' type='hidden' value='3' /> -->
<!-- <input type='submit' value='전송'><BR> -->
<!-- <input name='test1' type='text' value='test1'><BR> -->
<!-- <input type='file' name='test_file' id='test_file' style='width:450px'/><BR> -->
<input type='hidden' name='p_consult_no' value='<?=$p_consult_no?>'/>
<input type='hidden' name='p_proc_type' value='<?=$p_proc_type?>'/>
<input type='hidden' name='p_consult_company_no' value='<?=$p_consult_company_no?>'/>
<input type='hidden' name='p_worker_no'/>

<input type='hidden' name='p_company_no'/>
<input type='hidden' name='p_user_no'/>

<span class="p14 b bl06">1. 기본정보</span><br/><br/>
<table border="0" cellpadding="0" cellspacing="0" id="admin" width="100%">
        <tr>
          <td width="210" class="bt" id="t1" colspan="2" >기업코드</td>
          <td class="bt"><input type="text" name="company_reg_code" id="company_reg_code" style="width:530px;border:0px" readonly></td>
        </tr>
        <tr>
          <td width='10%' rowspan="2"  id="t1" >기업명</td>
          <td width='12% 'id="t1"'>한글</td>
          <td > <input type="text" name="company_nm_kr" id="company_nm_kr" style="width:530px;border:0px" readonly/></td>
        </tr>
        <tr>
           <td width='12%'id="t1"'>일문</td>
          <td ><input type="text" name="company_nm_jp" id="company_nm_jp" style="width:530px;border:0px" readonly/></td>
        </tr>
        <tr>
          <td  colspan="2"   id="t1" >전화번호</td>
          <td> <input type="text" name="company_tel" id="company_tel" style="width:530px;border:0px" readonly/></td>
        </tr>
        <tr>
          <td width='10%' rowspan="2"  id="t1" >주소</td>
          <td width='12% 'id="t1"'>한글</td>
          <td > <input type="text" name="company_addr_kr" id="company_addr_kr" style="width:530px;border:0px" readonly/></td>
        </tr>
        <tr>
           <td width='12%'id="t1"'>일문</td>
          <td ><input type="text" name="company_addr_jp" id="company_addr_jp" style="width:530px;border:0px" readonly/></td>
        </tr>
        <tr >
          <td  colspan="2"   id="t1" >매칭코드</td>
          <td class="bt">
            <input type="text" name="reg_code" id="reg_code" style="border:0px;width:530px" readonly />
          </span></td>
        </tr>
        <tr'>
          <td  colspan="2"   id="t1" >처리상황</td>
          <td>
<?
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'state';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='no-input'"  ;
    $creategory_setup['loop_end_tag'      ] = "&nbsp;"  ;
    $selectInfo = Base::$CODE_STATE_BC;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('SELECT',$selectInfo);
?>          
            </td>
        </tr>
        <tr'>
          <td  colspan="2"   id="t1" >노출여부</td>
          <td><input type="radio" name='open_yn' value='Y' />노출
            <input type="radio" name='open_yn' value='N' checked="checked"/>  비노출</td>
        </tr>
      </table>
	<br/><br/>

<span class="p14 b bl06">2. 비즈니스상담신청</span><br/><br/>
<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
  <tr>
   <td width="150" class="bt" id="t1">비즈니스  상담안건</td>
   <td class="bt">
    <input type='text' name='consult_item' size=100 value='' style='width:510px' class='required trim focus alert' maxlength=100 minlength=0 message='비지니스 상담 안건을 입력해주세요.' />
    </td>
  </tr>
  <tr>
   <td width="150" class="bt" id="t1">비즈니스  상담안건(일문)</td>
   <td class="bt">
    <input type='text' name='consult_item_jp' size=100 value='' style='width:510px' maxlength=100 minlength=0 />
    </td>
  </tr>
  <tr>
	<td width="170"  id="t1">희망비즈니스상태</td>
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
?>
    </td>
  </tr>
  <tr>
	<td width="170" id="t1">희망비즈니스내용요약</td>
	<td><textarea name="hope_biz" cols="45" rows="5" style="width:510px" class='required trim focus alert' message='희망비즈니스내용요약을 입력해주세요.'/></textarea></td>
  </tr>
  <tr>
	<td width="170" id="t1">희망비즈니스내용요약(일문)</td>
	<td><textarea name="hope_biz_jp" cols="45" rows="5" style="width:510px" /></textarea></td>
  </tr>
  <tr>
	<td width="170" id="t1">거래 희망 일본 기업유형</td>
	<td> <input type='text' name='hope_trade_type' size=100 value='' style='width:510px' maxlength=100 /></td>
  </tr>
  <tr>
	<td width="170" id="t1">거래 희망 일본 기업유형(일문)</td>
	<td> <input type='text' name='hope_trade_type_jp' size=100 value='' style='width:510px' maxlength=100 /></td>
  </tr>
  <tr>
	<td width="170" id="t1">일본 내 자료 공개 기한</td>
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
?>
    </td>
  </tr>
  <tr>
	<td width="170" id="t1">기타 의견 및 문의사항</td>
	<td> <textarea name="etc_question" cols="45" rows="5" style="width:510px"/></textarea></td>
  </tr>
  <tr>
	<td width="170" id="t1">기타 의견 및 문의사항(일문)</td>
	<td> <textarea name="etc_question_jp" cols="45" rows="5" style="width:510px"/></textarea></td>
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

<span class="p14 b bl06">3. 담당자 정보</span><br /><br />

<input type=hidden name=update_jp value="Y">

<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
  <tr>
	<td width="80" id="t1" class="bt" rowspan="4" >담당자</td>
	<td class="bt" id="t1" width="90">한글</td>
	<td class="bt"><input type='text' name='nm_kr' size=50 value='' style='width:510px' class='required trim focus alert' maxlength=50 minlength=0 message='담당자 한글를 입력해주세요.' /></td>
  </tr>
  <tr>
	<td id="t1">일문</td>
	<td><input type='text' name='nm_jp' size=50 value='' style='width:510px' /></td>
  </tr>
  <tr>
	<td id="t1">영문</td>
	<td><input type='text' name='nm_en' size=50 value='' style='width:510px' class='required trim focus alert' maxlength=50 minlength=0 message='담당자 영문를 입력해주세요.' /></td>
  </tr>
  <tr>
	<td id="t1">한자</td>
	<td><input type='text' name='nm_hj' size=50 value='' style='width:510px' maxlength=50 /></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">부서</td>
	<td><input type="text" name="dept" style="width:510px"/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">부서(일문)</td>
	<td><input type="text" name="dept_jp" style="width:510px"/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1">직위</td>
	<td><input type="text" name="position" style="width:510px"/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1">직위(일문)</td>
	<td><input type="text" name="position_jp" style="width:510px"/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">이메일</td>
	<td><input type='text' name='email' size=100 value='' style='width:510px' class='required email trim focus alert' maxlength=100 minlength=0 message='이메일를 입력해주세요.' /></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">전화번호</td>
    <td><input type="text" name="tel1" style="width:30px" maxlength="3" class='required number trim focus alert' message='전화번호를 확인해주세요.'/>-<input name="tel2" style="width:35px" maxlength=4 class='required number trim focus alert' message='전화번호를 확인해주세요.'/>-<input type="text" name="tel3" style="width:35px" maxlength=4 class='required number trim focus alert' message='전화번호를 확인해주세요.'/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1">휴대폰</td>
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
    $selectInfo = Base::$CODE_POSSIBLE_LANG;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('CHECKBOX',$selectInfo);
?>
    </td>
  </tr>
</table>
<br><br>
<span class="p14 b bl06">4. 대응방안</span><br/><br/>
<table border="0" cellpadding="0" cellspacing="0" id="admin" width="100%">
      <tr >
        <td  class="bt" style="height:100px;"><textarea name="action_plan" id="action_plan" cols="45" rows="5" style="width:98%"/></textarea></td>
        </tr>
    </table>
<div id="form_btn">
  	<a href="#" title="메일발송" onclick="return 메일발송팝업();"><img src="/images/btn_mail.jpg" /></a>
	<input type=image src="/images/btn_modify.jpg" title="정보수정"/>  	
    <a href="#" title="삭제하기" onclick="return 삭제('<?=$p_consult_no?>')"><img src="/images/btn_del.jpg" /></a>
    <a href="#" onclick="mypageList();" title="목록보기" id=btn_list  ><img src="/images/btn_list.jpg" /></a>
</div>
<br/><br/>

</form>
<form id=wCForm name=wCForm enctype='application/x-www-form-urlencoded' AUTOCOMPLETE='OFF' method='post' onsubmit='return 관리자코멘트입력();'>
<span class="p14 b bl06">5.관리자 Comment</span><br/><br/>
<input type='hidden' name='p_consult_no' value='<?=$p_consult_no?>'/>
<input type='hidden' name='p_proc_type' value='<?=$p_proc_type?>'/>
<input type='hidden' name='p_seq' size=3 value='' style='width:7px' maxlength=3 minlength=0 />
<table border="0" cellpadding="0" cellspacing="0" id="admin" width="100%">
    <td class="bt" style="height:50px;">
      <textarea name="admin_comment" cols="45" rows="2" style="width:600px" class='required trim focus alert' message='관리자 코멘트를 입력해주세요.'></textarea>
      <input type=image src="/images/btn_add2.jpg" width="80" height="25" align=absmiddle/>
      </td>
  </tr>
</table>
</form> 
<BR>
<table border="0" cellspacing="0" cellpadding="0" 
	id="tbl_comment_list" class=grid_tbl style="table-layout:fixed;width:600px">
	<thead></thead>
	<tbody></tbody>
	<tfoot></tfoot>
</table>
<p align="right">&nbsp;</p>
