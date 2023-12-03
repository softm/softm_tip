    var WAITINGSEC = 3;

    function fSetActiveRow(r,k) {
        if (_rI) _pRowIndex = _rI.rowIndex;
        _rI = new rowInfo(r,k);
    }

    var sRowIndex = -1;
    function  fOpenPopClassName(rIdx) {
        sRowIndex = rIdx+1;
        openWindow("calko_get_class.php", 640, 400,'winClassName').focus();
    }

    function fCopy() {
        var f = $('wForm');
        var estiNo = f.esti_no.value.replace(/\-/g,'');
        var twinkleInfo = {cssText:'background-color:#BFE2FF;border:1px dotted #CC0000',during:800,callback:function(){Alert.hide({id:'message_box'});$('message_box.ok').onclick();}};
        if (!estiNo) {
            Effect.twinkle(f.esti_no,twinkleInfo);
            Alert.show({id:'message_box',message:'Please input correct quotation number again.',ok:function(){f.esti_no.focus()}});
            setTimeout(function(){Alert.hide({id:'message_box'});f.esti_no.focus();},1000);
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
        var estiNo = f.esti_no.value.replace(/\-/g,'');
        var newEstiNo = f.new_esti_no.value.replace(/\-/g,'');
        var ajaxR = new asyncConnector('xmlhttp');
        var url = _url
                + '?op=copy_exec'
                + '&p_esti_no=' + estiNo
                + '&p_new_esti_no=' + newEstiNo;
        var info = f.destination.value.split('-');
        var country_code    = info[0];
        var destination     = info[1];
        var sold_to_party   = info[2];

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
            ajaxR.httpOpen('POST', url, false,params);
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
                Util.Alert.show({id:'alert_box',message:info[3],ok:function(){alert('Retry Again!');fGetQuotationNo();}});
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
        if (opener) {
            var estiNo = $('wForm').new_esti_no.value.replace(/\-/g,'');
            if (window.opener.fGetWrite) window.opener.fGetWrite({esti_no:estiNo,seq:1});
            window.opener.focus();
            self.close();
        }
    }

    function fInit() {
        var estiNo = fGetQuotationNo();
        var f = $('wForm');
        f.new_esti_no.value = estiNo;
    }

    function fGetQuotationNo() {
        var f = $('wForm');
        var url  = _url;
        var ajaxR = new asyncConnector('xmlhttp');
        var estiNo = f.esti_no.value.replace(/\-/g,'');

        url += '?op=get_max_esti_seq'
            + '&p_esti_no=' + estiNo
            + '&p_country_code=' + f.country_code.value;
        ajaxR.httpOpen('GET', url, false);
        var info = ajaxR.responseText();
        eval(info);
        return _info.esti_no.substr(0,6) + '-' + _info.esti_no.substr(6,5) + '-' + _info.esti_no.substr(11);
    }

    function fTest() {
        alert('테스트 계정은 test로만 선택가능합니다.');
        fChangeCountry('XX');
        fChangeDestination('XX-TEST DESTINATION-274801');
        return false;
    }
