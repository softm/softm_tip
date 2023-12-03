var GRID = {
    PARAMETER_SURFIX:"[]",
    where:{},
    sort:{},
    dubleTrans:false,
    init:function(inf) { /* table:tbl,editevent:'onfocus' */
        var tId = inf.table_id;
//        alert( inf.table_id );
        if ( $S(tId) ) {
            var frm = $C("form");
            var clTbl = $S(tId).cloneNode(true);
                frm.appendChild(clTbl);
                $S(tId).parentNode.replaceChild(frm,$S(tId));
            var tbl = $S(tId);

            // requestDataType : 'JSON', // JSON, POST, FORM, FORM.FILE
            inf.requestDataType = inf.requestDataType.toLowerCase();

            // responseDataType : json, xml, text
        	if ( !inf.responseDataType ) {
        		inf.responseDataType = "xml";
        	}
        	inf.responseDataType = inf.responseDataType.toLowerCase();

            if ( !inf.service_infor           ) throw new Error("호출 정보 오류 : infor가 설정되지 않았습니다.");
            if ( !inf.service_infor.className ) throw new Error("클래스가 지정되지 않았습니다.(common.Sample)");
            if ( !inf.service_infor.method    ) throw new Error('메소드가 지정되지 않았습니다.' + "\n" + '({ "list":"common.Sample.get", "update":"exec", "insert":"exec", "delete":"exec" })');
            if ( !inf.service_infor.method["list"  ] ) inf.service_infor.method["list"  ] = "get";
            if ( !inf.service_infor.method["update"] ) inf.service_infor.method["update"] = "save";
            if ( !inf.service_infor.method["insert"] ) inf.service_infor.method["insert"] = "save";
            if ( !inf.service_infor.method["delete"] ) inf.service_infor.method["delete"] = "save";
            if ( !inf.service_infor.method["save"  ] ) inf.service_infor.method["save"  ] = "save";

            if ( !inf.service_infor.params                ) inf.service_infor.params= {};

            if ( !inf.service_infor.argus                 ) inf.service_infor.argus = {};
            if ( !inf.service_infor.argus.p_navi_start    ) inf.service_infor.argus.p_navi_start = 1;
            if ( !inf.service_infor.argus.p_navi_function ) throw new Error("argus.p_navi_function가 지정되지 않았습니다.(argus:{p_navi_start:1,p_navi_start:'fGetList'})");
            inf.row  = !inf.row?{}:inf.row;
            inf.cell = !inf.cell?{color:{ 'save'  :'#CCCCFF' }}:inf.cell;


            if ( !inf.setting) inf.setting = {};

            inf.setting["delete"] = typeof(inf.setting["delete"]) == 'undefined'?true:inf.setting["delete"];
            inf.setting["insert"] = typeof(inf.setting["insert"]) == 'undefined'?true:inf.setting["insert"];

            inf.button = !inf.button?{}:inf.button;
            inf.button["delete"  ] = !inf.button["delete"   ]?"delete"   :inf.button["delete"   ];
            inf.button["undelete"] = !inf.button["undelete" ]?"undelete" :inf.button["undelete" ];
            inf.button["insert"  ] = !inf.button["insert"   ]?"insert"   :inf.button["insert"   ];
            inf.button["update"  ] = !inf.button["update"   ]?"update"   :inf.button["update"   ];

            inf.confirm            = !!inf.confirm;
            inf.editevent           = !inf.editevent?'onfocus':inf.editevent    ;
            inf.onload              = !inf.onload       ?null:inf.onload        ;
            inf.onsubmit            = !inf.onsubmit     ?null:inf.onsubmit      ;
            inf.onfocus             = !inf.onfocus      ?null:inf.onfocus       ;
            inf.ondelete            = !inf.ondelete     ?null:inf.ondelete      ;
            inf.onbeforeedit        = !inf.onbeforeedit ?null:inf.onbeforeedit  ;
            inf.onchange            = !inf.onchange     ?null:inf.onchange      ;
            if (!inf.message) inf.message = {};

            inf.message['insert']   = !inf.message['insert']?"입력하시겠습니까?" :inf.message['insert'];
            inf.message['update']   = !inf.message['update']?"수정하시겠습니까?" :inf.message['update'];
            inf.message['delete']   = !inf.message['delete']?"삭제하시겠습니까?." :inf.message['delete'];
            inf.message['nosave']   = !inf.message['nosave']?"저장할 자료가 없습니다.":inf.message['nosave'];

            // grid 기본정보 설정
            var gridInf = {
            	requestDataType     :inf.requestDataType,
            	responseDataType    :inf.responseDataType,
                dataType        :inf.dataType,
                id          :tId,
                table       :tbl,
                form        :frm,
                data        :null,
                items       :null,
                code        :null,
                confirm  :inf.confirm ,
                editevent :inf.editevent,

                onload    :inf.onload   ,
                onsubmit  :inf.onsubmit ,
                onfocus   :inf.onfocus  ,
                ondelete  :inf.ondelete ,
                onbeforeedit:inf.onbeforeedit,
                onchange :inf.onchange ,
                button:inf.button,
                row:inf.row,
                cell:inf.cell,
                message  :{
                    'insert':inf.message['insert'],
                    'update':inf.message['update'],
                    'delete':inf.message['delete'],
                    'nosave':inf.message['nosave']
                },
                setting :{
                	"delete":inf.setting["delete"],
                	"insert":inf.setting["insert"]
                },

                service_infor:inf.service_infor,
                tmp:{}
            };

            GRID[tId]= {};

            GRID[tId] = gridInf;
            GRID[tId].where ={};

            // 데이터 조회
            GRID[tId].load = function(o) {// o.pagenavi_pos
                var tInfor = GRID[tId];
                //log( tInfor.service_infor);
                tInfor.service_infor.argus.p_navi_start = o.pagenavi_pos;

                // 조건절
                var params           = '';
                var argus_condition  = '';
                if ( tInfor.requestDataType == "post" ) {
                    params = GRID[tId].getConditionParameter();
                    var sortStr = GRID.getSortQuery(tId);
                    if ( sortStr ) params += (params?'&':'') + sortStr; // SORT
                    var formStr = Form.queryString(GRID[tId].form);
                    if ( formStr ) params += '&' + formStr;
                } else if ( tInfor.requestDataType == "json" ) {
                    if ( GRID[tId] ) {
                        var sortStr = GRID.getSortQuery(tId);
                        if ( sortStr ) params += (params?'&':'') + sortStr; // SORT
                    }
                    argus_condition = GRID[tId].getConditionJson();
                    tInfor.service_infor.argus.condition  = argus_condition;
                }
                //alert(GRID[tId].getConditionParameter()=="null");
                //console.debug(argus_condition);
                tInfor.service_infor.params = params;

                // alert( inf.form instanceof Object );
                // alert( typeof(inf.form) );
                var frm = inf.form;
                callService({
                	requestDataType : tInfor.requestDataType, // JSON, POST
                	responseDataType : tInfor.responseDataType, // json, xml, text
//                    dataType    : tInfor.dataType   , // xml,html,script,json
                    table_id    : tId               ,
                    infor:{
                       className  : tInfor.service_infor.className    ,
                       method     : tInfor.service_infor.method.list  ,
                       params     : tInfor.service_infor.params,
                       argus      : tInfor.service_infor.argus
                    },
                    cb:function(data){
                        //GRID[tId].where ={}; // 임시 삭제.
                    	var json  = null;
//                    	alert(tInfor.responseDataType);
                    	if ( tInfor.responseDataType == "xml") {
                    		json  = Util.xml2json(data);
                    	} else {
                    		json  = data;
                    	}
                    	//console.info(JSON.stringify(json));
                        var items = typeof json.item == 'undefined'? new Array():json.item;
                            items = typeof items.length == 'undefined'? new Array(items):items;

//                        console.debug(data);
                        //console.debug(json);
//                        console.debug(json.item);
//                        console.debug(json.item);
//                        console.debug(items);
//                        console.debug(json.fieldinfo);
                         var code = {};
//                        	alert("xx");
//                        	console.debug(json.fieldinfo);
//                         if (!json.fieldinfo) throw new Error("json.fieldinfo not found : " + log(json) );
//                         alert( json );
//                        	console.debug(json.code);
                        if ( tInfor.responseDataType == "xml") {
	                     	if ( data.getElementsByTagName("code").length > 0 ) {
								for ( var fId in json.fieldinfo) {
									code[fId] = GRID.codeXmlToJson(data
											.getElementsByTagName("code")[0]
											.getElementsByTagName(fId));
								}
	                     	}
                        }
                        tInfor.data  = data ;
                        tInfor.items = items;
                        tInfor.code  = code ;
                        tInfor.fields=json.fieldinfo;
//                        console.info(json.fieldinfo);
                        GRID.createHead({table:tId}); // create head

                        var rows = GRID.bind({table:tbl,start:1});
//                        var r=tbl.tBodies[0].insertRow(-1);
//                        var c = GRID.row.addCell({row:r,value:'',editable:false,html:true,status:'R'});
//                            r.setAttribute("dumy_tr","1");
//                            c.colSpan = tbl.tHead.rows[0].cells.length;
                        // create navi
                        if ( json.pagenavi ) {
                            var r=tbl.tFoot.insertRow(-1);
                            var c = GRID.row.addCell({row:r,value:items.length>0?json.pagenavi.html:'조회된 자료가 없습니다.',editable:false,html:true,status:'R'});
                                c.colSpan = tbl.tHead.rows[0].cells.length;
                        }
//                            alert( json["return"] );
                        if ( json["return"] == '200' ) { // success
                            o.mode = "R";
                            //alert(json.message); // error
                            if ( typeof tInfor.onload   == 'function' ) tInfor.onload  (json_merge(o,{data:json}));
                        } else if (json["return"] == '500') {
                            alert(json.message); // error
                            //throw new Error(json.message);
                        }
                    },
                    debug:false,
                    contentType:"text/xml; charset=UTF-8",
                    form:inf.form
                });
            }

            // argus 설정
            GRID[tId].setArgus=function(key,value) {
                var tInfor = GRID[tId];
                tInfor.service_infor.argus[key] = value;
            }

            // where 조건절 생성 ------------------------------------------------
            GRID[tId].setCondition=function(key,value) {
                if ( typeof value == 'undefined' ) {
                    value = key;
                    key   = "WHERE";
                }

                if ( !GRID[tId].where[key] ) GRID[tId].where[key] = {};

                this.setString=function(k,value) {
                    GRID[tId].where[key].equal  = false;
                    GRID[tId].where[key].like   = false;
                    GRID[tId].where[key].where  = true ;
                    GRID[tId].where[key].value  = value;
                    return GRID[tId];
                }

                this.setEqual=function() {
                    GRID[tId].where[key].equal = true;
                    GRID[tId].where[key].where = false;
                    return GRID[tId];
                };

                this.setLike=function() {
                    GRID[tId].where[key].like  = true ;
                    GRID[tId].where[key].where = false;
                    return GRID[tId];
                };

               this.setString(key,value);

                    return GRID[tId];
            };
            // where 조건절 생성 ------------------------------------------------
            GRID[tId].clearCondition=function() {
                GRID[tId].where={};
            };

            GRID[tId].getConditionJson=function() {
                return GRID[tId].where;
            };
            GRID[tId].getConditionParameter=function() {
                var prototype = GRID[tId].where.constructor.prototype;
                var idx=0;
                var fParams = "";
                //log(GRID[tId].where);
                for ( var k in GRID[tId].where ) {
                    try
                    {
                        if (k in prototype) continue;
                        if (GRID[tId].where instanceof Array && isNaN(k)) continue;
                        fParams +=  'softm_cond' + GRID.PARAMETER_SURFIX + '=' + k + "&";
                        fParams +=  's_c_e' + GRID.PARAMETER_SURFIX + '=' + (GRID[tId].where[k].equal?1:0) + "&";
                        fParams +=  's_c_l' + GRID.PARAMETER_SURFIX + '=' + (GRID[tId].where[k].like?1:0 ) + "&";
                        fParams +=  's_c_w' + GRID.PARAMETER_SURFIX + '=' + (GRID[tId].where[k].where?1:0) + "&";
                        fParams +=  's_c_v' + GRID.PARAMETER_SURFIX + '=' + encodeURIComponent(GRID[tId].where[k].value) + "&";
                    } catch(e) {
                    }
                }
                fParams = fParams.substring(0, fParams.length - 1);
                return fParams;
            };
            // ------------------------------------------------ where 조건절 생성
            GRID[tId].getChanged=function() {
                if      ( this.requestDataType == "post" ) {
                    params = GRID.getSaveParameter({table:tId});
                    //log(params);
                    return params?true:false;
                }
                else if ( this.requestDataType == "json" ) {
                    argus  = GRID.getSaveJson     ({table:tId});
//                    return argus.count()>0?true:false;
                    return json_count(argus)>0?true:false;
                }
            }

            GRID[tId].save=function() {
                GRID.save({table:tId});
            }

            /**
             * @param rIdx : Row Index
             * @param fId  : Field name
             * @param value : 값
             * 사용법 : GRID["tbl_test"].setValue(1,"USER_ID",100);
             */
            GRID[tId].setValue=function(rIdx,fId,value) {
                var info = GRID.getInfor(tId);
                var tInfor = GRID[tId];
                var cellIndx = tInfor.fields[fId].index;
                var headRowCount = !info.head?0:info.head.rows.length;
                var rI = rIdx-headRowCount;
                var td = info.body.rows[rI].cells[cellIndx];
                if ( td.childNodes[0].tagName == 'TD' ) {
                    td.childNodes[0].nodeValue = value;
                } else {
                   window.setTimeout( function() { try {td.childNodes[0].value = value;} catch(e){} },0);
                }
                return value;
            }

            /**
             * @param rIdx : Row Index
             * @param fId  : Field name
             * 사용법 : GRID["tbl_test"].getValue("USER_ID")
             */
            GRID[tId].getValue=function(rowIndex,fId) {
                var info = GRID.getInfor(tId);
                var tInfor = GRID[tId];
                var cellIndx = tInfor.fields[fId].index;
                var headRowCount = !info.head?0:info.head.rows.length;
                var rI = rowIndex-headRowCount;
                return info.body.rows[rI].cells[cellIndx].getAttribute('data');
            }

            return true;
        } else {
            throw new Error('id attribute must be assign to table');
            return false;
        }
    },
    addCell:function(r,field_name,type,v,isnull,editable,cssText,html,status) {
        var tbl    = r.offsetParent;
        var tId    = tbl.id;
        v = (typeof v == 'object'?'':v);
        if ( type == 'TEXT' ) {
            c = GRID.row.addCell({row:r,value:v,editable:editable,cssText:cssText,html:html,isnull:isnull,status:status,field_name:field_name});
            c.setAttribute('data',v);
        } else if ( type == 'SELECT' ) {
            var code = GRID[tId].code;
            if ( code[field_name][v] ) {
                c = GRID.row.addCell({row:r,value:code[field_name][v],editable:editable,cssText:cssText,isnull:isnull,html:html,status:status,field_name:field_name});
            } else {
                c = GRID.row.addCell({row:r,value:v,editable:editable,cssText:cssText,isnull:isnull,html:html,status:status,field_name:field_name});
            }
            c.setAttribute('data',v);
        } else {
            alert(field_name);
            var err = new Error();
            err.name = 'My API Input Error';
            err.message = 'Undefined fieldInfo type in php!';
            alert('Undefined fieldInfo type!::>' + type);
            throw err;
        }
    },
    bind:function(o) { /* o:table, o.start */
        //var url = _url;
        var tbl = $S(o.table);
        var items =this[tbl.id].items;
        var tId = tbl.id;
        var th = tbl.tHead     ;
        var tb = tbl.tBodies[0];
        var tf = tbl.tFoot     ;
        var tInfor = GRID[tId];
        var r=null;
        var c=null;
        GRID.clearBody({table:tbl}); /* clear table */
        GRID.clearFoot({table:tbl}); /* clear table */
        var rows = new Array();

        var l = items.length;
        for (var i=0; i<l;i++ ) {
            r=tb.insertRow(-1);
            r.style.cursor='pointer';
//            r.style.height='20px';
            var rIdx = r.rowIndex;
            c =null;
            var prototype = tInfor.fields.constructor.prototype;
            for ( var k in tInfor.fields ) {
                if (k in prototype) continue;
                if (tInfor.fields instanceof Array && isNaN(k)) continue;
                var v = null;
                try{
                    v = items[i][k].value;
                    v = (typeof v == 'object'?'':v);
                } catch(e) {
//                	console.debug(items[i]);
                	alert(k);
                }
                var type   = tInfor.fields[k].type + '';
                var isnull = items[i][k].isnull;
                var editable = tInfor.fields[k].editable;
                var cssText  = tInfor.fields[k].cssText;
                var html= tInfor.fields[k].html;
                var status = 'U';

                if ( tInfor.fields[k].datatype == "currency") {
                   v = Number(v).numberFormat();
                }

                GRID.addCell(r,k,type,v,isnull,editable,cssText,html,status);
            }

            // 컬럼임의로 추가했던것 임시로 주석처리함. 확인필요.
            // c = GRID.row.addCell({row:r,value:'',editable:false});
            rows.push(r);

//            r.onclick = (function(fId){
//                return function(e){
//                    GRID.setSort({event:e,fieldName:fId,arrowDraw:true});
//                };
//            })(fId);

            r.onclick = function(e) {
            	var td = window.event?event.srcElement:e.target;
                if ( td.tagName.toLowerCase() != 'td') return;
                var td = GRID.cell.getTd(td);
                if ( !td.offsetParent ) return;
                var tId = td.offsetParent.id;
                var tInfor = GRID[tId];
                //console.debug(tInfor );
                var cg = GRID.getColgroup(td.offsetParent);
                var fId = cg.childNodes[td.cellIndex].getAttribute('field_name');
                var fInfor = tInfor.fields[fId];
                //alert( fInfor.editable );
                // && (tInfor.cell && tInfor.cell[fId] && typeof tInfor.cell[fId].onclick != 'function')
                //console.debug(tInfor.cell[fId].onclick, fId);
                if ( !fInfor.editable && ( !tInfor.cell[fId] || typeof (tInfor.cell[fId].onclick) != 'function' ) ) {
                    if (  typeof(tInfor.row.onclick) == 'function' ) {
                        tInfor.row.onclick({tId:tId,td:td,tr:this});
                    }
                }
            }
        }
        return rows;
    },
    reload:function(o) {
        var td      = null;
        var tr      = null;
        var tId     = null;
        var tbl     = null;
        var tInfor  = null;
        var mode    = o.mode;
        try
        {
            if ( o.td ) {
                td     = GRID.cell.getTd(o.td);
                tbl    = o.td.offsetParent;
                tId    = tbl.id;
                tInfor = GRID[tId];
            } else if ( o.tr ) {
                tr     = o.tr;
                tbl    = tr.offsetParent;
                tId    = tbl.id;
                tInfor = GRID[tId];
            } else {
                tbl    = $S(o.table);
                tId    = tbl.id;
                tInfor = GRID[tId];
            }
            var cg = GRID.getColgroup(tbl);
            function init(td,refTr) {
                tO          = td.firstChild    ;
                orgO        = td.childNodes[1] ;
                if ( orgO ) {
                    orgVal      = orgO.innerText             ;
                    orgIsNull   = orgO.getAttribute('isnull');
                }
                if ( o["return"] == 200 ) { // 처리 성공
                    var inserted= hasClass(td,"insert")?true:false;
                    if ( inserted ) {
                        var inVal    = td.getAttribute('data'  )!=null?td.getAttribute('data'):''; // td
                        var fId = cg.childNodes[td.cellIndex].getAttribute('field_name');
                        var fInfor;
                        if (fId) {
                            fInfor = tInfor.fields[fId];
                            GRID.addCell(refTr,fId,fInfor.type,inVal,fInfor.isnull,fInfor.editable,fInfor.cssText,"U");
                        }
                    }
                    td.setAttribute('isnull',0);
                } else { // 처리 실패
                    if (orgO) {
                        var fId = cg.childNodes[td.cellIndex].getAttribute('field_name');
                        if (fId) {
                            var t = tInfor.fields[fId].type;
                            if ( t == 'TEXT' ) {
                                td.firstChild.nodeValue = orgVal;
                            } else if ( t == 'SELECT' ) {
                                td.firstChild.nodeValue = tInfor.code[fId][orgVal];
                            }
                            td.setAttribute('data'  ,orgVal     );
                            td.setAttribute('isnull',orgIsNull  );
                        }
                    }
                }
                removeClass(td,"update");
                removeClass(td,"delete");
                if ( orgO ) td.removeChild(orgO) ;
            }

            if ( mode == 'I'  ) {
                tr = td.parentNode; // && o.return == 200
                td = null;
            }

            if ( td ) {
                init(td);
                var updateAllClear = true;
                var deleteAllClear = true;
                tr = td.parentNode;
                var ll = tr.cells.length;
                for (var i=0; i<tr.cells.length;i++ ) {
                    if ( hasClass(tr.cells[i],"update") ) updateAllClear = false;
                    if ( hasClass(tr.cells[i],"delete") ) deleteAllClear = false;
                }
                if ( updateAllClear ) removeClass(tr,"update");
                if ( deleteAllClear ) removeClass(tr,"delete");
                td.focus();
            } else if (tr) {
                var refTr=null;
                if ( mode == 'I'  ) {
                    refTr=tbl.tBodies[0].insertRow(tr.rowIndex);
                }
                var ll = tr.cells.length;
                for (var j=0; j<ll;j++ ) {
                    init(tr.cells[j],refTr);
                }
                if ( mode == 'I'  ) {
                    removeClass(tr,"insert");
                    addClass(tr,"update");
//                    alert( td.parentNode.rowIndex );
                    var hRL = !tbl.tHead?0:tbl.tHead.rows.length;
                    tbl.tBodies[0].deleteRow(tr.rowIndex-hRL);
                    GRID.row.addCell({row:refTr,value:'',editable:false});
                } else {
                    removeClass(tr,"update");
                    removeClass(tr,"delete");
                }
                if (GRID.sCell) GRID.sCell.focus();
            } else {
                var tBody = tbl.tBodies[0];
                var hRL = !tBody.parentNode.tHead?0:tBody.parentNode.tHead.rows.length;
                var tRL = !tBody.parentNode.tFoot?0:tBody.parentNode.tFoot.rows.length;
                var l = tBody.rows.length;
                for (var i=0; i<l;i++ ) {
                    var tr = tBody.rows[i];
                    var ll = tr.cells.length;
                    var inserted= hasClass(tr,"insert")?true:false;
                    var deleted = hasClass(tr,"delete")?true:false;
                    var updated = hasClass(tr,"update")?true:false;
                    if ( inserted || deleted || updated ) {
                        var refTr=null;
                        if ( inserted ) {
                            refTr=tbl.tBodies[0].insertRow(tr.rowIndex);
                        }
                        for (var j=0; j<ll;j++ ) {
                            init(tr.cells[j],refTr);
                        }
                        if ( updated ) removeClass(tr,"update");
                        if ( deleted ) {
                            removeClass(tr,"delete");
                            var hRL = !tbl.tHead?0:tbl.tHead.rows.length;
                            tbl.tBodies[0].deleteRow(tr.rowIndex-hRL);
                        }
                        if ( inserted ) {
                            var hRL = !tbl.tHead?0:tbl.tHead.rows.length;
                            tbl.tBodies[0].deleteRow(tr.rowIndex-hRL);
                            GRID.row.addCell({row:refTr,value:'',editable:false});
                        }
                        //log(tr);
                    } else {
                        //log(tr);
                    }
                }
            }
        }
        catch (e) {
            // alert(e);
        }

    },
    getSaveParameter:function(o) {
        var fParams = "";
        var mode = o.mode;
        var td      = null;
        var tId     = null;
        var tbl     = null;
        var tInfor  = null;
        if ( o.td ) {
            td     = GRID.cell.getTd(o.td);
            tbl    = td.offsetParent;
            tId    = tbl.id;
            tInfor = GRID[tId];
        } else {
            tbl    = $S(o.table);
            tId    = tbl.id;
            tInfor = GRID[tId];
        }
        //log(["tInfor : ",tInfor]);

        var tBody = tbl.tBodies[0];
        var hRL = !tBody.parentNode.tHead?0:tBody.parentNode.tHead.rows.length;
        var tRL = !tBody.parentNode.tFoot?0:tBody.parentNode.tFoot.rows.length;
        var l = tBody.rows.length;
        var prototype = tInfor.fields.constructor.prototype;
        function makeData(rIdx) {
            var idx=0;
            for ( var j in tInfor.fields ) {
                try
                {
                    if (j in prototype) continue;
                    if (tInfor.fields instanceof Array && isNaN(j)) continue;
                    var tr   = tBody.rows[rIdx];
                    var td   = tr.cells[idx];
                    var orgO = td.childNodes[1]; // Span

                    var chgVal    = td.getAttribute('data'  )!=null?td.getAttribute('data'):''; // td
                    var chgIsNull = td.getAttribute('isnull'); // td
                    var orgVal    = "";
                    var orgIsNull = "";

                    if ( orgO ) { // 변경된내용이 있는 TD
                        orgVal    = orgO.innerText             ;
                        orgIsNull = orgO.getAttribute('isnull');
                    } else { // 변경된내용이 없을경우 SPAN태그를 생성하여 보관하지 않음.
                        orgVal    = chgVal;
                        orgIsNull = chgIsNull;
                    }

                    if ( tInfor.requestDataType == 'json' ) {
                        orgVal = encodeURIComponent(orgVal);
                        chgVal = encodeURIComponent(chgVal);
                    }

                    var inserted= hasClass(tr,"insert")?true:false;
                    var deleted = hasClass(tr,"delete")?true:false;
                    var updated = hasClass(tr,"update")?true:false;
                    if ( inserted || deleted || updated ) {

                        if ( inserted ) {
                            fParams +=  j + ''    + GRID.PARAMETER_SURFIX  + '=' + encodeURIComponent(chgVal   ) + "&";
                            fParams +=  j + '_n'  + GRID.PARAMETER_SURFIX  + '=' + encodeURIComponent(chgIsNull) + "&";
                            fParams +=  j + '_o'  + GRID.PARAMETER_SURFIX  + '=' + encodeURIComponent(""       ) + "&";
                            fParams +=  j + '_o_n'+ GRID.PARAMETER_SURFIX  + '=' + encodeURIComponent(""       ) + "&";
                        } else if ( deleted ) {
                            fParams +=  j + ''    + GRID.PARAMETER_SURFIX  + '=' + encodeURIComponent(""       ) + "&";
                            fParams +=  j + '_n'  + GRID.PARAMETER_SURFIX  + '=' + encodeURIComponent(""       ) + "&";
                            fParams +=  j + '_o'  + GRID.PARAMETER_SURFIX  + '=' + encodeURIComponent(orgVal   ) + "&";
                            fParams +=  j + '_o_n'+ GRID.PARAMETER_SURFIX  + '=' + encodeURIComponent(orgIsNull) + "&";
                        } else if ( updated ) {
                            fParams +=  j + ''    + GRID.PARAMETER_SURFIX  + '=' + encodeURIComponent(chgVal   ) + "&";
                            fParams +=  j + '_n'  + GRID.PARAMETER_SURFIX  + '=' + encodeURIComponent(chgIsNull) + "&";
                            fParams +=  j + '_o'  + GRID.PARAMETER_SURFIX  + '=' + encodeURIComponent(orgVal   ) + "&";
                            fParams +=  j + '_o_n'+ GRID.PARAMETER_SURFIX  + '=' + encodeURIComponent(orgIsNull) + "&";
                        }
                    }
                    idx++;
                }
                catch (e)
                {
                    log(e);
                }
            }
        }

        if ( td ) {
            var tr = td.parentNode;
            var inserted= hasClass(tr,"insert")?true:false;
            var deleted = hasClass(tr,"delete")?true:false;
            var updated = hasClass(tr,"update")?true:false;
            fParams +=  'mode' + GRID.PARAMETER_SURFIX  + '=' + (inserted?"I":deleted?"D":"U") + "&";;
            makeData(td.parentNode.rowIndex-hRL)
        } else {
            //log([tBody.rows.length,hRL,tRL]);
            //log(tBody.rows);
            for (var i=0; i<l;i++ ) {
                var tr = tBody.rows[i];
                var inserted= hasClass(tr,"insert")?true:false;
                var deleted = hasClass(tr,"delete")?true:false;
                var updated = hasClass(tr,"update")?true:false;
                //alert(inserted);
                //tr.style.backgroundColor = "black";
                if ( inserted || deleted || updated ) {
                    fParams +=  'mode' + GRID.PARAMETER_SURFIX  + '=' + (inserted?"I":deleted?"D":"U") + "&";;
                    try
                    {
                        makeData(i);
                        //o.style.backgroundColor = "red";
                    }
                    catch (e) {
                        log(e);
                    }
                }
            }
        }
        fParams = fParams.substring(0, fParams.length - 1);
        //log(fParams);
        return fParams;
    },
    getSaveJson:function(o) {
        var fSaveJson = {};
        var mode = o.mode;
        var td      = null;
        var tId     = null;
        var tbl     = null;
        var tInfor  = null;
        if ( o.td ) {
            td     = GRID.cell.getTd(o.td);
            tbl    = td.offsetParent;
            tId    = tbl.id;
            tInfor = GRID[tId];
        } else {
            tbl    = $S(o.table);
            tId    = tbl.id;
            tInfor = GRID[tId];
        }
        //log(["tInfor : ",tInfor]);

        var tBody = tbl.tBodies[0];
        var hRL = !tBody.parentNode.tHead?0:tBody.parentNode.tHead.rows.length;
        var tRL = !tBody.parentNode.tFoot?0:tBody.parentNode.tFoot.rows.length;
        var l = tBody.rows.length;
        var prototype = tInfor.fields.constructor.prototype;

        function makeData(rIdx) {
            var idx=0;
            for ( var j in tInfor.fields ) {
//                try
//                {
                    if (j in prototype) continue;
                    if (tInfor.fields instanceof Array && isNaN(j)) continue;
                    var tr   = tBody.rows[rIdx];
                    var td   = tr.cells[idx];
                    var orgO = td.childNodes[1]; // Span

                    var chgVal    = td.getAttribute('data'  )!=null?td.getAttribute('data'):''; // td
                    var chgIsNull = td.getAttribute('isnull'); // td
                    var orgVal    = "";
                    var orgIsNull = "";

                    if ( orgO ) { // 변경된내용이 있는 TD
                        orgVal    = orgO.innerText             ;
                        orgIsNull = orgO.getAttribute('isnull');
                    } else { // 변경된내용이 없을경우 SPAN태그를 생성하여 보관하지 않음.
                        orgVal    = chgVal;
                        orgIsNull = chgIsNull;
                    }

                    if ( tInfor.requestDataType == 'json' ) {
                        orgVal = encodeURIComponent(orgVal);
                        chgVal = encodeURIComponent(chgVal);
                    }

                    var inserted= hasClass(tr,"insert")?true:false;
                    var deleted = hasClass(tr,"delete")?true:false;
                    var updated = hasClass(tr,"update")?true:false;
                    if ( inserted || deleted || updated ) {
                        if ( !fSaveJson[j + ''     ] ) fSaveJson[j + ''     ] = new Array();
                        if ( !fSaveJson[j + '_n'   ] ) fSaveJson[j + '_n'   ] = new Array();
                        if ( !fSaveJson[j + '_o'   ] ) fSaveJson[j + '_o'   ] = new Array();
                        if ( !fSaveJson[j + '_o_n' ] ) fSaveJson[j + '_o_n' ] = new Array();

                        if ( inserted ) {
                            fSaveJson[j + ''     ].push(chgVal   );
                            fSaveJson[j + '_n'   ].push(chgIsNull);
                            fSaveJson[j + '_o'   ].push("");
                            fSaveJson[j + '_o_n' ].push("");
                        } else if ( deleted ) {
                            //alert("deleted");
                            fSaveJson[j + ''     ].push(""       );
                            fSaveJson[j + '_n'   ].push(""       );
                            fSaveJson[j + '_o'   ].push(orgVal   );
                            fSaveJson[j + '_o_n' ].push(orgIsNull);
                        } else if ( updated ) {
                            fSaveJson[j + ''     ].push(chgVal   );
                            fSaveJson[j + '_n'   ].push(chgIsNull);
                            fSaveJson[j + '_o'   ].push(orgVal   );
                            fSaveJson[j + '_o_n' ].push(orgIsNull);
                        }
                    }
                    idx++;
//                }
//                catch (e)
//                {
//                    log(e);
//                }
            }
        }
        //log( ["Td " , td.parentNode ]);
        if ( td ) {
            var tr = td.parentNode;
            var inserted= hasClass(tr,"insert")?true:false;
            var deleted = hasClass(tr,"delete")?true:false;
            var updated = hasClass(tr,"update")?true:false;
            if ( !fSaveJson['mode'] ) fSaveJson['mode'] = new Array();
            fSaveJson['mode'].push(inserted?"I":deleted?"D":"U");
            makeData(td.parentNode.rowIndex-hRL)
        } else {
            //log([tBody.rows.length,hRL,tRL]);
            //log(tBody.rows);
            for (var i=0; i<l;i++ ) {
                var tr = tBody.rows[i];
                var inserted= hasClass(tr,"insert")?true:false;
                var deleted = hasClass(tr,"delete")?true:false;
                var updated = hasClass(tr,"update")?true:false;
                //alert(inserted);
                //tr.style.backgroundColor = "black";
                if ( inserted || deleted || updated ) {
                    if ( !fSaveJson['mode'] ) fSaveJson['mode'] = new Array();
                    fSaveJson['mode'].push(inserted?"I":deleted?"D":"U");
                    try
                    {
                        makeData(i);
                        //o.style.backgroundColor = "red";
                    }
                    catch (e) {
                        log(e);
                    }
                }

            }
        }
        log(["fSaveJson",fSaveJson]);
        return fSaveJson;
    },
    submit:function(o) { /* o.td, o.table, mode:'I/U/D/M', callback:function() */
        var mode = o.mode;
        var td      = null;
        var tId     = null;
        var tbl     = null;
        var tInfor  = null;
        if ( o.td ) {
            td     = GRID.cell.getTd(o.td);
            tbl    = td.offsetParent;
            tId    = tbl.id;
            tInfor = GRID[tId];
        } else {
            tbl    = $S(o.table);
            tId    = tbl.id;
            tInfor = GRID[tId];
        }
        //log("submit : mode : " + mode);
        var exec = true;
        if ( mode == "U" ) {
            method = tInfor.service_infor.method["update"];
            addClass(td,"update");
            addClass(td.parentNode,"update");
        } else if ( mode == "I" ) {
            method = tInfor.service_infor.method["insert"];
        } else if ( mode == "D" ) {
            method = tInfor.service_infor.method["delete"];
//            removeClass(td.parentNode,"update");
            var cs = td.parentNode.cells;
			var ll = td.parentNode.cells.length;
			for (var i=0; i<ll;i++ ) {
                addClass(td.parentNode.cells[i]   ,"delete");
               // if ( cs[cIdx].className && cs[cIdx].className.indexOf("update") > -1 ) removeClass(cs[cIdx],"update");
			}
            addClass(td.parentNode,"delete");
        } else {
            method = tInfor.service_infor.method["save"];
        }
        o.method = method;
        addClass(tbl,"change");
        if ( typeof tInfor.onsubmit == 'function' ) exec = tInfor.onsubmit(o);
        if ( exec ) GRID.save(o);
    },
    save:function(o) { /* o.td, o.table, mode:'I/U/D/M', callback:function(), method, return */
        var mode = o.mode;
        var td      = null;
        var tId     = null;
        var tbl     = null;
        var tInfor  = null;
        //alert(mode);
        if ( o.td ) {
            td     = GRID.cell.getTd(o.td);
            tbl    = td.offsetParent;
            tId    = tbl.id;
            tInfor = GRID[tId];
            this[tId].tmp.cssText = td.style.cssText;/* cssText 보관 */
            td.style.backgroundColor = tInfor.cell.color.save;
        } else {
            tbl    = $S(o.table);
            tId    = tbl.id;
            tInfor = GRID[tId];
        }
        var method = o.method?o.method:tInfor.service_infor.method["save"];
        var params = null;
        var argus  = null;
        // save data gen
        if      ( tInfor.requestDataType == "post" || tInfor.requestDataType == "form" ) {
        	params = GRID.getSaveParameter(o);
            var sortStr = GRID.getSortQuery(tId);
            if ( sortStr ) params += (params?'&':'') + sortStr; // SORT
            var formStr = Form.queryString(GRID[tId].form);
            if ( formStr ) params += '&' + formStr;
            //log(params);
        }
        else if ( tInfor.requestDataType == "json" ) {
        	argus  = GRID.getSaveJson     (o);
        	//log(argus );
            var sortStr = GRID.getSortQuery(tId);
            if ( sortStr ) params += (params?'&':'') + sortStr; // SORT
        }

        if ( params ) params = "&" + params;
        if (
             ( tInfor.requestDataType == "post" && params ) ||
             ( tInfor.requestDataType == "form" && params ) ||
//             tInfor.requestDataType == "json" && argus.count() > 0
             tInfor.requestDataType == "json" && json_count(argus) > 0
        ) {
//            alert(tInfor.requestDataType);
            callService({
            	requestDataType : tInfor.requestDataType, // JSON, POST
            	requestDataType : tInfor.requestDataType, // JSON, POST
                dataType    : tInfor.dataType   , // xml,html,script,json
                table_id    : tId,
                infor:{
                    className  : tInfor.service_infor.className,
                    method     : method,
                    argus      : argus,
                    params     : params
                },
                cb:function(xmlDoc) {
                    var json  = Util.xml2json(xmlDoc);
                    o["return"] = json["return"];
//                    alert("delete " + json["return"] );
                    if (json["return"] == '200' ) { // success
                        if ( mode == 'U' ) {
                            td.style.cssText = tInfor.tmp.cssText;
                            GRID.reload(o);
                        } else if ( mode == 'I' ) {
                            GRID.reload(o);
                        } else if ( mode == 'D' ) {
                            var hRL = !tbl.tHead?0:tbl.tHead.rows.length;
                            tbl.tBodies[0].deleteRow(td.parentNode.rowIndex-hRL);
                            GRID.reload(o);
                        } else {
                            GRID.reload(o);
                        }
                        removeClass(tbl,"change");
                        if ( typeof o.callback      == 'function' ) o.callback({data:json});

                    } else if (json["return"] == '500') { // error
                        try { td.style.cssText = tInfor.tmp.cssText; } catch(e) {};
                        alert(json.message);
                        if (o.mode != 'I' ) {
                        }
                        GRID.reload(o);
                    }
                    //if ( typeof tInfor.onload   == 'function' ) tInfor.onload  (o.merge({data:json}));
                    if ( typeof tInfor.onload   == 'function' ) tInfor.onload  ( json_merge ( o,{data:json}) );
                },
                debug:false,
                contentType:"text/xml; charset=UTF-8"
            });
        } else {
        }
    },
    insertRow:function(o) { /* table:tId */
        var tbl = $S(o.table);
        var tId = tbl.id;
        var th = tbl.tHead     ;
        var tb = tbl.tBodies[0];
        var tf = tbl.tFoot     ;
        var tInfor = GRID[tId];

        var r=tb.insertRow(-1);
        var c =null;
        var rIdx = r.rowIndex;
        var l = tInfor.fields.length;
        r.style.cursor='pointer';
        r.style.height='20px';
        var c=null;
        var prototype = tInfor.fields.constructor.prototype;
        for ( var j in tInfor.fields ) {
            if (j in prototype) continue;
            if (tInfor.fields instanceof Array && isNaN(j)) continue;
            var c = GRID.row.addCell({row:r,value:'',editable:true,status:'I',isnull:'1'});
            c.tabIndex = parseInt(r.rowIndex+''+c.cellIndex);
            c.setAttribute('data','');
            addClass(c,"insert");
        }
        addClass(r,"insert");

        if ( tInfor.setting["insert"] ) {
            var bt = $C('button');
            bt.innerText = tInfor.button["insert"];
            c = GRID.row.addCell({row:r,value:'',editable:false,status:'I'});
            c.style.verticalAlign = 'middle';
            c.appendChild(bt);

            bt.onclick = (function(r){
                return function(e){
                    e.cancelBubble = true;
                    e.returnValue=false;    /* 이벤트 무효화 */
                    var mode = c.getAttribute('status');
                    if ( tInfor.confirm ) {
                        var msg = tInfor.message['insert'];
                        if ( confirm(msg) ){
                            GRID.submit({td:c,mode:'I',table:tId});
                        }
                    } else {
                        GRID.submit({td:c,mode:'I',table:tId});
                    }
                    return false;
                };
            })(r);
        }

        try { r.cells[0].focus(); } catch(e) {}
        return r;
    },
    row:{
        /**
         * @param tr   : tr
         * @param fId  : Field Index
         * 사용법 : GRID.getValue(o.tr,o.fId)
         */
        getValue:function(tr,fId) {
            //console.debug(tr.offsetParent);
        	var info = GRID.getInfor(tr.offsetParent.id);
        	var tId = info.id;
	        var tInfor = GRID[tId];
	        var cg = GRID.getColgroup(info.table);
	        var rowIndex = tr.rowIndex ;
            if ( !tInfor.fields[fId] ) throw new Error("GRID에 정의된 fId가 없습니다.");
            var cellIndx = tInfor.fields[fId].index;
            var headRowCount = !info.head?0:info.head.rows.length;
            var rI = rowIndex-headRowCount;
            return info.body.rows[rI].cells[cellIndx].getAttribute('data');
        },
        insertCell:function(r) {
            var c = null;
            if        ( r.parentNode.tagName == 'TBODY' || r.parentNode.tagName == 'TFOOT' ) {
                c = r.insertCell(-1);
            } else if ( r.parentNode.tagName == 'THEAD' ) {
                c = $C('th');
                r.appendChild(c);
            }
            return c;
        },
        addCell:function(o) { /* {row:r,value:l>0?xml.pagenavi.html:'Data not Found',editable:false}*/
            var isnull   = typeof o.isnull   == 'undefined' || o.isnull   == 0?0:1;
            var editable = typeof o.editable == 'undefined' || o.editable == false?0:1;
            var html     = typeof o.html     == 'undefined' || o.html     == false?0:1;
            var status   = typeof o.status   == 'undefined' || o.status   == null?'':o.status;
            var cssText  = typeof o.cssText  == 'undefined' || o.cssText  == null?'':o.cssText;
            try
            {
            var tId = o.row.offsetParent.id;
            }
            catch (e)
            {
                alert(tId);
                return;
            }


            var tInfor = GRID[tId];
//console.debug(o.html);
            var c  = GRID.row.insertCell(o.row);
            if ( html == '1' ) {
                //c.innerHTML = o.value;
                c.innerHTML = '<pre>' + o.value + '</pre>';
            } else {
                c.appendChild($CT(o.value));
            }
            c.noWrap='true';
            c.style.overflow ='hidden';

            c.style.cssText = cssText;
            c.className = 'col' + c.cellIndex;
            var fId = o.field_name;
            if ( fId ) {
            	if ( tInfor.fields[fId].align ) c.style.textAlign = tInfor.fields[fId].align;
            }
            try{

            } catch(e) {
            	//console.debug(o.aaaa,fId,tInfor.fields);
            }


//            console.debug(fId);
//            if ( tInfor.fields[fId] && !tInfor.fields[fId].hide ) {
            	c.tabIndex = parseInt(o.row.rowIndex+''+c.cellIndex);
//            } else {
//            	c.tabIndex = parseInt(o.row.rowIndex+1000000+''+c.cellIndex);
//            }

              if ( tInfor.fields[fId] && tInfor.fields[fId].hide ) {
            		try {
            			if ( Util.Browser.msie ) {
                    		c.style.display = "none";
            			} else {
//                      	  console.debug("ab" , cssText, c, Util.Browser.msie);
                    		c.style.display = "none";
//                    		c.style.width = "0px";
//                    		c.width = "0";
            			}
            		} catch(e) {
            			console.debug(e);
            		}
              } else {

              }
            c.setAttribute("editable",editable  );
            c.setAttribute("isnull"  ,isnull    );
            c.setAttribute("status"  ,status    );
            var eventStr = tInfor.editevent;
            //alert(eventStr);
            if ( status == 'I' ) eventStr = 'onfocus';
            if ( status == 'I' && eventStr == 'onfocus' ) {
                    c.attachEvent('onfocus',function(e) {
                        GRID.row.onActivate(this.parentNode);
                        GRID.cell.onFocus(e);
                        GRID.cell.onEdit(e);
                    });
            } else {
                if ( document.all ) {
                    if ( editable == '1' ) {
                        c.attachEvent(eventStr ,
                            function(e) {
                                GRID.cell.onEdit(e);
                            }
                        );
                    }
                    if ( status == 'U' ) {
                        /* 아래코딩이 없으면 ipod safari에서는 onfocus 이벤트가 발생하지 않음. */
                        c.attachEvent('onclick',function(e) {
                            /* alert( userAgent ); */
                        });
                        c.attachEvent('onfocus',function(e) {
                            GRID.row.onActivate(this.parentNode);
                            GRID.cell.onFocus(e);
                        });
                    }
                } else {
                    if ( status == 'U' ) {
                        /* 아래코딩이 없으면 ipod safari에서는 onfocus 이벤트가 발생하지 않음. */
                        c.attachEvent('onclick',function(e) {
                        });

                        c.attachEvent('onfocus',function(e) {
                            GRID.row.onActivate(this.parentNode);
                            GRID.cell.onFocus(e);
                        });
                    }

                    if ( editable == '1' ) {
                        c.attachEvent(eventStr ,
                            function(e) {
                                GRID.cell.onEdit(e);
                            }
                        );
                    }
                }
                // GRID.cell.onclick
                if ( editable != '1' ) {
                    if ( tInfor.cell[fId] && typeof tInfor.cell[fId].onclick == 'function' ) {
                        c.onclick= function (event) {
                            var e = window.event?window.event:event;
                                tInfor.cell[fId].onclick({event:e,tId:tId,td:c,tr:c.parentNode,fId:fId});
                        }
                    }

                }
            }

            return c;
        },
        addCellByTag:function(r,tag) {
            var c  = r.insertCell(-1);
                c.innerHTML = tag;
                return c;
        },
        onActivate:function (e){
            try {
            if (e) {
                var r = e.type?(window.event?event.srcElement:e.target):e;
                var tId = r.offsetParent.id;
                var tInfor = GRID[tId];
                var rObj = tInfor.row;

                if ( rObj.sRow ) this.onDeactivate(rObj.sRow);
                if (r) {
                    rObj.sRow = r;
                    addClass(r,"select");
                }
            }
            }catch(e){
                log(e);
            }
        },
        onDeactivate:function (r){
            try
            {
                var tId = r.offsetParent.id;
                var tInfor = GRID[tId];
                var rObj = tInfor.row;
            }
            catch (e)
            {
            } finally {
                if ( rObj ) {
                    if ( rObj.sRow ) removeClass(rObj.sRow,"select");
                    rObj.sRow = null;
                }
            }
        }
    },
    cell:{
        /**
         * @param tId  : td
         * @param fId  : Field Index [optional]
         * 사용법 : GRID.cell.getValue(o.td,o.fId)
         */
        getValue:function(td,fId) {
        	var info = GRID.getInfor(td.offsetParent.id);
        	var tId = info.id;
	        var tInfor = GRID[tId];
	        var cg = GRID.getColgroup($S(tId));
	        var fId = fId ? fId : cg.childNodes[td.cellIndex].getAttribute('field_name');
	        var rowIndex = td.parentNode.rowIndex ;
            var cellIndx = tInfor.fields[fId].index;
            var headRowCount = !info.head?0:info.head.rows.length;
            var rI = rowIndex-headRowCount;
            return info.body.rows[rI].cells[cellIndx].getAttribute('data');
        },
        getTh:function(th){ /* 상위 TH Element를 반환한다. */
            for( var i=0;i<3;i++ ) {
                if ( th.tagName =='TH' ) break;
                else                     th = th.parentNode;
            }
            return th;
        },
        getTd:function(td){ /* 상위 TD Element를 반환한다. */
            for( var i=0;i<3;i++ ) {
                if ( td == null || td.tagName =='TD' ) break;
                else                     td = td.parentNode;
            }
            return td;
        },
        onActivate:function (e){
            var c = GRID.cell.getTd(window.event?event.srcElement:e.target);
            var tId = c.offsetParent.id;
            var tInfor = GRID[tId];
            var cObj = tInfor.cell;
            //if ( cObj.sCell ) this.onDeactivate(cObj.sCell );
            if ( cObj.sCell ) removeClass(cObj.sCell,"select");

            if (c) {
                if (c) {
                    cObj.sCell = c;
                } else {
                    cObj.sCell = null;
                }
                addClass(c,"select");
            }
        },
        onDeactivate:function (c){
            var tId = c.offsetParent.id;
            var tInfor = GRID[tId];
            var cObj = tInfor.cell;
            cObj.sCell = null;
        },
        onFocus:function(e) {
            var td = window.event?event.srcElement:e.target;
                td = GRID.cell.getTd(td);
            var tId = td.offsetParent.id;
            var tInfor = GRID[tId];

            var cg = GRID.getColgroup($S(tId));
            var fId = cg.childNodes[td.cellIndex].getAttribute('field_name');

            var exec = true;
            if ( typeof tInfor.onfocus == 'function' ) {
                exec = tInfor.onfocus({tId:tId,td:td,fId:fId});
            }
            if ( exec ) {
                var tBody = td.parentNode.parentNode;
                var hRL = !tBody.parentNode.tHead?0:tBody.parentNode.tHead.rows.length;
                var tRL = !tBody.parentNode.tFoot?0:tBody.parentNode.tFoot.rows.length;
                var cIdx = td.cellIndex;
                var rIdx = td.parentNode.rowIndex ;
                if ( tBody.rows ) GRID.row.onActivate(tBody.rows[rIdx-hRL]);

                if ( td.getAttribute('status') == 'U' ) {
                    if ( tInfor.setting["delete"] ) {
                        var btId = tBody.parentNode.id + '_del_button';
                        var btO  = $S(btId);
                        if ( btO ) btO.parentNode.removeChild(btO);
                        var bt = $C('button');
                            bt.id = btId;
                        var deleted = hasClass(tBody.rows[rIdx-hRL],"delete")?true:false;
                            bt.innerText = !deleted?tInfor.button["delete"  ]:tInfor.button["undelete"  ];

                        td.style.verticalAlign = 'middle';
                        td.parentNode.cells[td.parentNode.cells.length-1].appendChild(bt);
                        bt.onfocus = GRID.cell.onFocus;
                        bt.onclick= function(e) {
                            e = window.event?event:e;
                            e.cancelBubble = true;
                            e.returnValue=false;    /* 이벤트 무효화 */
                            GRID.cell.onFocus(e);
                            var exec = true;
                            if ( typeof tInfor.ondelete == 'function' ) {
                                exec = tInfor.ondelete({tId:tId,td:td});
                            }
                            if ( exec ) {
                                if ( tInfor.confirm ) {
                                    var msg = tInfor.message['delete'];
                                    if ( !confirm(msg) ) exec = false;
                                }
                                if ( exec ) {
                                    var deleted = hasClass(tBody.rows[rIdx-hRL],"delete")?true:false;
                                    if ( !deleted ) {
                                        bt.innerText = tInfor.button["undelete"];
                                        GRID.submit({td:td,mode:'D',table:tId});
                                    } else {
                                        bt.innerText = tInfor.button["delete"];
                                        GRID.reload({tr:td.parentNode});
                                    }
                                }
                            }
                            return false;
                        }
                    }
                }
                td.onkeydown= function (event) {
                    var e = window.event?window.event:event;
                    if (e.keyCode == 13) { /* enter */
                        /* eR.onblur(); */
                    }
                    if (e.keyCode == 9 || ( e.shiftKey && e.keyCode == 9 )) { /* tab || shift + tab */
                        if ( Util.Browser.mozilla || Util.Browser.opera) {
                            e.preventDefault();
                            e.stopPropagation();
                        } else {
                            e.cacelBubble = true;
                            e.returnValue = false;
                        }
                        if ( !(e.shiftKey && e.keyCode == 9) ) {
                            if ( td.nextSibling == null ) {
                                if ( td.parentNode.nextSibling ) td.parentNode.nextSibling.cells[0].focus();
                            } else {
                                td.nextSibling.focus();
                            }
                        } else {
                            if ( td.previousSibling == null ) {
                                //log(td.parentNode.previousSibling);
                                if ( td.parentNode.previousSibling ) {
                                    if ( !td.parentNode.previousSibling.getAttribute("dumy_tr") ) {
                                        td.parentNode.previousSibling.cells[td.parentNode.cells.length - 1].focus();
                                    } else {
                                        td.parentNode.previousSibling.previousSibling.cells[td.parentNode.cells.length - 1].focus();
                                    }
                                }
                            } else {
                                td.previousSibling.focus();
                            }
                        }
                    } else if (e.keyCode == 113) { /* F2 */
                        var eventStr = tInfor.editevent;
                        td.fireEvent(eventStr,e);
                    } else {
                        if ( td.firstChild.nodeType == 3 ) {
                            GRID.cell.onKeyDown(e);
                            e.cacelBubble = true;
                            e.returnValue = false;
                            try {
                                e.preventDefault();
                                e.stopPropagation();
                            } catch (e) {
								// TODO: handle exception
							}
                        }
                    }
                }
                GRID.cell.onActivate(e);
            }
            return exec;
        },
        onEdit:function(e) {
            //alert("a");
            var o = (window.event?event.srcElement:e.target);
            var c = this.getTd(o);
            var tId = c.offsetParent.id;
            var tInfor = GRID[tId];
            var cg = GRID.getColgroup($S(tId));
            var fId = cg.childNodes[c.cellIndex].getAttribute('field_name');

            var exec = true;
            if ( typeof tInfor.onbeforeedit == 'function' ) {
                exec = tInfor.onbeforeedit({tId:tId,td:c,fId:fId});
            }
            if ( exec && !hasClass(c,"delete")) {
                if ( c.getAttribute('editable') == '1' ) {
                    if ( c.firstChild.nodeType == 3 || ( c.firstChild.nodeType == 1 && c.firstChild.tagName.toLowerCase() == 'pre' ) ) {
                        var t = tInfor.fields[fId].type;
                        var dt = tInfor.fields[fId].datatype;
                        var eI = null;
                        var data = c.getAttribute('data');
                        if ( t == 'TEXT' ) {
                            eI = document.createElement("textarea");
                            eI.value = dt=="currency"?data.removeComma():data;
                            eI.style.border = '1px solid gray';
                            eI.style.width  = (c.offsetWidth - 15)+'px';
                            eI.style.height = (c.offsetHeight + 1)+'px';
                            eI.style.overflow = 'hidden';
                        } else if ( t == 'SELECT' ) {
                            var eI = $C(t);
                            var code = tInfor.code[fId];
                            var prototype = code.constructor.prototype;
                            for ( var n in code ) {
                                if (n in prototype) continue;
                                if (code instanceof Array && isNaN(n)) continue;
                                var opt = new Option(code[n],n);
                                eI.options[(eI.options.length)] = opt;
                            }
                            eI.style.width = '99%';
                            eI.value = data;
                        }

                        // GRID.cell.onblur
                        var onblurExec = true;
                        if ( tInfor.cell[fId] && typeof tInfor.cell[fId].onblur == 'function' ) {
                            eI.onblur= function (event) {
                                var e = window.event?window.event:event;
                                if ( tInfor.cell[fId] && typeof tInfor.cell[fId].onblur == 'function' ) {
                                    tInfor.cell[fId].onblur({event:e,tId:tId,td:eI,tr:eI.parentNode,fId:fId});
                                }
                            }
                        }
                        if ( onblurExec ) {
                            var t = tInfor.fields[fId].type;
                            if ( t == 'TEXT' ) {
                                eI.attachEvent('onblur'  ,GRID.cell.onBlur);
                            } else if ( t == 'SELECT' ) {
                                eI.attachEvent('onblur'  ,GRID.cell.onBlur);
                                eI.attachEvent('onchange',GRID.cell.onBlur);
                            }

                            eI.tabindex = parseInt(c.tabIndex) -1;
                            eI.onkeydown= function (event) {
                                var e = window.event?window.event:event;
                                if (e.keyCode == 13) { /* enter */
                                    /* eI.onblur(); */
                                }
                                if ( e.keyCode== 27) { /* esc */
                                    var td = this.parentNode;
                                    orgText = td.childNodes[1]; /* org */
                                    eI.value = orgText.innerText;
                                    eI.fireEvent('onblur',e);
                                    GRID.reload({td:td});
                                }
                                this.style.height = '40px'  ;
                                this.style.overflowY = 'auto';
                            }

                            c.replaceChild(eI,c.firstChild);
                            /* 초기값 데이터 유지영역 생성 */
                            if ( !c.childNodes[1] ) {
                                var orgO= $C('span');
                                orgO.innerText = data;
                                orgO.style.display = 'none';
                                orgO.setAttribute("isnull"  ,c.getAttribute('isnull')    );
                                c.appendChild( orgO );
                            }

                            if ( t == 'TEXT' ) { eI.focus(); eI.select(); }
                            else { eI.focus(); }
                        }
                    }
                }
            }
        },
        onBlur:function(e) {

            var e = window.event?window.event:e;
            var eO = window.event?e.srcElement:e.target;
            var c  = GRID.cell.getTd(eO);
            if (!c) return;
            var orgO = c.childNodes[1]; /* org */
            var tId = c.offsetParent.id;
            var tInfor = GRID[tId];

            var cg = GRID.getColgroup($S(tId));
            var fId = cg.childNodes[c.cellIndex].getAttribute('field_name');
            var t = tInfor.fields[fId].type;
            if ( eO.tagName != 'TD' ) {
                var cValue = eO.value;
                var oValue = orgO.innerText;
                if ( t == 'TEXT' ) {
                    if ( tInfor.fields[fId].datatype == "currency") {
                        oValue = oValue.removeComma();
                        c.replaceChild($CT(Number(eO.value).numberFormat()),eO);
                    } else {
                        c.replaceChild($CT(eO.value),eO);
                    }
                } else if ( t == 'SELECT' ) {
                    c.replaceChild($CT(tInfor.code[fId][eO.value]),eO);
                }
                var mode = c.getAttribute('status');
                if ( cValue != oValue ) {
                    var msg = '';
                    if      ( mode == 'I' ) msg = tInfor.message['insert'];
                    else if ( mode == 'U' ) msg = tInfor.message['update'];
                    if ( mode == 'U' ) {
                        var exec = true;
                        if ( typeof tInfor.onchange== 'function' ) exec = tInfor.onchange({tId:tId,td:c,fId:fId});
                        if ( exec ) {
                            // GRID.cell.onchange
                            if (  tInfor.cell[fId] && typeof tInfor.cell[fId].onchange == 'function' ) {
                                if ( !tInfor.cell[fId].onchange({event:null,tId:tId,td:c,tr:c.parentNode,fId:fId}) ) exec = false;
                            }
                            if ( exec ) {
                                c.setAttribute('data',cValue);
                                c.setAttribute('isnull','0');
                                if ( tInfor.confirm ) {
                                    if ( !confirm(msg) ) exec = false;
                                }
                            }
                        }
                        if ( exec ) {
                            GRID.submit({td:c,mode:mode,table:tId});
                        } else {
                            //GRID.reload(o);
                            GRID.reload({td:c});
                        }
                    } else if ( mode == 'I' ) {
                        c.setAttribute('data',cValue);
                        c.setAttribute('isnull','0');
                    }
                }
            }
        },
        onKeyDown:function(e) {
            var sRowObj = null;
        /*
            [trap = 37]
            [trap = 39]
            [trap = 38]
            [trap = 40]
        */
            var code = window.event?window.event.keyCode:e.keyCode;
            if (code == 38 || code == 40 ) {
                td = window.event?event.srcElement:e.target;
                td = GRID.cell.getTd(td);

                var cIdx = td.cellIndex;
                var rIdx = td.parentNode.rowIndex;

                var tBody = td.parentNode.parentNode;
                var hRL = !tBody.parentNode.tHead?0:tBody.parentNode.tHead.rows.length;
                var tRL = !tBody.parentNode.tFoot?0:tBody.parentNode.tFoot.rows.length;

                var newRIdx = rIdx + (code == 38?-1:1) - hRL;
                if ( newRIdx >= 0 && newRIdx < tBody.rows.length ) {
                    if ( tBody.rows[newRIdx].cells[cIdx] ) {
                   GRID.row.onActivate(tBody.rows[newRIdx]);
                   tBody.rows[newRIdx].cells[cIdx].focus();
                   var lastE = $L(tBody.rows[newRIdx].cells[cIdx]);
                   window.setTimeout( function() { try {lastE.focus();} catch(e){} },0);
                   }
                } else {
                    /* alert( tBody.tagName + ' / ' + code + ' / ' + rIdx + ' / ' + newRIdx + ' / ' + hRL + ' / ' + tRL + ' / ' + tBody.rows.length); */
                }
                if ( $L(td).tagName == 'INPUT' ) {
                    var n = $L(td).name;
                }
            }
        }
    },
    clearSort:function(tId) {
        this[tId].sort={};
    },
    setSort:function(o) { /* event:e,fieldName:fId */
        var th = window.event?event.srcElement:o.event.target;
            th = GRID.cell.getTh(th);

        var tbl = th.parentNode.parentNode.parentNode;
        var tId = tbl.id;
        var tInfor = GRID[tId];

        var sId = o.fieldName;
        //console.info(tInfor.fields[sId].html);
        if (!tInfor.fields[sId].sortable) {
            return;
        }
        var arrowDraw = o.arrowDraw?o.arrowDraw:false;
        if ( th.childNodes[0].innerText == '▼' || th.childNodes[0].innerText == '▲' || th.childNodes[0].innerText == '' ) {
            th.removeChild(th.childNodes[0]);
        }

        if (!this.sort[tId]     ) this.sort[tId] = {};
        if (!this.sort[tId][sId]) this.sort[tId][sId] = {};
        var direction = this.sort[tId][sId].direction?this.sort[tId][sId].direction:'';
        if      ( direction == '▲' ) direction = '▼';
        else if ( direction == '▼' ) direction = '' ;
        else                         direction = '▲';
        this.sort[tId][sId].direction = direction;

        if ( direction == '' ) delete this.sort[tId][sId];
//        if(typeof tInfor.onload === 'function') {
//            o.merge({mode:'SORT',pagenavi_pos:1});
            o = json_merge( o, {mode:'SORT',pagenavi_pos:1} );

            GRID[tId].load(o);
//            tInfor.onload(o);
//        }
        if( arrowDraw ) {
            this.drawSortArrow({td:th,fieldName:sId}); /* arrow display */
        }
    },
    getSortQuery:function(tId){
        var params = '';
        if ( typeof this.sort[tId] == 'object' ) {
            for ( var sid in this.sort[tId] ) {
//                params+='sort_f[]='+sid.toLowerCase().replace(/sort_/,'') + '&sort_d[]=' + this.sort[tId][sid].direction +"&";
                params+='sort_f[]='+sid.replace(/sort_/,'') + '&sort_d[]=' + this.sort[tId][sid].direction +"&";
            }
        }
        params = params.substring(0, params.length - 1);
        return params;
    },
    getXMLValue:function (o,nm) {
        var isnull = o.getElementsByTagName(nm)[0].attributes.getNamedItem("isnull");
        return (isnull!=null&&isnull.value=='1')?null:o.getElementsByTagName(nm)[0].firstChild.data;
    },
    codeXmlToJson:function(o) {
        var l = o.length;
        var _r = {};
        for (var i=0; i<l;i++ ) {
            var k = o[i].getAttribute('id');
            _r[k] = {};
            _r[k] = o[i].firstChild.nodeValue;
            var x=o[i].attributes;
            var ll = x.length;
            for ( var j=0;j<ll;j++ ) {
                _r[k][x[j].nodeName] = x[j].nodeValue;
            }
        }
        return _r;
    },
    clearHead:function(o) { /* table:tId */
//        var tbl = $S(o.table);
    	var tbl = null;
    	if ( typeof(o.table) == 'object') tbl = o.table;
    	else							  tbl = $S(o.table);
        var cG = GRID.getColgroup(tbl);
        if ( cG ) {
            while (cG.childNodes.length>0) {cG.removeChild(cG.firstChild); }
            tbl.removeChild(cG);
        }
        while (tbl.tHead.rows.length> 0     ) {tbl.tHead.deleteRow(0);      }
    },
    clearBody:function(o) { /* table:tId */
        var tbl = $S(o.table);
        while (tbl.tBodies[0].rows.length> 0) {tbl.tBodies[0].deleteRow(0); }
    },
    clearFoot:function(o) { /* table:tId */
        var tbl = $S(o.table);
        while (tbl.tFoot.rows.length> 0     ) {tbl.tFoot.deleteRow(0);      }
    },
    clearTable:function(o) { /* table:tId */
        var tbl = $S(o.table);
        while (tbl.tBodies[0].rows.length> 0) {tbl.tBodies[0].deleteRow(0); }
     /* while (tbl.tHead.rows.length> 0     ) {tbl.tHead.deleteRow(0);      } */
        this.clearHead({table:tbl});
        while (tbl.tFoot.rows.length> 0     ) {tbl.tFoot.deleteRow(0);      }
    },
    drawSortArrow:function(o) { /* td:c, fieldName:fId */
        var td = o.td;
        //log(td);
        //alert( td.style.display );
        try {
            if ( td.offsetParent ) {
                var tId = td.offsetParent.id;
                var tInfor = GRID[tId];
                var fId = o.fieldName;
                var fieldInfo = tInfor.fields;
                if ( this.sort[tId] && this.sort[tId][fId] ) {
                    s = $C('SPAN');
                    s.type = 'TEXT';
                    var setStr = '▲';
                    s.innerText = this.sort[tId][fId].direction; /*  ▲ / ▼ SPAN */
                    s.style.backgroundColor = 'transparent';
                    s.style.width = '11px';
                    s.style.height = '10px';
                    s.style.border = '0px';
                 /* o.appendChild(s);*/
                    o.td.insertBefore(s, o.td.firstChild);
                }
            }
        } catch(e) {

        }
    },
    createHead:function(o) { /* table,fieldInfo,calback */
        var tbl = $S(o.table);
        var th = tbl.tHead     ;
        var tId = tbl.id;
        var tInfor = GRID[tId];
        var r = null;
        GRID.clearTable({table:tbl}); /* clear table */
        if ( th.rows.length == 0 ) {
            r=th.insertRow(-1);
            var fieldInfo = tInfor.fields;
//            var ll = fieldInfo.count();
            var ll = json_count(fieldInfo);
        //log(tbl);
            var cg = GRID.getColgroup(tbl);
                cg = cg?cg:$C('COLGROUP');
//            var prototype = tInfor.fields.constructor.prototype;

            for ( var j in tInfor.fields ) {
//                if (j in prototype) continue;
//                if (tInfor.fields instanceof Array && isNaN(j)) continue;
//                if ( !fieldInfo[j].hide ) {
                    var fId = j;
                    var c = GRID.row.addCell({row:r,
                    						  value:(!fieldInfo[j].hide?fieldInfo[j].title:""),
                    						  editable:false,
                    						  field_name:j,
                    						  status:'R'});
                    c.style.cursor = 'pointer';
                    c.onclick = (function(fId){
                        return function(e){
                            GRID.setSort({event:e,fieldName:fId,arrowDraw:true});
                        };
                    })(fId);
                    c.className = 'col' + c.cellIndex;
//                    c.innerText = fieldInfo[j].align;

//                    if (fieldInfo[j].align ) c.style.textAlign = fieldInfo[j].align;

                    this.drawSortArrow({td:c,fieldName:fId}); /* arrow display */
                    var col = $C('COL');
//                    alert( col.width );
//                    console.debug(fieldInfo[j].hide);
                    	if ( fieldInfo[j].hide ) {
                    		try {
                    			if ( Util.Browser.msie ) {
                            		col.style.display = "none";
                    			} else {
                            		c.style.display = "none";
                            		col.width = "0";
                    			}
                    		} catch(e) {}
                    	} else {
                            if ( typeof(fieldInfo[j].width) == "string" ) col.width = fieldInfo[j].width;
                    	}
                        if ( typeof(fieldInfo[j].align) == "string" ) col.align = fieldInfo[j].align;
                        col.setAttribute('field_name',j);
                        cg.appendChild(col);
//                }

            }
            tbl.insertBefore(cg, tbl.tHead);
         /* tbl.tHead.appendChild(cg); */
//            if ( th.rows[0].cells.length == fieldInfo.count() ) {
            if ( tInfor.setting["delete"] ) {
                if ( th.rows[0].cells.length == json_count(fieldInfo) ) {
                    c = GRID.row.addCell({row:r,value:'',editable:false});
                    co = GRID.addCol(tbl);
                    co.align ='right';
                }
            }
        } else {
            r = tbl.tHead.rows[0];
        }
        return null;
    },
    getColgroup:function(tbl) {
        var l = tbl.children.length;
        var _r = null;
        for (var i=0; i<l;i++ ) {
            if ( tbl.children[i].tagName.toLowerCase() == 'colgroup') {
                _r = tbl.children[i];
                break;
            }
        }
        return _r;
    },
    addCol:function(tbl) {
        var cg = this.getColgroup(tbl);
        var col = $C('COL');
            cg.appendChild(col);
        return col;
    },
    getFieldParameter:function(fieldInfo) { /* 사용안함. */
        var p_field_names = new Array();
        var ll = fieldInfo.length;
        for (var j=0; j<ll;j++ ) p_field_names.push(fieldInfo[j].id);
        return p_field_names;
    },
    reGenTable:function(tObj,cellIndexs) {
        var getCellValueString = function (tObj,rIdx,cellIndexs) {

            var l = cellIndexs.length;
            var _rtn = new Array();
            for (var i=0; i<l; i++) {
                _rtn.push(tObj.rows[rIdx].cells[cellIndexs[i]].innerText);
            }
            return _rtn.join('|');
        }

        cellIndexs.sort();
        var rLen = tObj.rows.length - 1;
        var cLen = 0;
        if ( rLen > 0 ) {
            cLen = tObj.rows[1].cells.length;
        }
        var tmpInfoStr = '';
        var htKey = new Object();
        var htCnt = new Object();
        for (i=1; i<=rLen; i++) {
            var iStr = getCellValueString(tObj,i,cellIndexs);
            if (iStr == tmpInfoStr ) {
                var tmpHtV = parseInt(htKey[iStr],10);
                    tmpHtV = isNaN(tmpHtV)?0:tmpHtV;
                htKey[iStr] = tmpHtV + 1;
            }
            tmpInfoStr = iStr;
        }

        for (i=1; i<=rLen; i++) {
            var infoStr = tObj.rows[i].cells[0].innerText;
            var iStr = getCellValueString(tObj,i,cellIndexs);
            var rowSpan = parseInt(htKey[iStr],10);
            if (rowSpan > 0 ) {
                var si = i+1;
                var ei = i+rowSpan;
                var banNames = '';
                var banIdx=7;
                for (j=si; j<=ei; j++) {
                   var l = cellIndexs.length;
                   for (var k=l-1; k>=0; k--) {
                        if ( j == si ) {
                            tObj.rows[j].cells[cellIndexs[k]].rowSpan = rowSpan;
                        } else {
                            tObj.rows[j].cells[k].style.backgroundColor = 'blue';
                            tObj.rows[j].removeChild(tObj.rows[j].cells[cellIndexs[k]]);
                        }
                    }
                }
                i += rowSpan;
            }
        }
    },
    getInfor:function(table) {
    	var tbl = null;
    	if ( typeof(table) == 'object') tbl = table;
    	else							tbl = $S(table);
        var th = tbl.tHead     ;
        var tb = tbl.tBodies[0];
        var tf = tbl.tFoot     ;
        var rtn = {};
            rtn.table = tbl;
            rtn.head = th;
            rtn.body = tb;
            rtn.foot = tf;
            rtn.id   = tbl.id;
        return rtn;
    },
    /**
     * @param tId  : Table Id
     * @param rIdx : Row Index
     * @param fId  : Field name
     * 사용법 : GRID.getValue("tbl_test",1,"USER_ID")
     */
    getValue:function(table,rowIndex,fId) {
    	var info = this.getInfor(table);
//    	console.debug(table);
    	var tId = info.id;
        var tInfor = GRID[tId];
        var cellIndx = tInfor.fields[fId].index;
        var headRowCount = !info.head?0:info.head.rows.length;
        var rI = rowIndex-headRowCount;
        try
        {
            return info.body.rows[rI].cells[cellIndx].getAttribute('data');
        }
        catch (e)
        {
            return '';
        }

    },
    /**
     * @param tId  : Table Id
     * @param rIdx : Row Index
     * @param fId  : Field name
     * 사용법 : GRID.getCell("tbl_test",1,"USER_ID")
     */
    getCell:function(table,rowIndex,fId) {
    	var info = this.getInfor(table);
//    	console.debug(table);
    	var tId = info.id;
        var tInfor = GRID[tId];
        var cellIndx = tInfor.fields[fId].index;
        var headRowCount = !info.head?0:info.head.rows.length;
        var rI = rowIndex-headRowCount;
        return info.body.rows[rI].cells[cellIndx];
    }
}
