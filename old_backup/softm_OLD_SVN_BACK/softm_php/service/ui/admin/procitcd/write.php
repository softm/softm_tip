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
공종항목코드번호 : <input type='text' name='proc_it_cd_no' size=10 value='' style='width:25px' class='required trim focus alert' maxlength=10 minlength=0 message='공종항목코드번호를 입력해주세요.' /><BR>
공종항목코드 : <input type='text' name='proc_it_cd' size=9 value='' style='width:22px' class='required trim focus alert' maxlength=9 minlength=0 message='공종항목코드를 입력해주세요.' /><BR>
공종항목코드명 : <input type='text' name='proc_it_nm' size=255 value='' style='width:637px' class='required trim focus alert' maxlength=255 minlength=0 message='공종항목코드명를 입력해주세요.' /><BR>
대공종코드 : <input type='text' name='proc_cd' size=3 value='' style='width:7px' class='required trim focus alert' maxlength=3 minlength=0 message='대공종코드를 입력해주세요.' /><BR>
</form>