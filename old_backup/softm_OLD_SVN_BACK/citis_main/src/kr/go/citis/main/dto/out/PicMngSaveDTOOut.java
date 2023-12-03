package kr.go.citis.main.dto.out;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.PicMngSaveDTO;

/**
 * PicMngSaveDTOOut
 * 사진관리저장
 * @author softm 
 */
public class PicMngSaveDTOOut extends BaseDTO {
	private PicMngSaveDTO data; 
	public PicMngSaveDTOOut() {
		super();
	}
	public PicMngSaveDTO getData() {
		return data;
	}
	public void setData(PicMngSaveDTO data) {
		this.data = data;
	}
	
}