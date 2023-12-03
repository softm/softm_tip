package kr.go.citis.main.dto.out;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.PicMngDtlDTO;

/**
 * PicMngDtlDTOOut
 * 사진관리상세조회
 * @author softm 
 */
public class PicMngDtlDTOOut extends BaseDTO {
	private PicMngDtlDTO data; 
	public PicMngDtlDTOOut() {
		super();
	}
	public PicMngDtlDTO getData() {
		return data;
	}
	public void setData(PicMngDtlDTO data) {
		this.data = data;
	}
	
}