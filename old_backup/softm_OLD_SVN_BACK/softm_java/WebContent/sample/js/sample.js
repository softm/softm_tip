function onInit(argus) {
//	console.debug(argus);
//    Util.Load.script({src:"/service/ui/css/grid.css",type:"css"});
	fList(null,1);
}

function fList(event,p_start) {

//    console.debug(Form.value($N("s_code")));
	var s_code = "";
	var s_subject = $S("sForm").s_subject.value;
	if ( $S("sForm").s_code ) {
	    setRestore("s_code"     ,Form.value($N("s_code")[0]));
	    setRestore("s_subject"  ,Form.value($N("s_subject")[0]));		
		s_code = $S("sForm").s_code.value;
	} else {
		s_code = getRestoreValue("s_code")?getRestoreValue("s_code"):"";
	}
	
    call('JSON',"sample/notice/list",
        	{p_start:p_start,s_code:s_code,s_subject:s_subject},
            function(json) {
                if ( json['return'] == '200' ) { // success
                	if ( !$S("sForm").s_code ) {
		         	    Util.Load.script({src:"/js/common.js",type:'js',callback:function(){
//		         	    	alert(s_code);
		         	        var sCode = new Common.createArrangeElement("select","s_code","-구분-").make(json.data_board_code,s_code).append($S("tag_div_code"));
		         	        sCode.element.onchange = function(){
		         	    	   fList(null,1);
		         	        }
		         	    }});
                	}
//                    alert(json['message']);
                	$("#list_data").empty();
                	$("#page_navi").empty();
                	var items = [];
//                	console.debug(json.data.length);
                	var list = json.data;
                	for ( var i=0;i<json.data.length;i++) {
                		var item = list[i];
                		items.push('<tr style="cursor:pointer">');
                		items.push('<td tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff">' + item.rnum + '</td>');
                		items.push('<td tabindex=' + i +'2' + ' height="30" align="center" bgcolor="#ffffff">' + json.data_board_code[item.code] + '</td>');
                		items.push('<td tabindex=' + i +'3' + ' height="30" align="left" bgcolor="#ffffff" style="padding-left:10px"><a href=# onclick="fView(' + item.no  + ');">' + item.subject + '</a></td>');
                		items.push('<td tabindex=' + i +'4' + ' height="30" align="center" bgcolor="#ffffff">' + item.writer + '</td>');
                		items.push('<td tabindex=' + i +'5' + ' height="30" align="center" bgcolor="#ffffff">' + item.write_date + '</td>');
                		items.push('<td tabindex=' + i +'6' + ' height="30" align="center" bgcolor="#ffffff">' +
(
		item.display_att_file?
		"<div class='textOf' style='width:80px'><nobr><a href='#' onclick='fDownload(" + item.no + ");' title='" + item.display_att_file + "'>" + item.display_att_file + "</a></nobr></div>"
		:""
)                				
                				+ '</td>');
                		items.push('<td tabindex=' + i +'7' + ' height="30" align="center" bgcolor="#ffffff">' + item.read_count + '</td>');
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
            }
      );	
    return false;
}

function fView(no) {
	getUI("sample", "sample_view", {argus:{p_no:no}});
}

function fWrite() {
	getUI("sample", "sample_write", {argus:{p_mode:'I'}});
	return false;
}

function fListDownload(fName,fExt) {
//	console.debug($S("list_data").offsetParent.tHead);
    call('FORM',"common/save_download",
    {
//      	p_file:encodeURIComponent(fName+"." + fExt),
      	p_file:(fName+"." + fExt),
      	p_data:
      	"<table>" +
      		$S("list_data").offsetParent.tHead.outerHTML +
      		$S("list_data").outerHTML+
      	"</table>"
    });
    return false;
}

function fDownload(p_no) {
//	console.debug($S("list_data").offsetParent.tHead);
	call('FORM',"sample/notice/download",
			{
//      	p_file:encodeURIComponent(fName+"." + fExt),
		p_type:"notice",
		p_no:p_no
			});
	return false;
}

