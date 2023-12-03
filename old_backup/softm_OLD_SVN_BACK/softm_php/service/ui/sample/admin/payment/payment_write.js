function 결제작성실행(mode) {
    if (!changed) {
        alert ( '변경된 내용이 없습니다.' );
        return false;
    }
    if (doubleTrans) {
        return false;
    }
    var f = $('wForm');

    if (confirm('저장하시겠습니까?')) {
    var url  = '../service/gateway.php';
        url += '?p_hash=' + p_hash;

    var ajaxR = new asyncConnector('xmlhttp');
        ajaxR.openCallBack= function (str) {
            //ajaxR.dataArea.innerHTML = ajaxR.responseText();
            //alert(ajaxR.responseText());
            loadSwf.hideSwf();
            결제조회(1);
        }

        var bData = {service    : 'SESSION',
                     className  : 'admin.Payment',
                     method     : 'writeExec'     ,
                     argus      : {
                                mode        :mode,
                                pay_no      :$('pay_no'      ).value,
                                amount      :$('amount'      ).value,
                                surtax      :$('surtax'      ).value,
                                period      :$('period'      ).value,
                                tot_amount  :$('tot_amount'  ).value,
                                in_name     :$('in_name'     ).value,

                                avail_cnt   :$('avail_cnt'   ).value,
                                reg_cnt     :$('reg_cnt'     ).value,

                                pay_date    :$('pay_date'    ).value,
                                confirm_date:$('confirm_date').value,
                                end_date    :$('end_date'    ).value,

                                content     :$('content'     ).value,

                                prod_no     :$('prod_no'     ).value
                                }
                };
        loadSwf.showSwf();
        doubleTrans = true;
        ajaxR.httpOpen('POST', url, false,encodeURIComponent(JSON.stringify(bData)));
    }

    return true;
}

function setPost(argus) {
    var f = $('wForm');
    f.post_no.value = argus.post_no;
    f.address1.value = argus.address;
    f.address2.focus();
}


function 아이디조회(user_id) {
    var ajaxR = new asyncConnector('xmlhttp');
    var url  = '../service/gateway.php';
        url += '?p_hash=' + p_hash;

    ajaxR.openCallBack= function (str) {
        var r = ajaxR.responseText();
        if ( r ) {
            var d = JSON.parse(r);
            $('user_name').value  = d.USER_NAME   ;
            $('user_no').value    = d.USER_NO     ;
            $('user_level').value = d.USER_LEVEL  ;
            $('d_user_level').innerText = $('user_level')[$('user_level').selectedIndex].text;
            $('company_name').value = d.COMPANY_NAME;
            tel1_info.innerText = d.TEL1;
            tel2_info.innerText = d.TEL2;
            $('addr_info').innerText = d.POST_NO + "\n" + d.ADDRESS1 + " " + d.ADDRESS2;
        } else {
        }
        loadSwf.hideSwf();
    }

        var bData = {service    : 'SESSION',
                     className  : 'common.Session',
                     method     : 'getUserInfo'     ,
                     argus      : {
                                p_user_id:user_id
                                }
                };
    loadSwf.showSwf();
    ajaxR.httpOpen('POST', url, false,encodeURIComponent(JSON.stringify(bData)));
    return false;
}