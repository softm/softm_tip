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
host : <input type='text' name='host' size=60 value='' style='width:150px' class='required trim focus alert' maxlength=60 minlength=0 message='host를 입력해주세요.' /><BR>
db : <input type='text' name='db' size=64 value='' style='width:160px' class='required trim focus alert' maxlength=64 minlength=0 message='db를 입력해주세요.' /><BR>
user : <input type='text' name='user' size=16 value='' style='width:40px' class='required trim focus alert' maxlength=16 minlength=0 message='user를 입력해주세요.' /><BR>
table_name : <input type='text' name='table_name' size=64 value='' style='width:160px' class='required trim focus alert' maxlength=64 minlength=0 message='table_name를 입력해주세요.' /><BR>
column_name : <input type='text' name='column_name' size=64 value='' style='width:160px' class='required trim focus alert' maxlength=64 minlength=0 message='column_name를 입력해주세요.' /><BR>
timestamp : <input type='text' name='timestamp' value='' style='width:0px' class='required trim focus alert' maxlength= minlength=0 message='timestamp를 입력해주세요.' /><BR>
column_priv : <input type='text' name='column_priv' size='','','','' value='' style='width:0px' class='required trim focus alert' maxlength='','','','' minlength=0 message='column_priv를 입력해주세요.' /><BR>
</form>