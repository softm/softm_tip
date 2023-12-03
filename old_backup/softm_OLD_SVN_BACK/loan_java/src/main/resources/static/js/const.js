var DEBUG = true;
//var DEBUG = false;
var OP = !!!DEBUG;

var RESULT_CD = new Object();
	RESULT_CD.OK       = "0";
	RESULT_CD.ERROR    = "9";
	RESULT_CD.NOTLOGIN = "8";

// 상태코드
var LOAN_STATE_CD = new Object();
    LOAN_STATE_CD.NEXT_AUTH            = "02" ; // 후선인증요청

    LOAN_STATE_CD.CONSULT_END          = "13" ; // 상담신청완료
    LOAN_STATE_CD.CONSULT_CANCEL       = "09" ; // 상담취소

    LOAN_STATE_CD.LOAN_CHECK_END       = "17" ; // 진위여부완료 SOFTM
    
    LOAN_STATE_CD.LOAN_CONSULT_START   = "21" ; // 융자상담등록
    LOAN_STATE_CD.LOAN_DOCUMENTA       = "24A"; // 융자상담서류A
    LOAN_STATE_CD.LOAN_DOCUMENTB       = "24B"; // 융자상담서류B
    LOAN_STATE_CD.LOAN_DOCUMENT_MODIFY = "25" ; // 융자상담서류보완요청
    LOAN_STATE_CD.LOAN_CONSULT_END     = "23" ; // 융자상담완료

    LOAN_STATE_CD.LOAN_CONSULT_CANCEL  = "29" ; // 융자상담취소
    
// 신분증진위확인구분
var SCRA_ID_CARD_TYPE = new Object();
    SCRA_ID_CARD_TYPE.JUMIN = "01"; // 주민등록증
    SCRA_ID_CARD_TYPE.DRIVE = "02"; // 운전면허증
    
// 신분증진위확인증결과
var IDCARD_VERIFY_RESULT_TYPE = new Object();
    IDCARD_VERIFY_RESULT_TYPE.SUCCESS = "Y"; // 성공
    IDCARD_VERIFY_RESULT_TYPE.FAIL    = "N"; // 실패
    
// 주거형태
var HOUSE_OWN_CD_TYPE = new Object();
    HOUSE_OWN_CD_TYPE.OWN   = "01"; // 자가  
    HOUSE_OWN_CD_TYPE.RENT  = "04"; // 전세  
    HOUSE_OWN_CD_TYPE.RENT  = "05"; // 월세  
    HOUSE_OWN_CD_TYPE.RENT  = "06"; // 기타  
    HOUSE_OWN_CD_TYPE.SHARE = "07"; // 공동명의

// 가족관계
var CODE_FAMILY = [
	   {"CODE":"01","NAME":"단독"}
	  ,{"CODE":"02","NAME":"부"}
	  ,{"CODE":"03","NAME":"모"}
	  ,{"CODE":"04","NAME":"배우자"}
	  ,{"CODE":"05","NAME":"자녀"}
	  ,{"CODE":"06","NAME":"형제"}
	  ,{"CODE":"07","NAME":"친척"}
	  ,{"CODE":"08","NAME":"기타"}
	];

// 여/부
var CODE_YN_TYPE1 =  [
	{"CODE":"Y","NAME":"여"}
	,{"CODE":"N","NAME":"부"}
	];
	  
var CONST = new Object();
	CONST.DATA_TYPE = "jsonp";
//  CONST.DATA_TYPE = "json";
	CONST.CURRENT_DATE = moment().format("YYYY-MM-DD");

//var REST_URL = "http://test.charmods.co.kr";

/*
	var REST_URL = "http://61.98.130.46"; // OP
	var REST_URL = ""; // local & DEV
	var REST_URL = "/test"; // OP
*/	
var REST_URL = DEBUG?"/test":"http://ods.charmloan.co.kr";
/*
// ods.charmloan.co.kr/oz70
var REST_DEV_URL = "http://61.98.130.46/test"; // local & DEV
var REST_DEV_URL = "/test"; // local & DEV
var REST_DEV_URL = ""; // local & DEV
*/
var REST_DEV_URL = ""; // local & DEV

var INFO = new Object();
    INFO.MAC_ADDRESS = "";
