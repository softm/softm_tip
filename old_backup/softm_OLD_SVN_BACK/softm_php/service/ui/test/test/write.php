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
k1 : <input type='text' name='k1' size=11 value='' style='width:27px' class='required trim focus alert' maxlength=11 minlength=0 message='k1를 입력해주세요.' /><BR>
f1 : <input type='text' name='f1' size=255 value='' style='width:637px' maxlength=255 /><BR>
f2 : <input type='text' name='f2' size=255 value='' style='width:637px' maxlength=255 /><BR>
f3 : <input type='text' name='f3' size=255 value='' style='width:637px' maxlength=255 /><BR>
f4 : <input type='text' name='f4' size=255 value='' style='width:637px' maxlength=255 /><BR>
f5 : <input type='text' name='f5' size=255 value='' style='width:637px' maxlength=255 /><BR>
f6 : <input type='text' name='f6' value='2014-06-10' readonly  style='width:63px' maxlength= />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.f6,"yyyy-mm-dd hh:ii",this,true)'><BR>
</form>