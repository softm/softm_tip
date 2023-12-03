package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * BldChkupWrtDtlDTOData
 * 체크리스트마스터상세 : 수정시 조회필요
 * @author softm 
 */
public class BldChkupWrtDtlDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
	private String wMode = WConstant.WRITE_MODE_FISRT; // 작성구분
	
public String pIspnChkMgntSeq; // 검측마스터번호
public String pIspnChkSeq; // 검측체크번호

public String cnsttypecd; // 공종코드	
public String dtlcnsttypecd; // 세부공종코드

public String chkDt; // 점검일자
public String plcPrt; // 위치 및 부위
public String wrkAmnt; // 공사량
public String ispnDt; // 검측일자

	public BldChkupWrtDtlDTO() {
		super();
	}

	public String getMode() {
		return mode;
	}

	public void setMode(String mode) {
		this.mode = mode;
	}

	public String getpIspnChkMgntSeq() {
		return pIspnChkMgntSeq;
	}

	public void setpIspnChkMgntSeq(String pIspnChkMgntSeq) {
		this.pIspnChkMgntSeq = pIspnChkMgntSeq;
	}

	public String getpIspnChkSeq() {
		return pIspnChkSeq;
	}

	public void setpIspnChkSeq(String pIspnChkSeq) {
		this.pIspnChkSeq = pIspnChkSeq;
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

	public String getIspnDt() {
		return ispnDt;
	}

	public void setIspnDt(String ispnDt) {
		this.ispnDt = ispnDt;
	}

	public String getwMode() {
		return wMode;
	}

	public void setwMode(String wMode) {
		this.wMode = wMode;
	}

	public String getCnsttypecd() {
		return cnsttypecd;
	}

	public String getDtlcnsttypecd() {
		return dtlcnsttypecd;
	}

	public void setCnsttypecd(String cnsttypecd) {
		this.cnsttypecd = cnsttypecd;
	}

	public void setDtlcnsttypecd(String dtlcnsttypecd) {
		this.dtlcnsttypecd = dtlcnsttypecd;
	}

}