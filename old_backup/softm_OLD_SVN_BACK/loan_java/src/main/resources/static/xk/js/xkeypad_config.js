// XK Base Path URL 설정
//var g_hostPath = window.location.protocol + "//" + window.location.host + "";
var g_hostPath = "http://auth.charmloan.co.kr/XecureKeyPad";
var g_XKBasePath = window.location.protocol + "//" + window.location.host + "/xk";


// for Mobile Web
var XKConfigMobile = {
	version : "1.0.5.2",								// XK 버전
	server : g_hostPath + "/xkscriptservice",			// XK 서블릿 URL
	contextRoot	: g_XKBasePath + "/js",					// XK js 스크립트 경로
	cssPath : g_XKBasePath + "/css/xkp_mobile.css",		// XK css 파일
	//logoImgPath : g_XKBasePath + "/img/logo.png",		// XK 빈영역 로고 이미지
	inputObjectBackgroundColor : "#E4E4E4",				// 백그라운드 컬러
	inputObjectBorderStyle : "1px solid #9E9E9E",		// 보더스타일
	invalidSessionErrorMessage : "보안세션이 만료되었습니다.\n'확인'을 누르면 키패드가 갱신 됩니다.",	// 세션 만료 시 메시지설정
	invalidSessionAutoRefresh : true,					// 세션 만료시 자동 새로고침 설정
	enableAccessibility : false,						// 접근성 관련 설정
	useCustomAlert : false,								// 세션 만료시 Custom Alert 사용 여부 (enableAccessibility : true 설정시 함께 설정)
	functionKeyButtonStyle : "text", // "symbol"		// 재배열, 입력완료 기능 버튼 UI 스타일 설정 (text / symbol)
	maxInputSize : 20									// 최대 입력 사이즈
};

// for PC Web (Pure Script)
var XKConfigDesktop = {
	version : "2.0.0.2",
	server : g_XKBasePath + "/xkscriptservice",
	contextRoot : g_XKBasePath + "/js",
	imgRoot : g_XKBasePath + "/img",
	cssPath : g_XKBasePath + "/css/xkp_plugin.css",
	logoImgPath : g_XKBasePath + "/img/logo_white.png",
	buttonImgPath : g_XKBasePath + "/img/button.png",
	bannerText : "[XecureKeypad] 화면캡쳐 공격을 방어하기 위해 가상커서가 랜덤하게 배치됩니다.",
	invalidSessionErrorMessage : "보안세션이 만료되었습니다. 키패드를 갱신 하세요.",
	functionKeyButtonStyle : "text", // "symbol"
	maxInputSize : 20
};







//for PC Web (Pure Script)
var XKConfigDesktopSmall = {
	version : "2.0.0.2",
	server : g_XKBasePath + "/xkscriptservice",
	contextRoot : g_XKBasePath + "/js",
	imgRoot : g_XKBasePath + "/theme_white/img/html5",
	cssPath : g_XKBasePath + "/theme_white/css/xkp_html5.css",
	logoImgPath : g_XKBasePath + "/theme_white/img/html5/logo_white.png",
	buttonImgPath : g_XKBasePath + "/theme_white/img/button.png",
	bannerText : "[XecureKeypad] 화면캡쳐 공격을 방어하기 위해 가상커서가 랜덤하게 배치됩니다.",
	invalidSessionErrorMessage : "보안세션이 만료되었습니다. 키패드 갱신을 위해 재배열을 클릭해주세요.",
	functionKeyButtonStyle : "text", // "symbol"
	maxInputSize : 20,
	sessionValidTime : 30
};




// for PC Web (Pure Script by HTML5) // Small Skin
var XKConfigHTML5 = {
		version : "1.0.0.0",
		contextRoot : g_XKBasePath + "/js",
		imgRoot : g_XKBasePath + "/theme_white/img/html5",
		cssPath : g_XKBasePath + "/theme_white/css/xkp_html5.css",
		logoImgPath : g_XKBasePath + "/theme_white/img/html5/logo_white.png",
		buttonImgPath : g_XKBasePath + "/theme_white/img/button.png",
		bannerText : "[XecureKeypad] 화면캡쳐 공격을 방어하기 위해 가상커서가 랜덤하게 배치됩니다.",
		invalidSessionErrorMessage : "보안세션이 만료되었습니다. 키패드 갱신을 위해 재배열을 클릭해주세요.",
		functionKeyButtonStyle : "text", // "symbol"
		maxInputSize : 20,
		sessionValidTime : 30
	};

// for MAC Web (Plugin Mode)
var XK_NEW_ConfigPlugin = {
		version : "1.0.0.4",	// plugin version
		server : g_XKBasePath + "/xkservice",
		contextRoot : g_XKBasePath + "/js",
		imgRoot : g_XKBasePath + "/theme_white/img/html5",
		cssPath : g_XKBasePath + "/theme_white/css/xkp_html5.css",
		logoImgPath : g_XKBasePath + "/theme_white/img/html5/logo_white.png",
		buttonImgPath : g_XKBasePath + "/theme_white/img/html5/button.png",
		bannerText : "[XecureKeypad] 화면캡쳐 공격을 방어하기 위해 가상커서가 랜덤하게 배치됩니다.",
		invalidSessionErrorMessage : "보안세션이 만료되었습니다. 키패드를 갱신 하세요.",
		functionKeyButtonStyle : "text", // "symbol"
		sessionTimeout : 60,
		maxInputSize : 20
};
