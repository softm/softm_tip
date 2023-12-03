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
공정항목내역코드번호 : <input type='text' name='proc_bd_cd_no' size=10 value='' style='width:25px' class='required trim focus alert' maxlength=10 minlength=0 message='공정항목내역코드번호를 입력해주세요.' /><BR>
공정항목내역코드 : <input type='text' name='proc_bd_cd' size=12 value='' style='width:30px' class='required trim focus alert' maxlength=12 minlength=0 message='공정항목내역코드를 입력해주세요.' /><BR>
공정항목코드명 : <input type='text' name='proc_bd_nm' size=255 value='' style='width:637px' class='required trim focus alert' maxlength=255 minlength=0 message='공정항목코드명를 입력해주세요.' /><BR>
공정항목내역 Detail : <input type='text' name='proc_dt_nm' size=255 value='' style='width:637px' class='required trim focus alert' maxlength=255 minlength=0 message='공정항목내역 Detail를 입력해주세요.' /><BR>
대공정코드 : <input type='text' name='proc_cd' size=3 value='' style='width:7px' class='required trim focus alert' maxlength=3 minlength=0 message='대공정코드를 입력해주세요.' /><BR>
공정항목코드 : <input type='text' name='proc_it_cd' size=9 value='' style='width:22px' class='required trim focus alert' maxlength=9 minlength=0 message='공정항목코드를 입력해주세요.' /><BR>
규격 : <input type='text' name='std' size=50 value='' style='width:125px' maxlength=50 /><BR>
단위 : <input type='text' name='unit' size=50 value='' style='width:125px' maxlength=50 /><BR>
재료비 : <input type='text' name='m_amt' size=11 value='' style='width:27px' maxlength=11 /><BR>
노무비 : <input type='text' name='l_amt' size=11 value='' style='width:27px' maxlength=11 /><BR>
경비 : <input type='text' name='e_amt' size=11 value='' style='width:27px' maxlength=11 /><BR>
</form>