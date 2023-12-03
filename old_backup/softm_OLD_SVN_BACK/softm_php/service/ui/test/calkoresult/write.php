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
.... : <input type='text' name='esti_no' size=13 value='' style='width:32px' class='required trim focus alert' maxlength=13 minlength=0 message='....를 입력해주세요.' /><BR>
.... : <input type='text' name='seq' size=2,0 value='' style='width:5px' class='required trim focus alert' maxlength=2,0 minlength=0 message='....를 입력해주세요.' /><BR>
.. : <input type='text' name='qty' size=3 value='' style='width:7px' class='required trim focus alert' maxlength=3 minlength=0 message='..를 입력해주세요.' /><BR>
.. (ex:DSA0000) : <input type='text' name='code' size=20 value='' style='width:50px' class='required trim focus alert' maxlength=20 minlength=0 message='.. (ex:DSA0000)를 입력해주세요.' /><BR>
.. ...(....) : <input type='text' name='value' size=30 value='' style='width:75px' class='required trim focus alert' maxlength=30 minlength=0 message='.. ...(....)를 입력해주세요.' /><BR>
SPECIFICATION : <input type='text' name='specification' size=30 value='' style='width:75px' maxlength=30 /><BR>
..(1), ... (2) : <input type='text' name='standard' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='..(1), ... (2)를 입력해주세요.' /><BR>
.. (ex:DSA0000) : <input type='text' name='pre_crc_code' size=3 value='' style='width:7px' maxlength=3 /><BR>
Item Category <-- "AGC". .. : <input type='text' name='category' size=4 value='' style='width:10px' class='required trim focus alert' maxlength=4 minlength=0 message='Item Category <-- "AGC". ..를 입력해주세요.' /><BR>
Material Number PART CODE [CRC->MATNR] : <input type='text' name='mat_no' size=18 value='' style='width:45px' maxlength=18 /><BR>
XI.. .. CRC XML DATA : <input type='text' name='crc_xml_data' value='' style='width:0px' maxlength= /><BR>
XML DATA : KEY.VALUE .. : <input type='text' name='save_xml_data' value='' style='width:0px' maxlength= /><BR>
TP .. XML : <input type='text' name='send_xml_data' value='' style='width:0px' maxlength= /><BR>
log_xml_data : <input type='text' name='log_xml_data' value='' style='width:0px' maxlength= /><BR>
PDM.. ... TP... ... XML : <input type='text' name='tp_xml_data' value='' style='width:0px' maxlength= /><BR>
.... .. : <input type='text' name='opt_amt' size=15,0 value='' style='width:37px' maxlength=15,0 /><BR>
TP .. : <input type='text' name='tp_amt' size=15,0 value='' style='width:37px' maxlength=15,0 /><BR>
CRC.... : <input type='text' name='crc_send_date' value='2014-06-10 13:56' readonly  style='width:100px' maxlength= />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.crc_send_date,"yyyy-mm-dd hh:ii",this,true)'><BR>
CRC.... : <input type='text' name='crc_recv_date' value='2014-06-10 13:56' readonly  style='width:100px' maxlength= />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.crc_recv_date,"yyyy-mm-dd hh:ii",this,true)'><BR>
TP.... : <input type='text' name='tp_send_date' value='2014-06-10 13:56' readonly  style='width:100px' maxlength= />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.tp_send_date,"yyyy-mm-dd hh:ii",this,true)'><BR>
TP.... : <input type='text' name='tp_recv_date' value='2014-06-10 13:56' readonly  style='width:100px' maxlength= />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.tp_recv_date,"yyyy-mm-dd hh:ii",this,true)'><BR>
.... : <input type='text' name='save_date' value='2014-06-10 13:56' readonly  style='width:100px' maxlength= />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.save_date,"yyyy-mm-dd hh:ii",this,true)'><BR>
sap_esti_no : <input type='text' name='sap_esti_no' size=13 value='' style='width:32px' maxlength=13 /><BR>
send_mail : <input type='text' name='send_mail' size=1 value='' style='width:2px' maxlength=1 /><BR>
send_mail_date : <input type='text' name='send_mail_date' value='2014-06-10 13:56' readonly  style='width:100px' maxlength= />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.send_mail_date,"yyyy-mm-dd hh:ii",this,true)'><BR>
.... : 0:.., 1:CRC.., 2:CRC.., 3:.., 8:TP.., S:TP...., E:TP.... : <input type='text' name='state' size=1 value='' style='width:2px' maxlength=1 /><BR>
margin_rate : <input type='text' name='margin_rate' size=5,2 value='' style='width:12px' maxlength=5,2 /><BR>
markup_rate : <input type='text' name='markup_rate' size=5,2 value='' style='width:12px' maxlength=5,2 /><BR>
sgna_rate : <input type='text' name='sgna_rate' size=5,2 value='' style='width:12px' maxlength=5,2 /><BR>
exchange_rate : <input type='text' name='exchange_rate' value='' style='width:0px' maxlength= /><BR>
복사견적번호 : <input type='text' name='copy_esti_no' size=13 value='' style='width:32px' maxlength=13 /><BR>
복사견적순번 : <input type='text' name='copy_seq' size=2,0 value='' style='width:5px' maxlength=2,0 /><BR>
.... : <input type='text' name='reg_date' value='2014-06-10 13:56' readonly  style='width:100px' maxlength= />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.reg_date,"yyyy-mm-dd hh:ii",this,true)'><BR>
........ : <input type='text' name='reg_user_id' size=11 value='' style='width:27px' class='required trim focus alert' maxlength=11 minlength=0 message='........를 입력해주세요.' /><BR>
........ : <input type='text' name='reg_user_email' size=255 value='' style='width:637px' class='required trim focus alert' maxlength=255 minlength=0 message='........를 입력해주세요.' /><BR>
o_seq : <input type='text' name='o_seq' size=2,0 value='' style='width:5px' class='required trim focus alert' maxlength=2,0 minlength=0 message='o_seq를 입력해주세요.' /><BR>
</form>