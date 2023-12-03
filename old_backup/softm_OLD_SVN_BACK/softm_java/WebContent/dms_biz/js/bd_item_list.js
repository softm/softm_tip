function onInit(argus) {
//	console.debug(argus);
//    Util.Load.script({src:"/service/ui/css/grid.css",type:"css"});
	fList(null,1);
}
var sTr = null;
var sTr2 = null;
var S_SCHEDULE_NO = null;
var S_ITEM_NO = null;
function fList(event,p_start) {
//    console.debug(Form.value($N("s_code")));
	var s_code = "";
	
    call('JSON',"dms_biz/bd_item/sch_list",
        	{p_start:p_start,p_how_many:5},
            function(json) {
        		var firstNo = 0;
        		//,s_code:s_code,s_subject:s_subject
//        		console.debug(json);
            	try {
                if ( json['return'] == '200' ) { // success
//                    alert(json['message']);
                	$("#list_data").empty();
                	$("#page_navi").empty();
                	var items = [];
//                	console.debug(json.data.length);
                	var list = json.data;
                	for ( var i=0;i<json.data.length;i++) {
                		var item = list[i];
                		bdSDay = item.bd_start_day ;
                		bdEDay = item.bd_end_day ;
                		if (i == 0 ) firstNo = item.schedule_no;
//                		items.push('<td tabindex=' + i +'3' + ' height="30" align="left" bgcolor="#ffffff" style="padding-left:10px"><a href=# onclick="fView(' + item.no  + ');">' + item.subject + '</a></td>');                		
                		items.push('<tr style="cursor:pointer" onclick="fView(' + item.schedule_no  + ',this);">');
                		items.push('<td tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff">' + json.data_gubun_code[item.gubun_code] + '</td>');
                		items.push('<td tabindex=' + i +'2' + ' height="30" align="center" bgcolor="#ffffff">' + item.bd_no + '</td>');
                		items.push('<td tabindex=' + i +'2' + ' height="30" align="center" bgcolor="#ffffff">' + json.data_name_code[item.name_code] + '</td>');

                		items.push('<td tabindex=' + i +'4' + ' height="30" align="center" bgcolor="#ffffff">' + bdSDay.substring(0,4) + "-" + bdSDay.substring(4,6) + "-" + bdSDay.substring(6,8) + '</td>');
                		items.push('<td tabindex=' + i +'5' + ' height="30" align="center" bgcolor="#ffffff">' + item.bd_time.substring(0,2) + ":"  + item.bd_time.substring(2)  + '</td>');
                		items.push('<td tabindex=' + i +'5' + ' height="30" align="left" bgcolor="#ffffff" style="padding-left:10px">' + item.bd_place + '</td>');
                		
                		items.push('<td tabindex=' + i +'4' + ' height="30" align="center" bgcolor="#ffffff">' + bdEDay.substring(0,4) + "-" + bdEDay.substring(4,6) + "-" + bdEDay.substring(6,8) + '</td>');
                		items.push('</tr>');                		
//                        <td bgcolor="#ffffff" style="padding-left:10px;">본사 5층 이사회의실</td>
                	}
                	if ( items.length == 0 ) {
                		items.push('<tr style="cursor:pointer">');
                		items.push('<td colspan="7" tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff">검색된 자료가 없습니다.</td>');
                		items.push('</tr>');  
                	}
                	$("#list_data").html(items.join(''));
                	$("#page_navi").html(json.page_navi);	
                } else {
                    alert(json.message); // error
                }
            	} catch(e) {
            		console.debug(e);
            	}     
            	
            	fView(firstNo,$(list_data).find("tr").eq(0).get(0));            	
            }
      );	
    return false;
}

function fView(no,tr) {
	S_SCHEDULE_NO = no;
	var $cells = $(tr).find("td"); 
//	console.debug(tr.rowIndex,tr);
	if ( sTr ) {
		$(sTr).find("td").css("background", "#fff");
	} else {
	}
	$(tr).find("td").css("background", ROW_SELECTED_COLOR);	
	sTr = tr;
	
	fItemList(null,1);
}

function fSelectRow(no,tr) {
	S_ITEM_NO = no;
	var $cells = $(tr).find("td"); 
//	console.debug(tr.rowIndex,tr);
	if ( sTr2 ) {
		$(sTr2).find("td").css("background", "#fff");
	} else {
	}
	$(tr).find("td").css("background", ROW_SELECTED_COLOR);	
	sTr2 = tr;
}

function fView2(no,tr) {
	document.location.href = "/service.jsp?p_prg=dms_biz/bd_item_view&p_item_no=" + no;
}

function fItemList(event,p_start) {
//  console.debug(Form.value($N("s_code")));
	var s_code = "";
	
  call('JSON',"dms_biz/bd_item/list",
      	{p_start:p_start,s_schedule_no:S_SCHEDULE_NO},
          function(json) {
      		var firstNo = 0;
      		//,s_code:s_code,s_subject:s_subject
//      		console.debug(json);
          	try {
          		        		
              if ( json['return'] == '200' ) { // success
//                  alert(json['message']);
              	$("#list_data1").empty();
              	$("#page_navi1").empty();
              	var items = [];
//              	console.debug(json.data.length);
              	var list = json.data;
              	for ( var i=0;i<json.data.length;i++) {
              		var item = list[i];
//              		items.push('<td tabindex=' + i +'3' + ' height="30" align="left" bgcolor="#ffffff" style="padding-left:10px"><a href=# onclick="fView(' + item.no  + ');">' + item.subject + '</a></td>');                		
              		items.push('<tr style="cursor:pointer" onclick="fSelectRow(' + item.item_no  + ',this);">');
              		items.push('<td tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff"><input type="checkbox" name="chk_item" value="' + item.item_no + '"></td>');
              		items.push('<td tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff"><input type="text" name="col" value=' + item.col + ' size=5 style="text-align:center"></td>');
              		items.push('<td tabindex=' + i +'2' + ' height="30" align="center" bgcolor="#ffffff">' + json.data_item_code2[item.item_code2] + '</td>');
              		items.push('<td tabindex=' + i +'2' + ' height="30" align="center" bgcolor="#ffffff">' + json.data_item_code3[item.item_code3] + '</td>');
              		items.push('<td tabindex=' + i +'2' + ' height="30" align="center" bgcolor="#ffffff">' + json.data_item_code4[item.item_code4] + '</td>');
              		items.push('<td tabindex=' + i +'2' + ' height="30" align="left"   bgcolor="#ffffff" style="padding-left:3px"><a href="#" onclick="fView2(' + item.item_no  + ',this);">' 
              				+ "<div class='textOf' style='width:230px'><nobr>"
              				+ item.item_name
              				+ "</nobr></div>"              				
              				+ '</a></td>');
              		items.push('<td tabindex=' + i +'2' + ' height="30" align="center" bgcolor="#ffffff">-</td>');
              		items.push('<td tabindex=' + i +'2' + ' height="30" align="center" bgcolor="#ffffff">' + item.dept_code + '</td>');              		
              		items.push('<td tabindex=' + i +'2' + ' height="30" align="center" bgcolor="#ffffff">' + json.data_item_status[item.status] + '</td>');
            		items.push('<td tabindex=' + i +'6' + ' height="30" align="center" bgcolor="#ffffff">' +
            				(
            						item.display_att_file?
            						"<div class='textOf' style='width:80px'><nobr><a href='#' onclick='return fDownload(" + item.item_no + ");' title='" + item.display_att_file + "'><img src='/images/icon_han.gif' border='0'>" + "</a></nobr></div>"
            						:""
            				)
            				+ '</td>');
            		items.push('<td tabindex=' + i +'6' + ' height="30" align="center" bgcolor="#ffffff">' +
            				(
            						item.col==0
            						?"<font color='red'>미설정</font>"
            						:"<font color='blue'>설정</font>"
            				)
            				+ '</td>');            		
            		items.push('</tr>');     
              	}
              	
              	if ( items.length == 0 ) {
              		items.push('<tr style="cursor:pointer">');
              		items.push('<td colspan="11" tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff">검색된 자료가 없습니다.</td>');
              		items.push('</tr>');  
              	}
              	$("#list_data1").html(items.join(''));
              	$("#page_navi1").html(json.page_navi);	
              } else {
                  alert(json.message); // error
              }
          	} catch(e) {
//          		console.debug(e);
          	}     
          }
    );
  return false;
}

function fDownload(p_item_no) {
//	console.debug($S("list_data").offsetParent.tHead);
	call('FORM',"dms_biz/bd_item/download",
			{
//      	p_file:encodeURIComponent(fName+"." + fExt),
		p_type:"",
		p_item_no:p_item_no
			});
	return false;
}

function fGoWrite() {
	document.location.href = "/service.jsp?p_prg=dms_biz/bd_item_write&p_schedule_no=" + S_SCHEDULE_NO;
}

function fCheckAll(b) { 
//	console.debug($('input[name="chk_item"]'));
	$.each( $('input[name="chk_item"]'), function() {
		this.checked = b;
	});
}

function fDelete() {
	console.debug($('input[name="chk_item"]:checked'));
	if ( $('input[name="chk_item"]:checked').length == 0 ) {
		alert("선택된 안건이 없습니다.")
	} else {
		var json = Form.jsonData($S("wForm"));
		var sendJson = json.chk_item;
		sendJson.p_mode = "M";
		console.debug( sendJson );	
	    if( confirm("삭제하시겠습니까?") ) {
	        call("JSON","dms_biz/bd_item/delete",
	        	{p_mode:"M",chk_item:sendJson},
	            function(json) {
	                if ( json['return'] == '200' ) { // success      
	                    alert(json.message);
	                    fList(null,1);    	                    
	                } else {
	                    alert(json.message); // error
	                }
	        	}
	        );
	    }
	}
    return false;
}

function fUpdateStatus(status,return_reaseon) {
	console.debug($('input[name="chk_item"]:checked'));
	if ( $('input[name="chk_item"]:checked').length == 0 ) {
		alert("선택된 안건이 없습니다.")
	} else {	
		return_reaseon?return_reaseon:"";
		
		var json = Form.jsonData($S("wForm"));
		var itemNos = json.chk_item;
		
		var title = "";
		if ( status == "2") { // 반려
		} else if ( status == "3") { // 확정
			title = "확정 처리 하시겠습니까?";
		}
		
		if( !title || confirm(title) ) {
			call("JSON","dms_biz/bd_item/update_status",
				{
					p_status:status,
					chk_item:itemNos,
					p_return_reaseon:return_reaseon
				},
				function(json) {
					if ( json['return'] == '200' ) { // success      
						alert(json.message);
						fItemList(null,1);
					} else {
						alert(json.message); // error
					}
				}
			);
		}
	}
	return false;
}

function fOpenReturnReason() {
	if ( $('input[name="chk_item"]:checked').length == 0 ) {
		alert("선택된 안건이 없습니다.")
	} else {	
		UI.openWindow('/popup.jsp?p_prg=dms_popup/pop_return_reason', 550, 368,'pop_return_reason',{scrollbars:'yes'}).focus();
	}
	return false;
}

