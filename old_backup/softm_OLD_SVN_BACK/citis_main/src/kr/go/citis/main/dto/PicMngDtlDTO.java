package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * PicMngDtlDTO
 * 사진관리상세조회
 * @author softm 
 */
public class PicMngDtlDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
public String wMode        ; // 작성모드]
public String pCnstrphtSeq ; // 공사사진일련번호
public String cnsttypecd   ; // 공종코드
public String dtlcnsttypecd; // 세부공종코드
public String prt          ; // 위치
public String cnts         ; // 내용
	public PicMngDtlDTO() {
		super();
	}
	public String getMode() {
		return mode;
	}
	public String getwMode() {
		return wMode;
	}
	public String getpCnstrphtSeq() {
		return pCnstrphtSeq;
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
	public void setpCnstrphtSeq(String pCnstrphtSeq) {
		this.pCnstrphtSeq = pCnstrphtSeq;
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