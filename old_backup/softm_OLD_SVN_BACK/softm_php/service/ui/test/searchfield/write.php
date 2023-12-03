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
검색필드번호 : <input type='text' name='sf_no' size=10 value='' style='width:25px' class='required trim focus alert' maxlength=10 minlength=0 message='검색필드번호를 입력해주세요.' /><BR>
부모 검색필드번호 : <input type='text' name='g_sf_no' size=10 value='' style='width:25px' maxlength=10 /><BR>
검색필드명 : <input type='text' name='sf_nm' size=255 value='' style='width:637px' class='required trim focus alert' maxlength=255 minlength=0 message='검색필드명를 입력해주세요.' /><BR>
정렬 순서 : <input type='text' name='o_seq' size=4 value='' style='width:10px' class='required trim focus alert' maxlength=4 minlength=0 message='정렬 순서를 입력해주세요.' /><BR>
</form>