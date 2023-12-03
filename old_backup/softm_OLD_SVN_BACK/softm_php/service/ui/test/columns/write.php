<form id=wForm name=wForm enctype='application/x-www-form-urlencoded' AUTOCOMPLETE='OFF' method='post' onsubmit='return 실행();'>
<!-- <form id=wForm name=wForm enctype='multipart/form-data' method='post' onsubmit='return 파일업로드();'> -->
<!-- <input name='MAX_FILE_SIZE1' type='hidden' value='3' /> -->
<!-- <input type='submit' value='전송'><BR> -->
<!-- <input name='test1' type='text' value='test1'><BR> -->
<!-- <input type='file' name='test_file' id='test_file' style='width:450px'/><BR> -->
<div id="bd_btn">
<input type=image src="images/btn_modify.jpg" style="vertical-align:middle"/>
<a href="#" title="삭제하기" onclick="return 삭제();"><img src="images/btn_del.jpg" /></a>
<a href="#" title="목록보기" onclick="return 목록();"><img src="images/btn_list.jpg" /></a>
</div>
table_catalog : <input type='text' name='table_catalog' size=512 value='' style='width:1280px' maxlength=512 /><BR>
table_schema : <input type='text' name='table_schema' size=64 value='' style='width:160px' class='required trim focus alert' maxlength=64 minlength=0 message='table_schema를 입력해주세요.' /><BR>
table_name : <input type='text' name='table_name' size=64 value='' style='width:160px' class='required trim focus alert' maxlength=64 minlength=0 message='table_name를 입력해주세요.' /><BR>
column_name : <input type='text' name='column_name' size=64 value='' style='width:160px' class='required trim focus alert' maxlength=64 minlength=0 message='column_name를 입력해주세요.' /><BR>
ordinal_position : <input type='text' name='ordinal_position' size=21 value='' style='width:52px' class='required trim focus alert' maxlength=21 minlength=0 message='ordinal_position를 입력해주세요.' /><BR>
column_default : <input type='text' name='column_default' size=64 value='' style='width:160px' maxlength=64 /><BR>
is_nullable : <input type='text' name='is_nullable' size=3 value='' style='width:7px' class='required trim focus alert' maxlength=3 minlength=0 message='is_nullable를 입력해주세요.' /><BR>
data_type : <input type='text' name='data_type' size=64 value='' style='width:160px' class='required trim focus alert' maxlength=64 minlength=0 message='data_type를 입력해주세요.' /><BR>
character_maximum_length : <input type='text' name='character_maximum_length' size=21 value='' style='width:52px' maxlength=21 /><BR>
character_octet_length : <input type='text' name='character_octet_length' size=21 value='' style='width:52px' maxlength=21 /><BR>
numeric_precision : <input type='text' name='numeric_precision' size=21 value='' style='width:52px' maxlength=21 /><BR>
numeric_scale : <input type='text' name='numeric_scale' size=21 value='' style='width:52px' maxlength=21 /><BR>
character_set_name : <input type='text' name='character_set_name' size=64 value='' style='width:160px' maxlength=64 /><BR>
collation_name : <input type='text' name='collation_name' size=64 value='' style='width:160px' maxlength=64 /><BR>
column_type : <input type='text' name='column_type' value='' style='width:0px' class='required trim focus alert' maxlength= minlength=0 message='column_type를 입력해주세요.' /><BR>
column_key : <input type='text' name='column_key' size=3 value='' style='width:7px' class='required trim focus alert' maxlength=3 minlength=0 message='column_key를 입력해주세요.' /><BR>
extra : <input type='text' name='extra' size=20 value='' style='width:50px' class='required trim focus alert' maxlength=20 minlength=0 message='extra를 입력해주세요.' /><BR>
privileges : <input type='text' name='privileges' size=80 value='' style='width:200px' class='required trim focus alert' maxlength=80 minlength=0 message='privileges를 입력해주세요.' /><BR>
column_comment : <input type='text' name='column_comment' size=255 value='' style='width:637px' class='required trim focus alert' maxlength=255 minlength=0 message='column_comment를 입력해주세요.' /><BR>
</form>