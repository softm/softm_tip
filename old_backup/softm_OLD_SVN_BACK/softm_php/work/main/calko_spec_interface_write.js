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

    function fGetCRC() {
        var f = $N('wForm')[0];
        if ( f['quotation_no[]'  ].length > 1 ) {
            var estiNo = f['quotation_no[]'  ][1].value.replace(/\-/g,'');
            var twinkleInfo = {cssText:'background-color:#BFE2FF;border:1px dotted #CC0000',during:1300,callback:function(){Alert.hide({id:'message_box'});$('message_box.ok').onclick();}};
            if (!estiNo || estiNo.length != 13 ) {
                Effect.twinkle(f['quotation_no[]'][1],twinkleInfo);
                Alert.show({id:'message_box',message:'Please input correct quotation number again.',ok:function(){f['quotation_no[]'][1].focus()}});
            } else if ( !f.sales_in_charge.value.trim() ) {
                Effect.twinkle(f.sales_in_charge,twinkleInfo);
                Alert.show({id:'message_box',message:'Please input correct Sales in Charge',ok:function(){f.sales_in_charge.focus()}});
            } else if ( !f.name_of_client.value.trim() ) {
                Effect.twinkle(f.name_of_client,twinkleInfo);
                Alert.show({id:'message_box',message:'Please input Name of Client',ok:function(){f.name_of_client.focus()}});
            } else if ( !f.project_name.value.trim() ) {
                Effect.twinkle(f.project_name,twinkleInfo);
                Alert.show({id:'message_box',message:'Please input Project Name',ok:function(){f.project_name.focus()}});
            } else if ( !f.destination.value.trim() ) {
                Effect.twinkle(f.destination,twinkleInfo);
                Alert.show({id:'message_box',message:'Please input Destination',ok:function(){f.destination.focus()}});
            } else if ( !f.sold_to_party.value.trim() ) {
                Effect.twinkle(f.sold_to_party,twinkleInfo);
                Alert.show({id:'message_box',message:'Please input Sold-to-party',ok:function(){f.sold_to_party.focus()}});
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
                    var l = f['quotation_no[]'].length;
                    if ( l > 0 && l ) {
                        $('alert_box_progress').style.display = "none";
                        Util.Alert.show({id:'alert_box',message:'Do you want to progress Spec Interface?',ok:fGetCRCExec});
                    } else {
                        alert('Spec Interface Data is non-exist!');
                    }
                }
            }
        }
    }

    var CRC_GUBUN_CODE  = 'DSA0000';
    var CRC_STANDARD = '1'; // 표준:1, 비표준:2
    var CRC_ITEM_CATEGORY = 'AGC'; // Item Category

    function fGetCRCExec() {
        UI.setPreventArea();
        var f = $N('wForm')[0];
        var estiNo = f['quotation_no[]'  ][1].value.replace(/\-/g,'');
        var ajaxR = new asyncConnector('xmlhttp');
        var url = _url
                + '?op=crc_xml_save_check'
                + '&p_esti_no=' + estiNo;
        var params  = 'quotation_date='          + f.quotation_date.value
                    + '&expected_delivery_date=' + f.expected_delivery_date.value
                    + '&sales_in_charge='        + f.sales_in_charge.value
                    + '&name_of_client='         + f.name_of_client.value
                    + '&project_name='           + f.project_name.value
                    + '&country_code='           + f.country_code.value
                    + '&destination='            + f.destination.value
                    + '&sold_to_party='          + f.sold_to_party.value
        ;

        var l = f['quotation_no[]'].length;
        var exec = true;
        for (var i=1; i<l; i++) {
            if (isNaN(f['qty[]'][i].value.toNumber()) ) {
                Effect.twinkle(f['qty[]'][i]);
                Alert.show({id:'message_box',message:'Please check quantity.',ok:function(){f['qty[]'][i].focus()}});
                exec = false;
                break;
            }

            params += "&item_no[]="     + f['item_no[]'     ][i].value
                   +  "&qty[]="         + f['qty[]'         ][i].value
                   +  "&code[]="        + CRC_GUBUN_CODE
                   +  "&class_name[]="  + f['class_name[]'  ][i].value
                   +  "&standard[]="    + f['standard[]'    ][i].value
                   +  "&category[]="    + f['category[]'    ][i].value
        }

        if (exec) {
            ajaxR.httpOpen('POST', url, false,params);
            var info = ajaxR.responseText().split('|');
            var s = info[0];
            var m = info[1];
            var k = info[2];
            var msg = info[3];
            if (s == 'SUCCESS') { // success
                fRequestCRC();
            } else if (s == 'ERROR') {
                UI.clearPreventArea();
                Util.Alert.show({id:'alert_box',message:info[3],ok:null});
            }
        }
    }

    function fRequestCRC() {
        var f = $N('wForm')[0];
        var estiNo = f['quotation_no[]'  ][1].value.replace(/\-/g,'');
        var reqXml = '<ns0:MT_CALKO_CLSC_SRCH_OBJ xmlns:ns0="http://lm-erp.tkeasia.com/SD/CALKO_CLSC_SRCH_OBJ">\n';
        var sendL = f['quotation_no[]'].length;
        for (var i=1; i<sendL; i++) {
            reqXml +="   <ZKSSD0001>\n"
                   + "       <BSTKD>" + estiNo                          + "</BSTKD>\n"
                   + "       <BSTZD>" + f['item_no[]'       ][i].value  + "</BSTZD>\n"
                   + "       <ATNAM>" + CRC_GUBUN_CODE                  + "</ATNAM>\n"
                   + "       <ATWRT>" + f['class_name[]'    ][i].value  + "</ATWRT>\n"
                   + "   </ZKSSD0001>\n";
        }
        reqXml += "</ns0:MT_CALKO_CLSC_SRCH_OBJ>\n";

        $('area_list' ).style.display = 'inline' ;

        var ajaxR = new asyncConnector('xmlhttp');
        ajaxR.openCallBack= function (str) {
            var xmlDoc=ajaxR.responseXML();
            var pL =xmlDoc.getElementsByTagName("ZKSSD0002N");
            var recvL = pL.length;
            var xmlStr = '';
            try { xmlStr = ajaxR.xmlHttp.responseXML.xml ? ajaxR.xmlHttp.responseXML.xml : (new XMLSerializer()).serializeToString(ajaxR.xmlHttp.responseXML); } catch (e) { }

            if ( recvL > 0 ) {
                $('xml_data').value = 'xmlStr : ' + xmlStr;
                fSaveCRC(xmlStr); // CRC 저장
                /*
                for (var i=0; i<recvL; i++ ) {
                    var pItem =pL.item(i);
                    xmlStr +=     (pItem.getElementsByTagName("BSTKD").length > 0 && pItem.getElementsByTagName("BSTKD").item(0).firstChild ? pItem.getElementsByTagName("BSTKD").item(0).firstChild.nodeValue:'' )
                           + '/' +(pItem.getElementsByTagName("BSTZD").length > 0 && pItem.getElementsByTagName("BSTZD").item(0).firstChild ? pItem.getElementsByTagName("BSTZD").item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("KIND" ).length > 0 && pItem.getElementsByTagName("KIND" ).item(0).firstChild ? pItem.getElementsByTagName("KIND" ).item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("MATNR").length > 0 && pItem.getElementsByTagName("MATNR").item(0).firstChild ? pItem.getElementsByTagName("MATNR").item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("SEQNO").length > 0 && pItem.getElementsByTagName("SEQNO").item(0).firstChild ? pItem.getElementsByTagName("SEQNO").item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("ATCNT").length > 0 && pItem.getElementsByTagName("ATCNT").item(0).firstChild ? pItem.getElementsByTagName("ATCNT").item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("ATKLA").length > 0 && pItem.getElementsByTagName("ATKLA").item(0).firstChild ? pItem.getElementsByTagName("ATKLA").item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("ATNAM").length > 0 && pItem.getElementsByTagName("ATNAM").item(0).firstChild ? pItem.getElementsByTagName("ATNAM").item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("ATBEZ").length > 0 && pItem.getElementsByTagName("ATBEZ").item(0).firstChild ? decodeURIComponent(pItem.getElementsByTagName("ATBEZ").item(0).firstChild.nodeValue): '')
                           + '/' +(pItem.getElementsByTagName("ATWRT").length > 0 && pItem.getElementsByTagName("ATWRT").item(0).firstChild ? pItem.getElementsByTagName("ATWRT").item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("ATWTB").length > 0 && pItem.getElementsByTagName("ATWTB").item(0).firstChild ? decodeURIComponent(pItem.getElementsByTagName("ATWTB").item(0).firstChild.nodeValue): '')
                           + '/' +(pItem.getElementsByTagName("ATSTD").length > 0 && pItem.getElementsByTagName("ATSTD").item(0).firstChild ? pItem.getElementsByTagName("ATSTD").item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("SNIND").length > 0 && pItem.getElementsByTagName("SNIND").item(0).firstChild ? pItem.getElementsByTagName("SNIND").item(0).firstChild.nodeValue: '') + '\n';
                    //alert ( pItem.getElementsByTagName("BSTKD").item(0).firstChild.nodeValue );
                }
                */
            } else {
                Util.Alert.hide({id:'wait_box'});
                alert('The characteristic code is not receivable from the XI server.\n\nPlease, retry after check name of model.');
                // 구현은했지만 이 루틴으로 넘어올 가능성이 없어보임..
                var url = _url
                + '?op=crc_fail_del_exec'
                + '&p_esti_no=' + estiNo
                ;
                var ajaxF = new asyncConnector('xmlhttp');

                ajaxF.httpOpen('POST', url, false);
                var info = ajaxF.responseText().split('|');
                var s = info[0];
                var m = info[1];
                var k = info[2];
                var msg = info[3];
                if (s == 'SUCCESS') { // success
                    //alert( '삭제 됨.' );
                } else if (s == 'ERROR') {
                    //alert( '삭제 중 에러.' );
                    //var newQNo=fGetQuotationNo(f.country_code.value);
                    //f['quotation_no[]'][1].value = newQNo;
                    //fSyncQuotationNo();
                }
                /* */
            }
        }

      //var url = 'calko_crc_request.php'; // old
        var url = _url
                + '?op=crc_request'
                + '&p_esti_no=' + estiNo;
        ajaxR.contentType = "application/xml; charset=UTF-8";
        ajaxR.httpOpen('POST', url, true,encodeURIComponent(reqXml), $("area_list"));

        $('wait_box_progress').style.display = "";
        Util.Alert.show({id:'wait_box',message:'Spec Interface <font color=#FF0000>Receiving..</font><BR><BR><font color=#FF0000>Please do not terminate browser.</font>',keydowncancel:false});
        return false;
    }

    function fSaveCRC(xmlStr) {
        var f = $N('wForm')[0];
        var ajaxS = new asyncConnector('xmlhttp');
        var url = _url
                + '?op=crc_xml_save_exec';
        var params  ='x=' + encodeURIComponent(xmlStr);
        ajaxS.httpOpen('POST', url, true,params, null,
            function() {
                $('area_write').style.display = 'inline'   ;
                $('wait_box_progress').style.display = "none";
                var info = ajaxS.responseText().split('|');
                var s = info[0];
                var m = info[1];
                var k = info[2];
                var msg = info[3];
                if (s == 'SUCCESS') { // success
                    if ( m == 'I' ) fWatingEdit();
                } else if (s == 'ERROR') {
                    Util.Alert.hide({id:'wait_box'});
                    alert(info[3]); // error
                }
            }
        );
        $('wait_box.message').innerHTML = "Spec Interface <font color=#FF0000>Saving..</font><BR><BR><font color=#FF0000>Please do not terminate browser.</font>'";
        $('wait_box').style.backgroudColor = '#FF0000';
    }

    function fWatingEdit() {
        if (WAITINGSEC == 0 ) {
            Util.Alert.hide({id:'wait_box'});
            WAITINGSEC = 1;
            fGoEdit();
        } else {
            $('wait_box.message').innerHTML = '<font color=#FF0000>Spec Interface has been successfully completed.</font><BR><BR>Transferring to main screen(<font color=#0080FF>' + WAITINGSEC + '</font>Sec)<BR><button id=wait_box_ok style="margin-top:3px;margin-bottom:3px" onclick="fGoEdit()">Go</button>';
            setTimeout(fWatingEdit,1000);
            WAITINGSEC--;
        }
    }

    function fGoEdit() {
        var estiNo = $N('wForm')[0]['quotation_no[]'  ][1].value.replace(/\-/g,'');
/*
        if (opener) { // popup으로 처리할 경우
            if (window.opener.fGetWrite) window.opener.fGetWrite({esti_no:estiNo,seq:1});
            window.opener.focus();
            self.close();
        } else { // window로 처리할 경우
*/
            document.location.href = 'calko_write.php?p_esti_no=' + estiNo;
//      }
    }

    function fSetClassName(v) {
        var f = $N('wForm');
        var f = document.wForm;
        f['class_name[]'][sRowIndex].value = v;
    }

    function addCell(newRow,tagStr) {
        var newCell  = newRow.insertCell(-1);
            newCell.innerHTML = tagStr;
            newCell.onkeydown = function(event) {
                tableUtil.fupAdownKey(this,event);
            };
            return newCell;
    }

    function fChangeCountryCB() {
        var f = $N('wForm')[0];
        v = $('country_code').value;

        if (f['quotation_no[]'].length > 1 ) {
            var newQNo=fGetQuotationNo(v);
            f['quotation_no[]'][1].value = newQNo;
            fSyncQuotationNo();
        }
    }

    function fChangeDestination1() {
        var f = $N('wForm')[0];
        if (f['quotation_no[]'].length > 1 ) {

            var cCode = $('country_code').value;
            var dG = destGory[cCode];
            var sIdx = $('destination').selectedIndex;
            $('sold_to_party').value = dG[sIdx].sold_to_party;

            var newQNo=fGetQuotationNo(cCode);
            f['quotation_no[]'][1].value = newQNo;
            fSyncQuotationNo();
        }
        return newQNo;
    }

    function fGetQuotationNo(countryCode) {
        var url  = _url;
        var ajaxR = new asyncConnector('xmlhttp');
        url += '?op=get_max_esti_seq'
            + '&p_country_code=' + countryCode;
        ajaxR.httpOpen('GET', url, false);
        var info = ajaxR.responseText();
        eval(info);
        return countryCode + accounting_year + '-' + _info.max_esti_seq + '-01';
    }

    function fAddRow() {
        var f = $N('wForm')[0];
        var l = f['quotation_no[]'].length;
        var newQNo= ''; // fSyncQuotationNo시 반영됨

        if ( !l || l == 1 ) newQNo=fGetQuotationNo(f.country_code.value);

        var tableRef = document.getElementById('tbl2');
        // Insert a row in the table at row index 0
        var newRow   = tableRef.tBodies[0].insertRow(-1);
        newRow.style.cursor='pointer';
        newRow.style.height='24px';

        var rIdx = newRow.rowIndex;
        var attrStr = ' onfocus="tableUtil.row.activate(this.parentNode.parentNode)" autocomplete="off"';

        newCell = addCell(newRow,'Quotation No'); newCell.className = 'L1 bd';
        newRow.attachEvent('onclick',function(e) {
            tableUtil.row.activate(newRow);
        });

        newCell = addCell(newRow,'<input name="quotation_no[]"    type="text" maxlength=15 value="' + newQNo + '"' + attrStr + ' style="ime-mode:disabled" readonly /><input name="standard[]"    type="hidden" value="' + CRC_STANDARD + '"/><input name="category[]"    type="hidden" value="' + CRC_ITEM_CATEGORY + '"/>'); newCell.className = 'D1 bd';
        newCell = addCell(newRow,'Item No'); newCell.className = 'L1 bd';
        newCell = addCell(newRow,'<input name="item_no[]"    type="text" value="" maxlength=2 style="text-align:center" ' + attrStr + ' style="ime-mode:disabled"/>'); newCell.className = 'D1 bd';
        newCell = addCell(newRow,'Qty'); newCell.className = 'L1 bd';
        newCell = addCell(newRow,'<input name="qty[]"    type="text" value="1" maxlength=4 style="text-align:center" ' + attrStr + ' style="ime-mode:disabled"/>'); newCell.className = 'D1 bd';
        newCell = addCell(newRow,'Class Name'); newCell.className = 'L1 bd';
      //newCell = addCell(newRow,'<input name="class_name[]"    type="text" value="OS_ELEXESS_P17_BL" ' + attrStr + ' readonly/>'); newCell.className = 'D1 bd';
        newCell = addCell(newRow,'<select name="class_name[]"    type="text" value="OS_ELEXESS_P17_BL" ' + attrStr + '></select>'); newCell.className = 'D1 bd';
        newCell = addCell(newRow,'<button class=button1 onclick="fOpenPopClassName(this.parentNode.parentNode.rowIndex);return false;" style="width:60px">SELECT</button>'); newCell.className = 'D1 bd';
        newCell = addCell(newRow,'<a href=# onmousedown="fDeleteRow(this.parentNode.parentNode,event);return false;"><B>x</B></a>'); newCell.className = 'D1 bd';
        newCell.align = 'center';

        var qObj   = f['quotation_no[]' ];
        var iObj   = f['item_no[]'      ];
        var qtyObj = f['qty[]'          ];
        var cObj   = f['class_name[]'   ];

        //alert ( class_name_gory.length );
        var l = class_name_gory.length;
        for (var i=0; i<l;i++ ) {
            //var opt = document.createElement('OPTION');
            cObj[rIdx+1].options[cObj[rIdx+1].length] = new Option(class_name_gory[i].text,class_name_gory[i].value);
        }


        qObj[rIdx+1].attachEvent('onkeyup',function(e) {
            Util.Form.autoNextElement(qObj[rIdx+1],qtyObj[rIdx+1],15,e);
        });

        /*
        iObj[rIdx+1].attachEvent('onkeyup',function(e) {
            Util.Form.autoNextElement(iObj[rIdx+1],qtyObj[rIdx+1],2,e);
        });
        */
        /*
        f['qty[]'][rIdx+1].attachEvent('onkeyup',function(e) {
            Util.Form.autoNextElement(qtyObj[rIdx+1],f["class_name[]"][rIdx+1],2,e);
        });
        */

        if ( rIdx > 0 ) {
            qObj[rIdx+1].value      = qObj  [1].value ;
            qObj[rIdx+1].readOnly   = true          ;
            qObj[rIdx+1].style.backgroundColor = 'transparent';
            qObj[rIdx+1].style.border = 0;

            qtyObj[rIdx+1].value    = qtyObj[1].value   ;
            cObj[rIdx+1].value      = cObj[1].value     ;
        } else {
            //alert('test');
            qObj[1].attachEvent('onkeyup',function(e) {
                window.setTimeout(fSyncQuotationNo,100);
            });
        }

        iObj[rIdx+1].readOnly = true;
        iObj[rIdx+1].style.backgroundColor = 'transparent';
        iObj[rIdx+1].style.border = 0;

        iObj[rIdx+1].value = rIdx+1;

        newCell = addCell(newRow,'&nbsp;'); newCell.className = 'D1 bd';

        newCell.onfocus = function () {
            tableUtil.row.activate(newRow);
        }

        newCell.onblur = function () {
            tableUtil.row.deactivate(newRow);
        }

        newRow.className = rIdx%2?'even_row':'odd_row';
        qObj[rIdx+1].focus();
        setMask(rIdx+1);

        if ( !l || l == 1 ) {
            //newQNo=fChangeDestination1(f.destination.value);
        }
        return newRow;
    }

    function setMask(rowIndex) {
        var f = $N('wForm')[0];
      //var f = document.wForm;
        // PA0809-00001-01
        // 마스크 기능오류로 인해 #한자리씩 더 넣고 input maxlength속성에서 크기 지정
        //var om1 = new Mask('AA####-#####-###'   );  om1.attach(f['quotation_no[]'][rowIndex]);
        var om2 = new Mask('###'             );  om2.attach(f['item_no[]'][rowIndex]);
        var om3 = new Mask('#####'           );  om3.attach(f['qty[]'][rowIndex]);
    }

    function fSyncQuotationNo() {
        var f = $N('wForm')[0];
        var l = f['quotation_no[]'].length;
        //alert('test : ' +  l);
        for (var i=2; i<l; i++) {
            //if ( f['quotation_no[]'][1].value.length  == 15 ) {
                f['quotation_no[]'][i].value = f['quotation_no[]'][1].value ;
            //} else {
            //  f['quotation_no[]'][i].value = '';
            //}
            f['qty[]'][i].value          = f['qty[]'][1].value          ;
        }
    }

    function fDeleteRow(r,e) {
        if ( r && r.rowIndex > -1 ) {
            var cIdx = r.rowIndex;
            var tBody = r.parentNode;
            r.parentNode.deleteRow(cIdx);
            var msgStr = cIdx + ' / ';

            var tl = tBody.rows.length;
            if ( tl <= cIdx ) {
                cIdx--;
            } else {
                //cIdx = tl;
            }

            if (cIdx >= 0 ) {
                tableUtil.row.deactivate(r);
                var f   = $N('wForm')[0];
                var qObj= f['quotation_no[]'];
                qObj[1].readOnly                = false     ;
                qObj[1].style.backgroundColor   = '#FFFFFF' ;
                qObj[1].style.border            = ''        ;

                qObj[1].attachEvent('onkeyup',function(e) {
                    window.setTimeout(fSyncQuotationNo,100);
                });

                var l = qObj.length;
                for (var i=1; i<l; i++) f['item_no[]'][i].value = i;

                tableUtil.row.activate(tBody.rows[cIdx]);
            }
        }
    }

    function fTest() {
/**/
        alert('테스트 계정은 test로만 선택가능합니다.');
        $('country_code').value = 'XX';
        fChangeCountry($('country_code').value,$('destination').value,$('sold_to_party').value);
        //fChangeDestination1();
        //alert('test');
        return false;

    }
