var lds = new loadJsCss('head');
function 결제조회(s,userLevel) {
    lds.addJs ('mod2','../inc/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118' );
  //lds.addCss('mod1','../inc/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112');
    var ajaxR = new asyncConnector('xmlhttp');
    var url  = '../service/gateway.php';
        url += '?p_hash=' + p_hash;

    ajaxR.openCallBack= function (str) {
        ajaxR.dataArea.innerHTML = ajaxR.responseText();
        loadSwf.hideSwf();
    }

    var bData = {service    : 'PRODUCT',
                 className  : 'admin.Payment',
                 method     : 'getList'   ,
                 argus      : {
                                s:s,
                                s_user_level:userLevel?userLevel:($('sForm')?$('sForm').s_user_level.value:''),
                                s_direct_gb:($('sForm')?$('sForm').s_direct_gb.value:null),
                                s_pay_method:($('sForm')?$('sForm').s_pay_method.value:null),
                                s_payment_state:($('sForm')?$('sForm').s_payment_state.value:null),
                                s_pay_gb:($('sForm')?$('sForm').s_pay_gb.value:null),
                                s_pay_add_gb:($('sForm')?$('sForm').s_pay_add_gb.value:null),
                                s_gubun:($('sForm')?$('sForm').s_gubun.value:null),
                                s_search:($('sForm')?$('sForm').s_search.value:null),
                                s_reg_date:($('sForm')?$('s_reg_date').value:null),
                                e_reg_date:($('sForm')?$('e_reg_date').value:null),
                                p_chg_state     :($('p_chg_state'       )?$('p_chg_state').value:null)
                              }
                };
    //alert(JSON.stringify(bData));
    // loadSwf 용도 : "로딩중..." 표시
    loadSwf.showSwf();
    //alert(typeof(document.searchForm.tagName));
    //alert( JSON.stringify(bData) );
    //ajaxR.httpOpen('POST', url, true,'strJSON=' + encodeURIComponent(JSON.stringify(bData)), $("area01"));
    ajaxR.httpOpen('POST', url, true,encodeURIComponent(JSON.stringify(bData)), $("area01"));
    return false;
}

function 결제선택상태수정(m) {
    var payObj = document.getElementsByName('chk_pay_no');
    var l = payObj.length;
    var delCnt = 0;
    var payNos = Array();
    for (var i=0; i<l; i++) {
        if (payObj[i].checked ) {
            payNos.push(payObj[i].value);
            delCnt++
        }
    }

    var mStr = $('p_chg_state').options[$('p_chg_state').selectedIndex].text;
    if ( delCnt == 0 ) {
        alert('선택된 결제가 없습니다.');
    } else {
        var msg = '결제를 "' +  mStr + '" 상태로 변경하시겠습니까?';
        if ($('p_chg_state').value=='A') {
            msg += "\n이미 승인된 이력은 재승인되지 않습니다."
        }

        if (confirm(msg)) {
            var ajaxR = new asyncConnector('xmlhttp');
            var url  = '../service/gateway.php';
                url += '?p_hash=' + p_hash;

            ajaxR.openCallBack= function (str) {
                //var xmlDoc=ajaxR.responseXml();
                loadSwf.hideSwf();
                var rtn = ajaxR.responseText();
                var info = rtn.split('|');
                if ( info[0] == 'SUCCESS' ) {
                    결제조회();
                } else if ( info[0] == 'ERROR' ) {
                    alert('처리중 에러가 발생하였습니다.\n[' + info[1] + ']');
                }
                ajaxR.dataArea.innerHTML = ajaxR.responseText();
            }

            var bData = {service    : 'PRODUCT',
                         className  : 'admin.Payment',
                         method     : 'stateProcess'     ,
                         argus      : {
                                        state:$('p_chg_state').value,
                                        pay_nos:payNos
                                       }
                        };
            loadSwf.showSwf();
            ajaxR.httpOpen('POST', url, true,encodeURIComponent(JSON.stringify(bData)), $("area02"));
        }
    }
    return true;
}