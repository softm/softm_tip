function onInit(argus) {
    $(document).ready(function () {
        //tab_cont_controll
        $(".tab_cont_area").each(function(index){
            var $this = $(this);
            $(this).children(".tab_area").children("li").click(function() {
                var sindex = $(this).index();
//                $this.children(".tab_area").children("li").children("a").removeClass("active")
//                $(this).children("a").addClass("active");
//                $this.children(".tab_cont").hide().eq(sindex).show();
                if ( sindex == 1 ) {
                    document.location.href = "/reginfo.php?mode=write";
                }
            });
        });
    });
    Util.Load.script({src:serviceBase+"/ui/css/grid_mj.css",type:"css"});
    GRID.init({
        requestDataType : "POST"        , // JSON, POST
        responseDataType: "xml"         , // JSON, XML, TEXT
        table_id    : "tbl_list"    , // Table Id
        editevent   : "onclick"  , // onfocus, onclick, ondblclick : onclick과 onfous는 다르게 동작됨.
        confirm     : false         ,
        setting     : {
            "delete": false,
            "insert": false
        },
        service_infor:{
            className  : "front.Qna",
            method     : { "list":"front.Qna.select", "save":"save" },
            argus      : {
                p_navi_function:"조회"
            }
        },
        onload:function(o) { // o.mode : I/U/D/M/R/SORT
            // log(["onload mode : " + o.mode,o]);
            if ( o.data.return == "200" ) {
                if ( o.mode == "U" || o.mode == "D" ) alert(o.data.message);
            }
            onLoad(o,argus);
        }

//,        row:{
//        	onclick:function(o) {
//        		//        		console.debug(o);
//        		getUI("front/qna","write",{
//        			method:"POST",
//        			argus : {
//        				p_qna_no:GRID.getValue(o.tId,o.tr.rowIndex,"qna_no")
//        				//p_company_no:GRID.getValue(o.tId,o.tr.rowIndex,"company_no"),
//        			},
//        			target:"#contents",
//        			loadui:false
//        		});
//        	}
//        }

    });
    조회(getRestoreValue("p_navi_start")?getRestoreValue("p_navi_start"):1);
}

function onLoad(o,argus) { // o.mode : I/U/D/M/R/SORT
    $(".btn_modify").unbind("click");
    $(".btn_modify").click(function(e) {
        var tbl = $S("tbl_list");
        if ( tbl == null ) return;
        var td = GRID.cell.getTd($(this).get(0).parentNode);
        var tr = td.parentNode;
        var qState = GRID.getValue("tbl_list",tr.rowIndex,"QNA_STATE");
        if ( qState == 'A' ) {
            alert("답변완료된 문의사항은 수정할 수 없습니다.");
            return;
        }
        
        getUI("front/qna","write",{
            method:"POST",
            argus : {
              p_qna_no:GRID.getValue($S("tbl_list"),tr.rowIndex,"QNA_NO")
              //p_company_no:GRID.getValue(tbl,tr.rowIndex,"company_no"),
            },
            target:"#sub_content"
        });
        e.preventDefault();
    });

    $(".btn_delete").unbind("click");
    $(".btn_delete").click(function(e) {
      //              console.debug($(this));

      var td = GRID.cell.getTd($(this).get(0).parentNode);
      var tr = td.parentNode;
      var qState = GRID.getValue("tbl_list",tr.rowIndex,"QNA_STATE");
      if ( qState == 'A' ) {
          alert("답변완료된 문의사항은 삭제할 수 없습니다.");
          return;
      }
      // console.debug(td);
      // console.debug(tr.cells[0].innerText);
      if( confirm("삭제하시겠습니까?") ) {
      GRID.submit({
          td:td,mode:"D"});
          조회(1);
          //onInit(SOFTMARGUMENT);
      }
      e.preventDefault();
    });

    $('tbody td.col2').each(function(index, element){
        var qno = GRID.getValue("tbl_list",index+1,"QNA_NO");
        var title = $(element).text();
        if ( qno ) {
            $(element).html('<a href="#" onclick="수정(\'' + qno +'\');"><u>'+title+'</u></a>');
        }
    });
}

function 수정(qno) {
    getUI("front/qna","write",{
        method:"POST",
        argus : {
          p_qna_no:qno
          //p_company_no:GRID.getValue(tbl,tr.rowIndex,"company_no"),
        },
        target:"#sub_content"
        ,loadui:true
    });
}

function 조회(s) {
    var f = document.sForm;
    //GRID["tbl_list"].setArgus("s_search"         ,f.s_search.value);
    //GRID["tbl_list"].setCondition( "USER_LEVEL", ARGUS.p_user_level).setEqual();
    //GRID["tbl_list"].setCondition( $S("s_gubun").value,$S("s_search").value).setLike();
    //GRID["tbl_list"].setArgus("s_search",f.s_search.value);

    //setRestore("s_l_cat",f.s_l_cat.value);
    setRestore("p_navi_start",s,true);
//    GRID["tbl_list"].setArgus("s_search"        ,f.s_search.value);
//    GRID["tbl_list"].setArgus("s_qna_type"      ,f.s_qna_type.value);
//    GRID["tbl_list"].setArgus("s_qna_state"     ,f.s_qna_state.value);

    GRID["tbl_list"].load({pagenavi_pos:s});

    return false;
}

function 입력() {
    getUI("front/qna","write",{
        method:"POST",
        target:"#sub_content",
        argus:{
        p_qna_no:''
        }
    });
    return false;

}
function 파일다운로드() {
	call("FORM","common.Common","saveDownload", 
		{
		p_file_nm:"\"질문답변.xls\"",
		p_data:
		"<table>" +
			$S("tbl_list").tHead.outerHTML +
			$S("tbl_list").tBodies[0].outerHTML+
		"</table>"
		}
	);
}