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
.... : <input type='text' name='esti_no' size=13 value='' style='width:32px' class='required trim focus alert' maxlength=13 minlength=0 message='....를 입력해주세요.' /><BR>
QUOTATION_DATE : <input type='text' name='quotation_date' value='2014-06-10' readonly  style='width:63px' maxlength= />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.quotation_date,"yyyy-mm-dd hh:ii",this,true)'><BR>
EXPECTED_DELIVERY_DATE : <input type='text' name='expected_delivery_date' value='2014-06-10' readonly  style='width:63px' maxlength= />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.expected_delivery_date,"yyyy-mm-dd hh:ii",this,true)'><BR>
SALES_IN_CHARGE : <input type='text' name='sales_in_charge' size=255 value='' style='width:637px' maxlength=255 /><BR>
NAME_OF_CLIENT : <input type='text' name='name_of_client' size=255 value='' style='width:637px' maxlength=255 /><BR>
PROJECT_NAME : <input type='text' name='project_name' size=255 value='' style='width:637px' maxlength=255 /><BR>
.... : <input type='text' name='country_code' size=2 value='' style='width:5px' maxlength=2 /><BR>
DESTINATION : <input type='text' name='destination' size=50 value='' style='width:125px' maxlength=50 /><BR>
SOLD_TO_PARTY : <input type='text' name='sold_to_party' size=50 value='' style='width:125px' maxlength=50 /><BR>
사용상태 : 0:초기, 1:CRC요청, 2:CRC수신, 3:저장, 8:TP전송, P:Processing, S:TP성공완료, E:TP에러완료 : <input type='text' name='state' size=1 value='' style='width:2px' maxlength=1 /><BR>
.... : <input type='text' name='reg_date' value='2014-06-10 13:56' readonly  style='width:100px' maxlength= />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.reg_date,"yyyy-mm-dd hh:ii",this,true)'><BR>
........ : <input type='text' name='reg_user_id' size=11 value='' style='width:27px' class='required trim focus alert' maxlength=11 minlength=0 message='........를 입력해주세요.' /><BR>
........ : <input type='text' name='reg_user_email' size=255 value='' style='width:637px' class='required trim focus alert' maxlength=255 minlength=0 message='........를 입력해주세요.' /><BR>
</form>