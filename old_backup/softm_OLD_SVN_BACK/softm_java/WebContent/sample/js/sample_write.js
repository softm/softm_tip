var p_no = null;
var p_mode = null;
function onInit(argus) {
//	console.debug(argus);
//    Util.Load.script({src:"/service/ui/css/grid.css",type:"css"});
	p_no = argus.p_no;
	p_mode = argus.p_mode;
	$S("wForm").p_no.value = p_no?p_no:"0";
	$S("wForm").p_mode.value = p_mode;
	init();
}

function init() {
	if  ( p_mode == 'U' ) {
		if ( p_no ) {
			call('JSON',"sample/notice/get",
				{p_no:p_no},
			    function(json) {
			        if ( json['return'] == '200' ) { // success   
			            //console.debug(json.insert_id);
			            //alert(json.message); // success
			        	var s_code = "";			        	
			     	    Util.Load.script({src:"/js/common.js",type:'js',callback:function(){
			     	        var sCode = new Common.createArrangeElement("select","code","-구분-").make(json.data_board_code,s_code).append($S("tag_div_code"));
			     	        sCode.element.onchange = function(){
			     	        }
		         	       sCode.element.className="required trim focus alert";
		         	       sCode.element.setAttribute("message","구분을 선택해주세요.");
//		         	       console.debug(json.data);
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
	} else {
		call('JSON',"sample/notice/get_code",
			{p_board_type:"10"},
		    function(json) {
		        if ( json['return'] == '200' ) { // success   
		        	var s_code = "";
		     	    Util.Load.script({src:"/js/common.js",type:'js',callback:function(){
		     	        var sCode = new Common.createArrangeElement("select","code","-구분-").make(json.data_board_code,s_code).append($S("tag_div_code"));
		     	        sCode.element.onchange = function(){
		     	        }
	         	       sCode.element.className="required trim focus alert";
	         	       sCode.element.setAttribute("message","구분을 선택해주세요.");
		     	    }});
		        } else {
		            alert(json.message); // error
		        }
		    }
		);		
	
	}
    return false;
}

function fExec() {
    var f = $S('wForm');
        var exec = false;
        var invalidCb = {
//        	trade_hope_type:function(){ Effect.twinkle(f.trade_hope_type[0].parentNode);f.trade_hope_type[0].focus(); }    
        };
        if ( Form.validate(f ,invalidCb) ) {
        	var title = !""?"저장하시겠습니까?":"수정하시겠습니까?";
            if ( confirm(title) ) {
                exec = true;
            }
            if ( exec ) {
                call('FORM.FILE',"sample/notice/write",
                	{},
                    function(str) {
                        var json = eval("(" + str + ")" );    
                        if ( json['return'] == '200' ) { // success      
                            //console.debug(json.insert_id);
                            //alert(json.message); // success                        	
                            if ( json.mode == 'I' ) {
        	                    alert(json.message);
        	                    fList();    	                    
                            } else if ( json.mode == 'U' ) {
        	                    alert("정보가 수정되었습니다.");
                                onInit(SOFTMARGUMENT);    	                    
                            }
//                        } else if (json['return'] == '500') {
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
	if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
	getUI("sample","sample",{params:""});
//	document.location.href = "/service.jsp?p_prg=sample/sample";
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
function fDelete() {
    var f = $S('wForm');
    if (  parseInt(STATE) < 3 ) {    
	    if( confirm("삭제하시겠습니까?") ) {
	        call("JSON","front.TechConsult","delete",
	        {
	            p_consult_no:f.p_consult_no.value,
	            p_worker_no:f.p_worker_no.value
	        },
	        function(xmlDoc){
	             var json  = Util.xml2json(xmlDoc);
	             if ( json["return"] == "200" ) { // success
	                 alert(json.message); // success
	                 목록();
	             } else if (json["return"] == "500") {
	                 alert(json.message); // error
	             }
	         }
	         );
	    }
    } else {
    	alert("검토중에 있어서 삭제할 수 없습니다.");
    }
    return false;
}
