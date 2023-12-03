package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * CarRprtFileItemListDTO
 * 시정조치 보고서 파일 조회
 * @author softm 
 */
public class CarRprtFileItemListDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
	public String pRprtSeq	; // 보고서 일련번호                               
	public String pFileAsrt; // 파일구분[조치요구:RQSTS,조치결과:RSLT]          
	public String fileName ; // 파일명                                   
	public String fileSize ; // 파일크기                                
	public String fileUrl; // 파일다운로드                                
	public String atchSeq; // No
	
	
	public String getMode() {
		return mode;
	}
	public String getpRprtSeq() {
		return pRprtSeq;
	}
	public String getpFileAsrt() {
		return pFileAsrt;
	}
	public String getFileName() {
		return fileName;
	}
	public String getFileSize() {
		return fileSize;
	}
	public void setMode(String mode) {
		this.mode = mode;
	}
	public void setpRprtSeq(String pRprtSeq) {
		this.pRprtSeq = pRprtSeq;
	}
	public void setpFileAsrt(String pFileAsrt) {
		this.pFileAsrt = pFileAsrt;
	}
	public void setFileName(String fileName) {
		this.fileName = fileName;
	}
	public void setFileSize(String fileSize) {
		this.fileSize = fileSize;
	}
	public String getFileUrl() {
		return fileUrl;
	}
	public void setFileUrl(String fileUrl) {
		this.fileUrl = fileUrl;
	}
	public String getAtchSeq() {
		return atchSeq;
	}
	public void setAtchSeq(String atchSeq) {
		this.atchSeq = atchSeq;
	}
	
}