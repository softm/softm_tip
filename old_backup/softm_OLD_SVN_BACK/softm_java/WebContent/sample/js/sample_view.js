var P_NO = null;
function onInit(argus) {
//	console.debug(argus);
	P_NO = argus.p_no;
	init();
//    Util.Load.script({src:"/service/ui/css/grid.css",type:"css"});
}

function init() {
	if  ( P_NO ) {
		call('JSON',"sample/notice/get",
			{p_no:P_NO},
		    function(json) {
		        if ( json['return'] == '200' ) { // success   
		            //console.debug(json.insert_id);
		            //alert(json.message); // success                        	
		            UI.bind(json.data,{
		            	real_att_file:function(fe,v){
		            		fe.innerHTML = "<a href='#' onclick='fDownload(" + json.data.no + ");'>" + json.data.display_att_file + "</a>";
		            	}
		            });
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
	getUI("sample","sample_write",{argus:{p_mode:'U',p_no:no}});
	return false;
}
function fList(no) {
	getUI("sample","sample",{argus:{p_no:no}});
	return false;
}

function fDelete(no) {
    var f = $S('wForm');
        var exec = false;
        var invalidCb = {
//        	trade_hope_type:function(){ Effect.twinkle(f.trade_hope_type[0].parentNode);f.trade_hope_type[0].focus(); }    
        };
        if ( Form.validate(f ,invalidCb) ) {
        	var title = "삭제하시겠습니까?";
            if ( confirm(title) ) {
                exec = true;
            }
            if ( exec ) {
                call('FORM.FILE',"sample/notice/delete",
                	{},
                    function(str) {
                        var json = eval("(" + str + ")" );    
                        if ( json['return'] == '200' ) { // success      
                            if ( json.mode == 'D' ) {
        	                    alert(json.message);
        	                    listSearch();    	                    
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

