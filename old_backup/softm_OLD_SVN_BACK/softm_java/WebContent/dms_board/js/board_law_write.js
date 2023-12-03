function onInit(argus) {
	init();
}

function init() {
	wForm = $S("wForm");
	var today = new Date();
    call('JSON',"board/law/law_code",
    		{},
        	function(json) {
		        if ( json['return'] == '200' ) { // success   
		        	var s_code = "";			        	
		     	    Util.Load.script({src:"/js/common.js",type:'js',callback:function(){
		     	    	 var sCode = new Common.createArrangeElement("select","s_code","-구분-").make(json.data_board_code,s_code).append($S("tag_div_code"));
		     	        sCode.element.onchange = function(){
		     	        }
	         	       sCode.element.className="required trim focus alert";
	         	       sCode.element.setAttribute("message","구분을 선택해주세요.");
	         	       wForm.wdate.value = today.toDateString("yyyy-mm-dd");
		     	    }});			        	
		        } else {
		            alert(json.message); // error
		        }
		    }
      );	
    return false;
}

function fExec() {
    var f = $S('wForm');
        var exec = false;
        var invalidCb = {};
        if(f.subject.value =="") {
        	alert("제목을 입력 하세요");
        	return false;
        }
        if ( Form.validate(f ,invalidCb) ) {
        	var title = !""?"저장하시겠습니까?":"수정하시겠습니까?";
            if ( confirm(title) ) {
                exec = true;
            }
            if ( exec ) {
                call('FORM.FILE',"board/law/law_write",
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
	getUI("dms_board","board_law_list",{params:""});
	return false;
}
