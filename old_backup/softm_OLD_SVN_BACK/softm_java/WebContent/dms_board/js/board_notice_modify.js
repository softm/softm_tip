var p_no = null;
function onInit(argus) {
	p_no = argus.p_no;
	$S("wForm").p_no.value = p_no?p_no:"0";
	init();
}

function init() {
	if  ( p_no ) {
		call('JSON',"board/notice/notice_modify",
			{p_no:p_no},
		    function(json) {
				if ( json['return'] == '200' ) { // success   
		        	var s_code = "";			        	
		     	    Util.Load.script({src:"/js/common.js",type:'js',callback:function(){
		     	        var sCode = new Common.createArrangeElement("select","code","-구분-").make(json.data_board_code,s_code).append($S("tag_div_code"));
		     	        sCode.element.onchange = function(){
		     	        }
	         	       sCode.element.className="required trim focus alert";
	         	       sCode.element.setAttribute("message","구분을 선택해주세요.");
			           Form.bind(json.data,$S("wForm"));
			           if ( json.data.real_att_file ) {
		            	   $S("real_att_file").innerHTML = "<a href='#' onclick='fDownload(" + json.data.no + ");'>" + json.data.display_att_file + "</a>"
		            	                                 + "<input type=checkbox name='delete_yn_att_file' value='Y'/>삭제" 
		            	   ;
			           } 
		     	    }});			        	
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

function fExec() {
    var f = $S('wForm');
        var exec = false;
        var invalidCb = {};
        if ( Form.validate(f ,invalidCb) ) {
        	var title = !""?"저장하시겠습니까?":"수정하시겠습니까?";
            if ( confirm(title) ) {
                exec = true;
            }
            if ( exec ) {
                call('FORM.FILE',"board/notice/notice_update",
                	{},
                    function(str) {
                        var json = eval("(" + str + ")" );    
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


function fList() {
	getUI("dms_board","board_notice_list",{params:""});
	return false;
}