<?php
// echo USER_LEVEL;
?>
<form id=wForm name=wForm enctype='multipart/form-data' AUTOCOMPLETE='OFF' method='post' onsubmit='return 실행();'>
<input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
<input type=hidden name=p_company_no value="<?=$p_company_no?>">
<input type=hidden name=p_user_no value="<?=$p_user_no?>">
<input type=hidden name=p_user_level value="<?=$_POST['p_user_level']?>">
<input type=hidden name=country_type value="KR">
<table border="0" cellpadding="0" cellspacing="0" id="admin" width="700">
  <tr>
    <td colspan="2"id="t1">사업자번호</td>
    <td><!-- 1400164731 -->
        <input type='text' name='company_code1' size=3 style='width:40px' value='' class='required trim focus alert' maxlength=3 minlength=3 message='사업자번호를 확인해주세요.' <?=($p_company_no?"readonly":"")?>/>
        <input type='text' name='company_code2' size=2 style='width:30px' value='' class='required trim focus alert' maxlength=2 minlength=2 message='사업자번호를 확인해주세요.' <?=($p_company_no?"readonly":"")?>/>
        <input type='text' name='company_code3' size=5 style='width:70px' value='' class='required trim focus alert' maxlength=5 minlength=5 message='사업자번호를 확인해주세요.' <?=($p_company_no?"readonly":"")?>/>
    </td>
  </tr>
  <tr>
    <td width="70" rowspan="4" id="t1">기업명</td>
    <td width="70" id="t1">한글</td>
    <td><input type='text' name='company_nm_kr' style='width:120px' value='' class='required trim focus alert' maxlength=50 minlength=0 message='기업명 한글를 입력해주세요.' /></td>
  </tr>
  <tr>
    <td id="t1">영문</td>
    <td><input type='text' name='company_nm_en' style='width:120px' value='' class='required trim focus alert' maxlength=50 minlength=0 message='기업명 영문를 입력해주세요.' /></td>
  </tr>
  <tr>
    <td id="t1">한자</td>
    <td><input type='text' name='company_nm_hj' style='width:120px' value='' class='' maxlength=50 minlength=0 /></td>
  </tr>
  <tr>
    <td id="t1">일문</td>
    <td><input type='text' name='company_nm_jp' style='width:120px' value='' class='' maxlength=50 minlength=0 /></td>
  </tr>
  <tr>
    <td rowspan="4" id="t1">대표자</td>
    <td id="t1">한글</td>
    <td><input type='text' name='ceo_nm_kr' size=50 style='width:120px' value='' class='required trim focus alert' maxlength=50 minlength=0 message='대표자 한글를 입력해주세요.' /></td>
  </tr>
  <tr>
    <td id="t1">영문</td>
    <td><input type='text' name='ceo_nm_en' size=50 style='width:120px' value='' class='required trim focus alert' maxlength=50 minlength=0 message='대표자 영문를 입력해주세요.' /></td>
  </tr>
  <tr>
    <td id="t1">한자</td>
    <td><input type='text' name='ceo_nm_hj' size=50 style='width:120px' value='' maxlength=50 /></td>
  </tr>
  <tr>
    <td id="t1">일문</td>
    <td><input type='text' name='ceo_nm_jp' size=50 style='width:120px' value='' maxlength=50 /></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">업종분야</td>
    <td>
<?
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'biz_field';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='required alert no-input' message='업종분야를 선택해주세요.'"  ;
    $creategory_setup['loop_end_tag'      ] = "&nbsp;"  ;
    $selectInfo = Base::$CODE_BIZ_FIELD;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('RADIO',$selectInfo);
?>
	</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">업종분류</td>
    <td style="height:60px;">
    
<?
    unset($creategory_setup);
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'biz_classified[]';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='required alert no-input' message='업종분류를 선택해주세요.'"  ;
    $creategory_setup['loop_end_tag'    ] = ""  ;
    $creategory_setup['append_tag'      ] = '<input type="text" name="biz_classified_etc" disabled/>';
    $selectInfo = Base::$CODE_BIZ_CLASSIFIED;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('CHECKBOX',$selectInfo);
?>
  </td>
  </tr>
  <tr>
    <td colspan="2" id="t1">업종명</td>
    <td><input type='text' name='biz_name' size=50 style='width:100px' value='' maxlength=50 /></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">업종명(일문)</td>
    <td><input type='text' name='biz_name_jp' size=50 style='width:100px' value='' maxlength=50 /></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">설립연월일</td>
    <td>
    <?php
    print Util::arrangeFormElement ('select','establish_date1', 1900,date("Y"),"", 1, '', '-년-', '');
    ?>
    <?php
    print Util::arrangeFormElement ('select','establish_date2', 1,12,"", 1, '', '-월-', '');
    ?>   
    
    <?php
    print Util::arrangeFormElement ('select','establish_date3', 1,31,"", 1, '', '-일-', '');
    ?>
	</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">우편번호</td>
    <td><input type="text" name="zip_code" style="width:100px"/><button type=button onclick="return 우편번호팝업();">검색</button></td>
  </tr>
  <tr>
    <td rowspan="4" id="t1">본사주소</td>
    <td id="t1">한글</td>
    <td><input type="text" name="addr_kr" style="width:450px"/></td>
  </tr>
  <tr>
    <td id="t1">영문</td>
    <td><input type="text" name="addr_en" style="width:450px"/></td>
  </tr>
  <tr>
    <td id="t1">한자</td>
    <td><input type="text" name="addr_hj" style="width:450px"/></td>
  </tr>
  <tr>
    <td id="t1">일문</td>
    <td><input type="text" name="addr_jp" style="width:450px"/></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">종업원수</td>
    <td><input type="text" name="worker_cnt" style="width:50px" maxlength=8/>
      명</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">전화번호</td>
    <td><input type="text" name="tel1" style="width:30px" maxlength="3"/>-<input name="tel2" style="width:35px" maxlength=4/>-<input type="text" name="tel3" style="width:35px" maxlength=4/></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">팩스번호</td>
    <td><input type="text" name="fax1" style="width:30px" maxlength=3/>-<input name="fax2" style="width:35px" maxlength=4/>-<input type="text" name="fax3" style="width:35px" maxlength=4/></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">홈페이지</td>
    <td><input type="text" name="homepage" style="width:200px" maxlength=255/></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">자본금</td>
    <td><input type="text" name="capital" class="number alert focus" message="자본금을 확인해주세요." style="width:100px;text-align:right" maxlength=10/>
      백만원</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">매출액</td>
    <td><input type="text" name="sales" class="number alert focus" message="매출액을 확인해주세요." style="width:100px;text-align:right" maxlength=10/>
백만원</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">예상매출액</td>
    <td><input type="text" name="expect_sales" class="number alert focus" message="예상매출액을 확인해주세요." style="width:100px;text-align:right" maxlength=10/>
백만원</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">경상이익</td>
    <td><input type="text" name="ordinary_income" class="number alert focus" message="경상이익을 확인해주세요." style="width:100px;text-align:right" maxlength=10/>
백만원</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">주생산품</td>
    <td><input type="text" name="main_product" style="width:100px" maxlength=255/></td>
  </tr>

  <tr>
    <td colspan="2" id="t1">회사소개(한글)</td>
    <td style="height:100px;"><textarea name="company_intro" cols="45" rows="5" style="width:450px"/></textarea></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">일본과 거래 경험</td>
    <td>
<?
    unset($creategory_setup);
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'jp_trade_yn';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='required alert no-input' message='일본과 거래 경험을 선택해주세요.'"  ;
    $creategory_setup['loop_end_tag'    ] = "&nbsp;"  ;
    $selectInfo = Base::$CODE_EXIST;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('RADIO',$selectInfo);
?>
    </td>
  </tr>
  <tr>
    <td colspan="2" id="t1">기타 국가와 거래 경험</td>
    <td>
<?
    unset($creategory_setup);
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'etc_trade_yn';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='required alert no-input' message='기타 국가와 거래 경험을 선택해주세요.'"  ;
    $creategory_setup['loop_end_tag'    ] = "&nbsp;"  ;
    $selectInfo = Base::$CODE_EXIST;
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
    <td colspan="2" rowspan="5" id="t1">생산제품 및 취급품목</td>
<?
    }
?>

    <td>한글 <input type="text" name="product_kr[]" style="width:120px"/>&nbsp;&nbsp;&nbsp;
    영문 <input type="text" name="product_en[]" style="width:120px"/>&nbsp;&nbsp;&nbsp;
    일문 <input type="text" name="product_jp[]" style="width:120px"/>
 <input type="hidden" name="product[]" style="width:120px" value="<?=($l+1)?>"/>    
    </td>
  </tr>
<?
}
?>



    <tr>
    <td colspan="2" id="t1">주요거래처(국내)</td>
    <td style="height:70px;"><textarea name="internal_customer" cols="45" rows="3" style="width:450px"/></textarea></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">주요거래처(해외)</td>
    <td style="height:70px;"><textarea name="external_customer" cols="45" rows="3" style="width:450px"/></textarea></td>
  </tr>
  <tr>
    <td rowspan="3" id="t1">첨부파일</td>
    <td id="t1">회사소개서</td>
    <td><input type="file" name="file1"/>&nbsp;<SPAN id=file1_infor></SPAN></td>
  </tr>
  <tr>
    <td id="t1">제품소개서</td>
    <td><input type="file" name="file2"/>&nbsp;<SPAN id=file2_infor></SPAN></td>
  </tr>
  <tr>
    <td id="t1">기타</td>
    <td><input type="file" name="file3"/>&nbsp;<SPAN id=file3_infor></SPAN></td>
  </tr>
</table>
<div id="form_btn">
    <input type=image src="/images/btn_modify.jpg"/>
    <a href="#" title="삭제하기" id=btn_delete><img src="/images/btn_del.jpg" /></a>
    <a href="#" title="목록보기" id=btn_list  ><img src="/images/btn_list.jpg" /></a>
</div>
</form>
