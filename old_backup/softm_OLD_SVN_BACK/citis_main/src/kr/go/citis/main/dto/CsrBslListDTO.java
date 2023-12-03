package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * CsrBslListDTO
 * 공사기준조회
 * @author softm 
 */
public class CsrBslListDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
	public String pCnstrStdCls; // 공사기준구분
	public String pCnstrStdNm ; // 공사기준명
	public String cnstrStdSeq ; // 공사기준번호
	public String cnstrStdNm  ; // 공사기준명
	public String fileName    ; // 파일명
	public String fileUrl     ; // 파일다운로드
	
	public String getMode() {
		return mode;
	}
	public String getpCnstrStdCls() {
		return pCnstrStdCls;
	}
	public String getpCnstrStdNm() {
		return pCnstrStdNm;
	}
	public String getCnstrStdSeq() {
		return cnstrStdSeq;
	}
	public String getCnstrStdNm() {
		return cnstrStdNm;
	}
	public String getFileName() {
		return fileName;
	}
	public void setMode(String mode) {
		this.mode = mode;
	}
	public void setpCnstrStdCls(String pCnstrStdCls) {
		this.pCnstrStdCls = pCnstrStdCls;
	}
	public void setpCnstrStdNm(String pCnstrStdNm) {
		this.pCnstrStdNm = pCnstrStdNm;
	}
	public void setCnstrStdSeq(String cnstrStdSeq) {
		this.cnstrStdSeq = cnstrStdSeq;
	}
	public void setCnstrStdNm(String cnstrStdNm) {
		this.cnstrStdNm = cnstrStdNm;
	}
	public void setFileName(String fileName) {
		this.fileName = fileName;
	}
	public String getFileUrl() {
		return fileUrl;
	}
	public void setFileUrl(String fileUrl) {
		this.fileUrl = fileUrl;
	}

	
	
}