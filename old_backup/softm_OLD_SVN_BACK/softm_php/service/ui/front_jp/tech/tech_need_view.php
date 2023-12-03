<form id=wForm name=wForm enctype='application/x-www-form-urlencoded' AUTOCOMPLETE='OFF' method='post'>
<input type='hidden' name='p_consult_no' size=10 value='<?=$p_consult_no?>'/><BR>
<input type='hidden' name='p_proc_type' size=10 value='<?=PROC_TYPE_NC?>'/><BR>
<span class="p14 b bl06">1. 원하는 기술</span><br/><br/>
<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
  <tr>
    <td width="170" class="bt" id="t1">技術分野</td>
    <td class="bt">
<span id=area_tech_l_cat><select name=s_l_cat><option>1차카테고리</option></select></span>
<span id=area_tech_m_cat><select name=s_m_cat><option>2차카테고리</option></select></span>
<span id=area_tech_s_cat><select name=s_s_cat><option>3차카테고리</option></select></span>    
    </td>
  </tr>
    <tr>
	<td id="t1">技術名</td>
	<td><input type="text" name="tech_nm_jp" style='width:510px;border:0px' readonly maxlength=100 minlength=0/></td>
  </tr>
    <tr>
	<td id="t1">技術内容</td>
	<td><input type="text" name="tech_content_jp" style='width:510px;border:0px' readonly /></td>
  </tr>
  <tr>
    <td id="t1">技術説明</td>
	<td><textarea name="tech_comment_jp" cols="45" rows="5" style='width:510px;border:0px' readonly/></textarea></td>
  </tr>
  <tr>
    <td id="t1">希望類型</td>
    <td>
<?
   	print Base::$CODE_TECH_TRADE_HOPE_TYPE_JP[$p_trade_hope_type];
?>
  </td>
  </tr>
   <tr>
	<td id="t1"> キーワード</td>
	<td><input type='text' name='keyword_jp' size=100 value='' style='width:510px;border:0px' readonly maxlength=100/></td>
  </tr>
</table><br /><br />
<span class="p14 b bl06">2. 担当者 情報</span><br /><br />
<input type='hidden' name='p_worker_no' size=10 value=''/><BR>

<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
  <tr>
	<td colspan="2" id="t1"><span id="pt">*</span>企業名</td>
	<td><input type="text" name="company_nm_jp" style='width:510px;border:0px' readonly /></td>
  </tr>
  <tr>
	<td width="80" id="t1" class="bt" rowspan="3" >担当者</td>
	<td class="bt" id="t1" width="90">ひらがな</td>
	<td class="bt"><input type='text' name='nm_jp' size=50 value='' style='width:510px;border:0px' readonly/></td>
  </tr>
  <tr>
	<td id="t1">英語</td>
	<td><input type='text' name='nm_en' size=50 value='' style='width:510px;border:0px' readonly maxlength=50 /></td>
  </tr>
  <tr>
	<td id="t1">漢字</td>
	<td><input type='text' name='nm_hj' size=50 value='' style='width:510px;border:0px' readonly maxlength=50 /></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">部署</td>
	<td><input type="text" name="dept_jp" style='width:510px;border:0px' readonly/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1">職位</td>
	<td><input type="text" name="position_jp" style='width:510px;border:0px' readonly/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">イーメール</td>
	<td><input type='text' name='email' value='' style='width:510px;border:0px' readonly/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">電話番号</td>
    <td><input type="text" name="tel" style='width:230px;border:0px' readonly/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1">携帯番号</td>
    <td><input type="text" name="hp" style='width:230px;border:0px' readonly/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">ファックス</td>
    <td><input type="text" name="fax" style='width:230px;border:0px' readonly/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">対応可能外国語</td>
	<td>
<?
$printPossibleLang = array();
$possibleLang = split(",",$p_possible_lang);
foreach($possibleLang as $idx => $value) {
   	$printPossibleLang[] = Base::$CODE_POSSIBLE_LANG_JP[$value];
}
echo join(",",$printPossibleLang);
?>
    </td>
  </tr>
</table>
<div id="form_btn">
  <a href="#" title="목록보기" onclick="return 목록();"><img src="/images/btn_form_list.jpg" /></a>
</div>
</form>