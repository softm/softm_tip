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
cap_cd : <input type='text' name='cap_cd' size=2 value='' style='width:5px' class='required trim focus alert' maxlength=2 minlength=0 message='cap_cd를 입력해주세요.' /><BR>
cap_nm : <input type='text' name='cap_nm' size=20 value='' style='width:50px' class='required trim focus alert' maxlength=20 minlength=0 message='cap_nm를 입력해주세요.' /><BR>
x1좌표 : <input type='text' name='x1' size=8 value='' style='width:20px' maxlength=8 /><BR>
y1좌표 : <input type='text' name='y1' size=8 value='' style='width:20px' maxlength=8 /><BR>
x2좌표 : <input type='text' name='x2' size=8 value='' style='width:20px' maxlength=8 /><BR>
y2좌표 : <input type='text' name='y2' size=8 value='' style='width:20px' maxlength=8 /><BR>
</form>