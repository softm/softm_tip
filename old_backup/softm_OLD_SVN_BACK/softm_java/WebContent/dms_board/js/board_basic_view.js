var P_NO = null;
function onInit(argus) {
	console.debug("argus ===> " + argus);
	console.debug(argus);
	P_NO = argus.p_no;
	s_code = argus.s_code;
	s_subject = argus.s_subject;
	s_context = argus.s_context;
	init();
}

function init() {
	if  ( P_NO ) {
		call('JSON',"board/basic/basic_view",
			{p_no:P_NO,s_code:s_code,s_subject:s_subject,s_context:s_context},
		    function(json) {
		        if ( json['return'] == '200' ) { // success   
		            UI.bind(json.data,{
		            	real_att_file:function(fe,v){
		            		fe.innerHTML = "<a href='#' onclick='fDownload(" + json.data.no + ");'>" + json.data.display_att_file + "</a>";
		            	}
		            });
		            $("#next_data").empty();
                	var items = [];
                	var list = json.next_data;

                	var pre_bbs = "";
                	var next_bbs = "";
                	
                	for ( var i=0;i<json.next_data.length;i++) {
                		var item = list[i];
                		if(item.ne == 1) {
                			pre_bbs = '<a href=# onclick="fView(\''+item.no+'\',\''+s_code+'\',\''+s_subject+'\',\''+s_context+'\');">'+item.subject+'</a>';
                		} else if (item.ne == 2) {
                			next_bbs = '<a href=# onclick="fView(\''+item.no+'\',\''+s_code+'\',\''+s_subject+'\',\''+s_context+'\');">'+item.subject+'</a>';
                		}
                	}
                	
                	items.push('<table width="382" border="0" cellspacing="0" cellpadding="0">');
                	items.push('<tr>');
                	items.push('<td width="50" height="30" align="center"><img src="/images/btn_up.gif" border="0" align="absmiddle"></td>');
                	items.push('<td align="left">이전글 : '+pre_bbs+'</td>');
                	items.push('</tr>');
                	items.push('<tr>');
                	items.push('<td height="30" align="center"><img src="/images/btn_up.gif" border="0" align="absmiddle"></td>');
                	items.push('<td align="left">다음글 : '+next_bbs+'</td>');
                	items.push('</tr>');
                	items.push('</table>');

                	$("#next_data").html(items.join(''));
		        } else {
		            alert(json.message); // error
		        }
		    }
		);	
	} else {
		alert("조회정보가 불충분 합니다.")
	}
    return false;
}

function fGoUpdate(no) {
	getUI("dms_board","board_basic_modify",{argus:{p_no:no}});
	return false;
}

function fList(no) {
	getUI("dms_board","board_basic_list",{argus:{p_no:no}});
	return false;
}

function fDelete(p_no) {
    var f = $S('wForm');
        var exec = false;
        var invalidCb = {
        };
        if ( Form.validate(f ,invalidCb) ) {
        	var title = "삭제하시겠습니까?";
            if ( confirm(title) ) {
                exec = true;
            }
            if ( exec ) {
                call('JSON',"board/basic/basic_delete",
                	{p_no:p_no},
                    function(json) {
                        if ( json['return'] == '200' ) { // success      
       	                    alert(json.message);
       	                    fList();    	                    
                        } else {
                            alert(json.message); // error
                        }
                    },f
                );
            }
        }
    return false;
}

function fDownload(p_no) {
	call('FORM',"board/basic/basic_download",
			{
		p_no:p_no
			});
	return false;
}

