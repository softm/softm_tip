package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * TestRsltWrtListDTO
 * 검측 결과 등록 조회
 * @author softm 
 */
public class TestRsltWrtListDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
public String pIspnChkMgntSeq; // 검측마스터번호
public String pIspnChkSeq; // 검측체크번호
public String ispnChkItemSeq; // 검측체크항목번호
public String ispnItem; // 검사항목
public String ispnStd; // 검사기준
public String cntrChk; // 시공사점검
public String ispnRslt; // 검사결과
public String msrDtls; // 조치사항
	public TestRsltWrtListDTO() {
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
	public String getIspnChkItemSeq() {
		return ispnChkItemSeq;
	}
	public void setIspnChkItemSeq(String ispnChkItemSeq) {
		this.ispnChkItemSeq = ispnChkItemSeq;
	}

	public String getIspnItem() {
		return ispnItem;
	}
	public String getIspnStd() {
		return ispnStd;
	}
	public void setIspnItem(String ispnItem) {
		this.ispnItem = ispnItem;
	}
	public void setIspnStd(String ispnStd) {
		this.ispnStd = ispnStd;
	}
	public String getCntrChk() {
		return cntrChk;
	}
	public void setCntrChk(String cntrChk) {
		this.cntrChk = cntrChk;
	}
	
	public String getIspnRslt() {
		return ispnRslt;
	}
	public void setIspnRslt(String ispnRslt) {
		this.ispnRslt = ispnRslt;
	}
	public String getMsrDtls() {
		return msrDtls;
	}
	public void setMsrDtls(String msrDtls) {
		this.msrDtls = msrDtls;
	}
	
	
}