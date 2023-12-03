function 작성화면() {
	if ( USER_LEVEL >= 2 || USER_LEVEL == 'Z' ) {
	    getUI("front/biz","biz_consult_write",{
	        method:"POST",
	        argus : {
	        	p_proc_type:SOFTMARGUMENT.p_proc_type        	
	        },
	        target:"#contents"
	    });
	} else {
		alert("기업회원만 이용할 수 있습니다.");
	}
}