package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * TestRsltWrtSaveDTO
 * 검측 결과 등록 저장
 * @author softm 
 */
public class TestRsltWrtSaveDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
public String ispnChkMgntSeq; // 검측마스터번호
public String ispnChkSeq; // 검측체크번호
public String ispnChkItemSeq; // 검측체크항목번호
public String text; // 검사항목
public String dscrtn; // 검사기준
public String cntrChk; // 시공사점검
public String ispnRslt; // 검사결과
public String msrDtls; // 조치사항
	public TestRsltWrtSaveDTO() {
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
	public String getIspnChkItemSeq() {
		return ispnChkItemSeq;
	}
	public void setIspnChkItemSeq(String ispnChkItemSeq) {
		this.ispnChkItemSeq = ispnChkItemSeq;
	}
	public String getText() {
		return text;
	}
	public void setText(String text) {
		this.text = text;
	}
	public String getDscrtn() {
		return dscrtn;
	}
	public void setDscrtn(String dscrtn) {
		this.dscrtn = dscrtn;
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