var lds = new loadJsCss('head');

function 중개회원조회(s) {
    lds.addJs ('mod2','../inc/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118' );
  //lds.addCss('mod1','../inc/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112');
    var ajaxR = new asyncConnector('xmlhttp');
    var url  = '../service/gateway.php';
        url += '?p_hash=' + p_hash;

    ajaxR.openCallBack= function (str) {
        ajaxR.dataArea.innerHTML = ajaxR.responseText();
        loadSwf.hideSwf();
    }
    var bData = {service    : 'SALER',
                 className  : 'admin.Saler',
                 method     : 'getList'     ,
                 argus      : {
                                s:s,
                                s_user_level:($('sForm')?$('sForm').s_user_level.value:null),
                                s_gubun:($('sForm')?$('sForm').s_gubun.value:null),
                                s_search:($('sForm')?$('sForm').s_search.value:null),
                                s_reg_date:($('sForm')?$('s_reg_date').value:null),
                                e_reg_date:($('sForm')?$('e_reg_date').value:null)
                              }
                };

    // loadSwf 용도 : "로딩중..." 표시
    loadSwf.showSwf();
    //alert(typeof(document.searchForm.tagName));
    //alert( JSON.stringify(bData) );
    //ajaxR.httpOpen('POST', url, true,'strJSON=' + encodeURIComponent(JSON.stringify(bData)), $("area01"));
    ajaxR.httpOpen('POST', url, true,encodeURIComponent(JSON.stringify(bData)), $("area01"));
    return false;
}

function 중개회원작성(userNo) {
    lds.addJs ('mod3','../service/ui/admin/saler/saler_write.js' );
    lds.addJs ('mod4','../inc/js/twinkle.js' );
    lds.addJs ('session','../service/ui/common/session.js' );

  //lds.addCss('mod1','<?=BASE_DIR?>/inc/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112');
    var ajaxR = new asyncConnector('xmlhttp');
    var url  = '../service/gateway.php';
        url += '?p_hash=' + p_hash;

    ajaxR.openCallBack= function (str) {
        ajaxR.dataArea.innerHTML = ajaxR.responseText();
        loadSwf.hideSwf();
    }

    var bData = {service    : 'SALER',
                 className  : 'admin.Saler',
                 method     : 'getWrite'     ,
                 argus      : {
                                mode:!userNo?"I":"U",
                                p_user_no:userNo
                              }};

    // loadSwf 용도 : "로딩중..." 표시
    loadSwf.showSwf();
    //alert(typeof(document.searchForm.tagName));
    //alert( JSON.stringify(bData) );
    //ajaxR.httpOpen('POST', url, true,'strJSON=' + encodeURIComponent(JSON.stringify(bData)), $("area01"));
    ajaxR.httpOpen('POST', url, true,encodeURIComponent(JSON.stringify(bData)), $("area01"));
    return false;
}

function 중개회원선택삭제() {
    var delObj = document.getElementsByName('delete_no');
    var l = delObj.length;
    var delCnt = 0;
    var delUserNos = Array();
    for (var i=0; i<l; i++) {
        if (delObj[i].checked ) {
            delUserNos.push(delObj[i].value);
            delCnt++
        }
    }

    if ( delCnt == 0 ) {
        alert('선택된 자료가 없습니다.');
    } else {
        if (confirm('선택된 회원을 삭제 하시겠습니까?')) {
            var ajaxR = new asyncConnector('xmlhttp');
            var url  = '../service/gateway.php';
                url += '?p_hash=' + p_hash;

            ajaxR.openCallBack= function (str) {
                //var xmlDoc=ajaxR.responseXml();
                loadSwf.hideSwf();
                var rtn = ajaxR.responseText();
                var info = rtn.split('|');
                if ( info[0] == 'SUCCESS' ) {
                    일반회원조회();
                } else if ( info[0] == 'ERROR' ) {
                    alert('처리중 에러가 발생하였습니다.\n[' + info[1] + ']');
                }
                ajaxR.dataArea.innerHTML = ajaxR.responseText();
            }

            var bData = {service    : 'SALER',
                         className  : 'admin.Saler',
                         method     : 'deleteExec'     ,
                         argus      : {
                                        mode:'D',
                                        user_nos:delUserNos
                                      }
                        };
            loadSwf.showSwf();
            ajaxR.httpOpen('POST', url, true,encodeURIComponent(JSON.stringify(bData)), $("area02"));
        }
    }
    return true;
}