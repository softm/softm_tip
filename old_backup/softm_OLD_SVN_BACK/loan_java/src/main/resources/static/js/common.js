$(document).ready(function () {
	$( '<div class="mo-ui-snackbar" style="display: none; z-index: 1000; left: 0px;"><p class="message"></p></div>' ).appendTo( $( "body" ) );
	$( '<div class="mo-ui-layer progress" style="display:none"><div class="mo-ui-innerlayer"><div class="mo-icon-loading"><img src="/images/loading.png"></div></div></div>' ).appendTo( $( "body" ) );

	(new Image()).src = "/images/loading.png";
    if ( location.pathname != "/loginView.do" ) {
        var mInfo = getMemberInfo();
    	if ( jQuery.isEmptyObject(mInfo) ) {
        	goUrl("/loginView.do?redirect");    		
    	} else {
    		//$("#sesName"	).text(mInfo.USER_NAME);
    		//$("#sesDeptName").text(mInfo.DEPT_NM  );
    		$("body").show();
/*
    		$( "body" ).on( "click", "#slidePage", function() {
    		    var options = {};
			    var params=[];
	       	    if ( !$("#navi").text().trim() ) {
				    loadUi("#navi","/mainSlideView.do",params,function(){
				    	$( "#navi" ).show( "slide", options, 500, function() {
				    		//$("#page1").hide();
				    	});
				    });
	       	    } else {
			    	$( "#navi" ).show( "slide", options, 500, function() {
			    		//$("#page1").hide();
			    	} );
	       	    }
    		});
*/
    		//$(document).find('#navi').css({'width':'80px'})
    		if ( window.localStorage.getItem("lnb") == "small" ) {
    			new main_size('small');		
    		} else if ( window.localStorage.getItem("lnb") == "wide" ) {
    			new main_size();
    			//new main_size('wide');
    		} else {
    			new main_size();
    		}
		    var options = {};    		
		    var params=[];
		    loadUi("#navi","/mainSlideView.do",params,function(){
//		    	$( "#navi" ).show( "slide", options, 500, function() {
//		    		//$("#page1").hide();
//		    	});
		  		calendar_date(); // 좌측달력 ui_common.js
		    });
	  		
            $("body").on( "click", "#btnLogout, #btnGoConsult, #btnGoLoanStep, #btnGoDealContract, #btnGoCustMng, #btnGoDataRoom", function() {
                switch($(this)[0].id) {
        	        case "btnLogout": // 로그아웃
        	        	logout();
        	            break;
        	        case "btnGoConsult": // 고객상담
                        window.localStorage.setItem("lnbSeq",1);
        	        	goUrl("/consultView.do?statgroup=con");
        	        	break;
        	        case "btnGoLoanStep": // 사전품의
                        window.localStorage.setItem("lnbSeq",2);        	        	
        	        	goUrl("/loanListView.do?statgroup=loan");
        	            break;
        	        case "btnGoDealContract": // 여신거래약정
                        window.localStorage.setItem("lnbSeq",3);        	        	
        	        	goUrl("/loanListView.do?statgroup=sign");
        	            break;
        	        case "btnGoCustMng": // 고객관리
                        window.localStorage.setItem("lnbSeq",4);        	        	
        	        	goUrl("/loanListView.do");
        	            //goUrl("/dealView.do");
        	            break;
        	        case "btnGoDataRoom":
                        window.localStorage.setItem("lnbSeq",5);        	        	
        	        	alert("서비스 준비중입니다.");
        	            //goUrl("/dealView.do?lnbSeq=5");
        	            break;
        	        default:
        	            break;
            	}
            });
            
        	$(".datepicker").datepicker({
        	    //showOn: "button",
        	    buttonText: '달력',    
        	    //buttonImage: "/assets/img/calendar.gif",
        	    //buttonImageOnly: true,
        	    //minDate: 0,
        	    required: true,
        	    message: "This is a required field",
        	    dateFormat: 'dd-mm-yy',
        	    //changeYear: true, 
        	    //changeMonth: true, 
        	    dayNames: ['월요일', '화요일', '수요일', '목요일', '금요일', '토요일', '일요일'],
        	    dayNamesMin: ['월', '화', '수', '목', '금', '토', '일'], 
        	    monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'],
        	    monthNames: ['1','2','3','4','5','6','7','8','9','10','11','12'],        	    
        	    //monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
        	    defaultDate: null,
        	    dateFormat: "yy-mm-dd",
        	    showMonthAfterYear:true
                //,        	
        	    //showButtonPanel: true,
        	    //currentText: '오늘 날짜', 
        	    //closeText: '닫기', 
        	});
            $( ".datepicker" ).mask('0000-00-00');
            $( ".ctax_no" ).mask('000-00-00000');
            $('.amount').mask('#,##0',{reverse: true});
            $('.amount').focus(function(e){
            	if ( $(this).val() == "0" ) $(this).val("");
            });
    	}
    } else {
    	$("body").show();
    }
    
    $("body").on( "click", ".btnX", function() {      
    	$(this).prev().val("");
    });
    
    $("body").on( "click", ".logo_wrap .logo", function() {      
    	goUrl("/mainView.do?home");    	
    });
    
    $('.numeric').keyup(function(e) {
        if(this.value!='-')
          while(isNaN(this.value))
            this.value = this.value.split('').reverse().join('').replace(/[\D]/i,'')
                                   .split('').reverse().join('');
    })
    .on("cut copy paste",function(e){
    	e.preventDefault();
    });

    //$('<span style="color:red;">*</span>').insertAfter('.required');
    $(window).load(function(){
    	//TODO SOFTM 확인되야함.
        $("#imgMyPic"   ).attr("src","data:image/png;base64,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");
        //$("#spnUserName").text(mInfo.USER_NAME);
        //$("#spnDeptName").text(mInfo.DEPT_NM  );    
    });
});

// --
function isEmail (s){ return s.search(/^\s*[\w\~\-\.]+\@[\w\~\-]+(\.[\w\~\-]+)+\s*$/g)>=0;}
function isDate(strDT){
    if(strDT.length < 8) return false;
       strDT = strDT.replace(/[\-\.\/]/g,"");

    var d = new Date(strDT.substring(0, 4),
            strDT.substring(4, 6) - 1,
            strDT.substring(6, 8),
            0, 0, 0);

    if(isNaN(d) == true) return false;
    var s = d.getFullYear().toString();
    var n = d.getMonth() + 1;
    s += (n < 10 ? "0" : "") + n;
    n = d.getDate();
    s += (n < 10 ? "0" : "") + n;

    if(strDT != s) return false;
    return true;
}

function isArray(obj){ if (obj.constructor.toString().indexOf("Array") == -1) return false; else return true;}

function isValid(formSelector,vRules) {
	var vv = jQuery.extend( {} , vRules1, {onfocusout: false,errorPlacement: function(error, element) {}} );
    var validator = $(formSelector).validate(vv);
    if  ( !$(formSelector).valid() ) {
        var errors = validator.numberOfInvalids();
        if (errors) {
            if (validator.errorList.length > 0) alert(validator.errorList[0].message);
            validator.errorList[0].element.focus();
        }
        return false;
    } else {
    	return true;
    }
}

function isKoreanOnly( koreanChar ) {
	 if ( koreanChar == null ) return false ;
	 for(var i=0; i < koreanChar.length; i++){
	   var c=koreanChar.charCodeAt(i);
	   //( 0xAC00 <= c && c <= 0xD7A3 ) 초중종성이 모인 한글자
	   //( 0x3131 <= c && c <= 0x318E ) 자음 모음
	   if( !( ( 0xAC00 <= c && c <= 0xD7A3 ) || ( 0x3131 <= c && c <= 0x318E ) ) ) {
	      return false ;
	   }
	 }
	 return true ;
}

function execSync(url,params,cb) { 
	var callUrl = (params.indexOf("error=1")==-1?REST_URL:REST_DEV_URL) + url + "?ui_type=D";
	console.info("callUrl / params : " ,callUrl ,params);
	var rtnData = {};
	var fnCall = function(data) {
        var d = data;
    	if (  d.RESULT_CD == RESULT_CD.NOTLOGIN ) {
        	rtnData={}
    	}
    	if ( cb ) cb(d);
    	rtnData = d;
	}
	//callUrl += "&" + getXASToken();
	console.info( "callUrl : " + callUrl );
	$.ajax({
	      //type: CONST.DATA_TYPE=="json"?'GET':"POST",
	   		type: "POST",
		    dataType: CONST.DATA_TYPE,
		    async: false,
		    url: callUrl,		    
		    data: params,
		    //contentType:'application/x-www-form-urlencoded; charset=EUC-KR',
		    success: function(data) {
	            hideLoading();	    	
		    	if ( CONST.DATA_TYPE == "jsonp" ) {
		    		if ( data.RESULT_MSG ) alert(data.RESULT_MSG);		    		
		    		fnCall(data);
		    	}
		    },
		    complete: function(data) {
	            hideLoading();
		    	if ( CONST.DATA_TYPE == "json" ) {
			        var rtn = data.responseText;
			        try {
			        	//rtn = $.trim(rtn).replace(/\\\"/g,"\"");
						var d = JSON.parse(rtn);
						if ( d.RESULT_MSG ) alert(d.RESULT_MSG);						
						fnCall(d);	  
			        } catch (e) {
			            alert(e);
			        }
		    	}
		    },
		    error: function(xhr, textStatus, thrownError) {
		    	//params += params?"&error=1":"?error=1";		    	
		    	//return execSync(url,params,cb);
		    	
		    	try {
		    		hideLoading();	    	
		    	} catch (e ) {}
		    }
		});
	
	return rtnData;	
}

function exec(url,params,cb) {
	var callUrl = (params.indexOf("error=1")==-1?REST_URL:REST_DEV_URL) + url + "?ui_type=D";
	console.info("callUrl / params : " ,callUrl ,params);	
	var fnCall = function(data) {
        var d = data;
    	if (  d.RESULT_CD == RESULT_CD.NOTLOGIN ) {
        	goUrl("/loginView.do?relogin");
    	}
    	if ( cb ) cb(d);	
	}
	//callUrl += "&" + getXASToken();
	console.info( "callUrl : " + callUrl );
	$.ajax({
	      //type: CONST.DA0TA_TYPE=="json"?'GET':"POST",
	   		type: "POST",
		    dataType: CONST.DATA_TYPE,
		    async: true,
		    url: callUrl,		    
		    data: params,
		    //contentType:'application/x-www-form-urlencoded; charset=EUC-KR',
		    success: function(data) {
	            hideLoading();
		    	if ( CONST.DATA_TYPE == "jsonp" ) {	    	
		    		if ( data.RESULT_MSG ) alert(data.RESULT_MSG);	            
		    		fnCall(data);
		    	}
		    },
		    complete: function(data) {
	            hideLoading();
		    	if ( CONST.DATA_TYPE == "json" ) {
			        var rtn = data.responseText;
			        try {
			        	//rtn = $.trim(rtn).replace(/\\\"/g,"\"");
						var d = JSON.parse(rtn);
						if ( d.RESULT_MSG ) alert(d.RESULT_MSG);	            
						fnCall(d);	  
			        } catch (e) {
			            alert(e);
			        }
		    	}
		    },
		    error: function(xhr, textStatus, thrownError) {
		    	//return exec(url,params + (params?"&error=1":"?error=1") ,cb);
		    	try {
		    		hideLoading();	    	
		    	} catch (e ) {}
		    }
		});
}

function loadUi(selector,url,params,cb) {
    params = $.isArray(params)?params:[];
	console.info("params :" , params);
    $(selector).load( url + "?" + (params.length>0?params.join("&"):"") + (params.length>0?"&":"") + "ui_type=p&lnbSeq=" + lnbSeq, function(responseTxt, statusTxt, xhr){
        if(statusTxt == "success") {
        	if ( cb ) cb();
        } else if(statusTxt == "error") {
	    	params.push("error=1");
	    	loadUi(selector,url,params,cb);
        }
    });
}

function bindJsonToForm(jsonItem,formSelector,setRule) {
    var items = jsonItem;
    if ( jsonItem ) {
        for ( var fId in jsonItem ) {
            var v = items[fId];
            var fe = $(formSelector).find("[name='"+fId.toLowerCase()+"']");
            var rGroup = null;
            var size1 = 0;
            var type = null;
            if ( fe.length > 0 ) {
                type = fe[0].type;
                if ( typeof(type) == 'undefined' ) {
                    rGroup = $(formSelector).find("[name='"+fId.toLowerCase()+"']");                    
                    size1 = rGroup.length;
                    if ( size1 > 0 ) {
                        type = rGroup[0].type;
                    }
                }
	            try {
	            	$.each(fe, function( index, elm ) {
	            	    type = elm.type;
	  	                if ( type == 'text' || type == 'hidden' || type == 'password' || type == 'select-one' || type == 'textarea'  ) {
	  	                	elm.value =v;
		                } else if (  type == 'radio' || type == 'checkbox' ) {
		                    if ( v ) {
		                        if ( type == 'radio' ) {
	                                if ( elm.value == v ) {
	                                	elm.checked = true;
	                                }
		                        } else if ( type == 'checkbox' ) {
		                        	if ( jQuery.inArray( elm.value, v) > -1) {
		                             	elm.checked = true;
		                        	}
		                        }
		                    }
		                } else if ( type == 'select-multiple' ) {
		                	//TODO SOFTM 미적용.
		                	var options = $(elm).find("OPTION");
		                	$.each(options, function( index, elmOptions ) {
		                		if ( jQuery.inArray( elmOptions.value, v) > -1) {
		                			elm.selected = true;
		                		}		                	
			            	});
		                } else {
		
		                }	            		  
	            	});
	            	
	
	            } catch (e) {
	                //throw new Error(enm + "를 확인해주세요.");
	            }
            }
            
            if ( setRule && typeof(setRule[fId.toLowerCase()]) == 'function' ) {
            	setRule[fId.toLowerCase()]($(formSelector),v);
            } else {

            }            

        }
    } else {
    	//throw new Error("jsonItem not found : " + log(json) );
    }
}

function getCodeValue(params,cb) {
    params = $.isArray(params)?params:[];	
    var data = execSync("/codeListInfo.do", "codegrp=" + params.join(","),cb);
    return data;
}

function getCodeValueForZC(params,cb) {
	params = $.isArray(params)?params:[];	
   var data = execSync("/zcCodeListInfo.do", "codegrp=" + params.join(","),cb);
	return data;
}

function getCodeValueForIfis(params,cb) {
	params = $.isArray(params)?params:[];	
   var data = execSync("/ifisCodeListInfo.do", "codegrp=" + params.join(","),cb);
	return data;
}

function getCurrentDateString() {
	return moment().format("YYYY-MM-DD");
}

function createCombo(selector, codes, label, defaultValue) {
	$(selector).empty();
	if (label) $(selector).append( new Option( label, "" ) );
	
	$.each(codes,function(k,v) {
		$(selector).append( new Option( v.NAME, v.CODE ) );		
	});
	if ( defaultValue ) $(selector).val(defaultValue);
}

function createRadio(selector, codes, name, defaultValue) {
	$(selector).empty();
	$.each(codes,function(k,v) {
		$('<input class="designRadiobutton" type="radio" id="'+name+'_'+(k+1) + '" name="'+name+'" value="' + v.CODE + '" ' + (defaultValue==v.CODE?"checked":"") + '/>'
          +'<label for="'+name+'_'+(k+1) + '" class="add_text" style="padding-right:30px">' + v.NAME + '</label>&nbsp;&nbsp;&nbsp;&nbsp;'				
		).appendTo(selector);
	});
	if ( defaultValue )
		$(selector).find('input:radio[name="'+name+'"][value="' + defaultValue + '"]').attr('checked', 'checked');
}

function createCheckbox(selector, codes, name, defaultValues) {
	$(selector).empty();
	$.each(codes,function(k,v) {
		console.info( v.CODE, v.NAME,defaultValues, (jQuery.inArray( v.CODE, defaultValues )>-1?"checked":"") )
		$('<input class="designCheckbox" type="checkbox" id="'+name.replace("\[\]","")+'_'+(k+1) + '" name="'+name+'" value="' + v.CODE + '" '  + (jQuery.inArray( v.CODE, defaultValues)>-1?"checked":"") +  '/>'
				+'<label for="'+name.replace("\[\]","")+'_'+(k+1) + '" class="add_text" style="padding-right:30px">' + v.NAME + '</label>&nbsp;&nbsp;&nbsp;&nbsp;'				
		).appendTo(selector);
	});
}

function toast(v,cb) {
	if ( typeof(Android) !== "undefined") {
		Android.showToast(v);
	}
	if ( cb ) cb();
}

function showLoading() {
	if(isBrowser) {
		$('.mo-ui-layer.progress').show();
	} else {	
		if ( typeof(Android) !== "undefined") {	
			Android.showLoading();
		}
	}
}

function hideLoading() {
	window.setTimeout(function() {
		if(isBrowser) {
		    $('.mo-ui-layer.progress').hide();
		} else {	
			if ( typeof(Android) !== "undefined") {
			  Android.hideLoading();
			}
		}
	},100);
}

function snakBar(s,o){
    snakBarError(o,s);
}

function snakBarError(o,v) {
    if ( typeof o === "object" ) {
        var c = o.closest("dd");
        if ( o[0].tagName.toUpperCase() == "SELECT") {
            o.one( "change", function( event ) {
                fClearError(o);
            });
        } else {
            if ( o[0].tagName.toUpperCase() == "INPUT" || o[0].type.toUpperCase() == "TEXT") {
                if (  o.hasClass("approval") || o.hasClass("phone_number") ) {
                    c = o.closest("div");
                }
                if(o[0].type.toUpperCase() == "RADIO") {
                    o.one( "change", function( event ) {
                        fClearError(o);
                    });
                } else {
                    o.one( "keyup", function( event ) {
                        fClearError(o);
                    });
                }

            } else if ( o[0].tagName.toUpperCase() == "TEXTAREA" ) {
                o.one( "keyup", function( event ) {
                    fClearError(o);
                });
            }
        }
        c.addClass("mo-error");
    } else {
        if (o) {
            v=o;
        }
    }
    $('.mo-ui-snackbar p').text(v);
    if (!v) {
        $('.mo-ui-snackbar').css("display","none");
    } else {
        $('.mo-ui-snackbar').css("display","block");
        $('.mo-ui-snackbar').hide().stop( true, true ).fadeIn(200).show().delay(1500).fadeOut(200);
    }
}

function clearError(o) {
    var c = o.closest("dd");
    try
    {
        if ( o[0].tagName.toUpperCase() == "SELECT") {
        } else {
            if ( o[0].tagName.toUpperCase() == "INPUT" || o[0].type.toUpperCase() == "TEXT") {
                if (  o.hasClass("approval") || o.hasClass("phone_number") ) {
                    c = o.closest("div");
                }
            } else if ( o[0].tagName.toUpperCase() == "TEXTAREA" ) {
            }
        }
        c.removeClass("mo-error");
    }
    catch (e){
    }
}

/**
 * openOZ("LoanPic");
 * openOZ("SignPic");
 * openOZ("SignDoc");
 */
function openOZ(ozr,params) {
	if(isBrowser) {
		alert("openOZ : " + ozr + " / " + params);
	} else {	
		if ( typeof(Android) !== "undefined") {	
			Android.openOZ(ozr,params);
		}
	}
}

/**
 * getXASToken();
 */
function getXASToken() {
	if(isBrowser) {
		return "sid=&token=";
	} else {	
		if ( typeof(Android) !== "undefined") {	
			var v = Android.getXASToken();
			var info = v.split(",");
			//XecureAppShield.getInstance().getSID() + ","+ XecureAppShield.getInstance().getToken()			
			return "sid=" + info[0] + "&token=" + info[1];
		}
	}
}

function hideKeyboard() {
//	if ( typeof(Android) !== "undefined") {	
		Android.hideKeyboard();
//	}
}
function setKeyboard(b) {
	if ( typeof(Android) !== "undefined") {	
		Android.setKeyboard(b);
	}
}

function callForNative(json) {
	var info = JSON.parse(json);
	//info.result;
//	http://localhost:8080/loanListView.do?statgroup=con&lnbSeq=1
//	http://localhost:8080/loanListView.do?statgroup=loan&lnbSeq=2
//	http://localhost:8080/loanListView.do?statgroup=sign&lnbSeq=3		
	if ( info.gubun == "LoanPic" ) {
		goUrl("/loanListView.do?statgroup=con&lnbSeq=1");
	} else if ( info.gubun == "SignDoc" ) {
		document.location.replace(document.location.href);
	} else if ( info.gubun == "SignPic" ) {
		goUrl("/loanListView.do?statgroup=sign&lnbSeq=3"); // 여신거래약정
	}
	
}

function loadBasicInformation() {
	var info = {}; 	
	if ( typeof(Android) !== "undefined") {	
		info = JSON.parse(Android.getBasicInformation());
	} else {
		info.macAddress = "F4:42:8F:45:2A:E1";
	}
    window.INFO.MAC_ADDRESS = info.macAddress;	
}

jQuery.fn.visible = function() {
    return this.css('visibility', 'visible');
};

jQuery.fn.invisible = function() {
    return this.css('visibility', 'hidden');
};

jQuery.fn.visibilityToggle = function() {
    return this.css('visibility', function(i, visibility) {
        return (visibility == 'visible') ? 'hidden' : 'visible';
    });
};

Storage.prototype.setObject = function(key, value) {
    this.setItem(key, JSON.stringify(value));
}

Storage.prototype.getObject = function(key) {
    return JSON.parse(this.getItem(key));
}

function logout() {
	window.sessionStorage.setObject("_MFO",{});
    exec("/logoutProc.do", "",function(data) {
        if ( data.RESULT_CD == RESULT_CD.OK ) {
        	goUrl("/loginView.do?relogin");        	
        } else {
        }
    });
}

function goUrl(url) {
//	document.location.replace(url);
	var lnbSeq = 1;
	try{
		lnbSeq = window.localStorage.getItem("lnbSeq")?window.localStorage.getItem("lnbSeq"):1;
	} catch(e) {
		alert(e.toString())
	}

    var params = getParametersJson(url);
    if ( params["lnbSeq"] ) {
        lnbSeq = params["lnbSeq"];
        url = removeParameter(url,"lnbSeq");
    }
    
	document.location.href = url + (url.indexOf("?")>-1?"&":"?")+"lnbSeq="+lnbSeq;
}

function setMemberInfo(mNo) {
	var data = execSync("/memberInfo.do", "member_no="+mNo,function(data) {
	});
	data.MEMBER_NO = mNo;
    window.sessionStorage.setObject("_MFO",data);
}

function getMemberInfo() {
	return window.sessionStorage.getObject("_MFO");	
}

function formatDate(v) {
	if ( moment(v,"YYYY.MM.DD").isValid() ) {
		return moment(v,"YYYY.MM.DD").format("YYYY-MM-DD");	
	} else {
		return "-";	
	}
}

function formatNumber(v,f) {
	try {
		v = typeof v == "number"?""+v:v;
		f = f?f:v.split(".").length > 1?v.split(".")[1].length:0;
		var vv = jQuery.number(v,f);	
		return vv.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");;	
	} catch(e) {
		return v;
	}
}

var userAgent = navigator.userAgent.toLowerCase(),
	isIOS = 0 < userAgent.indexOf("iphone") || 0 < userAgent.indexOf("ipad"),
	isAndroid = 0 < userAgent.indexOf("android"),
	isBrowser = !isIOS && !isAndroid
;
if ( !isBrowser ) {
	isBrowser = 0 < userAgent.indexOf("android 5.0");
}

var Util = {
    Browser:{
        version: (userAgent.match( /.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/ ) || [])[1],
        safari: /webkit/.test( userAgent ),
        opera: /opera/.test( userAgent ),
        msie: /msie/.test( userAgent ) && !/opera/.test( userAgent ),
        mozilla: /mozilla/.test( userAgent ) && !/(compatible|webkit)/.test( userAgent )
    }
};

var Effect= {
    TWINKLE_INTERVAL:150,
    TWINKLE_OBJECT:{},
    DEFAULT_INFO:{cssText:'background-color:#fbffff;border:1px dotted red',during:700,interval_time:230,callback:function(){}},
    clearTwinkle:function(oId,cb) {
        if ( Effect.TWINKLE_OBJECT[oId] ) Effect.TWINKLE_OBJECT[oId].playing = false;
        //Effect.TWINKLE_OBJECT[oId] = null;
        var eFo = Effect.TWINKLE_OBJECT[oId];
        eFo.object.style.cssText = eFo.cssText;
        clearInterval(eFo.interval);
        if ( typeof cb == "function" ) cb();
    },
    /* using
Effect.twinkle($('part_msg' ),{cssText:'background-color:#BFE2FF;border:5px dotted #99CCCC;color:black',during:0,interval_time:1000,callback:function(){}});
     */
    twinkle:function(o,i,opt) {
        var execCnt = 0;
        var oId = '';
        if ( o.id ) {
            oId = o.id;
        } else {
            var oN = $("[name='"+o.name+"']");
            if ( oN.length == 1 ) {
                //o = oN[0];
                oId = o.name;
            } else {
                for( var ii=0;ii<oN.length;ii++){
                    if ( o == oN[ii]) {
                        o = oN[ii];
                        oId = o.name + '_' + ii;
                        break;
                    }
                }
            }
        }
        //log(oId);
        if ( o ) {
            var cssText = o.style.cssText;
            var eFo = null;
            if ( !Effect.TWINKLE_OBJECT[oId] ){
                Effect.TWINKLE_OBJECT[oId] = {};
                eFo = Effect.TWINKLE_OBJECT[oId];
                eFo.interval = null;
                eFo.object   = o;
                eFo.execCnt  = 0;
                eFo.infor    = i = !i?this.DEFAULT_INFO:i;
                eFo.cssText  = o.style.cssText;
                eFo.playing  = false;
                eFo.id       = oId;
            } else {
                eFo = Effect.TWINKLE_OBJECT[oId];
            }
            //log(eFo);
            if ( !eFo.playing ) {
                eFo.playing = true;
                function start(eFo) {
                    //eFo = Effect.TWINKLE_OBJECT[oId];
                    //log(eFo);
                    //alert(eFo);
                    var it = eFo.infor.interval_time?eFo.infor.interval_time:Effect.TWINKLE_INTERVAL;
                    if ( eFo.playing && eFo.infor.during == 0 || eFo.execCnt * it < eFo.infor.during ) {
                        if ( eFo.execCnt % 2 == 0 ) {
                            eFo.object.style.cssText = eFo.cssText + ';' + eFo.infor.cssText;
                        } else {
                            eFo.object.style.cssText = eFo.cssText;
                        }
                        eFo.execCnt++;

                    } else {
                        //alert('clear : ' + eFo.id );
                        eFo.object.style.cssText = eFo.cssText;
                        if (typeof(eFo.infor.callback) === 'function') {
                            eFo.infor.callback();
                        }
                        //Effect.TWINKLE_OBJECT[eFo.oId]
                        clearInterval(eFo.interval);
                        Effect.clearTwinkle(eFo.id);
                        delete Effect.TWINKLE_OBJECT[oId];
                    }
                }
                if (eFo.infor.focus) o.focus();
                if ( Util.Browser.mozilla ) {	                	
                    eFo.interval = setInterval(start,
                            eFo.infor.interval_time?eFo.infor.interval_time:Effect.TWINKLE_INTERVAL,
                                    eFo
                    );
                } else {
                    eFo.interval = setInterval(
                            function(){
                                start(eFo);
                            },
                            eFo.infor.interval_time?eFo.infor.interval_time:Effect.TWINKLE_INTERVAL
                    );
                }
            }
        }
        return o;
    }
}

/**
 * # Using - script
 *   validate( $('#lForm') ,{rules:{name:boolean},message:{name:boolean}}{
 *       user_id:function(){ Effect.twinkle($('#lForm')[0].user_id);},
 *       passwd:function(){ Effect.twinkle($('#lForm')[0].passwd);},
 *   });
 *
 * # Using - html
 * <input type="text" name="user_id" size="20" style="width:200px" value="" class="required trim focus email alert" maxlength=100 minlength=0 message="ID를 이메일 주소로 입력하세요."/>
 *
 * <input type="password" name="passwd" style="width:200px" size="20" maxlength="25" class="required focus "/>
 *
 * <input type="radio" name="rdo_user_id" value="Y" class="required focus">
 * <input type="radio" name="rdo_user_id" value="N" class="required focus">
 *
 * <input type="checkbox" name="chk_user_id" value="Y" class="required focus">
 *
 * <select name=test_select_one class="required focus">
 *  <option value=''>없음</option>
 *  <option value=1>1</option>
 *  <option value=2>2</option>
 * </select>
 *
 * <select name=test_select_multiy class="required focus" multiple="multiple">
 *   <option value=''>없음</option>
 *   <option value=1>1</option>
 *   <option value=2>2</option>
 * </select>
 * 
 * # jquery validator 참고
	jQuery.extend(jQuery.validator.messages, {
	    required: "This field is required.",
	    remote: "Please fix this field.",
	    email: "Please enter a valid email address.",
	    url: "Please enter a valid URL.",
	    date: "Please enter a valid date.",
	    dateISO: "Please enter a valid date (ISO).",
	    number: "Please enter a valid number.",
	    digits: "Please enter only digits.",
	    creditcard: "Please enter a valid credit card number.",
	    equalTo: "Please enter the same value again.",
	    accept: "Please enter a value with a valid extension.",
	    maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
	    minlength: jQuery.validator.format("Please enter at least {0} characters."),
	    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
	    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
	    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
	    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
	});
 */
 function validate (formSelector,settings,callback) {
	 var rules    = settings.rules?settings.rules:{};
	 var messages = settings.messages?settings.messages:{};

	 var forms =  $(formSelector);
	 if ( forms.length == 0 ) return;
	 var form = forms[0];
     var size = form.elements.length;
     var alert = $(form).hasClass("alert")||rules.alert||form.getAttribute("alert")!=null?true:false;
     var focus = $(form).hasClass("focus")||rules.focus||form.getAttribute("focus")!=null?true:false;
     var isvalid = true;
     var isChecked = {};
     var type;
     var elm,enm;
     for (var i = 0; i < size; i++) {
         elm = form[i];
         enm = elm.name;
         var rule = rules && rules[enm]?rules[enm]:{};
         // maxlength=10 minlength=1 message="Please enter the ID"
         var maxlength = elm.getAttribute("maxlength")?elm.getAttribute("maxlength"):rule.maxlength || 100000000;
         var minlength = elm.getAttribute("minlength")?elm.getAttribute("minlength"):rule.minlength || 0 ;
         var message   = elm.getAttribute("message")||messages[enm];
         var required = $(elm).hasClass("required")||elm.getAttribute("required")||!!rule.required;
         var numbered = $(elm).hasClass("number")||!!rule.number;
         var emailed  = $(elm).hasClass("email")||!!rule.email;
         var trimed  = $(elm).hasClass("trim")||!!rule.trim;
         
         var dated = $(elm).hasClass("date")||elm.getAttribute("date")||!!rule.dated;         
         	 dated = dated || $(elm).hasClass("dpDate")||elm.getAttribute("dpDate")||!!rule.dpDate;
         
         if (elm.disabled) continue; // skip disabled element
         
         focus = focus || $(elm).hasClass("focus")||!!rule.focus||$(elm)[0].getAttribute("focus")!=null?true:false;
         alert = alert || $(elm).hasClass("alert")||!!rule.alert||$(elm)[0].getAttribute("alert")!=null?true:false;
         alert = $(elm).hasClass("nofocus")||!!rule.nofocus||($(elm)[0].getAttribute("nofocus")!=null?true:false)?false:alert;
         alert = $(elm).hasClass("noalert")||!!rule.noalert||($(elm)[0].getAttribute("noalert")!=null?true:false)?false:alert;
         type = elm.type;

         if ( typeof rule.alert    == "function" ) alert    = rule.alert();
         if ( typeof rule.required == "function" ) required = rule.required();
         if ( typeof rule.numbered == "function" ) numbered = rule.numbered();
         if ( typeof rule.emailed  == "function" ) emailed  = rule.emailed();
         if ( typeof rule.trimed   == "function" ) trimed   = rule.trimed();
         if ( typeof rule.dated    == "function" ) dated   = dated.trimed();
        	 
         if ( required || numbered || emailed ) {
//                 console.info(elm);
//                 console.info(enm +
//                       "\n type : " + type +
//                       "\n required : " + required +
//                       "\n focus : " + focus +
//                       "\n maxlength : " + maxlength +
//                       "\n message : " + message +
//                       "\n minlength : " + minlength
//                 );
        	 //if ( enm == "person_cost") debugger;
             if ( type == 'textarea' || type == 'text' || type == 'password' || type == 'select-one' || type == 'number' ) {
            	 var v = null;
            	 if ( $(elm).hasClass("amount") ) {
            		 v = $(elm).cleanVal();
            	 } else {
            		 v = trimed? elm.value.trim():elm.value;
            	 }
            	 
//                   console.info("v : " + v +
//                           "\n v.length : " + ( typeof( v.length) != 'undefined'? v.length:'없음'  )
//                   );
                 
                 
                 if ( ( type == 'textarea' || type == 'text' || type == 'password' ) && v && numbered && isNaN(v) ) {
                     isvalid = false;
                     break;
                 } else {
                     if ( required ) {
                         if ( !v || v.length > maxlength || v.length < minlength ) {
                             isvalid = false;
                             break;
                         }
                     }
                 }

                 if ( v && emailed ) {
                     if ( !isEmail(v) ) {
                         isvalid = false;
                         break;
                     }
                 }
                 if ( v && dated ) {
                     if ( !isDate(v) ) {
                         isvalid = false;
                         break;
                     }
                 }
                 
             } else if ( type == 'select-multiple' ) {
                 var isSelected = false;
                 var size1 = elm.options.length;
                 for (var j = 0; j < size1; j++) {
                     if ( elm.options[j].selected ) {
                         isSelected = true;
                         break;
                     }
                 }
                 if ( !isSelected ) {
                     isvalid = false;
                     break;
                 }
             } else if (  type == 'radio' || type == 'checkbox' ) {
                 //var group = document.getElementsByName(enm);
                 var group = $(form).find("[name='"+enm+"']");
                 //alert(isChecked[enm] );
                 if (!isChecked[enm] ) {
                     isChecked[enm] = true;
                     var ischecked = false;
                     var size1 = group.length;
                     for (var j = 0; j < size1; j++) {
                         if ( group[j].checked ) {
                        	 ischecked = true;
                             break;
                         }
                     }
                     if ( !ischecked ) {
                         isvalid = false;
                         break;
                     }
                 }
             } else {

             }
         }
     }
     if ( !isvalid ) {
         if ( alert ) {
        	 var msg =$(elm).parent().prev().text().trim()||enm;
        	 message = message?message:formatMessage( "{0}"+josa(msg)+" 확인해주세요.", [msg]);
        	 if ( message ) window.alert(message);
         }
         if ( focus ) elm.focus();
         if ( typeof(callback) == 'object' && typeof(callback[enm]) == 'function' ) callback[enm](elm);
         //else Effect.twinkle(type=="radio"?$(elm).parent()[0]:elm);
     }
     console.info("validate->" + isvalid + (form?" / " + form.name:"") + (elm?"." + enm:"") );
     return isvalid;
}
 
function formatMessage( source, params ) {
		if ( arguments.length === 1 ) {
			return function() {
				var args = $.makeArray( arguments );
				args.unshift( source );
				return $.validator.format.apply( this, args );
			};
		}
		if ( params === undefined ) {
			return source;
		}
		if ( arguments.length > 2 && params.constructor !== Array  ) {
			params = $.makeArray( arguments ).slice( 1 );
		}
		if ( params.constructor !== Array ) {
			params = [ params ];
		}
		$.each( params, function( i, n ) {
			source = source.replace( new RegExp( "\\{" + i + "\\}", "g" ), function() {
				return n;
			} );
		} );
		return source;
};

// http://m.blog.naver.com/andreas84/130098312646
function josa(label) {
	 var strGA = 44032; //가
	 var strHI = 55203; //힣
	 var lastStrCode = label.charCodeAt(label.length-1);
	 var prop=true;
	 var msg;
	 if(lastStrCode < strGA || lastStrCode > strHI) {
		 //return false; //한글이 아님
		 return '을'; //한글이 아님
	 }
	 if (( lastStrCode - strGA ) % 28 == 0) prop = false;
	 if(prop) {
	  return '을';
	 }
	 else {
		 return '를';
	 }
}

function removeParameter(params,n) {
    //var params = "a=11111111111111&bccd=2&c=3";
    //var n = 'a';
  //var regexp = new RegExp("([\\?\\&]|^)"+n+"=[^&]*", "gi");
    var regexp = new RegExp("([\\?\\&]|^)"+n+"=[^&]*", "g");
    params = params.replace(regexp,"");
    return ( params.charAt(0) == '?' || params.charAt(0) == '&'?params.substring(1):params);
}

function getParametersJson(url) {
    // 파라미터가 담길 배열
    var param = new Array();
    url = decodeURIComponent(url);
 
    var params;
    // url에서 '?' 문자 이후의 파라미터 문자열까지 자르기
    params = url.substring( url.indexOf('?')+1, url.length );
    // 파라미터 구분자("&") 로 분리
    params = params.split("&");

    // params 배열을 다시 "=" 구분자로 분리하여 param 배열에 key = value 로 담는다.
    var size = params.length;
    var key, value;
    for(var i=0 ; i < size ; i++) {
        key = params[i].split("=")[0];
        value = params[i].split("=")[1];

        param[key] = value;
    }

    return param;
}
// --

// not used ------- 
function backKeyToFinish() {
    if ( typeof window.backKeyPressed === "undefined" ) {
        window.backKeyPressed = -1; // -1,0,1
    }
    if (window.backKeyPressed == -1) {
        window.backKeyPressed = 0;
            snakBarError("'뒤로' 버튼을 한 번 더 누르시면 종료됩니다.");
    } else if (backKeyPressed == 0) {
        window.backKeyPressed = 1;
    }

    if ( window.backKeyPressed == 1) {
        (isBrowser || (co.Common.dispose(), MDHUtil.Browser.terminateApp()))
    } else {
        window.setTimeout(function() {
            window.backKeyPressed = -1;
        },2000);
    }
}

function formElementChanged() {
    $( ":text, textarea, select" ).unbind("change").bind( "change", function( event ) {
        var o = $(this);

        for (var i=0;i<o.length;i++) {
            console.info ( o[i] );
            var ph = $(o[i]).attr("placeholder");
            var rph = $(o[i]).attr("restore_placeholder");
            console.info ( o[i].tagName, ph,rph );

            if ( o[i].tagName.toLowerCase() == "textarea" ) {
                if ( ph || rph ) {
                    if ($(o[i]).val()) {
                        $(o[i]).removeAttr("placeholder");
                        $(o[i]).attr("restore_placeholder",ph);
                    } else {
                        $(o[i]).removeAttr("restore_placeholder");
                        $(o[i]).attr("placeholder",rph);
                    }
                }
            } else if ( o[i].tagName.toLowerCase() == "select" ) {
                var v = $(o[i]).val();
                console.info($(o[i]).val());
                if ( v && v != "선택하세요." && v != "선택하세요" ) {
                    $(o[i]).addClass("greypoint");
                } else {
                    $(o[i]).removeClass("greypoint");
                }
            }
        }
    });
}

function resizeContent() {
    var windowHeight = $(window).height();
    var topHeight = $("#top").height();
    $('.mo-layout-content').css({'height':(windowHeight-57)+'px'});
}

//$(window).resize(function() {
//    resizeContent();
//});

function endScoll(o) {
//  $('body').animate({scrollTop : $("body")[0].scrollHeight}, 1000);
  var a = o?o:$('body');
  a.animate({scrollTop : a[0].scrollHeight}, 1000);
}

function bindTopButton(){
  $(".mo-btn-top").unbind("click").bind("click",function(e) {
      $("body").scrollTop(0);
  });

  $(".mo-btn-top").hide();
  $( window ).scroll(function() {
      if( $("body").scrollTop() == 0 ) {
          $(".mo-btn-top").hide();
      } else {
          if (!$(".mo-btn-top").is(":visible")) {
              $(".mo-btn-top").hide().stop( true, true ).fadeIn(1000).show();
          }
      }
  });
}
//------- not used
/* softm added
jQuery.fn.extend({
	  focus: function() {
		    return this.each(function() {
			      //this.checked = true;
		    	//console.info(this);
		    	this.focus();
		    	$("#contents").scrollTop($(this).offset().top);
			});
	  }
});
*/
