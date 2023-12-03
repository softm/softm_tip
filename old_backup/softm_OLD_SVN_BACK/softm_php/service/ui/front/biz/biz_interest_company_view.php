<form id=wForm name=wForm>
<?
	$p_company_no = $_POST[p_company_no];
?>
<span class="p14 b bl06">1. 비즈니스 상담정보</span><br/><br/>
<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
  <tr>
   <td width="150" class="bt" id="t1"> 비즈니스  상담안건</td>
   <td class="bt">
    <input type='text' name='consult_item' size=100 value='' style='width:510px;border:0px' readonly/>
    </td>
  </tr>
  <tr>
	<td width="170"  id="t1"> 희망비즈니스형태</td>
	<td><p>
<?
echo Base::$CODE_BIZ_TYPE[$p_hope_biz_type];
?>
    </td>
  </tr>
  <tr>
	<td width="170" id="t1"> 희망비즈니스내용요약</td>
	<td><textarea name="hope_biz" id="hope_biz" cols="45" rows="5" style="width:510px;border:0px" readonly/></textarea></td>
  </tr>
  <tr>
	<td width="170" id="t1">거래 희망 일본 기업유형</td>
	<td> <input type='text' name='hope_trade_type' size=100 value='' style='width:510px;border:0px' readonly/>	
	</td>
  </tr>
  <tr>
	<td width="170" id="t1"> 일본 내 자료 공개 기한</td>
	<td>
<?
echo Base::$CODE_DATA_OPEN_LIMIT[$p_open_limit];
?>
    </td>
  </tr>
  <tr>
	<td width="170" id="t1">기타 의견 및 문의사항</td>
	<td> <textarea name="etc_question" id="etc_question" cols="45" rows="5" style="width:510px;border:0px" readonly/></textarea></td>
  </tr>
  <tr>
	<td width="170" id="t1">제품사진</td>
	<td>&nbsp;<SPAN id=file1_infor></SPAN></td>
  </tr>
  <tr>
	<td width="170" id="t1">제품소개서</td>
	<td>&nbsp;<SPAN id=file2_infor></SPAN></td>
  </tr> 
  <tr>
	<td width="170" id="t1">기타</td>
	<td>&nbsp;<SPAN id=file3_infor></SPAN></td>
  </tr>
    
</table>
</form>
<BR>
<BR>
<span class="p14 b bl06">2. 기업정보</span><br/><br/>
<?php include_once SERVICE_DIR . '/inc/common/company_infor.inc';?>
<?php
if ( $p_gubun != "interest_list" ) { // 관심기업에서 온게 아니면
?>
<div id="form_btn">
  <a href="#" title="신청하기" id="btn_interest" onclick="관심기업(<?=$p_company_no?>);"><img src="/images/btn_register.jpg" /></a>&nbsp;
  <a href="#" title="목록보기"  id=btn_list      onclick="목록();" title="목록보기"><img src="/images/btn_form_list.jpg" /></a>
</div>
<?php
} else { // 관심기업에서 온게야
?>
<div id="form_btn">
  	<a href="#" title="신청하기" onclick="매칭신청();"><img src="/images/btn_order.jpg" /></a>
  	<a href="#" title="목록보기"  id=btn_list      onclick="목록();" title="목록보기"><img src="/images/btn_list.jpg" /></a>  	
</div>
<?php
}
?>