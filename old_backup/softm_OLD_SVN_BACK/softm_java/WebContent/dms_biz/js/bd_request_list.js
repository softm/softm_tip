if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}

function onInit(argus) {
//	console.debug(argus);
//    Util.Load.script({src:"/service/ui/css/grid.css",type:"css"});
	sForm = $S("sForm");
	fList(null,1);
}

var sForm     = null;
var sTr       = null;
var S_ITEM_NO = null;

function fSelectRow(no,tr) {
	S_ITEM_NO = no;
	var $cells = $(tr).find("td"); 
//	console.debug(tr.rowIndex,tr);
	if ( sTr ) {
		$(sTr).find("td").css("background", "#fff");
	} else {
	}
	$(tr).find("td").css("background", ROW_SELECTED_COLOR);	
	sTr = tr;
}

function fView(no,tr) {
}

function fGoWrite(init,no) {
	if ( dms.ADMIN_YN == "Y" ) {
		document.location.href = "/service.jsp?p_prg=dms_biz/bd_request_admin_write&p_req_no=" + ( no?no:"" );
	} else {
		if ( init ) {
			document.location.href = "/service.jsp?p_prg=dms_biz/bd_request_write&p_req_no=" + ( no?no:"" );
		} else {
			document.location.href = "/service.jsp?p_prg=dms_biz/bd_request_view&p_req_no=" + ( no?no:"" );
		}
	}	
}

function fGoAdminWrite(no) {
	document.location.href = "/service.jsp?p_prg=dms_biz/bd_request_admin_write&p_req_no=" + ( no?no:"" );
}

function fList(event,p_start) {
//  console.debug(Form.value($N("s_code")));
	var s_code = "";
  var argus  = Form.jsonData(sForm);
//  console.debug(argus);
  argus.p_start = p_start;
  
  call('JSON',"dms_biz/bd_request/search_list",
		  argus,
          function(json) {
      		var firstNo = 0;
      		//,s_code:s_code,s_subject:s_subject
//      		console.debug(json);
          	try {
              if ( json['return'] == '200' ) { // success
            	  if (!sForm.s_status) {
	     	        var status = new Common.createArrangeElement("select","s_status","-전체-").make(json.data_status,"").append($S("tag_status"));
	     	        status.element.onchange = function(e) {}
            	  
	     	        var reqGubun = new Common.createArrangeElement("select","s_req_gubun","-전체-").make(json.data_req_gubun,"").append($S("tag_req_gubun"));
	     	        reqGubun.element.onchange = function(e) {}
            	  }
//                  alert(json['message']);
              	$("#list_data").empty();
              	$("#page_navi").empty();
              	var items = [];
//              	console.debug(json.data.length);
              	var list = json.data;
              	for ( var i=0;i<json.data.length;i++) {
              		var item = list[i];
            		var wDate = item.wriet_date ;
            		var eDate = item.end_date   ;
            		var chargeUser = item.charge_user;
//              		items.push('<td tabindex=' + i +'3' + ' height="30" align="left" bgcolor="#ffffff" style="padding-left:10px"><a href=# onclick="fView(' + item.no  + ');">' + item.subject + '</a></td>');                		
              		items.push('<tr style="cursor:pointer" onclick="fSelectRow(' + item.item_no  + ',this);">');
              		items.push('<td tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff">' + ( item.req_gubun?json.data_req_gubun[item.req_gubun]:"-" ) + '</td>');
              		items.push('<td tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff">' + ( item.ko_name ) + '</td>');
              		items.push('<td tabindex=' + i +'1' + ' height="30" align="left" bgcolor="#ffffff" style="padding-left:5px">'
              		+ '<a href="#" onclick="fGoWrite(' + (item.req_gubun?false:true) + "," + item.req_no + ')">' + ( item.title ) + '</a>' 
              		+'</td>');
              		items.push('<td tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff">' + ( wDate.substring(0,4) + "-" + wDate.substring(4,6) + "-" + wDate.substring(6,8) ) + '</td>');
              		items.push('<td tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff">' + ( eDate.substring(0,4) + "-" + eDate.substring(4,6) + "-" + eDate.substring(6,8) ) + '</td>');
              		items.push('<td tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff">' + ( item.charge_user ) + '</td>');
              		items.push('<td tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff">' + ( item.dept_id ) + '</td>');
              		items.push('<td tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff">' + ( item.status?json.data_status[item.status]:"-" ) + '</td>');
              		items.push('</tr>');     
              	}
              	
              	if ( items.length == 0 ) {
              		items.push('<tr style="cursor:pointer">');
              		items.push('<td colspan="8" tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff">검색된 자료가 없습니다.</td>');
              		items.push('</tr>');  
              	}
              	$("#list_data").html(items.join(''));
              	$("#page_navi").html(json.page_navi);	
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

function fOpenManagerDept() {
	UI.openWindow('/popup.jsp?p_prg=dms_popup/pop_manager_dept', 550, 368,'pop_manager_dept',{scrollbars:'yes'}).focus();
	return false;
} 

function setDept(v) {
	sForm.s_dept_id.value = v;
}

function fDownload(p_item_no) {
//	console.debug($S("list_data").offsetParent.tHead);
	call('FORM',"dms_biz/bd_request/download",
	{
//      	p_file:encodeURIComponent(fName+"." + fExt),
		p_type:"",
		p_item_no:p_item_no
	});
	return false;
}


function fExcel() {
	  var argus  = Form.jsonData(sForm);	
	  call('FORM',"dms_biz/bd_request/search_list_excel", argus,
		        function(json) {
	  },
	  sForm);
	  return false;
}

