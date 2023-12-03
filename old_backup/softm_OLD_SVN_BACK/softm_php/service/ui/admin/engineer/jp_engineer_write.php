<form id=wForm name=wForm enctype='multipart/form-data' AUTOCOMPLETE='OFF' method='post' onsubmit='return 실행();'>
<input type=hidden name=p_engineer_no value="<?=$p_engineer_no?>">

<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="100%">
 
  <tr>
	<td width="80" id="t1" class="bt"  rowspan="4" >성명</td>
	<td id="t1" width="90" class="bt"  >한자</td>
	<td class="bt"  ><input type='text' name='nm_hj' size=50 value='' style='width:510px' maxlength=50 /></td>
  </tr>
   <tr>
	<td id="t1">일본어</td>
	<td><input type='text' name='nm_jp' size=50 value='' style='width:510px' maxlength=50 /></td>
  </tr>
   <tr>
	<td id="t1"><span id="pt">*</span> 한글</td>
	<td><input type='text' name='nm_kr' size=50 value='' style='width:510px' class='required trim focus alert' maxlength=50 minlength=0 message='한글명을 입력해주세요.' /></td>
  </tr>
   <tr>
	<td id="t1">영문</td>
	<td><input type='text' name='nm_jp' size=50 value='' style='width:510px' maxlength=50 /></td>
  </tr>
  <tr>
 
  <tr>
	<td colspan="2" id="t1"> 전화번호</td>
	<td><input type='text' name='tel' size=20 value='' style='width:250px' maxlength=20 /></td>
  </tr>
  <tr>
	<td colspan="2" id="t1"> 휴대폰</td>
	<td><input type='text' name='hp' size=20 value='' style='width:250px' maxlength=20 /></td>
  </tr>
    <tr>
	<td colspan="2" id="t1"> 이메일</td>
	<td><input type='text' name='email' size=100 value='' style='width:250px' class="email" message="이메일을 입력해주세요." maxlength=100 /></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">이력서</td>
	    <td ><input type="file" name="file1"/>&nbsp;<SPAN id=file1_infor></SPAN></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">각서</td>
	    <td ><input type="file" name="file2"/>&nbsp;<SPAN id=file2_infor></SPAN></td>
  </tr>
</table>
<div id="form_btn">
	<input type=image src="/images/btn_modify.jpg"/>
	<a href="#" title="삭제하기" onclick="return 삭제();"><img src="/images/btn_del.jpg" /></a>
	<a href="#" title="목록보기" onclick="return 목록();"><img src="/images/btn_list.jpg" /></a>    
</div><br />

</form>