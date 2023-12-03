package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * BldChkupWrtDtlSaveDTO
 * 체크리스트마스터상세 저장
 * @author softm 
 */
public class BldChkupWrtDtlSaveDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ; // 모드
	private String wMode = WConstant.WRITE_MODE_FISRT; // 작성구분
	
public String ispnChkMgntSeq; // 검측마스터번호
public String ispnChkSeq; // 검측체크번호
public String cnsttypecd; // 공종코드
public String dtlcnsttypecd; // 세부공종코드
public String chkDt; // 점검일자
public String plcPrt; // 위치 및 부위
public String wrkAmnt; // 공사량
public String siteNo; // 현장번호[담당,관할]
public String saveType; // 저장상태[임시저장,확정][S,C]

	public BldChkupWrtDtlSaveDTO() {
		super();
	}
	public String getMode() {
		return mode;
	}
	public void setMode(String mode) {
		this.mode = mode;
	}
	public String getIspnChkMgntSeq() {
		return ispnChkMgntSeq;
	}
	public void setIspnChkMgntSeq(String ispnChkMgntSeq) {
		this.ispnChkMgntSeq = ispnChkMgntSeq;
	}
	public String getIspnChkSeq() {
		return ispnChkSeq;
	}
	public void setIspnChkSeq(String ispnChkSeq) {
		this.ispnChkSeq = ispnChkSeq;
	}
	public String getCnsttypecd() {
		return cnsttypecd;
	}
	public void setCnsttypecd(String cnsttypecd) {
		this.cnsttypecd = cnsttypecd;
	}
	public String getDtlcnsttypecd() {
		return dtlcnsttypecd;
	}
	public void setDtlcnsttypecd(String dtlcnsttypecd) {
		this.dtlcnsttypecd = dtlcnsttypecd;
	}
	public String getChkDt() {
		return chkDt;
	}
	public void setChkDt(String chkDt) {
		this.chkDt = chkDt;
	}
	public String getPlcPrt() {
		return plcPrt;
	}
	public void setPlcPrt(String plcPrt) {
		this.plcPrt = plcPrt;
	}
	public String getWrkAmnt() {
		return wrkAmnt;
	}
	public void setWrkAmnt(String wrkAmnt) {
		this.wrkAmnt = wrkAmnt;
	}
	public String getSiteNo() {
		return siteNo;
	}
	public void setSiteNo(String siteNo) {
		this.siteNo = siteNo;
	}
	public String getwMode() {
		return wMode;
	}
	public void setwMode(String wMode) {
		this.wMode = wMode;
	}
	public String getSaveType() {
		return saveType;
	}
	public void setSaveType(String saveType) {
		this.saveType = saveType;
	}

	
	
	
}