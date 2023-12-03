<form id=wForm name=wForm enctype='multipart/form-data' AUTOCOMPLETE='OFF' method='post' onsubmit='return 실행();'>
<!-- <input type="hidden" name="MAX_FILE_SIZE" value="1024000" /> -->
<input type=hidden name=p_company_no value="<?=$p_company_no?>">
<input type=hidden name=p_user_no value="<?=$p_user_no?>">
<input type='hidden' name='p_worker_no'/>

<span class="p14 b bl06">1. ビジネス相談申込み</span><br/><br/>
<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
  <tr>
   <td width="150" id="t1"> ビジネス相談タイトル</td>
   <td>
    <input type='text' name='consult_item_jp' size=100 value='' style='width:510px' maxlength=100 minlength=0/>
    </td>
  </tr>
  <tr>
	<td width="170"  id="t1"><span id="pt">*</span> 希望ビジネス形態</td>
	<td><p>
<?
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'hope_biz_type';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='required trim focus alert' message='希望ビジネス形態를 입력해주세요.' class='no-input'"  ;
    $creategory_setup['loop_end_tag'    ] = "&nbsp;"  ;
    $selectInfo = Base::$CODE_BIZ_TYPE_JP;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('RADIO',$selectInfo);
?>
    </td>
  </tr>
  <tr>
	<td width="170" id="t1">取引希望日本企業</td>
	<td> <input type='text' name='hope_trade_type_jp' size=100 value='' style='width:510px' maxlength=100 /></td>
  </tr>
  <tr>
	<td width="170" id="t1"><span id="pt">*</span> 韓国への資料公開期限</td>
	<td>
<?
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'open_limit';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='required trim focus alert' message='韓国への資料公開期限을 선택해주세요.' class='no-input'"  ;
    $creategory_setup['loop_end_tag'      ] = "&nbsp;"  ;
    $selectInfo = Base::$CODE_DATA_OPEN_LIMIT_JP;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('RADIO',$selectInfo);
?>
    </td>
  </tr>
  <tr>
	<td width="170" id="t1">他の意見及び質問事項</td>
	<td> <textarea name="etc_question_jp" cols="45" rows="5" style="width:510px"/></textarea></td>
  </tr>
  <tr>
	<td width="170" id="t1">製品写真</td>
	<td><input type="file" name="file4"/>&nbsp;<SPAN id=file4_infor></SPAN></td>
  </tr>
  <tr>
	<td width="170" id="t1">製品紹介書</td>
	<td><input type="file" name="file5"/>&nbsp;<SPAN id=file5_infor></SPAN></td>
  </tr> 
  <tr>
	<td width="170" id="t1">その他</td>
	<td><input type="file" name="file6"/>&nbsp;<SPAN id=file6_infor></SPAN></td>
  </tr>
    
</table></td>
</tr>
</table><br/><br />
<span class="p14 b bl06">2. 企業情報</span><br/><br/>
<table border="0" cellpadding="0" cellspacing="0" id="admin" width="700">
  <tr>
    <td width="70" rowspan="3" id="t1">企業名</td>
    <td width="70" id="t1"><span id="pt">*</span> ひらがな</td>
    <td><input type='text' name='company_nm_jp' style='width:120px' value='' class='required trim focus alert' maxlength=50 minlength=0 message='企業名를 입력해주세요.' /></td>
  </tr>
  <tr>
    <td id="t1"><span id="pt">*</span> 英語</td>
    <td><input type='text' name='company_nm_en' style='width:120px' value='' class='required trim focus alert' maxlength=50 minlength=0 message='企業名 英語를 입력해주세요.' /></td>
  </tr>
  <tr>
    <td id="t1">漢字</td>
    <td><input type='text' name='company_nm_hj' style='width:120px' value='' class='' maxlength=50 minlength=0 /></td>
  </tr>
  <tr>
    <td rowspan="3" id="t1">取締役</td>
    <td id="t1"><span id="pt">*</span> ひらがな</td>
    <td><input type='text' name='ceo_nm_jp' size=50 style='width:120px' value='' class='required trim focus alert' maxlength=50 minlength=0 message='取締役를 입력해주세요.' /></td>
  </tr>
  <tr>
    <td id="t1"><span id="pt">*</span> 英語</td>
    <td><input type='text' name='ceo_nm_en' size=50 style='width:120px' value='' class='required trim focus alert' maxlength=50 minlength=0 message='取締役 英語를 입력해주세요.' /></td>
  </tr>
  <tr>
    <td id="t1">漢字</td>
    <td><input type='text' name='ceo_nm_hj' size=50 style='width:120px' value='' maxlength=50 /></td>
  </tr>
  <tr>
    <td colspan="2" id="t1"><span id="pt">*</span> 業種分野</td>
    <td>
<?
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'biz_field';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='required alert no-input' message='業種分野를 선택해주세요.'"  ;
    $creategory_setup['loop_end_tag'      ] = "&nbsp;"  ;
    $selectInfo = Base::$CODE_BIZ_FIELD_JP;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('RADIO',$selectInfo);
?>
	</td>
  </tr>
  <tr>
    <td colspan="2" id="t1"><span id="pt">*</span> 業種分類</td>
    <td style="height:60px;">
    
<?
    unset($creategory_setup);
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'biz_classified[]';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='required alert no-input' message='業種分類를 선택해주세요.'"  ;
    $creategory_setup['loop_end_tag'    ] = ""  ;
    $creategory_setup['append_tag'      ] = '<input type="text" name="biz_classified_etc" disabled/>';
    $selectInfo = Base::$CODE_BIZ_CLASSIFIED_JP;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('CHECKBOX',$selectInfo);
?>
  </td>
  </tr>
  <tr>
    <td colspan="2" id="t1">業種名</td>
    <td><input type='text' name='biz_name_jp' size=50 style='width:100px' value='' maxlength=50 /></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">設立年月日</td>
    <td>
    <?php
    print Util::arrangeFormElement ('select','establish_date1', 1900,date("Y"),"", 1, '', '-年-', '');
    ?>
    <?php
    print Util::arrangeFormElement ('select','establish_date2', 1,12,"", 1, '', '-月-', '');
    ?>   
    
    <?php
    print Util::arrangeFormElement ('select','establish_date3', 1,31,"", 1, '', '-日-', '');
    ?>
	</td>
  </tr>
  <tr>
    <td rowspan="3" id="t1">本社住所</td>
    <td id="t1"><span id="pt">*</span> ひらがな</td>
    <td><input type="text" name="addr_jp" style="width:450px" class='required trim focus alert' maxlength=50 minlength=0 message='本社住所 ひらがな를 입력해주세요.' /></td>
  </tr>
  <tr>
    <td id="t1"><span id="pt">*</span> 英語</td>
    <td><input type="text" name="addr_en" style="width:450px" class='required trim focus alert' maxlength=50 minlength=0 message='本社住所  英語를 입력해주세요.' /></td>
  </tr>
  <tr>
    <td id="t1">漢字</td>
    <td><input type="text" name="addr_hj" style="width:450px"/></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">従業人数</td>
    <td><input type="text" name="worker_cnt" style="width:50px" maxlength=8/>
      명</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">電話番号</td>
    <td><input type="text" name="tel" style="width:230px" maxlength="20"/></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">ホームページ</td>
    <td><input type="text" name="homepage" style="width:200px" maxlength=255/></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">資本金</td>
    <td><input type="text" name="capital" class="number alert focus" message="資本金을 확인해주세요." style="width:100px;text-align:right" maxlength=10/>
      백만엔</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">売上高</td>
    <td><input type="text" name="sales" class="number alert focus" message="売上高을 확인해주세요." style="width:100px;text-align:right" maxlength=10/>
백만엔</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">会社紹介</td>
    <td style="height:100px;"><textarea name="company_intro_jp" cols="45" rows="5" style="width:450px"/></textarea></td>
  </tr>
  <tr>
    <td colspan="2" id="t1"><span id="pt">*</span> 韓国との取引経験</td>
    <td>
<?
    unset($creategory_setup);
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'jp_trade_yn';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='required alert no-input' message='韓国との取引経験을 선택해주세요.'"  ;
    $creategory_setup['loop_end_tag'    ] = "&nbsp;"  ;
    $selectInfo = Base::$CODE_EXIST_JP;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('RADIO',$selectInfo);
?>
    </td>
  </tr>
  <tr>
    <td colspan="2" id="t1"><span id="pt">*</span> 他の国と取引経験</td>
    <td>
<?
    unset($creategory_setup);
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'etc_trade_yn';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='required alert no-input' message='他の国と取引経験을 선택해주세요.'"  ;
    $creategory_setup['loop_end_tag'    ] = "&nbsp;"  ;
    $selectInfo = Base::$CODE_EXIST_JP;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('RADIO',$selectInfo);
?>
    </td>
  </tr>
<?
for($l=0;$l<5;$l++) {
?>
  <tr>
<?
    if ( $l==0 ) {
?>
    <td colspan="2" rowspan="5" id="t1">生産製品及び取扱い品物</td>
<?
    }
?>

    <td>ひらがな <input type="text" name="product_jp[]" style="width:120px"/>&nbsp;&nbsp;&nbsp;
    英語 <input type="text" name="product_en[]" style="width:120px"/>
 <input type="hidden" name="product[]" style="width:120px" value="<?=($l+1)?>"/>    
    </td>
  </tr>
<?
}
?>
    <tr>
    <td colspan="2" id="t1">主な取引先</td>
    <td style="height:70px;"><textarea name="internal_customer_jp" cols="45" rows="3" style="width:450px"/></textarea></td>
  </tr>
  <tr>
    <td rowspan="3" id="t1">添付資料</td>
    <td id="t1">会社紹介書</td>
    <td><input type="file" name="file1"/>&nbsp;<SPAN id=file1_infor></SPAN></td>
  </tr>
  <tr>
    <td id="t1">製品紹介書</td>
    <td><input type="file" name="file2"/>&nbsp;<SPAN id=file2_infor></SPAN></td>
  </tr>
  <tr>
    <td id="t1">製品紹介書</td>
    <td><input type="file" name="file3"/>&nbsp;<SPAN id=file3_infor></SPAN></td>
  </tr>
</table>
<br><br>
<span class="p14 b bl06">3. 担当者 情報</span><br /><br />
<input type='hidden' name='p_worker_no'/>
<input type='hidden' name='tel_sep_none' value="Y"/>
<input type='hidden' name='update_jp' value="Y"/>

<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
  <tr>
	<td width="80" id="t1" class="bt" rowspan="3" >担当者</td>
	<td class="bt" id="t1" width="90"><span id="pt">*</span> ひらがな</td>
	<td class="bt"><input type='text' name='nm_jp' size=50 value='' style='width:510px' class='required trim focus alert' maxlength=50 minlength=0 message='担当者 ひらがな를 입력해주세요.' /></td>
  </tr>
  <tr>
	<td id="t1"><span id="pt">*</span> 英語</td>
	<td><input type='text' name='nm_en' size=50 value='' style='width:510px' class='required trim focus alert' maxlength=50 minlength=0 message='担当者  英語를 입력해주세요.' /></td>
  </tr>
  <tr>
	<td id="t1"><span id="pt">*</span> 漢字</td>
	<td><input type='text' name='nm_hj' size=50 value='' style='width:510px' class='required trim focus alert' maxlength=50 minlength=0 message='担当者  漢字를 입력해주세요.' /></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">部署</td>
	<td><input type="text" name="dept_jp" style="width:510px" class='trim focus alert' message='部署를 입력해주세요.'/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1">職位</td>
	<td><input type="text" name="position_jp" style="width:510px" class='trim focus alert' message='職位를 입력해주세요.'/></td>	
  </tr>
  <tr>
	<td colspan="2" id="t1"><span id="pt">*</span> イーメール</td>
	<td><input type='text' name='email' size=100 value='' style='width:510px' class='required email trim focus alert' maxlength=100 minlength=0 message='イーメール를 입력해주세요.' /></td>
  </tr>
  <tr>
	<td colspan="2" id="t1"><span id="pt">*</span> 電話番号</td>
    <td><input type="text" name="worker_tel" style="width:230px" maxlength="20" class='required trim focus alert' message='電話番号를 확인해주세요.'/></td>
  </tr>
 <tr>
	<td colspan="2" id="t1"><span id="pt">*</span> 携帯番号</td>
    <td><input type="text" name="worker_hp" style="width:230px" maxlength=20 class='required trim focus alert' message='携帯番号를 확인해주세요.'/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">FAX</td>
    <td><input type="text" name="worker_fax" style="width:230px" maxlength=20/></td>
  </tr>
  <tr>
	<td colspan="2" id="t1">対応可能外国語</td>
	<td>
<?
	unset(Base::$CODE_POSSIBLE_LANG_JP[KR]);
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'possible_lang[]';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='no-input'"  ;
    $creategory_setup['loop_end_tag'      ] = "&nbsp;"  ;
    $selectInfo = Base::$CODE_POSSIBLE_LANG_JP;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('CHECKBOX',$selectInfo);
?>
    </td>
  </tr>
</table>

<div id="form_btn">
    <input type=image src="/images/btn_form_apply.jpg" style='vertical-align:middle'/>
</div>
</form>
