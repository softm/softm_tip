var ARGUS = null;
var P_COMPANY_NO = null;
function onInit(argus) {
	ARGUS = argus;
	P_COMPANY_NO = argus.p_company_no;
	onDataLoad(null,argus)
}
function onDataLoad(json,argus) {
    $S('wForm')["biz_classified[]"][8].onclick = function () {
        $S('wForm').biz_classified_etc.disabled = !this.checked ;
        $S('wForm').biz_classified_etc.focus();
    }
    
    if ($S('wForm')["biz_classified[]"][8].checked) {
        $S('wForm').biz_classified_etc.disabled = false;
    }
    
    $S('wForm').worker_cnt.onfocus = Form.numeberOnly;
}
function 실행() {
	var f = $S('wForm');
	var exec = true;
    if (
	    Form.validate( f ,{
	        biz_field:function(){ f.biz_field[0].focus();Effect.twinkle(f.biz_field[0].parentNode);},
	        hope_biz_type:function(){ f.hope_biz_type[0].focus();Effect.twinkle(f.hope_biz_type[0].parentNode);},
	        open_limit:function(){ f.open_limit[0].focus();Effect.twinkle(f.open_limit[0].parentNode);},
	        "biz_classified[]":function(){ Effect.twinkle(f["biz_classified[]"][0].parentNode);},
	        jp_trade_yn:function(){ f.jp_trade_yn[0].focus();f.jp_trade_yn[0].focus();Effect.twinkle(f.jp_trade_yn[0].parentNode);},
	        etc_trade_yn:function(){ f.etc_trade_yn[0].focus(); f.etc_trade_yn[0].focus();Effect.twinkle(f.etc_trade_yn[0].parentNode);}
	        })
    )
    {
    	if ( exec ) {
    	    // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
            //  call(requestType,className,method,argus,cb,form)
//    		log(JSON.stringify(Form.jsonData(f)));
//    		call(requestType,className,method,argus,cb,form) {
	        call('FORM.FILE','front_jp.Company','insertJp',
	            {
	            },
    		    function(xmlDoc){
//	            	alert(xmlDoc);
	                var json  = Util.xml2json(xmlDoc);
	                if ( json["return"] == '200' ) { // success
///	                    alert(json.message); // success
	                    alert("신청되었습니다.(일어)"); // success
//	                    console.debug(json.insert_id);
	                    if ( json.insert_id ) {
//		                    SOFTMARGUMENT.p_company_no = json.insert_id
	                    }
//	                    onInit(SOFTMARGUMENT);
//	                    목록();
//	                    document.location.href = "/service/front_jp.php?sub=biz&mode=jp_company_write";
	                    document.location.href = "/sub.php?flashmenu=10803";
	                } else if (json["return"] == '500') {
	                    alert(json.message); // error
	                }
    		    },
    			$S("wForm")
    		);

    	}
    }
    return false;
}

/**
 * 사업자 번호 검사
 * @param bizID
 * @returns {Boolean}
 */
function checkBizRegNo(bizID)
{
    var checkID = new Array(1, 3, 7, 1, 3, 7, 1, 3, 5, 1);
    var i, Sum=0, c2, remander;        bizID = bizID.replace(/-/gi,'');
    for (i=0; i<=7; i++){
           Sum += checkID[i] * bizID.charAt(i);
    }

    c2 = "0" + (checkID[8] * bizID.charAt(8));
    c2 = c2.substring(c2.length - 2, c2.length);

    Sum += Math.floor(c2.charAt(0)) + Math.floor(c2.charAt(1));

    remander = (10 - (Sum % 10)) % 10 ;

    if(bizID.length != 10){
           return false;
    }else if (Math.floor(bizID.charAt(9)) != remander){
           return false;
    }else{
           return true;
    }
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
  		p_sub_dir:"company"
  	}
  );
}
/**
 * 파일 다운로드.
 * @param fNo
 * @param fNm
 */
function fileDownloadConsult(fNo,fNm) {
//	alert(fNo + " / " + fNm);
	call('FORM','common.Common','fileDownload',
			{
		p_file_no:fNo,
		p_file_nm:fNm,
		p_sub_dir:"biz"
			}
	);
}

