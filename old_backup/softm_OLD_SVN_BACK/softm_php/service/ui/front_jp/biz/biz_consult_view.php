<form id=wForm name=wForm enctype='multipart/form-data' AUTOCOMPLETE='OFF' method='post' onsubmit='return 실행();'>
<input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
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

<span class="p14 b bl06">1. ビジネス相談申込み</span><br/><br/>
<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
  <tr>
   <td width="150" class="bt" id="t1"><span id="pt">*</span> ビジネス相談タイトル</td>
   <td class="bt">
    <input type='text' name='consult_item' size=100 value='' style='width:510px;border:0px' readonly class='required trim focus alert' maxlength=100 minlength=0 message='비지니스 상담 안건을 입력해주세요.' />
    </td>
  </tr>
  <tr>
	<td width="170"  id="t1"><span id="pt">*</span> 希望ビジネス形態</td>
	<td>
<?
echo Base::$CODE_BIZ_TYPE_JP[$p_hope_biz_type];
?>
    </td>
  </tr>
  <tr>
	<td width="170" id="t1"><span id="pt">*</span> 希望ビジネス内容要約</td>
	<td><textarea name="hope_biz_jp" cols="45" rows="5" style="width:510px;border:0px" readonly/></textarea></td>
  </tr>
  <tr>
	<td width="170" id="t1">取引希望日本企業</td>
	<td> <input type='text' name='hope_trade_type_jp' size=100 value='' style='width:510px;border:0px' readonly maxlength=100 /></td>
  </tr>
  <tr>
	<td width="170" id="t1"><span id="pt">*</span> 日本への資料公開期限</td>
	<td>
<?
echo Base::$CODE_DATA_OPEN_LIMIT_JP[$p_open_limit];
?>
    </td>
  </tr>
  <tr>
	<td width="170" id="t1">その他の意見及び質問事項</td>
	<td> <textarea name="etc_question_jp" cols="45" rows="5" style="width:510px;border:0px" readonly/></textarea></td>
  </tr>
  <tr>
	<td width="170" id="t1">製品写真</td>
	<td><SPAN id=file1_infor></SPAN></td>
  </tr>
  <tr>
	<td width="170" id="t1">製品紹介書</td>
	<td><SPAN id=file2_infor></SPAN></td>
  </tr> 
  <tr>
	<td width="170" id="t1">その他</td>
	<td><SPAN id=file3_infor></SPAN></td>
  </tr>
    
</table></td>
</tr>
</table><br/><br />

<span class="p14 b bl06">2. 担当者 情報</span><br /><br />
<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
  <tr>
	<td width="80" id="t1" class="bt" rowspan="3" >担当者</td>
	<td class="bt" id="t1" width="90">ひらがな</td>
	<td class="bt"><input type='text' name='nm_jp' size=50 value='' style='width:510px;border:0px' readonly/></td>
  </tr>
  <tr>
	<td id="t1">英語</td>
	<td><input type='text' name='nm_en' size=50 value='' style='width:510px;border:0px' readonly/></td>
  </tr>
  <tr>
	<td id="t1">漢字</td>
	<td><input type='text' name='nm_hj' size=50 value='' style='width:510px;border:0px' readonly/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">部署</td>
	<td><input type="text" name="dept_jp" style="width:510px;border:0px" readonly/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1">職位</td>
	<td><input type="text" name="position_jp" style="width:510px;border:0px" readonly/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">イーメール</td>
	<td><input type='text' name='email' size=100 value='' style='width:510px;border:0px' readonly/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">電話番号</td>
    <td><input type="text" name="tel" style="width:230px;border:0px"  readonly/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1">携帯番号</td>
    <td><input type="text" name="hp" style="width:230px;border:0px"  readonly/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">FAX</td>
    <td><input type="text" name="fax" style="width:230px;border:0px"  readonly/></td>
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
<BR><BR>
<span class="p14 b bl06">3. 企業情報</span><br /><br />
<?php
include SERVICE_DIR . "/inc/common/company_infor_jp.inc";
?>
<div id="form_btn">
<a href="#" onclick="mypageList();" title="목록보기" id=btn_list  ><img src="/images/btn_list.jpg" /></a>
</div>
</form>