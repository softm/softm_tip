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
중간평가 배부일 : <input type='text' name='val1' size=20 value='' style='width:50px' maxlength=20 /><BR>
중간평가 회수일 : <input type='text' name='val2' size=20 value='' style='width:50px' maxlength=20 /><BR>
기말평가 배부일 : <input type='text' name='val3' size=20 value='' style='width:50px' maxlength=20 /><BR>
기말평가 회수일 : <input type='text' name='val4' size=20 value='' style='width:50px' maxlength=20 /><BR>
재적인원 : <input type='text' name='val5' size=20 value='' style='width:50px' maxlength=20 /><BR>
중간학년평균 - 국어 : <input type='text' name='avg1' size=20 value='' style='width:50px' maxlength=20 /><BR>
중간학년평균 - 수학 : <input type='text' name='avg2' size=20 value='' style='width:50px' maxlength=20 /><BR>
기말학년평균 - 국어 : <input type='text' name='avg3' size=20 value='' style='width:50px' maxlength=20 /><BR>
기말학년평균 - 수학 : <input type='text' name='avg4' size=20 value='' style='width:50px' maxlength=20 /><BR>
사용자번호 : <input type='text' name='user_no' size=8 value='' style='width:20px' class='required trim focus alert' maxlength=8 minlength=0 message='사용자번호를 입력해주세요.' /><BR>
</form>