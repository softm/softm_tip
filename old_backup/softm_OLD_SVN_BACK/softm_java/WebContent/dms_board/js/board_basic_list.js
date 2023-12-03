function onInit(argus) {
	fList(null,1);
}

function fList(event,p_start) {
	var s_code = "";
	var s_subject = $S("sForm").s_subject.value;
	var s_context = $S("sForm").s_context.value;
	
	
	if ( $S("sForm").s_code ) {
	    setRestore("s_code"     ,Form.value($N("s_code")[0]));
	    setRestore("s_subject"  ,Form.value($N("s_subject")[0]));		
		s_code = $S("sForm").s_code.value;
	} else {
		s_code = getRestoreValue("s_code")?getRestoreValue("s_code"):"";
	}
	
    call('JSON',"board/basic/basic_list",
        	{p_start:p_start,s_code:s_code,s_subject:s_subject,s_context:s_context},
            function(json) {
                if ( json['return'] == '200' ) { // success
                	if ( !$S("sForm").s_code ) {
		         	    Util.Load.script({src:"/js/common.js",type:'js',callback:function(){
		         	        var sCode = new Common.createArrangeElement("select","s_code","-구분-").make(json.data_board_code,s_code).append($S("tag_div_code"));
		         	        sCode.element.onchange = function(){
		         	    	   fList(null,1);
		         	        }
		         	    }});
                	}

                	$("#list_data").empty();
                	$("#page_navi").empty();
                	var items = [];
//                	console.debug(json.data.length);
                	var list = json.data;
                	for ( var i=0;i<json.data.length;i++) {
                		var item = list[i];
                		items.push('<tr>');
                		items.push('<td height="30" align="center" bgcolor="#ffffff">'+item.no+'</td>');
                		items.push('<td align="center" bgcolor="#ffffff">'+item.code_name+'</td>');
                		items.push('<td bgcolor="#ffffff" style="padding-left:5px;"><a href=# onclick="fView('+item.no+',\''+s_code+'\',\''+s_subject+'\',\''+s_context+'\');">'+item.subject+'</a></td>');
                		items.push('<td align="center" bgcolor="#ffffff">'+item.ename+'</td>');
                		items.push('<td align="center" bgcolor="#ffffff">'+item.write_date+'</td>');
               			items.push('<td align="center" bgcolor="#ffffff">'+item.read_count+'</td>');
               			items.push('</tr>');
                	}
                	if ( items.length == 0 ) {
                		items.push('<tr style="cursor:pointer">');
                		items.push('<td colspan="6" tabindex=' + i +'1' + ' height="30" align="center" bgcolor="#ffffff">검색된 자료가 없습니다.</td>');
                		items.push('</tr>');  
                	}
                	console.debug(items);
                	$("#list_data").html(items.join(''));
                	$("#page_navi").html(json.page_navi);	
                } else {
                    alert(json.message); // error
                }
            }
      );	
    return false;
}

function fView(no, s_code, s_subject, s_context) {
	getUI("dms_board", "board_basic_view", {argus:{p_no:no,s_code:s_code,s_subject:s_subject,s_context:s_context}});
}

function fWrite() {
	getUI("dms_board", "board_basic_write", {argus:{p_mode:'I'}});
	return false;
}

function fDownLoad(fName,fExt) {
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

function fSubmit() {
	fList(null,1);
}

