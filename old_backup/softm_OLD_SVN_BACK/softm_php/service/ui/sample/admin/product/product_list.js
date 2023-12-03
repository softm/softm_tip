var lds = new loadJsCss('head');

function 매물조회(s,userLevel) {
    lds.addJs ('mod_cal','../inc/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118' );
  //lds.addCss('mod1','../inc/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112');
    var ajaxR = new asyncConnector('xmlhttp');
    var url  = '../service/gateway.php';
        url += '?p_hash=' + p_hash;

    ajaxR.openCallBack= function (str) {
        ajaxR.dataArea.innerHTML = ajaxR.responseText();
        disableDateSearch($('s_on_date_search'));
        loadSwf.hideSwf();
    }

    var bData = {service    : 'PRODUCT',
                 className  : 'admin.Product',
                 method     : 'getList'     ,
                 argus      : {
                                s:s,
                                s_user_level    :userLevel?userLevel:($('sForm')?$('sForm').s_user_level.value:''),
                                s_direct_gb     :($('s_direct_gb'       )?$('s_direct_gb').value:null),
                                s_prod_gb       :($('s_prod_gb'         )?$('s_prod_gb').value:null),
                                s_trade_gb      :($('s_trade_gb'        )?$('s_trade_gb').value:null),
                                s_state         :($('s_state'           )?$('s_state').value:null),
                                s_trade_state   :($('s_trade_state'     )?$('s_trade_state').value:null),
                                s_exfire_yn     :($('s_exfire_yn'       )?$('s_exfire_yn').value:null),
                                s_gubun2        :($('s_gubun2'          )?$('s_gubun2').value:null),
                                s_search2_1     :($('s_search2_1'       )?$('s_search2_1').value:null),
                                s_search2_2     :($('s_search2_2'       )?$('s_search2_2').value:null),
                                s_directin_yn   :($('s_directin_yn'     )?$('s_directin_yn').value:null),
                                s_new_yn        :($('s_new_yn'          )?$('s_new_yn').value:null),
                                s_gubun         :($('s_gubun'           )?$('s_gubun').value:null),
                                s_search        :($('s_search'          )?$('s_search').value:null),
                                s_date_gubun    :($('s_date_gubun'      )?$('s_date_gubun').value:null),
                                s_reg_date      :($('s_reg_date'        )?$('s_reg_date').value:null),
                                e_reg_date      :($('e_reg_date'        )?$('e_reg_date').value:null),
                                s_on_date_search:($('s_on_date_search'  )?($('s_on_date_search').checked?'Y':'N'):null),
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

function 매물작성(prodNo) {
    lds.addJs ('mod_cal','../inc/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118' );
    lds.addJs ('mod_file','../inc/js/fileUpload.js' );
    lds.addJs ('mod_prod','../service/ui/admin/product/product_write.js' );
    lds.addJs ('mod_twinkle','../inc/js/twinkle.js' );

  //lds.addCss('mod1','<?=BASE_DIR?>/inc/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112');
    var ajaxR = new asyncConnector('xmlhttp');
    var url  = '../service/gateway.php';
        url += '?p_hash=' + p_hash;

    var mode = !prodNo?"I":"U";
    //alert( mode );
    ajaxR.openCallBack= function (str) {
        ajaxR.dataArea.innerHTML = ajaxR.responseText();
        if (mode == 'I') 아이디조회('ilban');
        window.setTimeout(function(){
            $('head_title').focus();
        },100);

        loadSwf.hideSwf();
    }

    var bData = {service    : 'PRODUCT',
                 className  : 'admin.Product',
                 method     : 'getWrite'     ,
                 argus      : {
                                mode:!prodNo?"I":"U",
                                p_prod_no:prodNo
                              }};

    // loadSwf 용도 : "로딩중..." 표시
    loadSwf.showSwf();
    ajaxR.httpOpen('POST', url, true,encodeURIComponent(JSON.stringify(bData)), $("area01"));

    return false;
}

function 매물선택상태수정() {
    var prodObj = document.getElementsByName('chk_prod_no');
    var l = prodObj.length;
    var delCnt = 0;
    var prodNos = Array();
    for (var i=0; i<l; i++) {
        if (prodObj[i].checked ) {
            prodNos.push(prodObj[i].value);
            delCnt++
        }
    }

    var mStr = $('p_chg_state').options[$('p_chg_state').selectedIndex].text;

    if ( delCnt == 0 ) {
        alert('선택된 매물이 없습니다.');
    } else {
        if (confirm('매물을 "' +  mStr + '" 상태로 변경하시겠습니까?')) {
            var ajaxR = new asyncConnector('xmlhttp');
            var url  = '../service/gateway.php';
                url += '?p_hash=' + p_hash;

            ajaxR.openCallBack= function (str) {
                //var xmlDoc=ajaxR.responseXml();
                loadSwf.hideSwf();
                var rtn = ajaxR.responseText();
                var info = rtn.split('|');
                if ( info[0] == 'SUCCESS' ) {
                    매물조회();
                } else if ( info[0] == 'ERROR' ) {
                    alert('처리중 에러가 발생하였습니다.\n[' + info[1] + ']');
                }
                ajaxR.dataArea.innerHTML = ajaxR.responseText();
            }

            var bData = {service    : 'PRODUCT',
                         className  : 'admin.Product',
                         method     : 'changeState'     ,
                         argus      : {
                                        state:$('p_chg_state').value,
                                        prod_nos:prodNos,
                                        p_state_date:$('p_state_date').value
                                       }
                        };
            loadSwf.showSwf();
            ajaxR.httpOpen('POST', url, true,encodeURIComponent(JSON.stringify(bData)), $("area02"));
        }
    }
    return true;
}

function disableDateSearch(o) {
    if ( o.checked ) {
        $('s_reg_date').disabled = false;
        $('e_reg_date').disabled = false;
    } else {
        $('s_reg_date').disabled = true;
        $('e_reg_date').disabled = true;
    }
}

function 매물히스토리보기(prodNo) {
    lds.addJs ('mod2','../inc/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118' );
  //lds.addCss('mod1','../inc/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112');
    var ajaxR = new asyncConnector('xmlhttp');
    var url  = '../service/gateway.php';
        url += '?p_hash=' + p_hash;

    ajaxR.openCallBack= function (str) {
        ajaxR.dataArea.innerHTML = ajaxR.responseText();
        disableDateSearch($('s_on_date_search'));
        loadSwf.hideSwf();
        ajaxR.dataArea.style.backgroundColor = '#FFF';
        ajaxR.dataArea.style.display = 'inline';
        ajaxR.dataArea.style.position= 'absolute';
        ajaxR.dataArea.style.top= '250px';
        ajaxR.dataArea.style.left= '400px';
        ajaxR.dataArea.style.border= '1 solid #000';

    }
    var bData = {service    : 'PRODUCT',
                 className  : 'admin.Product',
                 method     : 'getHistoryList'     ,
                 argus      : {
                    s_prod_no:prodNo
                }
                };
    loadSwf.showSwf();
    ajaxR.httpOpen('POST', url, true,encodeURIComponent(JSON.stringify(bData)), $("area02"));
    return false;
}
function 매물히스토리선택삭제() {
    var hObj = document.getElementsByName('chk_history_seq');
    var l = hObj.length;
    var delCnt = 0;
    var delHistorySeqs = Array();
    for (var i=0; i<l; i++) {
        if (hObj[i].checked ) {
            delHistorySeqs.push(hObj[i].value);
            delCnt++
        }
    }

    if ( delCnt == 0 ) {
        alert('선택된 자료가 없습니다.');
    } else {
        if (confirm('선택된 이력을 삭제 하시겠습니까?')) {
            var ajaxR = new asyncConnector('xmlhttp');
            var url  = '../service/gateway.php';
                url += '?p_hash=' + p_hash;

            ajaxR.openCallBack= function (str) {
                loadSwf.hideSwf();
                var rtn = ajaxR.responseText();
                var info = rtn.split('|');
                if ( info[0] == 'SUCCESS' ) {
                    매물히스토리보기($('p_prod_no').value);
                } else if ( info[0] == 'ERROR' ) {
                    alert('처리중 에러가 발생하였습니다.\n[' + info[1] + ']');
                }
                ajaxR.dataArea.innerHTML = ajaxR.responseText();
            }

            var bData = {service    : 'PRODUCT',
                         className  : 'admin.Product',
                         method     : 'deleteHistoryExec'    ,
                         argus      : {
                                        p_prod_no:$('p_prod_no').value,
                                        history_seqs:delHistorySeqs
                                      }
                        };
            loadSwf.showSwf();
            ajaxR.httpOpen('POST', url, false,encodeURIComponent(JSON.stringify(bData)), $("area02"));
        }
    }
    return true;
}

/* ------------------------------- ------------------------------- ------------------------------- -------------------------------*/
function 결제작성(payNo) {
    lds.addJs ('mod_cal','../inc/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118' );
    lds.addJs ('mod_file','../inc/js/fileUpload.js' );
    lds.addJs ('mod_prod','../service/ui/admin/payment/payment_write.js' );
    lds.addJs ('mod_twinkle','../inc/js/twinkle.js' );

  //lds.addCss('mod1','<?=BASE_DIR?>/inc/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112');
    var ajaxR = new asyncConnector('xmlhttp');
    var url  = '../service/gateway.php';
        url += '?p_hash=' + p_hash;

    var mode = !payNo?"I":"U";
    //alert( mode );
    ajaxR.openCallBack= function (str) {
        ajaxR.dataArea.innerHTML = ajaxR.responseText();
        if (mode == 'I') 아이디조회('ilban');
        window.setTimeout(function(){
            아이디조회($('user_id').value);
        },100);
        loadSwf.hideSwf();
    }

    var bData = {service    : 'PRODUCT',
                 className  : 'admin.Payment',
                 method     : 'getWrite'     ,
                 argus      : {
                                mode:mode,
                                p_pay_no:payNo
                              }};

    // loadSwf 용도 : "로딩중..." 표시
    loadSwf.showSwf();
    ajaxR.httpOpen('POST', url, true,encodeURIComponent(JSON.stringify(bData)), $("area01"));

    return false;
}
/* ------------------------------- ------------------------------- ------------------------------- -------------------------------*/