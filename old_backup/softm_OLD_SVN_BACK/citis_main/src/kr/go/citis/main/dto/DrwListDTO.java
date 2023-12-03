package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * DrwListDTO
 * 도면조회
 * @author softm 
 */
public class DrwListDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
	public String pPlnClsSeq ; // 도면분류구분
	public String pPlnNm     ; // 도면명
	public String plnSeq     ; // 도면번호
	public String plnNm      ; // 도면명
	public String sysRegDate ; // 등록일
	public String plnFileName; // 파일명
	public String fileUrl    ; // 파일다운로드	
	public String getMode() {
		return mode;
	}
	public String getpPlnClsSeq() {
		return pPlnClsSeq;
	}
	public String getpPlnNm() {
		return pPlnNm;
	}
	public String getPlnSeq() {
		return plnSeq;
	}
	public String getPlnNm() {
		return plnNm;
	}
	public String getSysRegDate() {
		return sysRegDate;
	}
	public String getPlnFileName() {
		return plnFileName;
	}
	public void setMode(String mode) {
		this.mode = mode;
	}
	public void setpPlnClsSeq(String pPlnClsSeq) {
		this.pPlnClsSeq = pPlnClsSeq;
	}
	public void setpPlnNm(String pPlnNm) {
		this.pPlnNm = pPlnNm;
	}
	public void setPlnSeq(String plnSeq) {
		this.plnSeq = plnSeq;
	}
	public void setPlnNm(String plnNm) {
		this.plnNm = plnNm;
	}
	public void setSysRegDate(String sysRegDate) {
		this.sysRegDate = sysRegDate;
	}
	public void setPlnFileName(String plnFileName) {
		this.plnFileName = plnFileName;
	}
	public String getFileUrl() {
		return fileUrl;
	}
	public void setFileUrl(String fileUrl) {
		this.fileUrl = fileUrl;
	}
	
}