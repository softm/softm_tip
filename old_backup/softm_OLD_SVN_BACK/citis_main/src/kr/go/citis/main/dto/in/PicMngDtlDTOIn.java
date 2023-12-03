package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.PicMngDtlDTO;

/**
 * PicMngDtlDTOIn
 * 사진관리상세조회
 * @author softm 
 */
public class PicMngDtlDTOIn extends BaseDTOIn {
	private PicMngDtlDTO data; 
	
	public PicMngDtlDTOIn() {
		super();
	}

	public PicMngDtlDTO getData() {
		return data;
	}

	public void setData(PicMngDtlDTO data) {
		this.data = data;
	}
	
	
}