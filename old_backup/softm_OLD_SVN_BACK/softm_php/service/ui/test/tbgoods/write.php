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
gid : <input type='text' name='gid' size=10 value='' style='width:25px' class='required trim focus alert' maxlength=10 minlength=0 message='gid를 입력해주세요.' /><BR>
seller_id : <input type='text' name='seller_id' size=20 value='' style='width:50px' class='required trim focus alert' maxlength=20 minlength=0 message='seller_id를 입력해주세요.' /><BR>
category : <input type='text' name='category' size=50 value='' style='width:125px' class='required trim focus alert' maxlength=50 minlength=0 message='category를 입력해주세요.' /><BR>
viewn : <input type='text' name='viewn' size=10 value='' style='width:25px' class='required trim focus alert' maxlength=10 minlength=0 message='viewn를 입력해주세요.' /><BR>
sale_type : <input type='text' name='sale_type' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='sale_type를 입력해주세요.' /><BR>
전시여부: 	판매중:1 승인대기:2 판매종료 :3 : <input type='text' name='sale_ing' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='전시여부: 	판매중:1 승인대기:2 판매종료 :3를 입력해주세요.' /><BR>
새제품 :1 중고제품 :2 : <input type='text' name='gstatus' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='새제품 :1 중고제품 :2를 입력해주세요.' /><BR>
upload_pic : <input type='text' name='upload_pic' size='','' value='' style='width:0px' class='required trim focus alert' maxlength='','' minlength=0 message='upload_pic를 입력해주세요.' /><BR>
use_option : <input type='text' name='use_option' size='','' value='' style='width:0px' class='required trim focus alert' maxlength='','' minlength=0 message='use_option를 입력해주세요.' /><BR>
gname : <input type='text' name='gname' size=100 value='' style='width:250px' class='required trim focus alert' maxlength=100 minlength=0 message='gname를 입력해주세요.' /><BR>
model : <input type='text' name='model' size=100 value='' style='width:250px' class='required trim focus alert' maxlength=100 minlength=0 message='model를 입력해주세요.' /><BR>
brand : <input type='text' name='brand' size=100 value='' style='width:250px' class='required trim focus alert' maxlength=100 minlength=0 message='brand를 입력해주세요.' /><BR>
makec : <input type='text' name='makec' size=30 value='' style='width:75px' class='required trim focus alert' maxlength=30 minlength=0 message='makec를 입력해주세요.' /><BR>
price : <input type='text' name='price' size=10 value='' style='width:25px' class='required trim focus alert' maxlength=10 minlength=0 message='price를 입력해주세요.' /><BR>
sale_price : <input type='text' name='sale_price' size=10 value='' style='width:25px' class='required trim focus alert' maxlength=10 minlength=0 message='sale_price를 입력해주세요.' /><BR>
dealer_price : <input type='text' name='dealer_price' size=10 value='' style='width:25px' class='required trim focus alert' maxlength=10 minlength=0 message='dealer_price를 입력해주세요.' /><BR>
asv : <input type='text' name='asv' size=4 value='' style='width:10px' class='required trim focus alert' maxlength=4 minlength=0 message='asv를 입력해주세요.' /><BR>
size : <input type='text' name='size' size=3 value='' style='width:7px' class='required trim focus alert' maxlength=3 minlength=0 message='size를 입력해주세요.' /><BR>
used : <input type='text' name='used' size=3 value='' style='width:7px' class='required trim focus alert' maxlength=3 minlength=0 message='used를 입력해주세요.' /><BR>
hdd : <input type='text' name='hdd' size=5 value='' style='width:12px' class='required trim focus alert' maxlength=5 minlength=0 message='hdd를 입력해주세요.' /><BR>
pay_type : <input type='text' name='pay_type' size=10 value='' style='width:25px' class='required trim focus alert' maxlength=10 minlength=0 message='pay_type를 입력해주세요.' /><BR>
card_nm : <input type='text' name='card_nm' size=2 value='' style='width:5px' class='required trim focus alert' maxlength=2 minlength=0 message='card_nm를 입력해주세요.' /><BR>
qunt : <input type='text' name='qunt' size=5 value='' style='width:12px' class='required trim focus alert' maxlength=5 minlength=0 message='qunt를 입력해주세요.' /><BR>
qunt_control : <input type='text' name='qunt_control' size='','' value='' style='width:0px' class='required trim focus alert' maxlength='','' minlength=0 message='qunt_control를 입력해주세요.' /><BR>
store_in_day : <input type='text' name='store_in_day' size=20 value='' style='width:50px' class='required trim focus alert' maxlength=20 minlength=0 message='store_in_day를 입력해주세요.' /><BR>
point : <input type='text' name='point' size=8 value='' style='width:20px' class='required trim focus alert' maxlength=8 minlength=0 message='point를 입력해주세요.' /><BR>
freebie : <input type='text' name='freebie' value='' style='width:0px' class='required trim focus alert' maxlength= minlength=0 message='freebie를 입력해주세요.' /><BR>
deliv_price : <input type='text' name='deliv_price' size=5 value='' style='width:12px' class='required trim focus alert' maxlength=5 minlength=0 message='deliv_price를 입력해주세요.' /><BR>
special : <input type='text' name='special' size=20 value='' style='width:50px' class='required trim focus alert' maxlength=20 minlength=0 message='special를 입력해주세요.' /><BR>
comment : <input type='text' name='comment' size=255 value='' style='width:637px' class='required trim focus alert' maxlength=255 minlength=0 message='comment를 입력해주세요.' /><BR>
date : <input type='text' name='date' value='2014-10-23 12:32' readonly  style='width:100px' class='required trim focus alert' maxlength= minlength=0 message='date를 입력해주세요.' />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.date,"yyyy-mm-dd hh:ii",this,true)'><BR>
click : <input type='text' name='click' size=10 value='' style='width:25px' class='required trim focus alert' maxlength=10 minlength=0 message='click를 입력해주세요.' /><BR>
etc : <input type='text' name='etc' value='' style='width:0px' maxlength= /><BR>
</form>