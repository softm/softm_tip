function HwpCtrlObject(param) {

	this.MIN_VERSION = 0x0505010B; //한글기안기 최소버전
	this.hwpCtrl = null; //한글기안기 Object
	this.isShowToolBar = false; //툴바보기여부
	this.isViewOptionPaper = false; //쪽윤곽 보기여부
	this.basePath = "C:/"; //한글문서 기본경로


	if(param) {		
		if(param.hwpCtrl) this.hwpCtrl = param.hwpCtrl;
		if(param.basePath) this.basePath = param.basePath;
		this.isShowToolBar = param.isShowToolBar;		
		this.isViewOptionPaper = param.isViewOptionPaper;
	}
	
	/**
	 * 속성 값을 변경하는 메서드
	 */
	this.setPropeties = function(properties) {
		if(properties) {		
			if(properties.hwpCtrl) this.hwpCtrl = properties.hwpCtrl;
			if(properties.isShowToolBar) this.isShowToolBar = properties.isShowToolBar;
			if(properties.isViewOptionPaper) this.isViewOptionPaper = properties.isViewOptionPaper;
			if(properties.basePath) this.basePath = properties.basePath;
		}
	};
	
	/**
	 * 한글 버전 체크 메서드
	 */
	this._VerifyVersion = function() {
		var retVal = true;
		var tempHwpCtrl = this.hwpCtrl;
		
		//한글 2002에서 버전 가져오는 메서드 getAttribute("Version")를 통해 버전을 확인한다.
		if(!tempHwpCtrl.getAttribute("Version")) {			
			//한글 2004이상 버전 가져오는 방식인 Version을 통해 버전정보를 확인한다.
			var curVersion = tempHwpCtrl.Version;
			if(curVersion) {
				//최소 한글 2002이상인 한글기안기만 사용하도록 한다.
				if(curVersion < this.MIN_VERSION) {
					alert("HwpCtrl의 버젼이 낮아서 정상적으로 동작하지 않을 수 있습니다.\n"+
						"최신 버젼으로 업데이트하기를 권장합니다.\n\n"+
						"현재 버젼: 0x" + curVersion.toString(16) + "\n"+
						"권장 버젼: 0x" + this.MIN_VERSION.toString(16) + " 이상");
					retVal = false;
				}
				//권장하는 버전으로 체크한다.
				if(curVersion >= 0x0505118 && curVersion <= 0x050511C ) {
					alert("HwpCtrl.GetTextFile이 정상적으로 동작하지 않는 버젼입니다.\n"+
						"최신 버젼으로 업데이트하기를 권장합니다.\n\n"+
						"현재 버젼: 0x" + curVersion.toString(16) + "\n"+
						"권장 버젼: " + 0x050511D + " 이상");
					retVal = false;
				}
			}else {
				retVal = false;
			}
		}
		return retVal;				
	};

	/**
	 * 툴바 셋팅 메서드
	 */
	this._ShowDraftEditToolBar = function() {
		var tempHwpCtrl = this.hwpCtrl;
		//검색과 바꾸기 다이얼 로그를 사용한다.
		tempHwpCtrl.ReplaceAction("FindDlg", "HwpCtrlFindDlg");
		tempHwpCtrl.ReplaceAction("ReplaceDlg", "HwpCtrlReplaceDlg");
		tempHwpCtrl.ShowToolBar(true);
		//툴바 메뉴, 표준, 포멧, 테이블 기능을 사용한다.
		tempHwpCtrl.SetToolBar(-1, "TOOLBAR_MENU");
		tempHwpCtrl.SetToolBar(-1, "TOOLBAR_STANDARD");
		tempHwpCtrl.SetToolBar(-1, "TOOLBAR_FORMAT");
		tempHwpCtrl.SetToolBar(-1, "TOOLBAR_TABLE");
		tempHwpCtrl.ShowToolBar(true);
		//쪽윤곽 보기여부를 사용하는 경우, 쪽윤곽 보기 설정을 지정한다.
		if(this.isViewOptionPaper) {
			tempHwpCtrl.CreateAction("ViewOptionPaper").Run();
		}
	};

	/**
	 * 한글 문서 오픈 메서드
	 */
	this.OpenDoc = function(fileName) {
		if(this._VerifyVersion()) {
			var tempHwpCtrl = this.hwpCtrl;
			try {
				//문서오픈시 접근허용 다이얼 로그를 안보이게 하기위해 DLL을 추가한다.
				//현재는 타 사이트에서 제작한 DLL을 등록하여 처리하였다.
				//한글 API에서 FilePathCheckDLL로 검색하면 PathChecker DLL을 생성하는 방식을 제공하므로
				//각 사이트마다 자신의 SntFilePathCheckerModule모듈을 만들어 레지스트리에 등록하고 사용하도록 한다.
				tempHwpCtrl.RegisterModule("FilePathCheckDLL", "SntFilePathCheckerModule");
			} catch(e) {}						
			
			//툴바를 사용할지 여부에 따라 툴바를 보여준다.
			if(this.isShowToolBar) {				
				this._ShowDraftEditToolBar();
			}

			//기본 경로에 해당 파일명으로 된 hwp파일을 오픈한다.
			alert(this.basePath + fileName + ".hwp");
			if(!tempHwpCtrl.Open(this.basePath + fileName + ".hwp")) {
				alert("파일이 존재하지 않습니다.");
				return false;
			}
		}
	};

	/**
	 * 문서를 다른 이름으로 저장한다.
	 * args값은 한글 API 참고.
	 */
	this.SaveAs = function(newFileName, format, args) {
		var tempHwpCtrl = this.hwpCtrl;
		try {
			//OpenDoc을 참고한다.
			tempHwpCtrl.RegisterModule("FilePathCheckDLL", "SntFilePathCheckerModule");
		} catch(e) {}

		if(!format) format = "HWP";
		if(!args) args = "";
		
		//해당 이름으로 base디렉토리에 새로 저장한다.
		return tempHwpCtrl.SaveAs(this.basePath + newFileName + ".hwp", format, args);
	};
	
	/**
	 * 한글 문서에 입력하는 메서드
	 */
	this.PutFieldText = function(fieldName, text) {
		var tempHwpCtrl = this.hwpCtrl;
		if(tempHwpCtrl.FieldExist(fieldName)) {
			//한글 2005이상인 경우, null을 입력할때 기안기가 죽는 현상 때문에 " " 스페이스 값을 넣어줌
			if(!text || text == "") {
				text = " ";
			}
			tempHwpCtrl.PutFieldText(fieldName, text);
		}
	};
	
	/**
	 * 해당 필드에 이미지를 입력한다.
	 * imgPath는 풀경로로 입력
	 * embeded : (true/false) 이미지를 문서에 포함할지 여부
	 * sizeoption : 이미지 크기 지정
	 *					0 : 원래의 크기대로 삽입
	 *					1 : 지정한 크기로 삽입
	 *					2 : 현재 캐럿이 표의 셀 안에 있을 경우, 셀의 크기에 맞게 자동 조절하여 삽입
	 *						width는 셀의 width만큼, height는 셀의 height만큼 확대/축소되며
 	 *						캐럿이 셀 안에 있지 않으면 이미지의 원래 크기대로 삽입
	 *					3 : 현재 캐럿이 표의 셀 안에 있을 경우, 셀의 크기에 맞추어 원본 이미지의 가로 세로의 비율이 동일하게 확대/축소하여 삽입
	 *	reverse : 이미지 반전 유무
	 * watermark : 워터마크 효과 여부
	 * effect : 그림효과
	 *				0 : 실제 이미지 그대로
	 *				1 : 그레이 스케일
	 *				2 : 흑백효과
	 */
	this.InsertPicture = function(fieldName, imgPath, embeded, sizeoption, reverse, watermark, effect, width, height) {
		var tempHwpCtrl = this.hwpCtrl;
		if(tempHwpCtrl.FieldExist(fieldName)) {
			if(!reverse) reverse = false;
			if(!watermark) watermark = false;
			if(!effect) effect = 0;			
			tempHwpCtrl.MoveToField(fieldName, true, true, false);
			if(width && height) {
				tempHwpCtrl.InsertPicture(imgPath, embeded, sizeoption, reverse, watermark, effect, width, height);
			}else {
				tempHwpCtrl.InsertPicture(imgPath, embeded, sizeoption, reverse, watermark, effect);
			}
		}
	};

	/**
	 * 에디트 모드 설정 메서드
	 * 0 : 읽기전용
	 * 1 : 일반편집모드
	 * 2 : 양식모드(양식 사용자 모드): Cell과 누름틀 중 양식 모드에서 편집 가능한 속성을 가진 것만 편집 가능
	 */
	this.SetEditMode = function(editMode) {
		this.hwpCtrl.EditMode = editMode;
	};
}