package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * BldChkupWrtItemListDTOData
 * 체크리스트항목조회
 * @author softm 
 */
public class BldChkupWrtItemListDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
	private String wMode = WConstant.WRITE_MODE_FISRT; // 작성구분
	
	public String pIspnChkMgntSeq; // 검측마스터번호    
	public String pIspnChkSeq    ; // 검측체크번호     
	public String pDtlcnsttypecd ; // 세부공종코드     
	public String pSiteNo        ; // 현장번호[담당,관할]
	public String ispnChkItemSeq ; // 검측체크항목번호   
	public String ispnItem       ; // 검사항목       
	public String ispnStd        ; // 검사기준       
	public String cntrChk        ; // 시공사점검      
	public String siteChkSeq     ; // 현장검측체크번호   

	public String getMode() {
		return mode;
	}
	public String getwMode() {
		return wMode;
	}
	public String getpIspnChkMgntSeq() {
		return pIspnChkMgntSeq;
	}
	public String getpIspnChkSeq() {
		return pIspnChkSeq;
	}
	public String getpDtlcnsttypecd() {
		return pDtlcnsttypecd;
	}
	public String getpSiteNo() {
		return pSiteNo;
	}
	public String getIspnChkItemSeq() {
		return ispnChkItemSeq;
	}
	public String getIspnItem() {
		return ispnItem;
	}
	public String getIspnStd() {
		return ispnStd;
	}
	public String getCntrChk() {
		return cntrChk;
	}
	public String getSiteChkSeq() {
		return siteChkSeq;
	}
	public void setMode(String mode) {
		this.mode = mode;
	}
	public void setwMode(String wMode) {
		this.wMode = wMode;
	}
	public void setpIspnChkMgntSeq(String pIspnChkMgntSeq) {
		this.pIspnChkMgntSeq = pIspnChkMgntSeq;
	}
	public void setpIspnChkSeq(String pIspnChkSeq) {
		this.pIspnChkSeq = pIspnChkSeq;
	}
	public void setpDtlcnsttypecd(String pDtlcnsttypecd) {
		this.pDtlcnsttypecd = pDtlcnsttypecd;
	}
	public void setpSiteNo(String pSiteNo) {
		this.pSiteNo = pSiteNo;
	}
	public void setIspnChkItemSeq(String ispnChkItemSeq) {
		this.ispnChkItemSeq = ispnChkItemSeq;
	}
	public void setIspnItem(String ispnItem) {
		this.ispnItem = ispnItem;
	}
	public void setIspnStd(String ispnStd) {
		this.ispnStd = ispnStd;
	}
	public void setCntrChk(String cntrChk) {
		this.cntrChk = cntrChk;
	}
	public void setSiteChkSeq(String siteChkSeq) {
		this.siteChkSeq = siteChkSeq;
	}
}