package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * PicMngListDTO
 * 사진관리조회
 * @author softm 
 */
public class PicMngListDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
public String pSiteNo      ; // 현장번호[담당,관할]
public String pCnsttypecd  ; // 공종
public String pYyyymm ; // 년월
public String cnstrphtSeq  ; // 공사사진일련번호
public String sysRegDt     ; // 날짜
public String dtlcnsttypecd; // 세부공종코드
public String dtlcnsttypenm; // 세부공종명
public String prt          ; // 위치
	public PicMngListDTO() {
		super();
	}
	public String getMode() {
		return mode;
	}
	public String getpSiteNo() {
		return pSiteNo;
	}
	public String getpCnsttypecd() {
		return pCnsttypecd;
	}
	public String getpYyyymm() {
		return pYyyymm;
	}
	public String getCnstrphtSeq() {
		return cnstrphtSeq;
	}
	public String getSysRegDt() {
		return sysRegDt;
	}
	public String getDtlcnsttypecd() {
		return dtlcnsttypecd;
	}
	public String getDtlcnsttypenm() {
		return dtlcnsttypenm;
	}
	public String getPrt() {
		return prt;
	}
	public void setMode(String mode) {
		this.mode = mode;
	}
	public void setpSiteNo(String pSiteNo) {
		this.pSiteNo = pSiteNo;
	}
	public void setpCnsttypecd(String pCnsttypecd) {
		this.pCnsttypecd = pCnsttypecd;
	}
	public void setpYyyymm(String pYyyymm) {
		this.pYyyymm = pYyyymm;
	}
	public void setCnstrphtSeq(String cnstrphtSeq) {
		this.cnstrphtSeq = cnstrphtSeq;
	}
	public void setSysRegDt(String sysRegDt) {
		this.sysRegDt = sysRegDt;
	}
	public void setDtlcnsttypecd(String dtlcnsttypecd) {
		this.dtlcnsttypecd = dtlcnsttypecd;
	}
	public void setDtlcnsttypenm(String dtlcnsttypenm) {
		this.dtlcnsttypenm = dtlcnsttypenm;
	}
	public void setPrt(String prt) {
		this.prt = prt;
	}
	
}