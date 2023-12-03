function onInit(argus) {
    if (jQuery.browser.msie) {}
    if ( LOGIN ) {
//    	alert(argus.mode);
        call('JSON','front.Member','get',
            {p_user_no:USER_NO},
            function(xmlDoc){
                var json  = Util.xml2json(xmlDoc);
                if ( json["return"] == '200' ) { // success
//                	alert(json.message); // success
                	var form = $S('wForm');
					Util.domReady(
						function() {
							Form.bind(json.fi,json.item,$S('wForm'));
						}
					);
//            	    form['re_passwd'].value = form['passwd'].value;
                } else if (json["return"] == '500') {
                    alert(json.message); // error
                }
            }
        );    
    } else {
        $S('wForm').user_email.onchange = function(e) { 중복검사(); return true; };
    }
}

function 실행() {
    if ( LOGIN ) {
    	if ( !$S('wForm').passwd.value.trim() ) {
        	removeClass($S('wForm').passwd	 ,"required");
        	removeClass($S('wForm').re_passwd,"required");    		
    	} else {
        	addClass($S('wForm').passwd	  ,"required");
        	addClass($S('wForm').re_passwd,"required");
    	}
    	removeClass($S('wForm').user_email,"required");
    } else {

    }
	
    if (
        Form.validate( $S('wForm') ,{
	        user_email:function(){ Effect.twinkle($S('wForm').user_email);},
	        passwd:function(){ Effect.twinkle($S('wForm').passwd);},
	        re_passwd:function(){ Effect.twinkle($S('wForm').re_passwd);},
	        user_name:function(){ Effect.twinkle($S('wForm').user_name);},
	        passwd_hint:function(){ Effect.twinkle($S('wForm').passwd_hint);},
	        passwd_correct:function(){ Effect.twinkle($S('wForm').passwd_correct);}
        }) 
    )
    {
    	if ( $S('wForm').passwd.value != $S('wForm').re_passwd.value ) {
    		alert("비밀번호와 비밀번호확인이 다릅니다.");
    		return false;
    	}
    	
    	var exec = false;
    	if ( !LOGIN ) {
        	if ( confirm("가입하시겠습니까?") ) {
            	exec = 중복검사();        		
        	} 
    	} else {
    		if ( $S('wForm').passwd.value.trim() ) {
            	if ( confirm("비밀번호를 수정하시겠습니까?") ) {
                	exec = true;
            	}
    		} else {
            	if ( confirm("수정하시겠습니까?") ) {
                	exec = true;
            	}
    		}
    	}
    	
    	if ( exec ) {
    	    // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
            //  call(requestType,className,method,argus,cb,form)
	        call('JSON','front.Member',!LOGIN?'register':'update',
	            {
	        	    user_id:$S('wForm').user_id.value.trim(),
		            user_email:$S('wForm').user_email.value.trim(),
		            passwd:$S('wForm').passwd.value.trim(),
		            user_name:$S('wForm').user_name.value.trim(),
		            passwd_hint:$S('wForm').passwd_hint.value.trim(),
		            passwd_correct:$S('wForm').passwd_correct.value.trim(),
		            user_no:USER_NO
	            },
	            function(xmlDoc){
	                var json  = Util.xml2json(xmlDoc);
	                if ( json["return"] == '200' ) { // success
	                    alert(json.message); // success
	                	if ( !LOGIN ) {	                    
	                		document.location.href = "/";
	                	}
	                } else if (json["return"] == '500') {
	                    alert(json.message); // error
	                }
	            }
	        );
    	}
    }
    return false;
}

var dupCheck = false;
function 중복검사() {
	if ( !$S('wForm').user_email.value ) return false;
	callJSONSync('front.Member','checkDupId',
	    {
	    	p_user_id:$S('wForm').user_id.value.trim()
	    },
	    function(xmlDoc){
	        var json  = Util.xml2json(xmlDoc);
	        if ( json["return"] == '200' ) { // success
//	            alert(json.message); // success
	            dupCheck = true;
	        } else if (json["return"] == '500') {
	            alert(json.message); // error
	            dupCheck = false;
	        }
	    }
	);
	return dupCheck;
}

function checkBizRegNo(bizID)
{
    var checkID = new Array(1, 3, 7, 1, 3, 7, 1, 3, 5, 1);
    var i, Sum=0, c2, remander;        bizID = bizID.replace(/-/gi,'');
    for (i=0; i<=7; i++){
           Sum += checkID[i] * bizID.charAt(i);
    }

    c2 = "0" + (checkID[8] * bizID.charAt(8));
    c2 = c2.substring(c2.length - 2, c2.length);

    Sum += Math.floor(c2.charAt(0)) + Math.floor(c2.charAt(1));

    remander = (10 - (Sum % 10)) % 10 ;

    if(bizID.length != 10){
           return false;
    }else if (Math.floor(bizID.charAt(9)) != remander){
           return false;
    }else{
           return true;
    }
}

function checkJumin(ssn1,ssn2) {
    var ssn = ssn1+ ssn2;
    if (ssn.length != 13) {
        return false;
    }
    var a=ssn.substring(0,1);
    var b=ssn.substring(1,2);
    var c=ssn.substring(2,3);
    var d=ssn.substring(3,4);
    var e=ssn.substring(4,5);
    var f=ssn.substring(5,6);
    var g=ssn.substring(6,7);
    var h=ssn.substring(7,8);
    var i=ssn.substring(8,9);
    var j=ssn.substring(9,10);
    var k=ssn.substring(10,11);
    var l=ssn.substring(11,12);
    var m=ssn.substring(12,13);
    var sum = 2*a + 3*b + 4*c+ 5*d + 6*e+ 7*f+ 8*g + 9*h+ 2*i+3*j+ 4*k+ 5*l;
    var r1 = sum%11;
    var temp = 11* ((sum-r1)/11) + 11 - sum;
    var r2 = temp%10;
    var temp1 = temp- 10*((temp-r2)/10);
    if (m != temp1) {
        return false;
    }
    return true;
}
