package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * PicMngSaveDTO
 * 사진관리저장
 * @author softm 
 */
public class PicMngSaveDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
public String wMode        ; // 작성모드
public String cnstrphtSeq ; // 공사사진일련번호호
public String siteNo       ; // 현장번호[담당,관할]호
public String cnsttypecd   ; // 공종코드호
public String dtlcnsttypecd; // 세부공종코드호
public String prt          ; // 위치호
public String cnts         ; // 내용
	public PicMngSaveDTO() {
		super();
	}
	public String getMode() {
		return mode;
	}
	public String getwMode() {
		return wMode;
	}
	public String getCnstrphtSeq() {
		return cnstrphtSeq;
	}
	public String getSiteNo() {
		return siteNo;
	}
	public String getCnsttypecd() {
		return cnsttypecd;
	}
	public String getDtlcnsttypecd() {
		return dtlcnsttypecd;
	}
	public String getPrt() {
		return prt;
	}
	public String getCnts() {
		return cnts;
	}
	public void setMode(String mode) {
		this.mode = mode;
	}
	public void setwMode(String wMode) {
		this.wMode = wMode;
	}
	public void setCnstrphtSeq(String cnstrphtSeq) {
		this.cnstrphtSeq = cnstrphtSeq;
	}
	public void setSiteNo(String siteNo) {
		this.siteNo = siteNo;
	}
	public void setCnsttypecd(String cnsttypecd) {
		this.cnsttypecd = cnsttypecd;
	}
	public void setDtlcnsttypecd(String dtlcnsttypecd) {
		this.dtlcnsttypecd = dtlcnsttypecd;
	}
	public void setPrt(String prt) {
		this.prt = prt;
	}
	public void setCnts(String cnts) {
		this.cnts = cnts;
	}

}