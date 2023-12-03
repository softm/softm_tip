<form id=wForm name=wForm enctype='application/x-www-form-urlencoded' AUTOCOMPLETE='OFF' method='post' onsubmit='return 실행();'>
<!-- <form id=wForm name=wForm enctype='multipart/form-data' method='post' onsubmit='return 파일업로드();'> -->
<!-- <input name='MAX_FILE_SIZE1' type='hidden' value='3' /> -->
<!-- <input type='submit' value='전송'><BR> -->
<!-- <input name='test1' type='text' value='test1'><BR> -->
<!-- <input type='file' name='test_file' id='test_file' style='width:450px'/><BR> -->
<div id="bd_btn">
<input type=image src="/service/images/btn_modify.jpg" style="vertical-align:middle"/>
<a href="#" title="삭제하기" onclick="return 삭제();"><img src="/service/images/btn_del.jpg" /></a>
<a href="#" title="목록보기" onclick="return 목록();"><img src="/service/images/btn_list.jpg" /></a>
</div>
회계연도-번호 : <input type='text' name='accounting_no' size=8 value='' style='width:20px' class='required trim focus alert' maxlength=8 minlength=0 message='회계연도-번호를 입력해주세요.' /><BR>
국가코드 : <input type='text' name='country_code' size=2 value='' style='width:5px' class='required trim focus alert' maxlength=2 minlength=0 message='국가코드를 입력해주세요.' /><BR>
코드 해당값(클래스명) : <input type='text' name='class_name' size=30 value='' style='width:75px' class='required trim focus alert' maxlength=30 minlength=0 message='코드 해당값(클래스명)를 입력해주세요.' /><BR>
회계연도 : <input type='text' name='accounting_year' size=4 value='' style='width:10px' class='required trim focus alert' maxlength=4 minlength=0 message='회계연도를 입력해주세요.' /><BR>
Margin (%) : <input type='text' name='margin_rate' size=5,2 value='' style='width:12px' maxlength=5,2 /><BR>
Markup (%) : <input type='text' name='markup_rate' size=5,2 value='' style='width:12px' maxlength=5,2 /><BR>
SG&A (%) : <input type='text' name='sgna_rate' size=5,2 value='' style='width:12px' maxlength=5,2 /><BR>
환율 : <input type='text' name='exchange_rate' value='' style='width:0px' maxlength= /><BR>
사용유무 : <input type='text' name='use_yn' size=1 value='' style='width:2px' maxlength=1 /><BR>
등록일자 : <input type='text' name='reg_date' value='2014-06-10 13:56' readonly  style='width:100px' maxlength= />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.reg_date,"yyyy-mm-dd hh:ii",this,true)'><BR>
수정일자 : <input type='text' name='mod_date' value='2014-06-10 13:56' readonly  style='width:100px' maxlength= />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.mod_date,"yyyy-mm-dd hh:ii",this,true)'><BR>
작성사용자아이디 : <input type='text' name='reg_user_id' size=11 value='' style='width:27px' class='required trim focus alert' maxlength=11 minlength=0 message='작성사용자아이디를 입력해주세요.' /><BR>
수정사용자아이디 : <input type='text' name='mod_user_id' size=11 value='' style='width:27px' maxlength=11 /><BR>
</form>