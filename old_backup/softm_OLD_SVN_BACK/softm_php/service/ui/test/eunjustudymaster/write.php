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
STUDY ID : <input type='text' name='s_id' size=10 value='' style='width:25px' class='required trim focus alert' maxlength=10 minlength=0 message='STUDY ID를 입력해주세요.' /><BR>
년도 : <input type='text' name='yyyy' size=4 value='' style='width:10px' class='required trim focus alert' maxlength=4 minlength=0 message='년도를 입력해주세요.' /><BR>
학기(1,2) : <input type='text' name='term' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='학기(1,2)를 입력해주세요.' /><BR>
중간(1)/기말(2) : <input type='text' name='gubun' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='중간(1)/기말(2)를 입력해주세요.' /><BR>
학년 : <input type='text' name='hak' size=20 value='' style='width:50px' class='required trim focus alert' maxlength=20 minlength=0 message='학년를 입력해주세요.' /><BR>
반 : <input type='text' name='ban' size=20 value='' style='width:50px' class='required trim focus alert' maxlength=20 minlength=0 message='반를 입력해주세요.' /><BR>
번호 : <input type='text' name='num' size=10 value='' style='width:25px' class='required trim focus alert' maxlength=10 minlength=0 message='번호를 입력해주세요.' /><BR>
학생명 : <input type='text' name='mem_name' size=20 value='' style='width:50px' maxlength=20 /><BR>
남(M)/여(F) : <input type='text' name='sex' size=1 value='' style='width:2px' maxlength=1 /><BR>
국어점수 : <input type='text' name='result_1' value='' style='width:0px' maxlength= /><BR>
수학점수 : <input type='text' name='result_2' value='' style='width:0px' maxlength= /><BR>
작성일자 : <input type='text' name='reg_date' value='' style='width:0px' class='required trim focus alert' maxlength= minlength=0 message='작성일자를 입력해주세요.' /><BR>
가정통신 : <input type='text' name='content' value='' style='width:0px' maxlength= /><BR>
사용자번호 : <input type='text' name='user_no' size=8 value='' style='width:20px' class='required trim focus alert' maxlength=8 minlength=0 message='사용자번호를 입력해주세요.' /><BR>
</form>