<form id=wForm name=wForm enctype='multipart/form-data' method='post' onsubmit='return 실행();'>
<input type='hidden' name='p_tech_no' size=10 value='<?=$p_tech_no?>'/>

<span class="p14 b bl06">1. 공급 가능한 기술</span><br/><br/>
<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
  <tr>
    <td width="170" class="bt" id="t1"><span id="pt">*</span> 技術分野</td>
    <td class="bt">
<span id=area_tech_l_cat><input name=tech_l_cat value="1차카테고리" readonly></span>
    </td>
  </tr>
    <tr>
	<td id="t1">기관명</td>
	<td> <input type='text' name='organ' size=100 value='' style='width:200px' maxlength=100 /> </td>
  </tr>
    <tr>
	<td id="t1">해당 URL</td>
	<td> <input type='text' name='url' size=255 value='' style='width:200px' maxlength=255 /></td>
  </tr>
   <tr>
	<td id="t1"><span id="pt">*</span>技術名</td>
	<td><input type='text' name='tech_nm_jp' size=100 value='' style='width:510px' maxlength=100 class='required trim focus alert' message='技術名을 입력해주세요.'/> </td>
  </tr>
  <tr>
    <td id="t1"><span id="pt">*</span> 特許番号</td>
	<td><input type='text' name='license_number' size=100 value='' style='width:510px' maxlength=100 class='required trim focus alert' message='特許番号을 입력해주세요.'/></td>
  </tr>
  <tr>
	<td id="t1"><span id="pt">*</span> 目的</td>
	<td><input type='text' name='purpose_jp' size=100 value='' style='width:510px' maxlength=100 class='required trim focus alert' message='目的을 입력해주세요.'/></td>
  </tr>
  <tr>
       <td id="t1" >概要</td>
        <td> <textarea name="outline_jp" id="outline_jp" cols="45" rows="5" style="width:510px"/></textarea></td>
      </tr>
  <tr>
	<td id="t1"><span id="pt">*</span> 特徴</td>
	<td> <input type='text' name='feature_jp' size=100 value='' style='width:200px' maxlength=100  class='required trim focus alert' message='特徴을 입력해주세요.'/></td>
  </tr>
  <tr>
	<td id="t1">キーワード</td>
	<td><input type='text' name='keyword_jp' size=100 value='' style='width:510px' maxlength=100 /></td>
  </tr>
   <tr height='30'>
       <td id="t1">添付ファイル</td>
        <td><input type="file" name="file1"/>&nbsp;<SPAN id=file1_infor></SPAN></td>
      </tr>
</table><br /><br />
 
<span class="p14 b bl06">2. 担当者 情報</span><br /><br />
<input type='hidden' name='p_worker_no'/>
<input type='hidden' name='tel_sep_none' value="Y"/>
<input type='hidden' name='update_jp' value="Y"/>
<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="100%">
  <tr>
	<td width="80" id="t1" class="bt" rowspan="3" >担当者</td>
	<td class="bt" id="t1" width="90">ひらがな</td>
	<td class="bt"><input type="text" name="nm_jp" style="width:510px" maxlength=50 minlength=0/></td>
  </tr>
  <tr>
	<td id="t1">英語</td>
	<td><input type="text" name="nm_en" style="width:510px" maxlength=50 minlength=0/></td>
  </tr>
  <tr>
	<td id="t1">漢字</td>
	<td><input type="text" name="nm_hj" style="width:510px" maxlength=50 minlength=0/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">部署</td>
	<td><input type="text" name="dept_jp" style="width:510px"/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1">職位</td>
	<td><input type="text" name="position_jp" style="width:510px"/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">イーメール</td>
	<td><input type='text' name='email' size=100 value='' style='width:510px' maxlength=100 minlength=0/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">電話番号</td>
	<td><input type="text" name="tel" id="tel" style="width:310px"/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1">携帯番号</td>
	<td><input type="text" name="hp" id="hp" style="width:310px"/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">ファックス</td>
	<td><input type="text" name="fax" id="fax" style="width:310px"/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">対応可能外国語</td>
	<td>
<?
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'possible_lang[]';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='no-input'"  ;
    $creategory_setup['loop_end_tag'      ] = "&nbsp;"  ;
    unset(Base::$CODE_POSSIBLE_LANG_JP[JP]);
    $selectInfo = Base::$CODE_POSSIBLE_LANG_JP;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('CHECKBOX',$selectInfo);
?>
    </td>
  </tr>
</table>
<div id="form_btn">
	<input type=image src="/images/btn_add.jpg" style="vertical-align:middle"/>
</div>
</form>