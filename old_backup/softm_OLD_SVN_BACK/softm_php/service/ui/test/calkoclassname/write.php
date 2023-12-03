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
코드 해당값(클래스명) : <input type='text' name='class_name' size=30 value='' style='width:75px' class='required trim focus alert' maxlength=30 minlength=0 message='코드 해당값(클래스명)를 입력해주세요.' /><BR>
Model Type : <input type='text' name='model_type' size=20 value='' style='width:50px' class='required trim focus alert' maxlength=20 minlength=0 message='Model Type를 입력해주세요.' /><BR>
Passenger : <input type='text' name='passenger' size=10 value='' style='width:25px' class='required trim focus alert' maxlength=10 minlength=0 message='Passenger를 입력해주세요.' /><BR>
Velocity : <input type='text' name='velocity' size=30 value='' style='width:75px' class='required trim focus alert' maxlength=30 minlength=0 message='Velocity를 입력해주세요.' /><BR>
Use : <input type='text' name='use_type' size=30 value='' style='width:75px' class='required trim focus alert' maxlength=30 minlength=0 message='Use를 입력해주세요.' /><BR>
Class : <input type='text' name='class' size=30 value='' style='width:75px' class='required trim focus alert' maxlength=30 minlength=0 message='Class를 입력해주세요.' /><BR>
순서 : <input type='text' name='seq' size=2,0 value='' style='width:5px' class='required trim focus alert' maxlength=2,0 minlength=0 message='순서를 입력해주세요.' /><BR>
사용유무 : <input type='text' name='use_yn' size=1 value='' style='width:2px' maxlength=1 /><BR>
</form>