function 매물작성실행(mode) {
    if (!changed) {
        alert ( '변경된 내용이 없습니다.' );
        return false;
    }
    if (doubleTrans) {
        return false;
    }
    var f = $('wForm');
    var chk = true;
    var cObj = null;

    var mObj = $('msg');

        cObj = $('head_title');
        if ( !cObj.value ) {
             mObj.innerHTML = "글머리를 입력해주세요.";
            eTwinkle(cObj,mObj);
            return false;
        }

        cObj = $('p_user_id');
        if ( !cObj.value.trim()  ) {
             mObj.innerHTML = "아이디를 입력해 주세요.";
            eTwinkle(cObj,mObj);
            return false;
        }

        if ( !$('p_user_no').value.trim()  ) {
             mObj.innerHTML = "회원아이디가 존재하지 않습니다. 아이디를 다시 입력해 주세요.";
            eTwinkle($('p_user_id'),mObj);
            return false;
        }

        if ( ( $('tel1_2').value.trim() + $('tel1_3').value.trim() ) == '' &&
             ( $('tel2_2').value.trim() + $('tel2_3').value.trim() ) == ''
            )
        {
            alert('핸드폰,전화번호중 하나는 입력하세요');
            eTwinkle($('tel2_2'));
            eTwinkle($('tel2_3'));
            eTwinkle($('tel1_2'));
            eTwinkle($('tel1_3'));
            return false;
        } else {
            var ReExp1=/\d{2,3}/;
            var ReExp2=/\d{3,4}/;
            var ReExp3=/\d{4}/;
            cObj = $('tel2_2');
            cObj.value =cObj.value.trim();
            if ( cObj.value && !ReExp2.test(cObj.value) ) {
                mObj.innerHTML = "전화번호를 입력해주세요.";
                eTwinkle(cObj,mObj);
                return false;
            }

            cObj = $('tel2_3');
            cObj.value =cObj.value.trim();
            if ( cObj.value && !ReExp3.test(cObj.value) ) {
                mObj.innerHTML = "전화번호를 입력해주세요.";
                eTwinkle(cObj,mObj);
                return false;
            }

            cObj = $('tel1_2');
            cObj.value =cObj.value.trim();
            if ( cObj.value && !ReExp2.test(cObj.value) ) {
                mObj.innerHTML = "핸드폰번호를 입력해주세요.";
                eTwinkle(cObj,mObj);
                return false;
            }

            cObj = $('tel1_3');
            cObj.value =cObj.value.trim();
            if ( cObj.value && !ReExp3.test(cObj.value) ) {
                mObj.innerHTML = "핸드폰번호를 입력해주세요.";
                eTwinkle(cObj,mObj);
                return false;
            }
        }

        cObj = $('p_user_name');
        if ( !cObj.value.trim()  ) {
             mObj.innerHTML = "이름을 입력해 주세요.";
            eTwinkle(cObj,mObj);
            return false;
        }

    mObj.innerHTML = "<b>입력내용이 정확합니다.</b>";

    if (confirm('저장하시겠습니까?')) {
        fileUpload.setForm($('wForm'),'../service/admin/admin_iexec.php', function () {
                loadSwf.hideSwf();
                var rtn = fileUpload.iframe.contentWindow.document.body.innerHTML;
                var info = rtn.split('|');
                if ( info[0] == 'SUCCESS' ) {
                    if (mode == 'I') {
                        alert('매물이 등록 되었습니다.');
                    } else {
                        alert('매물이 수정 되었습니다.');
                    }
                    doubleTrans = false;
                    changed     = false;
                    매물작성($('prod_no').value);
                    //매물조회();

                } else if ( info[0] == 'ERROR' ) {
                    alert('처리중 에러가 발생하였습니다.\n[' + info[1] + ']');
                    doubleTrans = false;
                }
            }
        );

        fileUpload.submit();
        doubleTrans = true;
        loadSwf.showSwf();


        //ajaxR.httpOpen('POST', url, true,encodeURIComponent(JSON.stringify(bData)), $("area02"));
    }

    return true;
}

function setPost(argus) {
    var f = $('wForm');
    f.post_no.value = argus.post_no;
    f.address1.value = argus.address;
    f.address2.focus();
}


function 아이디조회(p_user_id) {
    var ajaxR = new asyncConnector('xmlhttp');
    var url  = '../service/gateway.php';
        url += '?p_hash=' + p_hash;

    if( p_user_id ) $('p_user_id').value  = p_user_id;

    ajaxR.openCallBack= function (str) {
        var r = ajaxR.responseText();

        if ( r ) {
            var d = JSON.parse(r);
            $('p_user_name').value  = d.USER_NAME   ;
            $('p_user_no').value    = d.USER_NO     ;
            $('p_user_level').value = d.USER_LEVEL  ;
            $('d_user_level').innerText = $('p_user_level')[$('p_user_level').selectedIndex].text;
            $('company_name').value = d.COMPANY_NAME;

            var tInfo = d.TEL1.split('-');

            if (tInfo[0]) $('tel1_1').value = tInfo[0];
            else          $('tel1_1').value = '011';
            $('tel1_2').value = tInfo[1];
            $('tel1_3').value = tInfo[2];

            var t2Info = d.TEL2.split('-');
            if (t2Info[0]) $('tel2_1').value = t2Info[0];
            else           $('tel2_1').value = '02';
            $('tel2_2').value = t2Info[1];
            $('tel2_3').value = t2Info[2];

            $('post_no').value  = d.POST_NO ;
            $('address1').value = d.ADDRESS1;
            $('address2').value = d.ADDRESS2;
            var mObj = $('msg');
            mObj.innerHTML = '<font color=#000>' + $('p_user_name').value + ' [' + $('p_user_id').value + ']</font>' + " 회원으로 매물등록을 합니다.";

        } else {
            $('p_user_name').value  = '';
            $('p_user_no').value    = '';
            $('p_user_level').value = '';
            $('d_user_level').innerText = '없음';
            $('company_name').value = '';

            $('tel1_1').value = '010';
            $('tel1_2').value = ''   ;
            $('tel1_3').value = ''   ;

            $('tel2_1').value = '02';
            $('tel2_2').value = ''  ;
            $('tel2_3').value = ''  ;

            $('post_no').value  = '';
            $('address1').value = '';
            $('address2').value = '';

            var mObj = $('msg');
            mObj.innerHTML = "회원아이디가 존재하지 않습니다. 아이디를 다시 입력해 주세요.";
            eTwinkle($('p_user_id'),mObj);

        }
        loadSwf.hideSwf();
    }

        var bData = {service    : 'SESSION',
                     className  : 'common.Session',
                     method     : 'getUserInfo'     ,
                     argus      : {
                                p_user_id:p_user_id
                                }
                };
    loadSwf.showSwf();
    ajaxR.httpOpen('POST', url, false,encodeURIComponent(JSON.stringify(bData)));
    return false;
}