var WAITINGSEC = 3;

function fCopy() {
    var itemCnt = copyItems.count()
    var f = $('wForm');

    var estiNo = $('p_new_esti_no').value.replace(/\-/g,'');
    var twinkleInfo = {cssText:'background-color:#FFD9D9;border:1px dotted #CC0000',during:1000,callback:function(){Alert.hide({id:'message_box'});$('message_box.ok').onclick();}};

    Effect.TWINKLE_INTERVAL = 250;
    if ( itemCnt == 0 ) {
        Effect.twinkle($('target_tbl'),twinkleInfo);
        Alert.show({id:'message_box',message:'Add a quote, please copy. again.',ok:function(){$('p_new_esti_no').focus()}});
        setTimeout(function(){Alert.hide({id:'message_box'});$('p_new_esti_no').focus();},1000);
    } else if ( !f.sales_in_charge.value.trim() ) {
        Effect.twinkle(f.sales_in_charge,twinkleInfo);
        Alert.show({id:'message_box',message:'Please input Sales in Charge',ok:function(){f.sales_in_charge.focus()}});
        setTimeout(function(){Alert.hide({id:'message_box'});f.sales_in_charge.focus();},1000);
    } else if ( !f.name_of_client.value.trim() ) {
        Effect.twinkle(f.name_of_client,twinkleInfo);
        Alert.show({id:'message_box',message:'Please input Name of Client',ok:function(){f.name_of_client.focus()}});
        setTimeout(function(){Alert.hide({id:'message_box'});f.name_of_client.focus();},1000);
    } else if ( !f.project_name.value.trim() ) {
        Effect.twinkle(f.project_name,twinkleInfo);
        Alert.show({id:'message_box',message:'Please input Project Name',ok:function(){f.project_name.focus()}});
        setTimeout(function(){Alert.hide({id:'message_box'});f.project_name.focus();},1000);
    } else if ( !f.destination.value.trim() ) {
        Effect.twinkle(f.destination,twinkleInfo);
        Alert.show({id:'message_box',message:'Please input Destination',ok:function(){f.destination.focus()}});
        setTimeout(function(){Alert.hide({id:'message_box'});f.destination.focus();},1000);
    } else if ( !f.sold_to_party.value.trim() ) {
        Effect.twinkle(f.sold_to_party,twinkleInfo);
        Alert.show({id:'message_box',message:'Please input Sold-to-party',ok:function(){f.sold_to_party.focus()}});
        setTimeout(function(){Alert.hide({id:'message_box'});f.sold_to_party.focus();},1000);
    } else {
        var quotation_date = $('quotation_date').value;
        var expected_delivery_date = $('expected_delivery_date').value;

        var date1 = new Date(parseInt(quotation_date.substr(0,4),10), (parseInt(quotation_date.substr(5,2),10) - 1), parseInt(quotation_date.substr(8,2),10));
        var date2 = new Date(parseInt(expected_delivery_date.substr(0,4),10), (parseInt(expected_delivery_date.substr(5,2),10) - 1), parseInt(expected_delivery_date.substr(8,2),10));
        //alert( dateObj1 );
        //alert( dateObj1 - dateObj2 );
        var btDay = ( date2 - date1 ) / (60 * 60 * 24 * 1000);
        if (btDay < 30 ) {
            Effect.twinkle(f.quotation_date,twinkleInfo);
            Effect.twinkle(f.expected_delivery_date,twinkleInfo);
            Alert.show({id:'message_box',message:'expected_delivery_date >= delivery_date + 30 ',ok:function(){f.sold_to_party.focus()}});
        } else {
            $('alert_box_progress').style.display = "none";
            Util.Alert.show({id:'alert_box',message:'Do you want to progress Copy?',ok:fCopyExec});
        }
  }
}

function fCopyExec() {
    UI.setPreventArea();
    var f = $('wForm');
    var estiNo = $('p_new_esti_no').value.replace(/\-/g,'');
    var ajaxR = new asyncConnector('xmlhttp');
    var url = _url
            + '?op=copy_exec'
            + '&p_mode=' + ($N('copy_option')[0].checked?1:2)
            + '&p_esti_no=' + estiNo
    ;

    var params  = 'quotation_date='          + f.quotation_date.value
                + '&expected_delivery_date=' + f.expected_delivery_date.value
                + '&sales_in_charge='        + f.sales_in_charge.value
                + '&name_of_client='         + f.name_of_client.value
                + '&project_name='           + f.project_name.value
                + '&country_code='           + f.country_code.value
                + '&destination='            + f.destination.value
                + '&sold_to_party='          + f.sold_to_party.value
    ;
    var exec = true;
    if (exec) {
        var saveParam = new Array();

        var prototype = copyItems.constructor.prototype;
        for ( var eId in copyItems) {
            if (eId in prototype) continue;
            if (copyItems instanceof Array && isNaN(eId)) continue;
            saveParam.push(
                         '&p_copy_esti_no[]=' + copyItems[eId].quotation_number.replace(/\-/g,'') + 
                         '&p_copy_seq[]=' + copyItems[eId].seq.replace(/\n/g,'')
            );
        }
        params += saveParam.join('\n');
        ajaxR.httpOpen('POST', url, false,params, null);

        var info = ajaxR.responseText().split('|');
        var s = info[0];
        var m = info[1];
        var k = info[2];
        var msg = info[3];
        if (s == 'SUCCESS') { // success
            Util.Alert.show({id:'wait_box',message:'',keydowncancel:false});
            fWatingEdit();
        } else if (s == 'ERROR') {
            UI.clearPreventArea();
            Util.Alert.show({id:'alert_box',message:info[3],ok:function(){alert('Retry Again!');}});
        }
    }
}

function fWatingEdit() {
    if (WAITINGSEC == 0 ) {
        Util.Alert.hide({id:'wait_box'});
        WAITINGSEC = 1;
        fGoEdit();
    } else {
        $('wait_box.message').innerHTML = '<font color=#FF0000>Copy Completed!.</font><BR><BR>Transferring to main screen(<font color=#0080FF>' + WAITINGSEC + '</font>Sec)<BR><button id=wait_box_ok style="margin-top:3px;margin-bottom:3px" onclick="fGoEdit()">Go</button>';
        setTimeout(fWatingEdit,1000);
        WAITINGSEC--;
    }
}

function fGoEdit() {
    var estiNo = ($N('copy_option')[0].checked?$('p_new_esti_no').value.replace(/\-/g,''):$('p_new_esti_no').value.replace(/\-/g,''));
    document.location.href = 'calko_write.php?p_esti_no=' + estiNo;
}

function fInit() {
/*
    var estiNo = fGetQuotationNo();
    var f = $('wForm');
    f.new_esti_no.value = estiNo;
    //alert(estiNo);
*/
}

function fTest() {
    alert('테스트 계정은 test로만 선택가능합니다.');
    fChangeCountry('XX');
    fChangeDestination('XX-TEST DESTINATION-274801');
    return false;
}

function fDelete() {
    var itemCnt = copyItems.count();
    var rO = $('source_tbl').tBodies[0].rows;
    var l = rO.length;
    var deleteExec = false;

    for (var i=0; i<l;i++ ) {
        if ( rO[i].cells[0].firstChild.checked ) {
            deleteExec = true;
            break;
        }
    }

    var f = $('wForm');

    var estiNo = $('p_new_esti_no').value.replace(/\-/g,'');
    var twinkleInfo = {cssText:'background-color:#FFD9D9;border:1px dotted #CC0000',during:1000,callback:function(){Alert.hide({id:'message_box'});$('message_box.ok').onclick();}};

    Effect.TWINKLE_INTERVAL = 250;
    if ( !deleteExec ) {
        Effect.twinkle($('source_tbl'),twinkleInfo);
        Alert.show({id:'message_box',message:'Please choose to delete data.',ok:function(){$('p_new_esti_no').focus()}});
    } else {
        Util.Alert.show({id:'confirm_box',message:'Do you want to Delete?',ok:fDeleteExec});
    }

}

function fDeleteExec() {
    var rO = $('source_tbl').tBodies[0].rows;
    var l = rO.length;
    var params = new Array();
    for (var i=0; i<l;i++ ) {
        if ( rO[i].cells[0].firstChild.checked ) {
            params.push(
                         '&p_del_esti_no[]=' + rO[i].cells[1].innerText.replace(/\-/g,'') + 
                         '&p_del_seq[]=' + rO[i].cells[2].innerText
            );
        }
    }

    var ajaxR = new asyncConnector('xmlhttp');
    var url = _url
            + '?op=del_exec'
    ;
    var exec = true;
    if (exec) {
        ajaxR.httpOpen('POST', url, false,params.join('\n'), null);
        var info = ajaxR.responseText().split('|');
        var s = info[0];
        var m = info[1];
        var k = info[2];
        var msg = info[3];
        if (s == 'SUCCESS') { // success
            copyItems = {};  
            targetItems = {};
            Util.Alert.show({id:'message_box',message:'The selected quotation have been deleted.',keydowncancel:false});
            fSearch();
            fRedrawSourceList();
            fRedrawTargetList();
        } else if (s == 'ERROR') {
            Util.Alert.show({id:'message_box',message:info[3],ok:function(){alert('Retry Again!');fChangeOption();}});
        }
    }
}

var copyItems = {};
var targetItems = {};

function copyItem (quotation_number,seq,name_of_client,project_name,country_en_name,destination,specification,quotation_date,state,sales_in_charge,country_code,sold_to_party,expected_delivery_date,gubun) {
    this.quotation_number       = quotation_number      ;
    this.seq                    = seq                   ;
    this.name_of_client         = name_of_client        ;
    this.project_name           = project_name          ;
    this.country_en_name        = country_en_name       ;
    this.destination            = destination           ;
    this.specification          = specification         ;
    this.quotation_date         = quotation_date        ;
    this.state                  = state                 ;
    this.sales_in_charge        = sales_in_charge       ;
    this.country_code           = country_code          ;
    this.sold_to_party          = sold_to_party         ;
    this.expected_delivery_date = expected_delivery_date;
    this.gubun                  = gubun                 ;
}

function fRedrawSourceList() {
    var tableRef = $('source_tbl');
    var l = tableRef.tBodies[0].rows.length;
    var rO = tableRef.tBodies[0].rows;
    for (var i=0; i<l;i++ ) {
        rO[i].cells[0].firstChild.checked = false;
        if ( targetItems[rO[i].cells[1].innerText+'-'+rO[i].cells[2].innerText] ) {
            rO[i].style.display = 'none';

            rO[i].cells[0].firstChild.disabled = true;
            rO[i].style.backgroundColor = COLORS.DISABLE_BACKGROUND;
            rO[i].style.color = COLORS.DISABLE;
        } else {
            rO[i].style.display = '';

            rO[i].cells[0].firstChild.disabled = false;
            rO[i].style.backgroundColor = '';
            rO[i].style.color = '';
            if ( copyItems[rO[i].cells[1].innerText+'-'+rO[i].cells[2].innerText] ) {
                rO[i].cells[0].firstChild.checked = true;
                fChangeItem(rO[i]);
            }
        }
    }
    //tableUtil.reGenTable(tableRef.tBodies[0],[1,3]);
}

function fSearch(s) {
    var ajaxS = new asyncConnector('xmlhttp');
    var url = _url
            + '?op=get_source_list'
            + '&s_mode=search'
            + '&s_s_country_code='    + $('s_s_country_code'    ).value.trim()
            + '&s_s_destination='     + $('s_s_destination'     ).value.trim()
            + '&s_s_sales_in_charge=' + $('s_s_sales_in_charge' ).value.trim()
            + '&s_s_project_name='    + $('s_s_project_name'    ).value.trim()
            + '&s_s_name_of_client='  + $('s_s_name_of_client'  ).value.trim()
            + '&s_s_frm_reg_date='    + $('s_s_frm_reg_date'    ).value.trim()
            + '&s_s_to_reg_date='     + $('s_s_to_reg_date'     ).value.trim()
            + '&s=' + (s?s:1);

    var params  = null;
    ajaxS.httpOpen('GET', url, true,params, null,
        function() {
            $('area_list2').innerHTML = ajaxS.responseText();
            fRedrawSourceList();
            loading.hide();
        }
    );

    loading.setTarget($('area_list2'));
    loading.show();
}

function fChangeItem(r) {
    //tableUtil.row.activate(co[i].parentNode.parentNode);
    //try
    //{
        c = r.cells[0].firstChild.checked;
        var key = r.cells[1].innerText+'-'+r.cells[2].innerText;

        if (c) {
            delete copyItems[key];
            copyItems[key] = new copyItem (r.cells[ 1].innerText,
                                           r.cells[ 2].innerText,
                                           r.cells[ 3].innerText,
                                           r.cells[ 4].innerText,
                                           r.cells[ 5].innerText,
                                           r.cells[ 6].innerText,
                                           r.cells[ 7].innerText,
                                           r.cells[ 8].innerText,
                                           r.cells[ 9].innerText,
                                           r.cells[10].innerText,
                                           r.cells[11].innerText,
                                           r.cells[12].innerText,
                                           r.cells[13].innerText,
                                           'source'
            );
            r.style.backgroundColor = '#CDF4CC';
            $("source_check_all").checked = true;
        } else {
            delete copyItems[key];
            r.style.backgroundColor = '';

            var rO = $('target_tbl').tBodies[0].rows;
            var l = rO.length;

            var itemCnt = copyItems.count();
            for (var i=0; i<l;i++ ) {
                if ( (rO[i].cells[1].innerText + '-' + rO[i].cells[2].innerText) == key ) {
                    $('target_tbl').tBodies[0].deleteRow(rO[i].rowIndex);
                    break;
                }
            }
            if (itemCnt == 0 ) {
                $("source_check_all").checked = false;
            }
        }
    //}
    //catch (e) {
    //    alert(r.tagName);
    //}

}
function fAddItem(r) {
    fChangeItem(r);
    fRedrawTargetList();
    if (fAddItem.caller.toString().indexOf('function onclick') > -1 ) {
        $('target_check_all').checked = true;
        var p = $N('copy_option');
        if (p[0].checked) {
            fChangeOption();
        }
    }
}

function fDeSelectItem(r) {
    var key = r.cells[1].innerText+'-'+r.cells[2].innerText;
    delete copyItems[r.cells[1].innerText+'-'+r.cells[2].innerText];
    $('target_tbl').tBodies[0].deleteRow(r.rowIndex);
    var rO = $('source_tbl').tBodies[0].rows;
    var l = rO.length;
    for (var i=0; i<l;i++ ) {
        if ( (rO[i].cells[1].innerText + '-' + rO[i].cells[2].innerText) == key ) {
            rO[i].cells[0].firstChild.checked = false;
            fChangeItem(rO[i]);
            break;
        }
    }
    fChangeOption();
}

function fSourceCheckAll(o) {
    loading.setTarget($('area_list4'));
    loading.show();
    window.setTimeout(function() {
        var c = o.checked;
        var co = document.getElementsByName("source_check[]");
        var tableRef = $('source_tbl');
        var l = tableRef.tBodies[0].rows.length;
        for (var i=1; i<l+1;i++ ) {
            if (!co[i].disabled) {
                co[i].checked = c;
                var r = co[i].parentNode.parentNode;
                fChangeItem(r);
            }
        }
        fRedrawTargetList();
        $('target_check_all').checked = true;
        loading.hide();
        fChangeOption();

    },100);

}

function fTargetCheckAll(o) {
    var tableRef = $('target_tbl');
    var nm = o.id.split('_')[0];
    var c = o.checked;
    var co = document.getElementsByName("target_check[]");
    var tableRef = $('target_tbl');
    var l = tableRef.tBodies[0].rows.length;

    for (var i=1; i<l+1;i++ ) {
        co[i].checked = c;
        var r = co[i].parentNode.parentNode;
        delete copyItems[r.cells[1].innerText+'-'+r.cells[2].innerText];
    }
    $('source_check_all').checked = false;
    fRedrawSourceList();
    fRedrawTargetList();
}

var stdEstiNo = null;
function fRedrawTargetList() {
    var tableRef = $('target_tbl');
    while (tableRef.tBodies[0].rows.length> 0) {
        tableRef.tBodies[0].deleteRow(0);
    }
    var items = json_merge(targetItems,copyItems);
    var prototype = items.constructor.prototype;
    for ( var tId in items ) {
        if (tId in prototype) continue;
        if (items instanceof Array && isNaN(tId)) continue;
        // Insert a row in the table at row index 0
        var newRow   = tableRef.tBodies[0].insertRow(-1);
        newRow.tabIndex = 1;
        newRow.style.cursor='pointer';
        var rIdx = newRow.rowIndex;

        newRow.attachEvent('onmousedown',function(e) {
            var o = window.event?e.srcElement:e.target;
            tableUtil.row.activate(e.target?this:o.parentElement);
        });
        newCell = fAddCell(newRow,'<input type=checkbox name="target_check[]" onclick="fDeSelectItem(parentNode.parentNode);" checked>'); newCell.align = 'center';
        if (items[tId].gubun == 'target') {
            newRow.style.backgroundColor = COLORS.DISABLE_BACKGROUND;
            newRow.style.color           = COLORS.DISABLE           ;
            newCell.firstChild.disabled = true;
        }

        newCell = fAddCell(newRow,"<a href=# onclick='fViewQuotation(\"" + items[tId].quotation_number + "\",\"" + items[tId].seq + "\");'>"+items[tId].quotation_number+"</a>"); newCell.style.textAlign = 'center';
        newCell = fAddCell(newRow,"<a href=# onclick='fViewQuotation(\"" + items[tId].quotation_number + "\",\"" + items[tId].seq + "\");'>"+items[tId].seq             +"</a>"); newCell.style.textAlign = 'center';
        newCell = fAddCell(newRow,items[tId].name_of_client  );
        newCell = fAddCell(newRow,items[tId].project_name    );
        newCell = fAddCell(newRow,items[tId].country_en_name );
        newCell = fAddCell(newRow,items[tId].destination     );
        newCell = fAddCell(newRow,items[tId].specification   );
        newCell = fAddCell(newRow,items[tId].quotation_date  ); newCell.style.textAlign = 'center';
        newCell = fAddCell(newRow,items[tId].state           ); newCell.style.textAlign = 'center';
        newCell = fAddCell(newRow,'<span style="display:none">' + items[tId].sales_in_charge +'</span>');
        newCell = fAddCell(newRow,'<span style="display:none">' + items[tId].country_code +'</span>');
        newCell = fAddCell(newRow,'<span style="display:none">' + items[tId].sold_to_party +'</span>');
        newCell = fAddCell(newRow,'<span style="display:none">' + items[tId].expected_delivery_date +'</span>');
    }

    var tableRef = $('target_tbl');
    if (tableRef.tBodies[0].rows.length > 0 ) {
        stdEstiNo = tableRef.tBodies[0].rows[0].cells[1].innerText.replace(/\-/g,'');
        $('target_tbl_foot').style.display = 'none';
        var rO = tableRef.tBodies[0].rows;
        var l  = rO.length;
        rO[l-1].focus();
        var twinkleInfo = {cssText:'background-color:#FFD9D9;border:1px dotted #CC0000',during:1000};
        Effect.twinkle(rO[l-1],twinkleInfo);
    } else {
        $('target_tbl_foot').style.display = '';
    }
}

function fChangeOption() {
    var tableRef = $('target_tbl');
    var p = $N('copy_option');

    if (p[0].checked) {
        $('copy_label_1').innerText = 'New';
        targetItems = {};
        if ( preOption == '2' ) fRedrawSourceList();
        preOption = '1';
        fRedrawTargetList();
        if (tableRef.tBodies[0].rows.length > 0 ) {
            $('sales_in_charge').value = tableRef.tBodies[0].rows[0].cells[10].innerText;
            $('name_of_client' ).value = tableRef.tBodies[0].rows[0].cells[3].innerText;
            $('project_name'   ).value = tableRef.tBodies[0].rows[0].cells[4].innerText;
            $('country_code'   ).value = tableRef.tBodies[0].rows[0].cells[11].innerText;
            $('destination'    ).value = tableRef.tBodies[0].rows[0].cells[6].innerText;
            $('sold_to_party'  ).value = tableRef.tBodies[0].rows[0].cells[12].innerText;
            fChangeCountry( $('country_code'), $('destination') , $('sold_to_party') );
            $('p_new_esti_no').value = stdEstiNo.substr(0,6) + '-' + stdEstiNo.substr(6,5) + '-' + stdEstiNo.substr(11);
        } else {
            $('sales_in_charge').value = '';
            $('name_of_client' ).value = '';
            $('project_name'   ).value = '';
            $('country_code'   ).value = '';
            $('destination'    ).value = '';
            $('sold_to_party'  ).value = '';
            fChangeCountry( $('country_code'), $('destination') , $('sold_to_party') );

            $('p_new_esti_no').value = '';
        }
        var estiNo = fGetQuotationNo();
        $('p_new_esti_no').value = estiNo;
        $('country_code'            ).disabled = false;
        $('destination'             ).disabled = false;

    } else if (p[1].checked) {
        $('copy_label_1').innerText = 'Copy To Quotation';
        $('p_new_esti_no'   ).value = '';

        $('sales_in_charge').value = '';
        $('name_of_client' ).value = '';
        $('project_name'   ).value = '';
        $('country_code'   ).value = '';
        $('destination'    ).value = '';
        $('sold_to_party'  ).value = '';
        fChangeCountry( $('country_code'), $('destination') , $('sold_to_party') );
        if (fChangeOption.caller.toString().indexOf('function onclick') > -1 || fChangeOption.caller.toString().indexOf('anonymous') > -1 ) {
            fTargetSearchOpen();
        }
    }

  //alert(estiNo);
}

function fTargetSearchOpen() {
    var ajaxR = new asyncConnector('xmlhttp');
    var url  = _url;
    url += '?op=get_target_ui'
        //+ '&p_esti_no=' + stdEstiNo
        //+ '&p_option=' + (p[0].checked?'1':'2')
        //+ '&p_country_code=' + f.country_code.value;
    ajaxR.httpOpen('GET', url, false,'', $("area_list4"));
    ajaxR.dataArea.innerHTML = ajaxR.responseText();
    $("area_list4").style.display="inline";
    $("area_list4").style.zIndex=2;
    UI.setPreventArea();

    UI.setCenter($({element:ajaxR.dataArea,baseElement:document.body}));
    fSetCountryToCombo($('s_p_country_code'));
    $('s_p_country_code').value = $('s_p_country_code').getAttribute('set') + '';
    fChangeCountry( $('s_p_country_code'), $('s_p_destination') , $('s_p_sold_to_party') );
    fTargetSearch();
}

var preOption = null;
function fCloseSearchTarget() {
    if ( preOption == '1' ) $N('copy_option')[0].checked = true;
    fChangeOption();
    $("area_list4").style.display="none";
    UI.clearPreventArea();
}

function fTargetSearch(s) {
    var ajaxS = new asyncConnector('xmlhttp');
    var url = _url
            + '?op=get_target_list'
            + '&s_mode=pop_search'
            + '&s_p_country_code='    + $('s_p_country_code'    ).value.trim()
            + '&s_p_destination='     + $('s_p_destination'     ).value.trim()
            + '&s_p_sales_in_charge=' + $('s_p_sales_in_charge' ).value.trim()
            + '&s_p_project_name='    + $('s_p_project_name'    ).value.trim()
            + '&s_p_name_of_client='  + $('s_p_name_of_client'  ).value.trim()
            + '&s_p_frm_reg_date='    + $('s_p_frm_reg_date'    ).value.trim()
            + '&s_p_to_reg_date='     + $('s_p_to_reg_date'     ).value.trim()
            + '&s=' + (s?s:1);
    var params  = null;
    ajaxS.httpOpen('GET', url, true,params, null,
        function() {
            $('area_list4_1').innerHTML = ajaxS.responseText();
            loading.hide();
            $('copy_button4').disabled = false;
        }
    );
    loading.setTarget($('area_list4_1'));
    //loading.setPos('88px', '190px');
    loading.show();
}

function fTargetSelect(rIdx) {
    var tableRef = $('target_tbl_select');
    var l = tableRef.tBodies[0].rows.length;

    var rO = tableRef.tBodies[0].rows;
    var estiNo = rO[rIdx].cells[0].firstChild.value; // Quotation Number
    $('sold_to_party'  ).value = rO[rIdx].cells[0].childNodes[1].value; // sold_to_party
    $('sales_in_charge').value = rO[rIdx].cells[0].childNodes[2].value; // sales_in_charge

    $('name_of_client'          ).value = rO[rIdx].cells[1].firstChild.value; // Name Of Client
    $('project_name'            ).value = rO[rIdx].cells[2].firstChild.value; // Project Name
    $('country_code'            ).value = rO[rIdx].cells[3].firstChild.value; // Country
    $('destination'             ).value = rO[rIdx].cells[4].firstChild.value; // Destination
    $('p_new_esti_no').value = estiNo;
    $('country_code'            ).disabled = true;
    $('destination'             ).disabled = true;

    //alert( estiNo );
    $("area_list4").style.display="none";
    UI.clearPreventArea();
    targetItems = {}; // 초기화

    var ajaxR = new asyncConnector('xmlhttp');
    var url = _url
            + '?op=get_target_item'
            + '&p_esti_no=' + estiNo.replace(/\-/g,'')

    var params  = null;
    ajaxR.httpOpen('GET', url, false,params, null);
    eval(ajaxR.responseText());
    var tableRef = $('source_tbl');
    var l = tableRef.tBodies[0].rows.length;
    var rO = tableRef.tBodies[0].rows;
    for (var i=0; i<l;i++ ) {
        rO[i].cells[0].firstChild.checked = false;
        if ( targetItems[rO[i].cells[1].innerText+'-'+rO[i].cells[2].innerText] ) {
            rO[i].cells[0].firstChild.focus();
        }
    }

    var tableRef = $('target_tbl');
    var l = tableRef.tBodies[0].rows.length;
    var rO = tableRef.tBodies[0].rows;
    for (var i=l-1; i>=0;i-- ) {
       if ( targetItems[rO[i].cells[1].innerText+'-'+rO[i].cells[2].innerText] ) {
            delete copyItems[rO[i].cells[1].innerText+'-'+rO[i].cells[2].innerText];
            tableRef.tBodies[0].deleteRow(i);
        }
    }

    fRedrawSourceList();
    fRedrawTargetList();

    preOption = '2';

    loading.setTarget($('area_list4_1'));
/**/
}

function fGetQuotationNo() {
    var f = $('wForm');
    var url  = _url;
    var ajaxR = new asyncConnector('xmlhttp');
    var l = $('target_tbl').tBodies[0].rows.length;
    var p = $N('copy_option');
    if (l>0) {
        url += '?op=get_max_esti_seq'
            + '&p_esti_no=' + stdEstiNo
            + '&p_option=' + (p[0].checked?'1':'2')
            + '&p_country_code=' + f.country_code.value;
        ajaxR.httpOpen('GET', url, false);
        var info = ajaxR.responseText();
        eval(info);
        return _info.esti_no.substr(0,6) + '-' + _info.esti_no.substr(6,5) + '-' + _info.esti_no.substr(11);
    } else {
        stdEstiNo = '';
        return '';
    }
}

function fViewQuotation(esti_no, seq) {
    var url = "/calko/calko_write.php?p_esti_no=" + esti_no.replace(/\-/g,'') + "&p_seq=" + seq + "&p_mode=preview";
    var w = openWindow(url, 970, 700,'_preview_quotation',{scrollbars:'yes',resizable:'no'});
    w.focus();
}