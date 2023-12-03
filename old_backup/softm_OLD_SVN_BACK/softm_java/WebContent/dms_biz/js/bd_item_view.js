var s_item_no = null;
var wForm = null;
function onInit(argus) {
//	console.debug(argus);
//    Util.Load.script({src:"/service/ui/css/grid.css",type:"css"});
	p_mode = argus.p_mode;
	s_item_no = argus.p_item_no;
	wForm = $S("wForm");
	wForm.p_item_no.value = s_item_no;
	init();
}

function init() {
	if ( s_item_no ) {
		call('JSON',"dms_biz/bd_item/get",
			{s_item_no:s_item_no},
		    function(json) {
		        if ( json['return'] == '200' ) { // success   
		            //console.debug(json.insert_id);
		            //alert(json.message); // success
		            UI.bind(json.data,{
		            	avaiable_budget:function(fe,v){
		            		fe.innerHTML = v.toNumber().format() + "원";
		            	},
		            	budget_amount:function(fe,v){
		            		fe.innerHTML = v.toNumber().format() + "원";
		            	},
			            real_att_file:function(fe,v){
			            	fe.innerHTML = "<a href='#' onclick='return fDownload(" + json.data.item_no + ");'>" + json.data.display_att_file + "</a>";
			            }
		            });	
		        	$S("status_name").innerText = json.status_name;		            
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

function fList() {
//	if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
//	getUI("sample","sample",{params:""});
//	document.location.href = "/service.jsp?p_prg=sample/sample";
	history.go(-1);
	return false;
}

function fDelete() {
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","dms_biz/bd_item/delete",
        	{p_mode:"S",p_item_no:s_item_no},
            function(json) {
                if ( json['return'] == '200' ) { // success      
                    alert(json.message);
                    document.location.href = "/service.jsp?p_prg=dms_biz/bd_item_list";
//                    fList(null,1);
                } else {
                    alert(json.message); // error
                }
        	}
        );
    }
    return false;
}

function fGoWrite() {
	document.location.href = "/service.jsp?p_prg=dms_biz/bd_item_write&p_mode=U&p_item_no=" + s_item_no;
}