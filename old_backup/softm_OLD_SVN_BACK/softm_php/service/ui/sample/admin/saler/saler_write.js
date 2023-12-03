function 중개회원작성실행(mode) {
    var f = $('wForm');
    var chk = true;
    var cObj = null;

    var mObj = $('msg');
        cObj = $('user_id');
    if ( mode == 'I' && !valid ) {
        mObj.innerHTML = "아이디 중복확인을 해주세요.";
        eTwinkle(cObj,mObj);
        return false;
    }

    if ( chk ) {
        if (mode == 'I') {
            cObj = $('passwd');
            if ( !cObj.disabled && !cObj.value.trim() ) {
                mObj.innerHTML = "비밀 번호 입력을 확인해 주세요.";
                eTwinkle(cObj,mObj);
                return false;
            }

            cObj = $('c_passwd');
            if ( $('passwd').value != cObj.value ) {
                mObj.innerHTML = "비밀 번호가 일치 하지 않습니다.";
                eTwinkle(cObj,mObj);
                return false;
            }
        }

        cObj = $('company_name');
        if ( !cObj.value ) {
             mObj.innerHTML = "업체명을 입력해주세요.";
            eTwinkle(cObj,mObj);
            return false;
        }

        cObj = $('company_no');
        if ( !cObj.value || !checkBizRegNo(cObj.value) ) {
             mObj.innerHTML = "사업자등록번호를 정확히 입력해주세요.";
            eTwinkle(cObj,mObj);
            return false;
        }

        cObj = $('user_name');
        if ( !cObj.value ) {
             mObj.innerHTML = "이름을 입력해주세요.";
            eTwinkle(cObj,mObj);
            return false;
        }

        cObj = $('jumin_no1');
        if (!checkJumin($('jumin_no1').value,$('jumin_no2').value)) {
            mObj.innerHTML = "주민등록번호를 확인해 주세요.";
            eTwinkle(cObj,mObj);
            return false;
        }

        var ReExp1=/\d{2,3}/;
        var ReExp2=/\d{3,4}/;
        var ReExp3=/\d{4}/;
        cObj = $('tel1_2');
        cObj.value =cObj.value.trim();
        if ( !ReExp2.test(cObj.value) ) {
            mObj.innerHTML = "핸드폰번호를 입력해주세요.";
            eTwinkle(cObj,mObj);
            return false;
        }

        cObj = $('tel1_3');
        cObj.value =cObj.value.trim();
        if ( !ReExp3.test(cObj.value) ) {
            mObj.innerHTML = "핸드폰번호를 입력해주세요.";
            eTwinkle(cObj,mObj);
            return false;
        }

        cObj = $('e_mail');
        if ( cObj.value != '' && !isEmail(cObj.value) ) {
            mObj.innerHTML = "이메일주소를 올바르게 입력해 주세요.";
            eTwinkle(cObj,mObj);
            return false;
        }

        cObj = $('post_btn');
        if ( $('post_no').value == '' ) {
            mObj.innerHTML = "주소를 입력해 주세요.";
            eTwinkle(cObj,mObj);
            return false;
        }

        var ReExp1=/\d{2,3}/;
        var ReExp2=/\d{3,4}/;
        var ReExp3=/\d{4}/;
        cObj = $('tel2_2');
        cObj.value =cObj.value.trim();
        if ( !ReExp2.test(cObj.value) ) {
            mObj.innerHTML = "전화번호를 입력해주세요.";
            eTwinkle(cObj,mObj);
            return false;
        }

        cObj = $('tel2_3');
        cObj.value =cObj.value.trim();
        if ( !ReExp3.test(cObj.value) ) {
            mObj.innerHTML = "전화번호를 입력해주세요.";
            eTwinkle(cObj,mObj);
            return false;
        }

    } else {
        eTwinkle(cObj,mObj);
        return false;
    }
    mObj.innerHTML = "<b>입력내용이 정확합니다.</b>";

    if (confirm('저장하시겠습니까?')) {
        var ajaxR = new asyncConnector('xmlhttp');
        var url  = '../service/gateway.php';
            url += '?p_hash=' + p_hash;

        ajaxR.openCallBack= function (str) {
            //var xmlDoc=ajaxR.responseXml();
            loadSwf.hideSwf();
            var rtn = ajaxR.responseText();
            var info = rtn.split('|');
            if ( info[0] == 'SUCCESS' ) {
                중개회원조회();
            } else if ( info[0] == 'ERROR' ) {
                alert('처리중 에러가 발생하였습니다.\n[' + info[1] + ']');
            }
            ajaxR.dataArea.innerHTML = ajaxR.responseText();
        }

        var bData = {service    : 'SALER',
                     className  : 'admin.Saler',
                     method     : 'writeExec'     ,
                     argus      : {
                                    mode:mode,
                                    user_no:$('wForm').user_no.value,
                                    user_id:$('wForm').user_id.value,
                                    change_pwd:mode=='U' && $('change_pwd').checked?'Y':'N',
                                    passwd:$('wForm').passwd.value,
                                    company_name:$('wForm').company_name.value,
                                    company_no:$('wForm').company_no.value,
                                    user_name:$('wForm').user_name.value,
                                    user_level:$('wForm').user_level.value,
                                    jumin_no:$('wForm').jumin_no1.value + $('wForm').jumin_no2.value,
                                    sex:($('wForm').jumin_no2.value.substring(0,1) == '1' || $('wForm').jumin_no2.value.substring(0,1) == '3'?'M':'F'),
                                    tel1:$('wForm').tel1_1.value + $('wForm').tel1_2.value + $('wForm').tel1_3.value,
                                    e_mail:$('wForm').e_mail.value,
                                    email_yn:$('wForm').email_yn[0].checked?'Y':'N',
                                    post_no:$('wForm').post_no.value,
                                    address1:$('wForm').address1.value,
                                    address2:$('wForm').address2.value,
                                    tel2:$('wForm').tel2_1.value + $('wForm').tel2_2.value + $('wForm').tel2_3.value
                                  }
                    };
        loadSwf.showSwf();
        ajaxR.httpOpen('POST', url, true,encodeURIComponent(JSON.stringify(bData)), $("area02"));
    }

    return true;
}

function 비밀번호변경() {
    //alert($('change_pwd').checked);
    if (!$('change_pwd').checked) {
        $('passwd').style.cssText='width:100px;background-color:gray';
        $('c_passwd').style.cssText='width:100px;background-color:gray';
        $('passwd').readOnly = true;
        $('c_passwd').readOnly = true;
    } else {
        $('passwd').style.cssText='width:100px;';
        $('c_passwd').style.cssText='width:100px;';
        $('passwd').readOnly = false;
        $('c_passwd').readOnly = false;
        $('passwd').focus();
    }
}

function dupCheck(w,h) {
    var userId = document.myForm.p_user_id.value;
    if ( idCheck(userId) ) {
        var url = '../common/popup_user_dup_search.php?p_user_id=' + userId;
        popupWin = window.open('about:blank',"pop_dup_chk","width=" + w +",height=" + h + ",toolbar=no,menubar=no,resizable=yes,scrollbars=auto");
        document.campusForm.target = 'pop_dup_chk';
        document.campusForm.action = url;
        document.campusForm.submit();
        popupWin.focus();
    }
}

function idCheck(userId) {
    var chk = true;
    if ( userId.length < 4 || userId.length > 20 ) {
        $('msg').innerHTML = "아이디는 4자 이상, 20자 이하여야 합니다.";
        chk = false;
    }

    if ( !userId.trim() ) {
        $('msg').innerHTML = "아이디가 입력되지 않았거나 공백 문자를 사용하셨습니다.";
        chk = false;
    }

    if ( !isAlphaNum (userId) ) {
        $('msg').innerHTML = "'영문', '숫자', '_'로만 아이들 작성해 주세요.";
        chk = false;
    }

    return chk;
}
function isAlphaNum (argu)
{
    var AlphaNum = "1234567890_ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var ch1 = '';
    var ii=0;
    var L = argu.length;
    argu = argu.toUpperCase();
    for (var i=0; i < L; i++) {
        ch1 = argu.charAt(i);
        if ( AlphaNum.indexOf(ch1) < 0 ) { ii = 0; break; }
        else { ii=10; }
    }
    if ( ii == 10 ) { return true; } else { return false; }
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


function setPost(argus) {
    var f = $('wForm');
    f.post_no.value = argus.post_no;
    f.address1.value = argus.address;
    f.address2.focus();
}