package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * BldChkupWrtItemSaveDTOData
 * 체크리스트항목 저장
 * @author softm 
 */
public class BldChkupWrtItemSaveDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ; // 모드
	private String wMode = WConstant.WRITE_MODE_FISRT; // 작성구분

public String ispnChkSeq; // 검측체크번호
public String ispnChkItemSeq; // 검측체크항목번호
public String siteChkSeq; // 현장검측체크번호
public String cntrChk; // 시공사점검
    public BldChkupWrtItemSaveDTO() {
		super();
	}
	public String getMode() {
		return mode;
	}
	public void setMode(String mode) {
		this.mode = mode;
	}
	public String getIspnChkSeq() {
		return ispnChkSeq;
	}
	public void setIspnChkSeq(String ispnChkSeq) {
		this.ispnChkSeq = ispnChkSeq;
	}
	public String getIspnChkItemSeq() {
		return ispnChkItemSeq;
	}
	public void setIspnChkItemSeq(String ispnChkItemSeq) {
		this.ispnChkItemSeq = ispnChkItemSeq;
	}
	public String getSiteChkSeq() {
		return siteChkSeq;
	}
	public void setSiteChkSeq(String siteChkSeq) {
		this.siteChkSeq = siteChkSeq;
	}
	public String getCntrChk() {
		return cntrChk;
	}
	public void setCntrChk(String cntrChk) {
		this.cntrChk = cntrChk;
	}
	public String getwMode() {
		return wMode;
	}
	public void setwMode(String wMode) {
		this.wMode = wMode;
	}
	
	

}