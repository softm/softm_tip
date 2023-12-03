package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * PicMngItemListDTO
 * 사진관리사진정보조회
 * @author softm 
 */
public class PicMngItemListDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
public String pCnstrphtSeq; // 공사사진일련번호할]
public String fileSeq     ; // 파일일련번호
public String fileName    ; // 파일명
public String fileUrl     ; // 파일다운로드

	public PicMngItemListDTO() {
		super();
	}
	public String getMode() {
		return mode;
	}
	public String getpCnstrphtSeq() {
		return pCnstrphtSeq;
	}
	public String getFileSeq() {
		return fileSeq;
	}
	public String getFileName() {
		return fileName;
	}
	public String getFileUrl() {
		return fileUrl;
	}
	public void setMode(String mode) {
		this.mode = mode;
	}
	public void setpCnstrphtSeq(String pCnstrphtSeq) {
		this.pCnstrphtSeq = pCnstrphtSeq;
	}
	public void setFileSeq(String fileSeq) {
		this.fileSeq = fileSeq;
	}
	public void setFileName(String fileName) {
		this.fileName = fileName;
	}
	public void setFileUrl(String fileUrl) {
		this.fileUrl = fileUrl;
	}


	
}