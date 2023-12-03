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
.... : <input type='text' name='country_code' size=2 value='' style='width:5px' class='required trim focus alert' maxlength=2 minlength=0 message='....를 입력해주세요.' /><BR>
..... : <input type='text' name='country_en_name' size=50 value='' style='width:125px' maxlength=50 /><BR>
..... : <input type='text' name='country_kr_name' size=50 value='' style='width:125px' maxlength=50 /><BR>
DESTINATION : <input type='text' name='destination' size=50 value='' style='width:125px' class='required trim focus alert' maxlength=50 minlength=0 message='DESTINATION를 입력해주세요.' /><BR>
SOLD_TO_PARTY : <input type='text' name='sold_to_party' size=50 value='' style='width:125px' maxlength=50 /><BR>
</form>