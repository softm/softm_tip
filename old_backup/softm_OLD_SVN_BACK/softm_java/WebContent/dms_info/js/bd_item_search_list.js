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
function fOpenManagerDept() {
	UI.openWindow('/popup.jsp?p_prg=dms_popup/pop_manager_dept', 550, 368,'pop_manager_dept',{scrollbars:'yes'}).focus();
	return false;
} 

function setDept(v) {
	sForm.s_dept_code.value = v;
}

function fView(no,tr) {
}

// 작업 중임. 아직 클래스 코딩 안됨.
function fList(event,p_start) {
//  console.debug(Form.value($N("s_code")));
	var s_code = "";
  var argus  = Form.jsonData(sForm);
//  console.debug(argus);
  argus.p_start = p_start;
  
  call('JSON',"dms_biz/bd_item/search_list",
		  argus,
          function(json) {
      		var firstNo = 0;
      		//,s_code:s_code,s_subject:s_subject
//      		console.debug(json);
          	try {
              if ( json['return'] == '200' ) { // success
            	  if (!sForm.s_name_code) {
  	              	var dataNameCode = json_clone(json.data_name_code);
	     	        var nameCode = new Common.createArrangeElement("select","s_name_code","-전체-").make(dataNameCode,"").append($S("tag_name_code"));
	     	        nameCode.element.onchange = function(e) {}
            	  
	     	        var dataResultCode = json_clone(json.data_result_code);
	     	        var resultCode = new Common.createArrangeElement("select","s_result_code","-전체-").make(dataResultCode,"").append($S("tag_result_code"));
	     	        resultCode.element.onchange = function(e) {}
            	  }
//                  alert(json['message']);
              	$("#list_data").empty();
              	$("#page_navi").empty();
              	var items = [];
//              	console.debug(json.data.length);
              	var list = json.data;
              	for ( var i=0;i<json.data.length;i++) {
              		var item = list[i];
              		
                	var bdSDay = item.bd_start_day;
                	
//              		items.push('<td tabindex=' + i +'3' + ' height="30" align="left" bgcolor="#ffffff" style="padding-left:10px"><a href=# onclick="fView(' + item.no  + ');">' + item.subject + '</a></td>');                		
              		items.push('<tr style="cursor:pointer" onclick="fSelectRow(' + item.item_no  + ',this);">');
              		items.push('<td tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff">' + item.bd_no + '</td>');
              		items.push('<td tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff">' + bdSDay.substring(0,4) + "-" + bdSDay.substring(4,6) + "-" + bdSDay.substring(6,8) + '</td>');
              		items.push('<td tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff">' + item.col + '</td>');
              		items.push('<td tabindex=' + i +'2' + ' height="30" align="left"   bgcolor="#ffffff" style="padding-left:3px"><a href="#" onclick="fView(' + item.item_no  + ',this);">' 
              				+ "<div class='textOf' style='width:230px'><nobr>"
              				+ item.item_name
              				+ "</nobr></div>"              				
              				+ '</a></td>');
              		items.push('<td tabindex=' + i +'2' + ' height="30" align="center" bgcolor="#ffffff">' + item.dept_code + '</td>');              		
              		items.push('<td tabindex=' + i +'2' + ' height="30" align="center" bgcolor="#ffffff">' + item.result_name + '</td>');
            		items.push('<td tabindex=' + i +'6' + ' height="30" align="center" bgcolor="#ffffff">' +
            				(
            						item.display_att_file?
            						"<div class='textOf' style='width:80px'><nobr><a href='#' onclick='return fDownload(" + item.item_no + ");' title='" + item.display_att_file + "'><img src='/images/icon_han.gif' border='0'>" + "</a></nobr></div>"
            						:""
            				)
            				+ '</td>');
            		items.push('<td tabindex=' + i +'6' + ' height="30" align="center" bgcolor="#ffffff">' +
            				(
            						item.read_count
            				)
            				+ '</td>');            		
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


function fExcel() {
	  var argus  = Form.jsonData(sForm);	
	  call('FORM',"dms_biz/bd_item/search_list_excel", argus,
		        function(json) {
	  },
	  sForm);
	  return false;
}