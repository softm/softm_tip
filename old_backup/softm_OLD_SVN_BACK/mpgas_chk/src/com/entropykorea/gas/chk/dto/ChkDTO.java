package com.entropykorea.gas.chk.dto;
/**
 * ChkDTO
 * @author softm 
 */
public class ChkDTO {
	String checkupIdx=""; // 안전점검인덱스
	String checkupYm=""; // 작업년월
	String checkupCd=""; // 업무코드
	String houseNo=""; // 수용가번호
	String fakeHouseNo=""; // 가수용가번호
	String equipCd=""; // 기기번호코드
	String bldgOrd=""; // 건물순로
	String houseOrd=""; // 세대순로
	String areaCd=""; // 지역코드
	String sectorCd=""; // 구역코드
	String complexCd=""; // 단지코드
	String bldgCd=""; // 건물코드
	String areaNm=""; // 지역명
	String sectorNm=""; // 구역명
	String complexNm=""; // 단지명
	String bldgNo=""; // 번지
	String bldgNm=""; // 빌딩명
	String roomNo=""; // 동호수
	String fakeRoomNo=""; // 가수용가명
	String roadNm=""; // 도로명
	String custNo=""; // 고객번호
	String custNm=""; // 고객명
	String coNm=""; // 상호
	String telNo=""; // 고객전화번호
	String hpNo=""; // 고객핸드폰번호
	String workTelNo=""; // 직장전화번호
	String telCd=""; // 주전화번호구분코드
	String statusCd=""; // 수용가상태코드
	String gmNo=""; // 계량기번호
	String installLocCd=""; // 설치위치구분
	String purposeCd=""; // 용도코드
	String chgDt=""; // 교체일자
	String chgMeter=""; // 교체지침
	String bfMeter=""; // 전월지침
	String lastCheckupDt=""; // 전점검일자
	String lastCheckupCd=""; // 전점검결과
	String lastUserCd=""; // 전점검작업자
	String cheYn=""; // 체납여부
	String gmErrorYn=""; // 불회확인여부
	String longNoCheckupYn=""; // 장기미점검여부
	String longAcceptYn=""; // 장기인정고지세대여부
	String boilerOkYn=""; // 보일러점검결과
	String burnerOkYn=""; // 연소기점검결과
	String pipeOkYn=""; // 배관점검결과
	String gmOkYn=""; // 계량기점검결과
	String breakerOkYn=""; // 차단기보일러점검결과
	String checkupYn=""; // 점검여부
	String checkupDt=""; // 점검일자
	String checkupBeginDt=""; // 점검시작시간
	String checkupEndDt=""; // 점검종료시간
	String checkupUserCd=""; // 점검작업자
	String checkupResultCd=""; // 점검결과
	String checkupMeter=""; // 점검지침
	String gmNoCfm=""; // 확인계량기번호
	String qrReadYn=""; // 건물내부QR코드인식여부
	String photoFileNm=""; // 사진파일명
	String signFileNm=""; // 서명파일명
	String endYn=""; // 완료여부
	String sendYn=""; // 전송여부
	
	int count; // 갯수
	public void setCount(int count) { // 갯수
	    this.count = count;
	}
	public int getCount() { // 갯수
	    return this.count;
	}

	public void setCheckupIdx(String checkupIdx) { // 안전점검인덱스
		this.checkupIdx = checkupIdx;
	}
	public String getCheckupIdx() { // 안전점검인덱스
		return this.checkupIdx;
	}

	public void setCheckupYm(String checkupYm) { // 작업년월
		this.checkupYm = checkupYm;
	}
	public String getCheckupYm() { // 작업년월
		return this.checkupYm;
	}
	public void setCheckupCd(String checkupCd) { // 업무코드
	    this.checkupCd = checkupCd;
	}
	public String getCheckupCd() { // 업무코드
	    return this.checkupCd;
	}
	public void setHouseNo(String houseNo) { // 수용가번호
	    this.houseNo = houseNo;
	}
	public String getHouseNo() { // 수용가번호
	    return this.houseNo;
	}
	public void setFakeHouseNo(String fakeHouseNo) { // 가수용가번호
	    this.fakeHouseNo = fakeHouseNo;
	}
	public String getFakeHouseNo() { // 가수용가번호
	    return this.fakeHouseNo;
	}
	public void setEquipCd(String equipCd) { // 기기번호코드
	    this.equipCd = equipCd;
	}
	public String getEquipCd() { // 기기번호코드
	    return this.equipCd;
	}
	public void setBldgOrd(String bldgOrd) { // 건물순로
	    this.bldgOrd = bldgOrd;
	}
	public String getBldgOrd() { // 건물순로
	    return this.bldgOrd;
	}
	public void setHouseOrd(String houseOrd) { // 세대순로
	    this.houseOrd = houseOrd;
	}
	public String getHouseOrd() { // 세대순로
	    return this.houseOrd;
	}
	public void setAreaCd(String areaCd) { // 지역코드
	    this.areaCd = areaCd;
	}
	public String getAreaCd() { // 지역코드
	    return this.areaCd;
	}
	public void setSectorCd(String sectorCd) { // 구역코드
	    this.sectorCd = sectorCd;
	}
	public String getSectorCd() { // 구역코드
	    return this.sectorCd;
	}
	public void setComplexCd(String complexCd) { // 단지코드
	    this.complexCd = complexCd;
	}
	public String getComplexCd() { // 단지코드
	    return this.complexCd;
	}
	public void setBldgCd(String bldgCd) { // 건물코드
	    this.bldgCd = bldgCd;
	}
	public String getBldgCd() { // 건물코드
	    return this.bldgCd;
	}
	public void setAreaNm(String areaNm) { // 지역명
	    this.areaNm = areaNm;
	}
	public String getAreaNm() { // 지역명
	    return this.areaNm;
	}
	public void setSectorNm(String sectorNm) { // 구역명
	    this.sectorNm = sectorNm;
	}
	public String getSectorNm() { // 구역명
	    return this.sectorNm;
	}
	public void setComplexNm(String complexNm) { // 단지명
	    this.complexNm = complexNm;
	}
	public String getComplexNm() { // 단지명
	    return this.complexNm;
	}
	public void setBldgNo(String bldgNo) { // 번지
	    this.bldgNo = bldgNo;
	}
	public String getBldgNo() { // 번지
	    return this.bldgNo;
	}
	public void setBldgNm(String bldgNm) { // 빌딩명
		this.bldgNm = bldgNm;
	}
	public String getBldgNm() { // 빌딩명
		return this.bldgNm;
	}
	public void setRoomNo(String roomNo) { // 동호수
	    this.roomNo = roomNo;
	}
	public String getRoomNo() { // 동호수
	    return this.roomNo;
	}
	public void setFakeRoomNo(String fakeRoomNo) { // 가수용가명
	    this.fakeRoomNo = fakeRoomNo;
	}
	public String getFakeRoomNo() { // 가수용가명
	    return this.fakeRoomNo;
	}
	public void setRoadNm(String roadNm) { // 도로명
	    this.roadNm = roadNm;
	}
	public String getRoadNm() { // 도로명
	    return this.roadNm;
	}
	public void setCustNo(String custNo) { // 고객번호
	    this.custNo = custNo;
	}
	public String getCustNo() { // 고객번호
	    return this.custNo;
	}
	public void setCustNm(String custNm) { // 고객명
	    this.custNm = custNm;
	}
	public String getCustNm() { // 고객명
	    return this.custNm;
	}
	public void setCoNm(String coNm) { // 상호
	    this.coNm = coNm;
	}
	public String getCoNm() { // 상호
	    return this.coNm;
	}
	public void setTelNo(String telNo) { // 고객전화번호
	    this.telNo = telNo;
	}
	public String getTelNo() { // 고객전화번호
	    return this.telNo;
	}
	public void setHpNo(String hpNo) { // 고객핸드폰번호
	    this.hpNo = hpNo;
	}
	public String getHpNo() { // 고객핸드폰번호
	    return this.hpNo;
	}
	public void setWorkTelNo(String workTelNo) { // 직장전화번호
	    this.workTelNo = workTelNo;
	}
	public String getWorkTelNo() { // 직장전화번호
	    return this.workTelNo;
	}
	public void setTelCd(String telCd) { // 주전화번호구분코드
	    this.telCd = telCd;
	}
	public String getTelCd() { // 주전화번호구분코드
	    return this.telCd;
	}
	public void setStatusCd(String statusCd) { // 수용가상태코드
	    this.statusCd = statusCd;
	}
	public String getStatusCd() { // 수용가상태코드
	    return this.statusCd;
	}
	public void setGmNo(String gmNo) { // 계량기번호
	    this.gmNo = gmNo;
	}
	public String getGmNo() { // 계량기번호
	    return this.gmNo;
	}
	public void setInstallLocCd(String installLocCd) { // 설치위치구분
	    this.installLocCd = installLocCd;
	}
	public String getInstallLocCd() { // 설치위치구분
	    return this.installLocCd;
	}
	public void setPurposeCd(String purposeCd) { // 용도코드
	    this.purposeCd = purposeCd;
	}
	public String getPurposeCd() { // 용도코드
	    return this.purposeCd;
	}
	public void setChgDt(String chgDt) { // 교체일자
	    this.chgDt = chgDt;
	}
	public String getChgDt() { // 교체일자
	    return this.chgDt;
	}
	public void setChgMeter(String chgMeter) { // 교체지침
	    this.chgMeter = chgMeter;
	}
	public String getChgMeter() { // 교체지침
	    return this.chgMeter;
	}
	public void setBfMeter(String bfMeter) { // 전월지침
	    this.bfMeter = bfMeter;
	}
	public String getBfMeter() { // 전월지침
	    return this.bfMeter;
	}
	public void setLastCheckupDt(String lastCheckupDt) { // 전점검일자
	    this.lastCheckupDt = lastCheckupDt;
	}
	public String getLastCheckupDt() { // 전점검일자
	    return this.lastCheckupDt;
	}
	public void setLastCheckupCd(String lastCheckupCd) { // 전점검결과
	    this.lastCheckupCd = lastCheckupCd;
	}
	public String getLastCheckupCd() { // 전점검결과
	    return this.lastCheckupCd;
	}
	public void setLastUserCd(String lastUserCd) { // 전점검작업자
	    this.lastUserCd = lastUserCd;
	}
	public String getLastUserCd() { // 전점검작업자
	    return this.lastUserCd;
	}
	public void setCheYn(String cheYn) { // 체납여부
	    this.cheYn = cheYn;
	}
	public String getCheYn() { // 체납여부
	    return this.cheYn;
	}
	public void setGmErrorYn(String gmErrorYn) { // 불회확인여부
	    this.gmErrorYn = gmErrorYn;
	}
	public String getGmErrorYn() { // 불회확인여부
	    return this.gmErrorYn;
	}
	public void setLongNoCheckupYn(String longNoCheckupYn) { // 장기미점검여부
	    this.longNoCheckupYn = longNoCheckupYn;
	}
	public String getLongNoCheckupYn() { // 장기미점검여부
	    return this.longNoCheckupYn;
	}
	public void setLongAcceptYn(String longAcceptYn) { // 장기인정고지세대여부
	    this.longAcceptYn = longAcceptYn;
	}
	public String getLongAcceptYn() { // 장기인정고지세대여부
	    return this.longAcceptYn;
	}
	public void setBoilerOkYn(String boilerOkYn) { // 보일러점검결과
	    this.boilerOkYn = boilerOkYn;
	}
	public String getBoilerOkYn() { // 보일러점검결과
	    return this.boilerOkYn;
	}
	public void setBurnerOkYn(String burnerOkYn) { // 연소기점검결과
	    this.burnerOkYn = burnerOkYn;
	}
	public String getBurnerOkYn() { // 연소기점검결과
	    return this.burnerOkYn;
	}
	public void setPipeOkYn(String pipeOkYn) { // 배관점검결과
	    this.pipeOkYn = pipeOkYn;
	}
	public String getPipeOkYn() { // 배관점검결과
	    return this.pipeOkYn;
	}
	public void setGmOkYn(String gmOkYn) { // 계량기점검결과
	    this.gmOkYn = gmOkYn;
	}
	public String getGmOkYn() { // 계량기점검결과
	    return this.gmOkYn;
	}
	public void setBreakerOkYn(String breakerOkYn) { // 차단기보일러점검결과
	    this.breakerOkYn = breakerOkYn;
	}
	public String getBreakerOkYn() { // 차단기보일러점검결과
	    return this.breakerOkYn;
	}
	public void setCheckupYn(String checkupYn) { // 점검여부
	    this.checkupYn = checkupYn;
	}
	public String getCheckupYn() { // 점검여부
	    return this.checkupYn;
	}
	public void setCheckupDt(String checkupDt) { // 점검일자
	    this.checkupDt = checkupDt;
	}
	public String getCheckupDt() { // 점검일자
	    return this.checkupDt;
	}
	public void setCheckupBeginDt(String checkupBeginDt) { // 점검시작시간
	    this.checkupBeginDt = checkupBeginDt;
	}
	public String getCheckupBeginDt() { // 점검시작시간
	    return this.checkupBeginDt;
	}
	public void setCheckupEndDt(String checkupEndDt) { // 점검종료시간
	    this.checkupEndDt = checkupEndDt;
	}
	public String getCheckupEndDt() { // 점검종료시간
	    return this.checkupEndDt;
	}
	public void setCheckupUserCd(String checkupUserCd) { // 점검작업자
	    this.checkupUserCd = checkupUserCd;
	}
	public String getCheckupUserCd() { // 점검작업자
	    return this.checkupUserCd;
	}
	public void setCheckupResultCd(String checkupResultCd) { // 점검결과
	    this.checkupResultCd = checkupResultCd;
	}
	public String getCheckupResultCd() { // 점검결과
	    return this.checkupResultCd;
	}
	public void setCheckupMeter(String checkupMeter) { // 점검지침
	    this.checkupMeter = checkupMeter;
	}
	public String getCheckupMeter() { // 점검지침
	    return this.checkupMeter;
	}
	public void setGmNoCfm(String gmNoCfm) { // 확인계량기번호
	    this.gmNoCfm = gmNoCfm;
	}
	public String getGmNoCfm() { // 확인계량기번호
	    return this.gmNoCfm;
	}
	public void setQrReadYn(String qrReadYn) { // 건물내부QR코드인식여부
	    this.qrReadYn = qrReadYn;
	}
	public String getQrReadYn() { // 건물내부QR코드인식여부
	    return this.qrReadYn;
	}
	public void setPhotoFileNm(String photoFileNm) { // 사진파일명
	    this.photoFileNm = photoFileNm;
	}
	public String getPhotoFileNm() { // 사진파일명
	    return this.photoFileNm;
	}
	public void setSignFileNm(String signFileNm) { // 서명파일명
	    this.signFileNm = signFileNm;
	}
	public String getSignFileNm() { // 서명파일명
	    return this.signFileNm;
	}
	public void setEndYn(String endYn) { // 완료여부
	    this.endYn = endYn;
	}
	public String getEndYn() { // 완료여부
	    return this.endYn;
	}
	public void setSendYn(String sendYn) { // 전송여부
	    this.sendYn = sendYn;
	}
	public String getSendYn() { // 전송여부
	    return this.sendYn;
	}
}
