if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}

var sForm = null;
var wForm = null;
var sTd = null;

var BD_GUBUN_CODE = {};
var BD_NAME_CODE  = {};
var DATA          = {};
function onInit() {
     //fAdd("20110601");
     //fAdd("20110601");
     //fAdd("20110602");
     //document.body.onunload = function() {
        //alert("변경된 내용이있습니다.");
     //}
     fLoadData();
}
function fLoadData() {
//	alert($S("sForm").s_year.value.padLeft("0", 4));
	sForm = $S("sForm");
	wForm = $S("wForm");
	var sYear  = sForm.s_year.value.padLeft("0", 4);
	var sMonth = sForm.s_month.value.padLeft("0", 2);
    call('JSON',"dms_info/bd_schedule/list",
    	{
	     s_year:sYear,
	     s_month:sMonth
	    },
        function(json) {
            if ( json['return'] == '200' ) { // success
            	DATA = json.data;            	
 	        	BD_GUBUN_CODE = json.data_gubun_code;
 	        	BD_NAME_CODE  = json.data_name_code ;
 	        	
            	var items = [];
            	for ( var i=0;i<DATA.length;i++) {
            		var item = DATA[i];
                    fAdd("S",item.bd_start_day,item,i,null);
                    if ( item.bd_end_day.substring(0,6) == sYear + sMonth) {
                        fAdd("E",item.bd_end_day,item,i,null);
                    }
//                    console.debug(item.bd_start_day.substring(0,6));
            	}
	     	    Util.Load.script({src:"/js/common.js",type:'js',callback:function(){
	     	        var gubunCode = new Common.createArrangeElement("select","gubun_code").make(json.data_gubun_code,"").append($S("tag_gubun_code"));
	     	        gubunCode.element.onchange = function(){
	                	var dataNameCode = json_clone(json.data_name_code);
	     	        	if ( this.value == "10" || this.value == "20" ) { // 정기 / 임시
	     	        		delete dataNameCode["9010"]; // 사전협의회
	     	        		delete dataNameCode["9020"]; // 경영간부회의
	     	        		delete dataNameCode["9030"]; // 확대간부회의
	     	        	} else {
	     	        		delete dataNameCode["2010"]; // 비상임이사회
	     	        		delete dataNameCode["2020"]; // 이사회
	     	        		delete dataNameCode["2030"]; // 경영위원회
	     	        	}
	     	        	if ( wForm.name_code ) {
	     	        		$S("tag_name_code").removeChild(wForm.name_code);
	     	        	}
		     	        var nameCode = new Common.createArrangeElement("select","name_code","").make(dataNameCode,"").append($S("tag_name_code"));
		     	        nameCode.element.onchange = function(e) { 
		     	        }
//			     	        nameCode.element.className="required trim focus alert";
//			     	        nameCode.element.setAttribute("message","구분을 선택해주세요.");
	     	        }
//		     	        gubunCode.element.className="required trim focus alert";
//		     	        gubunCode.element.setAttribute("message","구분을 선택해주세요.");
			     	gubunCode.element.onchange();		     	        
	     	    }});
            } else {
                alert(json.message); // error
            }
        }
      );	
}

function fAdd(gubun,id,item,idx,e) {
    var target = window.event?event.srcElement:( e!=null?e.target:null ) ;
    if ( target == null || target.style.fontWeight != "normal" ) {
//        alert( id );
        var sO = $S(id)
        if (!sO) sO = sTd;
        //alert( sO );
        if ( sO ) {
            var o = sO.firstChild.nextSibling;
//            console.debug(target);
            var baseC = $C("DIV");
            baseC.style.width = "100%";
            baseC.style.border = "0px solid red";
            baseC.setAttribute("p_schedule_no",item.schedule_no);
            baseC.setAttribute("mode",( target == null?"U" :"I"));
            baseC.setAttribute("data_index",idx);

            var c = $C("DIV");
            c.style.backgroundColor = "#FFF";
            c.style.dislplay = "inline";
            c.style.color   = "#000";
            c.style.border  = "0px solid black";
            c.style.width   = "100%";
//            c.style.width   = "80%";
            c.style.textAlign= "left";

//            c.style.fontSize = "8pt";
            
            if ( gubun == "E" ) c.style.color = "red";
            
            c.innerHTML = 
            	"<div class=\"textOf\" style=\"width:90px;font-size:8pt\">" 
                + "제" + item.bd_no + "회 " 
                +
                (
                  item.gubun_code !='90'?
                  BD_GUBUN_CODE[item.gubun_code] + " ":""
                )
                + BD_NAME_CODE[item.name_code] + "<BR>"
                + "</div>" 
                + 
                ( gubun == "S"
                ? "시간 : " + item.bd_time.substring(0,2) + ":" + item.bd_time.substring(2) + ""
                + "<div class=\"textOf\" style=\"width:90px\">" + "장소 : " + item.bd_place + "</div>"
            	:"안건 제출 마감일"
                )
            ;
//            console.debug(BD_NAME_CODE,item.name_code);
            o.appendChild(c);
            baseC.appendChild(c);

//            var c = $C("SPAN");
//            c.style.backgroundColor = "#FFF";
//            c.style.color   = "#000";
//            c.style.border  = "1px solid black";
//            c.style.borderLeft  = "0px";
//            c.style.width   = "20%";
//            c.style.textAlign= "center";
//            c.style.fontWeight= "bold";
//            c.innerHTML= "Ⅹ";
//            c.onclick = function(e) {
//                if ( confirm( "삭제하시겟습니까?" ) ) {
//                  //this.parentNode.removeChild(this.previousSibling);
//                    //alert( this.parentNode.getAttribute("mode") );
////                    var mode = this.parentNode.getAttribute("mode");
////                    if ( mode == "I" ) {
////                        this.parentNode.parentNode.removeChild(this.parentNode);
////                    } else {
////                        this.parentNode.setAttribute("mode","D");
////                        this.parentNode.style.display = 'none';
////                    }
//                    
//                    call('JSON',"dms_info/bd_schedule/delete",
//                    	{
//                			p_schedule_no:this.parentNode.getAttribute ("p_schedule_no")
//                    	},
//                        function(json) {
//                            if ( json['return'] == '200' ) { // success      
//                                //alert(json.message); // success                        	
//                                fSearch();    	                    
//                            } else if (json['return'] == '500') {
//                                alert(json.message); // error
//                            }
//                        }
//                    );
//                    
//                    if(!e) window.event.cancelBubble(true); 
//                    else e.stopPropagation();
//                    
////                    if ( !window.event ) {          /* FF일 경우 */
////                        e.preventDefault() ;        /* 이벤트 무효화 */
////                    } else {                        /* IE일 경우 */
////                        e.returnValue=false;    /* 이벤트 무효화 */
////                    }
//                }
//            }
//            baseC.appendChild(c);
            o.appendChild(baseC);
            baseC.firstChild.focus();
        } else {
//            alert("날짜를 선택해주세요.");
        }
    } else {
        var dO = sTd.firstChild.nextSibling;
        //alert(sTd.firstChild.nextSibling);
        fDaySelect(sTd);
    }
}

function fSearch(yyyy,mm,dd) {
    if (typeof(yyyy ) != "undefined") document.sForm.s_year.value     = yyyy  ;
    if (typeof(mm   ) != "undefined") document.sForm.s_month.value    = mm    ;
    if (typeof(dd   ) != "undefined") document.sForm.s_day.value      = dd    ;
    else document.sForm.s_day.value      = '';
    var params = Form.queryString(document.sForm);
/*
    var params  = "year="   + yyyy  ;
        params += "&month="  + mm    ;
        params += typeof(dd)!="undefined"?"&day="    + dd:"";
*/
//    getContent2('topping/set_exam_write',{params:params,method:'POST',cb:fLoadData})
    getUI("dms_info","bd_schedule_main",{params:params,callback:fLoadData});
}

function fDaySelect(o) {
	if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
    if ( sTd ) {
        //alert( sTd.getAttribute("today") );
        eval("var b = " + sTd.getAttribute("today"));
        if ( !b ) {
           sTd.style.backgroundColor = '';
        } else {
           sTd.style.backgroundColor = '#c1ffff';
        }
    }
    sTd = o;
    sTd.style.backgroundColor = '#ffffca';
    //alert(o.width);
    $S('add_area').style.left = (Util.DOM.getX(o) + 0 ) + "px";
    $S('add_area').style.top  = (Util.DOM.getY(o) + 100 ) + "px";
    $S('add_area').style.display = "block";
    var abgTbl = $S('add_area').firstChild;
    //alert( abgTbl );
    var today = new Date();
    
	var baseC = o.firstChild.nextSibling.firstChild;
	wForm.gubun_code.value   = "10";
	wForm.gubun_code.onchange();
	
	wForm.name_code.value    = "";
	wForm.bd_start_day.value = "";
	wForm.bd_end_day.value   = "";
	wForm.bd_place.value     = "";
	wForm.bd_time_h.value    = "";
	wForm.bd_time_m.value    = "";
	
    if ( !o.firstChild.nextSibling.firstChild ) { // 입력
    	wForm.p_mode.value = "I";
		var year  = sForm.s_year.value.padLeft("0", 4);
		var month = sForm.s_month.value.padLeft("0", 2);
	    var day = sTd.firstChild.innerText.padLeft("0", 2);
	    var hour = sForm.hour.value.padLeft("0", 2);
	    var min  = sForm.min.value.padLeft("0", 2);

	    var bdStartDay = year + "-" +  month + "-" +  day;
	    wForm.bd_start_day.value = bdStartDay;
	    var bdEndDay = bdStartDay.toDate().calDate({day:7});
	    wForm.bd_end_day.value = bdEndDay.toDateString("yyyy-mm-dd");

	    wForm.bd_time_h.value = today.toDateString("hh");
	    wForm.bd_time_m.value = today.toDateString("MM") ;
	    
	    $S("btn_delete").style.display = "none";
	} else { // 수정
    	wForm.p_mode.value = "U";
	
    	var idx = baseC.getAttribute("data_index");
    	var item = DATA[idx];
    	wForm.gubun_code.value   = item.gubun_code;
    	
    	wForm.gubun_code.onchange();
    	
    	wForm.name_code.value    = item.name_code;
    	var bdSDay = item.bd_start_day;
    	var bdEDay = item.bd_end_day;
    	wForm.bd_start_day.value = bdSDay.substring(0,4) + "-" + bdSDay.substring(4,6) + "-" + bdSDay.substring(6,8);
    	wForm.bd_end_day.value   = bdEDay.substring(0,4) + "-" + bdEDay.substring(4,6) + "-" + bdEDay.substring(6,8);
    	wForm.bd_place.value     = item.bd_place;
    	wForm.bd_time_h.value    = item.bd_time.substring(0,2);
    	wForm.bd_time_m.value    = item.bd_time.substring(2);
    	
    	wForm.p_schedule_no.value= item.schedule_no;
    	
	    $S("btn_delete").style.display = "inline";
	}
}

function fGoList() {
    var params = Form.queryString(document.tForm);
    return getContent2('topping/set_exam_list',{params:params,method:'POST',target:$('area_content1'),cb:function() {}});
}

function fExec() {
    var exec = false;
    var invalidCb = {
//    	trade_hope_type:function(){ Effect.twinkle(f.trade_hope_type[0].parentNode);f.trade_hope_type[0].focus(); }    
    };
    if ( Form.validate(wForm ,invalidCb) ) {
    	var title = !""?"저장하시겠습니까?":"수정하시겠습니까?";
        if ( confirm(title) ) {
            exec = true;
        }
        if ( exec ) { 
//            call('FORM.FILE',"bbs/write",
            call('FORM',"dms_info/bd_schedule/write",
            	{},
                function(str) {
                    var json = eval("(" + str + ")" );    
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        //alert(json.message); // success                        	
                		if ( $S("calendarDiv") ) $S("calendarDiv").style.display = "none";
                    	if ( json.mode == 'I' ) {
    	                    alert(json.message);
                        } else if ( json.mode == 'U' ) {
    	                    alert(json.message);
                        }
	                    fSearch();
                    } else if (json['return'] == '500') {
                        alert(json.message); // error
                    }
                },wForm
            );
        }
    }
    return false;
}

function fDelExec() {
    var exec = false;
    var invalidCb = {
//    	trade_hope_type:function(){ Effect.twinkle(f.trade_hope_type[0].parentNode);f.trade_hope_type[0].focus(); }    
    };
	var title = !""?"삭제하시겠습니까?":"삭제하시겠습니까?";
    if ( confirm(title) ) {
        exec = true;
    }
    if ( exec ) { 
//            call('FORM.FILE',"bbs/write",
        call('JSON',"dms_info/bd_schedule/delete",
        	{
        	p_schedule_no:wForm.p_schedule_no.value
        	},
            function(json) {
//                    var json = eval("(" + str + ")" );    
                if ( json['return'] == '200' ) { // success      
            		if ( $S("calendarDiv") ) $S("calendarDiv").style.display = "none";
                	if ( json.mode == 'D' ) {
	                    alert(json.message);
	                    fSearch();
                    }
                } else if (json['return'] == '500') {
                    alert(json.message); // error
                }
            }
        );
    }
    return false;
}