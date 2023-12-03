<form id=wForm name=wForm enctype='multipart/form-data' method='post' onsubmit='return 실행();'>
<input type='hidden' name='p_tech_no' size=10 value='<?=$p_tech_no?>'/>
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
        <td><SPAN id=file1_infor></SPAN></td>
      </tr>
</table><br /><br />
 
<div id="form_btn">
<!--   <a href="sub.php?contents=submenu03&amp;load=menu03_02_01_add" title="신청하기"><img src="/images/btn_form_apply.jpg" /></a> -->
  <a href="#" title="신청하기" onclick="return 신청();"><img src="/images/btn_form_apply.jpg" /></a>  
  <a href="#" title="목록보기" onclick="return 목록();"><img src="/images/btn_form_list.jpg" /></a>
</div>
</form>