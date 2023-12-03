var P_GUBUN = null;
var P_COMPANY_NO = null;
function onInit(argus) {
	P_GUBUN = argus.p_gubun;	
    call("JSON","front.BizConsult","getJp",
            {
    			p_company_no:argus.p_company_no
            },
            function(xmlDoc){
                var json  = Util.xml2json(xmlDoc);
                if ( json["return"] == "200" ) { // success
                    var item = json.item;
                    P_COMPANY_NO = item.company_no;
                    
            		getPhp("front/biz","biz_interest_company_view",{
            			method:"POST",
            			argus : {
            				p_gubun:P_GUBUN,
                            p_company_no:item.company_no,
                            p_hope_biz_type:item.hope_biz_type,
                            p_open_limit:item.open_limit
            			},
            			target:"#contents",
            			loadui:false,
            			cb:function(){
            				onDataLoad(json,argus)
            			}
            		});
                } else if (json["return"] == "500") {
                    alert(json.message); // error
                }
            }
    	);
}

function onDataLoad(json,argus) {
    var form = $S("wForm");
    if ( json ) {
    	if ( (json.filename1) ) {
    		$S("file1_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno1 + "','f4_" + json.item.consult_no + "_');return false;\">" 
    		                            + ( json.filename1 + ((json.fileext1)?".":"") + (json.fileext1) ) + "</a>"
    								    ;
    	}
    	if ( (json.filename2) ) {
    		$S("file2_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno2 + "','f5_" + json.item.consult_no + "_');return false;\">" 
            + ( json.filename2 + ((json.fileext2)?".":"") + (json.fileext2) ) + "</a>"
		    ;
    	}
    	if ( (json.filename3) ) {
    		$S("file3_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno3 + "','f6_" + json.item.consult_no + "_');return false;\">" 
            + ( json.filename3 + ((json.fileext3)?".":"") + (json.fileext3) ) + "</a>"
		    ;
    	}    	
    	Form.bind(json.fi,json.item,$S("wForm"),{});
    }
}

/**
 * 비지니스 일본기업목록에서 접근한경우 목록복귀
 */
function 목록() {
    if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
    if ( P_GUBUN == "interest_list" ) { // 마이페이지 관심기업
		getUI("front/mypage","interest_company_list",{argus:{ p_company_type:SOFTMARGUMENT.p_company_type }});
    } else { // 일본기업목록
		getUI("front/biz","company_list",{argus:{ p_company_type:SOFTMARGUMENT.p_company_type }});    	
    }
}

function 관심기업(p_company_no) {
    call('POST','front.InterestCompany','insert',
    {
    	p_company_no:p_company_no
    },
    function(xmlDoc){
        var json  = Util.xml2json(xmlDoc);
        if ( json['return'] == '200' ) { // success
            //console.debug(json.insert_id);
            if ( json.mode == 'I' ) {
                //SOFTMARGUMENT.p_consult_no = json.insert_id;
            }
            //$S('btn_list').click();
            onInit(SOFTMARGUMENT);
            alert("관심기업으로 등록되었습니다. " + "\n"
                + "매칭신청은 마이페이지에서 가능합니다.");
//                    alert(json.message); // success
            document.location.href = "/service/front.php?sub=mypage&mode=interest_company_list";
        } else if (json['return'] == '500') {
//            alert(json.message); // error
            alert("이미 관심기업으로 등록되었습니다. ");
        }
    }
    //,f // requestType이 FORM, FORM.FILE의 경우
    );
}

/**
 * 파일 다운로드.
 * @param fNo
 * @param fNm
 */
function fileDownload(fNo,fNm) {
//  alert(fNo + " / " + fNm);
  call('FORM','common.Common','fileDownload',
      {
  		p_file_no:fNo,
  		p_file_nm:fNm,
  		p_sub_dir:"biz"
  	}
  );
}

function 매칭신청() {
	getUI("front/biz","biz_consult_write",{
		argus:{
			p_consult_company_no:P_COMPANY_NO,
			p_proc_type:3
		}
	});	
}  

function fileDownloadCompany(fNo,fNm) {
//    alert(fNo + " / " + fNm);
    call('FORM','common.Common','fileDownload',
        {
    		p_file_no:fNo,
    		p_file_nm:fNm,
    		p_sub_dir:"company"
    	}
    );
}