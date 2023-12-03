package com.entropykorea.gas.chg.dto;
/**
 * ChgDTO
 * @author softm 
 */
public class ChgDTO {
	String jobYm = ""; // 작업년월
	String houseNo = ""; // 수용가번호
	String custNo = ""; // 고객번호
	String equipCd = ""; // 기기번호코드(GW010)
	String areaCd = ""; // 지역코드
	String sectorCd = ""; // 구역코드
	String complexCd = ""; // 단지코드
	String bldgCd = ""; // 건물코드
	String houseOrd = ""; // 세대순로
	String areaNm = ""; // 지역명
	String sectorNm = ""; // 구역명
	String complexNm = ""; // 단지명
	String bldgNm = ""; // 건물명
	String bldgNo = ""; // 번지명
	String roomNo = ""; // 호수명
	String roadNm = ""; // 도로명
	String custNm = ""; // 고객명
	String coNm = ""; // 상호
	String telNo = ""; // 전화번호
	String hpNo = ""; // 핸드폰
	String workTelNo = ""; // 직장전화번호
	String telCd = ""; // 주전화번호구분코드(MA290)
	String houseStatusCd = ""; // 수용가상태코드(MA090
	String claimCustYn = ""; // N/A
	String claimContent = ""; // N/A
	String cheMonthCnt = ""; // N/A
	String chePriceSum = ""; // N/A
	String gmErrorYn = ""; // N/A
	String bfGmNo = ""; // 교체전계량기번호
	String bfModel = ""; // 교체전모델
	String bfKindCd = ""; // 교체전종류코드(GM030)
	String bfTypeCd = ""; // 교체전타입코드(GM050)
	String bfMakerCd = ""; // 교체전제조사코드(GM070)
	String bfInstallLocGbCd = ""; // 교체전설치위치구분(GM130)
	String bfMakeYy = ""; // 교체전제조년도
	String bfUnionCnt = ""; // 교체전유니온갯수
	String bfSealNo = ""; // 교체전유니온키퍼번호,봉인번호
	String bfRepairCd = ""; // 교체전검정품구분코드(GM110)
	String bfSealCd = ""; // 교체전봉인방법(MA220)
	String afGmNo = ""; // 교체후계량기번호
	String afModel = ""; // 교체후모델
	String afKindCd = ""; // 교체후종류코드(GM030)
	String afTypeCd = ""; // 교체후타입코드(GM050)
	String afMakerCd = ""; // 교체후제조사코드(GM070)
	String afInstallLocCd = ""; // 교체후설치위치코드(GM060)
	String afMakeYy = ""; // 교체후제조년도
	String afUnionCnt = ""; // 교체후유니온갯수
	String afSealNo = ""; // 교체후유니온키퍼번호,봉인번호
	String afRepairCd = ""; // 교체후검정품구분코드(GM110)
	String afSealCd = ""; // 교체전봉인방법(MA220)
	String chgRemoveMeter = ""; // 교체철거지침
	String chgInstallMeter = ""; // 교체설치지침
	String chgDt = ""; // 교체일자
	String bfInstallDt = ""; // 이전교체일자
	String chgUserCd = ""; // 교체자
	String signFileNm = ""; // N/A
	String photoFileNm = ""; // N/A
	String endYn = ""; // 완료여부
	String sendYn = ""; // 송신여부
	public String getJobYm() {
		return jobYm;
	}
	public void setJobYm(String jobYm) {
		this.jobYm = jobYm;
	}
	public String getHouseNo() {
		return houseNo;
	}
	public void setHouseNo(String houseNo) {
		this.houseNo = houseNo;
	}
	public String getCustNo() {
		return custNo;
	}
	public void setCustNo(String custNo) {
		this.custNo = custNo;
	}
	public String getEquipCd() {
		return equipCd;
	}
	public void setEquipCd(String equipCd) {
		this.equipCd = equipCd;
	}
	public String getAreaCd() {
		return areaCd;
	}
	public void setAreaCd(String areaCd) {
		this.areaCd = areaCd;
	}
	public String getSectorCd() {
		return sectorCd;
	}
	public void setSectorCd(String sectorCd) {
		this.sectorCd = sectorCd;
	}
	public String getComplexCd() {
		return complexCd;
	}
	public void setComplexCd(String complexCd) {
		this.complexCd = complexCd;
	}
	public String getBldgCd() {
		return bldgCd;
	}
	public void setBldgCd(String bldgCd) {
		this.bldgCd = bldgCd;
	}
	public String getHouseOrd() {
		return houseOrd;
	}
	public void setHouseOrd(String houseOrd) {
		this.houseOrd = houseOrd;
	}
	public String getAreaNm() {
		return areaNm;
	}
	public void setAreaNm(String areaNm) {
		this.areaNm = areaNm;
	}
	public String getSectorNm() {
		return sectorNm;
	}
	public void setSectorNm(String sectorNm) {
		this.sectorNm = sectorNm;
	}
	public String getComplexNm() {
		return complexNm;
	}
	public void setComplexNm(String complexNm) {
		this.complexNm = complexNm;
	}
	public String getBldgNm() {
		return bldgNm;
	}
	public void setBldgNm(String bldgNm) {
		this.bldgNm = bldgNm;
	}
	public String getBldgNo() {
		return bldgNo;
	}
	public void setBldgNo(String bldgNo) {
		this.bldgNo = bldgNo;
	}
	public String getRoomNo() {
		return roomNo;
	}
	public void setRoomNo(String roomNo) {
		this.roomNo = roomNo;
	}
	public String getRoadNm() {
		return roadNm;
	}
	public void setRoadNm(String roadNm) {
		this.roadNm = roadNm;
	}
	public String getCustNm() {
		return custNm;
	}
	public void setCustNm(String custNm) {
		this.custNm = custNm;
	}
	public String getCoNm() {
		return coNm;
	}
	public void setCoNm(String coNm) {
		this.coNm = coNm;
	}
	public String getTelNo() {
		return telNo;
	}
	public void setTelNo(String telNo) {
		this.telNo = telNo;
	}
	public String getHpNo() {
		return hpNo;
	}
	public void setHpNo(String hpNo) {
		this.hpNo = hpNo;
	}
	public String getWorkTelNo() {
		return workTelNo;
	}
	public void setWorkTelNo(String workTelNo) {
		this.workTelNo = workTelNo;
	}
	public String getTelCd() {
		return telCd;
	}
	public void setTelCd(String telCd) {
		this.telCd = telCd;
	}
	public String getHouseStatusCd() {
		return houseStatusCd;
	}
	public void setHouseStatusCd(String houseStatusCd) {
		this.houseStatusCd = houseStatusCd;
	}
	public String getClaimCustYn() {
		return claimCustYn;
	}
	public void setClaimCustYn(String claimCustYn) {
		this.claimCustYn = claimCustYn;
	}
	public String getClaimContent() {
		return claimContent;
	}
	public void setClaimContent(String claimContent) {
		this.claimContent = claimContent;
	}
	public String getCheMonthCnt() {
		return cheMonthCnt;
	}
	public void setCheMonthCnt(String cheMonthCnt) {
		this.cheMonthCnt = cheMonthCnt;
	}
	public String getChePriceSum() {
		return chePriceSum;
	}
	public void setChePriceSum(String chePriceSum) {
		this.chePriceSum = chePriceSum;
	}
	public String getGmErrorYn() {
		return gmErrorYn;
	}
	public void setGmErrorYn(String gmErrorYn) {
		this.gmErrorYn = gmErrorYn;
	}
	public String getBfGmNo() {
		return bfGmNo;
	}
	public void setBfGmNo(String bfGmNo) {
		this.bfGmNo = bfGmNo;
	}
	public String getBfModel() {
		return bfModel;
	}
	public void setBfModel(String bfModel) {
		this.bfModel = bfModel;
	}
	public String getBfKindCd() {
		return bfKindCd;
	}
	public void setBfKindCd(String bfKindCd) {
		this.bfKindCd = bfKindCd;
	}
	public String getBfTypeCd() {
		return bfTypeCd;
	}
	public void setBfTypeCd(String bfTypeCd) {
		this.bfTypeCd = bfTypeCd;
	}
	public String getBfMakerCd() {
		return bfMakerCd;
	}
	public void setBfMakerCd(String bfMakerCd) {
		this.bfMakerCd = bfMakerCd;
	}
	public String getBfInstallLocGbCd() {
		return bfInstallLocGbCd;
	}
	public void setBfInstallLocGbCd(String bfInstallLocGbCd) {
		this.bfInstallLocGbCd = bfInstallLocGbCd;
	}
	public String getBfMakeYy() {
		return bfMakeYy;
	}
	public void setBfMakeYy(String bfMakeYy) {
		this.bfMakeYy = bfMakeYy;
	}
	public String getBfUnionCnt() {
		return bfUnionCnt;
	}
	public void setBfUnionCnt(String bfUnionCnt) {
		this.bfUnionCnt = bfUnionCnt;
	}
	public String getBfSealNo() {
		return bfSealNo;
	}
	public void setBfSealNo(String bfSealNo) {
		this.bfSealNo = bfSealNo;
	}
	public String getBfRepairCd() {
		return bfRepairCd;
	}
	public void setBfRepairCd(String bfRepairCd) {
		this.bfRepairCd = bfRepairCd;
	}
	public String getBfSealCd() {
		return bfSealCd;
	}
	public void setBfSealCd(String bfSealCd) {
		this.bfSealCd = bfSealCd;
	}
	public String getAfGmNo() {
		return afGmNo;
	}
	public void setAfGmNo(String afGmNo) {
		this.afGmNo = afGmNo;
	}
	public String getAfModel() {
		return afModel;
	}
	public void setAfModel(String afModel) {
		this.afModel = afModel;
	}
	public String getAfKindCd() {
		return afKindCd;
	}
	public void setAfKindCd(String afKindCd) {
		this.afKindCd = afKindCd;
	}
	public String getAfTypeCd() {
		return afTypeCd;
	}
	public void setAfTypeCd(String afTypeCd) {
		this.afTypeCd = afTypeCd;
	}
	public String getAfMakerCd() {
		return afMakerCd;
	}
	public void setAfMakerCd(String afMakerCd) {
		this.afMakerCd = afMakerCd;
	}
	public String getAfInstallLocCd() {
		return afInstallLocCd;
	}
	public void setAfInstallLocCd(String afInstallLocCd) {
		this.afInstallLocCd = afInstallLocCd;
	}
	public String getAfMakeYy() {
		return afMakeYy;
	}
	public void setAfMakeYy(String afMakeYy) {
		this.afMakeYy = afMakeYy;
	}
	public String getAfUnionCnt() {
		return afUnionCnt;
	}
	public void setAfUnionCnt(String afUnionCnt) {
		this.afUnionCnt = afUnionCnt;
	}
	public String getAfSealNo() {
		return afSealNo;
	}
	public void setAfSealNo(String afSealNo) {
		this.afSealNo = afSealNo;
	}
	public String getAfRepairCd() {
		return afRepairCd;
	}
	public void setAfRepairCd(String afRepairCd) {
		this.afRepairCd = afRepairCd;
	}
	public String getAfSealCd() {
		return afSealCd;
	}
	public void setAfSealCd(String afSealCd) {
		this.afSealCd = afSealCd;
	}
	public String getChgRemoveMeter() {
		return chgRemoveMeter;
	}
	public void setChgRemoveMeter(String chgRemoveMeter) {
		this.chgRemoveMeter = chgRemoveMeter;
	}
	public String getChgInstallMeter() {
		return chgInstallMeter;
	}
	public void setChgInstallMeter(String chgInstallMeter) {
		this.chgInstallMeter = chgInstallMeter;
	}
	public String getChgDt() {
		return chgDt;
	}
	public String getBfInstallDt() {
		return bfInstallDt;
	}
	public void setChgDt(String chgDt) {
		this.chgDt = chgDt;
	}
	public void setBfChgDt(String bfInstallDt) {
		this.bfInstallDt = bfInstallDt;
	}
	public String getChgUserCd() {
		return chgUserCd;
	}
	public void setChgUserCd(String chgUserCd) {
		this.chgUserCd = chgUserCd;
	}
	public String getSignFileNm() {
		return signFileNm;
	}
	public void setSignFileNm(String signFileNm) {
		this.signFileNm = signFileNm;
	}
	public String getPhotoFileNm() {
		return photoFileNm;
	}
	public void setPhotoFileNm(String photoFileNm) {
		this.photoFileNm = photoFileNm;
	}
	public String getEndYn() {
		return endYn;
	}
	public void setEndYn(String endYn) {
		this.endYn = endYn;
	}
	public String getSendYn() {
		return sendYn;
	}
	public void setSendYn(String sendYn) {
		this.sendYn = sendYn;
	}
	
}
