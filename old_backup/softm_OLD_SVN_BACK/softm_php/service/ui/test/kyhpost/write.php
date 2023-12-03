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
zipcode : <input type='text' name='zipcode' size=7 value='' style='width:17px' class='required trim focus alert' maxlength=7 minlength=0 message='zipcode를 입력해주세요.' /><BR>
sido : <input type='text' name='sido' size=4 value='' style='width:10px' maxlength=4 /><BR>
gugun : <input type='text' name='gugun' size=20 value='' style='width:50px' maxlength=20 /><BR>
dong : <input type='text' name='dong' size=24 value='' style='width:60px' class='required trim focus alert' maxlength=24 minlength=0 message='dong를 입력해주세요.' /><BR>
ri : <input type='text' name='ri' size=36 value='' style='width:90px' maxlength=36 /><BR>
bunji : <input type='text' name='bunji' size=17 value='' style='width:42px' maxlength=17 /><BR>
st : <input type='text' name='st' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='st를 입력해주세요.' /><BR>
</form>