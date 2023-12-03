package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * PicMngItemDeleteDTO
 * 사진관리삭제
 * @author softm 
 */
public class PicMngItemDeleteDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
public String pCnstrphtSeq ; // 공사사진일련번호
	public PicMngItemDeleteDTO() {
		super();
	}
	public String getMode() {
		return mode;
	}
	public String getpCnstrphtSeq() {
		return pCnstrphtSeq;
	}
	public void setMode(String mode) {
		this.mode = mode;
	}
	public void setpCnstrphtSeq(String pCnstrphtSeq) {
		this.pCnstrphtSeq = pCnstrphtSeq;
	}

}