function onInit(argus) {
    Util.Load.script({src:"/service/ui/css/grid.css",type:"css"});
    GRID.init({
        requestType : "POST"        , // JSON, POST
        dataType    : "xml"         , // xml, json
        table_id    : "tbl_list"    , // Table Id
        editevent   : "ondblclick"  , // onfocus, onclick, ondblclick : onclick과 onfous는 다르게 동작됨.
        confirm     : false         ,
        setting     : {
            "delete": false,
            "insert": false
        },
        service_infor:{
            className  : "admin.TechSeedConsult",
            method     : { "list":"admin.TechSeedConsult.select", "save":"save" },
            argus      : {
                p_navi_function:"조회"
            }
        },
        onload:function(o) { // o.mode : I/U/D/M/R/SORT
            // log(["onload mode : " + o.mode,o]);
            if ( o.mode == "U" || o.mode == "D" ) alert(o.data.message);
            onLoad(o,argus);
        },
        cell:{
            color:{
                'save'  :'#ff0'
            },
            "file_no1":{
                onclick:function(o) {// event 리턴처리 됨.
                	var link = o.td.firstChild.firstChild;
                	var tech_no = GRID.cell.getValue(o.td,'tech_no');                	
                	//console.debug(link.getAttribute("fileno"));
                	var fileNo = link.getAttribute("fileno");
                	첨부파일(fileNo,'f1_' + tech_no + "_");
                	o.event.preventDefault();
                    return false;
                }
            }
        },        
        row:{
        	onclick:function(o) {
        		//        		console.debug(o);
//        		alert(GRID.getValue(o.tId,o.tr.rowIndex,"consult_no"));
//        		alert(GRID.getValue(o.tId,o.tr.rowIndex,"tech_no"));
                getUI("admin/tech","tech_seed_consult_write",{
        			method:"POST",
        			argus : {
        				p_consult_no:GRID.getValue(o.tId,o.tr.rowIndex,"consult_no"),
        				p_tech_no:GRID.getValue(o.tId,o.tr.rowIndex,"tech_no")
        			},
        			target:"#contents",
        			loadui:false
        		});
        	}
        }
    });

    var f = $S("sForm");
    
    Util.Load.script({src:"/service/js/common.js",type:'js',callback:function(){
        var L = new Common.createELTechCat("SELECT","L","s_l_cat","1차카테고리").make(getRestoreValue("s_l_cat")).append($S("area_tech_l_cat"));
        var M = new Common.createELTechCat("SELECT","M","s_m_cat","2차카테고리").make(getRestoreValue("s_l_cat"),getRestoreValue("s_m_cat")).append($S("area_tech_m_cat"));
        var S = new Common.createELTechCat("SELECT","S","s_s_cat","3차카테고리").make(getRestoreValue("s_l_cat"),getRestoreValue("s_m_cat"),getRestoreValue("s_s_cat")).append($S("area_tech_s_cat"));
        L.setNextObject(M);
        M.setNextObject(S);
        L.element.attachEvent("onchange",function() {
            M.element.attachEvent("onchange",function() {
            	조회(1);
                S.element.attachEvent("onchange",function() {
                	조회(1);        	
                });
            });
            조회(1);        	
        });

        조회(getRestoreValue("p_navi_start")?getRestoreValue("p_navi_start"):1);        
    }});
}

function onLoad(o,argus) { // o.mode : I/U/D/M/R/SORT
}

// 조회
function 조회(s) {
	var f = document.sForm;
    // GRID["tbl_list"].setCondition( "USER_LEVEL", ARGUS.p_user_level).setEqual();
    // GRID["tbl_list"].setCondition( $S("s_gubun").value,$S("s_search").value).setLike();
//	alert(f.s_l_cat.value);
//    console.debug("조회:" , SOFTMARGUMENT["RESTORE"]);
    GRID["tbl_list"].setArgus("s_l_cat"         ,f.s_l_cat.value);
    GRID["tbl_list"].setArgus("s_m_cat"         ,f.s_m_cat.value);
    GRID["tbl_list"].setArgus("s_s_cat"         ,f.s_s_cat.value);
    GRID["tbl_list"].setArgus("s_tech_nm"       ,f.s_tech_nm.value);
    GRID["tbl_list"].setArgus("s_license_number",f.s_license_number.value);
    GRID["tbl_list"].setArgus("s_organ"         ,f.s_organ.value);
    GRID["tbl_list"].setArgus("s_keyword"       ,f.s_keyword.value);
    
    setRestore("p_navi_start",s,true);
    // 변수로 저장
    setRestore("s_tech_nm",f.s_tech_nm.value);
    setRestore("s_license_number",f.s_license_number.value);
    setRestore("s_license_number",f.s_license_number.value);
    setRestore("s_organ",f.s_organ.value);
    setRestore("s_keyword",f.s_keyword.value);
    
    setRestore("s_l_cat",f.s_l_cat.value ,true);
    setRestore("s_m_cat",f.s_m_cat.value ,true);
    setRestore("s_s_cat",f.s_s_cat.value ,true);
    
    GRID["tbl_list"].load({pagenavi_pos:s});
    return false;
}

function 파일다운로드() {
	call("FORM","common.Common","saveDownload", 
		{
		p_file_nm:"일본기업시드관리.xls",
		p_data:
		"<table>" +
			$S("tbl_list").tHead.outerHTML +
			$S("tbl_list").tBodies[0].outerHTML+
		"</table>"
		}
	);
}
function 첨부파일(fNo,fNm) {
	//  alert(fNo + " / " + fNm);
	  call('FORM','common.Common','fileDownload',
	      {
	  		p_file_no:fNo,
	  		p_file_nm:fNm,
	  		p_sub_dir:"tech_seed"
	  	}
	  );
}

function fileDownload(fExt) {
	fExt = !fExt?"xls":fExt;
	call("FORM","common.Common","saveDownload",
		{
		p_file_nm:"기술매칭." + fExt,
		p_data:
		"<table>" +
			$S("tbl_list").tHead.outerHTML +
			$S("tbl_list").tBodies[0].outerHTML+
		"</table>"
		}
	);
	return false;
}

function MM_swapImgRestore() { //v3.0
	var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
	var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
	var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
		if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
	var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
		d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
	if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
	for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
	if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
	var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
		if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
